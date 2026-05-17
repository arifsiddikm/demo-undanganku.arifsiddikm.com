@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
<div class="page-header">
    <div>
        <div class="page-title">Selamat datang, {{ auth()->user()->name }} 👋</div>
        <p style="font-size:0.8rem;color:var(--color-muted);margin-top:0.2rem;">Kelola semua undangan digitalmu dari sini</p>
    </div>
    <a href="{{ route('invitations.create') }}" class="btn-primary">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Buat Undangan Baru
    </a>
</div>

{{-- Stats --}}
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:1rem;margin-bottom:1.75rem;">
    <div class="stat-card">
        <div class="stat-icon" style="background:#FDF2F8;">💌</div>
        <div>
            <div class="stat-num">{{ $stats['total_invitations'] ?? 0 }}</div>
            <div class="stat-label">Total Undangan</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#F0FDF4;">✅</div>
        <div>
            <div class="stat-num">{{ $stats['active_invitations'] ?? 0 }}</div>
            <div class="stat-label">Undangan Aktif</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#EFF6FF;">👥</div>
        <div>
            <div class="stat-num">{{ $stats['total_guests'] ?? 0 }}</div>
            <div class="stat-label">Total Tamu</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#FFFBEB;">💬</div>
        <div>
            <div class="stat-num">{{ $stats['total_wishes'] ?? 0 }}</div>
            <div class="stat-label">Ucapan & Doa</div>
        </div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;margin-bottom:1.75rem;">
    {{-- My Invitations --}}
    <div class="dash-card" style="grid-column: span 2;">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;flex-wrap:wrap;gap:0.75rem;">
            <div style="font-weight:600;font-size:0.95rem;">Undangan Saya</div>
            <a href="{{ route('invitations.index') }}" style="font-size:0.8rem;color:var(--color-pink);text-decoration:none;font-weight:500;">Lihat Semua →</a>
        </div>

        @forelse($invitations ?? [] as $inv)
        <div style="display:flex;align-items:center;gap:1rem;padding:0.85rem;border-radius:10px;border:1px solid #F3F4F6;margin-bottom:0.75rem;transition:border-color 0.2s;" onmouseover="this.style.borderColor='rgba(244,114,182,0.3)'" onmouseout="this.style.borderColor='#F3F4F6'">
            <div style="width:44px;height:44px;border-radius:10px;background:linear-gradient(135deg,#FDF2F8,#EFF6FF);display:flex;align-items:center;justify-content:center;font-size:1.25rem;flex-shrink:0;">💍</div>
            <div style="flex:1;min-width:0;">
                <div style="font-weight:600;font-size:0.875rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $inv->title }}</div>
                <div style="font-size:0.75rem;color:var(--color-muted);">{{ $inv->template->name ?? 'Template' }} · {{ $inv->created_at->diffForHumans() }}</div>
            </div>
            <div style="display:flex;align-items:center;gap:0.5rem;flex-shrink:0;">
                <span class="badge {{ $inv->status === 'active' ? 'badge-success' : ($inv->status === 'draft' ? 'badge-gray' : 'badge-warning') }}">
                    {{ $inv->status === 'active' ? 'Aktif' : ($inv->status === 'draft' ? 'Draft' : 'Nonaktif') }}
                </span>
                <a href="{{ route('editor.show', $inv->id) }}" class="btn-primary btn-sm">Edit</a>
                @if($inv->status === 'active')
                <a href="{{ route('invitation.show', $inv->slug) }}" target="_blank" class="btn-outline btn-sm">Lihat</a>
                @endif
            </div>
        </div>
        @empty
        <div style="text-align:center;padding:3rem 1rem;">
            <div style="font-size:3rem;margin-bottom:1rem;">💌</div>
            <div style="font-weight:600;margin-bottom:0.4rem;">Belum Ada Undangan</div>
            <p style="font-size:0.85rem;color:var(--color-muted);margin-bottom:1.25rem;">Mulai buat undangan digitalmu sekarang dan bagikan ke semua tamu.</p>
            <a href="{{ route('invitations.create') }}" class="btn-primary">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Buat Undangan Pertama
            </a>
        </div>
        @endforelse
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">
    {{-- Recent Orders --}}
    <div class="dash-card">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;">
            <div style="font-weight:600;font-size:0.95rem;">Pesanan Terbaru</div>
            <a href="{{ route('orders.index') }}" style="font-size:0.8rem;color:var(--color-pink);text-decoration:none;font-weight:500;">Lihat Semua →</a>
        </div>
        @forelse($orders ?? [] as $order)
        <div style="display:flex;align-items:center;justify-content:space-between;padding:0.75rem 0;border-bottom:1px solid #F3F4F6;">
            <div>
                <div style="font-size:0.8rem;font-weight:600;">{{ $order->order_number }}</div>
                <div style="font-size:0.72rem;color:var(--color-muted);">Paket {{ $order->package->name ?? '' }} · {{ $order->created_at->format('d M Y') }}</div>
            </div>
            <span class="badge {{ $order->payment_status === 'paid' ? 'badge-success' : ($order->payment_status === 'pending' ? 'badge-warning' : 'badge-danger') }}">
                {{ $order->payment_status === 'paid' ? 'Lunas' : ($order->payment_status === 'pending' ? 'Pending' : ucfirst($order->payment_status)) }}
            </span>
        </div>
        @empty
        <div style="text-align:center;padding:2rem;color:var(--color-muted);font-size:0.85rem;">Belum ada pesanan</div>
        @endforelse
    </div>

    {{-- Quick Actions --}}
    <div class="dash-card">
        <div style="font-weight:600;font-size:0.95rem;margin-bottom:1.25rem;">Aksi Cepat</div>
        <div style="display:flex;flex-direction:column;gap:0.6rem;">
            <a href="{{ route('invitations.create') }}" style="display:flex;align-items:center;gap:0.75rem;padding:0.85rem;border-radius:10px;background:#FDF2F8;text-decoration:none;transition:background 0.2s;" onmouseover="this.style.background='#FCE7F3'" onmouseout="this.style.background='#FDF2F8'">
                <div style="width:36px;height:36px;background:white;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0;">💌</div>
                <div>
                    <div style="font-weight:600;font-size:0.825rem;color:var(--color-text);">Buat Undangan Baru</div>
                    <div style="font-size:0.72rem;color:var(--color-muted);">Pilih template dan mulai edit</div>
                </div>
            </a>
            <a href="{{ route('templates.index') }}" style="display:flex;align-items:center;gap:0.75rem;padding:0.85rem;border-radius:10px;background:#EFF6FF;text-decoration:none;transition:background 0.2s;" onmouseover="this.style.background='#DBEAFE'" onmouseout="this.style.background='#EFF6FF'">
                <div style="width:36px;height:36px;background:white;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0;">🎨</div>
                <div>
                    <div style="font-weight:600;font-size:0.825rem;color:var(--color-text);">Jelajahi Template</div>
                    <div style="font-size:0.72rem;color:var(--color-muted);">Lihat semua pilihan desain</div>
                </div>
            </a>
            <a href="{{ route('home') }}#harga" style="display:flex;align-items:center;gap:0.75rem;padding:0.85rem;border-radius:10px;background:#FFF9F0;text-decoration:none;transition:background 0.2s;" onmouseover="this.style.background='#FEF3C7'" onmouseout="this.style.background='#FFF9F0'">
                <div style="width:36px;height:36px;background:white;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0;">💎</div>
                <div>
                    <div style="font-weight:600;font-size:0.825rem;color:var(--color-text);">Upgrade Paket</div>
                    <div style="font-size:0.72rem;color:var(--color-muted);">Buka fitur premium lebih banyak</div>
                </div>
            </a>
            <a href="https://wa.me/{{ env('ADMIN_WHATSAPP') }}" target="_blank" style="display:flex;align-items:center;gap:0.75rem;padding:0.85rem;border-radius:10px;background:#F0FDF4;text-decoration:none;transition:background 0.2s;" onmouseover="this.style.background='#DCFCE7'" onmouseout="this.style.background='#F0FDF4'">
                <div style="width:36px;height:36px;background:white;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1.1rem;flex-shrink:0;">💬</div>
                <div>
                    <div style="font-weight:600;font-size:0.825rem;color:var(--color-text);">Hubungi Admin</div>
                    <div style="font-size:0.72rem;color:var(--color-muted);">Via WhatsApp langsung</div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
