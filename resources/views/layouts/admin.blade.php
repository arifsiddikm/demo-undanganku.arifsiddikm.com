<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title','Admin') - UndanganKu Admin</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        :root { --pink:#F472B6; --sidebar-w:220px; --font-body:'DM Sans',sans-serif; }
        * { box-sizing:border-box; }
        body { font-family:var(--font-body); background:#F1F3F9; color:#1F2937; -webkit-font-smoothing:antialiased; }

        .admin-sidebar { position:fixed;top:0;left:0;bottom:0;width:var(--sidebar-w);background:#1F2937;display:flex;flex-direction:column;z-index:100; }
        .admin-logo { padding:1.25rem;font-size:1.2rem;font-weight:700;color:white;border-bottom:1px solid rgba(255,255,255,0.08); }
        .admin-logo span { color:var(--pink); }
        .admin-nav { flex:1;overflow-y:auto;padding:0.75rem 0.6rem; }
        .admin-nav-label { font-size:0.62rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:rgba(255,255,255,0.3);padding:0.6rem 0.6rem 0.25rem; }
        .admin-nav-item { display:flex;align-items:center;gap:0.6rem;padding:0.55rem 0.75rem;border-radius:8px;font-size:0.82rem;font-weight:500;color:rgba(255,255,255,0.6);text-decoration:none;transition:all 0.2s;margin-bottom:0.15rem;border:none;background:none;width:100%;cursor:pointer; }
        .admin-nav-item:hover { background:rgba(244,114,182,0.15);color:var(--pink); }
        .admin-nav-item.active { background:rgba(244,114,182,0.2);color:white; }

        .admin-topbar { position:fixed;top:0;left:var(--sidebar-w);right:0;height:56px;background:white;border-bottom:1px solid #E5E7EB;display:flex;align-items:center;justify-content:space-between;padding:0 1.5rem;z-index:99; }
        .admin-main { margin-left:var(--sidebar-w);padding-top:56px;min-height:100vh; }
        .admin-inner { padding:1.5rem; }

        .btn-primary { display:inline-flex;align-items:center;justify-content:center;gap:0.35rem;background:linear-gradient(135deg,#F472B6,#EC4899);color:white;font-weight:500;font-size:0.8rem;padding:0.5rem 1.1rem;border-radius:8px;border:none;cursor:pointer;transition:all 0.2s;text-decoration:none; }
        .btn-primary:hover { opacity:0.9;color:white; }
        .btn-danger { display:inline-flex;align-items:center;justify-content:center;gap:0.35rem;background:#FEE2E2;color:#DC2626;font-weight:500;font-size:0.8rem;padding:0.45rem 0.9rem;border-radius:8px;border:none;cursor:pointer;transition:all 0.2s;text-decoration:none; }
        .btn-danger:hover { background:#FECACA; }
        .btn-success { display:inline-flex;align-items:center;justify-content:center;gap:0.35rem;background:#D1FAE5;color:#065F46;font-weight:500;font-size:0.8rem;padding:0.45rem 0.9rem;border-radius:8px;border:none;cursor:pointer;transition:all 0.2s;text-decoration:none; }
        .btn-success:hover { background:#A7F3D0; }
        .btn-outline { display:inline-flex;align-items:center;justify-content:center;gap:0.35rem;background:transparent;color:#6B7280;font-weight:500;font-size:0.8rem;padding:0.45rem 0.9rem;border-radius:8px;border:1.5px solid #E5E7EB;cursor:pointer;transition:all 0.2s;text-decoration:none; }
        .btn-outline:hover { border-color:var(--pink);color:var(--pink); }
        .btn-sm { padding:0.3rem 0.75rem !important;font-size:0.75rem !important; }

        .form-label { display:block;font-size:0.78rem;font-weight:500;color:#1F2937;margin-bottom:0.3rem; }
        .form-input { display:block;width:100%;padding:0.55rem 0.8rem;font-size:0.82rem;font-family:var(--font-body);color:#1F2937;background:white;border:1.5px solid #E5E7EB;border-radius:8px;outline:none;transition:border-color 0.2s; }
        .form-input:focus { border-color:var(--pink);box-shadow:0 0 0 2px rgba(244,114,182,0.12); }
        .form-select { display:block;width:100%;padding:0.55rem 2rem 0.55rem 0.8rem;font-size:0.82rem;font-family:var(--font-body);color:#1F2937;background:white url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236B7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") no-repeat right 0.6rem center;background-size:12px;-webkit-appearance:none;border:1.5px solid #E5E7EB;border-radius:8px;outline:none;transition:border-color 0.2s; }
        .form-select:focus { border-color:var(--pink); }
        .form-textarea { display:block;width:100%;padding:0.55rem 0.8rem;font-size:0.82rem;font-family:var(--font-body);color:#1F2937;background:white;border:1.5px solid #E5E7EB;border-radius:8px;outline:none;resize:vertical;min-height:80px;transition:border-color 0.2s; }
        .form-textarea:focus { border-color:var(--pink); }
        .form-group { margin-bottom:1rem; }

        .card { background:white;border-radius:12px;border:1px solid #F3F4F6;box-shadow:0 1px 3px rgba(0,0,0,0.04); }
        .card-body { padding:1.25rem; }
        .stat-card { background:white;border-radius:12px;border:1px solid #F3F4F6;padding:1.25rem;display:flex;align-items:center;gap:1rem; }
        .stat-icon { width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:1.2rem;flex-shrink:0; }
        .stat-num { font-size:1.5rem;font-weight:700;line-height:1; }
        .stat-label { font-size:0.72rem;color:#6B7280;margin-top:0.15rem; }

        .table-auto { width:100%;border-collapse:collapse; }
        .table-auto th { font-size:0.7rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;color:#9CA3AF;padding:0.65rem 1rem;background:#FAFAFA;border-bottom:1px solid #E5E7EB;text-align:left;white-space:nowrap; }
        .table-auto td { padding:0.65rem 1rem;font-size:0.82rem;border-bottom:1px solid #F3F4F6;vertical-align:middle; }
        .table-auto tr:last-child td { border-bottom:none; }
        .table-auto tbody tr:hover td { background:#FFF9FF; }

        .badge { display:inline-flex;align-items:center;padding:0.18rem 0.55rem;border-radius:9999px;font-size:0.68rem;font-weight:600;letter-spacing:0.04em;text-transform:uppercase; }
        .badge-success { background:#F0FDF4;color:#16A34A; }
        .badge-warning { background:#FFFBEB;color:#D97706; }
        .badge-danger  { background:#FFF1F2;color:#E11D48; }
        .badge-gray    { background:#F3F4F6;color:#6B7280; }
        .badge-info    { background:#EFF6FF;color:#2563EB; }

        .alert { padding:0.75rem 1rem;border-radius:8px;font-size:0.85rem;margin-bottom:1rem; }
        .alert-success { background:#F0FDF4;color:#15803D;border:1px solid #BBF7D0; }
        .alert-danger  { background:#FFF1F2;color:#BE123C;border:1px solid #FECDD3; }

        .page-header { display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;flex-wrap:wrap;gap:1rem; }
        .page-title { font-size:1.2rem;font-weight:700; }

        ::-webkit-scrollbar { width:4px; }
        ::-webkit-scrollbar-thumb { background:#374151;border-radius:2px; }
    </style>
    @stack('styles')
</head>
<body>

<aside class="admin-sidebar">
    <div class="admin-logo">Undangan<span>Ku</span> <span style="font-size:0.65rem;background:rgba(244,114,182,0.2);color:var(--pink);padding:2px 6px;border-radius:4px;font-weight:600;">ADMIN</span></div>
    <nav class="admin-nav">
        <div class="admin-nav-label">Menu</div>
        <a href="{{ route('admin.dashboard') }}" class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            Dashboard
        </a>
        <a href="{{ route('admin.orders') }}" class="admin-nav-item {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
            Pesanan
            @php $pendingCount = \App\Models\Order::where('payment_status','pending')->count(); @endphp
            @if($pendingCount > 0) <span style="margin-left:auto;background:var(--pink);color:white;font-size:0.65rem;font-weight:700;padding:1px 6px;border-radius:9999px;">{{ $pendingCount }}</span> @endif
        </a>
        <a href="{{ route('admin.invitations') }}" class="admin-nav-item {{ request()->routeIs('admin.invitations*') ? 'active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/></svg>
            Data Undangan
        </a>
        <a href="{{ route('admin.users') }}" class="admin-nav-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
            Pengguna
        </a>
        <div class="admin-nav-label" style="margin-top:0.5rem;">Master Data</div>
        <a href="{{ route('admin.templates') }}" class="admin-nav-item {{ request()->routeIs('admin.templates*') ? 'active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><rect x="7" y="7" width="3" height="9"/><rect x="14" y="7" width="3" height="5"/></svg>
            Template
        </a>
        <a href="{{ route('admin.bank-accounts') }}" class="admin-nav-item {{ request()->routeIs('admin.bank-accounts*') ? 'active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
            No. Rekening
        </a>
        <a href="{{ route('admin.portfolios') }}" class="admin-nav-item {{ request()->routeIs('admin.portfolios*') ? 'active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            Portfolio
        </a>
        <a href="{{ route('admin.music') }}" class="admin-nav-item {{ request()->routeIs('admin.music*') ? 'active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/></svg>
            Musik Preset
        </a>
        <a href="{{ route('admin.testimonials') }}" class="admin-nav-item {{ request()->routeIs('admin.testimonials*') ? 'active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
            Testimoni
        </a>
        <a href="{{ route('admin.faqs') }}" class="admin-nav-item {{ request()->routeIs('admin.faqs*') ? 'active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 015.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            FAQ
        </a>

        <div style="padding:0.75rem 0.6rem;margin-top:0.5rem;">
            <form action="{{ route('logout') }}" method="POST" id="admin-logout-form">
                @csrf
                <button type="button" class="admin-nav-item logout-btn" style="width:100%;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <div style="padding:0.85rem;border-top:1px solid rgba(255,255,255,0.08);display:flex;align-items:center;gap:0.6rem;">
        <div style="width:30px;height:30px;border-radius:50%;background:linear-gradient(135deg,#F472B6,#93C5FD);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:0.75rem;flex-shrink:0;">A</div>
        <div style="overflow:hidden;">
            <div style="font-size:0.75rem;font-weight:600;color:white;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ auth()->user()->name }}</div>
            <div style="font-size:0.68rem;color:rgba(255,255,255,0.4);">Administrator</div>
        </div>
    </div>
</aside>

<header class="admin-topbar">
    <div style="font-weight:600;font-size:0.9rem;">@yield('page_title','Dashboard')</div>
    <div style="display:flex;align-items:center;gap:0.75rem;">
        <a href="{{ route('home') }}" target="_blank" class="btn-outline btn-sm">Lihat Website</a>
    </div>
</header>

<main class="admin-main">
    <div class="admin-inner">
        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if(session('error'))   <div class="alert alert-danger">{{ session('error') }}</div>   @endif

        @yield('content')
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script>
document.querySelectorAll('.logout-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        Swal.fire({ title:'Yakin logout?', icon:'question', showCancelButton:true, confirmButtonColor:'#F472B6', cancelButtonColor:'#9CA3AF', confirmButtonText:'Ya, Logout', cancelButtonText:'Batal' })
        .then(r => { if (r.isConfirmed) document.getElementById('admin-logout-form').submit(); });
    });
});

function confirmDelete(formId) {
    Swal.fire({ title:'Yakin hapus?', text:'Data yang dihapus tidak bisa dikembalikan!', icon:'warning', showCancelButton:true, confirmButtonColor:'#EF4444', cancelButtonColor:'#9CA3AF', confirmButtonText:'Hapus', cancelButtonText:'Batal' })
    .then(r => { if (r.isConfirmed) document.getElementById(formId).submit(); });
}

function confirmAction(msg, formId) {
    Swal.fire({ title:'Konfirmasi', text: msg, icon:'question', showCancelButton:true, confirmButtonColor:'#F472B6', confirmButtonText:'Ya, Lanjutkan', cancelButtonText:'Batal' })
    .then(r => { if (r.isConfirmed) document.getElementById(formId).submit(); });
}
</script>
@stack('scripts')
</body>
</html>
