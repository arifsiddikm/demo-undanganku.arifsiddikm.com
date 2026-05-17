@extends('layouts.app')

@section('title', 'Masuk - UndanganKu')
@section('meta_description', 'Masuk ke akun UndanganKu dan mulai buat undangan digital pernikahanmu.')

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
    padding: 3rem;
    position: relative; overflow: hidden;
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

    {{-- Left illustration --}}
    <div class="auth-left">
        <div style="position:relative;z-index:1;text-align:center;max-width:380px;">
            <div style="font-size:5rem;margin-bottom:1.5rem;">💑</div>
            <h2 style="font-family:var(--font-display);font-size:1.75rem;font-weight:600;margin-bottom:1rem;line-height:1.3;">
                Selamat Datang di<br><span style="color:var(--color-pink);">UndanganKu</span>
            </h2>
            <p style="font-size:0.875rem;color:var(--color-muted);line-height:1.7;margin-bottom:2rem;">
                Buat undangan digital pernikahan yang cantik dan modern. Lebih dari 10.000 pasangan sudah percaya kami.
            </p>
            <div style="display:flex;gap:1.5rem;justify-content:center;">
                <div style="text-align:center;">
                    <div style="font-family:var(--font-display);font-size:1.5rem;font-weight:600;color:var(--color-pink);">10rb+</div>
                    <div style="font-size:0.75rem;color:var(--color-muted);">Undangan Dibuat</div>
                </div>
                <div style="text-align:center;">
                    <div style="font-family:var(--font-display);font-size:1.5rem;font-weight:600;color:var(--color-pink);">100+</div>
                    <div style="font-size:0.75rem;color:var(--color-muted);">Template</div>
                </div>
                <div style="text-align:center;">
                    <div style="font-family:var(--font-display);font-size:1.5rem;font-weight:600;color:var(--color-pink);">4.9★</div>
                    <div style="font-size:0.75rem;color:var(--color-muted);">Rating</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Right form --}}
    <div class="auth-right">
        <div class="auth-form-box">
            <div class="auth-title">Masuk</div>
            <p class="auth-subtitle">Masuk dan kustomisasi undangan pernikahanmu, sesuai apa yang kamu mau.</p>

            @if($errors->any())
            <div class="alert alert-danger" style="display:flex;align-items:flex-start;gap:0.5rem;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;margin-top:1px;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <div>{{ $errors->first() }}</div>
            </div>
            @endif

            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('login') }}" method="POST" id="loginForm">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="email">Alamat Email</label>
                    <input type="email" id="email" name="email" class="form-input" placeholder="nama@email.com" value="{{ old('email') }}" required autocomplete="email">
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div style="position:relative;">
                        <input type="password" id="password" name="password" class="form-input" placeholder="Password kamu (min 8 karakter)" minlength="8" required autocomplete="current-password" style="padding-right:2.75rem;">
                        <button type="button" onclick="togglePassword('password','eyeIcon')" style="position:absolute;right:0.75rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--color-muted);padding:2px;">
                            <svg id="eyeIcon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>

                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;">
                    <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer;font-size:0.825rem;">
                        <input type="checkbox" name="remember" class="form-checkbox">
                        Ingat saya
                    </label>
                    <a href="{{ route('password.request') }}" style="font-size:0.825rem;color:var(--color-pink);text-decoration:none;font-weight:500;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Lupa password?</a>
                </div>

                <button type="submit" class="btn-primary" style="width:100%;padding:0.75rem;font-size:0.9rem;border-radius:10px;">
                    Masuk Sekarang
                </button>
            </form>

            {{-- Auto fill demo button --}}
            <div style="margin-top:1.25rem;padding:1rem;background:#F8F9FA;border-radius:10px;border:1px dashed #E5E7EB;">
                <div style="font-size:0.75rem;font-weight:600;color:var(--color-muted);margin-bottom:0.5rem;text-transform:uppercase;letter-spacing:0.06em;">⚡ Demo Login</div>
                <div style="display:flex;gap:0.5rem;flex-wrap:wrap;">
                    <button type="button" onclick="autoFill('reza@demo.com','user123')" style="padding:0.35rem 0.75rem;background:white;border:1px solid #E5E7EB;border-radius:6px;font-size:0.75rem;cursor:pointer;transition:all 0.2s;" onmouseover="this.style.borderColor='var(--color-pink)';this.style.color='var(--color-pink)'" onmouseout="this.style.borderColor='#E5E7EB';this.style.color='inherit'">
                        👤 User Demo
                    </button>
                    <button type="button" onclick="autoFill('admin@undanganku.com','admin123')" style="padding:0.35rem 0.75rem;background:white;border:1px solid #E5E7EB;border-radius:6px;font-size:0.75rem;cursor:pointer;transition:all 0.2s;" onmouseover="this.style.borderColor='var(--color-pink)';this.style.color='var(--color-pink)'" onmouseout="this.style.borderColor='#E5E7EB';this.style.color='inherit'">
                        🛡️ Admin
                    </button>
                </div>
            </div>

            <div style="text-align:center;margin-top:1.5rem;font-size:0.875rem;color:var(--color-muted);">
                Belum punya akun?
                <a href="{{ route('register') }}" style="color:var(--color-pink);font-weight:600;text-decoration:none;margin-left:0.25rem;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Daftar sekarang</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    input.type = input.type === 'password' ? 'text' : 'password';
}
function autoFill(email, pass) {
    document.getElementById('email').value = email;
    document.getElementById('password').value = pass;
    document.getElementById('email').dispatchEvent(new Event('input'));
}
</script>
@endpush
