@extends('layouts.admin')
@section('title', 'Detail Pesanan')
@section('page_title', 'Detail Pesanan #' . $order->order_number)

@section('content')
<div style="display:grid;grid-template-columns:1fr 340px;gap:1.25rem;">

    {{-- Left --}}
    <div>
        <div class="card" style="margin-bottom:1.25rem;">
            <div style="padding:1rem 1.25rem;border-bottom:1px solid #F3F4F6;display:flex;align-items:center;justify-content:space-between;">
                <div style="font-weight:600;">Info Pesanan</div>
                <span class="badge {{ $order->payment_status==='paid'?'badge-success':($order->payment_status==='pending'?'badge-warning':'badge-danger') }}" style="font-size:0.75rem;">
                    {{ $order->payment_status==='paid'?'✅ Lunas':($order->payment_status==='pending'?'⏳ Pending':'❌ Gagal') }}
                </span>
            </div>
            <div class="card-body">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                    <div>
                        <div style="font-size:0.72rem;color:#9CA3AF;margin-bottom:0.2rem;">No. Pesanan</div>
                        <div style="font-weight:700;font-family:monospace;">{{ $order->order_number }}</div>
                    </div>
                    <div>
                        <div style="font-size:0.72rem;color:#9CA3AF;margin-bottom:0.2rem;">Tanggal Pesanan</div>
                        <div style="font-weight:500;">{{ $order->created_at->format('d M Y H:i') }} WIB</div>
                    </div>
                    <div>
                        <div style="font-size:0.72rem;color:#9CA3AF;margin-bottom:0.2rem;">Metode Pembayaran</div>
                        <div style="font-weight:500;">{{ $order->payment_method === 'midtrans' ? '🔗 Payment Gateway' : '🏦 Transfer Manual' }}</div>
                    </div>
                    <div>
                        <div style="font-size:0.72rem;color:#9CA3AF;margin-bottom:0.2rem;">Total</div>
                        <div style="font-weight:700;font-size:1.1rem;color:#F472B6;">Rp {{ number_format($order->amount,0,',','.') }}</div>
                    </div>
                    @if($order->transaction_id)
                    <div>
                        <div style="font-size:0.72rem;color:#9CA3AF;margin-bottom:0.2rem;">Transaction ID</div>
                        <div style="font-family:monospace;font-size:0.8rem;">{{ $order->transaction_id }}</div>
                    </div>
                    @endif
                    @if($order->paid_at)
                    <div>
                        <div style="font-size:0.72rem;color:#9CA3AF;margin-bottom:0.2rem;">Waktu Bayar</div>
                        <div style="font-weight:500;">{{ $order->paid_at->format('d M Y H:i') }} WIB</div>
                    </div>
                    @endif
                </div>

                @if($order->notes)
                <div style="margin-top:1rem;padding:0.75rem;background:#F9FAFB;border-radius:8px;">
                    <div style="font-size:0.72rem;color:#9CA3AF;margin-bottom:0.2rem;">Catatan</div>
                    <div style="font-size:0.85rem;">{{ $order->notes }}</div>
                </div>
                @endif
            </div>
        </div>

        {{-- Transfer Proof --}}
        @if($order->transfer_proof)
        <div class="card" style="margin-bottom:1.25rem;">
            <div style="padding:1rem 1.25rem;border-bottom:1px solid #F3F4F6;font-weight:600;">Bukti Transfer</div>
            <div class="card-body">
                <img src="{{ asset('storage/' . $order->transfer_proof) }}" alt="Bukti Transfer" style="max-width:100%;max-height:400px;border-radius:10px;object-fit:contain;cursor:pointer;" onclick="window.open(this.src,'_blank')">
                <div style="font-size:0.75rem;color:#9CA3AF;margin-top:0.5rem;">Klik gambar untuk membuka di tab baru</div>

                @if($order->bankAccount)
                <div style="margin-top:1rem;padding:0.85rem;background:#F9FAFB;border-radius:8px;">
                    <div style="font-size:0.75rem;font-weight:600;color:#6B7280;margin-bottom:0.35rem;">Tujuan Transfer:</div>
                    <div style="font-weight:600;">{{ $order->bankAccount->bank_name }}</div>
                    <div style="font-size:0.82rem;color:#6B7280;">{{ $order->bankAccount->account_number }} · a.n. {{ $order->bankAccount->account_name }}</div>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>

    {{-- Right --}}
    <div>
        {{-- Buyer Info --}}
        <div class="card" style="margin-bottom:1.25rem;">
            <div style="padding:1rem 1.25rem;border-bottom:1px solid #F3F4F6;font-weight:600;">Info Pembeli</div>
            <div class="card-body">
                <div style="display:flex;align-items:center;gap:0.75rem;margin-bottom:1rem;">
                    <div style="width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg,#F472B6,#93C5FD);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:1rem;flex-shrink:0;">
                        {{ strtoupper(substr($order->user->name,0,1)) }}
                    </div>
                    <div>
                        <div style="font-weight:600;">{{ $order->user->name }}</div>
                        <div style="font-size:0.78rem;color:#9CA3AF;">{{ $order->user->email }}</div>
                    </div>
                </div>
                @if($order->user->phone)
                <div style="font-size:0.82rem;color:#6B7280;">📱 {{ $order->user->phone }}</div>
                @endif
            </div>
        </div>

        {{-- Package Info --}}
        <div class="card" style="margin-bottom:1.25rem;">
            <div style="padding:1rem 1.25rem;border-bottom:1px solid #F3F4F6;font-weight:600;">Paket Dipesan</div>
            <div class="card-body">
                <div style="font-size:1rem;font-weight:700;margin-bottom:0.25rem;">Paket {{ $order->package->name ?? '-' }}</div>
                <div style="font-size:0.8rem;color:#6B7280;margin-bottom:0.75rem;">{{ $order->package->description ?? '' }}</div>
                <div style="font-size:1.2rem;font-weight:700;color:#F472B6;">Rp {{ number_format($order->amount,0,',','.') }}</div>
            </div>
        </div>

        {{-- Actions --}}
        @if($order->payment_status === 'pending')
        <div class="card">
            <div class="card-body">
                <div style="font-weight:600;margin-bottom:0.75rem;">Aksi</div>
                <form id="conf-form" action="{{ route('admin.orders.confirm', $order->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group" style="margin-bottom:0.75rem">
                        <label class="form-label" style="font-size:0.75rem">Upload Bukti Transfer (opsional)</label>
                        <input type="file" name="transfer_proof" accept="image/*" class="form-input" style="font-size:0.78rem;padding:0.4rem">
                    </div>
                    <div class="form-group" style="margin-bottom:0.75rem">
                        <label class="form-label" style="font-size:0.75rem">Catatan Admin (opsional)</label>
                        <input type="text" name="notes" class="form-input" placeholder="Catatan konfirmasi..." style="font-size:0.78rem">
                    </div>
                    <button type="button" onclick="confirmAction('Konfirmasi pembayaran pesanan ini?','conf-form')" class="btn-primary" style="width:100%;padding:0.75rem;margin-bottom:0.5rem;">
                        ✅ Konfirmasi Pembayaran
                    </button>
                </form>
                <div style="font-size:0.75rem;color:#9CA3AF;text-align:center;">Undangan user akan otomatis diaktifkan setelah konfirmasi</div>
            </div>
        </div>
        @elseif($order->payment_status === 'paid')
        <div style="background:#F0FDF4;border:1px solid #BBF7D0;border-radius:12px;padding:1rem;text-align:center;">
            <div style="font-size:1.5rem;margin-bottom:0.4rem;">✅</div>
            <div style="font-weight:600;color:#15803D;">Pembayaran Dikonfirmasi</div>
            <div style="font-size:0.78rem;color:#16A34A;margin-top:0.2rem;">{{ $order->paid_at?->format('d M Y H:i') }} WIB</div>
        </div>
        @endif
    </div>
</div>

<div style="margin-top:1rem;">
    <a href="{{ route('admin.orders') }}" class="btn-outline">← Kembali ke Daftar Pesanan</a>
</div>
@endsection
