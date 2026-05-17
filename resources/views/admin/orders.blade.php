@extends('layouts.admin')
@section('title', 'Pesanan')
@section('page_title', 'Manajemen Pesanan')

@section('content')
{{-- Filters --}}
<div class="card" style="margin-bottom:1rem;padding:1rem 1.25rem;">
    <form method="GET" style="display:flex;gap:0.75rem;flex-wrap:wrap;align-items:flex-end;">
        <div style="flex:1;min-width:180px;">
            <label class="form-label">Cari Pesanan</label>
            <input type="text" name="search" class="form-input" placeholder="No. pesanan..." value="{{ request('search') }}">
        </div>
        <div style="min-width:140px;">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status')==='pending'?'selected':'' }}>Pending</option>
                <option value="paid" {{ request('status')==='paid'?'selected':'' }}>Lunas</option>
                <option value="failed" {{ request('status')==='failed'?'selected':'' }}>Gagal</option>
            </select>
        </div>
        <div style="min-width:140px;">
            <label class="form-label">Metode</label>
            <select name="method" class="form-select">
                <option value="">Semua Metode</option>
                <option value="midtrans" {{ request('method')==='midtrans'?'selected':'' }}>Gateway</option>
                <option value="bank_transfer" {{ request('method')==='bank_transfer'?'selected':'' }}>Transfer Manual</option>
            </select>
        </div>
        <button type="submit" class="btn-primary">Filter</button>
        <a href="{{ route('admin.orders') }}" class="btn-outline">Reset</a>
    </form>
</div>

<div class="card">
    <div style="overflow-x:auto;">
        <table class="table-auto">
            <thead><tr>
                <th>No. Pesanan</th>
                <th>Pembeli</th>
                <th>Paket</th>
                <th>Total</th>
                <th>Metode</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr></thead>
            <tbody>
            @forelse($orders as $order)
            <tr>
                <td style="font-weight:600;font-family:monospace;font-size:0.78rem;">{{ $order->order_number }}</td>
                <td>
                    <div style="font-weight:500;font-size:0.82rem;">{{ $order->user->name }}</div>
                    <div style="font-size:0.72rem;color:#9CA3AF;">{{ $order->user->email }}</div>
                </td>
                <td style="font-size:0.82rem;">{{ $order->package->name ?? '-' }}</td>
                <td style="font-weight:600;">Rp {{ number_format($order->amount,0,',','.') }}</td>
                <td>
                    @if($order->payment_method === 'midtrans')
                        <span class="badge badge-info">🔗 Gateway</span>
                    @else
                        <span class="badge badge-gray">🏦 Transfer</span>
                    @endif
                </td>
                <td style="font-size:0.78rem;color:#6B7280;">{{ $order->created_at->format('d M Y') }}</td>
                <td>
                    <span class="badge {{ $order->payment_status==='paid'?'badge-success':($order->payment_status==='pending'?'badge-warning':'badge-danger') }}">
                        {{ $order->payment_status==='paid'?'Lunas':($order->payment_status==='pending'?'Pending':'Gagal') }}
                    </span>
                </td>
                <td style="white-space:nowrap;">
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn-outline btn-sm">Detail</a>
                    @if($order->payment_status === 'pending')
                    <form id="conf-{{ $order->id }}" action="{{ route('admin.orders.confirm', $order->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="button" onclick="confirmAction('Konfirmasi pesanan #{{ $order->order_number }}?','conf-{{ $order->id }}')" class="btn-success btn-sm" style="margin-left:4px;">✓ Konfirmasi</button>
                    </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;padding:2.5rem;color:#9CA3AF;">Tidak ada pesanan ditemukan</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())
    <div style="padding:1rem 1.25rem;border-top:1px solid #F3F4F6;">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
