@extends('layouts.admin')
@section('title','Detail Undangan')
@section('page_title','Detail Undangan: ' . $invitation->title)
@section('content')
<div style="display:grid;grid-template-columns:1fr 340px;gap:1.25rem">
  <div>
    <div class="card" style="margin-bottom:1.25rem">
      <div style="padding:1rem 1.25rem;border-bottom:1px solid #F3F4F6;font-weight:600">Info Undangan</div>
      <div class="card-body">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
          <div><div style="font-size:.72rem;color:#9CA3AF;margin-bottom:.2rem">Judul</div><div style="font-weight:600">{{ $invitation->title }}</div></div>
          <div><div style="font-size:.72rem;color:#9CA3AF;margin-bottom:.2rem">Slug / URL</div><div style="font-family:monospace;font-size:.82rem">/{{ $invitation->slug }}</div></div>
          <div><div style="font-size:.72rem;color:#9CA3AF;margin-bottom:.2rem">Template</div><div>{{ $invitation->template->name ?? '-' }}</div></div>
          <div><div style="font-size:.72rem;color:#9CA3AF;margin-bottom:.2rem">Status</div><span class="badge {{ $invitation->status==='active'?'badge-success':($invitation->status==='draft'?'badge-gray':'badge-warning') }}">{{ ucfirst($invitation->status) }}</span></div>
          <div><div style="font-size:.72rem;color:#9CA3AF;margin-bottom:.2rem">Pengantin Pria</div><div>{{ $invitation->groom_name ?: '-' }}</div></div>
          <div><div style="font-size:.72rem;color:#9CA3AF;margin-bottom:.2rem">Pengantin Wanita</div><div>{{ $invitation->bride_name ?: '-' }}</div></div>
          @if($invitation->akad_date)<div><div style="font-size:.72rem;color:#9CA3AF;margin-bottom:.2rem">Tanggal Akad</div><div>{{ \Carbon\Carbon::parse($invitation->akad_date)->isoFormat('D MMMM YYYY') }}</div></div>@endif
          <div><div style="font-size:.72rem;color:#9CA3AF;margin-bottom:.2rem">Dibuat</div><div>{{ $invitation->created_at->format('d M Y H:i') }}</div></div>
        </div>
      </div>
    </div>
    <!-- Guests -->
    <div class="card" style="margin-bottom:1.25rem">
      <div style="padding:1rem 1.25rem;border-bottom:1px solid #F3F4F6;font-weight:600">Daftar Tamu ({{ $invitation->guests->count() }})</div>
      <div style="overflow-x:auto"><table class="table-auto">
        <thead><tr><th>Nama</th><th>No. HP</th><th>Pax</th><th>Status</th></tr></thead>
        <tbody>
        @forelse($invitation->guests as $g)
        <tr><td style="font-size:.82rem">{{ $g->name }}</td><td style="font-size:.78rem">{{ $g->phone ?: '-' }}</td><td>{{ $g->pax }}</td><td><span class="badge {{ $g->status==='hadir'?'badge-success':($g->status==='tidak_hadir'?'badge-danger':'badge-gray') }}">{{ $g->status==='hadir'?'Hadir':($g->status==='tidak_hadir'?'Tidak':'Pending') }}</span></td></tr>
        @empty
        <tr><td colspan="4" style="text-align:center;color:#9CA3AF">Belum ada tamu</td></tr>
        @endforelse
        </tbody>
      </table></div>
    </div>
    <!-- Wishes -->
    <div class="card">
      <div style="padding:1rem 1.25rem;border-bottom:1px solid #F3F4F6;font-weight:600">Ucapan & Doa ({{ $invitation->wishes->count() }})</div>
      <div class="card-body">
        @forelse($invitation->wishes->take(20) as $w)
        <div style="padding:.75rem;background:#F9FAFB;border-radius:8px;margin-bottom:.5rem"><div style="font-weight:500;font-size:.82rem">{{ $w->name }}</div><div style="font-size:.8rem;color:#6B7280;line-height:1.5">{{ $w->message }}</div></div>
        @empty<div style="text-align:center;padding:1rem;color:#9CA3AF">Belum ada ucapan</div>@endforelse
      </div>
    </div>
  </div>
  <div>
    <div class="card" style="margin-bottom:1.25rem">
      <div style="padding:1rem 1.25rem;border-bottom:1px solid #F3F4F6;font-weight:600">Pemilik</div>
      <div class="card-body">
        <div style="font-weight:600">{{ $invitation->user->name ?? '-' }}</div>
        <div style="font-size:.82rem;color:#6B7280">{{ $invitation->user->email ?? '' }}</div>
        @if($invitation->user->phone ?? false)<div style="font-size:.82rem;color:#6B7280;margin-top:.25rem">📱 {{ $invitation->user->phone }}</div>@endif
      </div>
    </div>
    <div class="card" style="margin-bottom:1.25rem">
      <div style="padding:1rem 1.25rem;border-bottom:1px solid #F3F4F6;font-weight:600">Statistik</div>
      <div class="card-body">
        @foreach([['Foto Galeri',$invitation->photos->count()],['Total Tamu',$invitation->guests->count()],['RSVP',$invitation->rsvps->count()],['Ucapan',$invitation->wishes->count()],['Rekening',$invitation->gifts->count()]] as [$l,$v])
        <div style="display:flex;justify-content:space-between;padding:.4rem 0;border-bottom:1px solid #F9FAFB;font-size:.82rem"><span style="color:#6B7280">{{ $l }}</span><strong>{{ $v }}</strong></div>
        @endforeach
      </div>
    </div>
    @if($invitation->status==='active')
    <div class="card">
      <div class="card-body">
        <div style="font-weight:600;margin-bottom:.75rem">Link Undangan</div>
        <div style="display:flex;align-items:center;gap:.5rem">
          <input type="text" readonly value="{{ url('/'.$invitation->slug) }}" class="form-input" style="font-size:.72rem;padding:.4rem .6rem">
          <a href="{{ url('/'.$invitation->slug) }}" target="_blank" class="btn-primary btn-sm" style="flex-shrink:0">Buka</a>
        </div>
      </div>
    </div>
    @endif
  </div>
</div>
<div style="margin-top:1rem"><a href="{{ route('admin.invitations') }}" class="btn-outline">← Kembali</a></div>
@endsection
