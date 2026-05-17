@extends('layouts.admin')
@section('title', 'No. Rekening')
@section('page_title', 'Manajemen No. Rekening')

@section('content')
<div style="display:grid;grid-template-columns:1fr 360px;gap:1.25rem;align-items:start;">

    {{-- List --}}
    <div class="card">
        <div style="padding:1rem 1.25rem;border-bottom:1px solid #F3F4F6;font-weight:600;">Daftar Rekening</div>
        <div style="overflow-x:auto;">
            <table class="table-auto">
                <thead><tr>
                    <th>Bank</th>
                    <th>No. Rekening</th>
                    <th>Atas Nama</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr></thead>
                <tbody>
                @forelse($bankAccounts as $bank)
                <tr>
                    <td style="font-weight:600;">{{ $bank->bank_name }}</td>
                    <td style="font-family:monospace;">{{ $bank->account_number }}</td>
                    <td>{{ $bank->account_name }}</td>
                    <td>
                        <span class="badge {{ $bank->is_active ? 'badge-success' : 'badge-gray' }}">
                            {{ $bank->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td>
                        <form id="del-bank-{{ $bank->id }}" action="{{ route('admin.bank-accounts.delete', $bank->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="button" onclick="confirmDelete('del-bank-{{ $bank->id }}')" class="btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center;padding:2rem;color:#9CA3AF;">Belum ada rekening</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Add form --}}
    <div class="card">
        <div style="padding:1rem 1.25rem;border-bottom:1px solid #F3F4F6;font-weight:600;">Tambah Rekening Baru</div>
        <div class="card-body">
            <form action="{{ route('admin.bank-accounts.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Nama Bank</label>
                    <input type="text" name="bank_name" class="form-input" placeholder="BCA, BRI, Mandiri, dll" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Nomor Rekening</label>
                    <input type="text" name="account_number" class="form-input" placeholder="1234567890" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Atas Nama</label>
                    <input type="text" name="account_name" class="form-input" placeholder="Nama pemilik rekening" required>
                </div>
                <button type="submit" class="btn-primary" style="width:100%;">Tambah Rekening</button>
            </form>
        </div>
    </div>
</div>
@endsection
