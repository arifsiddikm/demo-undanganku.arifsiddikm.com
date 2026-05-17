<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
<title>Edit — {{ $invitation->title ?? 'UndanganKu' }}</title>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<style>
*{box-sizing:border-box;margin:0;padding:0}
:root{
  --pink:#F472B6;--pink-bg:#FDF2F8;--text:#1F2937;--muted:#6B7280;
  --border:#E5E7EB;--bg:#F1F3F9;
  --sans:'DM Sans',system-ui,sans-serif;
  --sidebar:220px;--panel:320px;
}
html,body{height:100%;overflow:hidden}
body{font-family:var(--sans);background:var(--bg);color:var(--text);-webkit-font-smoothing:antialiased}

/* TOPBAR */
.topbar{position:fixed;top:0;left:0;right:0;height:52px;z-index:200;background:white;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;padding:0 1rem;gap:1rem}
.topbar-left{display:flex;align-items:center;gap:1rem}
.back-btn{display:flex;align-items:center;gap:.3rem;font-size:.8rem;color:var(--muted);text-decoration:none;padding:.3rem .6rem;border-radius:6px;transition:background .2s}
.back-btn:hover{background:var(--bg)}
.logo{font-size:1.1rem;font-weight:700;color:var(--text)}
.logo span{color:var(--pink)}
.inv-name{font-size:.85rem;color:var(--muted);font-weight:500;max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.topbar-right{display:flex;align-items:center;gap:.75rem}
.save-status{display:flex;align-items:center;gap:.4rem;font-size:.78rem;color:var(--muted)}
.save-dot{width:7px;height:7px;border-radius:50%;background:#10B981;flex-shrink:0}
.save-dot.saving{background:#F59E0B;animation:pulse .8s infinite}
@keyframes pulse{0%,100%{opacity:1}50%{opacity:.4}}
.btn-primary{background:var(--pink);color:white;border:none;padding:.5rem 1.1rem;border-radius:8px;font-family:var(--sans);font-size:.82rem;font-weight:600;cursor:pointer;transition:opacity .2s}
.btn-primary:hover{opacity:.85}
.btn-outline{background:white;color:var(--text);border:1.5px solid var(--border);padding:.45rem 1rem;border-radius:8px;font-family:var(--sans);font-size:.82rem;font-weight:500;cursor:pointer;transition:all .2s;text-decoration:none;display:inline-flex;align-items:center;gap:.3rem}
.btn-outline:hover{border-color:var(--pink);color:var(--pink)}
.btn-sm{padding:.3rem .7rem;font-size:.75rem}
.btn-danger{background:#EF4444;color:white;border:none;padding:.3rem .65rem;border-radius:6px;font-size:.72rem;cursor:pointer}

/* LAYOUT */
.editor-wrap{display:flex;height:100vh;padding-top:52px}

/* SIDEBAR */
.sidebar{width:var(--sidebar);background:white;border-right:1px solid var(--border);flex-shrink:0;overflow-y:auto;display:flex;flex-direction:column}
.sidebar::-webkit-scrollbar{width:3px}
.sidebar::-webkit-scrollbar-thumb{background:#FBCFE8;border-radius:2px}
.sidebar-group{padding:.5rem}
.sidebar-label{font-size:.62rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#9CA3AF;padding:.6rem .75rem .2rem}
.nav-btn{display:flex;align-items:center;gap:.5rem;padding:.5rem .75rem;border-radius:8px;font-size:.8rem;font-weight:500;color:var(--muted);cursor:pointer;border:none;background:none;width:100%;text-align:left;transition:all .15s}
.nav-btn:hover{background:var(--pink-bg);color:var(--pink)}
.nav-btn.active{background:var(--pink-bg);color:var(--pink);font-weight:600}
.nav-icon{font-size:.95rem;flex-shrink:0;width:18px}

/* PANEL */
.panel-wrap{width:var(--panel);background:white;border-right:1px solid var(--border);flex-shrink:0;display:flex;flex-direction:column;overflow:hidden}
.panel-section{display:none;flex-direction:column;height:100%;overflow:hidden}
.panel-section.active-panel{display:flex}
.panel-hd{padding:.9rem 1rem;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-shrink:0}
.panel-title{font-weight:600;font-size:.88rem}
.panel-body{flex:1;overflow-y:auto;padding:1rem}
.panel-body::-webkit-scrollbar{width:3px}
.panel-body::-webkit-scrollbar-thumb{background:#FBCFE8;border-radius:2px}
.panel-foot{padding:.8rem 1rem;border-top:1px solid var(--border);flex-shrink:0}

/* FORM */
.form-group{margin-bottom:.85rem}
.form-label{display:block;font-size:.74rem;font-weight:500;color:var(--text);margin-bottom:.28rem}
.fi{display:block;width:100%;padding:.55rem .8rem;font-size:.82rem;font-family:var(--sans);color:var(--text);background:white;border:1.5px solid var(--border);border-radius:8px;outline:none;transition:border-color .2s}
.fi:focus{border-color:var(--pink);box-shadow:0 0 0 2px rgba(244,114,182,.1)}
.fi::placeholder{color:#9CA3AF}
textarea.fi{resize:vertical;min-height:80px}
select.fi{background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236B7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");background-repeat:no-repeat;background-position:right .6rem center;background-size:12px;-webkit-appearance:none;padding-right:2rem}

/* UPLOAD ZONE */
.upload-zone{border:2px dashed var(--border);border-radius:10px;padding:1.25rem 1rem;text-align:center;cursor:pointer;transition:border-color .2s;background:white}
.upload-zone:hover{border-color:var(--pink)}

/* PREVIEW */
.preview-area{flex:1;display:flex;flex-direction:column;overflow:hidden}
.preview-bar{height:46px;background:white;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:center;gap:.5rem;flex-shrink:0}
.preview-toggle{padding:.28rem .85rem;border-radius:6px;font-size:.74rem;font-weight:500;border:1.5px solid var(--border);background:white;cursor:pointer;transition:all .2s;display:flex;align-items:center;gap:.3rem;font-family:var(--sans)}
.preview-toggle:hover{border-color:var(--pink);color:var(--pink)}
.preview-toggle.on{background:var(--pink);border-color:var(--pink);color:white}
.preview-scroll{flex:1;overflow-y:auto;display:flex;align-items:flex-start;justify-content:center;padding:1.5rem}
.preview-frame{background:white;border-radius:12px;overflow:hidden;box-shadow:0 8px 32px rgba(0,0,0,.12);transition:width .3s,border-radius .3s}
.preview-frame.desktop{width:100%;max-width:960px}
.preview-frame.mobile{width:375px;border-radius:36px;box-shadow:0 12px 48px rgba(0,0,0,.2)}
.preview-iframe{width:100%;min-height:700px;border:none;display:block}

/* RADIO STATUS */
.status-radio-wrap{display:flex;flex-direction:column;gap:.5rem;margin-top:.4rem}
.status-radio{display:flex;align-items:flex-start;gap:.6rem;padding:.6rem .75rem;border:1.5px solid var(--border);border-radius:8px;cursor:pointer;transition:border-color .2s}
.status-radio:has(input:checked){border-color:var(--pink)}
.status-radio input{margin-top:2px;accent-color:var(--pink);flex-shrink:0}
.status-radio-label{font-size:.82rem;font-weight:600;color:var(--text)}
.status-radio-desc{font-size:.71rem;color:var(--muted)}

/* GUEST ROW */
.guest-row{padding:.75rem;background:#F9FAFB;border-radius:8px;margin-bottom:.5rem;display:flex;align-items:center;justify-content:space-between;gap:.5rem}
.guest-info{flex:1;min-width:0}
.guest-name{font-weight:600;font-size:.82rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.guest-meta{font-size:.72rem;color:var(--muted);margin-top:.1rem}
.guest-badge{font-size:.65rem;padding:.15rem .45rem;border-radius:4px;font-weight:600}
.badge-hadir{background:#D1FAE5;color:#065F46}
.badge-tidak{background:#FEE2E2;color:#991B1B}
.badge-pending{background:#FEF3C7;color:#92400E}

/* GIFT ROW */
.gift-row-item{padding:.75rem;background:#F9FAFB;border-radius:8px;margin-bottom:.5rem;display:flex;align-items:center;gap:.75rem}
.gift-bank-label{font-size:.62rem;font-weight:700;color:var(--pink);width:38px;flex-shrink:0;letter-spacing:.04em}

/* STORY ITEM */
.story-item{border:1.5px solid var(--border);border-radius:10px;padding:.85rem;margin-bottom:.6rem;position:relative}

/* MISC */
.section-divider{height:1px;background:var(--border);margin:.75rem 0}
.alert-warn{background:#FFFBEB;border:1px solid #FDE68A;border-radius:10px;padding:.85rem;font-size:.8rem;color:#92400E}
.alert-success{background:#F0FDF4;border:1px solid #BBF7D0;border-radius:10px;padding:.85rem;font-size:.8rem;color:#065F46}
.stat-box{background:var(--pink-bg);border-radius:10px;padding:.85rem;text-align:center}
.stat-num{font-size:1.5rem;font-weight:700;color:var(--pink);line-height:1}
.stat-label{font-size:.7rem;color:var(--muted);margin-top:.2rem}
.music-card{border:1.5px solid var(--border);border-radius:8px;padding:.65rem .85rem;margin-bottom:.4rem;display:flex;align-items:center;gap:.75rem;cursor:pointer;transition:border-color .2s}
.music-card:hover{border-color:var(--pink)}
.music-card.selected{border-color:var(--pink);background:var(--pink-bg)}
.preset-music-card{border:1.5px solid var(--border);border-radius:8px;padding:.65rem .85rem;margin-bottom:.4rem;cursor:pointer;transition:border-color .2s}
.preset-music-card:hover,.preset-music-card.sel{border-color:var(--pink)}
@keyframes spin{to{transform:rotate(360deg)}}
.couple-order-toggle{display:flex;gap:.4rem;background:#F9FAFB;border-radius:8px;padding:.3rem;margin-bottom:.75rem}
.cot-btn{flex:1;padding:.4rem;border-radius:6px;font-size:.74rem;font-weight:500;border:none;cursor:pointer;transition:all .2s;text-align:center;background:transparent;color:var(--muted)}
.cot-btn.cot-active{background:white;color:var(--text);box-shadow:0 1px 4px rgba(0,0,0,.08)}
</style>
</head>
<body>

{{-- TOPBAR --}}
<div class="topbar">
  <div class="topbar-left">
    <a href="{{ route('dashboard') }}" class="back-btn">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
      Kembali
    </a>
    <div class="logo">Undangan<span>Ku</span></div>
    <div class="inv-name">{{ $invitation->title }}</div>
  </div>
  <div class="topbar-right">
    <div class="save-status">
      <div class="save-dot" id="saveDot"></div>
      <span id="saveText">Tersimpan</span>
    </div>
    <button class="btn-primary" onclick="saveAll()">Simpan</button>
    @if($invitation->status === 'active')
    <a href="{{ url('/'.$invitation->slug) }}" target="_blank" class="btn-outline">
      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
      Lihat
    </a>
    @elseif(!$invitation->order || $invitation->order->payment_status !== 'paid')
    <a href="{{ route('invitations.upgrade', $invitation->id) }}"
       style="background:linear-gradient(135deg,#F59E0B,#EF4444);color:white;border:none;padding:.45rem 1rem;border-radius:8px;font-family:var(--sans);font-size:.78rem;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:.35rem;white-space:nowrap;">
      ⚡ Aktifkan Undangan
    </a>
    @endif
  </div>
</div>

<div class="editor-wrap">

{{-- ===== SIDEBAR ===== --}}
<div class="sidebar">
  <div class="sidebar-group">
    <button class="nav-btn active" onclick="showPanel('dashboard')" id="menu-dashboard"><span class="nav-icon">📊</span>Ringkasan</button>
  </div>
  <div class="sidebar-group">
    <div class="sidebar-label">Isi Undangan</div>
    <button class="nav-btn" onclick="showPanel('cover')"     id="menu-cover"><span class="nav-icon">🖼️</span>Sampul</button>
    <button class="nav-btn" onclick="showPanel('opening')"   id="menu-opening"><span class="nav-icon">📝</span>Kata Pembuka</button>
    <button class="nav-btn" onclick="showPanel('groom')"     id="menu-groom"><span class="nav-icon">🤵</span>Profil Pria</button>
    <button class="nav-btn" onclick="showPanel('bride')"     id="menu-bride"><span class="nav-icon">👰</span>Profil Wanita</button>
    <button class="nav-btn" onclick="showPanel('event')"     id="menu-event"><span class="nav-icon">📅</span>Detail Acara</button>
    <button class="nav-btn" onclick="showPanel('gallery')"   id="menu-gallery"><span class="nav-icon">📸</span>Galeri Foto</button>
    <button class="nav-btn" onclick="showPanel('lovestory')" id="menu-lovestory"><span class="nav-icon">❤️</span>Love Story</button>
    <button class="nav-btn" onclick="showPanel('closing')"   id="menu-closing"><span class="nav-icon">🙏</span>Kata Penutup</button>
  </div>
  <div class="sidebar-group">
    <div class="sidebar-label">Tamu</div>
    <button class="nav-btn" onclick="showPanel('guests')"  id="menu-guests"><span class="nav-icon">👥</span>Daftar Tamu</button>
    <button class="nav-btn" onclick="showPanel('rsvp')"    id="menu-rsvp"><span class="nav-icon">✅</span>Konfirmasi Hadir</button>
    <button class="nav-btn" onclick="showPanel('wishes')"  id="menu-wishes"><span class="nav-icon">💬</span>Ucapan & Doa</button>
    <button class="nav-btn" onclick="showPanel('gift')"    id="menu-gift"><span class="nav-icon">🎁</span>No. Rekening</button>
  </div>
  <div class="sidebar-group">
    <div class="sidebar-label">Pengaturan</div>
    <button class="nav-btn" onclick="showPanel('music')"    id="menu-music"><span class="nav-icon">🎵</span>Musik Latar</button>
    <button class="nav-btn" onclick="showPanel('message')"  id="menu-message"><span class="nav-icon">📨</span>Teks Undangan</button>
    <button class="nav-btn" onclick="showPanel('settings')" id="menu-settings"><span class="nav-icon">⚙️</span>Pengaturan</button>
  </div>
</div>

{{-- ===== PANEL WRAPPER ===== --}}
<div class="panel-wrap">

{{-- DASHBOARD --}}
<div id="panel-dashboard" class="panel-section">
  <div class="panel-hd"><div class="panel-title">📊 Ringkasan</div></div>
  <div class="panel-body">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:.6rem;margin-bottom:1rem">
      <div class="stat-box"><div class="stat-num">{{ $stats['total_rsvp'] ?? 0 }}</div><div class="stat-label">RSVP</div></div>
      <div class="stat-box" style="background:#F0FDF4"><div class="stat-num" style="color:#10B981">{{ $stats['hadir'] ?? 0 }}</div><div class="stat-label">Hadir</div></div>
      <div class="stat-box" style="background:#FFF1F2"><div class="stat-num" style="color:#E11D48">{{ $stats['tidak_hadir'] ?? 0 }}</div><div class="stat-label">Tidak Hadir</div></div>
      <div class="stat-box" style="background:#EFF6FF"><div class="stat-num" style="color:#2563EB">{{ $stats['total_wishes'] ?? 0 }}</div><div class="stat-label">Ucapan</div></div>
    </div>
    @if($invitation->status === 'active')
    <div class="alert-success" style="margin-bottom:1rem">
      <div style="font-weight:600;margin-bottom:.35rem">🟢 Undangan Aktif</div>
      <div style="display:flex;align-items:center;gap:.4rem">
        <input type="text" readonly value="{{ url('/'.$invitation->slug) }}" id="invLink" class="fi" style="font-size:.72rem;padding:.35rem .6rem">
        <button onclick="copyLink()" class="btn-primary btn-sm" style="flex-shrink:0">Salin</button>
      </div>
    </div>
    @else
    <div class="alert-warn" style="margin-bottom:1rem">⚠️ Undangan belum aktif. Selesaikan pembayaran untuk mengaktifkan.</div>
    @endif
    <div style="font-weight:600;font-size:.8rem;margin-bottom:.6rem">Ucapan Terbaru</div>
    @forelse($recentWishes ?? [] as $w)
    <div style="padding:.6rem;background:#F9FAFB;border-radius:8px;margin-bottom:.4rem">
      <div style="font-weight:500;font-size:.75rem">{{ $w->name }}</div>
      <div style="font-size:.72rem;color:var(--muted);line-height:1.5">{{ Str::limit($w->message, 80) }}</div>
    </div>
    @empty
    <div style="text-align:center;padding:1rem;font-size:.8rem;color:var(--muted)">Belum ada ucapan</div>
    @endforelse
  </div>
</div>

{{-- COVER --}}
<div id="panel-cover" class="panel-section">
  <div class="panel-hd"><div class="panel-title">🖼️ Sampul</div></div>
  <div class="panel-body">
    <div class="form-group">
      <label class="form-label">Judul Undangan</label>
      <input type="text" class="fi" name="title" value="{{ $invitation->title }}" placeholder="Cth: Ikhwan & Akhwat" data-field="title">
    </div>
    <div class="form-group">
      <label class="form-label">Foto Sampul</label>
      <div class="upload-zone" onclick="document.getElementById('coverPhotoInput').click()">
        @if($invitation->cover_photo)
        <img id="preview_cover_photo" src="{{ asset('storage/'.$invitation->cover_photo) }}" style="width:100%;height:120px;object-fit:cover;border-radius:8px;margin-bottom:.5rem">
        @else
        <img id="preview_cover_photo" style="width:100%;height:120px;object-fit:cover;border-radius:8px;margin-bottom:.5rem;display:none">
        @endif
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="1.5" style="margin:0 auto .35rem;display:block"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
        <div style="font-size:.75rem;color:var(--muted)">Klik untuk upload foto</div>
        <div style="font-size:.68rem;color:#9CA3AF;margin-top:.15rem">JPG, PNG, maks. 5MB</div>
      </div>
      <input type="file" id="coverPhotoInput" accept="image/*" style="display:none" onchange="uploadPhoto(this,'cover_photo')">
    </div>
    <div class="form-group">
      <label class="form-label">Template</label>
      @php
        $pkg = $invitation->order?->package;
        $pkgSlug = $pkg?->slug ?? 'basic';
        $allowedCats = match($pkgSlug) { 'luxury' => ['basic','premium','luxury'], 'premium' => ['basic','premium'], default => ['basic'] };
      @endphp
      @foreach($templates->groupBy('category') as $cat => $tpls)
      <div style="margin-bottom:.6rem">
        <div style="font-size:.65rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:{{ in_array($cat,$allowedCats)?'var(--pink)':'#9CA3AF' }};margin-bottom:.3rem">{{ ucfirst($cat) }}{{ !in_array($cat,$allowedCats)?' 🔒':'' }}</div>
        @foreach($tpls as $tpl)
        <label style="display:flex;align-items:center;gap:.6rem;padding:.5rem .65rem;border:1.5px solid {{ $invitation->template_id==$tpl->id?'var(--pink)':($cat&&!in_array($cat,$allowedCats)?'#E5E7EB':'#E5E7EB') }};border-radius:8px;margin-bottom:.3rem;cursor:{{ in_array($cat,$allowedCats)?'pointer':'not-allowed' }};opacity:{{ in_array($cat,$allowedCats)?'1':'.5' }}">
          <input type="radio" name="template_id" value="{{ $tpl->id }}" {{ $invitation->template_id==$tpl->id?'checked':'' }} {{ !in_array($cat,$allowedCats)?'disabled':'' }} style="accent-color:var(--pink)" onchange="saveTemplateChange(this.value)">
          <span style="flex:1;font-size:.8rem;font-weight:500">{{ $tpl->name }}</span>
          <span style="width:14px;height:14px;border-radius:50%;background:{{ $tpl->primary_color }};flex-shrink:0"></span>
        </label>
        @endforeach
      </div>
      @endforeach
    </div>
    <div class="form-group">
      <label class="form-label">Urutan Tampil Mempelai</label>
      <p style="font-size:.71rem;color:var(--muted);margin-bottom:.5rem">Siapa yang ditampilkan lebih dulu di undangan?</p>
      <div class="couple-order-toggle">
        <button type="button" class="cot-btn {{ ($invitation->couple_order ?? 'bride_first') === 'bride_first' ? 'cot-active' : '' }}" onclick="setCoupleOrder('bride_first')">👰 Wanita Dulu</button>
        <button type="button" class="cot-btn {{ ($invitation->couple_order ?? 'bride_first') === 'groom_first' ? 'cot-active' : '' }}" onclick="setCoupleOrder('groom_first')">🤵 Pria Dulu</button>
      </div>
      <input type="hidden" name="couple_order" id="coupleOrderInput" value="{{ $invitation->couple_order ?? 'bride_first' }}">
    </div>
    <div class="form-group">
      <label class="form-label">Warna Primer</label>
      <input type="color" name="color_primary" value="{{ $invitation->color_primary ?? '#D4A574' }}" class="fi" style="height:40px;padding:.2rem .4rem;cursor:pointer" onchange="triggerAutoSave()">
    </div>
    <div class="form-group">
      <label class="form-label">Warna Sekunder</label>
      <input type="color" name="color_secondary" value="{{ $invitation->color_secondary ?? '#F5E6D3' }}" class="fi" style="height:40px;padding:.2rem .4rem;cursor:pointer" onchange="triggerAutoSave()">
    </div>
    <div class="form-group">
      <label class="form-label">Font Judul</label>
      <select class="fi" name="font_family" onchange="triggerAutoSave()">
        @foreach(['Fraunces'=>'Fraunces (Elegan)','DM Serif Display'=>'DM Serif Display (Modern)','Lora'=>'Lora (Klasik)','Cormorant Garamond'=>'Cormorant Garamond (Mewah)','Libre Baskerville'=>'Libre Baskerville (Tegas)','Gloock'=>'Gloock (Editorial)'] as $fv=>$fl)
        <option value="{{ $fv }}" {{ ($invitation->font_family??'Fraunces')===$fv?'selected':'' }}>{{ $fl }}</option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="panel-foot"><button onclick="saveSection('cover')" class="btn-primary" style="width:100%">Simpan</button></div>
</div>

{{-- OPENING TEXT --}}
<div id="panel-opening" class="panel-section">
  <div class="panel-hd"><div class="panel-title">📝 Kata Pembuka</div></div>
  <div class="panel-body">
    <div class="form-group">
      <label class="form-label" style="margin-bottom:.4rem">Template referensi:</label>
      @php
      $openingRefs = [
        "Dengan memohon ridha dan rahmat Allah SWT, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dan memberikan do'a restu pada pernikahan putra-putri kami.",
        "Bismillahirrahmanirrahim. Assalamualaikum Warahmatullahi Wabarakatuh. Dengan penuh kebahagiaan dan kerendahan hati, kami mengundang kehadiran Bapak/Ibu/Saudara/i.",
        "Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan untukmu isteri-isteri dari jenismu sendiri, supaya kamu cenderung dan merasa tenteram kepadanya. (QS. Ar-Rum: 21)",
        "Dengan penuh syukur kepada Tuhan Yang Maha Esa atas segala rahmat dan karunia-Nya, kami bermaksud mengundang Bapak/Ibu/Saudara/i untuk turut merayakan momen istimewa kami.",
        "Maha Suci Allah yang telah menciptakan makhluk-Nya berpasang-pasangan. Dengan segala kerendahan hati, kami mengundang kehadiran Bapak/Ibu/Saudara/i di hari bahagia kami.",
      ];
      @endphp
      @foreach($openingRefs as $ref)
      <div onclick="document.querySelector('[name=opening_text]').value='{{ addslashes($ref) }}';triggerAutoSave();Swal.fire({icon:'success',title:'Template diterapkan!',timer:700,showConfirmButton:false})" style="padding:.5rem .65rem;background:#F9FAFB;border-radius:6px;font-size:.72rem;color:var(--muted);cursor:pointer;margin-bottom:.3rem;border:1.5px solid transparent;transition:border-color .2s;line-height:1.5" onmouseover="this.style.borderColor='var(--pink)'" onmouseout="this.style.borderColor='transparent'">
        {{ Str::limit($ref,85) }}… <span style="color:var(--pink);font-weight:500">Gunakan →</span>
      </div>
      @endforeach
    </div>
    <div class="form-group">
      <label class="form-label">Teks Kata Pembuka</label>
      <textarea class="fi" name="opening_text" rows="5" data-field="opening_text">{{ $invitation->opening_text }}</textarea>
    </div>
  </div>
  <div class="panel-foot"><button onclick="saveSection('opening')" class="btn-primary" style="width:100%">Simpan</button></div>
</div>

{{-- GROOM --}}
<div id="panel-groom" class="panel-section">
  <div class="panel-hd"><div class="panel-title">🤵 Profil Pengantin Pria</div></div>
  <div class="panel-body">
    <div class="form-group">
      <label class="form-label">Foto</label>
      <div class="upload-zone" onclick="document.getElementById('groomPhotoInput').click()">
        @if($invitation->groom_photo)<img id="preview_groom_photo" src="{{ asset('storage/'.$invitation->groom_photo) }}" style="width:100%;height:100px;object-fit:cover;border-radius:8px;margin-bottom:.4rem">@else<img id="preview_groom_photo" style="width:100%;height:100px;object-fit:cover;border-radius:8px;margin-bottom:.4rem;display:none">@endif
        <div style="font-size:.74rem;color:var(--muted)">Upload foto pengantin pria</div>
      </div>
      <input type="file" id="groomPhotoInput" accept="image/*" style="display:none" onchange="uploadPhoto(this,'groom_photo')">
    </div>
    @foreach([['groom_name','Nama Lengkap','Pengantin Pria, S.T.'],['groom_nickname','Nama Panggilan','Ikhwan'],['groom_father','Nama Ayah','...'],['groom_mother','Nama Ibu','...'],['groom_instagram','Instagram (tanpa @)',''],['groom_bio','Bio (opsional)','']] as [$n,$l,$p])
    <div class="form-group"><label class="form-label">{{ $l }}</label><input type="text" class="fi" name="{{ $n }}" value="{{ $invitation->$n }}" placeholder="{{ $p }}" data-field="{{ $n }}"></div>
    @endforeach
  </div>
  <div class="panel-foot"><button onclick="saveSection('groom')" class="btn-primary" style="width:100%">Simpan</button></div>
</div>

{{-- BRIDE --}}
<div id="panel-bride" class="panel-section">
  <div class="panel-hd"><div class="panel-title">👰 Profil Pengantin Wanita</div></div>
  <div class="panel-body">
    <div class="form-group">
      <label class="form-label">Foto</label>
      <div class="upload-zone" onclick="document.getElementById('bridePhotoInput').click()">
        @if($invitation->bride_photo)<img id="preview_bride_photo" src="{{ asset('storage/'.$invitation->bride_photo) }}" style="width:100%;height:100px;object-fit:cover;border-radius:8px;margin-bottom:.4rem">@else<img id="preview_bride_photo" style="width:100%;height:100px;object-fit:cover;border-radius:8px;margin-bottom:.4rem;display:none">@endif
        <div style="font-size:.74rem;color:var(--muted)">Upload foto pengantin wanita</div>
      </div>
      <input type="file" id="bridePhotoInput" accept="image/*" style="display:none" onchange="uploadPhoto(this,'bride_photo')">
    </div>
    @foreach([['bride_name','Nama Lengkap','Pengantin Wanita, S.Pd.'],['bride_nickname','Nama Panggilan','Akhwat'],['bride_father','Nama Ayah','...'],['bride_mother','Nama Ibu','...'],['bride_instagram','Instagram (tanpa @)',''],['bride_bio','Bio (opsional)','']] as [$n,$l,$p])
    <div class="form-group"><label class="form-label">{{ $l }}</label><input type="text" class="fi" name="{{ $n }}" value="{{ $invitation->$n }}" placeholder="{{ $p }}" data-field="{{ $n }}"></div>
    @endforeach
  </div>
  <div class="panel-foot"><button onclick="saveSection('bride')" class="btn-primary" style="width:100%">Simpan</button></div>
</div>

{{-- EVENTS --}}
<div id="panel-event" class="panel-section">
  <div class="panel-hd"><div class="panel-title">📅 Detail Acara</div></div>
  <div class="panel-body">
    <div style="font-size:.72rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--muted);margin-bottom:.6rem">Akad Nikah</div>
    <div class="form-group"><label class="form-label">Tanggal</label><input type="text" class="fi flatpickr" name="akad_date" value="{{ $invitation->akad_date }}" placeholder="Pilih tanggal" data-field="akad_date"></div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:.6rem">
      <div class="form-group"><label class="form-label">Jam Mulai</label><input type="text" class="fi" name="akad_time_start" value="{{ $invitation->akad_time_start }}" placeholder="08:00" data-field="akad_time_start"></div>
      <div class="form-group"><label class="form-label">Jam Selesai</label><input type="text" class="fi" name="akad_time_end" value="{{ $invitation->akad_time_end }}" placeholder="10:00" data-field="akad_time_end"></div>
    </div>
    <div class="form-group"><label class="form-label">Nama Gedung/Tempat</label><input type="text" class="fi" name="akad_venue" value="{{ $invitation->akad_venue }}" placeholder="Masjid Al-Ikhlas" data-field="akad_venue"></div>
    <div class="form-group"><label class="form-label">Alamat Lengkap</label><textarea class="fi" name="akad_address" rows="2" data-field="akad_address">{{ $invitation->akad_address }}</textarea></div>
    <div class="form-group"><label class="form-label">Link Google Maps</label><input type="text" class="fi" name="akad_maps_url" value="{{ $invitation->akad_maps_url }}" placeholder="https://maps.google.com/..." data-field="akad_maps_url"></div>

    <div class="section-divider"></div>

    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:.6rem">
      <div style="font-size:.72rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--muted)">Resepsi</div>
      <label style="display:flex;align-items:center;gap:.4rem;cursor:pointer;font-size:.74rem;color:var(--muted)">
        <input type="checkbox" id="sameAsAkad" {{ $invitation->resepsi_same_as_akad?'checked':'' }} onchange="toggleResepsiSame(this.checked)" style="accent-color:var(--pink);width:14px;height:14px"> Sama dengan Akad
      </label>
    </div>
    <div id="resepsiFields">
      <div class="form-group"><label class="form-label">Tanggal</label><input type="text" class="fi flatpickr" name="resepsi_date" value="{{ $invitation->resepsi_date }}" placeholder="Pilih tanggal" data-field="resepsi_date"></div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:.6rem">
        <div class="form-group"><label class="form-label">Jam Mulai</label><input type="text" class="fi" name="resepsi_time_start" value="{{ $invitation->resepsi_time_start }}" placeholder="11:00" data-field="resepsi_time_start"></div>
        <div class="form-group"><label class="form-label">Jam Selesai</label><input type="text" class="fi" name="resepsi_time_end" value="{{ $invitation->resepsi_time_end }}" placeholder="15:00" data-field="resepsi_time_end"></div>
      </div>
      <div class="form-group"><label class="form-label">Nama Gedung/Tempat</label><input type="text" class="fi" name="resepsi_venue" value="{{ $invitation->resepsi_venue }}" placeholder="Gedung Serbaguna" data-field="resepsi_venue"></div>
      <div class="form-group"><label class="form-label">Alamat Lengkap</label><textarea class="fi" name="resepsi_address" rows="2" data-field="resepsi_address">{{ $invitation->resepsi_address }}</textarea></div>
      <div class="form-group"><label class="form-label">Link Google Maps</label><input type="text" class="fi" name="resepsi_maps_url" value="{{ $invitation->resepsi_maps_url }}" placeholder="https://maps.google.com/..." data-field="resepsi_maps_url"></div>
    </div>
    <input type="hidden" name="resepsi_same_as_akad" id="rsamehid" value="{{ $invitation->resepsi_same_as_akad?1:0 }}">

    <div class="section-divider"></div>
    <div class="form-group"><label class="form-label">URL Live Streaming (opsional)</label><input type="text" class="fi" name="livestream_url" value="{{ $invitation->livestream_url }}" placeholder="https://youtube.com/live/..." data-field="livestream_url"></div>
  </div>
  <div class="panel-foot"><button onclick="saveSection('event')" class="btn-primary" style="width:100%">Simpan</button></div>
</div>

{{-- GALLERY --}}
<div id="panel-gallery" class="panel-section">
  <div class="panel-hd"><div class="panel-title">📸 Galeri Foto</div></div>
  <div class="panel-body">
    @if(!$hasGallery)
    <div class="alert-warn" style="margin-bottom:1rem">⚠️ Galeri foto tersedia di paket <strong>Premium</strong> dan <strong>Luxury</strong>.</div>
    @endif
    <div style="{{ !$hasGallery?'opacity:.5;pointer-events:none':'' }}">
      <div class="form-group">
        <div class="upload-zone" onclick="document.getElementById('galleryInput').click()">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="1.5" style="margin:0 auto .35rem;display:block"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
          <div style="font-size:.75rem;color:var(--muted)">Upload foto (bisa pilih beberapa)</div>
          <div style="font-size:.68rem;color:#9CA3AF;margin-top:.15rem">JPG, PNG, maks. 5MB per foto</div>
        </div>
        <input type="file" id="galleryInput" accept="image/*" multiple style="display:none" onchange="uploadGallery(this)">
      </div>
      <div style="font-size:.78rem;font-weight:500;margin-bottom:.6rem" id="photoCount">Foto tersimpan ({{ $photos->count() }}):</div>
      <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:.4rem" id="galleryGrid">
        @foreach($photos as $p)
        <div id="photo-{{ $p->id }}" class="gallery-photo-item" style="position:relative;aspect-ratio:1;overflow:hidden;border-radius:6px">
          <img src="{{ asset('storage/'.$p->photo) }}" style="width:100%;height:100%;object-fit:cover">
          <button onclick="deletePhoto({{ $p->id }})" style="position:absolute;top:.25rem;right:.25rem;background:rgba(0,0,0,.5);color:white;border:none;border-radius:50%;width:22px;height:22px;font-size:.75rem;cursor:pointer;line-height:1">×</button>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>

{{-- LOVE STORY --}}
<div id="panel-lovestory" class="panel-section">
  <div class="panel-hd">
    <div class="panel-title">❤️ Love Story</div>
    <button onclick="addStoryItem()" class="btn-primary btn-sm">+ Tambah</button>
  </div>
  <div class="panel-body">
    <div style="font-size:.78rem;color:var(--muted);margin-bottom:.75rem;line-height:1.6">Tampil sebagai timeline di undangan. Tambah beberapa momen penting.</div>
    <div id="storyItems">
      @php $storyItems = is_string($invitation->love_story_items) ? json_decode($invitation->love_story_items, true) : ($invitation->love_story_items ?? []); @endphp
      @foreach($storyItems ?? [] as $s)
      <div class="story-item">
        <button onclick="removeStoryItem(this)" style="position:absolute;top:.5rem;right:.5rem;background:none;border:none;color:#9CA3AF;cursor:pointer;font-size:1.1rem;line-height:1">×</button>
        <div class="form-group"><label class="form-label" style="font-size:.7rem">Judul</label><input type="text" class="fi story-title" placeholder="Pertama Bertemu" value="{{ $s['title']??'' }}" style="font-size:.8rem"></div>
        <div class="form-group"><label class="form-label" style="font-size:.7rem">Tanggal</label><input type="text" class="fi story-date" placeholder="Juni 2020" value="{{ $s['date']??'' }}" style="font-size:.8rem"></div>
        <div class="form-group"><label class="form-label" style="font-size:.7rem">Cerita</label><textarea class="fi story-content" rows="3" placeholder="Cerita singkat..." style="font-size:.8rem;resize:none">{{ $s['content']??'' }}</textarea></div>
      </div>
      @endforeach
    </div>
    @if(empty($storyItems))<div id="storyEmptyMsg" style="text-align:center;padding:1.5rem;color:var(--muted);font-size:.8rem">Belum ada momen. Klik "+ Tambah".</div>@endif
  </div>
  <div class="panel-foot"><button id="saveStoryBtn" onclick="saveStoryItems()" class="btn-primary" style="width:100%">Simpan Love Story</button></div>
</div>

{{-- CLOSING --}}
<div id="panel-closing" class="panel-section">
  <div class="panel-hd"><div class="panel-title">🙏 Kata Penutup</div></div>
  <div class="panel-body">
    <div class="form-group">
      <label class="form-label" style="margin-bottom:.4rem">Template referensi:</label>
      @php
      $closingRefs = [
        "Merupakan kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan do'a restu. Atas kehadiran dan do'a restu, kami mengucapkan terima kasih.",
        "Tanpa mengurangi rasa hormat, kami memohon maaf apabila ada kekurangan dalam penyampaian undangan ini. Besar harapan kami atas kehadiran Bapak/Ibu/Saudara/i.",
        "Dengan kehadiran Bapak/Ibu/Saudara/i, hari istimewa kami akan semakin lengkap dan bermakna. Semoga Allah SWT membalas kebaikan Bapak/Ibu/Saudara/i dengan berlipat ganda.",
        "Kami memohon do'a restu agar pernikahan kami menjadi keluarga yang sakinah, mawaddah, warahmah. Terima kasih atas segala perhatian dan kasih sayang Bapak/Ibu/Saudara/i.",
        "Hormat kami, semoga silaturahmi kita selalu terjaga. Atas segala perhatian dan kehadiran Bapak/Ibu/Saudara/i kami mengucapkan Jazakumullahu Khairan Katsiran.",
      ];
      @endphp
      @foreach($closingRefs as $ref)
      <div onclick="document.querySelector('[name=closing_text]').value='{{ addslashes($ref) }}';triggerAutoSave();Swal.fire({icon:'success',title:'Template diterapkan!',timer:700,showConfirmButton:false})" style="padding:.5rem .65rem;background:#F9FAFB;border-radius:6px;font-size:.72rem;color:var(--muted);cursor:pointer;margin-bottom:.3rem;border:1.5px solid transparent;transition:border-color .2s;line-height:1.5" onmouseover="this.style.borderColor='var(--pink)'" onmouseout="this.style.borderColor='transparent'">
        {{ Str::limit($ref,85) }}… <span style="color:var(--pink);font-weight:500">Gunakan →</span>
      </div>
      @endforeach
    </div>
    <div class="form-group">
      <label class="form-label">Teks Penutup</label>
      <textarea class="fi" name="closing_text" rows="5" data-field="closing_text" placeholder="Merupakan kehormatan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir...">{{ $invitation->closing_text }}</textarea>
    </div>
  </div>
  <div class="panel-foot"><button onclick="saveSection('closing')" class="btn-primary" style="width:100%">Simpan</button></div>
</div>

{{-- GUESTS --}}
<div id="panel-guests" class="panel-section">
  <div class="panel-hd"><div class="panel-title">👥 Daftar Tamu</div></div>
  <div class="panel-body">
    <form id="addGuestForm" onsubmit="submitAddGuest(event)" style="background:#F9FAFB;border-radius:10px;padding:.85rem;margin-bottom:1rem">
      @csrf
      <input type="hidden" name="invitation_id" value="{{ $invitation->id }}">
      <div class="form-group"><label class="form-label">Nama Tamu</label><input type="text" class="fi" name="name" placeholder="Nama lengkap tamu" required style="font-size:.82rem"></div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:.5rem">
        <div class="form-group"><label class="form-label">No. HP</label><input type="text" class="fi" name="phone" placeholder="0812xxx" style="font-size:.8rem"></div>
        <div class="form-group"><label class="form-label">Jumlah Pax</label><input type="number" class="fi" name="pax" value="1" min="1" max="20" style="font-size:.8rem"></div>
      </div>
      <button type="submit" class="btn-primary btn-sm" style="width:100%">+ Tambah Tamu</button>
    </form>
    <div id="guestList">
      @forelse($guests as $g)
      <div class="guest-row" id="guestRow{{ $g->id }}">
        <div class="guest-info">
          <div class="guest-name">{{ $g->name }}</div>
          <div class="guest-meta">{{ $g->phone ?: '-' }} · {{ $g->pax }} pax
            <span class="guest-badge {{ $g->status==='hadir'?'badge-hadir':($g->status==='tidak_hadir'?'badge-tidak':'badge-pending') }}">{{ $g->status==='hadir'?'Hadir':($g->status==='tidak_hadir'?'Tidak':'Pending') }}</span>
          </div>
        </div>
        <div style="display:flex;gap:.35rem;flex-shrink:0">
          <button onclick="showGuestShare('{{ addslashes($g->name) }}')" class="btn-outline btn-sm">🔗</button>
          <button onclick="deleteGuest({{ $g->id }},this)" class="btn-danger">×</button>
        </div>
      </div>
      @empty
      <div style="text-align:center;padding:1.5rem;font-size:.8rem;color:var(--muted)" id="noGuests">Belum ada tamu</div>
      @endforelse
    </div>
  </div>
</div>

{{-- RSVP --}}
<div id="panel-rsvp" class="panel-section">
  <div class="panel-hd"><div class="panel-title">✅ Konfirmasi Hadir</div></div>
  <div class="panel-body">
    @forelse($rsvps as $r)
    <div style="padding:.65rem;background:#F9FAFB;border-radius:8px;margin-bottom:.4rem">
      <div style="display:flex;align-items:center;justify-content:space-between">
        <span style="font-weight:600;font-size:.82rem">{{ $r->name }}</span>
        <span class="guest-badge {{ $r->attendance==='hadir'?'badge-hadir':($r->attendance==='tidak_hadir'?'badge-tidak':'badge-pending') }}">{{ $r->attendance==='hadir'?'Hadir':($r->attendance==='tidak_hadir'?'Tidak':'Pending') }}</span>
      </div>
      <div style="font-size:.72rem;color:var(--muted);margin-top:.15rem">{{ $r->pax }} pax · {{ $r->phone?:'No HP' }}</div>
      @if($r->message)<div style="font-size:.72rem;color:var(--muted);margin-top:.2rem;font-style:italic">"{{ Str::limit($r->message,60) }}"</div>@endif
    </div>
    @empty
    <div style="text-align:center;padding:2rem;font-size:.82rem;color:var(--muted)">Belum ada konfirmasi hadir</div>
    @endforelse
  </div>
</div>

{{-- WISHES --}}
<div id="panel-wishes" class="panel-section">
  <div class="panel-hd"><div class="panel-title">💬 Ucapan & Doa</div></div>
  <div class="panel-body">
    @forelse($wishes as $w)
    <div style="padding:.65rem;background:#F9FAFB;border-radius:8px;margin-bottom:.4rem;border-left:3px solid var(--pink)">
      <div style="font-weight:600;font-size:.82rem">{{ $w->name }}</div>
      <div style="font-size:.8rem;color:var(--muted);line-height:1.6;margin-top:.2rem">{{ $w->message }}</div>
      <div style="font-size:.68rem;color:#C0BAB5;margin-top:.25rem">{{ $w->created_at->diffForHumans() }}</div>
    </div>
    @empty
    <div style="text-align:center;padding:2rem;font-size:.82rem;color:var(--muted)">Belum ada ucapan</div>
    @endforelse
  </div>
</div>

{{-- GIFT --}}
<div id="panel-gift" class="panel-section">
  <div class="panel-hd"><div class="panel-title">🎁 No. Rekening Hadiah</div></div>
  <div class="panel-body">
    <form id="addGiftForm" onsubmit="submitAddGift(event)" style="background:#F9FAFB;border-radius:10px;padding:.85rem;margin-bottom:1rem">
      @csrf
      <input type="hidden" name="invitation_id" value="{{ $invitation->id }}">
      <div class="form-group"><label class="form-label">Nama Bank/E-Wallet</label><input type="text" class="fi" name="bank_name" placeholder="BCA / GoPay / OVO" required style="font-size:.82rem"></div>
      <div class="form-group"><label class="form-label">Nomor Rekening</label><input type="text" class="fi" name="account_number" placeholder="0812345678" required style="font-size:.82rem"></div>
      <div class="form-group"><label class="form-label">Atas Nama</label><input type="text" class="fi" name="account_name" placeholder="Nama pemilik" required style="font-size:.82rem"></div>
      <button type="submit" class="btn-primary btn-sm" style="width:100%">+ Tambah Rekening</button>
    </form>
    <div id="giftList">
      @forelse($gifts as $g)
      <div class="gift-row-item" id="giftRow{{ $g->id }}">
        <div class="gift-bank-label">{{ strtoupper(substr($g->bank_name,0,4)) }}</div>
        <div style="flex:1"><div style="font-weight:600;font-size:.82rem">{{ $g->bank_name }}</div><div style="font-size:.78rem;color:var(--muted)">{{ $g->account_number }}</div><div style="font-size:.72rem;color:#9CA3AF">a.n. {{ $g->account_name }}</div></div>
        <button onclick="deleteGift({{ $g->id }},this)" class="btn-danger">×</button>
      </div>
      @empty
      <div style="text-align:center;padding:1.5rem;font-size:.8rem;color:var(--muted)" id="noGifts">Belum ada rekening</div>
      @endforelse
    </div>
  </div>
</div>

{{-- MUSIC --}}
<div id="panel-music" class="panel-section">
  <div class="panel-hd"><div class="panel-title">🎵 Musik Latar</div></div>
  <div class="panel-body">
    @if(!$hasMusic)
    <div class="alert-warn" style="margin-bottom:1rem">⚠️ Fitur musik tersedia di paket <strong>Premium</strong> dan <strong>Luxury</strong>.</div>
    @endif
    <div style="{{ !$hasMusic?'opacity:.5;pointer-events:none':'' }}">
      <div style="font-size:.78rem;font-weight:600;margin-bottom:.6rem">Pilih dari daftar lagu:</div>
      @foreach($presetMusics ?? [] as $pm)
      <div class="preset-music-card {{ ($invitation->selected_music_key??'')===$pm->file_url?'sel':'' }}" onclick="selectPresetMusic('{{ $pm->file_url }}',this)">
        <div style="display:flex;align-items:center;gap:.6rem;margin-bottom:.4rem">
          <input type="radio" name="selected_music_key" value="{{ $pm->file_url }}" {{ ($invitation->selected_music_key??'')===$pm->file_url?'checked':'' }} style="accent-color:var(--pink)">
          <div style="flex:1"><div style="font-size:.82rem;font-weight:500">{{ $pm->title }}</div>@if($pm->artist)<div style="font-size:.72rem;color:var(--muted)">{{ $pm->artist }}</div>@endif</div>
        </div>
        <audio controls style="width:100%;height:28px" preload="none"><source src="{{ $pm->file_url }}"></audio>
      </div>
      @endforeach
      <div class="section-divider"></div>
      <div style="font-size:.78rem;font-weight:600;margin-bottom:.4rem">Atau upload file sendiri:</div>
      <div class="upload-zone" onclick="document.getElementById('musicInput').click()">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="1.5" style="margin:0 auto .3rem;display:block"><path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/></svg>
        <div style="font-size:.74rem;color:var(--muted)">Upload MP3 (maks. 10MB)</div>
        @if($invitation->music_file)<div style="font-size:.7rem;color:var(--pink);margin-top:.2rem" id="musicFileName">{{ basename($invitation->music_file) }}</div>@else<div id="musicFileName" style="font-size:.7rem;color:var(--pink);margin-top:.2rem;display:none"></div>@endif
      </div>
      <input type="file" id="musicInput" accept="audio/*" style="display:none" onchange="uploadMusic(this)">
      <div class="form-group" style="margin-top:.75rem">
        <label style="display:flex;align-items:center;gap:.5rem;cursor:pointer;font-size:.82rem;font-weight:400">
          <input type="checkbox" name="music_autoplay" style="accent-color:var(--pink);width:15px;height:15px" {{ $invitation->music_autoplay?'checked':'' }}> Putar otomatis saat undangan dibuka
        </label>
      </div>
    </div>
  </div>
  {{-- Audio preview for selected preset music --}}
  @if($invitation->selected_music_key)
  <audio id="musicPreviewAudio" controls style="width:100%;margin-bottom:.5rem;border-radius:8px;" src="{{ $invitation->selected_music_key }}"></audio>
  @else
  <audio id="musicPreviewAudio" controls style="width:100%;margin-bottom:.5rem;border-radius:8px;display:none;"></audio>
  @endif
  <input type="hidden" id="selectedMusicKeyHidden" name="selected_music_key" value="{{ $invitation->selected_music_key ?? '' }}">
  <div class="panel-foot"><button onclick="saveSection('music')" class="btn-primary" style="width:100%">Simpan</button></div>
</div>

{{-- MESSAGE --}}
<div id="panel-message" class="panel-section">
  <div class="panel-hd"><div class="panel-title">📨 Teks Undangan WA</div></div>
  <div class="panel-body">
    <div style="font-size:.78rem;color:var(--muted);margin-bottom:.75rem;line-height:1.6">Template pesan WA yang dikirim bersama link undangan ke tamu.</div>
    <div style="font-size:.72rem;font-weight:600;color:var(--muted);margin-bottom:.4rem">Klik variabel untuk sisipkan:</div>
    <div style="display:flex;flex-wrap:wrap;gap:.35rem;margin-bottom:.75rem">
      @foreach(['nama_tamu','link_undangan','nama_pengantin_pria','nama_pengantin_wanita'] as $var)
      @php $vd = '{' . '{' . ' ' . $var . ' ' . '}' . '}'; @endphp
      <span onclick="insertVar('{{ $var }}')" style="padding:.2rem .5rem;background:var(--pink-bg);color:var(--pink);border-radius:4px;font-size:.7rem;cursor:pointer;font-family:monospace;border:1px solid rgba(244,114,182,.2)">{{ $vd }}</span>
      @endforeach
    </div>
    <div style="font-size:.72rem;font-weight:600;color:var(--muted);margin-bottom:.4rem">Referensi:</div>
    @php
    $refs = [
      "Assalamualaikum Warahmatullahi Wabarakatuh,\nKepada Yth. *{nama_tamu}*\n\nIzinkan kami mengundang kehadiran Bapak/Ibu/Saudara/i.\n\nLink: {link_undangan}\n\nYang Berbahagia,\n*{nama_pengantin_pria}* & *{nama_pengantin_wanita}*",
      "Halo *{nama_tamu}* 👋\n\nYuk hadir di hari spesial kami!\n\nLink: {link_undangan}\n\n*{nama_pengantin_pria}* & *{nama_pengantin_wanita}*"
    ];
    @endphp
    @foreach($refs as $ref)
    <div onclick="useMessageRef(this.dataset.msg)" data-msg="{{ addslashes($ref) }}" style="padding:.5rem .65rem;background:#F9FAFB;border-radius:6px;font-size:.72rem;color:var(--muted);cursor:pointer;margin-bottom:.3rem;border:1.5px solid transparent;line-height:1.5;transition:border-color .2s" onmouseover="this.style.borderColor='var(--pink)'" onmouseout="this.style.borderColor='transparent'">
      {{ Str::limit(str_replace(['\n','*'],[' ',''], $ref), 90) }} <span style="color:var(--pink);font-weight:500">Gunakan →</span>
    </div>
    @endforeach
    <div class="form-group" style="margin-top:.75rem">
      <label class="form-label">Teks Kustom</label>
      <textarea class="fi" id="invMessageTA" name="invitation_message" rows="8" style="font-size:.8rem;font-family:monospace;min-height:160px">{{ $invitation->invitation_message }}</textarea>
    </div>
  </div>
  <div class="panel-foot"><button onclick="saveMessageSection()" class="btn-primary" style="width:100%">Simpan</button></div>
</div>

{{-- SETTINGS --}}
<div id="panel-settings" class="panel-section">
  <div class="panel-hd"><div class="panel-title">⚙️ Pengaturan</div></div>
  <div class="panel-body">
    <div class="form-group">
      <label class="form-label">URL Slug Undangan</label>
      <div style="display:flex;align-items:center;gap:.4rem">
        <span style="font-size:.72rem;color:var(--muted);white-space:nowrap">{{ url('/') }}/</span>
        <input type="text" class="fi" name="slug" id="slugInput" value="{{ $invitation->slug }}" placeholder="nama-pengantin" oninput="checkSlug(this.value)" style="flex:1">
      </div>
      <div id="slugStatus" style="font-size:.72rem;margin-top:.25rem"></div>
    </div>
    <div class="form-group">
      <label class="form-label">Status Publikasi</label>
      @if($invitation->order && $invitation->order->payment_status === 'paid')
      <div class="status-radio-wrap">
        @foreach(['draft'=>['🟡 Draft','Tidak bisa diakses publik'],'active'=>['🟢 Aktif','Link bisa diakses semua orang'],'inactive'=>['🔴 Nonaktif','Disembunyikan sementara']] as $val=>[$lbl,$desc])
        <label class="status-radio">
          <input type="radio" name="status" value="{{ $val }}" {{ $invitation->status===$val?'checked':'' }} onchange="triggerAutoSave()">
          <div><div class="status-radio-label">{{ $lbl }}</div><div class="status-radio-desc">{{ $desc }}</div></div>
        </label>
        @endforeach
      </div>
      @else
      <div class="alert-warn">⚠️ Selesaikan pembayaran untuk mempublikasikan undangan ini.</div>
      @endif
    </div>
    @if($invitation->status === 'active')
    <div class="form-group">
      <div class="alert-success">
        <div style="font-weight:600;margin-bottom:.35rem">🟢 Link Aktif</div>
        <div style="display:flex;align-items:center;gap:.4rem">
          <input type="text" readonly value="{{ url('/'.$invitation->slug) }}" id="invLinkInput" class="fi" style="font-size:.72rem;padding:.35rem .6rem">
          <button onclick="copyInvLink()" class="btn-primary btn-sm" style="flex-shrink:0">Salin</button>
        </div>
      </div>
    </div>
    @endif
  </div>
  <div class="panel-foot"><button onclick="saveSection('settings')" class="btn-primary" style="width:100%">Simpan</button></div>
</div>

</div>{{-- end panel-wrap --}}

{{-- ===== PREVIEW AREA ===== --}}
<div class="preview-area">
  <div class="preview-bar">
    <button class="preview-toggle on" id="btn-desktop" onclick="setPreviewMode('desktop')">
      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>Desktop
    </button>
    <button class="preview-toggle" id="btn-mobile" onclick="setPreviewMode('mobile')">
      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>Mobile
    </button>
    <button class="preview-toggle" onclick="refreshPreview()" style="margin-left:.25rem">
      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 11-2.12-9.36L23 10"/></svg>Refresh
    </button>
  </div>
  <div class="preview-scroll">
    <div class="preview-frame desktop" id="previewFrame" style="position:relative;">
      <div id="previewLoader" style="position:absolute;inset:0;background:white;display:flex;align-items:center;justify-content:center;z-index:10;border-radius:12px;">
        <div style="text-align:center;">
          <div style="width:36px;height:36px;border:3px solid #FDE8F6;border-top-color:var(--pink);border-radius:50%;animation:spin .8s linear infinite;margin:0 auto .75rem;"></div>
          <div style="font-size:.78rem;color:var(--muted)">Memuat preview...</div>
        </div>
      </div>
      <iframe id="previewIframe" class="preview-iframe" src="{{ route('invitation.preview', $invitation->id) }}" onload="document.getElementById('previewLoader').style.display='none'"></iframe>
    </div>
  </div>
</div>

</div>{{-- end editor-wrap --}}

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script>
var INVITATION_ID = {{ $invitation->id }};
var SLUG          = '{{ $invitation->slug }}';
var CSRF          = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// ── showPanel ──────────────────────────────────────────────
function showPanel(name) {
    document.querySelectorAll('.panel-section').forEach(function(el) { el.classList.remove('active-panel'); });
    document.querySelectorAll('.nav-btn').forEach(function(el) { el.classList.remove('active'); });
    var p = document.getElementById('panel-' + name);
    var b = document.getElementById('menu-' + name);
    if (p) p.classList.add('active-panel');
    if (b) b.classList.add('active');
    try { localStorage.setItem('ep_{{ $invitation->id }}', name); } catch(e) {}
}

// Restore last panel
(function() {
    try {
        var last = localStorage.getItem('ep_{{ $invitation->id }}');
        if (last && document.getElementById('panel-' + last)) { showPanel(last); return; }
    } catch(e) {}
    showPanel('dashboard');
})();

document.querySelectorAll('form[action*="logout"]').forEach(function(f) {
    f.addEventListener('submit', function() { try { localStorage.removeItem('ep_{{ $invitation->id }}'); } catch(e) {} });
});

// ── Preview ────────────────────────────────────────────────
function setPreviewMode(mode) {
    var frame = document.getElementById('previewFrame');
    if (frame) frame.className = 'preview-frame ' + mode;
    document.getElementById('btn-desktop').classList.toggle('on', mode === 'desktop');
    document.getElementById('btn-mobile').classList.toggle('on', mode === 'mobile');
}
function refreshPreview() {
    var f = document.getElementById('previewIframe');
    var loader = document.getElementById('previewLoader');
    if (loader) loader.style.display = 'flex';
    if (f) { var s = f.src; f.src = ''; setTimeout(function() { f.src = s; }, 50); }
}
function updatePreview() { refreshPreview(); }

// ── Auto-save ──────────────────────────────────────────────
var saveTimer;
function triggerAutoSave() {
    clearTimeout(saveTimer);
    var dot = document.getElementById('saveDot'), txt = document.getElementById('saveText');
    if (dot) dot.className = 'save-dot saving';
    if (txt) txt.textContent = 'Menyimpan...';
    saveTimer = setTimeout(saveAll, 1500);
}
document.querySelectorAll('[data-field]').forEach(function(el) { el.addEventListener('input', triggerAutoSave); });

// ── collectFormData ────────────────────────────────────────
function collectFormData() {
    var data = { _token: CSRF };

    // 1. Semua input/select/textarea biasa (bukan radio/checkbox/file)
    document.querySelectorAll('input:not([type=radio]):not([type=checkbox]):not([type=file]), select, textarea').forEach(function(el) {
        if (!el.name || el.name === '_token') return;
        if (el.id === 'invMessageTA') return; // handle below
        data[el.name] = el.value;
    });

    // 2. Checkboxes
    document.querySelectorAll('input[type=checkbox]').forEach(function(el) {
        if (!el.name) return;
        data[el.name] = el.checked ? 1 : 0;
    });

    // 3. Radio buttons — ambil yang checked per name (template_id, dll)
    var seenRadio = {};
    document.querySelectorAll('input[type=radio]:checked').forEach(function(el) {
        if (!el.name || seenRadio[el.name]) return;
        seenRadio[el.name] = 1;
        data[el.name] = el.value;
    });

    // 4. couple_order dari hidden input (satu-satunya sumber kebenaran)
    var coupleHidden = document.getElementById('coupleOrderInput');
    if (coupleHidden) data['couple_order'] = coupleHidden.value;

    // 5. selected_music_key dari hidden input
    var musicHidden = document.getElementById('selectedMusicKeyHidden');
    if (musicHidden) data['selected_music_key'] = musicHidden.value;

    // 6. invitation_message dari textarea by id (paling reliable)
    var msgTA = document.getElementById('invMessageTA');
    if (msgTA !== null) data['invitation_message'] = msgTA.value;

    return data;
}

// ── saveAll ────────────────────────────────────────────────
async function saveAll() {
    var dot = document.getElementById('saveDot'), txt = document.getElementById('saveText');
    try {
        var payload = collectFormData();
        var res = await fetch('/dashboard/invitations/' + INVITATION_ID + '/save', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
            body: JSON.stringify(payload)
        });
        var json = await res.json();
        if (res.ok && json.success) {
            if (dot) dot.className = 'save-dot';
            if (txt) txt.textContent = 'Tersimpan';
            return true;
        } else throw new Error(json.message || 'Gagal');
    } catch(e) {
        if (dot) { dot.style.background = '#EF4444'; }
        if (txt) txt.textContent = 'Gagal simpan';
        console.error('[saveAll]', e);
        throw e;
    }
}
function saveSection(s) {
    var btn = event && event.target;
    if (btn) { btn.disabled = true; btn.textContent = 'Menyimpan...'; }
    saveAll().then(function(ok) {
        if (btn) { btn.disabled = false; btn.textContent = 'Simpan'; }
        Swal.fire({ icon: 'success', title: 'Tersimpan!', timer: 900, showConfirmButton: false });
        setTimeout(refreshPreview, 300);
    }).catch(function() {
        if (btn) { btn.disabled = false; btn.textContent = 'Simpan'; }
        Swal.fire({ icon: 'error', title: 'Gagal menyimpan', text: 'Coba lagi atau refresh halaman.' });
    });
}

// ── Upload Photo ───────────────────────────────────────────
function uploadPhoto(input, fieldName) {
    var file = input.files[0];
    if (!file) return;
    var reader = new FileReader();
    reader.onload = function(e) {
        var img = document.getElementById('preview_' + fieldName);
        if (img) { img.src = e.target.result; img.style.display = 'block'; }
    };
    reader.readAsDataURL(file);
    var fd = new FormData();
    fd.append('file', file); fd.append('field', fieldName); fd.append('_token', CSRF);
    fetch('/dashboard/invitations/' + INVITATION_ID + '/upload', { method: 'POST', body: fd })
        .then(function(r) { return r.json(); })
        .then(function(d) { if (d.success) { setTimeout(refreshPreview, 500); } });
}
function uploadGallery(input) {
    var files = Array.from(input.files);
    if (!files.length) return;
    var uploaded = 0;
    files.forEach(function(file) {
        var reader = new FileReader();
        reader.onload = function(e) {};
        reader.readAsDataURL(file);
        var fd = new FormData();
        fd.append('photo', file); fd.append('_token', CSRF);
        fetch('/dashboard/invitations/' + INVITATION_ID + '/gallery', { method: 'POST', body: fd })
            .then(function(r) { return r.json(); })
            .then(function(d) {
                if (d.success) {
                    uploaded++;
                    // Add photo to grid inline
                    var grid = document.getElementById('galleryGrid');
                    var cnt  = document.getElementById('photoCount');
                    if (grid && d.photo) {
                        var item = document.createElement('div');
                        item.id = 'photo-' + d.photo.id;
                        item.className = 'gallery-photo-item';
                        item.style.cssText = 'position:relative;aspect-ratio:1;overflow:hidden;border-radius:6px';
                        item.innerHTML = '<img src="' + d.photo.url + '" style="width:100%;height:100%;object-fit:cover">'
                            + '<button onclick="deletePhoto(' + d.photo.id + ')" style="position:absolute;top:.25rem;right:.25rem;background:rgba(0,0,0,.5);color:white;border:none;border-radius:50%;width:22px;height:22px;font-size:.75rem;cursor:pointer;line-height:1">×</button>';
                        grid.appendChild(item);
                        var total = document.querySelectorAll('.gallery-photo-item').length;
                        if (cnt) cnt.textContent = 'Foto tersimpan (' + total + '):';
                    }
                    if (uploaded === files.length) {
                        setTimeout(refreshPreview, 500);
                        Swal.fire({ icon: 'success', title: uploaded + ' foto diupload!', timer: 1200, showConfirmButton: false });
                    }
                }
            });
    });
}
function uploadMusic(input) {
    var file = input.files[0];
    if (!file) return;
    var fn = document.getElementById('musicFileName');
    if (fn) { fn.textContent = file.name; fn.style.display = 'block'; }
    var fd = new FormData();
    fd.append('music', file); fd.append('_token', CSRF);
    fetch('/dashboard/invitations/' + INVITATION_ID + '/music', { method: 'POST', body: fd })
        .then(function(r) { return r.json(); })
        .then(function(d) { if (d.success) { saveAll(); Swal.fire({ icon: 'success', title: 'Musik diupload!', timer: 1000, showConfirmButton: false }); } });
}
function deletePhoto(id) {
    Swal.fire({ title: 'Hapus foto ini?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#EF4444', confirmButtonText: 'Hapus', cancelButtonText: 'Batal' })
    .then(function(r) {
        if (r.isConfirmed) {
            fetch('/dashboard/photos/' + id, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': CSRF } })
            .then(function() {
                // Remove photo from UI without page reload
                var photoEl = document.getElementById('photo-' + id);
                if (photoEl) {
                    photoEl.remove();
                    var count = document.querySelectorAll('.gallery-photo-item').length;
                    var cntEl = document.getElementById('photoCount');
                    if (cntEl) cntEl.textContent = 'Foto tersimpan (' + count + '):';
                }
                refreshPreview();
                Swal.fire({ icon: 'success', title: 'Foto dihapus!', timer: 800, showConfirmButton: false });
            });
        }
    });
}

// ── Misc helpers ───────────────────────────────────────────
function copyLink() {
    var l = document.getElementById('invLink');
    if (l) navigator.clipboard.writeText(l.value).then(function() { Swal.fire({ icon: 'success', title: 'Link disalin!', timer: 800, showConfirmButton: false }); });
}
function copyInvLink() {
    var l = document.getElementById('invLinkInput');
    if (l) navigator.clipboard.writeText(l.value).then(function() { Swal.fire({ icon: 'success', title: 'Link disalin!', timer: 800, showConfirmButton: false }); });
}
function confirmAction(msg, formId) {
    Swal.fire({ title: msg, icon: 'question', showCancelButton: true, confirmButtonText: 'Ya', cancelButtonText: 'Batal' })
    .then(function(r) { if (r.isConfirmed) document.getElementById(formId).submit(); });
}

// ── Slug check ─────────────────────────────────────────────
var slugTimer;
function checkSlug(val) {
    clearTimeout(slugTimer);
    var el = document.getElementById('slugStatus');
    if (!el) return;
    if (!val || val.length < 3) { el.innerHTML = ''; return; }
    el.innerHTML = '<span style="color:#9CA3AF">Memeriksa...</span>';
    slugTimer = setTimeout(function() {
        fetch('/dashboard/check-slug?slug=' + encodeURIComponent(val) + '&exclude_id=' + INVITATION_ID)
            .then(function(r) { return r.json(); })
            .then(function(d) {
                el.innerHTML = d.available
                    ? '<span style="color:#10B981">✓ Tersedia</span>'
                    : '<span style="color:#EF4444">✗ Tidak tersedia</span>';
            });
    }, 500);
}

// ── Resepsi same as Akad ───────────────────────────────────
function toggleResepsiSame(checked) {
    var fields = document.getElementById('resepsiFields');
    if (!fields) return;
    if (checked) {
        [['akad_date','resepsi_date'],['akad_time_start','resepsi_time_start'],['akad_time_end','resepsi_time_end'],['akad_venue','resepsi_venue'],['akad_address','resepsi_address'],['akad_maps_url','resepsi_maps_url']].forEach(function(pair) {
            var s = document.querySelector('[name="' + pair[0] + '"]'), d = document.querySelector('[name="' + pair[1] + '"]');
            if (s && d) d.value = s.value;
        });
    }
    fields.style.opacity = checked ? '0.5' : '1';
    fields.style.pointerEvents = checked ? 'none' : 'all';
    var h = document.getElementById('rsamehid');
    if (h) h.value = checked ? 1 : 0;
    triggerAutoSave();
}
(function() { var cb = document.getElementById('sameAsAkad'); if (cb && cb.checked) toggleResepsiSame(true); })();

// ── Love Story ─────────────────────────────────────────────
function addStoryItem() {
    var c = document.getElementById('storyItems');
    if (!c) return;
    var d = document.createElement('div');
    d.className = 'story-item';
    d.innerHTML = '<button onclick="removeStoryItem(this)" style="position:absolute;top:.5rem;right:.5rem;background:none;border:none;color:#9CA3AF;cursor:pointer;font-size:1.1rem;line-height:1">×</button>'
        + '<div class="form-group"><label class="form-label" style="font-size:.7rem">Judul</label><input type="text" class="fi story-title" placeholder="Pertama Bertemu" style="font-size:.8rem"></div>'
        + '<div class="form-group"><label class="form-label" style="font-size:.7rem">Tanggal</label><input type="text" class="fi story-date" placeholder="Juni 2020" style="font-size:.8rem"></div>'
        + '<div class="form-group"><label class="form-label" style="font-size:.7rem">Cerita</label><textarea class="fi story-content" rows="3" placeholder="Cerita singkat..." style="font-size:.8rem;resize:none"></textarea></div>';
    c.appendChild(d);
    // Hide empty message
    var emptyMsg = document.getElementById('storyEmptyMsg');
    if (emptyMsg) emptyMsg.style.display = 'none';
    // Scroll to new item
    d.scrollIntoView({ behavior: 'smooth', block: 'end' });
}
function removeStoryItem(btn) { btn.closest('.story-item').remove(); }
async function saveStoryItems() {
    var btn = document.getElementById('saveStoryBtn');
    if (btn) { btn.disabled = true; btn.textContent = 'Menyimpan...'; }
    var items = [];
    document.querySelectorAll('.story-item').forEach(function(item) {
        var t = item.querySelector('.story-title');
        var dt = item.querySelector('.story-date');
        var c  = item.querySelector('.story-content');
        items.push({
            title:   t  ? t.value  : '',
            date:    dt ? dt.value : '',
            content: c  ? c.value  : ''
        });
    });
    try {
        var r = await fetch('/dashboard/invitations/' + INVITATION_ID + '/save', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
            body: JSON.stringify({ love_story_items: items })
        });
        var d = await r.json();
        if (btn) { btn.disabled = false; btn.textContent = 'Simpan Love Story'; }
        if (d.success) {
            Swal.fire({ icon: 'success', title: 'Love story disimpan!', timer: 1200, showConfirmButton: false });
            setTimeout(refreshPreview, 400);
        } else throw new Error(d.message||'error');
    } catch(e) {
        if (btn) { btn.disabled = false; btn.textContent = 'Simpan Love Story'; }
        Swal.fire({ icon: 'error', title: 'Gagal menyimpan', text: e.message });
    }
}

// ── Message template ───────────────────────────────────────
function setTextRef(fieldName, text) {
    var ta = document.querySelector('[name="' + fieldName + '"]');
    if (ta) { ta.value = text.replace(/\\n/g, '\n'); triggerAutoSave(); Swal.fire({icon:'success',title:'Teks diterapkan!',timer:700,showConfirmButton:false}); }
}

function insertVar(varName) {
    var ta = document.getElementById('invMessageTA');
    if (!ta) return;
    var s = ta.selectionStart, e = ta.selectionEnd;
    var wrap = '{' + '{' + ' ' + varName + ' ' + '}' + '}';
    ta.value = ta.value.slice(0, s) + wrap + ta.value.slice(e);
    ta.focus(); ta.selectionStart = ta.selectionEnd = s + wrap.length;
    triggerAutoSave();
}
function useMessageRef(text) {
    var ta = document.getElementById('invMessageTA');
    if (ta) { ta.value = text.replace(/\\n/g, '\n'); triggerAutoSave(); Swal.fire({ icon: 'success', title: 'Template diterapkan!', timer: 700, showConfirmButton: false }); }
}

// ── Preset music ───────────────────────────────────────────
function selectPresetMusic(url, card) {
    // 1. Deselect all cards
    document.querySelectorAll('.preset-music-card').forEach(function(el) { el.classList.remove('sel'); });
    card.classList.add('sel');

    // 2. Update HIDDEN INPUT — ini yang dibaca collectFormData
    var hiddenInput = document.getElementById('selectedMusicKeyHidden');
    if (hiddenInput) {
        hiddenInput.value = url;
    } else {
        // Buat hidden input jika belum ada
        var inp = document.createElement('input');
        inp.type = 'hidden';
        inp.id = 'selectedMusicKeyHidden';
        inp.name = 'selected_music_key';
        inp.value = url;
        document.body.appendChild(inp);
    }

    // 3. Audio preview
    var preview = document.getElementById('musicPreviewAudio');
    if (preview) {
        preview.src = url;
        preview.style.display = 'block';
        preview.load();
    }

    // 4. Save langsung dengan explicit payload (tidak lewat collectFormData)
    fetch('/dashboard/invitations/' + INVITATION_ID + '/save', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify({ selected_music_key: url })
    })
    .then(function(r) { return r.json(); })
    .then(function(d) {
        if (d.success) {
            var dot = document.getElementById('saveDot'), txt = document.getElementById('saveText');
            if (dot) dot.className = 'save-dot';
            if (txt) txt.textContent = 'Tersimpan';
            Swal.fire({ icon: 'success', title: 'Musik dipilih & disimpan!', timer: 900, showConfirmButton: false });
        } else throw new Error();
    })
    .catch(function() {
        Swal.fire({ icon: 'error', title: 'Gagal menyimpan musik', text: 'Coba klik Simpan manual.' });
    });
}

// ── Guest share ────────────────────────────────────────────
function showGuestShare(guestName) {
    var link = window.location.origin + '/' + SLUG + '?untuk=' + encodeURIComponent(guestName);
    var groom = {!! json_encode($invitation->groom_nickname ?: $invitation->groom_name ?: 'Pengantin Pria') !!};
    var bride  = {!! json_encode($invitation->bride_nickname ?: $invitation->bride_name ?: 'Pengantin Wanita') !!};
    var ta = document.getElementById('invMessageTA');
    var raw = (ta && ta.value.trim()) ? ta.value : ('Assalamualaikum,\nKepada *' + guestName + '*\n\nLink: ' + link + '\n\n' + groom + ' & ' + bride);
    var msg = raw.replace(/\{nama_tamu\}/g, guestName).replace(/\{link_undangan\}/g, link).replace(/\{nama_pengantin_pria\}/g, groom).replace(/\{nama_pengantin_wanita\}/g, bride);
    var safeLink = link.replace(/"/g, '&quot;');
    var waHref = 'https://wa.me/?text=' + encodeURIComponent(msg);
    Swal.fire({
        title: 'Bagikan ke ' + guestName,
        html: '<div style="text-align:left">'
            + '<p style="font-size:.72rem;color:#6B7280;margin-bottom:.3rem">Link personal:</p>'
            + '<div style="display:flex;gap:.35rem;margin-bottom:.65rem">'
            + '<input id="gsl" type="text" readonly value="' + safeLink + '" style="flex:1;padding:.4rem .6rem;border:1px solid #E5E7EB;border-radius:6px;font-size:.72rem;outline:none;background:#F9FAFB">'
            + '<button id="gslBtn" style="padding:.4rem .75rem;background:#F472B6;color:white;border:none;border-radius:6px;font-size:.72rem;cursor:pointer">Salin</button>'
            + '</div>'
            + '<a href="' + waHref + '" target="_blank" style="display:flex;align-items:center;justify-content:center;gap:.4rem;background:#25D366;color:white;padding:.65rem;border-radius:8px;text-decoration:none;font-size:.82rem;font-weight:500">Kirim WhatsApp ✉</a>'
            + '</div>',
        showConfirmButton: false,
        showCloseButton: true,
        width: 380,
        didOpen: function() {
            var btn = document.getElementById('gslBtn');
            if (btn) btn.addEventListener('click', function() {
                var inp = document.getElementById('gsl');
                if (inp) navigator.clipboard.writeText(inp.value).then(function() { btn.textContent = '✓'; btn.style.background = '#10B981'; });
            });
        }
    });
}

// ── Add guest AJAX ─────────────────────────────────────────
async function submitAddGuest(e) {
    e.preventDefault();
    var form = document.getElementById('addGuestForm');
    var fd = new FormData(form);
    var res = await fetch('{{ route("guests.store") }}', { method: 'POST', body: fd });
    var d = await res.json();
    if (d.success) {
        var g = d.guest;
        var noEl = document.getElementById('noGuests');
        if (noEl) noEl.remove();
        var row = document.createElement('div');
        row.className = 'guest-row'; row.id = 'guestRow' + g.id;
        row.innerHTML = '<div class="guest-info"><div class="guest-name">' + g.name + '</div><div class="guest-meta">' + (g.phone||'-') + ' · ' + g.pax + ' pax <span class="guest-badge badge-pending">Pending</span></div></div>'
            + '<div style="display:flex;gap:.35rem;flex-shrink:0">'
            + '<button onclick="showGuestShare(\'' + g.name.replace(/'/g,"\\'") + '\')" class="btn-outline btn-sm">🔗</button>'
            + '<button onclick="deleteGuest(' + g.id + ',this)" class="btn-danger">×</button>'
            + '</div>';
        document.getElementById('guestList').prepend(row);
        form.reset(); form.querySelector('[name=invitation_id]').value = INVITATION_ID;
    }
}

// ── Delete guest ───────────────────────────────────────────
function deleteGuest(id, btn) {
    if (!confirm('Hapus tamu ini?')) return;
    fetch('/dashboard/guests/' + id, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': CSRF } })
        .then(function(r) { return r.json(); })
        .then(function(d) { if (d.success) { var row = document.getElementById('guestRow' + id); if (row) row.remove(); } });
}

// ── Add gift AJAX ──────────────────────────────────────────
async function submitAddGift(e) {
    e.preventDefault();
    var form = document.getElementById('addGiftForm');
    var fd = new FormData(form);
    var res = await fetch('{{ route("gifts.store") }}', { method: 'POST', body: fd });
    var d = await res.json();
    if (d.success) {
        var g = d.gift;
        var noEl = document.getElementById('noGifts');
        if (noEl) noEl.remove();
        var row = document.createElement('div');
        row.className = 'gift-row-item'; row.id = 'giftRow' + g.id;
        row.innerHTML = '<div class="gift-bank-label">' + g.bank_name.substring(0,4).toUpperCase() + '</div>'
            + '<div style="flex:1"><div style="font-weight:600;font-size:.82rem">' + g.bank_name + '</div><div style="font-size:.78rem;color:var(--muted)">' + g.account_number + '</div><div style="font-size:.72rem;color:#9CA3AF">a.n. ' + g.account_name + '</div></div>'
            + '<button onclick="deleteGift(' + g.id + ',this)" class="btn-danger">×</button>';
        document.getElementById('giftList').prepend(row);
        form.reset(); form.querySelector('[name=invitation_id]').value = INVITATION_ID;
    }
}

// ── Delete gift ────────────────────────────────────────────
function deleteGift(id, btn) {
    if (!confirm('Hapus rekening ini?')) return;
    fetch('/dashboard/gifts/' + id, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': CSRF } })
        .then(function(r) { return r.json(); })
        .then(function(d) { if (d.success) { var row = document.getElementById('giftRow' + id); if (row) row.remove(); } });
}

// ── Couple Order Toggle ───────────────────────────────────────
function setCoupleOrder(order) {
    // 1. Update hidden input
    var hiddenInput = document.getElementById('coupleOrderInput');
    if (hiddenInput) hiddenInput.value = order;

    // 2. Update button styles
    document.querySelectorAll('.cot-btn').forEach(function(b) {
        var isWanita = b.textContent.indexOf('Wanita') >= 0;
        var isPria   = b.textContent.indexOf('Pria') >= 0;
        b.classList.toggle('cot-active',
            (order === 'bride_first' && isWanita) || (order === 'groom_first' && isPria)
        );
    });

    // 3. Direct fetch — tidak lewat collectFormData agar tidak ada race condition
    fetch('/dashboard/invitations/' + INVITATION_ID + '/save', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify({ couple_order: order })
    })
    .then(function(r) { return r.json(); })
    .then(function(d) {
        if (d.success) {
            var dot = document.getElementById('saveDot'), txt = document.getElementById('saveText');
            if (dot) dot.className = 'save-dot';
            if (txt) txt.textContent = 'Tersimpan';
            Swal.fire({ icon: 'success', title: 'Urutan mempelai disimpan!', timer: 800, showConfirmButton: false });
            setTimeout(refreshPreview, 400);
        } else throw new Error('Gagal');
    })
    .catch(function(e) {
        Swal.fire({ icon: 'error', title: 'Gagal menyimpan', text: e.message || 'Coba lagi.' });
    });
}

// ── saveMessageSection — save teks WA secara eksplisit ───────
function saveMessageSection() {
    var ta = document.getElementById('invMessageTA');
    var msg = ta ? ta.value : '';
    fetch('/dashboard/invitations/' + INVITATION_ID + '/save', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify({ invitation_message: msg })
    })
    .then(function(r) { return r.json(); })
    .then(function(d) {
        if (d.success) {
            Swal.fire({ icon: 'success', title: 'Teks Undangan disimpan!', timer: 900, showConfirmButton: false });
            var dot = document.getElementById('saveDot'), txt = document.getElementById('saveText');
            if (dot) dot.className = 'save-dot';
            if (txt) txt.textContent = 'Tersimpan';
        } else throw new Error();
    })
    .catch(function() { Swal.fire({ icon: 'error', title: 'Gagal menyimpan', text: 'Coba lagi.' }); });
}

// ── saveTemplateChange ────────────────────────────────────
function saveTemplateChange(templateId) {
    var dot = document.getElementById('saveDot'), txt = document.getElementById('saveText');
    if (dot) dot.style.background = '#F59E0B';
    if (txt) txt.textContent = 'Mengganti template...';
    fetch('/dashboard/invitations/' + INVITATION_ID + '/save', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify({ template_id: templateId })
    })
    .then(function(r) { return r.json(); })
    .then(function(d) {
        if (d.success) {
            if (dot) dot.className = 'save-dot';
            if (txt) txt.textContent = 'Tersimpan';
            Swal.fire({ icon: 'success', title: 'Template diganti!', timer: 900, showConfirmButton: false });
            setTimeout(refreshPreview, 400);
        } else throw new Error('Gagal');
    })
    .catch(function() {
        Swal.fire({ icon: 'error', title: 'Gagal mengganti template' });
    });
}

// ── Flatpickr init ─────────────────────────────────────────
if (typeof flatpickr !== 'undefined') {
    flatpickr('.flatpickr', { dateFormat: 'Y-m-d', locale: { firstDayOfWeek: 1 }, onChange: function() { triggerAutoSave(); } });
}
</script>
</body>
</html>
