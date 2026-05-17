@extends('layouts.app')

@section('title', 'Lupa Password - UndanganKu')
@section('meta_description', 'Reset password akun UndanganKu kamu via email.')

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

.info-card {
    background: white; border-radius: 12px;
    padding: 0.85rem 1rem;
    display: flex; align-items: center; gap: 0.75rem;
    font-size: 0.82rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}

.divider {
    display: flex; align-items: center; gap: 0.75rem;
    margin: 1.25rem 0;
}
.divider::before, .divider::after {
    content: ''; flex: 1; height: 1px; background: #E5E7EB;
}
.divider span { font-size: 0.75rem; color: #9CA3AF; }

.btn-wa {
    width: 100%; padding: 0.75rem;
    font-size: 0.875rem; border-radius: 10px;
    display: flex; align-items: center; justify-content: center; gap: 0.6rem;
    background: #25D366; color: white;
    text-decoration: none; font-weight: 600;
    border: none; cursor: pointer;
    transition: opacity 0.2s;
    margin-bottom: 1.5rem;
}
.btn-wa:hover { opacity: 0.88; color: white; }

@keyframes spin { to { transform: rotate(360deg); } }
.spinner { animation: spin 0.8s linear infinite; display: none; }

@media (max-width: 768px) {
    .auth-wrapper { grid-template-columns: 1fr; }
    .auth-left { display: none; }
    .auth-right { padding: 2rem 1.5rem; }
}
</style>
@endpush

@section('content')
<div class="auth-wrapper">

    {{-- Left decoration --}}
    <div class="auth-left">
        <div style="position:relative;z-index:1;text-align:center;max-width:380px;">
            <div style="font-size:5rem;margin-bottom:1.5rem;">🔑</div>
            <h2 style="font-family:var(--font-display);font-size:1.75rem;font-weight:600;margin-bottom:1rem;line-height:1.3;">
                Lupa password?<br>Tenang, kami bantu
            </h2>
            <p style="color:var(--color-muted);font-size:0.875rem;line-height:1.7;">
                Masukkan email yang kamu daftarkan. Kami kirimkan link untuk membuat password baru langsung ke inbox kamu.
            </p>
            <div style="margin-top:2rem;display:flex;flex-direction:column;gap:0.75rem;text-align:left;">
                <div class="info-card"><span style="font-size:1.25rem;">📧</span><span>Link dikirim ke email kamu</span></div>
                <div class="info-card"><span style="font-size:1.25rem;">⏱️</span><span>Link berlaku selama 60 menit</span></div>
                <div class="info-card"><span style="font-size:1.25rem;">🔒</span><span>Langsung login setelah reset</span></div>
            </div>
        </div>
    </div>

    {{-- Right form --}}
    <div class="auth-right">
        <div class="auth-form-box">
            <div class="auth-title">Lupa Password?</div>
            <p class="auth-subtitle">Masukkan emailmu dan kami kirimkan link reset password.</p>

            {{-- Success --}}
            @if (session('status'))
            <div class="alert alert-success" style="display:flex;align-items:flex-start;gap:0.6rem;margin-bottom:1.5rem;">
                <span style="font-size:1.1rem;flex-shrink:0;">✅</span>
                <div>
                    <div style="font-weight:600;margin-bottom:0.2rem;">Email terkirim!</div>
                    <div style="font-size:0.82rem;">{{ session('status') }}</div>
                </div>
            </div>
            @endif

            {{-- Error --}}
            @if ($errors->any())
            <div class="alert alert-danger" style="display:flex;align-items:center;gap:0.5rem;margin-bottom:1.25rem;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" id="resetForm">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="email">Alamat Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-input {{ $errors->has('email') ? 'error' : '' }}"
                        placeholder="nama@email.com"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                    >
                </div>

                <button type="submit" id="submitBtn" class="btn-primary" style="width:100%;padding:0.75rem;font-size:0.9rem;border-radius:10px;margin-bottom:1.25rem;">
                    <svg id="btnSpinner" class="spinner" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg>
                    <span id="btnText">📧 &nbsp; Kirim Link Reset Password</span>
                </button>
            </form>

            <div class="divider"><span>atau</span></div>

            <a href="https://wa.me/{{ env('ADMIN_WHATSAPP', '6289514392694') }}?text={{ urlencode('Halo admin UndanganKu, saya butuh bantuan reset password akun saya. Email: ' . old('email', '...')) }}"
               target="_blank" class="btn-wa">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                Chat Admin via WhatsApp
            </a>

            <div style="text-align:center;font-size:0.875rem;color:var(--color-muted);">
                Ingat password?
                <a href="{{ route('login') }}" style="color:var(--color-pink);font-weight:600;text-decoration:none;margin-left:0.25rem;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">Kembali Login</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('resetForm').addEventListener('submit', function () {
    const btn    = document.getElementById('submitBtn');
    const txt    = document.getElementById('btnText');
    const spin   = document.getElementById('btnSpinner');
    btn.disabled = true;
    txt.style.display  = 'none';
    spin.style.display = 'inline-block';
    btn.style.opacity  = '0.75';
});
</script>
@endpush
