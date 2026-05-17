<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - UndanganKu</title>
    <meta name="description" content="Dashboard UndanganKu - Kelola undangan digital pernikahanmu">

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        :root {
            --color-pink:       #F472B6;
            --color-pink-light: #FDF2F8;
            --color-blue:       #93C5FD;
            --color-text:       #1F2937;
            --color-muted:      #6B7280;
            --sidebar-w:        240px;
            --font-display:     'Cormorant Garamond', serif;
            --font-body:        'DM Sans', sans-serif;
        }
        * { box-sizing: border-box; }
        body { font-family: var(--font-body); background: #F8F9FB; color: var(--color-text); -webkit-font-smoothing: antialiased; }

        /* ========= SIDEBAR ========= */
        .sidebar {
            position: fixed; top: 0; left: 0; bottom: 0;
            width: var(--sidebar-w);
            background: white;
            border-right: 1px solid #F3F4F6;
            display: flex; flex-direction: column;
            z-index: 100;
            transition: transform 0.3s;
        }
        .sidebar-logo {
            padding: 1.25rem 1.25rem 0.75rem;
            font-family: var(--font-display);
            font-size: 1.4rem; font-weight: 600;
            border-bottom: 1px solid #F3F4F6;
            margin-bottom: 0.5rem;
        }
        .sidebar-logo span { color: var(--color-pink); }

        .sidebar-section-label {
            font-size: 0.65rem; font-weight: 700; letter-spacing: 0.1em;
            text-transform: uppercase; color: #9CA3AF;
            padding: 0.75rem 1.25rem 0.25rem;
        }

        .sidebar-nav { flex: 1; overflow-y: auto; padding: 0 0.75rem 1rem; }
        .sidebar-nav::-webkit-scrollbar { width: 3px; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: #FBCFE8; border-radius: 2px; }

        .nav-item {
            display: flex; align-items: center; gap: 0.65rem;
            padding: 0.6rem 0.85rem; border-radius: 10px;
            font-size: 0.85rem; font-weight: 500;
            color: var(--color-muted);
            text-decoration: none;
            transition: all 0.2s;
            margin-bottom: 0.15rem;
            cursor: pointer; border: none; background: transparent; width: 100%;
        }
        .nav-item:hover { background: #FDF2F8; color: var(--color-pink); }
        .nav-item.active { background: linear-gradient(135deg, #FDF2F8, #F0F9FF); color: var(--color-pink); font-weight: 600; }
        .nav-item svg { flex-shrink: 0; opacity: 0.7; }
        .nav-item.active svg { opacity: 1; }

        /* ========= TOP BAR ========= */
        .topbar {
            position: fixed; top: 0; right: 0;
            left: var(--sidebar-w);
            height: 60px; background: white;
            border-bottom: 1px solid #F3F4F6;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 1.5rem; z-index: 99;
        }
        .topbar-title {
            font-weight: 600; font-size: 0.95rem;
        }

        /* ========= MAIN ========= */
        .main-content {
            margin-left: var(--sidebar-w);
            padding-top: 60px;
            min-height: 100vh;
        }
        .main-inner { padding: 1.75rem; }

        /* ========= BUTTONS ========= */
        .btn-primary {
            display: inline-flex; align-items: center; justify-content: center; gap: 0.4rem;
            background: linear-gradient(135deg, #F472B6, #EC4899);
            color: white; font-weight: 500; font-size: 0.825rem;
            padding: 0.55rem 1.25rem; border-radius: 8px;
            border: none; cursor: pointer;
            transition: all 0.25s;
            box-shadow: 0 3px 10px rgba(244,114,182,0.3);
            text-decoration: none;
        }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 16px rgba(244,114,182,0.4); color: white; }

        .btn-outline {
            display: inline-flex; align-items: center; justify-content: center; gap: 0.4rem;
            background: transparent; color: var(--color-pink); font-weight: 500; font-size: 0.825rem;
            padding: 0.55rem 1.25rem; border-radius: 8px;
            border: 1.5px solid var(--color-pink); cursor: pointer;
            transition: all 0.25s; text-decoration: none;
        }
        .btn-outline:hover { background: var(--color-pink); color: white; }

        .btn-danger {
            display: inline-flex; align-items: center; justify-content: center; gap: 0.4rem;
            background: #FEE2E2; color: #DC2626; font-weight: 500; font-size: 0.825rem;
            padding: 0.45rem 1rem; border-radius: 8px;
            border: none; cursor: pointer; transition: all 0.2s; text-decoration: none;
        }
        .btn-danger:hover { background: #FECACA; color: #B91C1C; }

        .btn-success {
            display: inline-flex; align-items: center; justify-content: center; gap: 0.4rem;
            background: #D1FAE5; color: #065F46; font-weight: 500; font-size: 0.825rem;
            padding: 0.45rem 1rem; border-radius: 8px;
            border: none; cursor: pointer; transition: all 0.2s; text-decoration: none;
        }
        .btn-success:hover { background: #A7F3D0; }

        .btn-sm { padding: 0.35rem 0.85rem !important; font-size: 0.775rem !important; }

        /* ========= FORM ========= */
        .form-label { display: block; font-size: 0.8rem; font-weight: 500; color: var(--color-text); margin-bottom: 0.35rem; }
        .form-input {
            display: block; width: 100%; padding: 0.6rem 0.9rem;
            font-size: 0.85rem; font-family: var(--font-body);
            color: var(--color-text); background: white;
            border: 1.5px solid #E5E7EB; border-radius: 8px;
            outline: none; transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-input:focus { border-color: var(--color-pink); box-shadow: 0 0 0 3px rgba(244,114,182,0.12); }
        .form-input::placeholder { color: #9CA3AF; }
        .form-select {
            display: block; width: 100%; padding: 0.6rem 2.25rem 0.6rem 0.9rem;
            font-size: 0.85rem; font-family: var(--font-body); color: var(--color-text);
            background: white url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236B7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") no-repeat right 0.7rem center;
            background-size: 14px; -webkit-appearance: none;
            border: 1.5px solid #E5E7EB; border-radius: 8px; outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-select:focus { border-color: var(--color-pink); box-shadow: 0 0 0 3px rgba(244,114,182,0.12); }
        .form-textarea {
            display: block; width: 100%; padding: 0.6rem 0.9rem;
            font-size: 0.85rem; font-family: var(--font-body); color: var(--color-text);
            background: white; border: 1.5px solid #E5E7EB; border-radius: 8px;
            outline: none; resize: vertical; min-height: 90px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-textarea:focus { border-color: var(--color-pink); box-shadow: 0 0 0 3px rgba(244,114,182,0.12); }
        .form-checkbox {
            width: 1rem; height: 1rem; border: 1.5px solid #D1D5DB;
            border-radius: 4px; appearance: none; -webkit-appearance: none;
            background: white; cursor: pointer; transition: all 0.2s;
            position: relative; flex-shrink: 0;
        }
        .form-checkbox:checked { background: var(--color-pink); border-color: var(--color-pink); }
        .form-checkbox:checked::after {
            content:''; position:absolute; top:1px; left:3px;
            width:5px; height:8px; border:2px solid white;
            border-top:none; border-left:none; transform:rotate(45deg);
        }
        .form-radio {
            width: 1rem; height: 1rem; border: 1.5px solid #D1D5DB;
            border-radius: 50%; appearance: none; -webkit-appearance: none;
            background: white; cursor: pointer; transition: all 0.2s;
            position: relative; flex-shrink: 0;
        }
        .form-radio:checked { border-color: var(--color-pink); }
        .form-radio:checked::after {
            content:''; position:absolute; top:50%; left:50%;
            transform:translate(-50%,-50%); width:0.45rem; height:0.45rem;
            border-radius:50%; background:var(--color-pink);
        }
        .form-group { margin-bottom: 1.1rem; }
        .form-error { font-size: 0.75rem; color: #EF4444; margin-top: 0.25rem; }

        /* ========= CARDS ========= */
        .dash-card {
            background: white; border-radius: 12px; padding: 1.25rem;
            border: 1px solid #F3F4F6;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }

        /* Stat card */
        .stat-card {
            background: white; border-radius: 12px; padding: 1.25rem;
            border: 1px solid #F3F4F6;
            display: flex; align-items: center; gap: 1rem;
        }
        .stat-icon {
            width: 44px; height: 44px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.25rem; flex-shrink: 0;
        }
        .stat-num { font-family: var(--font-display); font-size: 1.6rem; font-weight: 600; line-height: 1; }
        .stat-label { font-size: 0.75rem; color: var(--color-muted); margin-top: 0.15rem; }

        /* ========= BADGES ========= */
        .badge {
            display: inline-flex; align-items: center;
            padding: 0.18rem 0.55rem; border-radius: 9999px;
            font-size: 0.68rem; font-weight: 600; letter-spacing: 0.04em; text-transform: uppercase;
        }
        .badge-basic   { background: #EFF6FF; color: #3B82F6; }
        .badge-premium { background: #FDF4FF; color: #A855F7; }
        .badge-luxury  { background: #FFF9F0; color: #D97706; }
        .badge-success { background: #F0FDF4; color: #16A34A; }
        .badge-warning { background: #FFFBEB; color: #D97706; }
        .badge-danger  { background: #FFF1F2; color: #E11D48; }
        .badge-gray    { background: #F3F4F6; color: #6B7280; }
        .badge-info    { background: #EFF6FF; color: #2563EB; }

        /* ========= ALERTS ========= */
        .alert { padding: 0.75rem 1rem; border-radius: 8px; font-size: 0.85rem; margin-bottom: 1rem; }
        .alert-success { background: #F0FDF4; color: #15803D; border: 1px solid #BBF7D0; }
        .alert-danger  { background: #FFF1F2; color: #BE123C; border: 1px solid #FECDD3; }
        .alert-warning { background: #FFFBEB; color: #92400E; border: 1px solid #FDE68A; }
        .alert-info    { background: #EFF6FF; color: #1E40AF; border: 1px solid #BFDBFE; }

        /* ========= TABLE ========= */
        .table-auto { width: 100%; border-collapse: collapse; }
        .table-auto th { font-size: 0.72rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; color: #9CA3AF; padding: 0.65rem 1rem; background: #FAFAFA; border-bottom: 1px solid #E5E7EB; text-align: left; white-space: nowrap; }
        .table-auto td { padding: 0.65rem 1rem; font-size: 0.85rem; border-bottom: 1px solid #F3F4F6; vertical-align: middle; }
        .table-auto tr:last-child td { border-bottom: none; }
        .table-auto tbody tr:hover td { background: #FDF9FF; }

        /* ========= PAGE TITLE ========= */
        .page-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem; }
        .page-title { font-family: var(--font-display); font-size: 1.5rem; font-weight: 600; }

        /* ========= MOBILE ========= */
        .mobile-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.4); z-index: 99; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .topbar { left: 0; }
            .main-content { margin-left: 0; }
            .mobile-overlay.open { display: block; }
        }

        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-thumb { background: #FBCFE8; border-radius: 2px; }
    </style>

    @stack('styles')
</head>
<body>

{{-- Mobile overlay --}}
<div class="mobile-overlay" id="mobileOverlay" onclick="closeSidebar()"></div>

{{-- SIDEBAR --}}
<aside class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        <a href="{{ route('home') }}" style="text-decoration:none;color:inherit;">
            Undangan<span>Ku</span>
        </a>
    </div>

    <nav class="sidebar-nav">
        <div class="sidebar-section-label">Menu Utama</div>

        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            Dashboard
        </a>

        <a href="{{ route('invitations.index') }}" class="nav-item {{ request()->routeIs('invitations.*') ? 'active' : '' }}">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            Undangan Saya
        </a>

        <a href="{{ route('orders.index') }}" class="nav-item {{ request()->routeIs('orders.*') ? 'active' : '' }}">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
            Pesanan
        </a>

        <div class="sidebar-section-label" style="margin-top:0.5rem;">Akun</div>

        <a href="{{ route('profile') }}" class="nav-item {{ request()->routeIs('profile') ? 'active' : '' }}">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Profil
        </a>

        <form action="{{ route('logout') }}" method="POST" id="sidebar-logout-form">
            @csrf
            <button type="button" class="nav-item logout-btn" style="margin-top:auto;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Keluar
            </button>
        </form>
    </nav>

    {{-- User info --}}
    <div style="padding:1rem;border-top:1px solid #F3F4F6;display:flex;align-items:center;gap:0.75rem;">
        <div style="width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,#F472B6,#93C5FD);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:0.8rem;flex-shrink:0;">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
        <div style="overflow:hidden;min-width:0;">
            <div style="font-size:0.8rem;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ auth()->user()->name }}</div>
            <div style="font-size:0.7rem;color:var(--color-muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ auth()->user()->email }}</div>
        </div>
    </div>
</aside>

{{-- TOP BAR --}}
<header class="topbar">
    <div style="display:flex;align-items:center;gap:1rem;">
        <button onclick="toggleSidebar()" class="md:hidden" style="background:none;border:none;cursor:pointer;padding:4px;border-radius:6px;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>
        <div class="topbar-title">@yield('page_title', 'Dashboard')</div>
    </div>
    <div style="display:flex;align-items:center;gap:1rem;">
        <a href="{{ route('invitations.create') }}" class="btn-primary btn-sm hidden md:inline-flex">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Buat Undangan
        </a>
    </div>
</header>

{{-- MAIN --}}
<main class="main-content">
    <div class="main-inner">
        {{-- Flash --}}
        @if(session('success'))
        <div class="alert alert-success" style="display:flex;align-items:center;gap:0.5rem;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger" style="display:flex;align-items:center;gap:0.5rem;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ session('error') }}
        </div>
        @endif

        @yield('content')
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
        document.getElementById('mobileOverlay').classList.toggle('open');
    }
    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('mobileOverlay').classList.remove('open');
    }

    // Logout confirm
    document.querySelectorAll('.logout-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Yakin ingin keluar?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#F472B6',
                cancelButtonColor: '#9CA3AF',
                confirmButtonText: 'Ya, Keluar',
                cancelButtonText: 'Batal',
            }).then(r => {
                if (r.isConfirmed) document.getElementById('sidebar-logout-form').submit();
            });
        });
    });
</script>
@stack('scripts')
</body>
</html>
