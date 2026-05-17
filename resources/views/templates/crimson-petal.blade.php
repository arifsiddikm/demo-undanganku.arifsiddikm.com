<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>{{ $invitation->title ?? 'Undangan Pernikahan' }}</title>
<link href="https://fonts.googleapis.com/css2?family=Cormorant:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box;margin:0;padding:0}
:root{
  --p:{{ $invitation->color_primary ?? '#B5496A' }};
  --pg:{{ $invitation->color_secondary ?? '#C8956A' }};
  --bg:#1A0810;--bg2:#220D14;--bg3:#2A1020;--cream:#F5EDE8;--text:#F5EDE8;--muted:#C09898;
  --serif:'Cormorant',serif;--sans:'Jost',sans-serif;
}
html{scroll-behavior:smooth}
body{font-family:var(--sans);background:var(--bg);color:var(--text);overflow-x:hidden}
/* OPENING */
#op{position:fixed;inset:0;z-index:9999;background:var(--bg);display:flex;align-items:center;justify-content:center;transition:transform .9s cubic-bezier(.76,0,.24,1)}
#op.gone{transform:translateY(-100%)}
.op-wrap{text-align:center;padding:2rem;max-width:420px;width:90%}
.op-petals{font-size:3rem;margin-bottom:1rem;opacity:.6;animation:sway 3s ease-in-out infinite}
@keyframes sway{0%,100%{transform:rotate(-5deg)}50%{transform:rotate(5deg)}}
.op-to{font-size:.6rem;letter-spacing:.3em;text-transform:uppercase;color:var(--muted);margin-bottom:.4rem}
.op-guest{font-family:var(--serif);font-size:2.5rem;font-style:italic;color:var(--cream);min-height:3rem;margin-bottom:.3rem;line-height:1.1}
.op-line{display:flex;align-items:center;gap:.75rem;margin:.85rem auto;width:160px}
.op-line span{flex:1;height:1px;background:rgba(181,73,106,.3)}
.op-line i{font-style:normal;color:var(--p);font-size:.7rem}
.op-from{font-family:var(--serif);font-size:1.5rem;font-style:italic;color:var(--cream);margin-bottom:.5rem}
.op-date{font-size:.78rem;color:var(--muted);margin-bottom:2.5rem}
.op-btn{display:inline-flex;align-items:center;gap:.5rem;background:linear-gradient(135deg,var(--p),var(--pg));color:white;padding:.85rem 2.25rem;border:none;cursor:pointer;font-family:var(--sans);font-size:.85rem;font-weight:500;letter-spacing:.06em;transition:opacity .2s}
.op-btn:hover{opacity:.88}
/* MAIN */
#mc{opacity:0;transition:opacity .5s .2s}
#mc.vis{opacity:1}
.gbanner{position:sticky;top:0;z-index:99;background:linear-gradient(90deg,var(--p),var(--pg));color:white;text-align:center;padding:.45rem 1rem;font-size:.75rem}
/* HERO */
.hero{min-height:100svh;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:5rem 1.5rem 4rem;background:radial-gradient(ellipse at 50% 0%,#3A0A1A,var(--bg) 70%)}
.hero-crown{font-family:var(--serif);font-size:1.8rem;color:var(--pg);opacity:.5;margin-bottom:1.25rem;letter-spacing:.3rem}
.hero-label{font-size:.6rem;font-weight:400;letter-spacing:.35em;text-transform:uppercase;color:var(--muted);margin-bottom:.85rem}
.hero-names{font-family:var(--serif);font-size:clamp(3rem,11vw,5.5rem);font-style:italic;color:var(--cream);line-height:1.05;margin-bottom:.5rem}
.hero-amp{display:block;color:var(--p)}
.hero-sep{display:flex;align-items:center;gap:.75rem;margin:.85rem auto;width:200px}
.hero-sep span{flex:1;height:1px;background:linear-gradient(90deg,transparent,var(--p),transparent)}
.hero-sep i{font-style:normal;color:var(--pg);font-size:.7rem}
.hero-date{font-family:var(--serif);font-size:1.1rem;font-style:italic;color:var(--muted);margin-bottom:2rem}
.hero-photo{width:190px;height:250px;overflow:hidden;margin:0 auto;position:relative;clip-path:polygon(50% 0%,100% 20%,100% 80%,50% 100%,0% 80%,0% 20%)}
.hero-photo img,.hero-photo .ph{width:100%;height:100%;object-fit:cover}
.hero-photo .ph{background:var(--bg2);display:flex;align-items:center;justify-content:center;font-size:3rem}
/* REVEAL */
.rv{opacity:0;transform:translateY(22px);transition:opacity .65s,transform .65s}
.rv.iv{opacity:1;transform:translateY(0)}
/* SECTION */
.sec{padding:4.5rem 1.5rem;max-width:660px;margin:0 auto}
.sh{text-align:center;margin-bottom:2.25rem}
.sl{font-size:.6rem;font-weight:400;letter-spacing:.28em;text-transform:uppercase;color:var(--p);display:block;margin-bottom:.5rem}
.st{font-family:var(--serif);font-size:clamp(2rem,6vw,2.8rem);font-style:italic;color:var(--cream)}
/* COUPLE */
.cc-grid{display:grid;grid-template-columns:1fr auto 1fr;align-items:center;gap:1.25rem}
.cc{background:var(--bg2);border:1px solid rgba(181,73,106,.15);padding:1.75rem 1.25rem;text-align:center}
.cc-photo{width:120px;height:150px;margin:0 auto .85rem;display:block;object-fit:cover;border:2px solid rgba(181,73,106,.2)}
.cc-photo-ph{width:120px;height:150px;background:var(--bg3);margin:0 auto .85rem;display:flex;align-items:center;justify-content:center;font-size:2.5rem}
.cc-role{font-size:.58rem;letter-spacing:.2em;text-transform:uppercase;color:var(--p);margin-bottom:.3rem}
.cc-name{font-family:var(--serif);font-size:1.4rem;font-style:italic;color:var(--cream);margin-bottom:.3rem;line-height:1.1}
.cc-parents{font-size:.75rem;color:var(--muted);line-height:1.7}
.cc-amp{font-family:var(--serif);font-size:2.5rem;font-style:italic;color:var(--p);text-align:center}
/* EVENTS */
.ev{background:var(--bg2);padding:1.5rem;margin-bottom:.85rem;border:1px solid rgba(181,73,106,.12);position:relative}
.ev::before{content:'';position:absolute;top:0;left:0;width:100%;height:2px;background:linear-gradient(90deg,var(--p),var(--pg))}
.ev-type{font-size:.58rem;font-weight:400;letter-spacing:.2em;text-transform:uppercase;color:var(--p);margin-bottom:.3rem}
.ev-name{font-family:var(--serif);font-size:1.5rem;font-style:italic;color:var(--cream);margin-bottom:.65rem}
.ev-row{display:flex;gap:.5rem;font-size:.82rem;color:var(--muted);margin-bottom:.3rem;align-items:flex-start}
.ev-link{color:var(--pg);font-size:.75rem;text-decoration:none;margin-top:.5rem;display:inline-block;font-weight:500}
/* COUNTDOWN */
.cd{display:flex;gap:.65rem;justify-content:center;flex-wrap:wrap;margin:1.25rem 0}
.cdb{background:var(--bg3);border:1px solid rgba(181,73,106,.15);padding:.65rem .85rem;text-align:center;min-width:62px}
.cdn{font-family:var(--serif);font-size:1.85rem;color:var(--pg);line-height:1}
.cdl{font-size:.58rem;text-transform:uppercase;letter-spacing:.08em;color:var(--muted)}
/* GALLERY */
.gg{display:grid;grid-template-columns:repeat(3,1fr);gap:.4rem}
.gi{overflow:hidden;cursor:pointer;aspect-ratio:1}
.gi:first-child{grid-column:span 2;grid-row:span 2;aspect-ratio:auto}
.gi img{width:100%;height:100%;object-fit:cover;transition:transform .5s;filter:brightness(.9)sepia(.1)}
.gi:hover img{transform:scale(1.05);filter:brightness(1)sepia(0)}
/* TIMELINE */
.tl{padding-left:1.75rem;position:relative}
.tl::before{content:'';position:absolute;left:.5rem;top:0;bottom:0;width:1px;background:rgba(181,73,106,.2)}
.tli{position:relative;margin-bottom:2rem}
.tli::before{content:'◆';position:absolute;left:-1.55rem;top:3px;font-size:.5rem;color:var(--p)}
.tli-date{font-size:.68rem;letter-spacing:.08em;color:var(--pg);margin-bottom:.2rem;font-weight:400}
.tli-title{font-family:var(--serif);font-size:1.15rem;font-style:italic;color:var(--cream);margin-bottom:.2rem}
.tli-text{font-size:.8rem;color:var(--muted);line-height:1.8}
/* FORM */
.fc{background:var(--bg2);padding:1.5rem;border:1px solid rgba(181,73,106,.1)}
.fi{width:100%;padding:.6rem .85rem;border:1px solid rgba(181,73,106,.2);font-family:var(--sans);font-size:.83rem;outline:none;margin-bottom:.65rem;color:var(--cream);background:#150510;transition:border-color .2s}
.fi:focus{border-color:var(--p)}
.fi::placeholder{color:#5A3040}
.rr{display:flex;gap:.5rem;margin-bottom:.65rem}
.ro{flex:1;padding:.6rem;border:1px solid rgba(181,73,106,.2);text-align:center;cursor:pointer;font-size:.8rem;color:var(--muted);transition:all .2s}
.ro.sh{border-color:#10B981;background:rgba(16,185,129,.08);color:#6EE7B7}
.ro.sn{border-color:#EF4444;background:rgba(239,68,68,.08);color:#FCA5A5}
.sbtn{width:100%;background:linear-gradient(135deg,var(--p),var(--pg));color:white;border:none;padding:.75rem;font-family:var(--sans);font-size:.85rem;font-weight:400;letter-spacing:.06em;cursor:pointer;transition:opacity .2s}
.sbtn:hover{opacity:.85}
.wi{padding:.85rem 1rem;background:var(--bg2);border-left:2px solid rgba(181,73,106,.3);margin-bottom:.6rem}
.wn{font-weight:400;font-size:.82rem;color:var(--cream);margin-bottom:.15rem;font-family:var(--sans)}
.wm{font-size:.8rem;color:var(--muted);line-height:1.7}
.wt{font-size:.65rem;color:#5A3040;margin-top:.2rem}
.gr{background:var(--bg2);padding:.85rem 1.1rem;margin-bottom:.6rem;display:flex;align-items:center;gap:.85rem;border:1px solid rgba(181,73,106,.1)}
.gbk{font-size:.6rem;font-weight:500;color:var(--pg);width:44px;text-align:center;flex-shrink:0;letter-spacing:.05em}
.cpbtn{padding:.25rem .65rem;background:transparent;color:var(--pg);border:1px solid rgba(200,149,106,.3);font-size:.7rem;cursor:pointer;flex-shrink:0;transition:all .2s}
.cpbtn:hover{background:var(--pg);color:var(--bg)}
/* FLOATS */
.fls{position:fixed;bottom:1.25rem;right:1rem;z-index:200;display:flex;flex-direction:column;gap:.5rem;align-items:flex-end}
.fb{border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:0 3px 14px rgba(0,0,0,.4);transition:transform .2s}
.fb:hover{transform:scale(1.08)}
.fb-m{width:44px;height:44px;background:linear-gradient(135deg,var(--p),var(--pg));color:white;border-radius:50%;font-size:1rem}
.fb-g{height:44px;min-width:44px;background:#25D366;color:white;padding:0 .85rem;font-size:.7rem;font-weight:500;gap:.3rem;border-radius:22px;font-family:var(--sans)}
.fb-s{width:44px;height:44px;background:var(--bg2);color:var(--muted);border:1px solid rgba(181,73,106,.2);border-radius:50%}
/* MODALS */
.mo{position:fixed;inset:0;background:rgba(0,0,0,.65);z-index:300;display:flex;align-items:flex-end;justify-content:center;opacity:0;pointer-events:none;transition:opacity .3s}
.mo.on{opacity:1;pointer-events:all}
.mb{background:var(--bg2);border-radius:14px 14px 0 0;padding:1.5rem;width:100%;max-width:440px;transform:translateY(100%);transition:transform .3s cubic-bezier(.34,1.56,.64,1);border-top:1px solid rgba(181,73,106,.15)}
.mo.on .mb{transform:translateY(0)}
.mh{width:36px;height:2px;background:#3A1520;margin:0 auto 1.1rem}
.smo{position:fixed;inset:0;background:rgba(0,0,0,.65);z-index:300;display:flex;align-items:center;justify-content:center;padding:1rem;opacity:0;pointer-events:none;transition:opacity .3s}
.smo.on{opacity:1;pointer-events:all}
.smb{background:var(--bg2);padding:1.5rem;width:100%;max-width:400px;border:1px solid rgba(181,73,106,.15);transform:scale(.92);transition:transform .3s cubic-bezier(.34,1.56,.64,1)}
.smo.on .smb{transform:scale(1)}
.lbx{position:fixed;inset:0;background:rgba(0,0,0,.96);z-index:400;display:flex;align-items:center;justify-content:center;opacity:0;pointer-events:none;transition:opacity .3s}
.lbx.on{opacity:1;pointer-events:all}
.lbx img{max-width:92vw;max-height:90vh;object-fit:contain}
.lbx-x{position:absolute;top:.75rem;right:.75rem;background:rgba(181,73,106,.2);color:white;border:none;border-radius:50%;width:38px;height:38px;font-size:1.1rem;cursor:pointer}
footer{background:#0D040A;color:#5A3040;text-align:center;padding:1.75rem 1rem;font-size:.75rem;border-top:1px solid rgba(181,73,106,.08)}
footer strong{color:var(--muted)}
.sbtn2{padding:.68rem;border:none;cursor:pointer;font-family:var(--sans);font-size:.78rem;font-weight:400;transition:all .2s}
</style>
</head>
<body>
@php $coupleOrder = $invitation->couple_order ?? "bride_first"; @endphp
@if(empty($isPreview))
<div id="op">
  <div class="op-wrap">
    <div class="op-petals">🌹</div>
    @if(!empty($guestName))<div class="op-to">Kepada Yth.</div><div class="op-guest">{{ $guestName }}</div>@endif
    <div class="op-line"><span></span><i>◆</i><span></span></div>
    <div class="op-from">
      @if($coupleOrder==='groom_first')
        {{ $invitation->groom_nickname ?: $invitation->groom_name }} <span style="color:var(--p)">&amp;</span> {{ $invitation->bride_nickname ?: $invitation->bride_name }}
      @else
        {{ $invitation->bride_nickname ?: $invitation->bride_name }} <span style="color:var(--p)">&amp;</span> {{ $invitation->groom_nickname ?: $invitation->groom_name }}
      @endif
    </div>
    @if($invitation->akad_date)<div class="op-date">{{ \Carbon\Carbon::parse($invitation->akad_date)->isoFormat('D MMMM YYYY') }}</div>@endif
    <button class="op-btn" onclick="openInv()">✦ Buka Undangan ✦</button>
  </div>
</div>
@endif
<div id="mc" class="{{ !empty($isPreview)?'vis':'' }}">
@if(!empty($guestName))<div class="gbanner">💌 Kepada: <strong>{{ $guestName }}</strong></div>@endif
<div class="hero">
  <div class="hero-crown">✦ ✦ ✦</div>
  <div class="hero-label">Undangan Pernikahan</div>
  <div class="hero-names">{{ $invitation->groom_nickname ?: ($invitation->groom_name ?: 'Pengantin Pria') }}<span class="hero-amp">&amp;</span>{{ $invitation->bride_nickname ?: ($invitation->bride_name ?: 'Pengantin Wanita') }}</div>
  <div class="hero-sep"><span></span><i>◆</i><span></span></div>
  @if($invitation->akad_date)<div class="hero-date">{{ \Carbon\Carbon::parse($invitation->akad_date)->isoFormat('dddd, D MMMM YYYY') }}</div>@endif
  <div class="hero-photo">@if($invitation->cover_photo)<img src="{{ asset('storage/'.$invitation->cover_photo) }}" alt="">@else<div class="ph">💑</div>@endif</div>
</div>

@if($invitation->opening_text)<div class="sec rv" style="text-align:center"><div style="font-family:var(--serif);font-size:1rem;font-style:italic;color:var(--muted);line-height:2.1">{!! $invitation->opening_text !!}</div><div class="hero-sep" style="margin-top:1.5rem"></div></div>@endif

<div style="background:var(--bg2)">
<div class="sec rv">
  <div class="sh"><span class="sl">Kedua Mempelai</span><div class="st">Mempelai Bahagia</div></div>
  <div class="cc-grid">
    <div class="cc">@if($invitation->groom_photo)<img src="{{ asset('storage/'.$invitation->groom_photo) }}" class="cc-photo" alt="">@else<div class="cc-photo-ph">🤵</div>@endif
      <div class="cc-role">Pengantin Pria</div><div class="cc-name">{{ $invitation->groom_name ?: 'Pengantin Pria' }}</div>
      <div class="cc-parents">Putra Bapak {{ $invitation->groom_father ?: '...' }}<br>& Ibu {{ $invitation->groom_mother ?: '...' }}</div>
    </div>
    <div class="cc-amp">&amp;</div>
    <div class="cc">@if($invitation->bride_photo)<img src="{{ asset('storage/'.$invitation->bride_photo) }}" class="cc-photo" alt="">@else<div class="cc-photo-ph">👰</div>@endif
      <div class="cc-role">Pengantin Wanita</div><div class="cc-name">{{ $invitation->bride_name ?: 'Pengantin Wanita' }}</div>
      <div class="cc-parents">Putri Bapak {{ $invitation->bride_father ?: '...' }}<br>& Ibu {{ $invitation->bride_mother ?: '...' }}</div>
    </div>
  </div>
</div>
</div>

<div class="sec rv">
  <div class="sh"><span class="sl">Save The Date</span><div class="st">Hari Istimewa</div></div>
  @if($invitation->akad_date)<div style="text-align:center;margin-bottom:1.75rem"><div class="cd" id="cd"></div></div>@endif
@if($invitation->akad_date)
<div class="ev">
  <div class="ev-type">Akad Nikah</div>
  <div class="ev-name">Ijab Qobul</div>
  <div class="ev-row"><span style="color:var(--p)">📅</span>{{ \Carbon\Carbon::parse($invitation->akad_date)->isoFormat('dddd, D MMMM YYYY') }}</div>
  @if($invitation->akad_time_start)
  <div class="ev-row"><span style="color:var(--p)">🕐</span>{{ $invitation->akad_time_start }}{{ $invitation->akad_time_end?' – '.$invitation->akad_time_end:'' }} WIB</div>
  @endif
  @if($invitation->akad_venue)
  <div class="ev-row"><span style="color:var(--p)">📍</span><div>{{ $invitation->akad_venue }}@if($invitation->akad_address)<br><span style="font-size:.72rem;color:#5A3040">{{ $invitation->akad_address }}</span>@endif</div></div>
  @endif
  @if($invitation->akad_maps_url)<a href="{{ $invitation->akad_maps_url }}" target="_blank" class="ev-link">📍 Buka Maps</a>@endif
</div>
@endif
@if($invitation->resepsi_date)
<div class="ev">
  <div class="ev-type">Resepsi</div>
  <div class="ev-name">Walimatul Ursy</div>
  <div class="ev-row"><span style="color:var(--p)">📅</span>{{ \Carbon\Carbon::parse($invitation->resepsi_date)->isoFormat('dddd, D MMMM YYYY') }}</div>
  @if($invitation->resepsi_time_start)
  <div class="ev-row"><span style="color:var(--p)">🕐</span>{{ $invitation->resepsi_time_start }}{{ $invitation->resepsi_time_end?' – '.$invitation->resepsi_time_end:'' }} WIB</div>
  @endif
  @if($invitation->resepsi_venue)
  <div class="ev-row"><span style="color:var(--p)">📍</span><div>{{ $invitation->resepsi_venue }}@if($invitation->resepsi_address)<br><span style="font-size:.72rem;color:#5A3040">{{ $invitation->resepsi_address }}</span>@endif</div></div>
  @endif
  @if($invitation->resepsi_maps_url)<a href="{{ $invitation->resepsi_maps_url }}" target="_blank" class="ev-link">📍 Buka Maps</a>@endif
</div>
@endif
@if($invitation->livestream_url)
<div class="ev" style="border-left-color:#7C3AED">
  <div class="ev-type" style="color:#9C5CE6">Live Streaming</div>
  <div class="ev-name">Saksikan Online</div>
  <a href="{{ $invitation->livestream_url }}" target="_blank" class="ev-link" style="color:#9C5CE6">▶ Tonton Live</a>
</div>
@endif
</div>

@if($invitation->photos && $invitation->photos->count()>0)
<div style="background:var(--bg2);padding:3.5rem 1.5rem"><div style="max-width:660px;margin:0 auto" class="rv"><div class="sh"><span class="sl">Precious Moments</span><div class="st">Momen Bersama</div></div><div class="gg">@foreach($invitation->photos->take(7) as $ph)<div class="gi" onclick="openLb('{{ asset('storage/'.$ph->photo) }}')"><img src="{{ asset('storage/'.$ph->photo) }}" loading="lazy" alt=""></div>@endforeach</div></div></div>
@endif

@php $stories = is_array($invitation->love_story_items) ? $invitation->love_story_items : (json_decode($invitation->love_story_items, true) ?? []); @endphp
@if(count($stories)>0)<div class="sec rv"><div class="sh"><span class="sl">Our Story</span><div class="st">Perjalanan Cinta</div></div><div class="tl">@foreach($stories as $s)<div class="tli rv">@if(!empty($s['date']))<div class="tli-date">{{ $s['date'] }}</div>@endif @if(!empty($s['title']))<div class="tli-title">{{ $s['title'] }}</div>@endif @if(!empty($s['content']))<div class="tli-text">{{ $s['content'] }}</div>@endif</div>@endforeach</div></div>@endif

<div style="background:var(--bg2)"><div class="sec rv">
  <div class="sh"><span class="sl">RSVP</span><div class="st">Konfirmasi Kehadiran</div></div>
  <div class="fc"><div id="rs-ok" style="display:none;text-align:center;padding:2rem"><div style="font-family:var(--serif);font-size:2rem;font-style:italic;color:var(--pg)">Terima Kasih 🌹</div><p style="font-size:.82rem;color:var(--muted);margin-top:.4rem">Konfirmasi sudah kami terima.</p></div>
  <div id="rs-form"><input class="fi" id="r-name" placeholder="Nama lengkap" value="{{ $guestName??'' }}"><input class="fi" id="r-phone" placeholder="No. WhatsApp (opsional)"><input class="fi" type="number" id="r-pax" value="1" min="1" max="20"><div style="font-size:.7rem;color:var(--muted);margin-bottom:.4rem;letter-spacing:.1em;text-transform:uppercase">Kehadiran</div><div class="rr"><div class="ro" id="rb-h" onclick="selA('hadir')">✅ Hadir</div><div class="ro" id="rb-t" onclick="selA('tidak_hadir')">❌ Tidak Hadir</div></div><textarea class="fi" id="r-msg" rows="2" placeholder="Pesan (opsional)" style="resize:none"></textarea><button class="sbtn" onclick="doRsvp()">Kirim Konfirmasi</button></div></div>
  <div style="margin-top:2rem"><div class="sh"><span class="sl">Doa & Ucapan</span></div>
  <div class="fc" style="margin-bottom:1rem"><input class="fi" id="w-name" placeholder="Nama kamu"><textarea class="fi" id="w-msg" rows="3" placeholder="Ucapan dan doa tulus…" style="resize:none"></textarea><button class="sbtn" onclick="doWish()">Kirim Ucapan 🌹</button></div>
  <div id="wlist">@php $_wishes=$invitation->id?$invitation->wishes()->where('is_visible',true)->latest()->take(10)->get():collect();@endphp@foreach($_wishes as $w)<div class="wi"><div class="wn">{{ $w->name }}</div><div class="wm">{{ $w->message }}</div><div class="wt">{{ $w->created_at->diffForHumans() }}</div></div>@endforeach</div>
  </div>
</div></div>

@if($invitation->closing_text)<div class="sec rv" style="text-align:center"><p style="font-family:var(--serif);font-size:1.05rem;font-style:italic;color:var(--muted);line-height:2.1">{!! $invitation->closing_text !!}</p><div class="hero-sep" style="margin:1.5rem auto"><span></span><i>◆</i><span></span></div><div style="font-family:var(--serif);font-size:1.8rem;font-style:italic;color:var(--cream);margin-top:.75rem">@if($coupleOrder==='groom_first'){{ $invitation->groom_nickname ?: $invitation->groom_name }} &amp; {{ $invitation->bride_nickname ?: $invitation->bride_name }}@else{{ $invitation->bride_nickname ?: $invitation->bride_name }} &amp; {{ $invitation->groom_nickname ?: $invitation->groom_name }}@endif</div></div>@endif
<footer><p>💝 <strong>{{ $invitation->title ?: 'Pernikahan Kami' }}</strong></p><p style="margin-top:.3rem">Dibuat dengan ❤️ oleh <strong>UndanganKu</strong></p></footer>
</div>
<div class="fls" id="fls" style="{{ empty($isPreview)?'display:none':'' }}">
  @if($invitation->music_file||$invitation->selected_music_key)<button class="fb fb-m" id="mbtn" onclick="togM()">🎵</button>@endif
  @if($invitation->gifts&&$invitation->gifts->count()>0)<button class="fb fb-g" onclick="document.getElementById('gmod').classList.add('on')"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 12v10H4V12"/><path d="M22 7H2v5h20V7z"/></svg>Gift</button>@endif
  <button class="fb fb-s" onclick="document.getElementById('shmod').classList.add('on')"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg></button>
</div>
@if($invitation->gifts&&$invitation->gifts->count()>0)
<div class="mo" id="gmod" onclick="if(event.target===this)this.classList.remove('on')"><div class="mb"><div class="mh"></div><div style="font-family:var(--serif);font-style:italic;font-size:1.2rem;color:var(--cream);margin-bottom:1.1rem">Send Your Gift 🌹</div>@foreach($invitation->gifts as $g)<div class="gr"><div class="gbk">{{ strtoupper(substr($g->bank_name,0,4)) }}</div><div style="flex:1"><div style="font-size:.88rem;color:var(--cream)">{{ $g->bank_name }}</div><div style="font-size:.82rem;color:var(--muted)">{{ $g->account_number }}</div><div style="font-size:.7rem;color:#5A3040">a.n. {{ $g->account_name }}</div></div><button class="cpbtn" onclick="cpTxt('{{ $g->account_number }}',this)">Salin</button></div>@endforeach</div></div>
@endif
<div class="smo" id="shmod" onclick="if(event.target===this)this.classList.remove('on')"><div class="smb"><div style="font-family:var(--serif);font-style:italic;font-size:1.15rem;color:var(--cream);margin-bottom:1rem">Bagikan Undangan</div><div style="display:flex;align-items:center;gap:.4rem;background:#150510;padding:.5rem .75rem;margin-bottom:.85rem;border:1px solid rgba(181,73,106,.15)"><input type="text" id="sh-link" readonly value="{{ url('/'.$invitation->slug) }}" style="flex:1;border:none;background:transparent;font-size:.7rem;outline:none;color:var(--muted)"><button onclick="cpTxt(document.getElementById('sh-link').value,this)" style="background:var(--p);color:white;border:none;padding:.25rem .65rem;font-size:.7rem;cursor:pointer">Salin</button></div><input type="text" id="sh-guest" placeholder="Nama tamu" class="fi" style="margin-bottom:.65rem"><div style="display:flex;gap:.5rem"><button class="sbtn2" style="flex:1;background:var(--bg);color:var(--muted);border:1px solid rgba(181,73,106,.12)" onclick="doShare(false)">Tanpa Nama</button><button class="sbtn2" style="flex:1;background:rgba(181,73,106,.1);color:var(--p);border:1px solid rgba(181,73,106,.25)" onclick="doShare(true)">Dengan Nama</button></div><button class="sbtn2" style="width:100%;margin-top:.5rem;background:#25D366;color:white" onclick="doShareWA()">Broadcast WhatsApp →</button></div></div>
<div class="lbx" id="lbx" onclick="this.classList.remove('on')"><button class="lbx-x">✕</button><img id="lbx-img" src="" alt=""></div>
@if($invitation->music_file)<audio id="aud" loop><source src="{{ asset('storage/'.$invitation->music_file) }}"></audio>@elseif($invitation->selected_music_key)<audio id="aud" loop><source src="{{ $invitation->selected_music_key }}"></audio>@endif
<script>
const SLUG='{{ $invitation->slug }}';let att='',playing=false;
function openInv(){const a=document.getElementById('aud');if(a){a.play().then(()=>{playing=true;updM()}).catch(()=>{})}document.getElementById('op').classList.add('gone');document.getElementById('mc').classList.add('vis');document.getElementById('fls').style.display='flex'}
const obs=new IntersectionObserver(e=>e.forEach(x=>{if(x.isIntersecting){x.target.classList.add('iv');obs.unobserve(x.target)}}),{threshold:.1});document.querySelectorAll('.rv').forEach(e=>obs.observe(e));
@if($invitation->akad_date)function updCD(){const t=new Date('{{ $invitation->akad_date }}').getTime(),diff=t-Date.now();if(diff<=0){document.getElementById('cd').innerHTML='<div style="color:var(--pg);font-family:var(--serif);font-style:italic;font-size:1.2rem">Hari Bahagia Telah Tiba 🌹</div>';return}const d=Math.floor(diff/86400000),h=Math.floor(diff%86400000/3600000),m=Math.floor(diff%3600000/60000),s=Math.floor(diff%60000/1000);document.getElementById('cd').innerHTML=[{v:d,l:'Hari'},{v:h,l:'Jam'},{v:m,l:'Menit'},{v:s,l:'Detik'}].map(x=>`<div class="cdb"><div class="cdn">${String(x.v).padStart(2,'0')}</div><div class="cdl">${x.l}</div></div>`).join('')}updCD();setInterval(updCD,1000);@endif
function selA(v){att=v;document.getElementById('rb-h').className='ro'+(v==='hadir'?' sh':'');document.getElementById('rb-t').className='ro'+(v==='tidak_hadir'?' sn':'')}
async function doRsvp(){const name=document.getElementById('r-name').value.trim();if(!name)return alert('Masukkan nama!');if(!att)return alert('Pilih konfirmasi!');const r=await fetch('/'+SLUG+'/rsvp',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},body:JSON.stringify({name,phone:document.getElementById('r-phone').value,pax:document.getElementById('r-pax').value,attendance:att,message:document.getElementById('r-msg').value})});const d=await r.json();if(d.success){document.getElementById('rs-form').style.display='none';document.getElementById('rs-ok').style.display='block'}else alert('Gagal.')}
async function doWish(){const name=document.getElementById('w-name').value.trim(),msg=document.getElementById('w-msg').value.trim();if(!name||!msg)return alert('Lengkapi data!');const r=await fetch('/'+SLUG+'/wish',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},body:JSON.stringify({name,message:msg})});const d=await r.json();if(d.success){document.getElementById('w-name').value='';document.getElementById('w-msg').value='';const el=document.createElement('div');el.className='wi';el.innerHTML=`<div class="wn">${name}</div><div class="wm">${msg}</div><div class="wt">Baru saja</div>`;document.getElementById('wlist').prepend(el)}}
function cpTxt(t,btn){navigator.clipboard.writeText(t).then(()=>{const o=btn.textContent;btn.textContent='✓';setTimeout(()=>btn.textContent=o,2e3)})}
function togM(){const a=document.getElementById('aud');if(!a)return;if(a.paused){a.play();playing=true}else{a.pause();playing=false}updM()}
function updM(){const b=document.getElementById('mbtn');if(b)b.textContent=playing?'🎵':'🔇'}
function openLb(s){document.getElementById('lbx-img').src=s;document.getElementById('lbx').classList.add('on')}
function doShare(wn){const name=document.getElementById('sh-guest').value.trim();const link=window.location.origin+'/'+SLUG+(wn&&name?'?untuk='+encodeURIComponent(name):'');navigator.clipboard.writeText(link).then(()=>alert('Link disalin!'))}
function doShareWA(){const name=document.getElementById('sh-guest').value.trim();const link=window.location.origin+'/'+SLUG+(name?'?untuk='+encodeURIComponent(name):'');const g={!! json_encode($invitation->groom_nickname ?: $invitation->groom_name ?: '') !!};const b={!! json_encode($invitation->bride_nickname ?: $invitation->bride_name ?: '') !!};let msg={!! json_encode($invitation->invitation_message ?: '') !!}||`Kepada *${name||'Bapak/Ibu/Saudara/i'}*\n\nLink: ${link}\n\n${g} & ${b}`;msg=msg.replace(/\{nama_tamu\}/g,name||'Bapak/Ibu/Saudara/i').replace(/\{link_undangan\}/g,link).replace(/\{nama_pengantin_pria\}/g,g).replace(/\{nama_pengantin_wanita\}/g,b);window.open('https://wa.me/?text='+encodeURIComponent(msg),'_blank')}
</script>
</body>
</html>
