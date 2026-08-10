@php
    $isHome = Request::routeIs('home');
    $isAuthPage = Request::routeIs('login', 'register', 'password.*');
    $dashboardUrl = '#';
    if (Auth::check()) {
        $dashboardUrl = match(Auth::user()->role) {
            'superadmin' => route('superadmin.dashboard'),
            'admin'      => route('admin.dashboard'),
            'asesor'     => route('asesor.dashboard'),
            'asesi'      => route('asesi.dashboard'),
            default      => route('home'),
        };
    }
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ \App\Models\LandingSetting::getValue('site_title', 'LPK MPI') }} | LPK Manajemen Pendidikan Indonesia – Lembaga Pendidikan Kerja</title>
    <!-- CSRF Token for JavaScript AJAX submissions -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Vite Assets (Tailwind & JS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Inline script to apply theme instantly before rendering to prevent flashing -->
    <script>
        const savedTheme = localStorage.getItem('lpk_theme');
        const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        if (savedTheme === 'dark' || (!savedTheme && systemDark)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    @auth
    @if(auth()->user()->role === 'superadmin')
    <style>
        body.initial-superadmin .tab-content:not(#sec-admin-panel) {
            display: none !important;
        }
        body.initial-superadmin #sec-admin-panel {
            display: block !important;
        }
    </style>
    @endif
    @endauth
</head>
<body class="bg-white dark:bg-slate-900 text-slate-950 dark:text-white font-sans min-h-screen relative overflow-x-hidden selection:bg-blue-600 selection:text-white transition-colors duration-300 @auth @if(auth()->user()->role === 'superadmin') initial-superadmin @endif @endauth">

    <!-- ======= VERTICAL ICON SIDEBAR (Landing Page) ======= -->
    <style>
        #pub-sidebar {
            display: none;
        }
        @media (min-width: 768px) {
            #pub-sidebar {
                position: fixed; top: 0; left: 0; height: 100%; width: 64px;
                transition: width 0.3s cubic-bezier(.4,0,.2,1);
                overflow: hidden; white-space: nowrap;
                background: #fff;
                border-right: 1px solid #e2e8f0;
                display: flex; flex-direction: column; z-index: 50;
            }
        }
        .dark #pub-sidebar { background: #0f172a; border-right-color: rgba(255,255,255,0.07); }
        #pub-sidebar:hover { width: 230px; }
    </style>

    @auth
    @if(auth()->user()->role === 'superadmin' && !request()->has('preview'))
    <style>
        #pub-sidebar { display: none !important; }
    </style>
    @endif
    @endauth

    <style>

        .pub-nav-item {
            display: flex; align-items: center; gap: 12px;
            padding: 9px 18px; cursor: pointer; border: none; background: none;
            width: 100%; color: #64748b; font-size: 10px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.08em;
            transition: background 0.15s, color 0.15s;
            text-align: left; text-decoration: none;
        }
        .dark .pub-nav-item { color: #94a3b8; }
        .pub-nav-item:hover, .pub-nav-item.active {
            background: rgba(59,130,246,0.08); color: #1d4ed8;
        }
        .dark .pub-nav-item:hover, .dark .pub-nav-item.active {
            background: rgba(59,130,246,0.12); color: #60a5fa;
        }
        .pub-nav-item.nav-btn-pendaftaran {
            background: linear-gradient(135deg, #155dfc, #084be3) !important;
            color: #ffffff !important;
            border-radius: 8px !important;
            margin: 6px 8px !important;
            padding: 10px 14px !important;
            width: calc(100% - 16px) !important;
            box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.2) !important;
            transition: all 0.2s ease-in-out !important;
        }
        .pub-nav-item.nav-btn-pendaftaran:hover {
            background: linear-gradient(135deg, #084be3, #0238b1) !important;
            transform: translateY(-1px) !important;
            box-shadow: 0 6px 12px -2px rgba(16, 185, 129, 0.3) !important;
        }
        .pub-nav-item.nav-btn-pendaftaran .pni svg {
            stroke: #ffffff !important;
        }
        .pub-nav-item .pni { flex-shrink: 0; width: 22px; height: 22px; display: flex; align-items: center; justify-content: center; }
        .pub-nav-item .pnl { opacity: 0; transition: opacity 0.2s ease 0.05s; overflow: hidden; }
        #pub-sidebar:hover .pnl { opacity: 1; }

        .pub-logo { display: flex; align-items: center; gap: 10px; padding: 16px 18px 12px; border-bottom: 1px solid #e2e8f0; }
        .dark .pub-logo { border-color: rgba(255,255,255,0.07); }
        .pub-logo .pli {
            flex-shrink: 0; width: 28px; height: 28px;
            background: linear-gradient(135deg, #2563eb, #1e3a8a);
            border-radius: 6px; display: flex; align-items: center;
            justify-content: center; font-size: 10px; font-weight: 900; color: #fff;
        }
        .pub-logo .plt { opacity: 0; transition: opacity 0.2s ease; }
        #pub-sidebar:hover .plt { opacity: 1; }

        .pub-divider { border-top: 1px solid #e2e8f0; margin: 4px 0; }
        .dark .pub-divider { border-color: rgba(255,255,255,0.06); }

        .pub-footer { padding: 8px 0; border-top: 1px solid #e2e8f0; }
        .dark .pub-footer { border-color: rgba(255,255,255,0.07); }

        /* push content right on desktop only */
        #pub-main-wrap { margin-left: 0; }
        @media (min-width: 768px) {
            #pub-main-wrap { margin-left: 64px; }
        }

        /* Footer full-bleed breakout: cancel the sidebar margin so footer spans full viewport */
        #pub-main-wrap > footer {
            position: relative;
            width: 100vw;
            margin-left: 0;
            box-sizing: border-box;
        }
        @media (min-width: 768px) {
            #pub-main-wrap > footer {
                width: calc(100vw - 64px);
            }
        }
    </style>

    @auth
    @if(auth()->user()->role === 'superadmin' && !request()->has('preview'))
    <style>
        #pub-main-wrap { margin-left: 0 !important; }
    </style>
    @endif
    @endauth

    @if($isAuthPage)
    <style>
        #pub-main-wrap { margin-left: 0 !important; }
    </style>
    @endif

    @if(!$isAuthPage)
    <aside id="pub-sidebar" @auth @if(auth()->user()->role === 'superadmin' && !request()->has('preview')) style="display:none" @endif @endauth>
        <!-- Logo -->
        <div class="pub-logo" id="nav-logo-btn" style="cursor: pointer;">
            @php $siteLogo = \App\Models\LandingSetting::getValue('site_logo'); @endphp
            @if($siteLogo)
                <img src="{{ asset('storage/'.$siteLogo) }}?v={{ file_exists(public_path('storage/'.$siteLogo)) ? filemtime(public_path('storage/'.$siteLogo)) : time() }}" class="w-7 h-7 object-contain" alt="LPK MPI">
            @else
                <div class="pli">MPI</div>
            @endif
            <div class="plt">
                <div style="font-size:10px;font-weight:900;color:#2563eb;letter-spacing:.08em;line-height:1.2;">LPK MPI</div>
                <div style="font-size:8px;color:#94a3b8;font-weight:600;line-height:1.2;">Manajemen Pendidikan Indonesia</div>
            </div>
        </div>

        <!-- Nav -->
        <nav style="flex:1;overflow-y:auto;overflow-x:hidden;padding:8px 0;">
            <a href="{{ $isHome ? '#' : route('home') . '#beranda' }}" onclick="{{ $isHome ? 'event.preventDefault();switchTab(\'beranda\');' : '' }}" class="pub-nav-item active" data-tab="beranda">
                <span class="pni"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg></span>
                <span class="pnl">Beranda</span>
            </a>

            <a href="{{ $isHome ? '#' : route('home') . '#tentang' }}" onclick="{{ $isHome ? 'event.preventDefault();switchTab(\'tentang\');' : '' }}" class="pub-nav-item" data-tab="tentang">
                <span class="pni"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg></span>
                <span class="pnl">Tentang Kami</span>
            </a>

            <a href="{{ $isHome ? '#' : route('home') . '#program' }}" onclick="{{ $isHome ? 'event.preventDefault();switchTab(\'program\');' : '' }}" class="pub-nav-item" data-tab="program">
                <span class="pni"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg></span>
                <span class="pnl">Program Pelatihan</span>
            </a>

            <a href="{{ $isHome ? '#' : route('home') . '#instruktur' }}" onclick="{{ $isHome ? 'event.preventDefault();switchTab(\'instruktur\');' : '' }}" class="pub-nav-item" data-tab="instruktur">
                <span class="pni"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 20v-1a6 6 0 0112 0v1"/></svg></span>
                <span class="pnl">Instruktur</span>
            </a>

            <a href="{{ $isHome ? '#' : route('home') . '#fasilitas' }}" onclick="{{ $isHome ? 'event.preventDefault();switchTab(\'fasilitas\');' : '' }}" class="pub-nav-item" data-tab="fasilitas">
                <span class="pni"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg></span>
                <span class="pnl">Fasilitas</span>
            </a>

            <a href="{{ $isHome ? '#' : route('home') . '#berita' }}" onclick="{{ $isHome ? 'event.preventDefault();switchTab(\'berita\');' : '' }}" class="pub-nav-item" data-tab="berita">
                <span class="pni"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg></span>
                <span class="pnl">Berita &amp; Artikel</span>
            </a>

            <a href="{{ $isHome ? '#' : route('home') . '#alumni' }}" onclick="{{ $isHome ? 'event.preventDefault();switchTab(\'alumni\');' : '' }}" class="pub-nav-item" data-tab="alumni">
                <span class="pni"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg></span>
                <span class="pnl">Alumni</span>
            </a>

            <a href="{{ route('pendaftaran') }}" target="_blank" class="pub-nav-item nav-btn-pendaftaran" data-tab="pendaftaran">
                <span class="pni"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></span>
                <span class="pnl">Pendaftaran</span>
            </a>

            <a href="{{ $isHome ? '#' : route('home') . '#kontak' }}" onclick="{{ $isHome ? 'event.preventDefault();switchTab(\'kontak\');' : '' }}" class="pub-nav-item" data-tab="kontak">
                <span class="pni"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg></span>
                <span class="pnl">Kontak</span>
            </a>

            <div class="pub-divider"></div>

            <a href="{{ $isHome ? '#' : route('home') . '#faq' }}" onclick="{{ $isHome ? 'event.preventDefault();navigateToSection(\'sec-faq\',\'faq\');' : '' }}" class="pub-nav-item" data-tab="faq">
                <span class="pni"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></span>
                <span class="pnl">FAQ</span>
            </a>
        </nav>

        <!-- Footer -->
        <div class="pub-footer">
            <!-- Theme Toggle -->
            <button onclick="document.querySelector('.theme-toggle-btn').click()" class="pub-nav-item">
                <span class="pni">
                    <svg class="w-4 h-4 hidden dark:block" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707.707M12 8a4 4 0 100 8 4 4 0 000-8z"/></svg>
                    <svg class="w-4 h-4 block dark:hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                </span>
                <span class="pnl">Ubah Tema</span>
            </button>

            @auth
                <a href="{{ $dashboardUrl }}" class="pub-nav-item" style="color:#3b82f6;">
                    <span class="pni"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg></span>
                    <span class="pnl">Dashboard</span>
                </a>
                <form action="{{ route('logout') }}" method="POST">@csrf
                    <button type="submit" class="pub-nav-item" style="color:#f87171;">
                        <span class="pni"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg></span>
                        <span class="pnl">Keluar</span>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="pub-nav-item" style="color:#3b82f6;">
                    <span class="pni"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg></span>
                    <span class="pnl">Masuk</span>
                </a>
            @endauth

            <!-- Hidden theme button (used by sidebar) -->
            <button class="theme-toggle-btn" style="display:none;"></button>
        </div>
    </aside>
    @endif

    <!-- Wrapper: push content right of sidebar -->
    <div id="pub-main-wrap">

    <!-- Mobile Top Header Bar (ratio kecil/layar HP/Tablet) -->
    @if(!$isAuthPage)
    <header class="md:hidden sticky top-0 left-0 w-full z-40 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md border-b border-slate-200 dark:border-slate-800/80 px-4 py-3 flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-3">
            <button onclick="toggleMobileMenu()" class="p-2 rounded-lg text-slate-700 dark:text-slate-200 focus:outline-none" aria-label="Toggle Navigation">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <div class="flex items-center gap-2">
                @php $siteLogo = \App\Models\LandingSetting::getValue('site_logo'); @endphp
                @if($siteLogo)
                    <img src="{{ asset('storage/'.$siteLogo) }}?v={{ file_exists(public_path('storage/'.$siteLogo)) ? filemtime(public_path('storage/'.$siteLogo)) : time() }}" class="w-7 h-7 object-contain" alt="LPK MPI">
                @else
                    <div class="w-7 h-7 bg-blue-600 text-white rounded flex items-center justify-center font-black text-xs">MPI</div>
                @endif
                <span class="font-extrabold text-sm text-slate-900 dark:text-white tracking-tight">LPK MPI</span>
            </div>
        </div>
        <button onclick="document.querySelector('.theme-toggle-btn').click()" class="p-2 rounded-lg text-slate-700 dark:text-slate-200">
            <svg class="w-4 h-4 hidden dark:block" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707.707M12 8a4 4 0 100 8 4 4 0 000-8z"/></svg>
            <svg class="w-4 h-4 block dark:hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
        </button>
    </header>
    @endif

    <!-- Drawer Mobile Overlay -->
    @if(!$isAuthPage)
    <div id="mobile-menu" class="hidden md:hidden fixed inset-0 z-50 bg-slate-950/60 backdrop-blur-sm" onclick="toggleMobileMenu()">
        <div class="w-64 bg-white dark:bg-slate-900 h-full shadow-2xl p-5 flex flex-col justify-between overflow-y-auto" onclick="event.stopPropagation()">
            <div>
                <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-200 dark:border-slate-800">
                    <div class="flex items-center gap-2">
                        @if($siteLogo)
                            <img src="{{ asset('storage/'.$siteLogo) }}?v={{ file_exists(public_path('storage/'.$siteLogo)) ? filemtime(public_path('storage/'.$siteLogo)) : time() }}" class="w-7 h-7 object-contain" alt="LPK MPI">
                        @else
                            <div class="w-7 h-7 bg-blue-600 text-white rounded flex items-center justify-center font-black text-xs">MPI</div>
                        @endif
                        <span class="font-extrabold text-sm text-slate-900 dark:text-white">LPK MPI</span>
                    </div>
                    <button onclick="toggleMobileMenu()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <nav class="space-y-1">
                    <a href="{{ $isHome ? '#' : route('home') . '#beranda' }}" onclick="{{ $isHome ? 'event.preventDefault(); switchTab(\'beranda\'); toggleMobileMenu();' : 'toggleMobileMenu();' }}" class="mobile-nav-link block px-3 py-2 rounded-lg text-xs font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800" data-tab="beranda">Beranda</a>
                    <a href="{{ $isHome ? '#' : route('home') . '#tentang' }}" onclick="{{ $isHome ? 'event.preventDefault(); switchTab(\'tentang\'); toggleMobileMenu();' : 'toggleMobileMenu();' }}" class="mobile-nav-link block px-3 py-2 rounded-lg text-xs font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800" data-tab="tentang">Tentang Kami</a>
                    <a href="{{ $isHome ? '#' : route('home') . '#program' }}" onclick="{{ $isHome ? 'event.preventDefault(); switchTab(\'program\'); toggleMobileMenu();' : 'toggleMobileMenu();' }}" class="mobile-nav-link block px-3 py-2 rounded-lg text-xs font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800" data-tab="program">Program Pelatihan</a>
                    <a href="{{ $isHome ? '#' : route('home') . '#instruktur' }}" onclick="{{ $isHome ? 'event.preventDefault(); switchTab(\'instruktur\'); toggleMobileMenu();' : 'toggleMobileMenu();' }}" class="mobile-nav-link block px-3 py-2 rounded-lg text-xs font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800" data-tab="instruktur">Instruktur</a>
                    <a href="{{ $isHome ? '#' : route('home') . '#fasilitas' }}" onclick="{{ $isHome ? 'event.preventDefault(); switchTab(\'fasilitas\'); toggleMobileMenu();' : 'toggleMobileMenu();' }}" class="mobile-nav-link block px-3 py-2 rounded-lg text-xs font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800" data-tab="fasilitas">Fasilitas</a>
                    <a href="{{ $isHome ? '#' : route('home') . '#berita' }}" onclick="{{ $isHome ? 'event.preventDefault(); switchTab(\'berita\'); toggleMobileMenu();' : 'toggleMobileMenu();' }}" class="mobile-nav-link block px-3 py-2 rounded-lg text-xs font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800" data-tab="berita">Berita &amp; Artikel</a>
                    <a href="{{ $isHome ? '#' : route('home') . '#alumni' }}" onclick="{{ $isHome ? 'event.preventDefault(); switchTab(\'alumni\'); toggleMobileMenu();' : 'toggleMobileMenu();' }}" class="mobile-nav-link block px-3 py-2 rounded-lg text-xs font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800" data-tab="alumni">Alumni</a>
                    <a href="{{ route('pendaftaran') }}" target="_blank" onclick="toggleMobileMenu();" class="block px-3 py-2.5 rounded-lg text-xs font-bold text-center text-white bg-gradient-to-r from-blue-500 to-indigo-600 hover:brightness-110 transition shadow-sm mt-3" data-tab="pendaftaran">Pendaftaran</a>
                    <a href="{{ $isHome ? '#' : route('home') . '#kontak' }}" onclick="{{ $isHome ? 'event.preventDefault(); switchTab(\'kontak\'); toggleMobileMenu();' : 'toggleMobileMenu();' }}" class="mobile-nav-link block px-3 py-2 rounded-lg text-xs font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800" data-tab="kontak">Kontak</a>
                </nav>
            </div>
            <div class="pt-4 border-t border-slate-200 dark:border-slate-800">
                @auth
                    <a href="{{ $dashboardUrl }}" class="block w-full py-2 px-3 mb-2 text-center text-xs font-bold text-white bg-blue-600 rounded-lg">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="block w-full py-2 px-3 mb-2 text-center text-xs font-bold text-white bg-blue-600 rounded-lg">Masuk</a>
                @endauth
            </div>
        </div>
    </div>
    @endif


    <main id="main-content-container" class="min-h-[70vh] {{ $isAuthPage ? 'w-full' : ($isHome ? 'w-full' : 'max-w-7xl mx-auto mt-8 mb-10 px-6') }} @auth @if(auth()->user()->role === 'superadmin' && !request()->has('preview')) !max-w-full !w-full !m-0 !p-0 !min-h-screen @endif @endauth">

        @yield('content')
    </main>

    <!-- Footer -->
    @if(!$isAuthPage && !$isHome)
    <footer class="w-full bg-white dark:bg-slate-900 border-t border-slate-100 dark:border-slate-800/60 py-16 mt-0 text-xs text-slate-600 dark:text-slate-400 transition-colors duration-300 @auth @if(auth()->user()->role === 'superadmin' && !request()->has('preview')) hidden @endif @endauth">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mb-10 text-left">

            <!-- Col 1: Branding & Address -->
            <div class="sm:col-span-2 lg:col-span-1 space-y-4">
                <div class="flex items-start gap-3">
                    @php $footerLogo = \App\Models\LandingSetting::getValue('site_logo'); @endphp
                    @if($footerLogo)
                        <img src="{{ asset('storage/'.$footerLogo) }}?v={{ file_exists(public_path('storage/'.$footerLogo)) ? filemtime(public_path('storage/'.$footerLogo)) : time() }}" class="w-9 h-9 object-contain shrink-0" alt="LPK MPI">
                    @else
                        <div class="w-9 h-9 bg-blue-600 rounded-lg flex items-center justify-center text-white text-xs font-black shrink-0">MPI</div>
                    @endif
                    <div>
                        <div class="font-extrabold text-sm text-slate-900 dark:text-white tracking-tight uppercase leading-tight">LPK MPI</div>
                        <div class="text-[10px] text-slate-500 dark:text-slate-400 font-medium">Manajemen Pendidikan Indonesia</div>
                    </div>
                </div>
                <p class="leading-relaxed text-slate-600 dark:text-slate-400">Lembaga Pelatihan Kerja yang berkomitmen mengembangkan SDM berkualitas melalui standar pelatihan unggulan.</p>
                <div class="space-y-1 font-mono text-[10px] text-slate-500 dark:text-slate-500">
                    <p>📍 Jl. Gedebage Selatan No.137, Bandung 40295</p>
                    <p>📞 +62 811-2009-989</p>
                    <p>✉️ lpkmpi@gmail.com</p>
                </div>
            </div>

            <!-- Col 2: Navigasi -->
            <div class="space-y-3">
                <h4 class="font-bold text-slate-900 dark:text-white uppercase tracking-wider text-[10px]">Tautan Navigasi</h4>
                <ul class="space-y-2 font-medium">
                    <li><a href="#beranda" onclick="switchTab('beranda')" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Beranda</a></li>
                    <li><a href="#" onclick="event.preventDefault(); navigateToSection('sec-tentang-profil', 'tentang')" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Profil Lembaga</a></li>
                    <li><a href="#" onclick="event.preventDefault(); navigateToSection('sec-program-manajemen', 'program')" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Program Pelatihan</a></li>
                    <li><a href="#" onclick="event.preventDefault(); switchTab('instruktur')" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Fasilitator & Instruktur</a></li>
                    <li><a href="#" onclick="event.preventDefault(); switchTab('kontak')" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Kontak Kami</a></li>
                </ul>
            </div>

            <!-- Col 3: Legalitas -->
            <div class="space-y-3">
                <h4 class="font-bold text-slate-900 dark:text-white uppercase tracking-wider text-[10px]">Legalitas Resmi</h4>
                <ul class="space-y-2 font-mono text-[10px] text-slate-500 dark:text-slate-500">
                    <li>SK Kemenkumham: AHU-0012345</li>
                    <li>NIB: 9120304958372</li>
                    <li>Izin LPK No. LPK-1294-ID</li>
                    <li>Izin Operasional: Terakreditasi A</li>
                </ul>
            </div>

            <!-- Col 4: Kebijakan -->
            <div class="space-y-3">
                <h4 class="font-bold text-slate-900 dark:text-white uppercase tracking-wider text-[10px]">Hukum & Kebijakan</h4>
                <ul class="space-y-2">
                    <li><a href="#" onclick="event.preventDefault(); navigateToSection('sec-faq', 'faq')" class="hover:text-blue-600 dark:hover:text-blue-400 transition">FAQ</a></li>
                    <li><span class="cursor-pointer hover:text-blue-600 dark:hover:text-blue-400 transition" onclick="alert('Kebijakan Privasi: Semua data registrasi, NIK, dan dokumen dienkripsi secara aman.')">Kebijakan Privasi</span></li>
                    <li><span class="cursor-pointer hover:text-blue-600 dark:hover:text-blue-400 transition" onclick="alert('Syarat & Ketentuan: Calon peserta wajib mematuhi seluruh ketentuan program pelatihan.')">Syarat Layanan</span></li>
                    <li><a href="{{ route('pendaftaran') }}" target="_blank" class="hover:text-blue-600 dark:hover:text-blue-400 transition">Pendaftaran Online</a></li>
                </ul>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="max-w-7xl mx-auto px-6 sm:px-8 border-t border-slate-100 dark:border-slate-800/60 pt-6 flex flex-col sm:flex-row justify-between items-center gap-3 text-center sm:text-left">
            <p class="text-slate-500 dark:text-slate-500 text-[10px]">&copy; 2026 LPK Manajemen Pendidikan Indonesia. All Rights Reserved.</p>
            <p class="font-semibold text-[10px] text-slate-400 dark:text-slate-500 uppercase tracking-widest">Verifikasi Resmi Lembaga Pendidikan Kerja (LPK)</p>
        </div>
    </footer>
    @endif

    <!-- App Scripts -->
    <script>
        // SPA state
        const STATE = {
            currentTab: '{{ (auth()->check() && auth()->user()->role === "superadmin") ? "admin-panel" : "beranda" }}',
            apiHits: 0
        };

        document.addEventListener('DOMContentLoaded', () => {
            initApp();
        });

        async function initApp() {
            setupTheme();
            setupNavigation();
            setupScrollHighlight();
            
            // Only fetch stats if authenticated (admin elements are present in the DOM)
            if (document.getElementById('admin-stat-total')) {
                await refreshStats();
            }

            // Explore program CTA
            const exploreBtn = document.getElementById('explore-programs-btn');
            if (exploreBtn) {
                exploreBtn.addEventListener('click', () => switchTab('program'));
            }
            // Logo CTA
            const navLogoBtn = document.getElementById('nav-logo-btn');
            if (navLogoBtn) {
                navLogoBtn.addEventListener('click', (e) => {
                    const targetEl = document.getElementById('sec-beranda');
                    if (targetEl) {
                        e.preventDefault();
                        switchTab('beranda');
                    } else {
                        window.location.href = "{{ route('home') }}";
                    }
                });
            }
        }

        // Fetch metrics from backend dynamically
        async function refreshStats() {
            try {
                const response = await fetch('/admin/dashboard', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await response.json();
                if (data.success) {
                    document.getElementById('admin-stat-total').textContent = data.stats.total;
                    document.getElementById('admin-stat-cert').textContent = data.stats.cert;
                    document.getElementById('admin-stat-api').textContent = data.stats.api;
                    STATE.apiHits = data.stats.api;
                }
            } catch (err) {
                console.error('Error refreshing stats:', err);
            }
        }

        // Toggle Light & Dark Mode
        function setupTheme() {
            const toggleBtns = document.querySelectorAll('.theme-toggle-btn');
            toggleBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    if (document.documentElement.classList.contains('dark')) {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('lpk_theme', 'light');
                    } else {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('lpk_theme', 'dark');
                    }
                });
            });
        }

        // Mobile menu helpers
        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            if (mobileMenu) {
                mobileMenu.classList.toggle('hidden');
            }
        }

        function toggleMobileSubmenu(submenuId) {
            const submenu = document.getElementById(submenuId);
            if (submenu) {
                submenu.classList.toggle('hidden');
            }
        }

        // SPA Navigation tabs
        function setupNavigation() {
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    const targetTab = link.getAttribute('data-tab');
                    const targetEl = document.getElementById('sec-' + targetTab);
                    if (targetEl) {
                        e.preventDefault();
                        switchTab(targetTab);
                    }
                });
            });

            // Mobile menu toggle
            const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
            const mobileMenu = document.getElementById('mobile-menu');
            if (mobileMenuToggle && mobileMenu) {
                mobileMenuToggle.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                });
            }

            const mobileLinks = document.querySelectorAll('.mobile-nav-link');
            mobileLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    const targetTab = link.getAttribute('data-tab');
                    const targetEl = document.getElementById('sec-' + targetTab);
                    if (targetEl) {
                        e.preventDefault();
                        if (mobileMenu) mobileMenu.classList.add('hidden');
                        switchTab(targetTab);
                    } else {
                        if (mobileMenu) mobileMenu.classList.add('hidden');
                    }
                });
            });

             // Handle back/forward buttons or hash routing
            if (window.location.hash) {
                const hashTab = window.location.hash.substring(1);
                const validTabs = ['beranda', 'tentang', 'program', 'instruktur', 'fasilitas', 'berita', 'alumni', 'pendaftaran', 'kontak', 'scan-qr', 'faq', 'admin-panel'];
                if (validTabs.includes(hashTab)) {
                    switchTab(hashTab);
                }
            }
        }

        let isManualScrolling = false;
        let manualScrollTimer = null;

        function navigateToSection(sectionId, parentTabId) {
            // First ensure we switch to the parent public tab (which shows all public sections and hides the admin panel)
            switchTab(parentTabId);
            
            // Smooth scroll to the specific sub-section
            setTimeout(() => {
                const targetEl = document.getElementById(sectionId);
                if (targetEl) {
                    const mobileHeader = document.querySelector('header');
                    const headerHeight = (mobileHeader && mobileHeader.offsetHeight > 0) ? mobileHeader.offsetHeight : 20;
                    const targetPosition = targetEl.getBoundingClientRect().top + window.pageYOffset - headerHeight - 35;
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            }, 150);
        }

        function setActiveNavbarLink(tabId) {
            // Update desktop vertical sidebar navigation
            document.querySelectorAll('.pub-nav-item').forEach(link => {
                if (link.getAttribute('data-tab') === tabId) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });

            // Update mobile menu navigation
            document.querySelectorAll('.mobile-nav-link').forEach(link => {
                if (link.getAttribute('data-tab') === tabId) {
                    link.classList.add('bg-blue-50', 'dark:bg-blue-900/20', 'text-blue-700', 'dark:text-blue-400');
                    link.classList.remove('text-slate-700', 'dark:text-slate-300');
                } else {
                    link.classList.remove('bg-blue-50', 'dark:bg-blue-900/20', 'text-blue-700', 'dark:text-blue-400');
                    link.classList.add('text-slate-700', 'dark:text-slate-300');
                }
            });
        }

        function setupScrollHighlight() {
            window.addEventListener('scroll', () => {
                if (isManualScrolling || STATE.currentTab === 'admin-panel') return;
                
                const sections = ['beranda', 'tentang', 'program', 'instruktur', 'fasilitas', 'berita', 'alumni', 'pendaftaran', 'kontak', 'scan-qr', 'faq'];
                const scrollPosition = window.scrollY + 180; // offset for sticky navbar

                for (const secId of sections) {
                    const el = document.getElementById(`sec-${secId}`);
                    if (el) {
                        const top = el.offsetTop;
                        const height = el.offsetHeight;
                        if (scrollPosition >= top && scrollPosition < top + height) {
                            setActiveNavbarLink(secId);
                            STATE.currentTab = secId;
                            break;
                        }
                    }
                }
            });
        }

        function switchTab(tabId) {
            // Remove initial superadmin body class if present to allow public page rendering
            document.body.classList.remove('initial-superadmin');

            const header = document.querySelector('header');
            const footer = document.querySelector('footer');
            const mainContainer = document.getElementById('main-content-container');

            // Check if it's the admin panel
            if (tabId === 'admin-panel') {
                const adminSec = document.getElementById('sec-admin-panel');
                if (!adminSec) {
                    window.location.href = "{{ route('login') }}";
                    return;
                }
                
                // Hide all public sections
                const publicTabs = ['beranda', 'tentang', 'program', 'instruktur', 'fasilitas', 'berita', 'alumni', 'pendaftaran', 'kontak', 'scan-qr', 'faq'];
                publicTabs.forEach(pTab => {
                    const sec = document.getElementById(`sec-${pTab}`);
                    if (sec) {
                        sec.classList.remove('block');
                        sec.classList.add('hidden');
                    }
                });
                
                // Show admin panel
                adminSec.classList.remove('hidden');
                adminSec.classList.add('block');

                // Hide header and footer, expand container (for superadmin/sidebar view)
                const isSuperAdmin = '{{ (auth()->check() && auth()->user()->role === "superadmin") ? "true" : "false" }}' === 'true';
                if (isSuperAdmin) {
                    if (header) header.classList.add('hidden');
                    if (footer) footer.classList.add('hidden');
                    if (mainContainer) {
                        mainContainer.classList.add('!max-w-full', '!w-full', '!m-0', '!p-0', '!min-h-screen');
                    }
                }
            } else {
                // If it's a public tab, make sure all public sections are visible
                const publicTabs = ['beranda', 'tentang', 'program', 'instruktur', 'fasilitas', 'berita', 'alumni', 'pendaftaran', 'kontak', 'scan-qr', 'faq'];
                publicTabs.forEach(pTab => {
                    const sec = document.getElementById(`sec-${pTab}`);
                    if (sec) {
                        sec.classList.remove('hidden');
                        sec.classList.add('block');
                    }
                });
                
                // Hide admin panel if present
                const adminSec = document.getElementById('sec-admin-panel');
                if (adminSec) {
                    adminSec.classList.remove('block');
                    adminSec.classList.add('hidden');
                }

                // Show header and footer, normalize container
                if (header) header.classList.remove('hidden');
                if (footer) footer.classList.remove('hidden');
                if (mainContainer) {
                    mainContainer.classList.remove('!max-w-full', '!w-full', '!m-0', '!p-0', '!min-h-screen');
                }
                
                isManualScrolling = true;
                clearTimeout(manualScrollTimer);

                // Scroll to the targeted section with a layout reflow delay
                setTimeout(() => {
                    const targetSec = document.getElementById(`sec-${tabId}`);
                    if (targetSec) {
                        const mobileHeader = document.querySelector('header');
                        const headerHeight = (mobileHeader && mobileHeader.offsetHeight > 0) ? mobileHeader.offsetHeight : 20;
                        const targetPosition = targetSec.getBoundingClientRect().top + window.pageYOffset - headerHeight - 15;
                        window.scrollTo({
                            top: targetPosition,
                            behavior: 'smooth'
                        });
                    }
                    
                    // Release manual scrolling after smooth scroll finishes
                    manualScrollTimer = setTimeout(() => {
                        isManualScrolling = false;
                    }, 1000);
                }, 50);
            }

            STATE.currentTab = tabId;
            window.location.hash = tabId;
            
            // Update active nav styling
            setActiveNavbarLink(tabId);
        }

        // Called from Program Cards
        function selectProgramAndRegister(programId) {
            window.location.href = "{{ route('login') }}?program=" + programId;
        }
    </script>
</body>
</html>

