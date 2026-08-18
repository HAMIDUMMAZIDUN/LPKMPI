<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Asesor — LPK MPI</title>
    @php
        $siteLogo = \App\Models\LandingSetting::getValue('site_logo');
        $siteName = \App\Models\LandingSetting::getValue('site_name') ?? 'LPK MPI';
    @endphp
    @if($siteLogo)
        <link rel="icon" type="image/{{ pathinfo($siteLogo, PATHINFO_EXTENSION) === 'svg' ? 'svg+xml' : 'png' }}" href="{{ asset('storage/' . $siteLogo) }}?v={{ file_exists(public_path('storage/' . $siteLogo)) ? filemtime(public_path('storage/' . $siteLogo)) : time() }}">
    @else
        <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">
    @endif
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        blue: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#155dfc',
                            600: '#084be3',
                            700: '#0238b1',
                        }
                    }
                }
            }
        }
    </script>
    <script>
        (function() {
            const saved = localStorage.getItem('lpk_theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (saved === 'dark' || (!saved && prefersDark)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(226, 232, 240, 0.8);
        }
        .dark .glass {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(51, 65, 85, 0.5);
        }
        #sidebar {
            width: 260px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        #sidebar-nav::-webkit-scrollbar {
            display: none;
        }
        #sidebar-nav {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .content-wrapper {
            transition: padding-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        @media (min-width: 769px) {
            #sidebar {
                width: 70px;
                overflow-x: hidden;
            }
            #sidebar:hover {
                width: 260px;
                box-shadow: 4px 0 25px rgba(0, 0, 0, 0.1);
            }
            #sidebar:hover ~ .content-wrapper {
                padding-left: 260px !important;
            }
            /* Hide text elements when collapsed */
            #sidebar:not(:hover) .px-6 div > div:last-child,
            #sidebar:not(:hover) nav button:not(.accordion-trigger) > span,
            #sidebar:not(:hover) nav button.accordion-trigger span.flex > span:last-child,
            #sidebar:not(:hover) .accordion-arrow,
            #sidebar:not(:hover) .accordion-content,
            #sidebar:not(:hover) .p-4 button > span:last-child,
            #sidebar:not(:hover) .p-4 a > span:last-child {
                opacity: 0 !important;
                width: 0 !important;
                padding: 0 !important;
                margin: 0 !important;
                overflow: hidden;
                display: none !important;
                pointer-events: none;
            }
        }
        @media (max-width: 768px) {
            #sidebar {
                transform: translateX(-100%);
            }
            #sidebar.open {
                transform: translateX(0);
            }
        }

        /* Custom Global Text Color Sync Override */
        /* Light Mode: Force slate/gray/neutral/indigo text to black */
        .text-slate-950, .text-slate-900, .text-slate-800, .text-slate-700, .text-slate-650, .text-slate-600, .text-slate-500, .text-slate-400, .text-slate-350, .text-slate-300, .text-slate-200,
        .text-indigo-950, .text-indigo-900, .text-indigo-800, .text-indigo-700, .text-indigo-600, .text-indigo-500, .text-indigo-400, .text-indigo-300, .text-indigo-200,
        .text-gray-950, .text-gray-900, .text-gray-800, .text-gray-700, .text-gray-600, .text-gray-500, .text-gray-400, .text-gray-300, .text-gray-200,
        .text-neutral-950, .text-neutral-900, .text-neutral-800, .text-neutral-700, .text-neutral-600, .text-neutral-500, .text-neutral-400, .text-neutral-300, .text-neutral-200 {
            color: #000000 !important;
        }

        /* Dark Mode: Force slate/gray/neutral/indigo text to white */
        .dark .text-slate-950, .dark .text-slate-900, .dark .text-slate-800, .dark .text-slate-700, .dark .text-slate-650, .dark .text-slate-600, .dark .text-slate-500, .dark .text-slate-400, .dark .text-slate-350, .dark .text-slate-300, .dark .text-slate-200,
        .dark .text-indigo-950, .dark .text-indigo-900, .dark .text-indigo-800, .dark .text-indigo-700, .dark .text-indigo-600, .dark .text-indigo-500, .dark .text-indigo-400, .dark .text-indigo-300, .dark .text-indigo-200,
        .dark .text-gray-950, .dark .text-gray-900, .dark .text-gray-800, .dark .text-gray-700, .dark .text-gray-600, .dark .text-gray-500, .dark .text-gray-400, .dark .text-gray-300, .dark .text-gray-200,
        .dark .text-neutral-950, .dark .text-neutral-900, .dark .text-neutral-800, .dark .text-neutral-700, .dark .text-neutral-600, .dark .text-neutral-500, .dark .text-neutral-400, .dark .text-neutral-300, .dark .text-neutral-200 {
            color: #ffffff !important;
        }
    </style>
</head>
<body class="h-screen overflow-hidden bg-white dark:bg-slate-900 text-slate-800 dark:text-slate-100 transition-colors duration-300 flex">

    <!-- SIDEBAR -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 flex flex-col justify-between shrink-0 overflow-hidden h-screen">
        <div class="flex flex-col flex-1 min-h-0">
            <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800/80 flex items-center justify-between shrink-0">
                <div class="flex items-center gap-3">
                    @if($siteLogo)
                        <img src="{{ asset('storage/'.$siteLogo) }}?v={{ file_exists(public_path('storage/'.$siteLogo)) ? filemtime(public_path('storage/'.$siteLogo)) : time() }}" alt="Logo" class="w-9 h-9 rounded-xl object-contain shadow-md">
                    @else
                        <div class="w-9 h-9 rounded-xl bg-blue-600 flex items-center justify-center text-white font-extrabold shadow-md shadow-blue-600/10">
                            ⚖️
                        </div>
                    @endif
                    <div>
                        <div class="font-extrabold text-sm text-slate-900 dark:text-white tracking-tight">{{ $siteName }}</div>
                        <div class="text-[10px] text-blue-600 font-bold tracking-widest uppercase">Asesor Panel</div>
                    </div>
                </div>
                <button type="button" onclick="toggleSidebar()" class="md:hidden text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="p-4 space-y-1 overflow-y-auto flex-1" id="sidebar-nav">

                <button type="button" onclick="showPanel('dasbor')" id="btn-dasbor" class="sidebar-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all text-left">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"/></svg>
                    <span>Dasbor</span>
                </button>

                <!-- Accordion: Asesmen -->
                <div class="accordion-group">
                    <button type="button" class="accordion-trigger w-full flex items-center justify-between gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all text-left" onclick="toggleAccordion(this)">
                        <span class="flex items-center gap-3">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                            <span>Asesmen & Penilaian</span>
                        </span>
                        <svg class="accordion-arrow w-4 h-4 shrink-0 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="accordion-content hidden pl-4 mt-1 space-y-1 border-l-2 border-blue-100 dark:border-blue-900 ml-6">
                        <button type="button" onclick="showPanel('apl02')" id="btn-apl02" class="sidebar-btn w-full flex items-center gap-2 px-3 py-2.5 rounded-lg text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all text-left">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            Review Pra-Asesmen (APL-02)
                        </button>
                        <button type="button" onclick="showPanel('penilaian')" id="btn-penilaian" class="sidebar-btn w-full flex items-center gap-2 px-3 py-2.5 rounded-lg text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all text-left">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            Penilaian CBT & Praktik
                        </button>
                    </div>
                </div>

                <!-- Accordion: Kelola -->
                <div class="accordion-group">
                    <button type="button" class="accordion-trigger w-full flex items-center justify-between gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all text-left" onclick="toggleAccordion(this)">
                        <span class="flex items-center gap-3">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                            <span>Manajemen Ujian</span>
                        </span>
                        <svg class="accordion-arrow w-4 h-4 shrink-0 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="accordion-content hidden pl-4 mt-1 space-y-1 border-l-2 border-blue-100 dark:border-blue-900 ml-6">
                        <button type="button" onclick="showPanel('kelola')" id="btn-kelola" class="sidebar-btn w-full flex items-center gap-2 px-3 py-2.5 rounded-lg text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all text-left">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            Kelola Ujian
                        </button>
                        <button type="button" onclick="showPanel('jadwal')" id="btn-jadwal" class="sidebar-btn w-full flex items-center gap-2 px-3 py-2.5 rounded-lg text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all text-left">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            Jadwal & Silabus
                        </button>
                    </div>
                </div>

                <button type="button" onclick="showPanel('profil')" id="btn-profil" class="sidebar-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all text-left">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span>Profil Saya</span>
                </button>
            </nav>
        </div>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-slate-100 dark:border-slate-800 shrink-0">
            <button type="button" onclick="toggleTheme()" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 transition-all text-left">
                <span id="theme-icon">🌙</span>
                <span id="theme-label">Mode Gelap</span>
            </button>

            <a href="{{ route('home') }}" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 transition-all text-left">
                <span>🏠</span>
                <span>Beranda Utama</span>
            </a>

            <form action="{{ route('logout') }}" method="POST" class="mt-2">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/20 transition-all text-left">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- CONTENT WRAPPER -->
    <div class="content-wrapper flex-1 flex flex-col min-w-0 overflow-x-hidden overflow-y-auto md:pl-[70px]">

        <!-- TOPBAR -->
        <header class="h-16 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 px-6 flex items-center justify-between sticky top-0 z-30">
            <div class="flex items-center gap-3">
                <button type="button" onclick="toggleSidebar()" class="md:hidden text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <span class="text-xs font-black uppercase tracking-widest text-blue-600 block">MPI ASSESSMENT CENTER</span>
            </div>

            <!-- Profile & Notifications -->
            <div class="flex items-center gap-4">
                <div class="relative cursor-pointer text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    <span class="absolute top-0 right-0 w-2.5 h-2.5 bg-blue-500 rounded-full ring-2 ring-white dark:ring-slate-950"></span>
                </div>

                <div class="flex items-center gap-3 pl-3 border-l border-slate-200 dark:border-slate-800">
                    <div class="text-right hidden sm:block">
                        <div class="text-xs font-bold text-slate-800 dark:text-slate-200">{{ auth()->user()->name }}</div>
                        <div class="text-[9px] font-bold text-slate-400 uppercase">Asesor Penilai</div>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-bold shadow-md shadow-blue-500/10">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                </div>
            </div>
        </header>

        <!-- MAIN AREA -->
        <main class="flex-1 p-6 max-w-6xl mx-auto w-full space-y-6">

            @if(session('success'))
                <div class="p-4 bg-blue-500/10 border border-blue-500/20 text-blue-600 dark:text-blue-400 rounded-xl text-sm flex items-center gap-3 shadow-sm">
                    <span>✓</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 bg-rose-500/10 border border-rose-500/20 text-rose-600 dark:text-rose-400 rounded-xl text-sm flex items-center gap-3 shadow-sm">
                    <span>✗</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- PANEL: DASBOR -->
            <div id="panel-dasbor" class="role-panel space-y-6">
                @php $pendingAttempts = $attempts->where('status', 'in_progress')->count(); @endphp
                @if($pendingAttempts > 0)
                <div class="p-4 bg-amber-500/10 border border-amber-500/25 rounded-2xl flex items-center justify-between text-amber-800 dark:text-amber-400 shadow-sm">
                    <div class="flex items-center gap-3">
                        <span class="text-xl">⚠️</span>
                        <span class="text-xs font-bold uppercase tracking-wider">Ada {{ $pendingAttempts }} Ujian Asesi sedang berlangsung dan belum selesai.</span>
                    </div>
                    <button type="button" onclick="showPanel('penilaian')" class="bg-amber-600 hover:bg-amber-700 text-white font-extrabold text-[10px] uppercase px-4 py-2 rounded-xl transition-all shadow-sm">Lihat Sekarang</button>
                </div>
                @endif

                <!-- Schedule Card & Summary -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                    <div class="md:col-span-7 bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm space-y-4">
                        <h3 class="font-extrabold text-sm text-slate-800 dark:text-white uppercase tracking-wider">Jadwal Ujian/Observasi Terdekat</h3>
                        @php $nextSched = $schedules->where('scheduled_at', '>=', now())->first(); @endphp
                        @if($nextSched)
                        <div class="bg-white dark:bg-slate-950/60 p-4 border border-slate-200 dark:border-slate-800 rounded-xl space-y-1">
                            <div class="text-xs font-bold text-slate-800 dark:text-slate-100">{{ $nextSched->trainingProgram?->title ?? $nextSched->topic }}</div>
                            <div class="text-[11px] text-slate-400 font-mono">{{ \Carbon\Carbon::parse($nextSched->scheduled_at)->translatedFormat('l, d M Y — H:i') }} WIB</div>
                            <div class="text-[10px] text-blue-600 font-bold uppercase mt-1">📍 {{ $nextSched->location }}</div>
                        </div>
                        @else
                        <div class="text-center py-6 text-slate-400 text-xs">
                            <div class="text-3xl mb-2">📅</div>
                            Tidak ada jadwal mendatang.
                        </div>
                        @endif
                    </div>

                    <div class="md:col-span-5 bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm space-y-4">
                        <h3 class="font-extrabold text-sm text-slate-800 dark:text-white uppercase tracking-wider">Ringkasan Evaluasi CBT</h3>
                        <div class="grid grid-cols-2 gap-4 text-center">
                            <div class="bg-white dark:bg-slate-950/60 rounded-xl p-3 border border-slate-200 dark:border-slate-800">
                                <div id="stat-schemes" class="text-2xl font-black text-slate-800 dark:text-white">{{ $schemes->count() }}</div>
                                <div class="text-[9px] text-slate-400 font-bold uppercase mt-1">Skema Dibuat</div>
                            </div>
                            <div class="bg-white dark:bg-slate-950/60 rounded-xl p-3 border border-slate-200 dark:border-slate-800">
                                <div id="stat-attempts" class="text-2xl font-black text-slate-800 dark:text-white">{{ $attempts->count() }}</div>
                                <div class="text-[9px] text-slate-400 font-bold uppercase mt-1">Ujian Selesai</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PANEL: APL02 -->
            <div id="panel-apl02" class="role-panel hidden space-y-6">
                <div class="space-y-1">
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">Review Mandiri Portofolio (APL-02)</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-xs">Periksa kelengkapan bukti mandiri / portofolio asesi.</p>
                </div>
                <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm">
                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-slate-100 dark:border-slate-800 text-slate-400 text-[10px] uppercase font-extrabold">
                                    <th class="px-5 py-3 text-left">Nama Asesi</th>
                                    <th class="px-5 py-3 text-left">Program</th>
                                    <th class="px-5 py-3 text-left">Dokumen</th>
                                    <th class="px-5 py-3 text-center">Berkas</th>
                                    <th class="px-5 py-3 text-center">Status</th>
                                    <th class="px-5 py-3 text-left">Catatan Asesor</th>
                                    <th class="px-5 py-3 text-center">Aksi Penilaian</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @forelse($portfolios as $port)
                                <tr>
                                    <td class="px-5 py-4">
                                        <div class="font-bold text-slate-800 dark:text-white">{{ $port->user?->name ?? '-' }}</div>
                                        <div class="text-[10px] text-slate-400 font-semibold">{{ $port->user?->email }}</div>
                                    </td>
                                    <td class="px-5 py-4 text-xs font-semibold text-slate-700 dark:text-slate-350">{{ $port->trainingProgram?->title ?? '-' }}</td>
                                    <td class="px-5 py-4 text-xs font-bold text-slate-800 dark:text-white">{{ $port->document_name }}</td>
                                    <td class="px-5 py-4 text-center">
                                        <a href="{{ asset('storage/' . $port->file_path) }}" target="_blank" class="inline-flex items-center gap-1.5 text-blue-600 dark:text-blue-400 hover:underline text-xs font-bold font-mono">
                                            👁️ Lihat File
                                        </a>
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        @if($port->status === 'approved')
                                            <span class="bg-emerald-50 dark:bg-emerald-950/20 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 px-2 py-0.5 rounded text-[9px] font-bold uppercase">Disetujui</span>
                                        @elseif($port->status === 'rejected')
                                            <span class="bg-rose-50 dark:bg-rose-950/20 text-rose-600 dark:text-rose-400 border border-rose-500/20 px-2 py-0.5 rounded text-[9px] font-bold uppercase">Ditolak</span>
                                        @else
                                            <span class="bg-amber-50 dark:bg-amber-950/20 text-amber-600 dark:text-amber-400 border border-amber-500/20 px-2 py-0.5 rounded text-[9px] font-bold uppercase">Pending</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-xs text-slate-500 dark:text-slate-400">{{ $port->notes ?? '-' }}</td>
                                    <td class="px-5 py-4 text-center">
                                        @if($port->status === 'pending')
                                            <button type="button" onclick="openReviewModal('{{ $port->id }}', '{{ addslashes($port->user?->name) }}', '{{ addslashes($port->document_name) }}')" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-[10px] uppercase px-3 py-1.5 rounded-lg transition-all shadow-md shadow-blue-500/10">Review</button>
                                        @else
                                            <button type="button" onclick="openReviewModal('{{ $port->id }}', '{{ addslashes($port->user?->name) }}', '{{ addslashes($port->document_name) }}', '{{ $port->status }}', '{{ addslashes($port->notes) }}')" class="text-slate-400 hover:text-slate-600 text-xs font-semibold">Ubah Review</button>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="7" class="px-5 py-8 text-center text-slate-500 dark:text-slate-400">Belum ada berkas portofolio asesi yang diunggah.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- PANEL: PENILAIAN -->
            <div id="panel-penilaian" class="role-panel hidden space-y-6">
                <div class="space-y-1">
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">Hasil Ujian &amp; Penilaian Ujian</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-xs">Daftar asesi yang telah mengerjakan ujian CBT dan perlu dinilai keputusannya.</p>
                </div>

                <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm">
                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-slate-100 dark:border-slate-800 text-slate-400 text-[10px] uppercase font-extrabold">
                                    <th class="px-5 py-3 text-left">Nama Asesi</th>
                                    <th class="px-5 py-3 text-left">Skema</th>
                                    <th class="px-5 py-3 text-left">Nilai CBT</th>
                                    <th class="px-5 py-3 text-center">Keputusan Kelulusan / Nilai</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @forelse($attempts as $att)
                                    <tr>
                                        <td class="px-5 py-4 font-bold text-slate-800 dark:text-white">{{ $att->asesi?->name ?? '-' }}</td>
                                        <td class="px-5 py-4 text-xs text-slate-600 dark:text-slate-300 font-semibold">{{ $att->scheme?->title ?? '-' }}</td>
                                        <td class="px-5 py-4 text-xs font-mono font-bold">{{ $att->score }}%</td>
                                        <td class="px-5 py-4 text-center">
                                            <button type="button" onclick="alert('Membuka form penilaian praktikum & keputusan kelulusan...');" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-[10px] uppercase px-3 py-1.5 rounded-lg shadow-sm">Input Nilai &amp; Keputusan</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="px-5 py-8 text-center text-slate-500 dark:text-slate-400">Belum ada pengerjaan ujian.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- PANEL: KELOLA -->
            <div id="panel-kelola" class="role-panel hidden space-y-6">
                <!-- Skema Form & List -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Buat Skema -->
                    <div class="md:col-span-1 bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm space-y-4">
                        <h3 class="font-extrabold text-sm text-slate-800 dark:text-white uppercase tracking-wider">Buat Ujian CBT Baru</h3>
                        <form action="{{ route('asesor.scheme.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Judul Ujian</label>
                                <input type="text" name="title" required placeholder="Contoh: Ujian Tata Usaha MPI" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Deskripsi Singkat</label>
                                <textarea name="description" placeholder="Deskripsi ujian..." class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold" rows="3"></textarea>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Durasi (Menit)</label>
                                <input type="number" name="duration_minutes" required value="60" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                            </div>
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs uppercase py-3 rounded-xl shadow-md shadow-blue-500/10">Buat Skema Ujian</button>
                        </form>
                    </div>

                    <!-- List Skema -->
                    <div class="md:col-span-2 bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm">
                        <div class="overflow-x-auto w-full">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-slate-100 dark:border-slate-800 text-slate-400 text-[10px] uppercase font-extrabold">
                                        <th class="px-5 py-3 text-left">Judul Ujian</th>
                                        <th class="px-5 py-3 text-left">Durasi</th>
                                        <th class="px-5 py-3 text-left">Soal</th>
                                        <th class="px-5 py-3 text-center">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                    @forelse($schemes as $sch)
                                        <tr>
                                            <td class="px-5 py-4 font-bold text-slate-800 dark:text-white">{{ $sch->title }}</td>
                                            <td class="px-5 py-4 text-xs font-mono">{{ $sch->duration_minutes }} menit</td>
                                            <td class="px-5 py-4 text-xs font-mono font-bold">{{ $sch->questions_count }} Soal</td>
                                            <td class="px-5 py-4 text-center">
                                                <div class="flex items-center justify-center gap-3">
                                                    <a href="{{ route('asesor.scheme.edit', $sch->id) }}" class="text-blue-600 hover:text-blue-700 font-bold text-xs uppercase">Edit Soal</a>
                                                    <form action="{{ route('asesor.scheme.delete', $sch->id) }}" method="POST">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="text-rose-600 hover:text-rose-800 font-bold text-xs uppercase">Hapus</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="px-5 py-8 text-center text-slate-500 dark:text-slate-400">Belum ada skema ujian dibuat.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PANEL: JADWAL & SILABUS -->
            <div id="panel-jadwal" class="role-panel hidden space-y-6">
                <div class="space-y-1">
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">Jadwal & Silabus Pelatihan</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-xs">Kelola jadwal pertemuan diklat dan silabus program pelatihan LPK.</p>
                </div>

                <!-- Form Edit Jadwal (Hidden by Default) -->
                <div id="form-edit-schedule" class="hidden bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm space-y-4">
                    <h3 class="font-extrabold text-sm text-slate-800 dark:text-white uppercase tracking-wider">Edit Jadwal Kelas</h3>
                    <form id="edit-schedule-form-action" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Program Pelatihan</label>
                                <select name="training_program_id" id="edit-schedule-program-id" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold font-mono">
                                    @foreach($programs as $p)
                                        <option value="{{ $p->id }}">{{ $p->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Topik / Materi Pembahasan</label>
                                <input type="text" name="topic" id="edit-schedule-topic" required placeholder="Contoh: Pengantar Tata Usaha" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold font-mono">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Tanggal & Waktu</label>
                                <input type="datetime-local" name="scheduled_at" id="edit-schedule-scheduled-at" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold font-mono">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Lokasi / Tautan Media</label>
                                <input type="text" name="location" id="edit-schedule-location" required placeholder="Contoh: Ruang Kelas B / Zoom Meeting" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold font-mono">
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <button type="button" onclick="cancelEditSchedule()" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase px-4 py-2.5 rounded-xl font-bold">Batal</button>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs uppercase px-6 py-3 rounded-xl shadow-md shadow-blue-500/10">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Form Tambah Jadwal Baru -->
                    <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm space-y-4">
                        <h3 class="font-extrabold text-sm text-slate-800 dark:text-white uppercase tracking-wider">Tambah Jadwal Pertemuan Baru</h3>
                        <form action="{{ route('asesor.schedule.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Program Pelatihan</label>
                                <select name="training_program_id" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                                    @foreach($programs as $p)
                                        <option value="{{ $p->id }}">{{ $p->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Topik / Materi Pembahasan</label>
                                <input type="text" name="topic" required placeholder="Contoh: Pengantar Administrasi Sekolah" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Tanggal & Waktu</label>
                                    <input type="datetime-local" name="scheduled_at" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold font-mono">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Lokasi / Tautan Zoom</label>
                                    <input type="text" name="location" required placeholder="Contoh: Ruang 3 / Zoom Link" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                                </div>
                            </div>
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs uppercase py-3 rounded-xl transition-all shadow-md shadow-blue-500/10">Buat Jadwal Baru</button>
                        </form>
                    </div>

                    <!-- Form Edit Silabus / Deskripsi Program -->
                    <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm space-y-4">
                        <h3 class="font-extrabold text-sm text-slate-800 dark:text-white uppercase tracking-wider">Perbarui Silabus Program</h3>
                        <form id="update-syllabus-form" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Pilih Program Pelatihan</label>
                                <select id="syllabus-program-selector" onchange="loadProgramSyllabus(this.value)" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                                    <option value="">-- Pilih Program --</option>
                                    @foreach($programs as $p)
                                        <option value="{{ $p->id }}" data-desc="{{ $p->description }}" data-benefits="{{ is_array($p->benefits) ? implode("\n", $p->benefits) : '' }}">{{ $p->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Deskripsi Silabus</label>
                                <textarea name="description" id="syllabus-description" required rows="3" placeholder="Deskripsi materi program..." class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold"></textarea>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Materi / Manfaat (Satu baris per item)</label>
                                <textarea name="benefits" id="syllabus-benefits" rows="3" placeholder="Contoh:&#10;Sertifikat Kompetensi Resmi&#10;Modul Pembelajaran Praktis" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold"></textarea>
                            </div>
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs uppercase py-3 rounded-xl transition-all shadow-md shadow-blue-500/10">Simpan Perubahan Silabus</button>
                        </form>
                    </div>
                </div>

                <!-- List Jadwal Kelas Aktif -->
                <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm">
                    <h3 class="p-4 font-extrabold text-xs text-slate-400 uppercase tracking-widest border-b border-slate-100 dark:border-slate-800">Daftar Pertemuan Kelas Saya</h3>
                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-slate-100 dark:border-slate-800 text-slate-400 text-[10px] uppercase font-extrabold">
                                    <th class="px-5 py-3 text-left">Program Pelatihan</th>
                                    <th class="px-5 py-3 text-left">Topik / Materi</th>
                                    <th class="px-5 py-3 text-left">Waktu</th>
                                    <th class="px-5 py-3 text-left">Lokasi / Media</th>
                                    <th class="px-5 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @forelse($schedules as $sched)
                                    <tr>
                                        <td class="px-5 py-4 font-bold text-slate-800 dark:text-white">{{ $sched->trainingProgram?->title ?? '-' }}</td>
                                        <td class="px-5 py-4 text-xs font-semibold text-slate-700 dark:text-slate-300">{{ $sched->topic }}</td>
                                        <td class="px-5 py-4 text-xs font-mono text-slate-500 dark:text-slate-400">{{ \Carbon\Carbon::parse($sched->scheduled_at)->format('d M Y, H:i') }} WIB</td>
                                        <td class="px-5 py-4 text-xs text-slate-600 dark:text-slate-400 font-semibold">{{ $sched->location }}</td>
                                        <td class="px-5 py-4">
                                            <div class="flex items-center justify-center gap-2">
                                                <button type="button" data-schedule="{{ json_encode($sched) }}" onclick="editSchedule(JSON.parse(this.dataset.schedule))" class="text-blue-600 hover:text-blue-800 font-bold uppercase text-[10px]">Edit</button>
                                                <form action="{{ route('asesor.schedule.delete', $sched->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-rose-600 hover:text-rose-800 font-bold uppercase text-[10px]">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="px-5 py-8 text-center text-slate-500 dark:text-slate-400">Belum ada jadwal kelas dibuat.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- PANEL: PROFIL -->
            <div id="panel-profil" class="role-panel hidden space-y-6">
                <div class="space-y-1">
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">Profil Saya</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-xs">Perbarui data login dan kredensial asesor Anda.</p>
                </div>
                <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 max-w-2xl shadow-sm">
                    <form action="{{ route('asesor.profile.update') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Username / Nama Asesor</label>
                            <input type="text" name="username" value="{{ auth()->user()->username }}" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold font-mono">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Email</label>
                            <input type="email" name="email" value="{{ auth()->user()->email }}" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold font-mono">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Kata Sandi Baru (Kosongkan jika tidak diubah)</label>
                            <input type="password" name="password" placeholder="Minimal 6 karakter" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Konfirmasi Kata Sandi</label>
                            <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi baru" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs uppercase px-6 py-3 rounded-xl shadow-md shadow-blue-500/10">Perbarui Profil</button>
                        </div>
                    </form>
                </div>
            </div>

        </main>
    </div>

    <!-- SCRIPTS -->
    <script>
        const panels = ['dasbor', 'apl02', 'penilaian', 'kelola', 'jadwal', 'profil'];

        function editSchedule(sched) {
            const editDiv = document.getElementById('form-edit-schedule');
            editDiv.classList.remove('hidden');
            document.getElementById('edit-schedule-program-id').value = sched.training_program_id;
            document.getElementById('edit-schedule-topic').value = sched.topic;
            
            if(sched.scheduled_at) {
                const date = new Date(sched.scheduled_at);
                const localISODate = new Date(date.getTime() - date.getTimezoneOffset() * 60000)
                                      .toISOString().slice(0, 16);
                document.getElementById('edit-schedule-scheduled-at').value = localISODate;
            }
            
            document.getElementById('edit-schedule-location').value = sched.location;
            document.getElementById('edit-schedule-form-action').action = `/dashboard/asesor/schedules/${sched.id}`;
            editDiv.scrollIntoView({ behavior: 'smooth' });
        }

        function cancelEditSchedule() {
            document.getElementById('form-edit-schedule').classList.add('hidden');
        }

        function loadProgramSyllabus(programId) {
            const selector = document.getElementById('syllabus-program-selector');
            const selectedOpt = selector.options[selector.selectedIndex];
            
            if (programId) {
                const desc = selectedOpt.getAttribute('data-desc') || '';
                const benefits = selectedOpt.getAttribute('data-benefits') || '';
                
                document.getElementById('syllabus-description').value = desc;
                document.getElementById('syllabus-benefits').value = benefits;
                document.getElementById('update-syllabus-form').action = `/dashboard/asesor/syllabus/${programId}`;
            } else {
                document.getElementById('syllabus-description').value = '';
                document.getElementById('syllabus-benefits').value = '';
                document.getElementById('update-syllabus-form').action = '';
            }
        }

        function updateDocumentTitle(panelId) {
            let sectionTitle = "";
            switch(panelId) {
                case 'dasbor': sectionTitle = "Dasbor Evaluasi"; break;
                case 'apl02': sectionTitle = "Review Pra-Asesmen (APL-02)"; break;
                case 'penilaian': sectionTitle = "Penilaian Ujian"; break;
                case 'kelola': sectionTitle = "Kelola Ujian"; break;
                case 'jadwal': sectionTitle = "Jadwal & Silabus"; break;
                case 'profil': sectionTitle = "Profil Saya"; break;
                default: sectionTitle = "Dasbor";
            }
            const siteName = "{{ $siteName }}";
            document.title = `${sectionTitle} — Asesor — ${siteName}`;
        }

        function showPanel(id) {
            if (id.startsWith('panel-')) {
                id = id.substring(6);
            }
            panels.forEach(p => {
                const el = document.getElementById('panel-' + p);
                if (el) el.classList.add('hidden');
            });
            const activeEl = document.getElementById('panel-' + id);
            if (activeEl) activeEl.classList.remove('hidden');

            document.querySelectorAll('#sidebar button').forEach(b => {
                b.classList.remove('bg-blue-50', 'dark:bg-blue-950/20', 'text-blue-600', 'dark:text-blue-400');
                b.classList.add('text-slate-600', 'dark:text-slate-400');
            });

            const btn = document.getElementById('btn-' + id);
            if (btn) {
                btn.classList.add('bg-blue-50', 'dark:bg-blue-950/20', 'text-blue-600', 'dark:text-blue-400');
                btn.classList.remove('text-slate-600', 'dark:text-slate-400');
            }

            localStorage.setItem('asesor_active_panel', id);
            
            updateDocumentTitle(id);

            if (window.innerWidth < 768) {
                document.getElementById('sidebar').classList.remove('open');
            }
        }

        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
        }

        function toggleTheme() {
            const html = document.documentElement;
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.setItem('lpk_theme', 'light');
            } else {
                html.classList.add('dark');
                localStorage.setItem('lpk_theme', 'dark');
            }
            updateThemeUI();
        }

        function updateThemeUI() {
            const icon = document.getElementById('theme-icon');
            const label = document.getElementById('theme-label');
            const isDark = document.documentElement.classList.contains('dark');
            if (icon) icon.textContent = isDark ? '🌙' : '☀️';
            if (label) label.textContent = isDark ? 'Mode Gelap' : 'Mode Terang';
        }

        function toggleAccordion(trigger) {
            const group = trigger.closest('.accordion-group');
            const content = group.querySelector('.accordion-content');
            const arrow = trigger.querySelector('.accordion-arrow');
            const isOpen = !content.classList.contains('hidden');
            document.querySelectorAll('.accordion-content').forEach(c => c.classList.add('hidden'));
            document.querySelectorAll('.accordion-arrow').forEach(a => a.style.transform = '');
            if (!isOpen) {
                content.classList.remove('hidden');
                arrow.style.transform = 'rotate(180deg)';
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const activePanel = urlParams.get('open') || 'dasbor';
            showPanel(activePanel);
            updateThemeUI();
            const activeBtn = document.getElementById('btn-' + activePanel);
            if (activeBtn) {
                const group = activeBtn.closest('.accordion-group');
                if (group) {
                    const content = group.querySelector('.accordion-content');
                    const arrow = group.querySelector('.accordion-arrow');
                    if (content) content.classList.remove('hidden');
                    if (arrow) arrow.style.transform = 'rotate(180deg)';
                }
            }
        });

        function openReviewModal(id, asesiName, docName, status = '', notes = '') {
            const modal = document.getElementById('review-portfolio-modal');
            const form = document.getElementById('review-portfolio-form');
            const nameEl = document.getElementById('review-asesi-name');
            const docEl = document.getElementById('review-doc-name');
            const notesEl = document.getElementById('review-notes');

            // Set action URL dynamically
            let actionUrl = "{{ route('asesor.portfolio.review', ':id') }}";
            form.action = actionUrl.replace(':id', id);

            // Populate data
            nameEl.textContent = asesiName;
            docEl.textContent = docName;
            notesEl.value = notes;

            // Reset radio buttons
            document.getElementById('status-approved').checked = false;
            document.getElementById('status-rejected').checked = false;

            if (status === 'approved') {
                document.getElementById('status-approved').checked = true;
            } else if (status === 'rejected') {
                document.getElementById('status-rejected').checked = true;
            }

            modal.classList.remove('hidden');
        }

        function closeReviewModal() {
            document.getElementById('review-portfolio-modal').classList.add('hidden');
        }
    </script>

    <!-- MODAL REVIEW PORTOFOLIO (APL-02) -->
    <div id="review-portfolio-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden transition-all transform scale-95 duration-200">
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-850 flex items-center justify-between">
                <h3 class="text-base font-extrabold text-slate-900 dark:text-white uppercase tracking-wider">Review Portofolio Asesi</h3>
                <button type="button" onclick="closeReviewModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-white transition-colors text-lg font-bold">&times;</button>
            </div>
            
            <!-- Modal Body / Form -->
            <form id="review-portfolio-form" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Nama Asesi</label>
                    <div id="review-asesi-name" class="text-sm font-bold text-slate-800 dark:text-white"></div>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Jenis Dokumen</label>
                    <div id="review-doc-name" class="text-xs font-semibold text-slate-600 dark:text-slate-350"></div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Keputusan Review</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 px-4 py-3 rounded-xl flex-1 hover:border-emerald-500 transition-all">
                            <input type="radio" name="status" value="approved" id="status-approved" required class="text-blue-600 focus:ring-blue-500">
                            <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase">Setujui</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 px-4 py-3 rounded-xl flex-1 hover:border-rose-500 transition-all">
                            <input type="radio" name="status" value="rejected" id="status-rejected" required class="text-blue-600 focus:ring-blue-500">
                            <span class="text-xs font-bold text-rose-600 dark:text-rose-400 uppercase">Tolak</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Catatan / Alasan (Opsional)</label>
                    <textarea name="notes" id="review-notes" rows="3" placeholder="Berikan catatan perbaikan atau alasan jika dokumen ditolak..." class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 transition-all"></textarea>
                </div>

                <div class="flex justify-end gap-3 pt-2 border-t border-slate-100 dark:border-slate-850">
                    <button type="button" onclick="closeReviewModal()" class="border border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-900 text-slate-600 dark:text-slate-400 font-bold text-xs uppercase tracking-wider px-5 py-2.5 rounded-xl transition-all">Batal</button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase tracking-wider px-5 py-2.5 rounded-xl transition-all shadow-md shadow-blue-500/10">Simpan Keputusan</button>
                </div>
            </form>
        </div>
    </div>

    @include('layouts.partials.live_refresh', [
        'statsUrl' => route('asesor.stats'),
        'statMap'  => [
            'stat-schemes'  => 'schemes',
            'stat-attempts' => 'attempts',
        ]
    ])
</body>
</html>

