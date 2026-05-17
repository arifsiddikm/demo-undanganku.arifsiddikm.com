@extends('layouts.app')
@section('title', 'Portfolio - UndanganKu')
@section('meta_description', 'Lihat koleksi undangan digital pernikahan cantik yang telah dibuat oleh ribuan pasangan Indonesia.')

@section('content')
{{-- HERO --}}
<div style="padding:7rem 1.5rem 4rem;text-align:center;background:linear-gradient(160deg,#FDF2F8 0%,#EFF6FF 100%);">
    <div style="font-size:0.72rem;font-weight:700;letter-spacing:0.2em;text-transform:uppercase;color:var(--color-pink);margin-bottom:0.75rem;">Portfolio</div>
    <h1 style="font-family:var(--font-display);font-size:clamp(2rem,5vw,3rem);font-weight:500;margin-bottom:1rem;line-height:1.2;">Karya Undangan Digital<br>yang Sudah Kami Buat</h1>
    <p style="font-size:0.95rem;color:var(--color-muted);max-width:500px;margin:0 auto;">Temukan inspirasi dari ribuan undangan digital cantik yang telah dibuat bersama UndanganKu.</p>
</div>

{{-- PORTFOLIO GRID --}}
<div style="max-width:1100px;margin:0 auto;padding:3rem 1.5rem;">
    @if($portfolios->count() > 0)
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:1.5rem;">
        @foreach($portfolios as $p)
        <div style="border-radius:16px;overflow:hidden;background:white;box-shadow:0 2px 16px rgba(0,0,0,0.06);transition:transform 0.2s,box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 8px 32px rgba(0,0,0,0.12)'" onmouseout="this.style.transform='';this.style.boxShadow='0 2px 16px rgba(0,0,0,0.06)'">
            <div style="aspect-ratio:4/3;background:linear-gradient(135deg,#FDF2F8,#EFF6FF);overflow:hidden;position:relative;">
                @if($p->photo)
                <img src="{{ str_starts_with($p->photo,'http') ? $p->photo : asset('storage/'.$p->photo) }}" alt="{{ $p->couple_name }}" style="width:100%;height:100%;object-fit:cover;">
                @else
                <div style="display:flex;align-items:center;justify-content:center;height:100%;font-size:3rem;">💍</div>
                @endif
                @if($p->package_name)
                <span style="position:absolute;top:0.6rem;right:0.6rem;background:rgba(0,0,0,0.5);color:white;font-size:0.65rem;font-weight:600;padding:0.2rem 0.5rem;border-radius:4px;backdrop-filter:blur(4px);">{{ $p->package_name }}</span>
                @endif
            </div>
            <div style="padding:1rem;">
                <div style="font-family:var(--font-display);font-size:1.1rem;font-weight:500;margin-bottom:0.25rem;">{{ $p->couple_name }}</div>
                @if($p->rating)
                <div style="margin-bottom:0.6rem;">
                    @for($i=1;$i<=5;$i++)
                    <span style="color:{{ $i<=$p->rating?'#F59E0B':'#E5E7EB' }};font-size:0.85rem;">★</span>
                    @endfor
                </div>
                @endif
                @if($p->testimonial)
                <p style="font-size:0.8rem;color:var(--color-muted);line-height:1.6;margin-bottom:0.75rem;font-style:italic;">"{{ Str::limit($p->testimonial, 100) }}"</p>
                @endif
                @if($p->demo_url)
                <a href="{{ $p->demo_url }}" target="_blank" class="btn-outline btn-sm" style="width:100%;justify-content:center;">Lihat Undangan →</a>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($portfolios->hasPages())
    <div style="margin-top:2rem;text-align:center;">{{ $portfolios->links() }}</div>
    @endif

    @else
    <div style="text-align:center;padding:4rem 1rem;">
        <div style="font-size:4rem;margin-bottom:1rem;">💍</div>
        <h3 style="font-family:var(--font-display);font-size:1.5rem;font-weight:500;margin-bottom:0.75rem;">Portfolio Segera Hadir</h3>
        <p style="font-size:0.9rem;color:var(--color-muted);margin-bottom:1.5rem;">Jadilah yang pertama membuat undangan digital bersama kami!</p>
        <a href="{{ route('register') }}" class="btn-primary">Mulai Sekarang</a>
    </div>
    @endif
</div>

{{-- TESTIMONIALS --}}
@if($testimonials->count() > 0)
<div style="background:#FDF2F8;padding:4rem 0;overflow:hidden;">
    <div style="text-align:center;margin-bottom:2.5rem;">
        <div style="font-size:0.72rem;font-weight:700;letter-spacing:0.2em;text-transform:uppercase;color:var(--color-pink);margin-bottom:0.5rem;">Testimoni</div>
        <h2 style="font-family:var(--font-display);font-size:2rem;font-weight:500;">Apa Kata Mereka?</h2>
    </div>
    <style>
    .pf-marquee-wrap{overflow:hidden;-webkit-mask:linear-gradient(90deg,transparent,white 8%,white 92%,transparent);mask:linear-gradient(90deg,transparent,white 8%,white 92%,transparent)}
    .pf-marquee-track{display:flex;gap:1.25rem;width:max-content;animation:pf-marquee 28s linear infinite}
    .pf-marquee-track:hover{animation-play-state:paused}
    @keyframes pf-marquee{0%{transform:translateX(0)}100%{transform:translateX(-50%)}}
    .pf-tcard{background:white;border-radius:16px;padding:1.5rem;width:300px;flex-shrink:0;box-shadow:0 2px 12px rgba(244,114,182,.08);}
    </style>
    <div class="pf-marquee-wrap">
        <div class="pf-marquee-track">
            @php $tArr = $testimonials->toArray(); $doubled = array_merge($tArr,$tArr); @endphp
            @foreach($doubled as $t)
            @php $t = (object)$t; @endphp
            <div class="pf-tcard">
                <div style="margin-bottom:0.6rem;color:#F59E0B;font-size:.9rem;">{{ str_repeat('★', $t->rating ?? 5) }}</div>
                <p style="font-size:0.82rem;line-height:1.7;color:var(--color-muted);margin-bottom:0.85rem;font-style:italic;">"{{ $t->content }}"</p>
                <div style="display:flex;align-items:center;gap:0.6rem;">
                    <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#F472B6,#93C5FD);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:0.8rem;flex-shrink:0;">{{ strtoupper(substr($t->name,0,1)) }}</div>
                    <div>
                        <div style="font-weight:600;font-size:0.82rem;">{{ $t->name }}</div>
                        @if(!empty($t->couple))<div style="font-size:0.72rem;color:var(--color-pink);">{{ $t->couple }}</div>@endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- CTA --}}
<div style="padding:4rem 1.5rem;text-align:center;background:linear-gradient(135deg,#1F2937,#374151);">
    <h2 style="font-family:var(--font-display);font-size:2rem;font-weight:500;color:white;margin-bottom:0.75rem;">Siap Membuat Undangan Digital?</h2>
    <p style="font-size:0.9rem;color:rgba(255,255,255,0.6);margin-bottom:1.5rem;">Bergabung dan buat undangan impianmu sekarang. Gratis untuk dicoba!</p>
    <a href="{{ route('register') }}" class="btn-primary" style="padding:0.8rem 2rem;font-size:0.95rem;">Mulai Gratis Sekarang ✨</a>
</div>
@endsection
