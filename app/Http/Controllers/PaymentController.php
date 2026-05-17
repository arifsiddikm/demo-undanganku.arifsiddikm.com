<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Package;
use App\Models\BankAccount;
use App\Models\Invitation;
use App\Mail\OrderCreatedAdmin;
use App\Mail\OrderConfirmedUser;
use App\Mail\TransferProofAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * Show checkout page
     */
    public function checkout($slug)
    {
        $package = Package::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $bankAccounts = BankAccount::where('is_active', true)->get();
        $invitation = null;
        return view('dashboard.checkout', compact('package', 'bankAccounts', 'invitation'));
    }

    public function checkoutForInvitation($slug, $invitationId)
    {
        $package = Package::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $bankAccounts = BankAccount::where('is_active', true)->get();
        $invitation = Invitation::where('user_id', Auth::id())->findOrFail($invitationId);
        return view('dashboard.checkout', compact('package', 'bankAccounts', 'invitation'));
    }

    /**
     * Get Snap Token from Riplabs API
     */
    public function getSnapToken(Request $request)
    {
        $request->validate(['package_id' => 'required|exists:packages,id']);

        $package = Package::findOrFail($request->package_id);
        $user    = Auth::user();

        // Generate order number
        $orderNumber = env('MIDTRANS_ORDER_PREFIX', 'UNDANGANKU') . str_pad(Order::count() + 1, 8, '0', STR_PAD_LEFT);

        // Create pending order
        $order = Order::create([
            'order_number'   => $orderNumber,
            'user_id'        => $user->id,
            'package_id'     => $package->id,
            'amount'         => $package->price,
            'payment_method' => 'midtrans',
            'payment_status' => 'pending',
        ]);

        // Link invitation if provided
        if ($request->invitation_id) {
            $inv = Invitation::where('user_id', $user->id)->find($request->invitation_id);
            if ($inv) $inv->update(['order_id' => $order->id]);
        }

        // Call Riplabs Snap Token API
        try {
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL            => env('RIPLABS_SNAPTOKEN_URL'),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING       => '',
                CURLOPT_MAXREDIRS      => 10,
                CURLOPT_TIMEOUT        => 30,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST  => 'POST',
                CURLOPT_POSTFIELDS     => [
                    'key'         => env('RIPLABS_KEY'),
                    'order_id'    => $orderNumber,
                    'total_harga' => (int) $package->price,
                    'nama'        => $user->name,
                    'email'       => $user->email,
                    'notelp'      => $user->phone ?? '0',
                    'namaproduk'  => 'Paket Undangan ' . $package->name,
                ],
                CURLOPT_HTTPHEADER => ['Content-Type: multipart/form-data'],
            ]);
            $response = curl_exec($ch);
            $curlErr  = curl_error($ch);
            curl_close($ch);

            if ($curlErr) throw new \Exception('cURL error: ' . $curlErr);

            $result = json_decode($response, true);

            if (!$result || !$result['status'] || empty($result['snaptoken'])) {
                throw new \Exception($result['message'] ?? 'Gagal mendapatkan snap token');
            }

            // Save snap token
            $order->update(['snap_token' => $result['snaptoken']]);

            // Notify admin
            try { Mail::to(env('ADMIN_EMAIL'))->send(new OrderCreatedAdmin($order)); } catch (\Throwable $e) { Log::error('Mail admin: ' . $e->getMessage()); }

            return response()->json([
                'success'    => true,
                'snap_token' => $result['snaptoken'],
                'order_id'   => $orderNumber,
            ]);

        } catch (\Throwable $e) {
            Log::error('Snaptoken error: ' . $e->getMessage());
            $order->delete();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Midtrans notification callback (from Riplabs relay)
     */
    public function notification(Request $request)
    {
        try {
            $callbackKey = $request->header('X-Callback-Key') ?? $request->input('callback_key', '');
            // Validate callback key
            if ($callbackKey && $callbackKey !== env('MIDTRANS_CALLBACK_KEY')) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            $transactionStatus = $request->input('transaction_status');
            $paymentType       = $request->input('payment_type');
            $orderId           = $request->input('order_id');

            if (!$orderId || !$transactionStatus) {
                return response()->json(['message' => 'Invalid payload'], 422);
            }

            $order = Order::where('order_number', $orderId)->first();
            if (!$order) return response()->json(['message' => 'Order not found'], 404);

            // Update status
            if (in_array($transactionStatus, ['capture', 'settlement'])) {
                $order->update([
                    'payment_status' => 'paid',
                    'payment_type'   => $paymentType,
                    'transaction_id' => $request->input('transaction_id'),
                    'paid_at'        => now(),
                ]);
                $this->activateInvitation($order);
                // Notify user
                try { Mail::to($order->user->email)->send(new OrderConfirmedUser($order)); } catch (\Throwable $e) { Log::error('Mail user: ' . $e->getMessage()); }
                // Notify admin
                try { Mail::to(env('ADMIN_EMAIL'))->send(new \App\Mail\OrderPaidAdmin($order)); } catch (\Throwable $e) { }
            } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                $order->update(['payment_status' => 'failed']);
            } elseif ($transactionStatus === 'pending') {
                $order->update(['payment_status' => 'pending', 'payment_type' => $paymentType]);
            }

            return response()->json(['message' => 'OK']);

        } catch (\Throwable $e) {
            Log::error('Payment notification error: ' . $e->getMessage());
            return response()->json(['message' => 'Error'], 500);
        }
    }

    /**
     * Payment finish redirect
     */
    public function finishRedirect(Request $request)
    {
        $orderId           = $request->input('order_id');
        $transactionStatus = $request->input('transaction_status');

        if (in_array($transactionStatus, ['capture', 'settlement'])) {
            return redirect()->route('dashboard')->with('success', 'Pembayaran berhasil! Undangan kamu sudah aktif. 🎉');
        } elseif ($transactionStatus === 'pending') {
            return redirect()->route('orders.index')->with('info', 'Menunggu konfirmasi pembayaran.');
        }
        return redirect()->route('orders.index')->with('error', 'Pembayaran gagal atau dibatalkan.');
    }

    /**
     * Store manual bank transfer order
     */
    public function storeTransfer(Request $request)
    {
        $request->validate([
            'package_id'      => 'required|exists:packages,id',
            'bank_account_id' => 'required|exists:bank_accounts,id',
            'transfer_proof'  => 'required|image|max:5120',
            'notes'           => 'nullable|string|max:500',
        ]);

        $package  = Package::findOrFail($request->package_id);
        $user     = Auth::user();

        // Upload proof
        $proofPath = $request->file('transfer_proof')->store('transfer-proofs', 'public');

        // Create order
        $orderNumber = env('MIDTRANS_ORDER_PREFIX', 'UNDANGANKU') . str_pad(Order::count() + 1, 8, '0', STR_PAD_LEFT);
        $order = Order::create([
            'order_number'    => $orderNumber,
            'user_id'         => $user->id,
            'package_id'      => $package->id,
            'amount'          => $package->price,
            'payment_method'  => 'bank_transfer',
            'payment_status'  => 'pending',
            'bank_account_id' => $request->bank_account_id,
            'transfer_proof'  => $proofPath,
            'notes'           => $request->notes,
        ]);

        // Link invitation if provided
        if ($request->invitation_id) {
            $inv = Invitation::where('user_id', $user->id)->find($request->invitation_id);
            if ($inv) $inv->update(['order_id' => $order->id]);
        }

        // Notify admin
        try { Mail::to(env('ADMIN_EMAIL'))->send(new TransferProofAdmin($order)); } catch (\Throwable $e) { Log::error('Transfer proof mail: ' . $e->getMessage()); }
        // Notify user
        try { Mail::to($user->email)->send(new \App\Mail\TransferProofUser($order)); } catch (\Throwable $e) { }

        return redirect()->route('orders.index')
            ->with('success', 'Bukti transfer berhasil dikirim! Admin akan memverifikasi dalam 1x24 jam. 🎉');
    }

    /**
     * Activate invitation after payment confirmed
     */
    private function activateInvitation(Order $order): void
    {
        // Check if user already has an invitation linked to this order
        $invitation = Invitation::where('order_id', $order->id)->first();
        if ($invitation) {
            $invitation->update(['status' => 'active']);
        }
        // Also activate most recent draft invitation of this user (if no order-linked one)
        else {
            $draft = Invitation::where('user_id', $order->user_id)
                ->where('status', 'draft')
                ->latest()
                ->first();
            if ($draft) {
                $draft->update(['status' => 'active', 'order_id' => $order->id]);
            }
        }
    }
}
