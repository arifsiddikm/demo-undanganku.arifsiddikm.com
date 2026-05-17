<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>{{ $invitation->title ?? 'Undangan Pernikahan' }}</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,wght@0,300;0,400;1,300;1,400&family=Outfit:wght@300;400;500&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
:root {
  --rose:   {{ $invitation->color_primary  ?? '#C1826A' }};
  --sand:   {{ $invitation->color_secondary ?? '#EFE5D8' }};
  --ivory:  #FAF7F4;
  --bark:   #3D2B1F;
  --stone:  #8A7060;
  --light:  #F5EEE6;
  --serif:  'Fraunces', Georgia, serif;
  --sans:   'Outfit', system-ui, sans-serif;
  --r4: 4px; --r8: 8px; --r16: 16px;
}
html { scroll-behavior: smooth; }
body { font-family: var(--sans); background: var(--ivory); color: var(--bark); overflow-x: hidden; -webkit-font-smoothing: antialiased; }

/* ── OPENING ── */
#opening {
  position: fixed; inset: 0; z-index: 9999;
  background: var(--sand);
  display: flex; flex-direction: column; align-items: center; justify-content: center;
  transition: transform 0.9s cubic-bezier(0.76, 0, 0.24, 1);
}
#opening.away { transform: translateY(-100%); }
.op-inner { text-align: center; padding: 2.5rem 2rem; max-width: 380px; width: 100%; }
.op-arc {
  width: 160px; height: 80px; border-radius: 80px 80px 0 0;
  border: 1px solid rgba(193,130,106,0.3); border-bottom: none;
  margin: 0 auto 2rem; display: flex; align-items: flex-end; justify-content: center; padding-bottom: 0.5rem;
  font-size: 1.5rem;
}
.op-eyebrow { font-size: 0.62rem; letter-spacing: 0.22em; text-transform: uppercase; color: var(--stone); margin-bottom: 0.5rem; }
.op-to-name { font-family: var(--serif); font-style: italic; font-size: 2rem; color: var(--bark); margin-bottom: 0.25rem; min-height: 2.5rem; line-height: 1.2; }
.op-from { font-family: var(--serif); font-size: 1.1rem; color: var(--rose); margin-bottom: 0.2rem; }
.op-date { font-size: 0.78rem; color: var(--stone); margin-bottom: 2.5rem; letter-spacing: 0.06em; }
.op-cta {
  display: inline-flex; align-items: center; gap: 0.6rem;
  background: var(--rose); color: white;
  font-family: var(--sans); font-size: 0.85rem; font-weight: 500; letter-spacing: 0.04em;
  padding: 0.85rem 2.25rem; border: none; border-radius: var(--r4); cursor: pointer;
  transition: background 0.2s, transform 0.15s;
}
.op-cta:hover { background: var(--bark); transform: translateY(-1px); }

/* ── MAIN ── */
#main { opacity: 0; transition: opacity 0.5s 0.2s; }
#main.show { opacity: 1; }
.guest-strip { background: var(--rose); color: white; text-align: center; padding: 0.45rem 1rem; font-size: 0.78rem; position: sticky; top: 0; z-index: 99; }

/* ── HERO ── */
.hero {
  min-height: 100svh; position: relative; overflow: hidden;
  display: flex; flex-direction: column; align-items: center; justify-content: flex-end;
  padding: 0 1.5rem 4rem;
  background: linear-gradient(180deg, #F0E4D7 0%, var(--sand) 55%, var(--ivory) 100%);
}
.hero-bg-circle {
  position: absolute; top: -80px; left: 50%; transform: translateX(-50%);
  width: 340px; height: 340px; border-radius: 50%;
  background: radial-gradient(circle, rgba(193,130,106,0.12) 0%, transparent 70%);
  pointer-events: none;
}
.hero-photo-frame {
  width: 200px; height: 260px;
  border-radius: 100px 100px 0 0;
  overflow: hidden; margin: 0 auto 2rem;
  border: 6px solid white;
  box-shadow: 0 12px 40px rgba(61,43,31,0.12), 0 0 0 1px rgba(193,130,106,0.15);
  position: relative; z-index: 1;
}
.hero-photo-frame img, .hero-photo-frame .ph {
  width: 100%; height: 100%; object-fit: cover;
}
.hero-photo-frame .ph {
  background: linear-gradient(160deg, var(--sand), #E8D5C4);
  display: flex; align-items: center; justify-content: center; font-size: 3.5rem;
}
.hero-text { text-align: center; position: relative; z-index: 1; }
.hero-eyebrow { font-size: 0.62rem; letter-spacing: 0.22em; text-transform: uppercase; color: var(--stone); margin-bottom: 1rem; }
.hero-names {
  font-family: var(--serif); font-style: italic;
  font-size: clamp(2.8rem, 10vw, 4.5rem); line-height: 1.05;
  color: var(--bark); margin-bottom: 0.6rem;
}
.hero-amp { color: var(--rose); font-style: normal; font-weight: 300; display: block; font-size: 0.55em; margin: 0.1em 0; }
.hero-rule { display: flex; align-items: center; gap: 0.75rem; margin: 0.9rem auto; width: fit-content; }
.hero-rule span { width: 40px; height: 1px; background: var(--rose); opacity: 0.4; }
.hero-rule b { color: var(--rose); font-size: 0.5rem; font-weight: normal; }
.hero-date { font-family: var(--serif); font-size: 0.95rem; color: var(--stone); letter-spacing: 0.05em; }
.hero-scroll { margin-top: 2.5rem; font-size: 0.65rem; letter-spacing: 0.2em; text-transform: uppercase; color: var(--stone); animation: bob 2.4s ease-in-out infinite; display: block; }
@keyframes bob { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(5px); } }

/* ── SCROLL REVEAL ── */
.sr { opacity: 0; transform: translateY(24px); transition: opacity 0.65s ease, transform 0.65s ease; }
.sr.in { opacity: 1; transform: translateY(0); }

/* ── SECTION ── */
.sect { padding: 4.5rem 1.5rem; max-width: 640px; margin: 0 auto; }
.sect-head { text-align: center; margin-bottom: 2.25rem; }
.eyebrow { display: block; font-size: 0.6rem; font-weight: 500; letter-spacing: 0.22em; text-transform: uppercase; color: var(--rose); margin-bottom: 0.45rem; }
.headline { font-family: var(--serif); font-style: italic; font-size: clamp(1.7rem, 5vw, 2.3rem); color: var(--bark); line-height: 1.15; }
.rule-thin { width: 36px; height: 1.5px; background: var(--rose); margin: 0.75rem auto 0; opacity: 0.4; }

/* ── OPENING TEXT ── */
.opening-card {
  background: white; border-radius: var(--r16); padding: 2rem 1.75rem;
  border: 1px solid rgba(193,130,106,0.12);
  box-shadow: 0 2px 16px rgba(61,43,31,0.04);
  font-family: var(--serif); font-style: italic;
  font-size: 0.95rem; line-height: 2; color: var(--stone); text-align: center;
}

/* ── COUPLE ── */
.couple-wrap { display: flex; flex-direction: column; gap: 1.25rem; }
.couple-card {
  background: white; border-radius: var(--r16);
  border: 1px solid rgba(193,130,106,0.1);
  box-shadow: 0 2px 16px rgba(61,43,31,0.04);
  display: flex; align-items: center; gap: 1.25rem; padding: 1.25rem;
}
.couple-card.bride { flex-direction: row-reverse; }
.cp-photo {
  width: 96px; height: 116px; border-radius: 10px;
  object-fit: cover; flex-shrink: 0;
  border: 3px solid var(--sand);
}
.cp-photo-ph {
  width: 96px; height: 116px; border-radius: 10px;
  background: linear-gradient(135deg, var(--sand), #E0CFC0);
  display: flex; align-items: center; justify-content: center;
  font-size: 2.2rem; flex-shrink: 0;
}
.cp-info { flex: 1; }
.cp-role { font-size: 0.6rem; font-weight: 500; letter-spacing: 0.18em; text-transform: uppercase; color: var(--rose); margin-bottom: 0.3rem; }
.cp-name { font-family: var(--serif); font-style: italic; font-size: 1.4rem; color: var(--bark); line-height: 1.1; margin-bottom: 0.35rem; }
.cp-parents { font-size: 0.78rem; color: var(--stone); line-height: 1.7; }
.cp-ig { display: inline-flex; align-items: center; gap: 0.25rem; font-size: 0.75rem; color: var(--rose); text-decoration: none; margin-top: 0.35rem; }
.couple-amp { text-align: center; font-family: var(--serif); font-style: italic; font-size: 2rem; color: var(--rose); padding: 0.25rem 0; }

/* ── EVENTS ── */
.event-card {
  background: white; border-radius: var(--r16); padding: 1.5rem;
  border: 1px solid rgba(193,130,106,0.12);
  box-shadow: 0 2px 12px rgba(61,43,31,0.04);
  margin-bottom: 0.85rem; position: relative; overflow: hidden;
}
.event-card::before {
  content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
  background: linear-gradient(90deg, var(--rose), transparent);
}
.ev-badge { font-size: 0.58rem; font-weight: 500; letter-spacing: 0.18em; text-transform: uppercase; color: var(--rose); margin-bottom: 0.3rem; }
.ev-title { font-family: var(--serif); font-style: italic; font-size: 1.4rem; color: var(--bark); margin-bottom: 0.75rem; line-height: 1.1; }
.ev-row { display: flex; align-items: flex-start; gap: 0.6rem; font-size: 0.82rem; color: var(--stone); margin-bottom: 0.35rem; line-height: 1.5; }
.ev-icon { color: var(--rose); flex-shrink: 0; margin-top: 1px; font-style: normal; font-size: 0.85rem; }
.ev-maps { display: inline-flex; align-items: center; gap: 0.35rem; margin-top: 0.6rem; font-size: 0.78rem; font-weight: 500; color: var(--rose); text-decoration: none; }

/* ── COUNTDOWN ── */
.countdown { display: flex; gap: 0.65rem; justify-content: center; flex-wrap: wrap; margin: 1.5rem 0; }
.cd-box {
  background: white; border-radius: var(--r8); padding: 0.75rem 1rem;
  text-align: center; min-width: 64px;
  border: 1px solid rgba(193,130,106,0.15);
  box-shadow: 0 1px 8px rgba(61,43,31,0.05);
}
.cd-num { font-family: var(--serif); font-size: 2rem; color: var(--rose); line-height: 1; display: block; }
.cd-lbl { font-size: 0.57rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--stone); margin-top: 0.15rem; display: block; }

/* ── GALLERY ── */
.gallery {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  grid-template-rows: auto auto;
  gap: 0.5rem;
}
.gallery-item { overflow: hidden; border-radius: var(--r8); cursor: pointer; }
.gallery-item:first-child { grid-column: span 2; aspect-ratio: 2 / 1.2; }
.gallery-item:not(:first-child) { aspect-ratio: 1; }
.gallery-item img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.45s ease; display: block; }
.gallery-item:hover img { transform: scale(1.06); }

/* ── LOVE STORY ── */
.timeline { position: relative; padding-left: 2rem; }
.timeline::before { content: ''; position: absolute; left: 0.55rem; top: 0.5rem; bottom: 0; width: 1px; background: linear-gradient(180deg, var(--rose), transparent); opacity: 0.25; }
.tl-item { position: relative; margin-bottom: 2rem; }
.tl-dot { position: absolute; left: -1.55rem; top: 5px; width: 9px; height: 9px; border-radius: 50%; background: var(--rose); border: 2px solid white; box-shadow: 0 0 0 2px rgba(193,130,106,0.2); }
.tl-date { font-size: 0.68rem; font-weight: 500; color: var(--rose); letter-spacing: 0.1em; margin-bottom: 0.2rem; }
.tl-title { font-family: var(--serif); font-style: italic; font-size: 1.05rem; color: var(--bark); margin-bottom: 0.25rem; }
.tl-body { font-size: 0.82rem; color: var(--stone); line-height: 1.75; }

/* ── FORM ── */
.form-panel { background: white; border-radius: var(--r16); padding: 1.5rem; border: 1px solid rgba(193,130,106,0.1); box-shadow: 0 2px 12px rgba(61,43,31,0.04); }
.finput {
  width: 100%; padding: 0.65rem 0.9rem;
  border: 1.5px solid #E8DDD6; border-radius: var(--r8);
  font-family: var(--sans); font-size: 0.84rem; color: var(--bark);
  background: white; outline: none; margin-bottom: 0.65rem;
  transition: border-color 0.2s;
}
.finput:focus { border-color: var(--rose); }
.finput::placeholder { color: #BDB0A8; }
.attend-row { display: flex; gap: 0.5rem; margin-bottom: 0.65rem; }
.attend-btn {
  flex: 1; padding: 0.65rem; border-radius: var(--r8);
  border: 1.5px solid #E8DDD6; background: white;
  font-family: var(--sans); font-size: 0.8rem; color: var(--stone);
  cursor: pointer; transition: all 0.2s; text-align: center;
}
.attend-btn.yes { border-color: #10B981; background: #F0FDF4; color: #065F46; }
.attend-btn.no  { border-color: #EF4444; background: #FFF1F2; color: #991B1B; }
.submit-btn {
  width: 100%; background: var(--rose); color: white; border: none;
  padding: 0.8rem; border-radius: var(--r8);
  font-family: var(--sans); font-size: 0.88rem; font-weight: 500;
  cursor: pointer; transition: background 0.2s;
}
.submit-btn:hover { background: var(--bark); }
.wish-item {
  padding: 1rem; background: var(--ivory); border-radius: var(--r8);
  margin-bottom: 0.6rem; border-left: 3px solid rgba(193,130,106,0.3);
}
.wish-name { font-weight: 500; font-size: 0.83rem; color: var(--bark); margin-bottom: 0.15rem; }
.wish-msg  { font-size: 0.8rem; color: var(--stone); line-height: 1.65; }
.wish-time { font-size: 0.65rem; color: #C4B8B0; margin-top: 0.25rem; }

/* ── GIFT ── */
.gift-row {
  background: white; border-radius: var(--r8); padding: 0.9rem 1.1rem;
  display: flex; align-items: center; gap: 0.9rem; margin-bottom: 0.6rem;
  border: 1px solid rgba(193,130,106,0.1);
}
.gift-bank { font-size: 0.62rem; font-weight: 600; letter-spacing: 0.08em; color: var(--rose); width: 40px; flex-shrink: 0; }
.copy-btn {
  padding: 0.28rem 0.65rem; font-size: 0.7rem; font-weight: 500;
  background: var(--sand); color: var(--rose);
  border: 1px solid rgba(193,130,106,0.2); border-radius: var(--r4);
  cursor: pointer; flex-shrink: 0; transition: all 0.2s;
}
.copy-btn:hover { background: var(--rose); color: white; }

/* ── FLOATS ── */
.floats { position: fixed; bottom: 1.25rem; right: 1rem; z-index: 200; display: flex; flex-direction: column; gap: 0.5rem; align-items: flex-end; }
.float-btn {
  border: none; cursor: pointer; display: flex; align-items: center; justify-content: center;
  box-shadow: 0 4px 16px rgba(61,43,31,0.18); transition: transform 0.2s;
  font-family: var(--sans); font-weight: 500;
}
.float-btn:hover { transform: scale(1.08); }
.float-music { width: 46px; height: 46px; border-radius: 50%; background: var(--rose); color: white; font-size: 1.1rem; }
.float-gift  { height: 46px; min-width: 46px; border-radius: 23px; background: #25D366; color: white; font-size: 0.72rem; padding: 0 0.85rem; gap: 0.3rem; }
.float-share { width: 46px; height: 46px; border-radius: 50%; background: white; color: var(--bark); border: 1px solid rgba(193,130,106,0.15); }

/* ── MODALS ── */
.overlay { position: fixed; inset: 0; background: rgba(61,43,31,0.45); z-index: 300; display: flex; align-items: flex-end; justify-content: center; opacity: 0; pointer-events: none; transition: opacity 0.3s; }
.overlay.open { opacity: 1; pointer-events: all; }
.sheet { background: white; border-radius: 20px 20px 0 0; padding: 1.5rem; width: 100%; max-width: 460px; transform: translateY(100%); transition: transform 0.35s cubic-bezier(0.34, 1.26, 0.64, 1); }
.overlay.open .sheet { transform: translateY(0); }
.sheet-handle { width: 36px; height: 3px; background: #E8DDD6; border-radius: 2px; margin: 0 auto 1.25rem; }
.sheet-title { font-family: var(--serif); font-style: italic; font-size: 1.15rem; color: var(--bark); margin-bottom: 1.1rem; }
.center-overlay { position: fixed; inset: 0; background: rgba(61,43,31,0.45); z-index: 300; display: flex; align-items: center; justify-content: center; padding: 1rem; opacity: 0; pointer-events: none; transition: opacity 0.3s; }
.center-overlay.open { opacity: 1; pointer-events: all; }
.dialog { background: white; border-radius: var(--r16); padding: 1.5rem; width: 100%; max-width: 400px; transform: scale(0.92); transition: transform 0.3s cubic-bezier(0.34, 1.26, 0.64, 1); }
.center-overlay.open .dialog { transform: scale(1); }
.share-row { display: flex; gap: 0.5rem; margin-bottom: 0.5rem; }
.share-half { flex: 1; padding: 0.7rem; border-radius: var(--r8); border: none; font-family: var(--sans); font-size: 0.8rem; font-weight: 500; cursor: pointer; transition: all 0.2s; }
.lightbox { position: fixed; inset: 0; background: rgba(0,0,0,0.92); z-index: 400; display: flex; align-items: center; justify-content: center; opacity: 0; pointer-events: none; transition: opacity 0.3s; }
.lightbox.open { opacity: 1; pointer-events: all; }
.lightbox img { max-width: 92vw; max-height: 90vh; object-fit: contain; border-radius: var(--r8); }
.lb-close { position: absolute; top: 1rem; right: 1rem; background: rgba(255,255,255,0.12); color: white; border: none; border-radius: 50%; width: 40px; height: 40px; font-size: 1.1rem; cursor: pointer; }

/* ── FOOTER ── */
footer { background: var(--bark); color: rgba(255,255,255,0.4); text-align: center; padding: 2rem 1rem; font-size: 0.75rem; }
footer strong { color: rgba(255,255,255,0.75); }
</style>
</head>
<body>
@php $coupleOrder = $invitation->couple_order ?? "bride_first"; @endphp

@if(empty($isPreview))
<div id="opening">
  <div class="op-inner">
    <div class="op-arc">💌</div>
    @if(!empty($guestName))
      <p class="op-eyebrow">Kepada Yth.</p>
      <p class="op-to-name">{{ $guestName }}</p>
    @endif
    <p class="op-from">@if($coupleOrder==='groom_first'){{ $invitation->groom_nickname ?: $invitation->groom_name }} &amp; {{ $invitation->bride_nickname ?: $invitation->bride_name }}@else{{ $invitation->bride_nickname ?: $invitation->bride_name }} &amp; {{ $invitation->groom_nickname ?: $invitation->groom_name }}@endif</p>
    @if($invitation->akad_date)
      <p class="op-date">{{ \Carbon\Carbon::parse($invitation->akad_date)->isoFormat('D MMMM YYYY') }}</p>
    @endif
    <button class="op-cta" onclick="openInvitation()">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><polyline points="2,5 12,13 22,5"/></svg>
      Buka Undangan
    </button>
  </div>
</div>
@endif

<div id="main" class="{{ !empty($isPreview) ? 'show' : '' }}">

@if(!empty($guestName))
  <div class="guest-strip">Undangan untuk: <strong>{{ $guestName }}</strong></div>
@endif

<!-- HERO -->
<section class="hero">
  <div class="hero-bg-circle"></div>
  <div class="hero-photo-frame">
    @if($invitation->cover_photo)
      <img src="{{ asset('storage/'.$invitation->cover_photo) }}" alt="">
    @else
      <div class="ph">💑</div>
    @endif
  </div>
  <div class="hero-text">
    <p class="hero-eyebrow">Undangan Pernikahan</p>
    <h1 class="hero-names">
      @if($coupleOrder === 'groom_first')
        {{ $invitation->groom_nickname ?: ($invitation->groom_name ?: 'Pengantin Pria') }}
        <span class="hero-amp">&amp;</span>
        {{ $invitation->bride_nickname ?: ($invitation->bride_name ?: 'Pengantin Wanita') }}
      @else
        {{ $invitation->bride_nickname ?: ($invitation->bride_name ?: 'Pengantin Wanita') }}
        <span class="hero-amp">&amp;</span>
        {{ $invitation->groom_nickname ?: ($invitation->groom_name ?: 'Pengantin Pria') }}
      @endif
    </h1>
    <div class="hero-rule"><span></span><b>✦</b><span></span></div>
    @if($invitation->akad_date)
      <p class="hero-date">{{ \Carbon\Carbon::parse($invitation->akad_date)->isoFormat('dddd, D MMMM YYYY') }}</p>
    @endif
    <span class="hero-scroll">↓</span>
  </div>
</section>

<!-- BISMILLAH / OPENING TEXT -->
@if($invitation->opening_text)
<section style="background: var(--light); padding: 3.5rem 1.5rem;">
  <div class="opening-card sr" style="max-width: 560px; margin: 0 auto;">
    {!! $invitation->opening_text !!}
  </div>
</section>
@endif

<!-- COUPLE -->
<section style="background: var(--ivory);">
  <div class="sect sr">
    <div class="sect-head">
      <span class="eyebrow">Kedua Mempelai</span>
      <h2 class="headline">Dengan Penuh Rasa Syukur</h2>
      <div class="rule-thin"></div>
    </div>
    <div class="couple-wrap">
      <div class="couple-card sr">
        @if($invitation->groom_photo)
          <img src="{{ asset('storage/'.$invitation->groom_photo) }}" class="cp-photo" alt="">
        @else
          <div class="cp-photo-ph">🤵</div>
        @endif
        <div class="cp-info">
          <p class="cp-role">Pengantin Pria</p>
          <h3 class="cp-name">{{ $invitation->groom_name ?: 'Pengantin Pria' }}</h3>
          <p class="cp-parents">Putra dari Bapak {{ $invitation->groom_father ?: '…' }}<br>dan Ibu {{ $invitation->groom_mother ?: '…' }}</p>
          @if($invitation->groom_instagram)<a href="https://instagram.com/{{ $invitation->groom_instagram }}" target="_blank" class="cp-ig">@ {{ $invitation->groom_instagram }}</a>@endif
        </div>
      </div>
      <div class="couple-amp">✦</div>
      <div class="couple-card bride sr">
        @if($invitation->bride_photo)
          <img src="{{ asset('storage/'.$invitation->bride_photo) }}" class="cp-photo" alt="">
        @else
          <div class="cp-photo-ph">👰</div>
        @endif
        <div class="cp-info" style="text-align: right;">
          <p class="cp-role">Pengantin Wanita</p>
          <h3 class="cp-name">{{ $invitation->bride_name ?: 'Pengantin Wanita' }}</h3>
          <p class="cp-parents">Putri dari Bapak {{ $invitation->bride_father ?: '…' }}<br>dan Ibu {{ $invitation->bride_mother ?: '…' }}</p>
          @if($invitation->bride_instagram)<a href="https://instagram.com/{{ $invitation->bride_instagram }}" target="_blank" class="cp-ig">@ {{ $invitation->bride_instagram }}</a>@endif
        </div>
      </div>
    </div>
  </div>
</section>

<!-- EVENTS + COUNTDOWN -->
<section style="background: var(--light);">
  <div class="sect sr">
    <div class="sect-head">
      <span class="eyebrow">Tanggal Pernikahan</span>
      <h2 class="headline">Hari yang Kami Nantikan</h2>
      <div class="rule-thin"></div>
    </div>
    @if($invitation->akad_date)
    <div style="text-align: center; margin-bottom: 1.75rem;">
      <p style="font-size: 0.72rem; color: var(--stone); margin-bottom: 0.5rem; letter-spacing: 0.08em;">Menghitung hari…</p>
      <div class="countdown" id="countdown"></div>
    </div>
    @endif
    @if($invitation->akad_date)
    <div class="event-card sr">
      <p class="ev-badge">Akad Nikah</p>
      <h3 class="ev-title">Ijab Qobul</h3>
      <div class="ev-row"><i class="ev-icon">📅</i>{{ \Carbon\Carbon::parse($invitation->akad_date)->isoFormat('dddd, D MMMM YYYY') }}</div>
      @if($invitation->akad_time_start)<div class="ev-row"><i class="ev-icon">🕐</i>{{ $invitation->akad_time_start }}{{ $invitation->akad_time_end ? ' – '.$invitation->akad_time_end : '' }} WIB</div>@endif
      @if($invitation->akad_venue)<div class="ev-row"><i class="ev-icon">📍</i><div>{{ $invitation->akad_venue }}@if($invitation->akad_address)<br><span style="color: #C4B8B0; font-size: 0.78rem;">{{ $invitation->akad_address }}</span>@endif</div></div>@endif
      @if($invitation->akad_maps_url)<a href="{{ $invitation->akad_maps_url }}" target="_blank" class="ev-maps">Buka di Maps →</a>@endif
    </div>
    @endif
    @if($invitation->resepsi_date)
    <div class="event-card sr">
      <p class="ev-badge">Resepsi Pernikahan</p>
      <h3 class="ev-title">Walimatul Ursy</h3>
      <div class="ev-row"><i class="ev-icon">📅</i>{{ \Carbon\Carbon::parse($invitation->resepsi_date)->isoFormat('dddd, D MMMM YYYY') }}</div>
      @if($invitation->resepsi_time_start)<div class="ev-row"><i class="ev-icon">🕐</i>{{ $invitation->resepsi_time_start }}{{ $invitation->resepsi_time_end ? ' – '.$invitation->resepsi_time_end : '' }} WIB</div>@endif
      @if($invitation->resepsi_venue)<div class="ev-row"><i class="ev-icon">📍</i><div>{{ $invitation->resepsi_venue }}@if($invitation->resepsi_address)<br><span style="color: #C4B8B0; font-size: 0.78rem;">{{ $invitation->resepsi_address }}</span>@endif</div></div>@endif
      @if($invitation->resepsi_maps_url)<a href="{{ $invitation->resepsi_maps_url }}" target="_blank" class="ev-maps">Buka di Maps →</a>@endif
    </div>
    @endif
    @if($invitation->livestream_url)
    <div class="event-card sr" style="--rose: #7C3AED;">
      <p class="ev-badge">Live Streaming</p>
      <h3 class="ev-title">Saksikan Secara Online</h3>
      <a href="{{ $invitation->livestream_url }}" target="_blank" class="ev-maps" style="color: #7C3AED;">▶ Tonton Live →</a>
    </div>
    @endif
  </div>
</section>

<!-- GALLERY -->
@if($invitation->photos && $invitation->photos->count() > 0)
<section style="background: var(--ivory);">
  <div class="sect sr">
    <div class="sect-head">
      <span class="eyebrow">Galeri Foto</span>
      <h2 class="headline">Momen Bersama</h2>
      <div class="rule-thin"></div>
    </div>
    <div class="gallery">
      @foreach($invitation->photos->take(9) as $photo)
        <div class="gallery-item" onclick="openLightbox('{{ asset('storage/'.$photo->photo) }}')">
          <img src="{{ asset('storage/'.$photo->photo) }}" alt="" loading="lazy">
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- LOVE STORY -->
@php $stories = is_array($invitation->love_story_items) ? $invitation->love_story_items : (json_decode($invitation->love_story_items, true) ?? []); @endphp
@if(count($stories) > 0)
<section style="background: var(--light);">
  <div class="sect sr">
    <div class="sect-head">
      <span class="eyebrow">Our Story</span>
      <h2 class="headline">Perjalanan Cinta Kami</h2>
      <div class="rule-thin"></div>
    </div>
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
@elseif($invitation->love_story)
<section style="background: var(--light);">
  <div class="sect sr">
    <div class="sect-head">
      <span class="eyebrow">Our Story</span>
      <h2 class="headline">Perjalanan Cinta Kami</h2>
      <div class="rule-thin"></div>
    </div>
    <p style="font-family: var(--serif); font-style: italic; font-size: 0.95rem; color: var(--stone); line-height: 2;">{!! nl2br(e($invitation->love_story)) !!}</p>
  </div>
</section>
@endif

<!-- RSVP -->
<section style="background: var(--ivory);">
  <div class="sect sr">
    <div class="sect-head">
      <span class="eyebrow">RSVP</span>
      <h2 class="headline">Konfirmasi Kehadiran</h2>
      <div class="rule-thin"></div>
    </div>
    <div class="form-panel">
      <div id="rsvp-success" style="display:none; text-align:center; padding: 2rem;">
        <p style="font-family: var(--serif); font-style: italic; font-size: 1.3rem; color: var(--rose);">Terima Kasih!</p>
        <p style="font-size: 0.82rem; color: var(--stone); margin-top: 0.4rem;">Konfirmasi kehadiranmu sudah kami catat.</p>
      </div>
      <div id="rsvp-form">
        <input class="finput" id="r-name" placeholder="Nama lengkap" value="{{ $guestName ?? '' }}">
        <input class="finput" id="r-phone" placeholder="No. WhatsApp (opsional)" type="tel">
        <input class="finput" id="r-pax" placeholder="Jumlah tamu" type="number" value="1" min="1" max="20">
        <p style="font-size: 0.74rem; color: var(--stone); margin-bottom: 0.4rem;">Konfirmasi kehadiran:</p>
        <div class="attend-row">
          <button class="attend-btn" id="btn-hadir" onclick="setAttend('hadir')">✅ Hadir</button>
          <button class="attend-btn" id="btn-tidak" onclick="setAttend('tidak_hadir')">❌ Tidak Hadir</button>
        </div>
        <textarea class="finput" id="r-msg" rows="2" placeholder="Pesan untuk pengantin (opsional)" style="resize:none;"></textarea>
        <button class="submit-btn" onclick="submitRSVP()">Kirim Konfirmasi</button>
      </div>
    </div>

    <!-- WISHES -->
    <div style="margin-top: 2.5rem;">
      <div class="sect-head" style="margin-bottom: 1.5rem;">
        <span class="eyebrow">Ucapan &amp; Doa</span>
      </div>
      <div class="form-panel" style="margin-bottom: 1.25rem;">
        <input class="finput" id="w-name" placeholder="Nama kamu">
        <textarea class="finput" id="w-msg" rows="3" placeholder="Kirimkan ucapan dan doa tulus untuk kedua mempelai…" style="resize:none;"></textarea>
        <button class="submit-btn" onclick="submitWish()">Kirim Ucapan 🙏</button>
      </div>
      <div id="wishes-list">
        @php $_wishes = $invitation->id ? $invitation->wishes()->where('is_visible',true)->latest()->take(10)->get() : collect(); @endphp
        @foreach($_wishes as $w)
        <div class="wish-item">
          <p class="wish-name">{{ $w->name }}</p>
          <p class="wish-msg">{{ $w->message }}</p>
          <p class="wish-time">{{ $w->created_at->diffForHumans() }}</p>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>

<!-- CLOSING -->
@if($invitation->closing_text)
<section style="background: var(--sand); padding: 4rem 1.5rem; text-align: center;">
  <div class="sr" style="max-width: 560px; margin: 0 auto;">
    <p style="font-family: var(--serif); font-style: italic; font-size: 0.95rem; color: var(--stone); line-height: 2.1;">{!! $invitation->closing_text !!}</p>
    <div class="hero-rule" style="margin: 1.5rem auto;"><span></span><b>✦</b><span></span></div>
    <p style="font-family: var(--serif); font-style: italic; font-size: 1.5rem; color: var(--bark);">
      @if($coupleOrder==='groom_first'){{ $invitation->groom_nickname ?: $invitation->groom_name }} &amp; {{ $invitation->bride_nickname ?: $invitation->bride_name }}@else{{ $invitation->bride_nickname ?: $invitation->bride_name }} &amp; {{ $invitation->groom_nickname ?: $invitation->groom_name }}@endif
    </p>
  </div>
</section>
@endif

<footer>
  <p>💝 <strong>{{ $invitation->title ?: 'Undangan Pernikahan' }}</strong></p>
  <p style="margin-top: 0.35rem;">Dibuat dengan ❤️ oleh <strong>UndanganKu</strong></p>
</footer>
</div>

<!-- FLOATING BUTTONS -->
<div class="floats" id="floats" style="{{ empty($isPreview) ? 'display:none' : '' }}">
  @if($invitation->music_file || $invitation->selected_music_key)
  <button class="float-btn float-music" id="music-btn" onclick="toggleMusic()" title="Musik">🎵</button>
  @endif
  @if($invitation->gifts && $invitation->gifts->count() > 0)
  <button class="float-btn float-gift" onclick="document.getElementById('gift-overlay').classList.add('open')">
    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 12v10H4V12"/><path d="M22 7H2v5h20V7z"/><path d="M12 22V7"/><path d="M12 7H7.5a2.5 2.5 0 010-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 000-5C13 2 12 7 12 7z"/></svg>
    Hadiah
  </button>
  @endif
  <button class="float-btn float-share" onclick="document.getElementById('share-overlay').classList.add('open')" title="Bagikan">
    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
  </button>
</div>

<!-- GIFT SHEET -->
@if($invitation->gifts && $invitation->gifts->count() > 0)
<div class="overlay" id="gift-overlay" onclick="if(event.target===this)this.classList.remove('open')">
  <div class="sheet">
    <div class="sheet-handle"></div>
    <h3 class="sheet-title">Kirim Hadiah 💝</h3>
    @foreach($invitation->gifts as $g)
    <div class="gift-row">
      <div class="gift-bank">{{ strtoupper(substr($g->bank_name,0,4)) }}</div>
      <div style="flex:1;">
        <p style="font-weight:600;font-size:0.88rem;">{{ $g->bank_name }}</p>
        <p style="font-size:0.83rem;color:var(--stone);">{{ $g->account_number }}</p>
        <p style="font-size:0.72rem;color:#C4B8B0;">a.n. {{ $g->account_name }}</p>
      </div>
      <button class="copy-btn" onclick="copyText('{{ $g->account_number }}', this)">Salin</button>
    </div>
    @endforeach
  </div>
</div>
@endif

<!-- SHARE DIALOG -->
<div class="center-overlay" id="share-overlay" onclick="if(event.target===this)this.classList.remove('open')">
  <div class="dialog">
    <p style="font-family:var(--serif);font-style:italic;font-size:1.1rem;margin-bottom:1rem;color:var(--bark);">Bagikan Undangan</p>
    <div style="display:flex;align-items:center;gap:0.4rem;background:var(--ivory);border-radius:var(--r8);padding:0.5rem 0.75rem;margin-bottom:1rem;border:1px solid rgba(193,130,106,0.15);">
      <input type="text" id="share-link" readonly value="{{ url('/'.$invitation->slug) }}" style="flex:1;border:none;background:transparent;font-size:0.72rem;outline:none;color:var(--stone);">
      <button onclick="copyText(document.getElementById('share-link').value, this)" style="background:var(--rose);color:white;border:none;border-radius:var(--r4);padding:0.28rem 0.65rem;font-size:0.72rem;cursor:pointer;">Salin</button>
    </div>
    <p style="font-size:0.72rem;color:var(--stone);margin-bottom:0.5rem;">Nama tamu (opsional, untuk link personal):</p>
    <input type="text" id="share-guest" class="finput" placeholder="Nama Tamu" style="margin-bottom:0.75rem;">
    <div class="share-row">
      <button class="share-half" style="background:var(--ivory);color:var(--bark);border:1px solid rgba(193,130,106,0.15);" onclick="doShare(false)">Tanpa Nama</button>
      <button class="share-half" style="background:var(--sand);color:var(--rose);" onclick="doShare(true)">Dengan Nama</button>
    </div>
    <button onclick="doShareWA()" style="width:100%;background:#25D366;color:white;border:none;padding:0.72rem;border-radius:var(--r8);font-family:var(--sans);font-size:0.82rem;font-weight:500;cursor:pointer;">
      Broadcast WhatsApp →
    </button>
  </div>
</div>

<!-- LIGHTBOX -->
<div class="lightbox" id="lightbox" onclick="this.classList.remove('open')">
  <button class="lb-close">✕</button>
  <img id="lightbox-img" src="" alt="">
</div>

<!-- AUDIO -->
@if($invitation->music_file)
<audio id="audio" loop><source src="{{ asset('storage/'.$invitation->music_file) }}"></audio>
@elseif($invitation->selected_music_key)
<audio id="audio" loop><source src="{{ $invitation->selected_music_key }}"></audio>
@endif

<script>
const SLUG = '{{ $invitation->slug }}';
let attending = '', musicPlaying = false;

function openInvitation() {
  const audio = document.getElementById('audio');
  if (audio) { audio.play().then(() => { musicPlaying = true; updateMusicBtn(); }).catch(() => {}); }
  document.getElementById('opening').classList.add('away');
  const main = document.getElementById('main');
  main.classList.add('show');
  document.getElementById('floats').style.display = 'flex';
}

// Scroll reveal
const observer = new IntersectionObserver(entries => {
  entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('in'); observer.unobserve(e.target); } });
}, { threshold: 0.1 });
document.querySelectorAll('.sr').forEach(el => observer.observe(el));

// Countdown
@if($invitation->akad_date)
(function countdown() {
  const target = new Date('{{ $invitation->akad_date }}').getTime();
  const el = document.getElementById('countdown');
  function tick() {
    const diff = target - Date.now();
    if (diff <= 0) { el.innerHTML = '<span style="font-family:var(--serif);font-style:italic;color:var(--rose);font-size:1.2rem;">Hari Bahagia Telah Tiba 🎉</span>'; return; }
    const parts = [
      { v: Math.floor(diff / 86400000), l: 'Hari' },
      { v: Math.floor(diff % 86400000 / 3600000), l: 'Jam' },
      { v: Math.floor(diff % 3600000 / 60000), l: 'Menit' },
      { v: Math.floor(diff % 60000 / 1000), l: 'Detik' }
    ];
    el.innerHTML = parts.map(p => `<div class="cd-box"><span class="cd-num">${String(p.v).padStart(2,'0')}</span><span class="cd-lbl">${p.l}</span></div>`).join('');
  }
  tick(); setInterval(tick, 1000);
})();
@endif

// RSVP
function setAttend(v) {
  attending = v;
  document.getElementById('btn-hadir').className = 'attend-btn' + (v === 'hadir' ? ' yes' : '');
  document.getElementById('btn-tidak').className = 'attend-btn' + (v === 'tidak_hadir' ? ' no' : '');
}
async function submitRSVP() {
  const name = document.getElementById('r-name').value.trim();
  if (!name) return alert('Masukkan nama kamu!');
  if (!attending) return alert('Pilih konfirmasi kehadiran!');
  const res = await fetch('/' + SLUG + '/rsvp', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
    body: JSON.stringify({ name, phone: document.getElementById('r-phone').value, pax: document.getElementById('r-pax').value, attendance: attending, message: document.getElementById('r-msg').value })
  });
  const data = await res.json();
  if (data.success) { document.getElementById('rsvp-form').style.display = 'none'; document.getElementById('rsvp-success').style.display = 'block'; }
  else alert('Gagal mengirim. Coba lagi ya!');
}

// Wishes
async function submitWish() {
  const name = document.getElementById('w-name').value.trim();
  const msg = document.getElementById('w-msg').value.trim();
  if (!name || !msg) return alert('Lengkapi nama dan ucapan!');
  const res = await fetch('/' + SLUG + '/wish', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
    body: JSON.stringify({ name, message: msg })
  });
  const data = await res.json();
  if (data.success) {
    document.getElementById('w-name').value = '';
    document.getElementById('w-msg').value = '';
    const item = document.createElement('div');
    item.className = 'wish-item';
    item.innerHTML = `<p class="wish-name">${name}</p><p class="wish-msg">${msg}</p><p class="wish-time">Baru saja</p>`;
    document.getElementById('wishes-list').prepend(item);
  }
}

// Copy
function copyText(text, btn) {
  navigator.clipboard.writeText(text).then(() => {
    const orig = btn.textContent;
    btn.textContent = '✓ Disalin';
    setTimeout(() => { btn.textContent = orig; }, 2000);
  });
}

// Music
function toggleMusic() {
  const a = document.getElementById('audio');
  if (!a) return;
  if (a.paused) { a.play(); musicPlaying = true; } else { a.pause(); musicPlaying = false; }
  updateMusicBtn();
}
function updateMusicBtn() {
  const btn = document.getElementById('music-btn');
  if (btn) btn.textContent = musicPlaying ? '🎵' : '🔇';
}

// Lightbox
function openLightbox(src) {
  document.getElementById('lightbox-img').src = src;
  document.getElementById('lightbox').classList.add('open');
}

// Share
function doShare(withName) {
  const name = document.getElementById('share-guest').value.trim();
  const link = window.location.origin + '/' + SLUG + (withName && name ? '?untuk=' + encodeURIComponent(name) : '');
  navigator.clipboard.writeText(link).then(() => alert('Link disalin!'));
}
function doShareWA() {
  const name = document.getElementById('share-guest').value.trim();
  const link = window.location.origin + '/' + SLUG + (name ? '?untuk=' + encodeURIComponent(name) : '');
  const g = {!! json_encode($invitation->groom_nickname ?: $invitation->groom_name ?: '') !!};
  const b = {!! json_encode($invitation->bride_nickname ?: $invitation->bride_name ?: '') !!};
  let msg = {!! json_encode($invitation->invitation_message ?: '') !!} || `Kepada *${name || 'Bapak/Ibu/Saudara/i'}*\n\nLink: ${link}\n\n${g} & ${b}`;
  msg = msg.replace(/\{nama_tamu\}/g, name || 'Bapak/Ibu/Saudara/i').replace(/\{link_undangan\}/g, link).replace(/\{nama_pengantin_pria\}/g, g).replace(/\{nama_pengantin_wanita\}/g, b);
  window.open('https://wa.me/?text=' + encodeURIComponent(msg), '_blank');
}
</script>
</body>
</html>
