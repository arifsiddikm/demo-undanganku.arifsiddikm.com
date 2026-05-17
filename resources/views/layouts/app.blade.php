<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'UndanganKu - Undangan Digital Pernikahan Online')</title>
    <meta name="description" content="@yield('meta_description', 'UndanganKu adalah platform undangan digital pernikahan online terpercaya. Buat undangan cantik, modern, dan mudah dibagikan. Mulai dari Rp 75.000.')">
    <meta name="keywords" content="@yield('meta_keywords', 'undangan digital, undangan pernikahan online, undangan nikah digital, wedding invitation online, undangan digital murah')">
    <meta name="author" content="UndanganKu">
    <meta property="og:title" content="@yield('title', 'UndanganKu - Undangan Digital Pernikahan Online')">
    <meta property="og:description" content="@yield('meta_description', 'Platform undangan digital pernikahan terpercaya di Indonesia.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">
    <meta name="twitter:card" content="summary_large_image">

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500;600&family=Dancing+Script:wght@600&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        :root {
            --color-pink:       #F472B6;
            --color-pink-light: #FDF2F8;
            --color-pink-mid:   #FBCFE8;
            --color-blue:       #93C5FD;
            --color-blue-light: #EFF6FF;
            --color-blue-mid:   #BFDBFE;
            --color-rose:       #E11D48;
            --color-text:       #1F2937;
            --color-muted:      #6B7280;
            --color-white:      #FFFFFF;
            --color-bg:         #FAFAFA;
            --font-display:     'Cormorant Garamond', serif;
            --font-script:      'Dancing Script', cursive;
            --font-body:        'DM Sans', sans-serif;
        }

        * { box-sizing: border-box; }

        body {
            font-family: var(--font-body);
            color: var(--color-text);
            background: var(--color-bg);
            -webkit-font-smoothing: antialiased;
        }

        /* =============================
           NAVBAR
        ============================= */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 999;
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(244,114,182,0.15);
            transition: box-shadow 0.3s;
        }
        .navbar.scrolled { box-shadow: 0 4px 24px rgba(244,114,182,0.10); }
        .nav-logo {
            font-family: var(--font-display);
            font-size: 1.6rem; font-weight: 600;
            color: var(--color-text);
            letter-spacing: -0.02em;
        }
        .nav-logo span { color: var(--color-pink); }
        .nav-link {
            font-size: 0.875rem; font-weight: 500;
            color: var(--color-muted);
            transition: color 0.2s;
            padding: 0.25rem 0;
            position: relative;
        }
        .nav-link::after {
            content: '';
            position: absolute; bottom: -2px; left: 0; right: 0; height: 2px;
            background: var(--color-pink);
            transform: scaleX(0); transition: transform 0.2s;
        }
        .nav-link:hover { color: var(--color-pink); }
        .nav-link:hover::after { transform: scaleX(1); }
        .nav-link.active { color: var(--color-pink); }
        .nav-link.active::after { transform: scaleX(1); }

        /* =============================
           BUTTONS
        ============================= */
        .btn-primary {
            display: inline-flex; align-items: center; justify-content: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, #F472B6, #EC4899);
            color: white; font-weight: 500; font-size: 0.875rem;
            padding: 0.6rem 1.5rem; border-radius: 9999px;
            border: none; cursor: pointer;
            transition: all 0.25s;
            box-shadow: 0 4px 14px rgba(244,114,182,0.35);
            text-decoration: none;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(244,114,182,0.45);
            color: white;
        }
        .btn-primary:active { transform: translateY(0); }

        .btn-outline {
            display: inline-flex; align-items: center; justify-content: center;
            gap: 0.5rem;
            background: transparent;
            color: var(--color-pink); font-weight: 500; font-size: 0.875rem;
            padding: 0.6rem 1.5rem; border-radius: 9999px;
            border: 1.5px solid var(--color-pink); cursor: pointer;
            transition: all 0.25s;
            text-decoration: none;
        }
        .btn-outline:hover {
            background: var(--color-pink);
            color: white;
        }

        .btn-secondary {
            display: inline-flex; align-items: center; justify-content: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, #93C5FD, #60A5FA);
            color: white; font-weight: 500; font-size: 0.875rem;
            padding: 0.6rem 1.5rem; border-radius: 9999px;
            border: none; cursor: pointer;
            transition: all 0.25s;
            text-decoration: none;
        }
        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(147,197,253,0.45);
            color: white;
        }

        .btn-danger {
            display: inline-flex; align-items: center; justify-content: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, #F87171, #EF4444);
            color: white; font-weight: 500; font-size: 0.875rem;
            padding: 0.5rem 1.25rem; border-radius: 8px;
            border: none; cursor: pointer;
            transition: all 0.25s;
            text-decoration: none;
        }
        .btn-danger:hover { opacity: 0.9; transform: translateY(-1px); color: white; }

        .btn-success {
            display: inline-flex; align-items: center; justify-content: center;
            gap: 0.5rem;
            background: linear-gradient(135deg, #6EE7B7, #10B981);
            color: white; font-weight: 500; font-size: 0.875rem;
            padding: 0.5rem 1.25rem; border-radius: 8px;
            border: none; cursor: pointer;
            transition: all 0.25s;
            text-decoration: none;
        }
        .btn-success:hover { opacity: 0.9; transform: translateY(-1px); color: white; }

        .btn-sm {
            padding: 0.35rem 0.85rem !important;
            font-size: 0.8rem !important;
        }

        /* =============================
           FORM INPUTS
        ============================= */
        .form-label {
            display: block;
            font-size: 0.8rem; font-weight: 500;
            color: var(--color-text);
            margin-bottom: 0.4rem;
        }

        .form-input {
            display: block; width: 100%;
            padding: 0.65rem 1rem;
            font-size: 0.875rem; font-family: var(--font-body);
            color: var(--color-text);
            background: white;
            border: 1.5px solid #E5E7EB;
            border-radius: 10px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-input:focus {
            border-color: var(--color-pink);
            box-shadow: 0 0 0 3px rgba(244,114,182,0.15);
        }
        .form-input::placeholder { color: #9CA3AF; }
        .form-input.error { border-color: #EF4444; }

        .form-select {
            display: block; width: 100%;
            padding: 0.65rem 2.5rem 0.65rem 1rem;
            font-size: 0.875rem; font-family: var(--font-body);
            color: var(--color-text);
            background: white url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236B7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") no-repeat right 0.75rem center;
            background-size: 16px;
            -webkit-appearance: none;
            border: 1.5px solid #E5E7EB;
            border-radius: 10px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-select:focus {
            border-color: var(--color-pink);
            box-shadow: 0 0 0 3px rgba(244,114,182,0.15);
        }

        .form-textarea {
            display: block; width: 100%;
            padding: 0.65rem 1rem;
            font-size: 0.875rem; font-family: var(--font-body);
            color: var(--color-text);
            background: white;
            border: 1.5px solid #E5E7EB;
            border-radius: 10px;
            outline: none;
            resize: vertical; min-height: 100px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-textarea:focus {
            border-color: var(--color-pink);
            box-shadow: 0 0 0 3px rgba(244,114,182,0.15);
        }

        /* Custom Checkbox */
        .form-checkbox {
            width: 1.1rem; height: 1.1rem;
            border: 1.5px solid #D1D5DB;
            border-radius: 4px;
            appearance: none; -webkit-appearance: none;
            background: white; cursor: pointer;
            transition: all 0.2s;
            position: relative;
            flex-shrink: 0;
        }
        .form-checkbox:checked {
            background: var(--color-pink);
            border-color: var(--color-pink);
        }
        .form-checkbox:checked::after {
            content: '';
            position: absolute; top: 1px; left: 4px;
            width: 5px; height: 9px;
            border: 2px solid white;
            border-top: none; border-left: none;
            transform: rotate(45deg);
        }
        .form-checkbox:focus { box-shadow: 0 0 0 3px rgba(244,114,182,0.15); }

        /* Custom Radio */
        .form-radio {
            width: 1.1rem; height: 1.1rem;
            border: 1.5px solid #D1D5DB;
            border-radius: 50%;
            appearance: none; -webkit-appearance: none;
            background: white; cursor: pointer;
            transition: all 0.2s;
            position: relative;
            flex-shrink: 0;
        }
        .form-radio:checked {
            border-color: var(--color-pink);
            background: white;
        }
        .form-radio:checked::after {
            content: '';
            position: absolute; top: 50%; left: 50%;
            transform: translate(-50%, -50%);
            width: 0.5rem; height: 0.5rem;
            border-radius: 50%;
            background: var(--color-pink);
        }
        .form-radio:focus { box-shadow: 0 0 0 3px rgba(244,114,182,0.15); }

        .form-group { margin-bottom: 1.25rem; }

        .form-error {
            font-size: 0.75rem; color: #EF4444;
            margin-top: 0.25rem;
        }

        /* =============================
           CARDS
        ============================= */
        .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 4px 16px rgba(244,114,182,0.06);
            overflow: hidden;
        }
        .card-body { padding: 1.5rem; }
        .card-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #F3F4F6;
        }

        /* =============================
           SECTION HEADERS
        ============================= */
        .section-tag {
            display: inline-block;
            background: var(--color-pink-light);
            color: var(--color-pink);
            font-size: 0.75rem; font-weight: 600;
            padding: 0.25rem 0.85rem; border-radius: 9999px;
            letter-spacing: 0.08em; text-transform: uppercase;
            margin-bottom: 0.75rem;
        }
        .section-title {
            font-family: var(--font-display);
            font-size: clamp(1.75rem, 4vw, 2.5rem);
            font-weight: 600; line-height: 1.2;
            color: var(--color-text);
        }
        .section-title span { color: var(--color-pink); }
        .section-sub {
            font-size: 0.95rem; color: var(--color-muted); line-height: 1.7;
            max-width: 560px;
        }

        /* =============================
           BADGES
        ============================= */
        .badge {
            display: inline-flex; align-items: center;
            padding: 0.2rem 0.6rem; border-radius: 9999px;
            font-size: 0.7rem; font-weight: 600;
            letter-spacing: 0.04em; text-transform: uppercase;
        }
        .badge-basic   { background: #EFF6FF; color: #3B82F6; }
        .badge-premium { background: #FDF4FF; color: #A855F7; }
        .badge-luxury  { background: #FFF9F0; color: #D97706; }
        .badge-success { background: #F0FDF4; color: #16A34A; }
        .badge-warning { background: #FFFBEB; color: #D97706; }
        .badge-danger  { background: #FFF1F2; color: #E11D48; }
        .badge-info    { background: #EFF6FF; color: #2563EB; }
        .badge-gray    { background: #F3F4F6; color: #6B7280; }

        /* =============================
           ALERT
        ============================= */
        .alert {
            padding: 0.85rem 1rem; border-radius: 10px;
            font-size: 0.875rem; margin-bottom: 1rem;
        }
        .alert-success { background: #F0FDF4; color: #15803D; border: 1px solid #BBF7D0; }
        .alert-danger  { background: #FFF1F2; color: #BE123C; border: 1px solid #FECDD3; }
        .alert-warning { background: #FFFBEB; color: #92400E; border: 1px solid #FDE68A; }
        .alert-info    { background: #EFF6FF; color: #1E40AF; border: 1px solid #BFDBFE; }

        /* =============================
           FLOATING WA BUTTON
        ============================= */
        .wa-float {
            position: fixed; bottom: 1.5rem; right: 1.5rem; z-index: 998;
            width: 52px; height: 52px;
            background: #25D366;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 16px rgba(37,211,102,0.4);
            transition: transform 0.25s, box-shadow 0.25s;
            text-decoration: none;
        }
        .wa-float:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 24px rgba(37,211,102,0.5);
        }
        .wa-float svg { width: 28px; height: 28px; fill: white; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #FBCFE8; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #F472B6; }

        /* Page transitions */
        .page-enter { animation: fadeSlideUp 0.4s ease forwards; }
        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Table */
        .table-auto { width: 100%; border-collapse: collapse; }
        .table-auto th {
            font-size: 0.75rem; font-weight: 600; text-transform: uppercase;
            letter-spacing: 0.06em; color: var(--color-muted);
            padding: 0.75rem 1rem; background: #FAFAFA;
            border-bottom: 1px solid #E5E7EB;
            text-align: left;
        }
        .table-auto td {
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            border-bottom: 1px solid #F3F4F6;
            vertical-align: middle;
        }
        .table-auto tr:hover td { background: #FDF2F8; }

        @media (max-width: 768px) {
            .section-title { font-size: 1.6rem; }
        }
    </style>

    @stack('styles')
</head>
<body>

    {{-- NAVBAR --}}
    <nav class="navbar" id="mainNavbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="nav-logo flex items-center gap-2">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                        <circle cx="16" cy="16" r="16" fill="#FDF2F8"/>
                        <path d="M16 8C13 8 10 10.5 10 13.5C10 18 16 24 16 24C16 24 22 18 22 13.5C22 10.5 19 8 16 8Z" fill="#F472B6"/>
                        <path d="M16 8C19 8 22 10.5 22 13.5C22 18 16 24 16 24" fill="#EC4899" opacity="0.6"/>
                    </svg>
                    Undangan<span>Ku</span>
                </a>

                {{-- Desktop Nav --}}
                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                    <a href="{{ route('templates.index') }}" class="nav-link {{ request()->routeIs('templates.*') ? 'active' : '' }}">Preset/Desain</a>
                    <a href="{{ route('portfolio') }}" class="nav-link {{ request()->routeIs('portfolio') ? 'active' : '' }}">Portfolio</a>
                    <a href="{{ route('home') }}#harga" class="nav-link">Harga</a>
                </div>

                {{-- Auth Buttons --}}
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-primary btn-sm">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="hidden md:inline-flex nav-link">Daftar</a>
                        <a href="{{ route('login') }}" class="btn-primary btn-sm">Masuk</a>
                    @endauth

                    {{-- Mobile burger --}}
                    <button id="mobileMenuBtn" class="md:hidden p-2 rounded-lg hover:bg-pink-50 transition-colors">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                    </button>
                </div>
            </div>

            {{-- Mobile Menu --}}
            <div id="mobileMenu" class="md:hidden hidden pb-4">
                <div class="flex flex-col gap-1 pt-2 border-t border-pink-100">
                    <a href="{{ route('home') }}" class="px-3 py-2 text-sm font-medium text-gray-600 hover:text-pink-500 hover:bg-pink-50 rounded-lg transition-colors">Beranda</a>
                    <a href="{{ route('templates.index') }}" class="px-3 py-2 text-sm font-medium text-gray-600 hover:text-pink-500 hover:bg-pink-50 rounded-lg transition-colors">Preset/Desain</a>
                    <a href="{{ route('portfolio') }}" class="px-3 py-2 text-sm font-medium text-gray-600 hover:text-pink-500 hover:bg-pink-50 rounded-lg transition-colors">Portfolio</a>
                    <a href="{{ route('home') }}#harga" class="px-3 py-2 text-sm font-medium text-gray-600 hover:text-pink-500 hover:bg-pink-50 rounded-lg transition-colors">Harga</a>
                    @guest
                    <a href="{{ route('register') }}" class="px-3 py-2 text-sm font-medium text-gray-600 hover:text-pink-500 hover:bg-pink-50 rounded-lg transition-colors">Daftar</a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div style="position:fixed;top:72px;right:1rem;z-index:9999;min-width:280px;" id="flash-success">
        <div class="alert alert-success flex items-center gap-2 shadow-lg">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    </div>
    <script>setTimeout(()=>{ const el = document.getElementById('flash-success'); if(el) el.style.display='none'; }, 4000);</script>
    @endif

    @if(session('error'))
    <div style="position:fixed;top:72px;right:1rem;z-index:9999;min-width:280px;" id="flash-error">
        <div class="alert alert-danger flex items-center gap-2 shadow-lg">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ session('error') }}
        </div>
    </div>
    <script>setTimeout(()=>{ const el = document.getElementById('flash-error'); if(el) el.style.display='none'; }, 5000);</script>
    @endif

    {{-- Main Content --}}
    <main class="page-enter">
        @yield('content')
    </main>

    {{-- Footer --}}
    @unless(request()->routeIs('editor.*'))
    <footer style="background: #1F2937; color: #9CA3AF; padding: 3rem 0 1.5rem;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="nav-logo text-white mb-3" style="font-family: var(--font-display);">
                        Undangan<span style="color: var(--color-pink);">Ku</span>
                    </div>
                    <p style="font-size: 0.875rem; line-height: 1.7; max-width: 340px;">
                        Platform undangan digital pernikahan yang membantu pasangan membuat undangan cantik, modern, dan mudah dibagikan ke seluruh keluarga dan tamu.
                    </p>
                    <div class="flex gap-3 mt-4">
                        <a href="https://wa.me/{{ env('ADMIN_WHATSAPP') }}" target="_blank"
                           style="width:36px;height:36px;background:#25D366;border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;text-decoration:none;transition:transform 0.2s;"
                           onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.555 4.116 1.527 5.848L0 24l6.335-1.509C8.035 23.44 9.985 24 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.87 0-3.628-.488-5.148-1.34l-.37-.217-3.762.896.956-3.67-.24-.382C2.488 15.632 2 13.875 2 12 2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
                        </a>
                        <a href="https://instagram.com" target="_blank"
                           style="width:36px;height:36px;background:linear-gradient(135deg,#f9a8d4,#c026d3);border-radius:50%;display:flex;align-items:center;justify-content:center;color:white;text-decoration:none;transition:transform 0.2s;"
                           onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><circle cx="12" cy="12" r="5"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg>
                        </a>
                    </div>
                </div>
                <div>
                    <h4 style="color:white;font-weight:600;margin-bottom:1rem;font-size:0.875rem;">Produk</h4>
                    <ul style="list-style:none;padding:0;display:flex;flex-direction:column;gap:0.5rem;">
                        <li><a href="{{ route('templates.index') }}" style="color:#9CA3AF;text-decoration:none;font-size:0.875rem;transition:color 0.2s;" onmouseover="this.style.color='#F472B6'" onmouseout="this.style.color='#9CA3AF'">Preset Undangan</a></li>
                        <li><a href="{{ route('portfolio') }}" style="color:#9CA3AF;text-decoration:none;font-size:0.875rem;transition:color 0.2s;" onmouseover="this.style.color='#F472B6'" onmouseout="this.style.color='#9CA3AF'">Portfolio</a></li>
                        <li><a href="{{ route('home') }}#harga" style="color:#9CA3AF;text-decoration:none;font-size:0.875rem;transition:color 0.2s;" onmouseover="this.style.color='#F472B6'" onmouseout="this.style.color='#9CA3AF'">Harga</a></li>
                        <li><a href="{{ route('home') }}#faq" style="color:#9CA3AF;text-decoration:none;font-size:0.875rem;transition:color 0.2s;" onmouseover="this.style.color='#F472B6'" onmouseout="this.style.color='#9CA3AF'">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h4 style="color:white;font-weight:600;margin-bottom:1rem;font-size:0.875rem;">Akun</h4>
                    <ul style="list-style:none;padding:0;display:flex;flex-direction:column;gap:0.5rem;">
                        <li><a href="{{ route('register') }}" style="color:#9CA3AF;text-decoration:none;font-size:0.875rem;transition:color 0.2s;" onmouseover="this.style.color='#F472B6'" onmouseout="this.style.color='#9CA3AF'">Daftar</a></li>
                        <li><a href="{{ route('login') }}" style="color:#9CA3AF;text-decoration:none;font-size:0.875rem;transition:color 0.2s;" onmouseover="this.style.color='#F472B6'" onmouseout="this.style.color='#9CA3AF'">Masuk</a></li>
                        @auth <li><a href="{{ route('dashboard') }}" style="color:#9CA3AF;text-decoration:none;font-size:0.875rem;" onmouseover="this.style.color='#F472B6'" onmouseout="this.style.color='#9CA3AF'">Dashboard</a></li> @endauth
                    </ul>
                </div>
            </div>
            <div style="border-top:1px solid #374151;padding-top:1.5rem;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem;">
                <p style="font-size:0.8rem;">© {{ date('Y') }} UndanganKu. Hak cipta dilindungi.</p>
                <p style="font-size:0.8rem;">Made with ❤️ for Indonesian couples</p>
            </div>
        </div>
    </footer>
    @endunless

    {{-- Floating WA Button --}}
    @unless(request()->routeIs('editor.*') || request()->routeIs('admin.*'))
    <a href="https://wa.me/{{ env('ADMIN_WHATSAPP') }}?text=Halo,%20saya%20ingin%20bertanya%20tentang%20UndanganKu" target="_blank" class="wa-float" title="Chat WhatsApp">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.555 4.116 1.527 5.848L0 24l6.335-1.509C8.035 23.44 9.985 24 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.87 0-3.628-.488-5.148-1.34l-.37-.217-3.762.896.956-3.67-.24-.382C2.488 15.632 2 13.875 2 12 2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
    </a>
    @endunless

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    <script>
        // Navbar scroll effect
        const navbar = document.getElementById('mainNavbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 20) navbar.classList.add('scrolled');
            else navbar.classList.remove('scrolled');
        });

        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }

        // CSRF setup for AJAX
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // SweetAlert logout confirm
        document.querySelectorAll('.logout-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form') || document.getElementById('logout-form');
                Swal.fire({
                    title: 'Yakin ingin keluar?',
                    text: 'Kamu akan keluar dari akun ini.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#F472B6',
                    cancelButtonColor: '#9CA3AF',
                    confirmButtonText: 'Ya, Keluar',
                    cancelButtonText: 'Batal',
                    borderRadius: '16px',
                }).then(result => {
                    if (result.isConfirmed && form) form.submit();
                });
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
