<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>{{ $invitation->title ?? 'Undangan Pernikahan' }}</title>
<link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box;margin:0;padding:0}
:root{
  --p:{{ $invitation->color_primary ?? '#4A7C59' }};
  --s:{{ $invitation->color_secondary ?? '#2C3E2D' }};
  --bg:#1A2B1C;--bg2:#243326;--cream:#F2EDDF;--text:#F2EDDF;--muted:#9BAE9F;
  --serif:'Libre Baskerville',serif;--sans:'Inter',sans-serif;
}
html{scroll-behavior:smooth}
body{font-family:var(--sans);background:var(--bg);color:var(--text);overflow-x:hidden}
#op{position:fixed;inset:0;z-index:9999;background:var(--bg);display:flex;align-items:center;justify-content:center;transition:transform .9s cubic-bezier(.76,0,.24,1)}
#op.gone{transform:translateY(-100%)}
.op-wrap{text-align:center;padding:2rem;max-width:380px;width:90%}
.op-circle{width:100px;height:100px;border-radius:50%;border:1px solid rgba(74,124,89,.4);margin:0 auto 1.5rem;display:flex;align-items:center;justify-content:center;font-size:2.2rem;animation:pulse 3s ease-in-out infinite}
@keyframes pulse{0%,100%{box-shadow:0 0 0 0 rgba(74,124,89,.3)}50%{box-shadow:0 0 0 12px rgba(74,124,89,.05)}}
.op-to{font-size:.62rem;letter-spacing:.25em;text-transform:uppercase;color:var(--muted);margin-bottom:.35rem}
.op-guest{font-family:var(--serif);font-size:2rem;font-style:italic;color:var(--cream);margin-bottom:.3rem;min-height:2.6rem}
.op-from{font-size:.82rem;color:var(--muted);margin-bottom:2rem;line-height:1.7}
.op-from strong{color:var(--cream)}
.op-btn{display:inline-block;background:transparent;color:var(--p);padding:.75rem 2rem;border:1px solid var(--p);cursor:pointer;font-family:var(--sans);font-size:.82rem;font-weight:500;letter-spacing:.1em;text-transform:uppercase;transition:all .3s}
.op-btn:hover{background:var(--p);color:var(--bg)}
#mc{opacity:0;transition:opacity .5s .2s}
#mc.vis{opacity:1}
.gbanner{position:sticky;top:0;z-index:99;background:var(--p);color:white;text-align:center;padding:.45rem 1rem;font-size:.75rem}
.hero{min-height:100svh;display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:5rem 1.5rem 4rem;background:linear-gradient(160deg,#101A11,var(--bg) 50%,var(--bg2))}
.hero-tag{font-size:.6rem;font-weight:500;letter-spacing:.3em;text-transform:uppercase;color:var(--p);margin-bottom:1.25rem;border:1px solid rgba(74,124,89,.3);padding:.3rem .9rem;display:inline-block}
.hero-names{font-family:var(--serif);font-size:clamp(2.8rem,10vw,5rem);font-style:italic;color:var(--cream);line-height:1.1;margin-bottom:.75rem}
.hero-amp{color:var(--p)}
.hero-line{width:40px;height:1px;background:rgba(74,124,89,.5);margin:.85rem auto}
.hero-date{font-family:var(--serif);font-size:.95rem;color:var(--muted);margin-bottom:2rem}
.hero-photo-wrap{position:relative;width:180px;margin:0 auto}
.hero-photo{width:180px;height:220px;overflow:hidden;border-radius:2px}
.hero-photo img,.hero-photo .ph{width:100%;height:100%;object-fit:cover}
.hero-photo .ph{background:var(--bg2);display:flex;align-items:center;justify-content:center;font-size:3rem}
.rv{opacity:0;transform:translateY(20px);transition:opacity .65s,transform .65s}
.rv.iv{opacity:1;transform:translateY(0)}
.sec{padding:4.5rem 1.5rem;max-width:640px;margin:0 auto}
.sh{text-align:center;margin-bottom:2rem}
.sl{font-size:.6rem;font-weight:500;letter-spacing:.25em;text-transform:uppercase;color:var(--p);display:block;margin-bottom:.5rem}
.st{font-family:var(--serif);font-size:clamp(1.7rem,5vw,2.3rem);font-style:italic;color:var(--cream)}
.cc-row{display:flex;gap:1rem;align-items:flex-start}
.cc{flex:1;background:var(--bg2);border:1px solid rgba(74,124,89,.15);padding:1.5rem 1.25rem;text-align:center}
.cc-img{width:110px;height:135px;object-fit:cover;margin:0 auto .75rem;display:block;border:2px solid rgba(74,124,89,.25)}
.cc-img-ph{width:110px;height:135px;background:var(--bg);margin:0 auto .75rem;display:flex;align-items:center;justify-content:center;font-size:2rem}
.cc-role{font-size:.58rem;letter-spacing:.15em;text-transform:uppercase;color:var(--p);margin-bottom:.25rem}
.cc-name{font-family:var(--serif);font-size:1.1rem;font-style:italic;color:var(--cream);margin-bottom:.25rem}
.cc-parents{font-size:.75rem;color:var(--muted);line-height:1.6}
.ev-card{background:var(--bg2);border:1px solid rgba(74,124,89,.15);padding:1.4rem;margin-bottom:.85rem;border-left:2px solid var(--p)}
.ev-type{font-size:.58rem;font-weight:500;letter-spacing:.15em;text-transform:uppercase;color:var(--p);margin-bottom:.3rem}
.ev-name{font-family:var(--serif);font-size:1.3rem;font-style:italic;color:var(--cream);margin-bottom:.6rem}
.ev-row{display:flex;gap:.5rem;font-size:.8rem;color:var(--muted);margin-bottom:.3rem;align-items:flex-start}
.ev-link{color:var(--p);font-size:.75rem;text-decoration:none;margin-top:.4rem;display:inline-block;font-weight:500}
.cd{display:flex;gap:.6rem;justify-content:center;flex-wrap:wrap;margin:1.25rem 0}
.cdb{background:var(--bg2);border:1px solid rgba(74,124,89,.15);padding:.65rem .85rem;text-align:center;min-width:60px}
.cdn{font-family:var(--serif);font-size:1.75rem;color:var(--p);line-height:1}
.cdl{font-size:.58rem;text-transform:uppercase;letter-spacing:.07em;color:var(--muted)}
.gg{display:grid;grid-template-columns:1fr 1fr;gap:.4rem}
.gi{overflow:hidden;cursor:pointer}
.gi:first-child{grid-column:span 2;aspect-ratio:16/7}
.gi:not(:first-child){aspect-ratio:1}
.gi img{width:100%;height:100%;object-fit:cover;transition:transform .4s;filter:brightness(.95)}
.gi:hover img{transform:scale(1.04);filter:brightness(1)}
.tl{padding-left:1.75rem;position:relative}
.tl::before{content:'';position:absolute;left:.5rem;top:0;bottom:0;width:1px;background:rgba(74,124,89,.25)}
.tli{position:relative;margin-bottom:1.75rem}
.tli::before{content:'';position:absolute;left:-1.35rem;top:5px;width:8px;height:8px;background:var(--bg2);border:1.5px solid var(--p)}
.tli-date{font-size:.68rem;color:var(--p);font-weight:500;margin-bottom:.2rem;letter-spacing:.06em}
.tli-title{font-family:var(--serif);font-size:1rem;font-style:italic;color:var(--cream);margin-bottom:.2rem}
.tli-text{font-size:.8rem;color:var(--muted);line-height:1.75}
.fc{background:var(--bg2);border:1px solid rgba(74,124,89,.12);padding:1.5rem}
.fi{width:100%;padding:.6rem .85rem;border:1px solid rgba(74,124,89,.25);font-family:var(--sans);font-size:.83rem;outline:none;margin-bottom:.65rem;color:var(--cream);background:#111E12;transition:border-color .2s}
.fi:focus{border-color:var(--p)}
.fi::placeholder{color:#4A5C4B}
.rr{display:flex;gap:.5rem;margin-bottom:.65rem}
.ro{flex:1;padding:.6rem;border:1px solid rgba(74,124,89,.25);text-align:center;cursor:pointer;font-size:.8rem;color:var(--muted);transition:all .2s}
.ro.sh{border-color:#10B981;background:rgba(16,185,129,.1);color:#6EE7B7}
.ro.sn{border-color:#EF4444;background:rgba(239,68,68,.08);color:#FCA5A5}
.sbtn{width:100%;background:var(--p);color:white;border:none;padding:.75rem;font-family:var(--sans);font-size:.85rem;font-weight:500;cursor:pointer;letter-spacing:.05em;transition:opacity .2s}
.sbtn:hover{opacity:.85}
.wi{padding:.85rem 1rem;background:var(--bg2);border-left:2px solid rgba(74,124,89,.3);margin-bottom:.6rem}
.wn{font-weight:500;font-size:.82rem;color:var(--cream);margin-bottom:.15rem}
.wm{font-size:.8rem;color:var(--muted);line-height:1.6}
.wt{font-size:.65rem;color:#3A5040;margin-top:.2rem}
.gr{background:var(--bg2);padding:.85rem 1.1rem;margin-bottom:.6rem;display:flex;align-items:center;gap:.85rem;border:1px solid rgba(74,124,89,.1)}
.gbk{font-size:.62rem;font-weight:700;color:var(--p);width:44px;text-align:center;flex-shrink:0;font-family:var(--sans);letter-spacing:.05em}
.cpbtn{padding:.25rem .65rem;background:transparent;color:var(--p);border:1px solid rgba(74,124,89,.3);font-size:.7rem;cursor:pointer;flex-shrink:0;transition:all .2s}
.cpbtn:hover{background:var(--p);color:var(--bg)}
.fls{position:fixed;bottom:1.25rem;right:1rem;z-index:200;display:flex;flex-direction:column;gap:.5rem;align-items:flex-end}
.fb{border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;box-shadow:0 3px 12px rgba(0,0,0,.3);transition:transform .2s}
.fb:hover{transform:scale(1.08)}
.fb-music{width:44px;height:44px;background:var(--p);color:white;border-radius:50%;font-size:1rem}
.fb-gift{height:44px;min-width:44px;background:#25D366;color:white;padding:0 .85rem;font-size:.7rem;font-weight:700;gap:.3rem;border-radius:22px;font-family:var(--sans)}
.fb-share{width:44px;height:44px;background:var(--bg2);color:var(--muted);border:1px solid rgba(74,124,89,.2);border-radius:50%}
.mo{position:fixed;inset:0;background:rgba(0,0,0,.6);z-index:300;display:flex;align-items:flex-end;justify-content:center;opacity:0;pointer-events:none;transition:opacity .3s}
.mo.on{opacity:1;pointer-events:all}
.mb{background:var(--bg2);border-radius:14px 14px 0 0;padding:1.5rem;width:100%;max-width:440px;transform:translateY(100%);transition:transform .3s cubic-bezier(.34,1.56,.64,1);border-top:1px solid rgba(74,124,89,.15)}
.mo.on .mb{transform:translateY(0)}
.mh{width:36px;height:3px;background:#333;margin:0 auto 1.1rem}
.smo{position:fixed;inset:0;background:rgba(0,0,0,.6);z-index:300;display:flex;align-items:center;justify-content:center;padding:1rem;opacity:0;pointer-events:none;transition:opacity .3s}
.smo.on{opacity:1;pointer-events:all}
.smb{background:var(--bg2);border-radius:10px;padding:1.5rem;width:100%;max-width:400px;border:1px solid rgba(74,124,89,.15);transform:scale(.92);transition:transform .3s cubic-bezier(.34,1.56,.64,1)}
.smo.on .smb{transform:scale(1)}
.lbx{position:fixed;inset:0;background:rgba(0,0,0,.95);z-index:400;display:flex;align-items:center;justify-content:center;opacity:0;pointer-events:none;transition:opacity .3s}
.lbx.on{opacity:1;pointer-events:all}
.lbx img{max-width:92vw;max-height:90vh;object-fit:contain}
.lbx-x{position:absolute;top:.75rem;right:.75rem;background:rgba(74,124,89,.2);color:white;border:none;border-radius:50%;width:38px;height:38px;font-size:1.1rem;cursor:pointer}
footer{background:#0D1710;color:#3A5040;text-align:center;padding:1.75rem 1rem;font-size:.75rem;border-top:1px solid rgba(74,124,89,.08)}
footer strong{color:var(--muted)}
.share-btn{padding:.68rem;border:none;cursor:pointer;font-family:var(--sans);font-size:.78rem;font-weight:500;transition:all .2s}
</style>
</head>
<body>
@php $coupleOrder = $invitation->couple_order ?? "bride_first"; @endphp
@if(empty($isPreview))
<div id="op">
  <div class="op-wrap">
    <div class="op-circle">🌿</div>
    @if(!empty($guestName))<div class="op-to">Kepada Yth.</div><div class="op-guest">{{ $guestName }}</div>@endif
    <div class="op-from">
      @if($coupleOrder==='groom_first')
        <strong>{{ $invitation->groom_nickname ?: $invitation->groom_name }}</strong> <span style="color:var(--p)">&amp;</span> <strong>{{ $invitation->bride_nickname ?: $invitation->bride_name }}</strong>
      @else
        <strong>{{ $invitation->bride_nickname ?: $invitation->bride_name }}</strong> <span style="color:var(--p)">&amp;</span> <strong>{{ $invitation->groom_nickname ?: $invitation->groom_name }}</strong>
      @endif
    </div>
    <button class="op-btn" onclick="openInv()">Buka Undangan</button>
  </div>
</div>
@endif
<div id="mc" class="{{ !empty($isPreview)?'vis':'' }}">
@if(!empty($guestName))<div class="gbanner">💌 Kepada: <strong>{{ $guestName }}</strong></div>@endif
<div class="hero">
  <div class="hero-tag">Undangan Pernikahan</div>
  <div class="hero-names">{{ $invitation->groom_nickname ?: ($invitation->groom_name ?: 'Pengantin Pria') }}<br><span class="hero-amp">&amp;</span><br>{{ $invitation->bride_nickname ?: ($invitation->bride_name ?: 'Pengantin Wanita') }}</div>
  <div class="hero-line"></div>
  @if($invitation->akad_date)<div class="hero-date">{{ \Carbon\Carbon::parse($invitation->akad_date)->isoFormat('dddd, D MMMM YYYY') }}</div>@endif
  <div class="hero-photo-wrap"><div class="hero-photo">@if($invitation->cover_photo)<img src="{{ asset('storage/'.$invitation->cover_photo) }}" alt="">@else<div class="ph">💑</div>@endif</div></div>
</div>

@if($invitation->opening_text)
<div class="sec rv" style="text-align:center"><div style="font-family:var(--serif);font-size:.92rem;font-style:italic;color:var(--muted);line-height:2">{!! $invitation->opening_text !!}</div><div style="width:30px;height:1px;background:rgba(74,124,89,.4);margin:1.5rem auto 0"></div></div>
@endif

<div style="background:var(--bg2)">
<div class="sec rv">
  <div class="sh"><span class="sl">The Couple</span><div class="st">Kedua Mempelai</div></div>
  <div class="cc-row">
    <div class="cc">@if($invitation->groom_photo)<img src="{{ asset('storage/'.$invitation->groom_photo) }}" class="cc-img" alt="">@else<div class="cc-img-ph">🤵</div>@endif
      <div class="cc-role">Pengantin Pria</div><div class="cc-name">{{ $invitation->groom_name ?: 'Pengantin Pria' }}</div>
      <div class="cc-parents">Putra Bapak {{ $invitation->groom_father ?: '...' }}<br>& Ibu {{ $invitation->groom_mother ?: '...' }}</div>
    </div>
    <div class="cc">@if($invitation->bride_photo)<img src="{{ asset('storage/'.$invitation->bride_photo) }}" class="cc-img" alt="">@else<div class="cc-img-ph">👰</div>@endif
      <div class="cc-role">Pengantin Wanita</div><div class="cc-name">{{ $invitation->bride_name ?: 'Pengantin Wanita' }}</div>
      <div class="cc-parents">Putri Bapak {{ $invitation->bride_father ?: '...' }}<br>& Ibu {{ $invitation->bride_mother ?: '...' }}</div>
    </div>
  </div>
</div>
</div>

<div class="sec rv">
  <div class="sh"><span class="sl">Rangkaian Acara</span><div class="st">Hari Istimewa</div></div>
  @if($invitation->akad_date)<div style="text-align:center;margin-bottom:1.5rem"><div class="cd" id="cd"></div></div>@endif
@if($invitation->akad_date)
<div class="ev-card">
  <div class="ev-type">Akad Nikah</div><div class="ev-name">Ijab Qobul</div>
  <div class="ev-row"><span style="color:var(--p)">📅</span>{{ \Carbon\Carbon::parse($invitation->akad_date)->isoFormat('dddd, D MMMM YYYY') }}</div>
  @if($invitation->akad_time_start)<div class="ev-row"><span style="color:var(--p)">🕐</span>{{ $invitation->akad_time_start }}{{ $invitation->akad_time_end?' – '.$invitation->akad_time_end:'' }} WIB</div>@endif
  @if($invitation->akad_venue)<div class="ev-row"><span style="color:var(--p)">📍</span><div>{{ $invitation->akad_venue }}@if($invitation->akad_address)<br><span style="font-size:.72rem;color:#3A5040">{{ $invitation->akad_address }}</span>@endif</div></div>@endif
  @if($invitation->akad_maps_url)<a href="{{ $invitation->akad_maps_url }}" target="_blank" class="ev-link">📍 Buka Maps</a>@endif
</div>
@endif
@if($invitation->resepsi_date)
<div class="ev-card">
  <div class="ev-type">Resepsi</div><div class="ev-name">Walimatul Ursy</div>
  <div class="ev-row"><span style="color:var(--p)">📅</span>{{ \Carbon\Carbon::parse($invitation->resepsi_date)->isoFormat('dddd, D MMMM YYYY') }}</div>
  @if($invitation->resepsi_time_start)<div class="ev-row"><span style="color:var(--p)">🕐</span>{{ $invitation->resepsi_time_start }}{{ $invitation->resepsi_time_end?' – '.$invitation->resepsi_time_end:'' }} WIB</div>@endif
  @if($invitation->resepsi_venue)<div class="ev-row"><span style="color:var(--p)">📍</span><div>{{ $invitation->resepsi_venue }}@if($invitation->resepsi_address)<br><span style="font-size:.72rem;color:#3A5040">{{ $invitation->resepsi_address }}</span>@endif</div></div>@endif
  @if($invitation->resepsi_maps_url)<a href="{{ $invitation->resepsi_maps_url }}" target="_blank" class="ev-link">📍 Buka Maps</a>@endif
</div>
@endif
@if($invitation->livestream_url)
<div class="ev-card" style="border-left-color:#7C3AED">
  <div class="ev-type" style="color:#9C5CE6">Live Streaming</div>
  <div class="ev-name" style="color:var(--cream)">Saksikan Online</div>
  <a href="{{ $invitation->livestream_url }}" target="_blank" class="ev-link" style="color:#9C5CE6">▶ Tonton Live</a>
</div>
@endif
</div>

@if($invitation->photos && $invitation->photos->count()>0)
<div style="background:var(--bg2);padding:3.5rem 1.5rem"><div style="max-width:640px;margin:0 auto" class="rv"><div class="sh"><span class="sl">Gallery</span><div class="st">Momen Bersama</div></div><div class="gg">@foreach($invitation->photos->take(5) as $ph)<div class="gi" onclick="openLb('{{ asset('storage/'.$ph->photo) }}')"><img src="{{ asset('storage/'.$ph->photo) }}" loading="lazy" alt=""></div>@endforeach</div></div></div>
@endif

@php $stories = is_array($invitation->love_story_items) ? $invitation->love_story_items : (json_decode($invitation->love_story_items, true) ?? []); @endphp
@if(count($stories)>0)
<div class="sec rv"><div class="sh"><span class="sl">Our Story</span><div class="st">Perjalanan Kami</div></div><div class="tl">@foreach($stories as $s)<div class="tli rv">@if(!empty($s['date']))<div class="tli-date">{{ $s['date'] }}</div>@endif @if(!empty($s['title']))<div class="tli-title">{{ $s['title'] }}</div>@endif @if(!empty($s['content']))<div class="tli-text">{{ $s['content'] }}</div>@endif</div>@endforeach</div></div>
@endif

<div style="background:var(--bg2)">
<div class="sec rv">
  <div class="sh"><span class="sl">RSVP</span><div class="st">Konfirmasi Kehadiran</div></div>
  <div class="fc">
    <div id="rs-ok" style="display:none;text-align:center;padding:2rem"><div style="font-family:var(--serif);font-size:1.4rem;font-style:italic;color:var(--p)">Terima Kasih 🙏</div><p style="font-size:.82rem;color:var(--muted);margin-top:.4rem">Konfirmasi kehadiranmu sudah kami terima.</p></div>
    <div id="rs-form"><input class="fi" id="r-name" placeholder="Nama lengkap" value="{{ $guestName??'' }}"><input class="fi" id="r-phone" placeholder="No. WhatsApp (opsional)"><input class="fi" type="number" id="r-pax" value="1" min="1" max="20"><div style="font-size:.72rem;color:var(--muted);margin-bottom:.4rem;text-transform:uppercase;letter-spacing:.08em">Kehadiran</div><div class="rr"><div class="ro" id="rb-h" onclick="selA('hadir')">✅ Hadir</div><div class="ro" id="rb-t" onclick="selA('tidak_hadir')">❌ Tidak Hadir</div></div><textarea class="fi" id="r-msg" rows="2" placeholder="Pesan (opsional)" style="resize:none"></textarea><button class="sbtn" onclick="doRsvp()">Kirim Konfirmasi</button></div>
  </div>
  <div style="margin-top:2rem"><div class="sh"><span class="sl">Wishes</span><div class="st">Ucapan & Doa</div></div>
    <div class="fc" style="margin-bottom:1rem"><input class="fi" id="w-name" placeholder="Nama kamu"><textarea class="fi" id="w-msg" rows="3" placeholder="Ucapan dan doa untuk pengantin…" style="resize:none"></textarea><button class="sbtn" onclick="doWish()">Kirim Ucapan</button></div>
    <div id="wlist">@php $_wishes=$invitation->id?$invitation->wishes()->where('is_visible',true)->latest()->take(10)->get():collect();@endphp@foreach($_wishes as $w)<div class="wi"><div class="wn">{{ $w->name }}</div><div class="wm">{{ $w->message }}</div><div class="wt">{{ $w->created_at->diffForHumans() }}</div></div>@endforeach</div>
  </div>
</div>
</div>

@if($invitation->closing_text)<div class="sec rv" style="text-align:center"><p style="font-family:var(--serif);font-size:.9rem;font-style:italic;color:var(--muted);line-height:2">{!! $invitation->closing_text !!}</p><div style="font-family:var(--serif);font-size:1.6rem;font-style:italic;color:var(--cream);margin-top:.85rem">{{ $invitation->groom_nickname ?: $invitation->groom_name }} & {{ $invitation->bride_nickname ?: $invitation->bride_name }}</div></div>@endif
<footer><p>💝 <strong>{{ $invitation->title ?: 'Pernikahan Kami' }}</strong></p><p style="margin-top:.3rem">Dibuat dengan ❤️ oleh <strong>UndanganKu</strong></p></footer>
</div>
<div class="fls" id="fls" style="{{ empty($isPreview)?'display:none':'' }}">
  @if($invitation->music_file||$invitation->selected_music_key)<button class="fb fb-music" id="mbtn" onclick="togM()">🎵</button>@endif
  @if($invitation->gifts&&$invitation->gifts->count()>0)<button class="fb fb-gift" onclick="document.getElementById('gmod').classList.add('on')"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 12v10H4V12"/><path d="M22 7H2v5h20V7z"/><path d="M12 22V7"/></svg>Gift</button>@endif
  <button class="fb fb-share" onclick="document.getElementById('shmod').classList.add('on')"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg></button>
</div>
@if($invitation->gifts&&$invitation->gifts->count()>0)
<div class="mo" id="gmod" onclick="if(event.target===this)this.classList.remove('on')"><div class="mb"><div class="mh"></div><div style="font-weight:600;color:var(--cream);margin-bottom:1.1rem;font-size:.92rem">Send Your Gift</div>@foreach($invitation->gifts as $g)<div class="gr"><div class="gbk">{{ strtoupper(substr($g->bank_name,0,4)) }}</div><div style="flex:1"><div style="font-weight:500;color:var(--cream);font-size:.88rem">{{ $g->bank_name }}</div><div style="font-size:.82rem;color:var(--muted)">{{ $g->account_number }}</div><div style="font-size:.7rem;color:#3A5040">a.n. {{ $g->account_name }}</div></div><button class="cpbtn" onclick="cpTxt('{{ $g->account_number }}',this)">Copy</button></div>@endforeach</div></div>
@endif
<div class="smo" id="shmod" onclick="if(event.target===this)this.classList.remove('on')"><div class="smb"><div style="font-weight:600;color:var(--cream);margin-bottom:1rem;font-size:.92rem">Bagikan Undangan</div><div style="display:flex;align-items:center;gap:.4rem;background:#111E12;padding:.5rem .75rem;margin-bottom:.85rem;border:1px solid rgba(74,124,89,.15)"><input type="text" id="sh-link" readonly value="{{ url('/'.$invitation->slug) }}" style="flex:1;border:none;background:transparent;font-size:.7rem;outline:none;color:var(--muted)"><button onclick="cpTxt(document.getElementById('sh-link').value,this)" style="background:var(--p);color:white;border:none;padding:.25rem .65rem;font-size:.7rem;cursor:pointer">Salin</button></div><input type="text" id="sh-guest" placeholder="Nama tamu" class="fi" style="margin-bottom:.65rem"><div style="display:flex;gap:.5rem"><button class="share-btn" style="flex:1;background:var(--bg);color:var(--muted);border:1px solid rgba(74,124,89,.15)" onclick="doShare(false)">Tanpa Nama</button><button class="share-btn" style="flex:1;background:rgba(74,124,89,.15);color:var(--p);border:1px solid rgba(74,124,89,.3)" onclick="doShare(true)">Dengan Nama</button></div><button class="share-btn" style="width:100%;margin-top:.5rem;background:#25D366;color:white" onclick="doShareWA()">Broadcast WhatsApp →</button></div></div>
<div class="lbx" id="lbx" onclick="this.classList.remove('on')"><button class="lbx-x">✕</button><img id="lbx-img" src="" alt=""></div>
@if($invitation->music_file)<audio id="aud" loop><source src="{{ asset('storage/'.$invitation->music_file) }}"></audio>@elseif($invitation->selected_music_key)<audio id="aud" loop><source src="{{ $invitation->selected_music_key }}"></audio>@endif
<script>
const SLUG='{{ $invitation->slug }}';let att='',playing=false;
function openInv(){const a=document.getElementById('aud');if(a){a.play().then(()=>{playing=true;updM()}).catch(()=>{})}document.getElementById('op').classList.add('gone');document.getElementById('mc').classList.add('vis');document.getElementById('fls').style.display='flex'}
const obs=new IntersectionObserver(e=>e.forEach(x=>{if(x.isIntersecting){x.target.classList.add('iv');obs.unobserve(x.target)}}),{threshold:.1});document.querySelectorAll('.rv').forEach(e=>obs.observe(e));
@if($invitation->akad_date)function updCD(){const t=new Date('{{ $invitation->akad_date }}').getTime(),diff=t-Date.now();if(diff<=0){document.getElementById('cd').innerHTML='<div style="color:var(--p);font-family:var(--serif);font-style:italic">Hari Bahagia Telah Tiba 🎉</div>';return}const d=Math.floor(diff/86400000),h=Math.floor(diff%86400000/3600000),m=Math.floor(diff%3600000/60000),s=Math.floor(diff%60000/1000);document.getElementById('cd').innerHTML=[{v:d,l:'Hari'},{v:h,l:'Jam'},{v:m,l:'Menit'},{v:s,l:'Detik'}].map(x=>`<div class="cdb"><div class="cdn">${String(x.v).padStart(2,'0')}</div><div class="cdl">${x.l}</div></div>`).join('')}updCD();setInterval(updCD,1000);@endif
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
