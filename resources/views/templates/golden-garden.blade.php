<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>{{ $invitation->title ?? 'Undangan Pernikahan' }}</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Gloock:ital@0;1&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --amber:  {{ $invitation->color_primary  ?? '#C49A3C' }};
  --brown:  {{ $invitation->color_secondary ?? '#2C1A0A' }};
  --bg:     #1C1108;
  --bg2:    #251608;
  --bg3:    #2E1D0C;
  --parch:  #F0E4C8;
  --muted:  #9A7E56;
  --faint:  #4A3010;
  --serif:  'Gloock', Georgia, serif;
  --sans:   'Jost', system-ui, sans-serif;
}
html{scroll-behavior:smooth}
body{font-family:var(--sans);background:var(--bg);color:var(--parch);overflow-x:hidden;-webkit-font-smoothing:antialiased}

/* OPENING */
#opening{position:fixed;inset:0;z-index:9999;background:var(--bg);display:flex;align-items:center;justify-content:center;transition:transform .9s cubic-bezier(.76,0,.24,1)}
#opening.away{transform:translateY(-100%)}
.op-frame{
  width:min(360px,90vw);padding:2.5rem 2rem;text-align:center;position:relative;
  border:1px solid rgba(196,154,60,.15);
}
.op-frame::before,.op-frame::after{content:'';position:absolute;width:16px;height:16px;border-color:rgba(196,154,60,.3);border-style:solid}
.op-frame::before{top:-1px;left:-1px;border-width:1px 0 0 1px}
.op-frame::after{bottom:-1px;right:-1px;border-width:0 1px 1px 0}
.op-icon{font-size:2.5rem;margin-bottom:1.25rem;display:block;opacity:.7}
.op-eyebrow{font-size:.58rem;letter-spacing:.28em;text-transform:uppercase;color:var(--muted);margin-bottom:.5rem}
.op-to{font-family:var(--serif);font-style:italic;font-size:2rem;color:var(--parch);min-height:2.5rem;line-height:1.2;margin-bottom:.3rem}
.op-divider{display:flex;align-items:center;gap:.6rem;margin:.85rem auto;width:120px}
.op-divider span{flex:1;height:1px;background:rgba(196,154,60,.25)}
.op-divider b{color:var(--amber);font-size:.45rem;font-weight:normal}
.op-from{font-family:var(--serif);font-size:1.2rem;color:var(--amber);margin-bottom:.25rem}
.op-date{font-size:.72rem;color:var(--muted);margin-bottom:2.25rem;letter-spacing:.06em}
.op-cta{
  display:inline-block;background:transparent;color:var(--amber);
  font-family:var(--sans);font-size:.8rem;font-weight:400;letter-spacing:.14em;text-transform:uppercase;
  padding:.8rem 2rem;border:1px solid rgba(196,154,60,.4);cursor:pointer;
  transition:all .3s;
}
.op-cta:hover{background:var(--amber);color:var(--bg)}

/* MAIN */
#main{opacity:0;transition:opacity .5s .2s}
#main.show{opacity:1}
.guest-strip{background:var(--amber);color:var(--bg);text-align:center;padding:.45rem 1rem;font-size:.78rem;font-weight:500;position:sticky;top:0;z-index:99}

/* HERO */
.hero{
  min-height:100svh;display:flex;flex-direction:column;align-items:center;justify-content:center;
  text-align:center;padding:5rem 1.5rem 4rem;
  background:radial-gradient(ellipse 80% 60% at 50% -5%, rgba(196,154,60,.12) 0%, transparent 65%), var(--bg);
  position:relative;overflow:hidden;
}
.hero-watermark{
  position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);
  font-family:var(--serif);font-size:clamp(8rem,30vw,14rem);color:rgba(196,154,60,.03);
  pointer-events:none;white-space:nowrap;font-style:italic;
}
.hero-kicker{font-size:.58rem;font-weight:400;letter-spacing:.32em;text-transform:uppercase;color:var(--amber);margin-bottom:1.5rem;position:relative;z-index:1}
.hero-names{font-family:var(--serif);font-size:clamp(2.8rem,10vw,5.5rem);line-height:1.05;color:var(--parch);margin-bottom:.6rem;position:relative;z-index:1}
.hero-amp{display:block;font-style:italic;color:var(--amber);font-size:.5em;margin:.2em 0;font-weight:300}
.hero-rule{display:flex;align-items:center;gap:.75rem;margin:.9rem auto;width:fit-content}
.hero-rule span{width:40px;height:1px;background:rgba(196,154,60,.3)}
.hero-rule b{color:var(--amber);font-size:.45rem;font-weight:normal}
.hero-date{font-family:var(--serif);font-style:italic;font-size:.95rem;color:var(--muted);margin-bottom:2.5rem}
.hero-photo-outer{position:relative;width:180px;margin:0 auto;z-index:1}
.hero-photo-outer::before{
  content:'';position:absolute;inset:-12px;
  border:1px solid rgba(196,154,60,.12);
  pointer-events:none;
}
.hero-photo{width:180px;height:240px;overflow:hidden}
.hero-photo img,.hero-photo .ph{width:100%;height:100%;object-fit:cover}
.hero-photo .ph{background:var(--bg2);display:flex;align-items:center;justify-content:center;font-size:3.5rem}

/* SCROLL REVEAL */
.sr{opacity:0;transform:translateY(20px);transition:opacity .65s ease,transform .65s ease}
.sr.in{opacity:1;transform:translateY(0)}

/* SECTION */
.sect{padding:4.5rem 1.5rem;max-width:640px;margin:0 auto}
.sect-head{text-align:center;margin-bottom:2.25rem}
.eyebrow{display:block;font-size:.58rem;font-weight:400;letter-spacing:.25em;text-transform:uppercase;color:var(--amber);margin-bottom:.4rem}
.headline{font-family:var(--serif);font-style:italic;font-size:clamp(1.7rem,5vw,2.4rem);color:var(--parch);line-height:1.15}
.rule-amber{width:32px;height:1px;background:rgba(196,154,60,.35);margin:.7rem auto 0}

/* COUPLE */
.couple-wrap{display:flex;flex-direction:column;gap:1rem}
.cp-card{background:var(--bg2);border:1px solid rgba(196,154,60,.1);display:flex;align-items:center;gap:1.25rem;padding:1.25rem;position:relative;overflow:hidden}
.cp-card::before{content:'';position:absolute;top:0;left:0;width:2px;height:100%;background:linear-gradient(180deg,var(--amber),transparent)}
.cp-card.bride{flex-direction:row-reverse}
.cp-card.bride::before{left:auto;right:0}
.cp-photo{width:90px;height:115px;object-fit:cover;flex-shrink:0;border:1px solid rgba(196,154,60,.15)}
.cp-photo-ph{width:90px;height:115px;background:var(--bg3);flex-shrink:0;display:flex;align-items:center;justify-content:center;font-size:2rem}
.cp-role{font-size:.55rem;letter-spacing:.18em;text-transform:uppercase;color:var(--amber);margin-bottom:.3rem}
.cp-name{font-family:var(--serif);font-style:italic;font-size:1.3rem;color:var(--parch);line-height:1.1;margin-bottom:.3rem}
.cp-parents{font-size:.75rem;color:var(--muted);line-height:1.65}
.couple-amp{text-align:center;font-family:var(--serif);font-style:italic;font-size:1.5rem;color:var(--amber);padding:.1rem 0}

/* EVENTS */
.ev-card{background:var(--bg2);padding:1.5rem;margin-bottom:.85rem;position:relative}
.ev-card::after{content:'';position:absolute;top:0;left:0;right:0;height:1px;background:linear-gradient(90deg,var(--amber),transparent 60%)}
.ev-corners::before,.ev-corners::after{content:'◆';font-size:.45rem;color:rgba(196,154,60,.3);position:absolute}
.ev-corners::before{top:.4rem;right:.6rem}
.ev-corners::after{bottom:.4rem;left:.6rem}
.ev-badge{font-size:.55rem;letter-spacing:.18em;text-transform:uppercase;color:var(--amber);margin-bottom:.3rem}
.ev-title{font-family:var(--serif);font-style:italic;font-size:1.4rem;color:var(--parch);margin-bottom:.7rem;line-height:1.1}
.ev-row{display:flex;align-items:flex-start;gap:.6rem;font-size:.82rem;color:var(--muted);margin-bottom:.35rem;line-height:1.5}
.ev-icon{color:var(--amber);flex-shrink:0;font-style:normal;margin-top:1px}
.ev-link{color:var(--amber);font-size:.78rem;text-decoration:none;margin-top:.6rem;display:inline-block;font-weight:400;letter-spacing:.04em}

/* COUNTDOWN */
.countdown{display:flex;gap:.65rem;justify-content:center;flex-wrap:wrap;margin:1.5rem 0}
.cd-box{background:var(--bg2);border:1px solid rgba(196,154,60,.1);padding:.7rem 1rem;text-align:center;min-width:64px;position:relative}
.cd-num{font-family:var(--serif);font-size:2rem;color:var(--amber);line-height:1;display:block}
.cd-lbl{font-size:.55rem;text-transform:uppercase;letter-spacing:.1em;color:var(--muted);margin-top:.15rem;display:block}

/* GALLERY — editorial 3-col mosaic */
.gallery{display:grid;grid-template-columns:repeat(3,1fr);grid-template-rows:auto auto auto;gap:.4rem}
.gi{overflow:hidden;cursor:pointer}
.gi:first-child{grid-column:span 2;grid-row:span 2;aspect-ratio:1}
.gi:not(:first-child){aspect-ratio:1}
.gi img{width:100%;height:100%;object-fit:cover;transition:transform .5s;filter:sepia(.12) brightness(.95)}
.gi:hover img{transform:scale(1.05);filter:sepia(0) brightness(1)}

/* TIMELINE */
.timeline{padding-left:1.75rem;position:relative}
.timeline::before{content:'';position:absolute;left:.55rem;top:.5rem;bottom:0;width:1px;background:linear-gradient(180deg,rgba(196,154,60,.3),transparent)}
.tl-item{position:relative;margin-bottom:2rem}
.tl-dot{position:absolute;left:-1.3rem;top:5px;width:8px;height:8px;background:var(--bg2);border:1.5px solid var(--amber);transform:rotate(45deg)}
.tl-date{font-size:.66rem;font-weight:400;color:var(--amber);letter-spacing:.1em;margin-bottom:.2rem}
.tl-title{font-family:var(--serif);font-style:italic;font-size:1.05rem;color:var(--parch);margin-bottom:.25rem}
.tl-body{font-size:.82rem;color:var(--muted);line-height:1.75}

/* FORM */
.form-panel{background:var(--bg2);border:1px solid rgba(196,154,60,.1);padding:1.5rem}
.finput{width:100%;padding:.65rem .9rem;border:1px solid rgba(196,154,60,.18);font-family:var(--sans);font-size:.84rem;color:var(--parch);background:#120C04;outline:none;margin-bottom:.65rem;transition:border-color .2s}
.finput:focus{border-color:var(--amber)}
.finput::placeholder{color:#4A3010}
.attend-row{display:flex;gap:.5rem;margin-bottom:.65rem}
.attend-btn{flex:1;padding:.65rem;border:1px solid rgba(196,154,60,.18);background:transparent;font-family:var(--sans);font-size:.8rem;color:var(--muted);cursor:pointer;transition:all .2s;text-align:center}
.attend-btn.yes{border-color:#10B981;background:rgba(16,185,129,.08);color:#6EE7B7}
.attend-btn.no{border-color:#EF4444;background:rgba(239,68,68,.08);color:#FCA5A5}
.submit-btn{width:100%;background:var(--amber);color:var(--bg);border:none;padding:.8rem;font-family:var(--sans);font-size:.86rem;font-weight:500;letter-spacing:.06em;cursor:pointer;transition:opacity .2s}
.submit-btn:hover{opacity:.85}
.wish-item{padding:1rem;background:var(--bg2);border-left:2px solid rgba(196,154,60,.2);margin-bottom:.6rem}
.wish-name{font-weight:400;font-size:.83rem;color:var(--parch);margin-bottom:.15rem}
.wish-msg{font-size:.8rem;color:var(--muted);line-height:1.65}
.wish-time{font-size:.65rem;color:var(--faint);margin-top:.25rem}

/* GIFT */
.gift-row{background:var(--bg2);border:1px solid rgba(196,154,60,.1);padding:.9rem 1.1rem;display:flex;align-items:center;gap:.9rem;margin-bottom:.6rem}
.gift-bank{font-size:.58rem;font-weight:500;color:var(--amber);width:38px;flex-shrink:0;letter-spacing:.08em}
.copy-btn{padding:.28rem .65rem;font-size:.7rem;background:transparent;color:var(--amber);border:1px solid rgba(196,154,60,.28);cursor:pointer;flex-shrink:0;transition:all .2s}
.copy-btn:hover{background:var(--amber);color:var(--bg)}

/* FLOATS */
.floats{position:fixed;bottom:1.25rem;right:1rem;z-index:200;display:flex;flex-direction:column;gap:.5rem;align-items:flex-end}
.float-btn{border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 18px rgba(0,0,0,.5);transition:transform .2s;font-family:var(--sans);font-weight:500}
.float-btn:hover{transform:scale(1.08)}
.float-music{width:46px;height:46px;border-radius:50%;background:var(--amber);color:var(--bg);font-size:1.1rem}
.float-gift{height:46px;min-width:46px;border-radius:23px;background:#25D366;color:white;font-size:.72rem;padding:0 .85rem;gap:.3rem}
.float-share{width:46px;height:46px;border-radius:50%;background:var(--bg2);color:var(--muted);border:1px solid rgba(196,154,60,.12)}

/* MODALS */
.overlay{position:fixed;inset:0;background:rgba(0,0,0,.7);z-index:300;display:flex;align-items:flex-end;justify-content:center;opacity:0;pointer-events:none;transition:opacity .3s}
.overlay.open{opacity:1;pointer-events:all}
.sheet{background:var(--bg2);border-radius:16px 16px 0 0;padding:1.5rem;width:100%;max-width:460px;transform:translateY(100%);transition:transform .35s cubic-bezier(.34,1.26,.64,1);border-top:1px solid rgba(196,154,60,.12)}
.overlay.open .sheet{transform:translateY(0)}
.sheet-handle{width:36px;height:2px;background:var(--faint);margin:0 auto 1.25rem}
.center-overlay{position:fixed;inset:0;background:rgba(0,0,0,.7);z-index:300;display:flex;align-items:center;justify-content:center;padding:1rem;opacity:0;pointer-events:none;transition:opacity .3s}
.center-overlay.open{opacity:1;pointer-events:all}
.dialog{background:var(--bg2);border:1px solid rgba(196,154,60,.12);padding:1.5rem;width:100%;max-width:400px;transform:scale(.92);transition:transform .3s cubic-bezier(.34,1.26,.64,1)}
.center-overlay.open .dialog{transform:scale(1)}
.share-row{display:flex;gap:.5rem;margin-bottom:.5rem}
.share-half{flex:1;padding:.7rem;border:none;font-family:var(--sans);font-size:.8rem;font-weight:400;cursor:pointer;transition:all .2s}
.lightbox{position:fixed;inset:0;background:rgba(0,0,0,.96);z-index:400;display:flex;align-items:center;justify-content:center;opacity:0;pointer-events:none;transition:opacity .3s}
.lightbox.open{opacity:1;pointer-events:all}
.lightbox img{max-width:92vw;max-height:90vh;object-fit:contain}
.lb-close{position:absolute;top:1rem;right:1rem;background:rgba(196,154,60,.15);color:var(--parch);border:none;border-radius:50%;width:40px;height:40px;font-size:1.1rem;cursor:pointer}
footer{background:#0A0602;color:var(--faint);text-align:center;padding:2rem 1rem;font-size:.75rem;border-top:1px solid rgba(196,154,60,.06)}
footer strong{color:var(--muted)}
</style>
</head>
<body>
@php $coupleOrder = $invitation->couple_order ?? "bride_first"; @endphp

@if(empty($isPreview))
<div id="opening">
  <div class="op-frame">
    <span class="op-icon">✦</span>
    @if(!empty($guestName))
      <p class="op-eyebrow">Kepada Yth.</p>
      <p class="op-to">{{ $guestName }}</p>
    @endif
    <div class="op-divider"><span></span><b>◆</b><span></span></div>
    <p class="op-from">
      @if($coupleOrder==='groom_first')
        {{ $invitation->groom_nickname ?: $invitation->groom_name }} &amp; {{ $invitation->bride_nickname ?: $invitation->bride_name }}
      @else
        {{ $invitation->bride_nickname ?: $invitation->bride_name }} &amp; {{ $invitation->groom_nickname ?: $invitation->groom_name }}
      @endif
    </p>
    @if($invitation->akad_date)
      <p class="op-date">{{ \Carbon\Carbon::parse($invitation->akad_date)->isoFormat('D MMMM YYYY') }}</p>
    @endif
    <button class="op-cta" onclick="openInvitation()">✦ Buka Undangan ✦</button>
  </div>
</div>
@endif

<div id="main" class="{{ !empty($isPreview) ? 'show' : '' }}">
@if(!empty($guestName))<div class="guest-strip">Undangan untuk: {{ $guestName }}</div>@endif

<section class="hero">
  <div class="hero-watermark" aria-hidden="true">{{ $invitation->groom_nickname ?: '' }}</div>
  <p class="hero-kicker">Undangan Pernikahan</p>
  <h1 class="hero-names">
    @if($coupleOrder==='groom_first')
      {{ $invitation->groom_nickname ?: ($invitation->groom_name ?: 'Pengantin Pria') }}
      <span class="hero-amp">&amp;</span>
      {{ $invitation->bride_nickname ?: ($invitation->bride_name ?: 'Pengantin Wanita') }}
    @else
      {{ $invitation->bride_nickname ?: ($invitation->bride_name ?: 'Pengantin Wanita') }}
      <span class="hero-amp">&amp;</span>
      {{ $invitation->groom_nickname ?: ($invitation->groom_name ?: 'Pengantin Pria') }}
    @endif
  </h1>
  <div class="hero-rule"><span></span><b>◆</b><span></span></div>
  @if($invitation->akad_date)<p class="hero-date">{{ \Carbon\Carbon::parse($invitation->akad_date)->isoFormat('dddd, D MMMM YYYY') }}</p>@endif
  <div class="hero-photo-outer" style="margin-top:2rem;">
    <div class="hero-photo">
      @if($invitation->cover_photo)<img src="{{ asset('storage/'.$invitation->cover_photo) }}" alt="">@else<div class="ph">💑</div>@endif
    </div>
  </div>
</section>

@if($invitation->opening_text)
<section style="background:var(--bg2);padding:3.5rem 1.5rem;">
  <div style="max-width:560px;margin:0 auto;font-family:var(--serif);font-style:italic;font-size:.95rem;line-height:2.1;color:var(--muted);text-align:center;" class="sr">{!! $invitation->opening_text !!}</div>
</section>
@endif

<section style="background:var(--bg3);">
<div class="sect sr">
  <div class="sect-head"><span class="eyebrow">Kedua Mempelai</span><h2 class="headline">Mempelai Bahagia</h2><div class="rule-amber"></div></div>
  <div class="couple-wrap">
    <div class="cp-card sr">
      @if($invitation->groom_photo)<img src="{{ asset('storage/'.$invitation->groom_photo) }}" class="cp-photo" alt="">@else<div class="cp-photo-ph">🤵</div>@endif
      <div class="cp-info">
        <p class="cp-role">Pengantin Pria</p><h3 class="cp-name">{{ $invitation->groom_name ?: 'Pengantin Pria' }}</h3>
        <p class="cp-parents">Putra Bapak {{ $invitation->groom_father ?: '…' }}<br>& Ibu {{ $invitation->groom_mother ?: '…' }}</p>
      </div>
    </div>
    <div class="couple-amp">◆</div>
    <div class="cp-card bride sr">
      @if($invitation->bride_photo)<img src="{{ asset('storage/'.$invitation->bride_photo) }}" class="cp-photo" alt="">@else<div class="cp-photo-ph">👰</div>@endif
      <div class="cp-info" style="text-align:right;">
        <p class="cp-role">Pengantin Wanita</p><h3 class="cp-name">{{ $invitation->bride_name ?: 'Pengantin Wanita' }}</h3>
        <p class="cp-parents">Putri Bapak {{ $invitation->bride_father ?: '…' }}<br>& Ibu {{ $invitation->bride_mother ?: '…' }}</p>
      </div>
    </div>
  </div>
</div>
</section>

<section style="background:var(--bg);">
<div class="sect sr">
  <div class="sect-head"><span class="eyebrow">Detail Acara</span><h2 class="headline">Hari yang Istimewa</h2><div class="rule-amber"></div></div>
  @if($invitation->akad_date)
  <div style="text-align:center;margin-bottom:1.75rem;"><p style="font-size:.66rem;letter-spacing:.12em;text-transform:uppercase;color:var(--muted);margin-bottom:.5rem;">Menghitung hari</p><div class="countdown" id="countdown"></div></div>
  @endif
  @if($invitation->akad_date)
  <div class="ev-card ev-corners sr">
    <p class="ev-badge">Akad Nikah</p><h3 class="ev-title">Ijab Qobul</h3>
    <div class="ev-row"><i class="ev-icon">📅</i>{{ \Carbon\Carbon::parse($invitation->akad_date)->isoFormat('dddd, D MMMM YYYY') }}</div>
    @if($invitation->akad_time_start)<div class="ev-row"><i class="ev-icon">🕐</i>{{ $invitation->akad_time_start }}{{ $invitation->akad_time_end ? ' – '.$invitation->akad_time_end : '' }} WIB</div>@endif
    @if($invitation->akad_venue)<div class="ev-row"><i class="ev-icon">📍</i><div>{{ $invitation->akad_venue }}@if($invitation->akad_address)<br><span style="color:var(--faint);font-size:.78rem;">{{ $invitation->akad_address }}</span>@endif</div></div>@endif
    @if($invitation->akad_maps_url)<a href="{{ $invitation->akad_maps_url }}" target="_blank" class="ev-link">Buka di Maps →</a>@endif
  </div>
  @endif
  @if($invitation->resepsi_date)
  <div class="ev-card ev-corners sr">
    <p class="ev-badge">Resepsi</p><h3 class="ev-title">Walimatul Ursy</h3>
    <div class="ev-row"><i class="ev-icon">📅</i>{{ \Carbon\Carbon::parse($invitation->resepsi_date)->isoFormat('dddd, D MMMM YYYY') }}</div>
    @if($invitation->resepsi_time_start)<div class="ev-row"><i class="ev-icon">🕐</i>{{ $invitation->resepsi_time_start }}{{ $invitation->resepsi_time_end ? ' – '.$invitation->resepsi_time_end : '' }} WIB</div>@endif
    @if($invitation->resepsi_venue)<div class="ev-row"><i class="ev-icon">📍</i><div>{{ $invitation->resepsi_venue }}@if($invitation->resepsi_address)<br><span style="color:var(--faint);font-size:.78rem;">{{ $invitation->resepsi_address }}</span>@endif</div></div>@endif
    @if($invitation->resepsi_maps_url)<a href="{{ $invitation->resepsi_maps_url }}" target="_blank" class="ev-link">Buka di Maps →</a>@endif
  </div>
  @endif
  @if($invitation->livestream_url)<div class="ev-card sr"><p class="ev-badge" style="color:#9C5CE6;">Live Streaming</p><h3 class="ev-title">Saksikan Online</h3><a href="{{ $invitation->livestream_url }}" target="_blank" class="ev-link" style="color:#9C5CE6;">▶ Tonton Live →</a></div>@endif
</div>
</section>

@if($invitation->photos && $invitation->photos->count() > 0)
<section style="background:var(--bg2);padding:4rem 1.5rem;">
<div style="max-width:640px;margin:0 auto;" class="sr">
  <div class="sect-head"><span class="eyebrow">Gallery</span><h2 class="headline">Precious Moments</h2><div class="rule-amber"></div></div>
  <div class="gallery">
    @foreach($invitation->photos->take(7) as $photo)
    <div class="gi" onclick="openLightbox('{{ asset('storage/'.$photo->photo) }}')"><img src="{{ asset('storage/'.$photo->photo) }}" alt="" loading="lazy"></div>
    @endforeach
  </div>
</div>
</section>
@endif

@php $stories = is_array($invitation->love_story_items) ? $invitation->love_story_items : (json_decode($invitation->love_story_items, true) ?? []); @endphp
@if(count($stories) > 0)
<section style="background:var(--bg3);">
<div class="sect sr">
  <div class="sect-head"><span class="eyebrow">Our Story</span><h2 class="headline">Perjalanan Cinta</h2><div class="rule-amber"></div></div>
  <div class="timeline">
    @foreach($stories as $story)
    <div class="tl-item sr">
      <div class="tl-dot"></div>
      @if(!empty($story['date']))<p class="tl-date">{{ $story['date'] }}</p>@endif
      @if(!empty($story['title']))<h4 class="tl-title">{{ $story['title'] }}</h4>@endif
      @if(!empty($story['content']))<p class="tl-body">{{ $story['content'] }}</p>@endif
    </div>
    @endforeach
  </div>
</div>
</section>
@endif

<section style="background:var(--bg);">
<div class="sect sr">
  <div class="sect-head"><span class="eyebrow">RSVP</span><h2 class="headline">Konfirmasi Kehadiran</h2><div class="rule-amber"></div></div>
  <div class="form-panel">
    <div id="rsvp-success" style="display:none;text-align:center;padding:2rem;"><p style="font-family:var(--serif);font-style:italic;font-size:1.5rem;color:var(--amber);">Terima Kasih ✦</p><p style="font-size:.82rem;color:var(--muted);margin-top:.4rem;">Konfirmasi sudah kami catat.</p></div>
    <div id="rsvp-form">
      <input class="finput" id="r-name" placeholder="Nama lengkap" value="{{ $guestName ?? '' }}">
      <input class="finput" id="r-phone" placeholder="No. WhatsApp (opsional)" type="tel">
      <input class="finput" id="r-pax" placeholder="Jumlah tamu" type="number" value="1" min="1" max="20">
      <p style="font-size:.7rem;color:var(--muted);margin-bottom:.4rem;letter-spacing:.1em;text-transform:uppercase;">Kehadiran</p>
      <div class="attend-row">
        <button class="attend-btn" id="btn-hadir" onclick="setAttend('hadir')">✅ Hadir</button>
        <button class="attend-btn" id="btn-tidak" onclick="setAttend('tidak_hadir')">❌ Tidak Hadir</button>
      </div>
      <textarea class="finput" id="r-msg" rows="2" placeholder="Pesan (opsional)" style="resize:none;"></textarea>
      <button class="submit-btn" onclick="submitRSVP()">Kirim Konfirmasi</button>
    </div>
  </div>
  <div style="margin-top:2.5rem;">
    <div class="sect-head" style="margin-bottom:1.5rem;"><span class="eyebrow">Ucapan &amp; Doa</span></div>
    <div class="form-panel" style="margin-bottom:1.25rem;">
      <input class="finput" id="w-name" placeholder="Nama kamu">
      <textarea class="finput" id="w-msg" rows="3" placeholder="Ucapan tulus untuk pengantin…" style="resize:none;"></textarea>
      <button class="submit-btn" onclick="submitWish()">Kirim Ucapan</button>
    </div>
    <div id="wishes-list">
      @php $_wishes = $invitation->id ? $invitation->wishes()->where('is_visible',true)->latest()->take(10)->get() : collect(); @endphp
      @foreach($_wishes as $w)<div class="wish-item"><p class="wish-name">{{ $w->name }}</p><p class="wish-msg">{{ $w->message }}</p><p class="wish-time">{{ $w->created_at->diffForHumans() }}</p></div>@endforeach
    </div>
  </div>
</div>
</section>

@if($invitation->closing_text)
<section style="background:var(--bg2);padding:4rem 1.5rem;text-align:center;">
  <div class="sr" style="max-width:560px;margin:0 auto;">
    <p style="font-family:var(--serif);font-style:italic;font-size:.95rem;color:var(--muted);line-height:2.1;">{!! $invitation->closing_text !!}</p>
    <div class="hero-rule" style="margin:1.5rem auto;"><span></span><b>◆</b><span></span></div>
    <p style="font-family:var(--serif);font-style:italic;font-size:1.7rem;color:var(--parch);">@if($coupleOrder==='groom_first'){{ $invitation->groom_nickname ?: $invitation->groom_name }} &amp; {{ $invitation->bride_nickname ?: $invitation->bride_name }}@else{{ $invitation->bride_nickname ?: $invitation->bride_name }} &amp; {{ $invitation->groom_nickname ?: $invitation->groom_name }}@endif</p>
  </div>
</section>
@endif

<footer><p>💝 <strong>{{ $invitation->title ?: 'Undangan Pernikahan' }}</strong></p><p style="margin-top:.35rem;">Dibuat dengan ❤️ oleh <strong>UndanganKu</strong></p></footer>
</div>

<div class="floats" id="floats" style="{{ empty($isPreview) ? 'display:none' : '' }}">
  @if($invitation->music_file || $invitation->selected_music_key)<button class="float-btn float-music" id="music-btn" onclick="toggleMusic()">🎵</button>@endif
  @if($invitation->gifts && $invitation->gifts->count() > 0)<button class="float-btn float-gift" onclick="document.getElementById('gift-overlay').classList.add('open')"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 12v10H4V12"/><path d="M22 7H2v5h20V7z"/><path d="M12 22V7"/><path d="M12 7H7.5a2.5 2.5 0 010-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 000-5C13 2 12 7 12 7z"/></svg>Hadiah</button>@endif
  <button class="float-btn float-share" onclick="document.getElementById('share-overlay').classList.add('open')"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg></button>
</div>

@if($invitation->gifts && $invitation->gifts->count() > 0)
<div class="overlay" id="gift-overlay" onclick="if(event.target===this)this.classList.remove('open')">
  <div class="sheet"><div class="sheet-handle"></div><h3 style="font-family:var(--serif);font-style:italic;font-size:1.15rem;color:var(--parch);margin-bottom:1.1rem;">Kirim Hadiah ✦</h3>
    @foreach($invitation->gifts as $g)<div class="gift-row"><div class="gift-bank">{{ strtoupper(substr($g->bank_name,0,4)) }}</div><div style="flex:1;"><p style="font-weight:400;font-size:.88rem;color:var(--parch);">{{ $g->bank_name }}</p><p style="font-size:.83rem;color:var(--muted);">{{ $g->account_number }}</p><p style="font-size:.72rem;color:var(--faint);">a.n. {{ $g->account_name }}</p></div><button class="copy-btn" onclick="copyText('{{ $g->account_number }}', this)">Salin</button></div>@endforeach
  </div>
</div>
@endif

<div class="center-overlay" id="share-overlay" onclick="if(event.target===this)this.classList.remove('open')">
  <div class="dialog">
    <p style="font-family:var(--serif);font-style:italic;font-size:1.1rem;color:var(--parch);margin-bottom:1rem;">Bagikan Undangan</p>
    <div style="display:flex;align-items:center;gap:.4rem;background:#0A0602;padding:.5rem .75rem;margin-bottom:1rem;border:1px solid rgba(196,154,60,.12);"><input type="text" id="share-link" readonly value="{{ url('/'.$invitation->slug) }}" style="flex:1;border:none;background:transparent;font-size:.72rem;outline:none;color:var(--muted);"><button onclick="copyText(document.getElementById('share-link').value,this)" style="background:var(--amber);color:var(--bg);border:none;padding:.28rem .65rem;font-size:.72rem;cursor:pointer;font-weight:500;">Salin</button></div>
    <p style="font-size:.72rem;color:var(--muted);margin-bottom:.5rem;">Nama tamu (untuk link personal):</p>
    <input type="text" id="share-guest" class="finput" placeholder="Nama Tamu" style="margin-bottom:.75rem;">
    <div class="share-row">
      <button class="share-half" style="background:var(--bg);color:var(--muted);border:1px solid rgba(196,154,60,.1);" onclick="doShare(false)">Tanpa Nama</button>
      <button class="share-half" style="background:rgba(196,154,60,.1);color:var(--amber);border:1px solid rgba(196,154,60,.2);" onclick="doShare(true)">Dengan Nama</button>
    </div>
    <button onclick="doShareWA()" style="width:100%;background:#25D366;color:white;border:none;padding:.72rem;font-family:var(--sans);font-size:.82rem;font-weight:400;cursor:pointer;">Broadcast WhatsApp →</button>
  </div>
</div>

<div class="lightbox" id="lightbox" onclick="this.classList.remove('open')"><button class="lb-close">✕</button><img id="lightbox-img" src="" alt=""></div>
@if($invitation->music_file)<audio id="audio" loop><source src="{{ asset('storage/'.$invitation->music_file) }}"></audio>@elseif($invitation->selected_music_key)<audio id="audio" loop><source src="{{ $invitation->selected_music_key }}"></audio>@endif

<script>
const SLUG = '{{ $invitation->slug }}';
let attending = '', musicPlaying = false;

function openInvitation() {
  const a = document.getElementById('audio');
  if (a) { a.play().then(() => { musicPlaying = true; updateMusicBtn(); }).catch(() => {}); }
  document.getElementById('opening').classList.add('away');
  document.getElementById('main').classList.add('show');
  document.getElementById('floats').style.display = 'flex';
}

const observer = new IntersectionObserver(entries => {
  entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in'); observer.unobserve(e.target); } });
}, { threshold: 0.1 });
document.querySelectorAll('.sr').forEach(el => observer.observe(el));

@if($invitation->akad_date)
(function() {
  const target = new Date('{{ $invitation->akad_date }}').getTime();
  const el = document.getElementById('countdown');
  function tick() {
    const diff = target - Date.now();
    if (diff <= 0) { el.innerHTML = '<span style="font-family:var(--serif);font-style:italic;color:var(--amber);">Hari Bahagia Telah Tiba ✦</span>'; return; }
    const parts = [{v:Math.floor(diff/86400000),l:'Hari'},{v:Math.floor(diff%86400000/3600000),l:'Jam'},{v:Math.floor(diff%3600000/60000),l:'Menit'},{v:Math.floor(diff%60000/1000),l:'Detik'}];
    el.innerHTML = parts.map(p => `<div class="cd-box"><span class="cd-num">${String(p.v).padStart(2,'0')}</span><span class="cd-lbl">${p.l}</span></div>`).join('');
  }
  tick(); setInterval(tick, 1000);
})();
@endif

function setAttend(v) {
  attending = v;
  document.getElementById('btn-hadir').className = 'attend-btn' + (v === 'hadir' ? ' yes' : '');
  document.getElementById('btn-tidak').className = 'attend-btn' + (v === 'tidak_hadir' ? ' no' : '');
}
async function submitRSVP() {
  const name = document.getElementById('r-name').value.trim();
  if (!name) return alert('Masukkan nama!');
  if (!attending) return alert('Pilih konfirmasi kehadiran!');
  const res = await fetch('/' + SLUG + '/rsvp', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ name, phone: document.getElementById('r-phone').value, pax: document.getElementById('r-pax').value, attendance: attending, message: document.getElementById('r-msg').value }) });
  const d = await res.json();
  if (d.success) { document.getElementById('rsvp-form').style.display = 'none'; document.getElementById('rsvp-success').style.display = 'block'; }
  else alert('Gagal. Coba lagi!');
}
async function submitWish() {
  const name = document.getElementById('w-name').value.trim(), msg = document.getElementById('w-msg').value.trim();
  if (!name || !msg) return alert('Lengkapi nama dan ucapan!');
  const res = await fetch('/' + SLUG + '/wish', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: JSON.stringify({ name, message: msg }) });
  const d = await res.json();
  if (d.success) { document.getElementById('w-name').value = ''; document.getElementById('w-msg').value = ''; const item = document.createElement('div'); item.className = 'wish-item'; item.innerHTML = `<p class="wish-name">${name}</p><p class="wish-msg">${msg}</p><p class="wish-time">Baru saja</p>`; document.getElementById('wishes-list').prepend(item); }
}
function copyText(text, btn) { navigator.clipboard.writeText(text).then(() => { const orig = btn.textContent; btn.textContent = '✓'; setTimeout(() => { btn.textContent = orig; }, 2000); }); }
function toggleMusic() { const a = document.getElementById('audio'); if (!a) return; if (a.paused) { a.play(); musicPlaying = true; } else { a.pause(); musicPlaying = false; } updateMusicBtn(); }
function updateMusicBtn() { const btn = document.getElementById('music-btn'); if (btn) btn.textContent = musicPlaying ? '🎵' : '🔇'; }
function openLightbox(src) { document.getElementById('lightbox-img').src = src; document.getElementById('lightbox').classList.add('open'); }
function doShare(withName) { const name = document.getElementById('share-guest').value.trim(); const link = window.location.origin + '/' + SLUG + (withName && name ? '?untuk=' + encodeURIComponent(name) : ''); navigator.clipboard.writeText(link).then(() => alert('Link disalin!')); }
function doShareWA() {
  const name = document.getElementById('share-guest').value.trim();
  const link = window.location.origin + '/' + SLUG + (name ? '?untuk=' + encodeURIComponent(name) : '');
  const g = {!! json_encode($invitation->groom_nickname ?: $invitation->groom_name ?: '') !!};
  const b = {!! json_encode($invitation->bride_nickname ?: $invitation->bride_name ?: '') !!};
  let msg = {!! json_encode($invitation->invitation_message ?: '') !!} || ('Kepada *' + (name || 'Bapak/Ibu/Saudara/i') + '*\n\nLink: ' + link + '\n\n' + g + ' & ' + b);
  msg = msg.replace(/\{nama_tamu\}/g, name || 'Bapak/Ibu/Saudara/i').replace(/\{link_undangan\}/g, link).replace(/\{nama_pengantin_pria\}/g, g).replace(/\{nama_pengantin_wanita\}/g, b);
  window.open('https://wa.me/?text=' + encodeURIComponent(msg), '_blank');
}
</script>
</body>
</html>
