<?php

namespace App\Http\Controllers;

use App\Models\UserTestimonial;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'order_id'        => 'required|exists:orders,id',
            'content'         => 'required|string|min:10|max:1000',
            'rating'          => 'required|integer|min:1|max:5',
            'allow_portfolio' => 'nullable|boolean',
        ]);

        // Ensure order belongs to user and is paid
        $order = Order::where('id', $request->order_id)
            ->where('user_id', Auth::id())
            ->where('payment_status', 'paid')
            ->firstOrFail();

        // One testimonial per order
        $existing = UserTestimonial::where('order_id', $order->id)->first();
        if ($existing) {
            return response()->json(['success' => false, 'message' => 'Kamu sudah pernah memberikan testimoni untuk pesanan ini.'], 422);
        }

        UserTestimonial::create([
            'order_id'        => $order->id,
            'user_id'         => Auth::id(),
            'content'         => $request->content,
            'rating'          => $request->rating,
            'allow_portfolio' => $request->boolean('allow_portfolio', false),
            'status'          => 'pending',
        ]);

        return response()->json(['success' => true, 'message' => 'Terima kasih! Testimoni kamu akan ditinjau admin. 🙏']);
    }
}
