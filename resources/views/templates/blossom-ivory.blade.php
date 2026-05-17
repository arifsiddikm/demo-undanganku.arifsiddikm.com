<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>{{ $invitation->title ?? 'Undangan Pernikahan' }}</title>
<link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;1,400&family=Nunito:wght@300;400;600&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box;margin:0;padding:0}
:root{
  --p:{{ $invitation->color_primary ?? '#8B6F5E' }};
  --s:{{ $invitation->color_secondary ?? '#F2EAE1' }};
  --bg:#FDFAF7;--text:#3A2E28;--muted:#9A8880;
  --serif:'Lora',serif;--sans:'Nunito',sans-serif;
}
html{scroll-behavior:smooth}
body{font-family:var(--sans);background:var(--bg);color:var(--text);overflow-x:hidden}

/* OPENING */
#op{position:fixed;inset:0;z-index:9999;background:var(--s);display:flex;align-items:center;justify-content:center;transition:transform .9s cubic-bezier(.76,0,.24,1)}
#op.gone{transform:translateY(-100%)}
.op-wrap{text-align:center;padding:2rem;max-width:380px;width:90%}
.op-deco{font-family:var(--serif);font-size:1.5rem;color:var(--p);opacity:.5;letter-spacing:.5rem;margin-bottom:1.5rem}
.op-to{font-size:.65rem;letter-spacing:.2em;text-transform:uppercase;color:var(--muted);margin-bottom:.4rem}
.op-guest{font-family:var(--serif);font-size:2.2rem;font-style:italic;color:var(--text);margin-bottom:.3rem;min-height:2.8rem}
.op-names{font-family:var(--serif);font-size:1.3rem;color:var(--p);margin-bottom:.5rem}
.op-date{font-size:.82rem;color:var(--muted);margin-bottom:2.5rem}
.op-btn{display:inline-flex;align-items:center;gap:.5rem;background:var(--p);color:white;padding:.85rem 2.5rem;border-radius:4px;border:none;cursor:pointer;font-family:var(--sans);font-size:.88rem;font-weight:600;letter-spacing:.04em;transition:opacity .2s}
.op-btn:hover{opacity:.85}

/* MAIN */
#mc{opacity:0;transition:opacity .4s ease .15s}
#mc.vis{opacity:1}
.gbanner{position:sticky;top:0;z-index:99;background:var(--p);color:white;text-align:center;padding:.45rem 1rem;font-size:.78rem}

/* HERO */
.hero{min-height:100svh;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:5rem 1.5rem 4rem;background:linear-gradient(175deg,#FFF9F4 0%,var(--s) 60%,var(--bg) 100%)}
.hero-ornament{font-family:var(--serif);font-size:1.1rem;color:var(--p);letter-spacing:.4rem;opacity:.5;margin-bottom:2rem}
.hero-announce{font-size:.65rem;font-weight:600;letter-spacing:.25em;text-transform:uppercase;color:var(--muted);margin-bottom:1.25rem}
.hero-couple{font-family:var(--serif);font-size:clamp(2.8rem,10vw,5rem);font-style:italic;line-height:1.1;color:var(--text);margin-bottom:.5rem}
.hero-amp{color:var(--p)}
.hero-divider{display:flex;align-items:center;gap:1rem;margin:1.25rem auto;width:200px}
.hero-divider span{flex:1;height:1px;background:var(--p);opacity:.3}
.hero-divider i{font-family:var(--serif);color:var(--p);font-size:.75rem;font-style:normal}
.hero-date{font-family:var(--serif);font-size:1rem;color:var(--muted);margin-bottom:.5rem}
.hero-photo{width:200px;height:240px;border-radius:4px;overflow:hidden;margin:1.75rem auto;border:6px solid white;box-shadow:0 8px 32px rgba(139,111,94,.12)}
.hero-photo img,.hero-photo .ph{width:100%;height:100%;object-fit:cover}
.hero-photo .ph{background:linear-gradient(160deg,#F5EDE7,#E8D8CE);display:flex;align-items:center;justify-content:center;font-size:3rem}

/* REVEAL */
.rv{opacity:0;transform:translateY(20px);transition:opacity .65s ease,transform .65s ease}
.rv.iv{opacity:1;transform:translateY(0)}

/* SECTION */
.sec{padding:4rem 1.5rem;max-width:620px;margin:0 auto}
.sec-hd{text-align:center;margin-bottom:2rem}
.sec-label{font-size:.62rem;font-weight:600;letter-spacing:.2em;text-transform:uppercase;color:var(--p);display:block;margin-bottom:.4rem}
.sec-title{font-family:var(--serif);font-size:clamp(1.6rem,5vw,2.2rem);font-style:italic;color:var(--text)}
.sec-line{width:40px;height:2px;background:var(--p);margin:.75rem auto 0;opacity:.4}

/* COUPLE CARDS */
.couple-grid{display:grid;grid-template-columns:1fr 1fr;gap:1rem}
.cc{background:white;border-radius:8px;padding:1.5rem 1.25rem;text-align:center;border:1px solid rgba(139,111,94,.1);box-shadow:0 2px 12px rgba(139,111,94,.06)}
.cc-img{width:100px;height:120px;border-radius:4px;object-fit:cover;margin:0 auto .85rem;display:block;border:3px solid var(--s)}
.cc-img-ph{width:100px;height:120px;border-radius:4px;background:var(--s);margin:0 auto .85rem;display:flex;align-items:center;justify-content:center;font-size:2rem}
.cc-label{font-size:.6rem;letter-spacing:.15em;text-transform:uppercase;color:var(--p);margin-bottom:.3rem}
.cc-name{font-family:var(--serif);font-size:1.2rem;font-style:italic;color:var(--text);margin-bottom:.3rem}
.cc-parents{font-size:.75rem;color:var(--muted);line-height:1.6}

/* EVENTS */
.ev-card{background:white;border-radius:8px;padding:1.5rem;margin-bottom:.85rem;border-left:3px solid var(--p);box-shadow:0 2px 8px rgba(0,0,0,.04)}
.ev-type{font-size:.6rem;font-weight:700;letter-spacing:.15em;text-transform:uppercase;color:var(--p);margin-bottom:.3rem}
.ev-name{font-family:var(--serif);font-size:1.35rem;font-style:italic;color:var(--text);margin-bottom:.65rem}
.ev-row{display:flex;gap:.5rem;font-size:.82rem;color:var(--muted);margin-bottom:.3rem;align-items:flex-start}
.ev-icon{flex-shrink:0;color:var(--p);margin-top:1px}
.ev-link{display:inline-flex;align-items:center;gap:.3rem;color:var(--p);font-size:.78rem;text-decoration:none;margin-top:.5rem;font-weight:600}

/* COUNTDOWN */
.cd{display:flex;gap:.6rem;justify-content:center;flex-wrap:wrap;margin:1.25rem 0}
.cdb{background:white;border-radius:4px;padding:.65rem .85rem;text-align:center;min-width:60px;border:1px solid rgba(139,111,94,.15);box-shadow:0 1px 6px rgba(139,111,94,.08)}
.cdn{font-family:var(--serif);font-size:1.75rem;color:var(--p);line-height:1}
.cdl{font-size:.58rem;text-transform:uppercase;letter-spacing:.08em;color:var(--muted)}

/* GALLERY */
.gallery{display:grid;grid-template-columns:repeat(3,1fr);gap:.4rem}
.gi{overflow:hidden;border-radius:4px;cursor:pointer;aspect-ratio:1}
.gi:first-child{grid-column:span 2;aspect-ratio:2/1}
.gi img{width:100%;height:100%;object-fit:cover;transition:transform .4s}
.gi:hover img{transform:scale(1.05)}

/* TIMELINE */
.tl{padding-left:1.75rem;position:relative}
.tl::before{content:'';position:absolute;left:.5rem;top:0;bottom:0;width:1px;background:rgba(139,111,94,.2)}
.tli{position:relative;margin-bottom:1.75rem}
.tli::before{content:'';position:absolute;left:-1.4rem;top:5px;width:8px;height:8px;border-radius:50%;background:var(--p)}
.tli-date{font-size:.7rem;color:var(--p);font-weight:600;margin-bottom:.2rem}
.tli-title{font-family:var(--serif);font-size:1rem;font-style:italic;color:var(--text);margin-bottom:.2rem}
.tli-text{font-size:.82rem;color:var(--muted);line-height:1.7}

/* FORM */
.form-card{background:white;border-radius:8px;padding:1.5rem;border:1px solid rgba(139,111,94,.1)}
.fi{width:100%;padding:.6rem .85rem;border:1.5px solid #E8DDD7;border-radius:4px;font-family:var(--sans);font-size:.85rem;outline:none;margin-bottom:.65rem;color:var(--text);background:white;transition:border-color .2s}
.fi:focus{border-color:var(--p)}
.rr{display:flex;gap:.5rem;margin-bottom:.65rem}
.ro{flex:1;padding:.6rem;border:1.5px solid #E8DDD7;border-radius:4px;text-align:center;cursor:pointer;font-size:.8rem;transition:all .2s}
.ro.sh{border-color:#10B981;background:#F0FDF4;color:#065F46}
.ro.sn{border-color:#EF4444;background:#FFF1F2;color:#991B1B}
.sbtn{width:100%;background:var(--p);color:white;border:none;padding:.75rem;border-radius:4px;font-family:var(--sans);font-size:.88rem;font-weight:600;cursor:pointer;transition:opacity .2s}
.sbtn:hover{opacity:.85}
.wish-item{padding:.85rem 1rem;background:white;border-radius:6px;margin-bottom:.6rem;border-left:3px solid rgba(139,111,94,.3)}
.wname{font-weight:600;font-size:.82rem;margin-bottom:.15rem}
.wmsg{font-size:.8rem;color:var(--muted);line-height:1.6}
.wtime{font-size:.65rem;color:#C5B5AE;margin-top:.2rem}

/* GIFT */
.gift-row{background:white;border-radius:6px;padding:.85rem 1.1rem;margin-bottom:.6rem;display:flex;align-items:center;gap:.85rem;border:1px solid rgba(139,111,94,.1)}
.gift-bank{font-size:.65rem;font-weight:700;color:var(--p);width:44px;text-align:center;flex-shrink:0}
.cpbtn{padding:.25rem .65rem;background:var(--s);color:var(--p);border:1px solid rgba(139,111,94,.2);border-radius:4px;font-size:.7rem;cursor:pointer;flex-shrink:0;transition:all .2s}
.cpbtn:hover{background:var(--p);color:white}

/* FLOATS */
.fls{position:fixed;bottom:1.25rem;right:1rem;z-index:200;display:flex;flex-direction:column;gap:.5rem;align-items:flex-end}
.fb{border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:0 3px 12px rgba(0,0,0,.15);transition:transform .2s;border-radius:50px}
.fb:hover{transform:scale(1.08)}
.fb-music{width:44px;height:44px;background:var(--p);color:white;border-radius:50%;font-size:1rem}
.fb-gift{height:44px;min-width:44px;background:#25D366;color:white;padding:0 .85rem;font-size:.72rem;font-weight:700;gap:.3rem;font-family:var(--sans)}
.fb-share{width:44px;height:44px;background:white;color:var(--text);border:1px solid rgba(139,111,94,.15)}

/* MODAL */
.mo{position:fixed;inset:0;background:rgba(0,0,0,.4);z-index:300;display:flex;align-items:flex-end;justify-content:center;opacity:0;pointer-events:none;transition:opacity .3s}
.mo.on{opacity:1;pointer-events:all}
.mb{background:white;border-radius:16px 16px 0 0;padding:1.5rem;width:100%;max-width:440px;transform:translateY(100%);transition:transform .3s cubic-bezier(.34,1.56,.64,1)}
.mo.on .mb{transform:translateY(0)}
.mh{width:36px;height:3px;background:#E5E7EB;border-radius:2px;margin:0 auto 1.1rem}
.smo{position:fixed;inset:0;background:rgba(0,0,0,.4);z-index:300;display:flex;align-items:center;justify-content:center;padding:1rem;opacity:0;pointer-events:none;transition:opacity .3s}
.smo.on{opacity:1;pointer-events:all}
.smb{background:white;border-radius:12px;padding:1.5rem;width:100%;max-width:400px;transform:scale(.92);transition:transform .3s cubic-bezier(.34,1.56,.64,1)}
.smo.on .smb{transform:scale(1)}
.lbx{position:fixed;inset:0;background:rgba(0,0,0,.93);z-index:400;display:flex;align-items:center;justify-content:center;opacity:0;pointer-events:none;transition:opacity .3s}
.lbx.on{opacity:1;pointer-events:all}
.lbx img{max-width:92vw;max-height:90vh;object-fit:contain;border-radius:4px}
.lbx-x{position:absolute;top:.75rem;right:.75rem;background:rgba(255,255,255,.15);color:white;border:none;border-radius:50%;width:38px;height:38px;font-size:1.1rem;cursor:pointer}
footer{background:var(--text);color:rgba(255,255,255,.45);text-align:center;padding:1.75rem 1rem;font-size:.75rem}
footer strong{color:rgba(255,255,255,.8)}
.share-btn{padding:.7rem;border-radius:6px;border:none;cursor:pointer;font-family:var(--sans);font-size:.8rem;font-weight:600;transition:all .2s}
</style>
</head>
<body>
@php $coupleOrder = $invitation->couple_order ?? "bride_first"; @endphp
@if(empty($isPreview))
<div id="op">
  <div class="op-wrap">
    <div class="op-deco">— ✦ —</div>
    @if(!empty($guestName))<div class="op-to">Kepada Yth.</div><div class="op-guest">{{ $guestName }}</div>@endif
    <div class="op-names">
      @if($coupleOrder==='groom_first')
        {{ $invitation->groom_nickname ?: $invitation->groom_name }} &amp; {{ $invitation->bride_nickname ?: $invitation->bride_name }}
      @else
        {{ $invitation->bride_nickname ?: $invitation->bride_name }} &amp; {{ $invitation->groom_nickname ?: $invitation->groom_name }}
      @endif
    </div>
    @if($invitation->akad_date)<div class="op-date">{{ \Carbon\Carbon::parse($invitation->akad_date)->isoFormat('D MMMM YYYY') }}</div>@endif
    <button class="op-btn" onclick="openInv()">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><polyline points="2,5 12,13 22,5"/></svg>
      Buka Undangan
    </button>
  </div>
</div>
@endif

<div id="mc" class="{{ !empty($isPreview)?'vis':'' }}">
@if(!empty($guestName))<div class="gbanner">💌 Kepada: <strong>{{ $guestName }}</strong></div>@endif

<div class="hero">
  <div class="hero-ornament">— ✦ —</div>
  <div class="hero-announce">Undangan Pernikahan</div>
  <div class="hero-couple">
    @if($coupleOrder==='groom_first')
      {{ $invitation->groom_nickname ?: ($invitation->groom_name ?: 'Pengantin Pria') }}
      <span class="hero-amp"> &amp; </span>
      {{ $invitation->bride_nickname ?: ($invitation->bride_name ?: 'Pengantin Wanita') }}
    @else
      {{ $invitation->bride_nickname ?: ($invitation->bride_name ?: 'Pengantin Wanita') }}
      <span class="hero-amp"> &amp; </span>
      {{ $invitation->groom_nickname ?: ($invitation->groom_name ?: 'Pengantin Pria') }}
    @endif
  </div>
  <div class="hero-divider"><span></span><i>✦</i><span></span></div>
  @if($invitation->akad_date)<div class="hero-date">{{ \Carbon\Carbon::parse($invitation->akad_date)->isoFormat('dddd, D MMMM YYYY') }}</div>@endif
  <div class="hero-photo">
    @if($invitation->cover_photo)<img src="{{ asset('storage/'.$invitation->cover_photo) }}" alt="">@else<div class="ph">💑</div>@endif
  </div>
</div>

@if($invitation->opening_text)
<div class="sec rv" style="text-align:center">
  <p style="font-family:var(--serif);font-size:.95rem;font-style:italic;color:var(--muted);line-height:2">{!! $invitation->opening_text !!}</p>
  <div style="width:30px;height:1px;background:var(--p);margin:1.5rem auto 0;opacity:.4"></div>
</div>
@endif

<div style="background:var(--s)">
<div class="sec rv">
  <div class="sec-hd"><span class="sec-label">Kedua Mempelai</span><div class="sec-title">Dengan Penuh Syukur</div><div class="sec-line"></div></div>
  <div class="couple-grid">
    <div class="cc">
      @if($invitation->groom_photo)<img src="{{ asset('storage/'.$invitation->groom_photo) }}" class="cc-img" alt="">@else<div class="cc-img-ph">🤵</div>@endif
      <div class="cc-label">Pengantin Pria</div>
      <div class="cc-name">{{ $invitation->groom_name ?: 'Pengantin Pria' }}</div>
      <div class="cc-parents">Putra Bapak {{ $invitation->groom_father ?: '...' }}<br>& Ibu {{ $invitation->groom_mother ?: '...' }}</div>
    </div>
    <div class="cc">
      @if($invitation->bride_photo)<img src="{{ asset('storage/'.$invitation->bride_photo) }}" class="cc-img" alt="">@else<div class="cc-img-ph">👰</div>@endif
      <div class="cc-label">Pengantin Wanita</div>
      <div class="cc-name">{{ $invitation->bride_name ?: 'Pengantin Wanita' }}</div>
      <div class="cc-parents">Putri Bapak {{ $invitation->bride_father ?: '...' }}<br>& Ibu {{ $invitation->bride_mother ?: '...' }}</div>
    </div>
  </div>
</div>
</div>

<div class="sec rv">
  <div class="sec-hd"><span class="sec-label">Rangkaian Acara</span><div class="sec-title">Hari Istimewa</div><div class="sec-line"></div></div>
  @if($invitation->akad_date)
  <div style="text-align:center;margin-bottom:1.75rem">
    <div style="font-size:.72rem;color:var(--muted);margin-bottom:.5rem">Menghitung hari…</div>
    <div class="cd" id="cd"></div>
  </div>
  @endif
  @if($invitation->akad_date)
  <div class="ev-card">
    <div class="ev-type">Akad Nikah</div><div class="ev-name">Ijab Qobul</div>
    <div class="ev-row"><span class="ev-icon">📅</span>{{ \Carbon\Carbon::parse($invitation->akad_date)->isoFormat('dddd, D MMMM YYYY') }}</div>
    @if($invitation->akad_time_start)<div class="ev-row"><span class="ev-icon">🕐</span>{{ $invitation->akad_time_start }}{{ $invitation->akad_time_end?' – '.$invitation->akad_time_end:'' }} WIB</div>@endif
    @if($invitation->akad_venue)<div class="ev-row"><span class="ev-icon">📍</span><div>{{ $invitation->akad_venue }}@if($invitation->akad_address)<br><span style="font-size:.75rem;color:#C5B5AE">{{ $invitation->akad_address }}</span>@endif</div></div>@endif
    @if($invitation->akad_maps_url)<a href="{{ $invitation->akad_maps_url }}" target="_blank" class="ev-link">📍 Buka Maps</a>@endif
  </div>
  @endif
  @if($invitation->resepsi_date)
  <div class="ev-card">
    <div class="ev-type">Resepsi</div><div class="ev-name">Walimatul Ursy</div>
    <div class="ev-row"><span class="ev-icon">📅</span>{{ \Carbon\Carbon::parse($invitation->resepsi_date)->isoFormat('dddd, D MMMM YYYY') }}</div>
    @if($invitation->resepsi_time_start)<div class="ev-row"><span class="ev-icon">🕐</span>{{ $invitation->resepsi_time_start }}{{ $invitation->resepsi_time_end?' – '.$invitation->resepsi_time_end:'' }} WIB</div>@endif
    @if($invitation->resepsi_venue)<div class="ev-row"><span class="ev-icon">📍</span><div>{{ $invitation->resepsi_venue }}@if($invitation->resepsi_address)<br><span style="font-size:.75rem;color:#C5B5AE">{{ $invitation->resepsi_address }}</span>@endif</div></div>@endif
    @if($invitation->resepsi_maps_url)<a href="{{ $invitation->resepsi_maps_url }}" target="_blank" class="ev-link">📍 Buka Maps</a>@endif
  </div>
  @endif
  @if($invitation->livestream_url)<div class="ev-card" style="border-left-color:#7C3AED"><div class="ev-type" style="color:#7C3AED">Live Streaming</div><div class="ev-name">Saksikan Online</div><a href="{{ $invitation->livestream_url }}" target="_blank" class="ev-link" style="color:#7C3AED">▶ Tonton Live</a></div>@endif
</div>

@if($invitation->photos && $invitation->photos->count()>0)
<div style="background:var(--s);padding:3.5rem 1.5rem">
<div style="max-width:620px;margin:0 auto" class="rv">
  <div class="sec-hd"><span class="sec-label">Galeri</span><div class="sec-title">Momen Bersama</div><div class="sec-line"></div></div>
  <div class="gallery">@foreach($invitation->photos->take(9) as $ph)<div class="gi" onclick="openLb('{{ asset('storage/'.$ph->photo) }}')"><img src="{{ asset('storage/'.$ph->photo) }}" loading="lazy" alt=""></div>@endforeach</div>
</div>
</div>
@endif

@php $stories = is_array($invitation->love_story_items) ? $invitation->love_story_items : (json_decode($invitation->love_story_items, true) ?? []); @endphp
@if(count($stories)>0)
<div class="sec rv">
  <div class="sec-hd"><span class="sec-label">Our Story</span><div class="sec-title">Perjalanan Cinta</div><div class="sec-line"></div></div>
  <div class="tl">
    @foreach($stories as $s)
    <div class="tli rv">
      @if(!empty($s['date']))<div class="tli-date">{{ $s['date'] }}</div>@endif
      @if(!empty($s['title']))<div class="tli-title">{{ $s['title'] }}</div>@endif
      @if(!empty($s['content']))<div class="tli-text">{{ $s['content'] }}</div>@endif
    </div>
    @endforeach
  </div>
</div>
@endif

<div style="background:var(--s)">
<div class="sec rv">
  <div class="sec-hd"><span class="sec-label">RSVP</span><div class="sec-title">Konfirmasi Kehadiran</div><div class="sec-line"></div></div>
  <div class="form-card">
    <div id="rs-ok" style="display:none;text-align:center;padding:2rem"><div style="font-family:var(--serif);font-size:1.5rem;font-style:italic;color:var(--p)">Terima Kasih 🙏</div><p style="font-size:.82rem;color:var(--muted);margin-top:.4rem">Konfirmasi kehadiranmu sudah kami terima.</p></div>
    <div id="rs-form">
      <input class="fi" id="r-name" placeholder="Nama lengkap" value="{{ $guestName??'' }}">
      <input class="fi" id="r-phone" placeholder="No. WhatsApp (opsional)">
      <input class="fi" type="number" id="r-pax" value="1" min="1" max="20" placeholder="Jumlah tamu">
      <div style="font-size:.75rem;color:var(--muted);margin-bottom:.4rem">Kehadiran:</div>
      <div class="rr"><div class="ro" id="rb-h" onclick="selA('hadir')">✅ Hadir</div><div class="ro" id="rb-t" onclick="selA('tidak_hadir')">❌ Tidak Hadir</div></div>
      <textarea class="fi" id="r-msg" rows="2" placeholder="Pesan (opsional)" style="resize:none"></textarea>
      <button class="sbtn" onclick="doRsvp()">Kirim Konfirmasi</button>
    </div>
  </div>
  <div style="margin-top:2rem">
    <div class="sec-hd"><span class="sec-label">Ucapan & Doa</span></div>
    <div class="form-card" style="margin-bottom:1rem">
      <input class="fi" id="w-name" placeholder="Nama kamu">
      <textarea class="fi" id="w-msg" rows="3" placeholder="Ucapan dan doa tulus untuk pengantin…" style="resize:none"></textarea>
      <button class="sbtn" onclick="doWish()">Kirim Ucapan 🙏</button>
    </div>
    <div id="wlist">
      @php $_wishes = $invitation->id ? $invitation->wishes()->where('is_visible',true)->latest()->take(10)->get() : collect(); @endphp
      @foreach($_wishes as $w)<div class="wish-item"><div class="wname">{{ $w->name }}</div><div class="wmsg">{{ $w->message }}</div><div class="wtime">{{ $w->created_at->diffForHumans() }}</div></div>@endforeach
    </div>
  </div>
</div>
</div>

@if($invitation->closing_text)
<div class="sec rv" style="text-align:center">
  <p style="font-family:var(--serif);font-size:.95rem;font-style:italic;color:var(--muted);line-height:2">{!! $invitation->closing_text !!}</p>
  <div style="font-family:var(--serif);font-size:1.75rem;font-style:italic;color:var(--text);margin-top:1rem">{{ $invitation->groom_nickname ?: $invitation->groom_name }} & {{ $invitation->bride_nickname ?: $invitation->bride_name }}</div>
</div>
@endif
<footer><p>💝 <strong>{{ $invitation->title ?: 'Pernikahan Kami' }}</strong></p><p style="margin-top:.3rem">Dibuat dengan ❤️ oleh <strong>UndanganKu</strong></p></footer>
</div>

<div class="fls" id="fls" style="{{ empty($isPreview)?'display:none':'' }}">
  @if($invitation->music_file||$invitation->selected_music_key)<button class="fb fb-music" id="mbtn" onclick="togM()">🎵</button>@endif
  @if($invitation->gifts&&$invitation->gifts->count()>0)<button class="fb fb-gift" onclick="document.getElementById('gmod').classList.add('on')"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 12v10H4V12"/><path d="M22 7H2v5h20V7z"/><path d="M12 22V7"/><path d="M12 7H7.5a2.5 2.5 0 010-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 000-5C13 2 12 7 12 7z"/></svg> Hadiah</button>@endif
  <button class="fb fb-share" onclick="document.getElementById('shmod').classList.add('on')"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg></button>
</div>

@if($invitation->gifts&&$invitation->gifts->count()>0)
<div class="mo" id="gmod" onclick="if(event.target===this)this.classList.remove('on')"><div class="mb"><div class="mh"></div><div style="font-weight:700;font-size:.95rem;margin-bottom:1.1rem">💝 Kirim Hadiah</div>@foreach($invitation->gifts as $g)<div class="gift-row"><div class="gift-bank">{{ strtoupper(substr($g->bank_name,0,4)) }}</div><div style="flex:1"><div style="font-weight:600;font-size:.88rem">{{ $g->bank_name }}</div><div style="font-size:.83rem">{{ $g->account_number }}</div><div style="font-size:.72rem;color:var(--muted)">a.n. {{ $g->account_name }}</div></div><button class="cpbtn" onclick="cpTxt('{{ $g->account_number }}',this)">Salin</button></div>@endforeach</div></div>
@endif
<div class="smo" id="shmod" onclick="if(event.target===this)this.classList.remove('on')"><div class="smb"><div style="font-weight:700;font-size:.95rem;margin-bottom:1.1rem">Bagikan Undangan</div><div style="display:flex;align-items:center;gap:.4rem;background:#F9FAFB;border-radius:6px;padding:.5rem .75rem;margin-bottom:1rem"><input type="text" id="sh-link" readonly value="{{ url('/'.$invitation->slug) }}" style="flex:1;border:none;background:transparent;font-size:.72rem;outline:none"><button onclick="cpTxt(document.getElementById('sh-link').value,this)" style="background:var(--p);color:white;border:none;border-radius:4px;padding:.25rem .65rem;font-size:.72rem;cursor:pointer">Salin</button></div><input type="text" id="sh-guest" placeholder="Nama tamu (untuk link personal)" class="fi" style="margin-bottom:.75rem"><div style="display:flex;gap:.5rem"><button class="share-btn" style="flex:1;background:#F3F4F6;color:#374151" onclick="doShare(false)">Tanpa Nama</button><button class="share-btn" style="flex:1;background:var(--s);color:var(--p)" onclick="doShare(true)">Dengan Nama</button></div><button class="share-btn" style="width:100%;margin-top:.5rem;background:#25D366;color:white" onclick="doShareWA()">Broadcast WhatsApp →</button></div></div>
<div class="lbx" id="lbx" onclick="this.classList.remove('on')"><button class="lbx-x">✕</button><img id="lbx-img" src="" alt=""></div>
@if($invitation->music_file)<audio id="aud" loop><source src="{{ asset('storage/'.$invitation->music_file) }}"></audio>@elseif($invitation->selected_music_key)<audio id="aud" loop><source src="{{ $invitation->selected_music_key }}"></audio>@endif
<script>
const SLUG='{{ $invitation->slug }}';let att='',playing=false;
function openInv(){const a=document.getElementById('aud');if(a){a.play().then(()=>{playing=true;updM()}).catch(()=>{})}document.getElementById('op').classList.add('gone');document.getElementById('mc').classList.add('vis');document.getElementById('fls').style.display='flex'}
const obs=new IntersectionObserver(e=>e.forEach(x=>{if(x.isIntersecting){x.target.classList.add('iv');obs.unobserve(x.target)}}),{threshold:.1});document.querySelectorAll('.rv').forEach(e=>obs.observe(e));
@if($invitation->akad_date)
function updCD(){const t=new Date('{{ $invitation->akad_date }}').getTime(),diff=t-Date.now();if(diff<=0){document.getElementById('cd').innerHTML='<div style="font-family:var(--serif);font-size:1.2rem;font-style:italic;color:var(--p)">Hari Bahagia Telah Tiba 🎉</div>';return}const d=Math.floor(diff/86400000),h=Math.floor(diff%86400000/3600000),m=Math.floor(diff%3600000/60000),s=Math.floor(diff%60000/1000);document.getElementById('cd').innerHTML=[{v:d,l:'Hari'},{v:h,l:'Jam'},{v:m,l:'Menit'},{v:s,l:'Detik'}].map(x=>`<div class="cdb"><div class="cdn">${String(x.v).padStart(2,'0')}</div><div class="cdl">${x.l}</div></div>`).join('')}updCD();setInterval(updCD,1000);
@endif
function selA(v){att=v;document.getElementById('rb-h').className='ro'+(v==='hadir'?' sh':'');document.getElementById('rb-t').className='ro'+(v==='tidak_hadir'?' sn':'')}
async function doRsvp(){const name=document.getElementById('r-name').value.trim();if(!name)return alert('Masukkan nama!');if(!att)return alert('Pilih konfirmasi!');const r=await fetch('/'+SLUG+'/rsvp',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},body:JSON.stringify({name,phone:document.getElementById('r-phone').value,pax:document.getElementById('r-pax').value,attendance:att,message:document.getElementById('r-msg').value})});const d=await r.json();if(d.success){document.getElementById('rs-form').style.display='none';document.getElementById('rs-ok').style.display='block'}else alert('Gagal. Coba lagi.')}
async function doWish(){const name=document.getElementById('w-name').value.trim(),msg=document.getElementById('w-msg').value.trim();if(!name||!msg)return alert('Lengkapi nama dan ucapan!');const r=await fetch('/'+SLUG+'/wish',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},body:JSON.stringify({name,message:msg})});const d=await r.json();if(d.success){document.getElementById('w-name').value='';document.getElementById('w-msg').value='';const el=document.createElement('div');el.className='wish-item';el.innerHTML=`<div class="wname">${name}</div><div class="wmsg">${msg}</div><div class="wtime">Baru saja</div>`;document.getElementById('wlist').prepend(el);alert('Ucapan terkirim! 🙏')}}
function cpTxt(t,btn){navigator.clipboard.writeText(t).then(()=>{const o=btn.textContent;btn.textContent='✓';setTimeout(()=>btn.textContent=o,2e3)})}
function togM(){const a=document.getElementById('aud');if(!a)return;if(a.paused){a.play();playing=true}else{a.pause();playing=false}updM()}
function updM(){const b=document.getElementById('mbtn');if(b)b.textContent=playing?'🎵':'🔇'}
function openLb(s){document.getElementById('lbx-img').src=s;document.getElementById('lbx').classList.add('on')}
function doShare(wn){const name=document.getElementById('sh-guest').value.trim();const link=window.location.origin+'/'+SLUG+(wn&&name?'?untuk='+encodeURIComponent(name):'');navigator.clipboard.writeText(link).then(()=>alert('Link disalin!'))}
function doShareWA(){const name=document.getElementById('sh-guest').value.trim();const link=window.location.origin+'/'+SLUG+(name?'?untuk='+encodeURIComponent(name):'');const g={!! json_encode($invitation->groom_nickname ?: $invitation->groom_name ?: '') !!};const b={!! json_encode($invitation->bride_nickname ?: $invitation->bride_name ?: '') !!};let msg={!! json_encode($invitation->invitation_message ?: '') !!}||`Kepada *${name||'Bapak/Ibu/Saudara/i'}*\n\nLink: ${link}\n\n${g} & ${b}`;msg=msg.replace(/\{nama_tamu\}/g,name||'Bapak/Ibu/Saudara/i').replace(/\{link_undangan\}/g,link).replace(/\{nama_pengantin_pria\}/g,g).replace(/\{nama_pengantin_wanita\}/g,b);window.open('https://wa.me/?text='+encodeURIComponent(msg),'_blank')}
</script>
</body>
</html>
