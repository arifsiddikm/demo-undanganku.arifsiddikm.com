@extends('layouts.admin')
@section('title', 'Pengguna')
@section('page_title', 'Manajemen Pengguna')

@section('content')
<div class="card" style="margin-bottom:1rem;padding:1rem 1.25rem;">
    <form method="GET" style="display:flex;gap:0.75rem;align-items:flex-end;">
        <div style="flex:1;">
            <label class="form-label">Cari Pengguna</label>
            <input type="text" name="search" class="form-input" placeholder="Nama atau email..." value="{{ request('search') }}">
        </div>
        <button type="submit" class="btn-primary">Cari</button>
        <a href="{{ route('admin.users') }}" class="btn-outline">Reset</a>
    </form>
</div>

<div class="card">
    <div style="overflow-x:auto;">
        <table class="table-auto">
            <thead><tr>
                <th>Pengguna</th>
                <th>No. WA</th>
                <th>Bergabung</th>
                <th>Undangan</th>
                <th>Pesanan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr></thead>
            <tbody>
            @forelse($users as $user)
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:0.6rem;">
                        <div style="width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,#F472B6,#93C5FD);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:0.82rem;flex-shrink:0;">
                            {{ strtoupper(substr($user->name,0,1)) }}
                        </div>
                        <div>
                            <div style="font-weight:600;font-size:0.85rem;">{{ $user->name }}</div>
                            <div style="font-size:0.72rem;color:#9CA3AF;">{{ $user->email }}</div>
                        </div>
                    </div>
                </td>
                <td style="font-size:0.82rem;">{{ $user->phone ?? '-' }}</td>
                <td style="font-size:0.78rem;color:#6B7280;">{{ $user->created_at->format('d M Y') }}</td>
                <td style="text-align:center;font-weight:600;">{{ $user->invitations_count ?? 0 }}</td>
                <td style="text-align:center;font-weight:600;">{{ $user->orders_count ?? 0 }}</td>
                <td>
                    <span class="badge {{ $user->is_active ? 'badge-success' : 'badge-danger' }}">
                        {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td>
                    <form id="toggle-{{ $user->id }}" action="{{ route('admin.users.toggle', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="button"
                            onclick="confirmAction('{{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }} akun {{ $user->name }}?','toggle-{{ $user->id }}')"
                            class="{{ $user->is_active ? 'btn-danger' : 'btn-success' }} btn-sm">
                            {{ $user->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;padding:2.5rem;color:#9CA3AF;">Tidak ada pengguna ditemukan</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div style="padding:1rem 1.25rem;border-top:1px solid #F3F4F6;">{{ $users->links() }}</div>
    @endif
</div>
@endsection
