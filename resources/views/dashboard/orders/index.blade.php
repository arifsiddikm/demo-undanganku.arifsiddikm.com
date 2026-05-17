@extends('layouts.dashboard')
@section('title', 'Pesanan Saya')
@section('page_title', 'Pesanan Saya')

@section('content')
<div class="dash-card">
    <div style="font-weight:600;font-size:0.95rem;margin-bottom:1.25rem;">Riwayat Pesanan</div>

    @forelse($orders as $order)
    <div style="border:1px solid #F3F4F6;border-radius:12px;padding:1rem;margin-bottom:0.85rem;transition:border-color 0.2s;" onmouseover="this.style.borderColor='rgba(244,114,182,0.3)'" onmouseout="this.style.borderColor='#F3F4F6'">
        <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
            <div>
                <div style="font-weight:700;font-family:monospace;font-size:0.85rem;margin-bottom:0.2rem;">{{ $order->order_number }}</div>
                <div style="font-size:0.82rem;font-weight:500;">Paket {{ $order->package->name ?? '-' }}</div>
                <div style="font-size:0.75rem;color:var(--color-muted);margin-top:0.15rem;">
                    {{ $order->payment_method === 'midtrans' ? '🔗 Payment Gateway' : '🏦 Transfer Manual' }}
                    · {{ $order->created_at->format('d M Y H:i') }}
                </div>
            </div>
            <div style="text-align:right;">
                <div style="font-weight:700;color:var(--color-pink);margin-bottom:0.35rem;">Rp {{ number_format($order->amount,0,',','.') }}</div>
                <span class="badge {{ $order->payment_status==='paid'?'badge-success':($order->payment_status==='pending'?'badge-warning':'badge-danger') }}">
                    {{ $order->payment_status==='paid'?'✅ Lunas':($order->payment_status==='pending'?'⏳ Menunggu':'❌ Gagal') }}
                </span>
            </div>
        </div>
        @if($order->payment_status === 'pending' && $order->payment_method === 'bank_transfer')
        <div style="margin-top:0.75rem;padding:0.65rem;background:#FFFBEB;border-radius:8px;font-size:0.78rem;color:#92400E;">
            ⚠️ Bukti transfer sedang diverifikasi admin. Proses 1x24 jam.
        </div>
        @endif
    </div>
    @empty
    <div style="text-align:center;padding:3rem;">
        <div style="font-size:3rem;margin-bottom:1rem;">📦</div>
        <div style="font-weight:600;margin-bottom:0.4rem;">Belum Ada Pesanan</div>
        <p style="font-size:0.85rem;color:var(--color-muted);margin-bottom:1.25rem;">Beli paket undangan untuk mengaktifkan undangan digital kamu.</p>
        <a href="{{ route('home') }}#harga" class="btn-primary">Lihat Paket Harga</a>
    </div>
    @endforelse

    @if($orders->hasPages())
    <div style="margin-top:1rem;">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
