@extends('layouts.dashboard')
@section('title', 'Undangan Saya')
@section('page_title', 'Undangan Saya')

@section('content')
<div class="page-header">
  <div></div>
  <a href="{{ route('invitations.create') }}" class="btn-primary">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    Buat Undangan Baru
  </a>
</div>

<div class="dash-card" style="padding:0.75rem;">
  @forelse($invitations as $inv)
  @php
    $hasOrder   = $inv->order && $inv->order->payment_status === 'paid';
    $isPending  = $inv->order && $inv->order->payment_status === 'pending';
    $pkgSlug    = $inv->order?->package?->slug ?? null;
    $pkgName    = $inv->order?->package?->name ?? null;
  @endphp
  <div style="border:1.5px solid {{ $hasOrder ? '#E5E7EB' : '#FDE68A' }};border-radius:14px;padding:1rem 1.15rem;margin-bottom:0.85rem;transition:border-color .2s;background:{{ $hasOrder ? 'white' : '#FFFBEB' }};"
    onmouseover="this.style.borderColor='rgba(244,114,182,.35)'" onmouseout="this.style.borderColor='{{ $hasOrder ? '#E5E7EB' : '#FDE68A' }}'">

    <div style="display:flex;align-items:flex-start;gap:1rem;">
      {{-- Icon/thumb --}}
      <div style="width:52px;height:52px;border-radius:10px;background:linear-gradient(135deg,{{ $inv->color_primary ?? '#F472B6' }},{{ $inv->color_secondary ?? '#93C5FD' }});display:flex;align-items:center;justify-content:center;font-size:1.4rem;flex-shrink:0;">💍</div>

      {{-- Info --}}
      <div style="flex:1;min-width:0;">
        <div style="display:flex;align-items:center;gap:0.5rem;flex-wrap:wrap;margin-bottom:0.2rem;">
          <span style="font-weight:700;font-size:0.9rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $inv->title }}</span>
          <span class="badge {{ $inv->status==='active'?'badge-success':($inv->status==='draft'?'badge-gray':'badge-warning') }}" style="font-size:0.65rem;">
            {{ $inv->status==='active'?'✅ Aktif':($inv->status==='draft'?'📝 Draft':'⏸ Nonaktif') }}
          </span>
          @if($hasOrder)
          <span class="badge badge-info" style="font-size:0.65rem;background:#EFF6FF;color:#2563EB;">{{ $pkgName }}</span>
          @elseif($isPending)
          <span class="badge" style="font-size:0.65rem;background:#FEF3C7;color:#92400E;">⏳ Menunggu Verifikasi</span>
          @else
          <span class="badge" style="font-size:0.65rem;background:#FEF3C7;color:#92400E;">⚠️ Belum Diaktifkan</span>
          @endif
        </div>
        <div style="font-size:0.75rem;color:var(--color-muted);">
          Template: {{ $inv->template->name ?? 'Belum dipilih' }} · Dibuat {{ $inv->created_at->diffForHumans() }}
        </div>
        @if($inv->status === 'active' && $inv->slug)
        <div style="font-size:0.72rem;color:var(--color-pink);margin-top:0.2rem;font-family:monospace;">
          {{ url('/'.$inv->slug) }}
        </div>
        @endif
        @if(!$hasOrder && !$isPending)
        <div style="font-size:0.72rem;color:#92400E;margin-top:0.3rem;line-height:1.5;">
          Pilih paket untuk mengaktifkan undangan dan membuka semua fitur.
        </div>
        @endif
      </div>

      {{-- Actions --}}
      <div style="display:flex;flex-direction:column;align-items:flex-end;gap:0.4rem;flex-shrink:0;">
        {{-- Upgrade button - prominent if no order --}}
        @if(!$hasOrder && !$isPending)
        <a href="{{ route('invitations.upgrade', $inv->id) }}" class="btn-primary" style="font-size:0.78rem;padding:0.45rem 0.9rem;background:linear-gradient(135deg,#F59E0B,#EF4444);border:none;white-space:nowrap;">
          ⚡ Upgrade Sekarang
        </a>
        @elseif($isPending)
        <a href="{{ route('orders.show', $inv->order->id) }}" class="btn-outline" style="font-size:0.75rem;padding:0.4rem 0.75rem;color:#92400E;border-color:#FDE68A;white-space:nowrap;">
          📤 Lihat Pesanan
        </a>
        @endif
        <div style="display:flex;gap:0.4rem;flex-wrap:wrap;justify-content:flex-end;">
          <a href="{{ route('editor.show', $inv->id) }}" class="btn-primary btn-sm">✏️ Edit</a>
          @if($inv->status === 'active' && $inv->slug)
          <a href="{{ url('/'.$inv->slug) }}" target="_blank" class="btn-outline btn-sm">👁 Lihat</a>
          @endif
          <button onclick="confirmDelete({{ $inv->id }}, '{{ addslashes($inv->title) }}')" class="btn-danger btn-sm">×</button>
        </div>
      </div>
    </div>

    {{-- Upgrade packages row (shown inline when no order) --}}
    @if(!$hasOrder && !$isPending)
    <div style="margin-top:0.85rem;padding-top:0.85rem;border-top:1px dashed #FDE68A;">
      <div style="font-size:0.72rem;font-weight:700;color:#92400E;margin-bottom:0.5rem;letter-spacing:.05em;text-transform:uppercase;">Pilih Paket:</div>
      <div style="display:flex;gap:0.5rem;flex-wrap:wrap;">
        @foreach($packages as $pkg)
        <a href="{{ route('checkout.invitation', [$pkg->slug, $inv->id]) }}"
          style="flex:1;min-width:100px;padding:0.6rem 0.75rem;border:1.5px solid {{ $pkg->slug==='luxury'?'#C49A3C':($pkg->slug==='premium'?'#7C3AED':'#E5E7EB') }};border-radius:10px;text-align:center;text-decoration:none;transition:all .2s;background:{{ $pkg->slug==='luxury'?'#FFFBEB':($pkg->slug==='premium'?'#F5F3FF':'white') }}"
          onmouseover="this.style.background='{{ $pkg->slug==='luxury'?'#FEF3C7':($pkg->slug==='premium'?'#EDE9FE':'#FDF2F8') }}'"
          onmouseout="this.style.background='{{ $pkg->slug==='luxury'?'#FFFBEB':($pkg->slug==='premium'?'#F5F3FF':'white') }}'">
          <div style="font-weight:700;font-size:0.8rem;color:{{ $pkg->slug==='luxury'?'#92400E':($pkg->slug==='premium'?'#6D28D9':'#374151') }}">
            {{ $pkg->slug==='luxury'?'👑':($pkg->slug==='premium'?'💎':'✨') }} {{ $pkg->name }}
          </div>
          <div style="font-size:0.7rem;color:var(--color-muted);margin-top:0.1rem;">Rp {{ number_format($pkg->price,0,',','.') }}</div>
        </a>
        @endforeach
      </div>
    </div>
    @endif

  </div>
  @empty
</div>
<div class="dash-card">
  <div style="text-align:center;padding:3rem;">
    <div style="font-size:3rem;margin-bottom:1rem;">💌</div>
    <div style="font-weight:700;font-size:1.1rem;margin-bottom:0.5rem;">Belum Ada Undangan</div>
    <p style="font-size:0.85rem;color:var(--color-muted);margin-bottom:1.5rem;max-width:360px;margin-left:auto;margin-right:auto;">Buat undangan digital pertamamu dan bagikan ke semua tamu dengan mudah!</p>
    <a href="{{ route('invitations.create') }}" class="btn-primary" style="padding:0.75rem 2rem;">Buat Undangan Pertama</a>
  </div>
  @endforelse

  @if($invitations->hasPages())
  <div style="margin-top:1rem;">{{ $invitations->links() }}</div>
  @endif
</div>

{{-- Delete form --}}
<form id="del-inv-form" method="POST" style="display:none;">@csrf @method('DELETE')</form>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script>
function confirmDelete(id, title) {
    Swal.fire({
        title: 'Hapus Undangan?',
        html: '<b>' + title + '</b><br><span style="font-size:.85rem;color:#6B7280">Semua data termasuk foto, tamu, dan ucapan akan dihapus permanen!</span>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#EF4444',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then(function(r) {
        if (r.isConfirmed) {
            var form = document.getElementById('del-inv-form');
            form.action = '/dashboard/invitations/' + id;
            form.submit();
        }
    });
}
</script>
@endpush
@endsection
