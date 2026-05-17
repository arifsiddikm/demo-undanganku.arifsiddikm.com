@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page_title', 'Dashboard Admin')

@section('content')
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(170px,1fr));gap:1rem;margin-bottom:1.5rem;">
    <div class="stat-card">
        <div class="stat-icon" style="background:#FDF2F8;">👥</div>
        <div><div class="stat-num">{{ number_format($stats['total_users']) }}</div><div class="stat-label">Total Pengguna</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#EFF6FF;">📦</div>
        <div><div class="stat-num">{{ number_format($stats['total_orders']) }}</div><div class="stat-label">Total Pesanan</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#F0FDF4;">✅</div>
        <div><div class="stat-num">{{ number_format($stats['paid_orders']) }}</div><div class="stat-label">Pesanan Lunas</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#FFFBEB;">⏳</div>
        <div><div class="stat-num">{{ number_format($stats['pending_orders']) }}</div><div class="stat-label">Perlu Verifikasi</div></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#F0FDF4;">💰</div>
        <div><div class="stat-num" style="font-size:1.1rem;">Rp {{ number_format($stats['total_revenue'],0,',','.') }}</div><div class="stat-label">Total Pendapatan</div></div>
    </div>
</div>

<div class="card">
    <div style="padding:1rem 1.25rem;border-bottom:1px solid #F3F4F6;display:flex;align-items:center;justify-content:space-between;">
        <div style="font-weight:600;font-size:0.9rem;">Pesanan Terbaru</div>
        <a href="{{ route('admin.orders') }}" style="font-size:0.8rem;color:#F472B6;text-decoration:none;">Lihat Semua →</a>
    </div>
    <div style="overflow-x:auto;">
        <table class="table-auto">
            <thead><tr>
                <th>No. Pesanan</th>
                <th>Pembeli</th>
                <th>Paket</th>
                <th>Total</th>
                <th>Metode</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr></thead>
            <tbody>
            @forelse($recentOrders as $order)
            <tr>
                <td style="font-weight:600;font-family:monospace;font-size:0.78rem;">{{ $order->order_number }}</td>
                <td>
                    <div style="font-weight:500;font-size:0.82rem;">{{ $order->user->name }}</div>
                    <div style="font-size:0.72rem;color:#9CA3AF;">{{ $order->user->email }}</div>
                </td>
                <td><span style="font-size:0.8rem;">{{ $order->package->name ?? '-' }}</span></td>
                <td style="font-weight:600;">Rp {{ number_format($order->amount,0,',','.') }}</td>
                <td>
                    <span style="font-size:0.75rem;color:#6B7280;">
                        {{ $order->payment_method === 'midtrans' ? '🔗 Gateway' : '🏦 Transfer' }}
                    </span>
                </td>
                <td>
                    <span class="badge {{ $order->payment_status==='paid'?'badge-success':($order->payment_status==='pending'?'badge-warning':'badge-danger') }}">
                        {{ $order->payment_status==='paid'?'Lunas':($order->payment_status==='pending'?'Pending':'Gagal') }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn-outline btn-sm">Detail</a>
                    @if($order->payment_status === 'pending')
                    <form id="conf-{{ $order->id }}" action="{{ route('admin.orders.confirm', $order->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="button" onclick="confirmAction('Konfirmasi pembayaran #{{ $order->order_number }}?','conf-{{ $order->id }}')" class="btn-success btn-sm" style="margin-left:4px;">Konfirmasi</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;padding:2rem;color:#9CA3AF;">Belum ada pesanan</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
