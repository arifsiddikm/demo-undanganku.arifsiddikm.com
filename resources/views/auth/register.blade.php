@extends('layouts.app')

@section('title', 'Daftar - UndanganKu')
@section('meta_description', 'Daftar akun UndanganKu gratis dan buat undangan digital pernikahanmu sekarang.')

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
    position: absolute; bottom: -20%; left: -20%;
    width: 60%; height: 60%;
    background: radial-gradient(circle, rgba(147,197,253,0.15), transparent 70%);
    border-radius: 50%;
}
.auth-right {
    display: flex; align-items: center; justify-content: center;
    padding: 2rem 3rem; overflow-y: auto;
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

    {{-- Left --}}
    <div class="auth-left">
        <div style="position:relative;z-index:1;text-align:center;max-width:380px;">
            <div style="font-size:5rem;margin-bottom:1.5rem;">💍</div>
            <h2 style="font-family:var(--font-display);font-size:1.75rem;font-weight:600;margin-bottom:1rem;line-height:1.3;">
                Mulai Perjalanan<br><span style="color:var(--color-pink);">Pernikahanmu</span>
            </h2>
            <p style="font-size:0.875rem;color:var(--color-muted);line-height:1.7;margin-bottom:2rem;">
                Bergabung dengan ribuan pasangan Indonesia yang sudah membuat undangan digital cantik bersama kami.
            </p>
            <div style="background:white;border-radius:16px;padding:1.25rem;box-shadow:0 4px 20px rgba(244,114,182,0.1);text-align:left;">
                <div style="font-size:0.75rem;font-weight:600;color:var(--color-muted);margin-bottom:0.75rem;text-transform:uppercase;letter-spacing:0.08em;">Gratis untuk memulai</div>
                @foreach(['Coba buat undangan draft gratis','Pilih template premium pilihan','Edit kapan saja sebelum aktivasi','Bayar setelah puas dengan hasilnya'] as $feat)
                <div style="display:flex;align-items:center;gap:0.5rem;font-size:0.8rem;margin-bottom:0.4rem;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#F472B6" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    {{ $feat }}
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Right form --}}
    <div class="auth-right">
        <div class="auth-form-box">
            <div class="auth-title">Daftar</div>
            <p class="auth-subtitle">Buat akun gratis dan mulai membuat undangan digital impianmu.</p>

            @if($errors->any())
            <div class="alert alert-danger">
                <ul style="margin:0;padding-left:1.1rem;">
                    @foreach($errors->all() as $err)
                    <li style="font-size:0.825rem;">{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" class="form-input" placeholder="Nama lengkap kamu" value="{{ old('name') }}" required autocomplete="name">
                </div>
                <div class="form-group">
                    <label class="form-label" for="email">Alamat Email</label>
                    <input type="email" id="email" name="email" class="form-input" placeholder="nama@email.com" value="{{ old('email') }}" required autocomplete="email">
                </div>
                <div class="form-group">
                    <label class="form-label" for="phone">No. WhatsApp <span style="color:#9CA3AF;font-weight:400;">(opsional)</span></label>
                    <input type="text" id="phone" name="phone" class="form-input" placeholder="08xxxxxxxxxx" value="{{ old('phone') }}" autocomplete="tel">
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div style="position:relative;">
                        <input type="password" id="password" name="password" class="form-input" placeholder="Minimal 8 karakter" required autocomplete="new-password" minlength="8" style="padding-right:2.75rem;">
                        <button type="button" onclick="togglePassword('password')" style="position:absolute;right:0.75rem;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--color-muted);padding:2px;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                    <div id="passwordStrength" style="margin-top:0.35rem;display:none;">
                        <div style="height:3px;border-radius:2px;background:#E5E7EB;overflow:hidden;">
                            <div id="strengthBar" style="height:100%;border-radius:2px;transition:width 0.3s,background 0.3s;width:0%;"></div>
                        </div>
                        <div id="strengthLabel" style="font-size:0.7rem;margin-top:0.2rem;color:var(--color-muted);"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" placeholder="Ulangi password" required autocomplete="new-password" minlength="8">
                </div>

                <div style="display:flex;align-items:flex-start;gap:0.5rem;margin-bottom:1.5rem;">
                    <input type="checkbox" name="agree" id="agree" class="form-checkbox" required style="margin-top:2px;">
                    <label for="agree" style="font-size:0.8rem;color:var(--color-muted);cursor:pointer;line-height:1.5;">
                        Saya menyetujui <a href="#" style="color:var(--color-pink);text-decoration:none;">Syarat & Ketentuan</a> dan <a href="#" style="color:var(--color-pink);text-decoration:none;">Kebijakan Privasi</a> UndanganKu
                    </label>
                </div>

                <button type="submit" class="btn-primary" style="width:100%;padding:0.75rem;font-size:0.9rem;border-radius:10px;">
                    Daftar Sekarang ✨
                </button>
            </form>

            <div style="text-align:center;margin-top:1.5rem;font-size:0.875rem;color:var(--color-muted);">
                Sudah punya akun?
                <a href="{{ route('login') }}" style="color:var(--color-pink);font-weight:600;text-decoration:none;margin-left:0.25rem;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Masuk di sini</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function togglePassword(id) {
    const el = document.getElementById(id);
    el.type = el.type === 'password' ? 'text' : 'password';
}
document.getElementById('password').addEventListener('input', function() {
    const val = this.value;
    const wrap = document.getElementById('passwordStrength');
    const bar = document.getElementById('strengthBar');
    const lbl = document.getElementById('strengthLabel');
    if (!val) { wrap.style.display = 'none'; return; }
    wrap.style.display = 'block';
    let score = 0;
    if (val.length >= 8) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;
    const levels = [
        { w:'25%', bg:'#EF4444', txt:'Lemah' },
        { w:'50%', bg:'#F59E0B', txt:'Cukup' },
        { w:'75%', bg:'#3B82F6', txt:'Kuat' },
        { w:'100%', bg:'#10B981', txt:'Sangat Kuat' },
    ];
    const lvl = levels[Math.max(0, score-1)];
    bar.style.width = lvl.w; bar.style.background = lvl.bg;
    lbl.textContent = lvl.txt; lbl.style.color = lvl.bg;
});
</script>
@endpush
