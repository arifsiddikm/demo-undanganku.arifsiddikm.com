@extends('layouts.admin')
@section('title','Data Undangan')
@section('page_title','Data Undangan')
@section('content')
<div class="card" style="margin-bottom:1rem;padding:1rem 1.25rem">
  <form method="GET" style="display:flex;gap:.75rem;flex-wrap:wrap;align-items:flex-end">
    <div style="flex:1;min-width:180px"><label class="form-label">Cari</label><input type="text" name="search" class="form-input" placeholder="Judul atau slug..." value="{{ request('search') }}"></div>
    <div style="min-width:130px"><label class="form-label">Status</label><select name="status" class="form-select"><option value="">Semua</option><option value="active" {{ request('status')==='active'?'selected':'' }}>Aktif</option><option value="draft" {{ request('status')==='draft'?'selected':'' }}>Draft</option><option value="inactive" {{ request('status')==='inactive'?'selected':'' }}>Nonaktif</option></select></div>
    <button type="submit" class="btn-primary">Filter</button>
    <a href="{{ route('admin.invitations') }}" class="btn-outline">Reset</a>
  </form>
</div>
<div class="card">
  <div style="overflow-x:auto">
    <table class="table-auto">
      <thead><tr><th>Undangan</th><th>Pemilik</th><th>Template</th><th>Status</th><th>Tamu</th><th>Ucapan</th><th>Dibuat</th><th>Aksi</th></tr></thead>
      <tbody>
      @forelse($invitations as $inv)
      <tr>
        <td>
          <div style="font-weight:600;font-size:.85rem">{{ $inv->title }}</div>
          <div style="font-size:.72rem;color:#9CA3AF;font-family:monospace">/{{ $inv->slug }}</div>
        </td>
        <td><div style="font-size:.82rem">{{ $inv->user->name ?? '-' }}</div><div style="font-size:.72rem;color:#9CA3AF">{{ $inv->user->email ?? '' }}</div></td>
        <td style="font-size:.8rem">{{ $inv->template->name ?? '-' }}</td>
        <td><span class="badge {{ $inv->status==='active'?'badge-success':($inv->status==='draft'?'badge-gray':'badge-warning') }}">{{ $inv->status==='active'?'Aktif':($inv->status==='draft'?'Draft':'Nonaktif') }}</span></td>
        <td style="text-align:center;font-weight:600">{{ $inv->guests->count() }}</td>
        <td style="text-align:center;font-weight:600">{{ $inv->wishes->count() }}</td>
        <td style="font-size:.78rem;color:#6B7280">{{ $inv->created_at->format('d M Y') }}</td>
        <td>
          <a href="{{ route('admin.invitations.show',$inv->id) }}" class="btn-outline btn-sm">Detail</a>
          @if($inv->status==='active')<a href="{{ url('/'.$inv->slug) }}" target="_blank" class="btn-primary btn-sm" style="margin-left:4px">Lihat</a>@endif
        </td>
      </tr>
      @empty
      <tr><td colspan="8" style="text-align:center;padding:2.5rem;color:#9CA3AF">Tidak ada undangan</td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
  @if($invitations->hasPages())<div style="padding:1rem 1.25rem;border-top:1px solid #F3F4F6">{{ $invitations->links() }}</div>@endif
</div>
@endsection
