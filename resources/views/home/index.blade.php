@extends('layouts.app')

@section('title', 'UndanganKu - Undangan Digital Pernikahan Online Terpercaya')
@section('meta_description', 'Buat undangan pernikahan digital yang cantik, modern dan mudah dibagikan. Template premium, fitur RSVP, galeri foto, love story. Mulai dari Rp 75.000.')
@section('meta_keywords', 'undangan digital, undangan pernikahan online, undangan nikah digital, wedding invitation online, undangan digital murah, undanganku')

@push('styles')
<style>
    /* HERO */
    .hero-section {
        min-height: 100vh;
        background: linear-gradient(160deg, #FFF5FB 0%, #EFF6FF 50%, #FDF2F8 100%);
        display: flex; align-items: center; padding-top: 4rem;
        position: relative; overflow: hidden;
    }
    .hero-section::before {
        content: '';
        position: absolute; top: -20%; right: -10%;
        width: 60vw; height: 60vw;
        background: radial-gradient(circle, rgba(244,114,182,0.08) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .hero-section::after {
        content: '';
        position: absolute; bottom: -10%; left: -5%;
        width: 40vw; height: 40vw;
        background: radial-gradient(circle, rgba(147,197,253,0.1) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }
    .hero-title {
        font-family: var(--font-display);
        font-size: clamp(2.5rem, 6vw, 4.5rem);
        font-weight: 600; line-height: 1.1;
        letter-spacing: -0.02em;
    }
    .hero-title .accent { color: var(--color-pink); }
    .hero-badge {
        display: inline-flex; align-items: center; gap: 0.4rem;
        background: rgba(244,114,182,0.1);
        color: var(--color-pink);
        font-size: 0.8rem; font-weight: 500;
        padding: 0.35rem 0.85rem; border-radius: 9999px;
        border: 1px solid rgba(244,114,182,0.25);
        margin-bottom: 1rem;
    }
    .hero-badge .dot {
        width: 6px; height: 6px;
        background: var(--color-pink); border-radius: 50%;
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0%,100% { opacity:1; transform: scale(1); }
        50% { opacity:0.5; transform: scale(0.8); }
    }
    .hero-stats {
        display: flex; gap: 2rem; flex-wrap: wrap;
        padding-top: 2rem; margin-top: 2rem;
        border-top: 1px solid rgba(244,114,182,0.15);
    }
    .hero-stat-num {
        font-family: var(--font-display);
        font-size: 1.75rem; font-weight: 600;
        color: var(--color-text); line-height: 1;
    }
    .hero-stat-num span { color: var(--color-pink); }
    .hero-stat-label { font-size: 0.8rem; color: var(--color-muted); margin-top: 0.2rem; }

    /* Mock phone preview */
    .phone-mockup {
        position: relative; display: inline-block;
        filter: drop-shadow(0 24px 64px rgba(244,114,182,0.25));
    }
    .phone-frame {
        width: 260px; background: #1F2937;
        border-radius: 36px; padding: 12px;
        box-shadow: inset 0 0 0 2px #374151;
        position: relative;
    }
    .phone-screen {
        border-radius: 28px; overflow: hidden;
        background: linear-gradient(160deg, #FFF5FB, #EFF6FF);
        min-height: 480px;
        position: relative;
    }
    .phone-notch {
        width: 80px; height: 20px; background: #1F2937;
        border-radius: 0 0 14px 14px;
        margin: 0 auto 0.75rem;
    }

    /* Feature cards */
    .feature-card {
        background: white; border-radius: 16px; padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid #F3F4F6;
        transition: transform 0.25s, box-shadow 0.25s;
    }
    .feature-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(244,114,182,0.12);
        border-color: rgba(244,114,182,0.2);
    }
    .feature-icon {
        width: 48px; height: 48px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 1rem;
        font-size: 1.5rem;
    }

    /* Template cards */
    .template-card {
        background: white; border-radius: 16px; overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        border: 1.5px solid transparent;
        transition: all 0.3s;
        cursor: pointer;
    }
    .template-card:hover {
        border-color: var(--color-pink);
        transform: translateY(-6px);
        box-shadow: 0 16px 40px rgba(244,114,182,0.18);
    }
    .template-thumb {
        width: 100%; aspect-ratio: 9/16; max-height: 280px; object-fit: cover;
        background: linear-gradient(160deg, #FDF2F8, #EFF6FF);
        display: flex; align-items: center; justify-content: center;
        font-size: 3rem;
    }

    /* Pricing */
    .pricing-card {
        background: white; border-radius: 20px; padding: 2rem;
        border: 1.5px solid #E5E7EB;
        transition: all 0.3s; position: relative;
        overflow: hidden;
    }
    .pricing-card.popular {
        border-color: var(--color-pink);
        box-shadow: 0 8px 32px rgba(244,114,182,0.18);
    }
    .pricing-card.popular::before {
        content: '⭐ Paling Populer';
        position: absolute; top: 1rem; right: -2rem;
        background: var(--color-pink); color: white;
        font-size: 0.7rem; font-weight: 600;
        padding: 0.35rem 3rem; border-radius: 2px;
        transform: rotate(45deg); letter-spacing: 0.05em;
    }
    .pricing-card:hover:not(.popular) {
        border-color: rgba(244,114,182,0.4);
        box-shadow: 0 8px 32px rgba(244,114,182,0.1);
    }
    .pricing-price {
        font-family: var(--font-display);
        font-size: 2.5rem; font-weight: 600;
        color: var(--color-text); line-height: 1;
    }
    .pricing-price .currency { font-size: 1.25rem; vertical-align: top; margin-top: 0.4rem; display: inline-block; }

    /* Steps (cara pakai) */
    .step-number {
        width: 40px; height: 40px; border-radius: 50%;
        background: linear-gradient(135deg, #F472B6, #EC4899);
        color: white; font-weight: 700; font-size: 1rem;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(244,114,182,0.35);
    }

    /* Testimonials */
    .testimonial-card {
        background: white; border-radius: 16px; padding: 1.5rem;
        border: 1px solid #F3F4F6;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .stars { color: #F59E0B; letter-spacing: 0.1em; }

    /* FAQ */
    .faq-item {
        background: white; border-radius: 12px; overflow: hidden;
        border: 1px solid #F3F4F6; margin-bottom: 0.75rem;
    }
    .faq-question {
        padding: 1rem 1.25rem; cursor: pointer;
        font-weight: 500; font-size: 0.95rem;
        display: flex; justify-content: space-between; align-items: center;
        transition: background 0.2s;
    }
    .faq-question:hover { background: #FDF2F8; }
    .faq-answer {
        padding: 0 1.25rem; max-height: 0; overflow: hidden;
        transition: max-height 0.3s ease, padding 0.3s;
        font-size: 0.875rem; color: var(--color-muted); line-height: 1.7;
    }
    .faq-item.open .faq-answer { max-height: 200px; padding: 0 1.25rem 1rem; }
    .faq-icon { transition: transform 0.3s; flex-shrink: 0; }
    .faq-item.open .faq-icon { transform: rotate(180deg); }

    /* Section backgrounds */
    .section-alt { background: linear-gradient(160deg, #FFF5FB 0%, #EFF6FF 100%); }

    .animate-float {
        animation: floatAnim 6s ease-in-out infinite;
    }
    @keyframes floatAnim {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-12px); }
    }
</style>
@endpush

@section('content')

{{-- ============================================================
     HERO SECTION
============================================================ --}}
<section class="hero-section">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="relative z-10">
                <div class="hero-badge">
                    <span class="dot"></span>
                    Lebih dari 10.000+ undangan dibuat
                </div>
                <h1 class="hero-title mb-5">
                    Buat Undangan<br>
                    Pernikahan Digital<br>
                    <span class="accent">Yang Memukau ✨</span>
                </h1>
                <p class="section-sub mb-8" style="max-width:480px;">
                    Undangan digital cantik, modern, dan mudah dibagikan ke seluruh keluarga & tamu. Pilih dari ratusan template premium, sesuaikan dengan selera, dan bagikan dalam hitungan menit.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('register') }}" class="btn-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                        Buat Undangan Gratis
                    </a>
                    <a href="{{ route('templates.index') }}" class="btn-outline">
                        Lihat Template
                    </a>
                </div>

                <div class="hero-stats">
                    <div>
                        <div class="hero-stat-num">10rb<span>+</span></div>
                        <div class="hero-stat-label">Undangan dibuat</div>
                    </div>
                    <div>
                        <div class="hero-stat-num">{{ $templateCount ?? 3 }}<span>+</span></div>
                        <div class="hero-stat-label">Template tersedia</div>
                    </div>
                    <div>
                        <div class="hero-stat-num">4.9<span>★</span></div>
                        <div class="hero-stat-label">Rating pengguna</div>
                    </div>
                </div>
            </div>

            {{-- Phone Mockup --}}
            <div class="hidden lg:flex justify-center items-center relative">
                <div class="phone-mockup animate-float">
                    <div class="phone-frame">
                        <div class="phone-screen">
                            <div class="phone-notch"></div>
                            <div style="text-align:center;padding:1rem 1rem 0;font-family:var(--font-display);font-size:0.85rem;color:#9CA3AF;">~ Undangan Pernikahan ~</div>
                            <div style="text-align:center;padding:0.5rem 1rem;font-family:var(--font-display);font-size:1.4rem;color:var(--color-text);font-weight:600;line-height:1.3;">Ikhwan<br>&amp;<br>Akhwat</div>
                            <div style="display:flex;justify-content:center;margin:0.5rem 0;">
                                <div style="width:40px;height:1px;background:var(--color-pink)"></div>
                            </div>
                            <div style="text-align:center;padding:0 1rem;font-size:0.7rem;color:var(--color-muted);">Sabtu, 15 Juni 2025<br>Ballroom Grand Hyatt Jakarta</div>
                            <div style="margin:1rem;background:linear-gradient(135deg,#FDF2F8,#EFF6FF);border-radius:12px;padding:0.75rem;text-align:center;">
                                <div style="font-size:0.65rem;color:var(--color-muted);margin-bottom:0.25rem;">Waktu tersisa</div>
                                <div style="font-family:var(--font-display);font-size:1.2rem;color:var(--color-pink);font-weight:600;">48 : 12 : 35</div>
                            </div>
                            <div style="margin:0 1rem;display:grid;grid-template-columns:1fr 1fr;gap:0.5rem;">
                                <div style="background:var(--color-pink);color:white;border-radius:8px;padding:0.5rem;text-align:center;font-size:0.65rem;font-weight:600;">💌 Konfirmasi</div>
                                <div style="background:white;border:1px solid var(--color-pink);color:var(--color-pink);border-radius:8px;padding:0.5rem;text-align:center;font-size:0.65rem;font-weight:600;">🗺️ Peta</div>
                            </div>
                            <div style="text-align:center;margin:1rem;font-size:0.65rem;color:var(--color-muted);">✨ Dibuat dengan UndanganKu</div>
                        </div>
                    </div>
                </div>

                {{-- Floating decorations --}}
                <div style="position:absolute;top:-1rem;right:2rem;background:white;border-radius:12px;padding:0.75rem 1rem;box-shadow:0 4px 20px rgba(244,114,182,0.2);font-size:0.75rem;font-weight:500;border:1px solid rgba(244,114,182,0.15);">
                    💍 RSVP Online
                </div>
                <div style="position:absolute;bottom:3rem;left:-1rem;background:white;border-radius:12px;padding:0.75rem 1rem;box-shadow:0 4px 20px rgba(147,197,253,0.2);font-size:0.75rem;font-weight:500;border:1px solid rgba(147,197,253,0.2);">
                    🎵 Musik Latar
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     ABOUT
============================================================ --}}
<section style="padding: 5rem 0;" id="tentang">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <div class="section-tag">Tentang Kami</div>
                <h2 class="section-title mb-4">Kenapa Pilih <span>UndanganKu?</span></h2>
                <p class="section-sub mb-6">
                    UndanganKu hadir untuk membantu pasangan Indonesia membuat undangan pernikahan digital yang cantik, personal, dan mudah dibagikan — tanpa perlu keahlian desain apapun.
                </p>
                <div style="display:flex;flex-direction:column;gap:1rem;">
                    <div style="display:flex;align-items:flex-start;gap:0.75rem;">
                        <div style="width:32px;height:32px;background:rgba(244,114,182,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#F472B6" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                        </div>
                        <div>
                            <div style="font-weight:600;font-size:0.9rem;margin-bottom:0.15rem;">Edit Mudah, Hasil Profesional</div>
                            <div style="font-size:0.825rem;color:var(--color-muted);">Antarmuka drag & drop yang intuitif, siapapun bisa membuat undangan cantik dalam menit.</div>
                        </div>
                    </div>
                    <div style="display:flex;align-items:flex-start;gap:0.75rem;">
                        <div style="width:32px;height:32px;background:rgba(147,197,253,0.15);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#60A5FA" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                        </div>
                        <div>
                            <div style="font-weight:600;font-size:0.9rem;margin-bottom:0.15rem;">Berbagi Instan via WhatsApp</div>
                            <div style="font-size:0.825rem;color:var(--color-muted);">Dapatkan link unik, langsung bisa dibagikan ke semua kontak tanpa perlu instal aplikasi apapun.</div>
                        </div>
                    </div>
                    <div style="display:flex;align-items:flex-start;gap:0.75rem;">
                        <div style="width:32px;height:32px;background:rgba(244,114,182,0.1);border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px;">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#F472B6" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                        </div>
                        <div>
                            <div style="font-weight:600;font-size:0.9rem;margin-bottom:0.15rem;">RSVP & Manajemen Tamu Online</div>
                            <div style="font-size:0.825rem;color:var(--color-muted);">Kelola konfirmasi kehadiran, ucapan, dan daftar tamu semuanya dalam satu dashboard.</div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="feature-card">
                    <div class="feature-icon" style="background:#FDF2F8;">🎨</div>
                    <div style="font-weight:600;font-size:0.9rem;margin-bottom:0.35rem;">100+ Template</div>
                    <div style="font-size:0.8rem;color:var(--color-muted);">Pilih dari koleksi template premium yang terus diperbarui</div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon" style="background:#EFF6FF;">💌</div>
                    <div style="font-weight:600;font-size:0.9rem;margin-bottom:0.35rem;">RSVP Digital</div>
                    <div style="font-size:0.8rem;color:var(--color-muted);">Konfirmasi kehadiran tamu secara online real-time</div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon" style="background:#FDF2F8;">🎵</div>
                    <div style="font-weight:600;font-size:0.9rem;margin-bottom:0.35rem;">Musik Latar</div>
                    <div style="font-size:0.8rem;color:var(--color-muted);">Upload musik favorit sebagai latar belakang undangan</div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon" style="background:#EFF6FF;">📸</div>
                    <div style="font-weight:600;font-size:0.9rem;margin-bottom:0.35rem;">Galeri Foto</div>
                    <div style="font-size:0.8rem;color:var(--color-muted);">Tampilkan momen indah dengan galeri foto yang elegan</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     HOW IT WORKS - ANIMATED
============================================================ --}}
<section class="section-alt" style="padding:5rem 0;" id="cara-pakai">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div style="text-align:center;margin-bottom:3.5rem;">
            <div class="section-tag">Cara Kerja</div>
            <h2 class="section-title">Mudah &amp; <span>Menyenangkan!</span></h2>
            <p class="section-sub" style="margin:0.75rem auto 0;">Dari pilih template sampai link aktif — simpel, cepat, dan seru.</p>
        </div>
        <style>
        .ck-steps{display:flex;flex-direction:column;gap:1rem}
        .ck-step{display:flex;align-items:flex-start;gap:1rem;padding:1rem 1.25rem;border-radius:14px;cursor:pointer;border:2px solid transparent;transition:all .3s;position:relative}
        .ck-step.active{background:white;border-color:rgba(244,114,182,.3);box-shadow:0 4px 20px rgba(244,114,182,.1)}
        .ck-step-num{width:44px;height:44px;border-radius:50%;background:#F3F4F6;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:.85rem;color:#9CA3AF;flex-shrink:0;transition:all .3s}
        .ck-step.active .ck-step-num{background:linear-gradient(135deg,#F472B6,#A78BFA);color:white}
        .ck-step-label{font-size:.65rem;font-weight:700;letter-spacing:.15em;text-transform:uppercase;margin-bottom:.2rem;transition:color .3s}
        .ck-step.active .ck-step-label{color:var(--color-pink)}
        .ck-step-title{font-weight:700;font-size:.95rem;margin-bottom:.25rem}
        .ck-step-desc{font-size:.82rem;color:var(--color-muted);line-height:1.6}
        .ck-connector{width:2px;height:20px;background:#E5E7EB;margin-left:1.35rem}
        .ck-preview-box{background:white;border-radius:20px;padding:1.75rem;border:1px solid #F3F4F6;box-shadow:0 8px 32px rgba(0,0,0,.08);min-height:320px;display:flex;align-items:center;justify-content:center;transition:all .4s;position:relative;overflow:hidden}
        .ck-preview-content{text-align:center;transition:all .3s}
        .ck-preview-content .icon{font-size:4rem;margin-bottom:1rem;display:block}
        .ck-progress{height:3px;background:#F3F4F6;border-radius:2px;margin-top:1.5rem;overflow:hidden}
        .ck-progress-bar{height:100%;background:linear-gradient(90deg,#F472B6,#A78BFA);border-radius:2px;transition:width .4s ease}
        @media(min-width:768px){.ck-wrap{display:grid;grid-template-columns:1fr 1fr;gap:3rem;align-items:start}}
        </style>
        <div class="ck-wrap">
            <div>
                <div class="ck-steps">
                    @php
                    $steps = [
                        ['num'=>'1','label'=>'LANGKAH 1','title'=>'Daftar & Pilih Paket','desc'=>'Buat akun gratis, pilih paket undangan sesuai kebutuhan (Basic, Premium, atau Luxury), dan lakukan pembayaran.','icon'=>'📝','preview_title'=>'Pilih Paket Kamu','preview_desc'=>'Basic mulai Rp 75.000 | Premium Rp 150.000 | Luxury Rp 299.000'],
                        ['num'=>'2','label'=>'LANGKAH 2','title'=>'Pilih Template Favoritmu','desc'=>'Browsing koleksi template cantik kami dan pilih yang sesuai gaya pernikahanmu. Bisa ganti sewaktu-waktu!','icon'=>'🎨','preview_title'=>'3 Kategori Template','preview_desc'=>'Basic · Premium · Luxury — semua desain profesional'],
                        ['num'=>'3','label'=>'LANGKAH 3','title'=>'Isi & Personalisasi','desc'=>'Masukkan nama, foto, detail acara, love story, musik latar, daftar tamu, dan lainnya. Semua real-time preview!','icon'=>'✏️','preview_title'=>'Editor Real-time','preview_desc'=>'Langsung lihat perubahan di preview tanpa reload'],
                        ['num'=>'4','label'=>'LANGKAH 4','title'=>'Publish & Bagikan','desc'=>'Aktifkan link undangan dan bagikan ke tamu via WhatsApp dengan nama tamu otomatis. Pantau RSVP & ucapan.','icon'=>'🚀','preview_title'=>'Link Undangan Aktif','preview_desc'=>'undanganku.com/nama-kalian?untuk=Nama+Tamu'],
                    ];
                    @endphp
                    @foreach($steps as $i => $s)
                    <div class="ck-step {{ $i===0?'active':'' }}" id="ck-step-{{ $i }}" onclick="activateStep({{ $i }})">
                        <div class="ck-step-num">{{ $s['num'] }}</div>
                        <div>
                            <div class="ck-step-label">{{ $s['label'] }}</div>
                            <div class="ck-step-title">{{ $s['title'] }}</div>
                            <div class="ck-step-desc">{{ $s['desc'] }}</div>
                        </div>
                    </div>
                    @if($i < count($steps)-1)<div class="ck-connector"></div>@endif
                    @endforeach
                </div>
            </div>
            <div>
                <div class="ck-preview-box" id="ck-preview">
                    @foreach($steps as $i => $s)
                    <div class="ck-preview-content" id="ck-preview-{{ $i }}" style="{{ $i>0?'display:none':'' }}">
                        <span class="icon">{{ $s['icon'] }}</span>
                        <div style="font-weight:700;font-size:1.1rem;margin-bottom:.5rem">{{ $s['preview_title'] }}</div>
                        <p style="font-size:.85rem;color:var(--color-muted)">{{ $s['preview_desc'] }}</p>
                        <div style="margin-top:1.5rem;padding:.75rem;background:#FDF2F8;border-radius:10px;font-size:.78rem;color:#BE185D">Langkah {{ $i+1 }} dari 4</div>
                    </div>
                    @endforeach
                </div>
                <div class="ck-progress" style="margin-top:1.25rem"><div class="ck-progress-bar" id="ck-progress-bar" style="width:25%"></div></div>
            </div>
        </div>
    </div>
</section>
@push('scripts')
<script>
let ckTimer, ckCurrent = 0;
const ckTotal = 4;
function activateStep(i) {
    clearInterval(ckTimer);
    setStep(i);
    ckTimer = setInterval(() => { ckCurrent = (ckCurrent+1)%ckTotal; setStep(ckCurrent); }, 3000);
}
function setStep(i) {
    ckCurrent = i;
    document.querySelectorAll('.ck-step').forEach((el,j) => el.classList.toggle('active', j===i));
    document.querySelectorAll('.ck-preview-content').forEach((el,j) => el.style.display = j===i?'block':'none');
    document.getElementById('ck-progress-bar').style.width = ((i+1)/ckTotal*100)+'%';
}
ckTimer = setInterval(() => { ckCurrent = (ckCurrent+1)%ckTotal; setStep(ckCurrent); }, 3000);
</script>
@endpush

{{-- ============================================================
     TEMPLATES PREVIEW
============================================================ --}}
<section style="padding:5rem 0;" id="template">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div style="text-align:center;margin-bottom:3rem;">
            <div class="section-tag">Template Pilihan</div>
            <h2 class="section-title">Preset Template <span>Tersedia</span></h2>
            <p class="section-sub" style="margin:0.75rem auto 0;">Mulai dari desain minimalis hingga mewah, semua ada untuk kamu.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($templates ?? [] as $template)
            <div class="template-card">
                <div class="template-thumb" style="background:{{ $template->category === 'basic' ? 'linear-gradient(160deg,#FDF2F8,#FBCFE8)' : ($template->category === 'premium' ? 'linear-gradient(160deg,#EFF6FF,#BFDBFE)' : 'linear-gradient(160deg,#FFF9F0,#FDE68A)') }};">
                    @if($template->thumbnail)
                        <img src="{{ asset($template->thumbnail) }}" alt="{{ $template->name }}" style="width:100%;height:100%;object-fit:cover;">
                    @else
                        <span>💍</span>
                    @endif
                </div>
                <div style="padding:1.25rem;">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.5rem;">
                        <h3 style="font-weight:600;font-size:0.95rem;">{{ $template->name }}</h3>
                        <span class="badge badge-{{ $template->category }}">{{ ucfirst($template->category) }}</span>
                    </div>
                    <p style="font-size:0.8rem;color:var(--color-muted);margin-bottom:1rem;line-height:1.5;">{{ $template->description }}</p>
                    <a href="{{ route('templates.preview', $template->slug) }}" target="_blank" class="btn-outline btn-sm" style="width:100%;justify-content:center;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        Preview Template
                    </a>
                </div>
            </div>
            @empty
            @foreach([['name'=>'Sakura Bloom','cat'=>'basic','icon'=>'🌸','desc'=>'Minimalis nuansa bunga sakura'],['name'=>'Royal Blue','cat'=>'premium','icon'=>'💎','desc'=>'Elegan biru navy dengan sentuhan emas'],['name'=>'Golden Garden','cat'=>'luxury','icon'=>'✨','desc'=>'Mewah dengan animasi bunga dan partikel']] as $t)
            <div class="template-card">
                <div class="template-thumb" style="background:{{ $t['cat']==='basic'?'linear-gradient(160deg,#FDF2F8,#FBCFE8)':($t['cat']==='premium'?'linear-gradient(160deg,#EFF6FF,#BFDBFE)':'linear-gradient(160deg,#FFF9F0,#FDE68A)') }};font-size:4rem;justify-content:center;align-items:center;display:flex;">
                    {{ $t['icon'] }}
                </div>
                <div style="padding:1.25rem;">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:0.5rem;">
                        <h3 style="font-weight:600;font-size:0.95rem;">{{ $t['name'] }}</h3>
                        <span class="badge badge-{{ $t['cat'] }}">{{ ucfirst($t['cat']) }}</span>
                    </div>
                    <p style="font-size:0.8rem;color:var(--color-muted);margin-bottom:1rem;">{{ $t['desc'] }}</p>
                    <a href="{{ route('templates.index') }}" class="btn-outline btn-sm" style="width:100%;justify-content:center;">Lihat Preview</a>
                </div>
            </div>
            @endforeach
            @endforelse
        </div>
        <div style="text-align:center;margin-top:2.5rem;">
            <a href="{{ route('templates.index') }}" class="btn-outline">
                Lihat Semua Template
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- ============================================================
     FEATURES LIST
============================================================ --}}
<section class="section-alt" style="padding:5rem 0;" id="fitur">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div style="text-align:center;margin-bottom:3rem;">
            <div class="section-tag">Fitur Lengkap</div>
            <h2 class="section-title">Semua Yang Kamu <span>Butuhkan</span></h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach([
                ['icon'=>'💍','title'=>'Profil Pasangan','desc'=>'Data lengkap pengantin'],
                ['icon'=>'📅','title'=>'Detail Acara','desc'=>'Akad & Resepsi'],
                ['icon'=>'🗺️','title'=>'Google Maps','desc'=>'Navigasi venue mudah'],
                ['icon'=>'💌','title'=>'RSVP Online','desc'=>'Konfirmasi kehadiran'],
                ['icon'=>'💬','title'=>'Ucapan & Doa','desc'=>'Kirim doa dari mana saja'],
                ['icon'=>'📸','title'=>'Galeri Foto','desc'=>'Album foto digital'],
                ['icon'=>'❤️','title'=>'Love Story','desc'=>'Cerita cinta pasangan'],
                ['icon'=>'🎵','title'=>'Musik Latar','desc'=>'Suasana romantis'],
                ['icon'=>'⏰','title'=>'Countdown Timer','desc'=>'Hitung mundur hari H'],
                ['icon'=>'🎁','title'=>'No. Rekening','desc'=>'Hadiah digital'],
                ['icon'=>'📊','title'=>'Statistik Tamu','desc'=>'Dashboard kehadiran'],
                ['icon'=>'🔗','title'=>'Link Unik','desc'=>'URL personal kamu'],
            ] as $feat)
            <div class="feature-card" style="display:flex;align-items:flex-start;gap:0.75rem;padding:1rem;">
                <div style="font-size:1.5rem;flex-shrink:0;">{{ $feat['icon'] }}</div>
                <div>
                    <div style="font-weight:600;font-size:0.85rem;margin-bottom:0.15rem;">{{ $feat['title'] }}</div>
                    <div style="font-size:0.75rem;color:var(--color-muted);">{{ $feat['desc'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================
     PRICING
============================================================ --}}
<section style="padding:5rem 0;" id="harga">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div style="text-align:center;margin-bottom:3rem;">
            <div class="section-tag">Harga Terjangkau</div>
            <h2 class="section-title">Pilih Paket <span>Sesuai Budget</span></h2>
            <p class="section-sub" style="margin:0.75rem auto 0;">Investasi kecil untuk kenangan pernikahan yang abadi.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($packages ?? [] as $package)
            <div class="pricing-card {{ $package->slug === 'premium' ? 'popular' : '' }}">
                <div style="margin-bottom:1.5rem;">
                    <div class="badge badge-{{ $package->slug }}" style="margin-bottom:0.75rem;">{{ $package->name }}</div>
                    <div class="pricing-price">
                        <span class="currency">Rp</span>{{ number_format($package->price, 0, ',', '.') }}
                    </div>
                    <div style="font-size:0.8rem;color:var(--color-muted);margin-top:0.35rem;">Bayar sekali, aktif selamanya</div>
                </div>
                <p style="font-size:0.85rem;color:var(--color-muted);margin-bottom:1.25rem;line-height:1.6;">{{ $package->description }}</p>
                <ul style="list-style:none;padding:0;margin-bottom:1.5rem;display:flex;flex-direction:column;gap:0.6rem;">
                    @foreach((is_array($package->features) ? $package->features : json_decode($package->features, true)) ?? [] as $feat)
                    <li style="display:flex;align-items:center;gap:0.5rem;font-size:0.825rem;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#F472B6" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        {{ $feat }}
                    </li>
                    @endforeach
                </ul>
                <a href="{{ route('checkout', $package->slug) }}" class="{{ $package->slug === 'premium' ? 'btn-primary' : 'btn-outline' }}" style="width:100%;justify-content:center;">
                    Pilih Paket {{ $package->name }}
                </a>
            </div>
            @empty
            @foreach([
                ['name'=>'Basic','slug'=>'basic','price'=>'75.000','popular'=>false,'feats'=>['Template Basic Pilihan','Profil Pasangan','Detail Acara','Google Maps','RSVP Online','Ucapan & Doa','Countdown Timer','Maks. 100 Tamu']],
                ['name'=>'Premium','slug'=>'premium','price'=>'150.000','popular'=>true,'feats'=>['Semua Fitur Basic','Template Premium Pilihan','Galeri Foto (20 foto)','Musik Latar Custom','Love Story Pengantin','No. Rekening Hadiah','Maks. 500 Tamu','QR Code Undangan']],
                ['name'=>'Luxury','slug'=>'luxury','price'=>'299.000','popular'=>false,'feats'=>['Semua Fitur Premium','Template Luxury Eksklusif','Galeri Foto Unlimited','Link Live Streaming','Animasi Premium','Custom Warna & Font','Tamu Unlimited','Priority Support']],
            ] as $p)
            <div class="pricing-card {{ $p['popular'] ? 'popular' : '' }}">
                <div style="margin-bottom:1.5rem;">
                    <div class="badge badge-{{ $p['slug'] }}" style="margin-bottom:0.75rem;">{{ $p['name'] }}</div>
                    <div class="pricing-price"><span class="currency">Rp</span>{{ $p['price'] }}</div>
                    <div style="font-size:0.8rem;color:var(--color-muted);margin-top:0.35rem;">Bayar sekali, aktif selamanya</div>
                </div>
                <ul style="list-style:none;padding:0;margin-bottom:1.5rem;display:flex;flex-direction:column;gap:0.6rem;">
                    @foreach($p['feats'] as $f)
                    <li style="display:flex;align-items:center;gap:0.5rem;font-size:0.825rem;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#F472B6" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        {{ $f }}
                    </li>
                    @endforeach
                </ul>
                <a href="{{ route('checkout', $p['slug']) }}" class="{{ $p['popular'] ? 'btn-primary' : 'btn-outline' }}" style="width:100%;justify-content:center;">
                    Pilih Paket {{ $p['name'] }}
                </a>
            </div>
            @endforeach
            @endforelse
        </div>
    </div>
</section>

{{-- ============================================================
     PORTFOLIO SECTION (mini)
============================================================ --}}
<section class="section-alt" style="padding:5rem 0;" id="portfolio">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div style="display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:2.5rem;flex-wrap:wrap;gap:1rem;">
            <div>
                <div class="section-tag">Portfolio</div>
                <h2 class="section-title">Mereka Sudah <span>Percaya Kami</span></h2>
            </div>
            <a href="{{ route('portfolio') }}" class="btn-outline btn-sm">Lihat Semua →</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @forelse($portfolios ?? [] as $port)
            <div style="background:white;border-radius:16px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.06);transition:transform 0.25s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="aspect-ratio:3/4;background:linear-gradient(160deg,#FDF2F8,#EFF6FF);overflow:hidden;position:relative;">
                    @if($port->photo)
                    <img src="{{ str_starts_with($port->photo,'http') ? $port->photo : asset('storage/'.$port->photo) }}" alt="{{ $port->couple_name }}" style="width:100%;height:100%;object-fit:cover;">
                    @else
                    <div style="display:flex;align-items:center;justify-content:center;height:100%;font-size:2.5rem;">💍</div>
                    @endif
                    @if($port->package_name)<span style="position:absolute;top:.5rem;right:.5rem;background:rgba(0,0,0,.45);color:white;font-size:.6rem;font-weight:600;padding:.18rem .5rem;border-radius:4px;backdrop-filter:blur(4px);">{{ $port->package_name }}</span>@endif
                </div>
                <div style="padding:0.85rem;">
                    <div style="font-weight:600;font-size:0.875rem;">{{ $port->couple_name }}</div>
                    @if($port->testimonial)<div style="font-size:0.73rem;color:var(--color-muted);margin-top:.2rem;line-height:1.5;">{{ Str::limit($port->testimonial,60) }}</div>@endif
                    @if($port->demo_url)
                    <a href="{{ $port->demo_url }}" target="_blank" style="display:block;margin-top:0.5rem;font-size:0.75rem;color:var(--color-pink);text-decoration:none;font-weight:500;">Lihat Undangan →</a>
                    @endif
                </div>
            </div>
            @empty
            @foreach(['Reza & Vina','Bagas & Rini','Dika & Nona','Eko & Maya'] as $couple)
            <div style="background:white;border-radius:16px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.06);transition:transform 0.25s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="aspect-ratio:3/4;background:linear-gradient(160deg,#FDF2F8,#EFF6FF);display:flex;align-items:center;justify-content:center;font-size:2.5rem;">💍</div>
                <div style="padding:0.85rem;">
                    <div style="font-weight:600;font-size:0.875rem;">{{ $couple }}</div>
                    <div style="font-size:0.75rem;color:var(--color-muted);">Paket Premium</div>
                </div>
            </div>
            @endforeach
            @endforelse
        </div>
    </div>
</section>

{{-- TESTIMONIALS MARQUEE --}}
<section style="padding:5rem 0;overflow:hidden;" id="testimoni">
    <div style="text-align:center;margin-bottom:3rem;">
        <div class="section-tag">Testimoni</div>
        <h2 class="section-title">Kata Mereka Yang <span>Sudah Pakai</span></h2>
    </div>
    @php
    $allT = collect($testimonials ?? []);
    if($allT->count() < 4) {
        $allT = collect([
            (object)['name'=>'Riska & Andika','couple'=>'','content'=>'Undangannya cantik banget! Prosesnya cepet dan mudah. 10/10 recommended!','rating'=>5],
            (object)['name'=>'Bagas & Putri','couple'=>'','content'=>'Template banyak pilihannya, langsung cocok. Admin responsif, hasilnya keren!','rating'=>5],
            (object)['name'=>'Dimas & Nayla','couple'=>'','content'=>'Fitur RSVP-nya berguna banget buat ngitung tamu. Hemat waktu!','rating'=>5],
            (object)['name'=>'Reza & Vina','couple'=>'','content'=>'Desainnya keren dan responsive di HP. Link undangan langsung bisa dishare.','rating'=>5],
        ]);
    }
    @endphp
    <style>
    .marquee-wrap{overflow:hidden;-webkit-mask:linear-gradient(90deg,transparent,white 10%,white 90%,transparent);mask:linear-gradient(90deg,transparent,white 10%,white 90%,transparent)}
    .marquee-track{display:flex;gap:1.25rem;width:max-content;animation:marquee 30s linear infinite}
    .marquee-track:hover{animation-play-state:paused}
    @keyframes marquee{0%{transform:translateX(0)}100%{transform:translateX(-50%)}}
    .tcard{background:white;border-radius:16px;padding:1.25rem;width:280px;flex-shrink:0;border:1px solid #F3F4F6;box-shadow:0 2px 12px rgba(0,0,0,.04)}
    </style>
    <div class="marquee-wrap">
        <div class="marquee-track" id="marqueeTrack">
            @foreach(array_merge($allT->toArray(), $allT->toArray()) as $t)
            <div class="tcard">
                <div style="color:#F59E0B;font-size:.9rem;margin-bottom:.6rem">{{ str_repeat('★', is_object($t) ? $t->rating : $t['rating']) }}</div>
                <p style="font-size:.82rem;color:var(--color-muted);line-height:1.7;margin-bottom:.85rem">"{{ is_object($t) ? $t->content : $t['content'] }}"</p>
                <div style="display:flex;align-items:center;gap:.6rem">
                    <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#F472B6,#93C5FD);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:.8rem;flex-shrink:0">{{ strtoupper(substr(is_object($t)?$t->name:$t['name'],0,1)) }}</div>
                    <div>
                        <div style="font-weight:600;font-size:.82rem">{{ is_object($t) ? $t->name : $t['name'] }}</div>
                        @if(is_object($t) && $t->couple)<div style="font-size:.72rem;color:var(--color-muted)">{{ $t->couple }}</div>@endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================
     FAQ
============================================================ --}}
<section class="section-alt" style="padding:5rem 0;" id="faq">
    <div class="max-w-3xl mx-auto px-4">
        <div style="text-align:center;margin-bottom:3rem;">
            <div class="section-tag">FAQ</div>
            <h2 class="section-title">Pertanyaan Yang <span>Sering Ditanya</span></h2>
        </div>
        @forelse($faqs ?? [] as $faq)
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this.closest('.faq-item'))">
                <span>{{ $faq->question }}</span>
                <svg class="faq-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
            </div>
            <div class="faq-answer">{{ $faq->answer }}</div>
        </div>
        @empty
        @foreach([
            ['q'=>'Berapa lama undangan aktif setelah pembayaran?','a'=>'Undangan digital kamu akan aktif selama 1 tahun setelah pembayaran dikonfirmasi. Paket Luxury aktif selamanya.'],
            ['q'=>'Apakah saya bisa edit undangan setelah dibuat?','a'=>'Ya! Kamu bisa edit undangan kapan saja melalui dashboard. Perubahan langsung terlihat di link undangan kamu.'],
            ['q'=>'Bagaimana cara berbagi link undangan?','a'=>'Setelah undangan dibuat, kamu akan dapat link unik yang bisa dibagikan via WhatsApp, Instagram, atau media sosial lainnya.'],
            ['q'=>'Metode pembayaran apa saja yang tersedia?','a'=>'Kami menerima Midtrans (QRIS, GoPay, Transfer Bank, Kartu Kredit) dan Transfer Bank Manual ke rekening kami.'],
        ] as $f)
        <div class="faq-item">
            <div class="faq-question" onclick="toggleFaq(this.closest('.faq-item'))">
                <span>{{ $f['q'] }}</span>
                <svg class="faq-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
            </div>
            <div class="faq-answer">{{ $f['a'] }}</div>
        </div>
        @endforeach
        @endforelse
    </div>
</section>

{{-- ============================================================
     CTA
============================================================ --}}
<section style="padding:5rem 0;">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <div style="background:linear-gradient(160deg, #FDF2F8, #EFF6FF);border-radius:28px;padding:4rem 2rem;position:relative;overflow:hidden;">
            <div style="position:absolute;top:-2rem;right:-2rem;width:200px;height:200px;background:radial-gradient(circle,rgba(244,114,182,0.12),transparent);border-radius:50%;"></div>
            <div style="position:absolute;bottom:-2rem;left:-2rem;width:160px;height:160px;background:radial-gradient(circle,rgba(147,197,253,0.15),transparent);border-radius:50%;"></div>
            <div style="position:relative;z-index:1;">
                <div style="font-size:2.5rem;margin-bottom:1rem;">💍</div>
                <h2 class="section-title" style="margin-bottom:1rem;">Siap Buat Undangan <span>Impianmu?</span></h2>
                <p class="section-sub" style="margin:0 auto 2rem;">Bergabung dengan ribuan pasangan yang sudah mempercayakan undangan digital mereka ke UndanganKu.</p>
                <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
                    <a href="{{ route('register') }}" class="btn-primary">
                        Mulai Gratis Sekarang ✨
                    </a>
                    <a href="https://wa.me/{{ env('ADMIN_WHATSAPP') }}" target="_blank" class="btn-outline">
                        Tanya Admin WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
function toggleFaq(item) {
    const isOpen = item.classList.contains('open');
    document.querySelectorAll('.faq-item.open').forEach(el => el.classList.remove('open'));
    if (!isOpen) item.classList.add('open');
}
</script>
@endpush
