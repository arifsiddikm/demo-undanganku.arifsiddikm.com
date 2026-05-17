@extends('layouts.app')

@section('title', 'Buat Password Baru - UndanganKu')
@section('meta_description', 'Buat password baru untuk akun UndanganKu kamu.')

@push('styles')
<style>
.auth-wrapper {
    min-height: 100vh;
    display: grid;
    grid-template-columns: 1fr 1fr;
    padding-top: 64px;
}
.auth-left {
    background: linear-gradient(160deg, #FDF2F8 0%, #EFF6FF 100%);
    display: flex; align-items: center; justify-content: center;
    padding: 3rem; position: relative; overflow: hidden;
}
.auth-left::before {
    content: '';
    position: absolute; top: -20%; right: -20%;
    width: 60%; height: 60%;
    background: radial-gradient(circle, rgba(244,114,182,0.12), transparent 70%);
    border-radius: 50%;
}
.auth-right {
    display: flex; align-items: center; justify-content: center;
    padding: 2rem 3rem;
}
.auth-form-box { width: 100%; max-width: 420px; }
.auth-title { font-family: var(--font-display); font-size: 2rem; font-weight: 600; margin-bottom: 0.4rem; }
.auth-subtitle { font-size: 0.875rem; color: var(--color-muted); margin-bottom: 2rem; line-height: 1.6; }
@media (max-width: 768px) {
    .auth-wrapper { grid-template-columns: 1fr; }
    .auth-left { display: none; }
    .auth-right { padding: 2rem 1.5rem; }
}
</style>
@endpush

@section('content')
<div class="auth-wrapper">

    <div class="auth-left">
        <div style="position:relative;z-index:1;text-align:center;max-width:380px;">
            <div style="font-size:5rem;margin-bottom:1.5rem;">🔐</div>
            <h2 style="font-family:var(--font-display);font-size:1.75rem;font-weight:600;margin-bottom:1rem;line-height:1.3;">
                Password baru<br>yang lebih kuat
            </h2>
            <p style="color:var(--color-muted);font-size:0.875rem;line-height:1.7;">
                Buat password yang unik dan mudah diingat — tapi sulit ditebak orang lain.
            </p>
            <div style="margin-top:2rem;display:flex;flex-direction:column;gap:0.75rem;text-align:left;">
                <div style="background:white;border-radius:12px;padding:0.85rem 1rem;display:flex;align-items:center;gap:0.75rem;font-size:0.82rem;box-shadow:0 2px 8px rgba(0,0,0,0.06);">
                    <span style="font-size:1.25rem;">✅</span>
                    <span>Minimal 8 karakter</span>
                </div>
                <div style="background:white;border-radius:12px;padding:0.85rem 1rem;display:flex;align-items:center;gap:0.75rem;font-size:0.82rem;box-shadow:0 2px 8px rgba(0,0,0,0.06);">
                    <span style="font-size:1.25rem;">🔒</span>
                    <span>Gunakan kombinasi huruf & angka</span>
                </div>
            </div>
        </div>
    </div>

    <div class="auth-right">
        <div class="auth-form-box">
            <div class="auth-title">Buat Password Baru</div>
            <p class="auth-subtitle">Masukkan password baru untuk akun <strong>{{ $email }}</strong></p>

            @if ($errors->any())
            <div style="background:#FEF2F2;border:1px solid #FECACA;border-radius:10px;padding:0.85rem 1rem;margin-bottom:1.25rem;font-size:0.83rem;color:#991B1B;">
                {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <div style="margin-bottom:1rem;">
                    <label style="display:block;font-size:0.82rem;font-weight:500;margin-bottom:0.35rem;">Password Baru</label>
                    <div style="position:relative;">
                        <input type="password" name="password" id="pass1"
                               style="width:100%;padding:0.7rem 2.8rem 0.7rem 1rem;border:1.5px solid #E5E7EB;border-radius:10px;font-size:0.875rem;outline:none;font-family:var(--font-body);transition:border-color .2s;"
                               placeholder="Minimal 8 karakter" required autofocus minlength="8"
                               onfocus="this.style.borderColor='var(--color-pink)'" onblur="this.style.borderColor='#E5E7EB'">
                        <button type="button" onclick="togglePass('pass1','eye1')" style="position:absolute;right:0.75rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#9CA3AF;padding:0;">
                            <svg id="eye1" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>

                <div style="margin-bottom:1.5rem;">
                    <label style="display:block;font-size:0.82rem;font-weight:500;margin-bottom:0.35rem;">Konfirmasi Password Baru</label>
                    <div style="position:relative;">
                        <input type="password" name="password_confirmation" id="pass2"
                               style="width:100%;padding:0.7rem 2.8rem 0.7rem 1rem;border:1.5px solid #E5E7EB;border-radius:10px;font-size:0.875rem;outline:none;font-family:var(--font-body);transition:border-color .2s;"
                               placeholder="Ulangi password baru" required minlength="8"
                               onfocus="this.style.borderColor='var(--color-pink)'" onblur="this.style.borderColor='#E5E7EB'">
                        <button type="button" onclick="togglePass('pass2','eye2')" style="position:absolute;right:0.75rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#9CA3AF;padding:0;">
                            <svg id="eye2" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-primary"
                        style="width:100%;padding:0.8rem;font-size:0.9rem;border-radius:10px;display:flex;align-items:center;justify-content:center;gap:0.5rem;">
                    🔑 &nbsp; Simpan Password Baru
                </button>
            </form>

            <div style="text-align:center;font-size:0.85rem;color:var(--color-muted);margin-top:1.5rem;">
                Ingat password lama?
                <a href="{{ route('login') }}" style="color:var(--color-pink);font-weight:600;text-decoration:none;margin-left:0.25rem;">Kembali Login</a>
            </div>
        </div>
    </div>
</div>

<script>
function togglePass(inputId, eyeId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(eyeId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
    } else {
        input.type = 'password';
        icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    }
}
</script>
@endsection
