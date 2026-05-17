@extends('layouts.dashboard')
@section('title', 'Profil Saya')
@section('page_title', 'Profil Saya')

@section('content')
<div style="display:grid;grid-template-columns:1fr 320px;gap:1.25rem;max-width:850px;">

    <div class="dash-card">
        <div style="font-weight:600;font-size:0.95rem;margin-bottom:1.25rem;">Edit Profil</div>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $e)<div style="font-size:0.82rem;">• {{ $e }}</div>@endforeach
        </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-input" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Email <span style="color:#9CA3AF;font-weight:400;">(tidak dapat diubah)</span></label>
                <input type="email" class="form-input" value="{{ $user->email }}" readonly style="background:#F9FAFB;cursor:not-allowed;">
            </div>
            <div class="form-group">
                <label class="form-label">No. WhatsApp</label>
                <input type="text" name="phone" class="form-input" value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx">
            </div>

            <div style="border-top:1px solid #F3F4F6;margin:1.25rem 0;"></div>
            <div style="font-size:0.82rem;font-weight:600;color:var(--color-muted);margin-bottom:1rem;text-transform:uppercase;letter-spacing:0.06em;">Ubah Password <span style="font-weight:400;text-transform:none;letter-spacing:0;">(kosongkan jika tidak ingin ubah)</span></div>

            <div class="form-group">
                <label class="form-label">Password Baru</label>
                <div style="position:relative;">
                    <input type="password" name="password" id="newPasswordField" class="form-input" placeholder="Masukkan password baru (min 8 karakter)" autocomplete="new-password" minlength="8">
                    <span style="position:absolute;right:.75rem;top:50%;transform:translateY(-50%);cursor:pointer;font-size:.9rem;" onclick="var f=document.getElementById('newPasswordField');f.type=f.type==='text'?'password':'text'">👁</span>
                </div>
                <div style="font-size:.72rem;color:var(--color-muted);margin-top:.25rem;">Minimal 8 karakter. Kosongkan jika tidak ingin ubah.</div>
            </div>
            

            <button type="submit" class="btn-primary" style="padding:0.65rem 1.75rem;">Simpan Perubahan</button>
        </form>
    </div>

    <div>
        <div class="dash-card" style="text-align:center;margin-bottom:1rem;">
            <div style="width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,#F472B6,#93C5FD);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:2rem;margin:0 auto 1rem;">
                {{ strtoupper(substr($user->name,0,1)) }}
            </div>
            <div style="font-weight:700;font-size:1rem;">{{ $user->name }}</div>
            <div style="font-size:0.8rem;color:var(--color-muted);margin-top:0.2rem;">{{ $user->email }}</div>
            <div style="margin-top:0.75rem;">
                <span class="badge badge-success">Pengguna Aktif</span>
            </div>
        </div>

        <div class="dash-card">
            <div style="font-weight:600;font-size:0.85rem;margin-bottom:0.85rem;">Akun Saya</div>
            <div style="font-size:0.8rem;color:var(--color-muted);margin-bottom:0.35rem;">Bergabung sejak</div>
            <div style="font-size:0.85rem;font-weight:500;margin-bottom:0.75rem;">{{ $user->created_at->format('d M Y') }}</div>
            <div style="font-size:0.8rem;color:var(--color-muted);margin-bottom:0.35rem;">No. WhatsApp</div>
            <div style="font-size:0.85rem;font-weight:500;">{{ $user->phone ?? '-' }}</div>
        </div>
    </div>
</div>
@endsection
