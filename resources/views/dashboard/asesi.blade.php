<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Asesi — LPK MPI</title>
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
        /* Custom sidebar hover transition */
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
                            🎓
                        </div>
                    @endif
                    <div>
                        <div class="font-extrabold text-sm text-slate-900 dark:text-white tracking-tight">{{ $siteName }}</div>
                        <div class="text-[10px] text-blue-600 font-bold tracking-widest uppercase">Asesi Panel</div>
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

                <button type="button" onclick="showPanel('profil')" id="btn-profil" class="sidebar-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all text-left">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span>Profil & Dokumen</span>
                </button>

                <!-- Accordion: Pelatihan -->
                <div class="accordion-group">
                    <button type="button" class="accordion-trigger w-full flex items-center justify-between gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all text-left" onclick="toggleAccordion(this)">
                        <span class="flex items-center gap-3">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            <span>Pelatihan & Ujian</span>
                        </span>
                        <svg class="accordion-arrow w-4 h-4 shrink-0 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="accordion-content hidden pl-4 mt-1 space-y-1 border-l-2 border-blue-100 dark:border-blue-900 ml-6">
                        <button type="button" onclick="showPanel('portofolio')" id="btn-portofolio" class="sidebar-btn w-full flex items-center gap-2 px-3 py-2.5 rounded-lg text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all text-left">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            Portofolio APL-02
                        </button>
                        <button type="button" onclick="showPanel('skema')" id="btn-skema" class="sidebar-btn w-full flex items-center gap-2 px-3 py-2.5 rounded-lg text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all text-left">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            Skema Pelatihan
                        </button>
                        <button type="button" onclick="showPanel('jadwal')" id="btn-jadwal" class="sidebar-btn w-full flex items-center gap-2 px-3 py-2.5 rounded-lg text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all text-left">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            Jadwal & Ujian
                        </button>
                        <button type="button" onclick="showPanel('sertifikat')" id="btn-sertifikat" class="sidebar-btn w-full flex items-center gap-2 px-3 py-2.5 rounded-lg text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all text-left">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            E-Sertifikat
                        </button>
                    </div>
                </div>
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
                <span class="text-xs font-black uppercase tracking-widest text-blue-600 block">MANAJEMEN PENDIDIKAN INDONESIA</span>
            </div>
            
            <!-- User Status & Notification -->
            <div class="flex items-center gap-4">
                <div class="relative cursor-pointer text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    <span class="absolute top-0 right-0 w-2.5 h-2.5 bg-blue-500 rounded-full ring-2 ring-white dark:ring-slate-950"></span>
                </div>
                
                <!-- Profile details -->
                <div class="flex items-center gap-3 pl-3 border-l border-slate-200 dark:border-slate-800">
                    <div class="text-right hidden sm:block">
                        <div class="text-xs font-bold text-slate-800 dark:text-slate-200">{{ auth()->user()->name }}</div>
                        <div class="text-[9px] font-bold text-slate-400 uppercase">Asesi (Peserta)</div>
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

            <!-- PANEL: DASBOR -->
            <div id="panel-dasbor" class="role-panel space-y-6">
                <!-- Welcome Greeting -->
                <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl p-6 md:p-8 text-white relative overflow-hidden shadow-lg shadow-blue-600/10">
                    <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-blue-500/20 rounded-full"></div>
                    <div class="absolute right-12 top-4 text-6xl opacity-10 font-serif">🎓</div>
                    <div class="relative z-10 space-y-2 max-w-xl">
                        <span class="text-[10px] bg-white/20 px-3 py-1 rounded-full font-bold uppercase tracking-wider">MARHABAN</span>
                        <h2 class="text-2xl md:text-3xl font-extrabold font-heading">Selamat datang, {{ auth()->user()->name }}</h2>
                        <p class="text-blue-100 text-xs md:text-sm">Selamat datang di portal asesi Manajemen Pendidikan Indonesia. Akses materi, kuis, dan kelola portofolio sertifikasi Anda secara terpadu di sini.</p>
                    </div>
                </div>

                <!-- Live Stats Bar -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-950/20 text-blue-600 flex items-center justify-center text-2xl">📋</div>
                        <div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Skema Sertifikasi Aktif</div>
                            <div id="stat-schemes" class="text-2xl font-black text-slate-800 dark:text-white mt-1">{{ $schemes->count() }}</div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-amber-50 dark:bg-amber-950/20 text-amber-600 flex items-center justify-center text-2xl">✍️</div>
                        <div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Ujian Diikuti</div>
                            <div id="stat-attempts" class="text-2xl font-black text-slate-800 dark:text-white mt-1">{{ $attempts->count() }}</div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-950/20 text-blue-600 flex items-center justify-center text-2xl">🎓</div>
                        <div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Sertifikat Kelulusan</div>
                            <div id="stat-lulus" class="text-2xl font-black text-slate-800 dark:text-white mt-1">{{ $enrollments->where('status', 'LULUS')->count() }}</div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                    <!-- Status Card -->
                    <div class="md:col-span-4 bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 flex flex-col justify-between shadow-sm">
                        <div class="space-y-1">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Verifikasi Akun</span>
                            <h3 class="text-base font-extrabold text-slate-800 dark:text-white">Status Pendaftaran</h3>
                        </div>
                        <div class="mt-4">
                            @php
                                $hasPaid = $enrollments->contains('payment_status', 'PAID');
                            @endphp
                            @if($hasPaid)
                                <div class="inline-flex items-center gap-2 bg-blue-500/10 border border-blue-500/25 px-4 py-2 rounded-xl text-xs font-bold text-blue-600 dark:text-blue-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                    Terverifikasi Aktif
                                </div>
                            @else
                                <div class="inline-flex items-center gap-2 bg-amber-500/10 border border-amber-500/25 px-4 py-2 rounded-xl text-xs font-bold text-amber-600 dark:text-amber-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                    Menunggu Verifikasi
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Progress Bar Card -->
                    <div class="md:col-span-8 bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Progres Pelatihan &amp; Diklat</h3>
                            <span class="text-xs font-black text-blue-600 dark:text-blue-400">70% Selesai</span>
                        </div>
                        <!-- Progress Bar -->
                        <div class="w-full bg-white dark:bg-slate-800 h-2.5 rounded-full overflow-hidden">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-full rounded-full" style="width: 70%"></div>
                        </div>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed">Anda telah menyelesaikan 7 dari 10 kompetensi dasar dalam kurikulum Manajemen Pendidikan Indonesia.</p>
                    </div>
                </div>

                <!-- Next Schedule & Quick Action -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Schedule Card -->
                    <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm space-y-4">
                        <div class="flex items-center gap-3">
                            <span class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-950/20 text-blue-600 flex items-center justify-center text-sm">📅</span>
                            <h3 class="font-bold text-sm text-slate-800 dark:text-white">Jadwal Terdekat</h3>
                        </div>
                        <div class="bg-white dark:bg-slate-950/60 p-4 border border-slate-200 dark:border-slate-800 rounded-xl space-y-1">
                            <div class="text-xs font-bold text-slate-800 dark:text-slate-100">Pra-Asesmen Tata Usaha Pendidikan Indonesia</div>
                            <div class="text-[11px] text-slate-500 dark:text-slate-400 font-mono">Selasa, 11 Agustus 2026 (09:00 - 11:30 WIB)</div>
                            <div class="text-[10px] text-blue-600 font-bold uppercase mt-1">Metode: Daring via Zoom</div>
                        </div>
                    </div>

                    <!-- Quick Action Card -->
                    <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm flex flex-col justify-between gap-4">
                        <div class="space-y-1">
                            <span class="text-[10px] font-bold text-blue-600 uppercase tracking-widest block">AKSES CEPAT</span>
                            <h3 class="text-sm font-bold text-slate-800 dark:text-white">Aktivitas Belajar Mandiri</h3>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <button type="button" onclick="showPanel('skema')" class="flex-1 min-w-[120px] bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs uppercase tracking-wider py-3 rounded-xl transition-all shadow-md shadow-blue-500/10">
                                Lanjutkan Modul
                            </button>
                            <button type="button" onclick="showPanel('jadwal')" class="flex-1 min-w-[120px] bg-white hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-750 text-slate-800 dark:text-white font-extrabold text-xs uppercase tracking-wider py-3 rounded-xl transition-all border border-slate-200 dark:border-slate-700">
                                Lihat Hasil Ujian
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PANEL: PROFIL & DOKUMEN -->
            <div id="panel-profil" class="role-panel hidden space-y-6">
                <div class="space-y-1">
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">Profil & Pengaturan Akun</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-xs">Ubah data login dan kelola data profil terdaftar Anda.</p>
                </div>
                <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 max-w-2xl shadow-sm">
                    <form action="{{ route('asesi.profile.update') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                            <input type="text" name="username" value="{{ auth()->user()->username }}" required
                                class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 transition-all font-semibold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Alamat Email</label>
                            <input type="email" name="email" value="{{ auth()->user()->email }}" required
                                class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 transition-all font-semibold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Kata Sandi Baru (Kosongkan jika tidak diubah)</label>
                            <input type="password" name="password" placeholder="Minimal 6 karakter"
                                class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi baru"
                                class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 transition-all">
                        </div>
                        <div class="flex justify-end pt-2">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs uppercase tracking-wider px-6 py-3 rounded-xl transition-all shadow-md shadow-blue-500/10">
                                Perbarui Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- PANEL: PORTOFOLIO (APL-02) -->
            <div id="panel-portofolio" class="role-panel hidden space-y-6">
                <div class="space-y-1">
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">Portofolio Mandiri (APL-02)</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-xs">Unggah dokumen portofolio pendukung untuk persyaratan pra-asesmen sertifikasi.</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                    <!-- Form Upload -->
                    <div class="lg:col-span-4 bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm space-y-4 h-fit">
                        <h3 class="font-extrabold text-sm text-slate-800 dark:text-white uppercase tracking-wider">Unggah Dokumen Baru</h3>
                        @if($enrollments->isEmpty())
                            <p class="text-xs text-rose-500 font-semibold">Anda harus terdaftar di program pelatihan aktif terlebih dahulu.</p>
                        @else
                            <form action="{{ route('asesi.portfolio.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Program Pelatihan</label>
                                    <select name="training_program_id" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                                        @foreach($enrollments as $enr)
                                            @if($enr->trainingProgram)
                                                <option value="{{ $enr->trainingProgram->id }}">{{ $enr->trainingProgram->title }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Jenis Dokumen / Bukti</label>
                                    <select name="document_name" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                                        <option value="Curriculum Vitae (CV)">Curriculum Vitae (CV)</option>
                                        <option value="Surat Pengalaman Kerja / SK">Surat Pengalaman Kerja / SK</option>
                                        <option value="Sertifikat Diklat / Pelatihan">Sertifikat Diklat / Pelatihan</option>
                                        <option value="Ijazah Terakhir">Ijazah Terakhir</option>
                                        <option value="Dokumen Karya Mandiri / Portofolio">Dokumen Karya Mandiri / Portofolio</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">File Berkas (PDF, JPG, PNG - Max 5MB)</label>
                                    <input type="file" name="portfolio_file" required class="w-full text-xs file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-950/20 dark:file:text-blue-400">
                                </div>
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs uppercase tracking-wider py-3 rounded-xl transition-all shadow-md shadow-blue-500/10">Unggah Portofolio</button>
                            </form>
                        @endif
                    </div>

                    <!-- List Uploaded Portfolios -->
                    <div class="lg:col-span-8 bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm">
                        <h3 class="p-4 font-extrabold text-xs text-slate-400 uppercase tracking-widest border-b border-slate-100 dark:border-slate-800">Berkas Portofolio Terunggah</h3>
                        <div class="overflow-x-auto w-full">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-slate-100 dark:border-slate-800 text-slate-400 text-[10px] uppercase font-extrabold">
                                        <th class="px-4 py-3 text-left">Jenis Dokumen</th>
                                        <th class="px-4 py-3 text-left">Program</th>
                                        <th class="px-4 py-3 text-center">Berkas</th>
                                        <th class="px-4 py-3 text-center">Status</th>
                                        <th class="px-4 py-3 text-left">Catatan</th>
                                        <th class="px-4 py-3 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                    @forelse($portfolios as $port)
                                        <tr>
                                            <td class="px-4 py-4 font-bold text-slate-800 dark:text-white text-xs">{{ $port->document_name }}</td>
                                            <td class="px-4 py-4 text-xs text-slate-600 dark:text-slate-350">{{ $port->trainingProgram->title ?? '-' }}</td>
                                            <td class="px-4 py-4 text-center">
                                                <a href="{{ asset('storage/' . $port->file_path) }}" target="_blank" class="inline-flex items-center gap-1.5 text-blue-600 dark:text-blue-400 hover:underline text-xs font-bold font-mono">
                                                    👁️ Lihat File
                                                </a>
                                            </td>
                                            <td class="px-4 py-4 text-center">
                                                @if($port->status === 'approved')
                                                    <span class="bg-emerald-50 dark:bg-emerald-950/20 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 px-2 py-0.5 rounded text-[9px] font-bold uppercase">Disetujui</span>
                                                @elseif($port->status === 'rejected')
                                                    <span class="bg-rose-50 dark:bg-rose-950/20 text-rose-600 dark:text-rose-400 border border-rose-500/20 px-2 py-0.5 rounded text-[9px] font-bold uppercase">Ditolak</span>
                                                @else
                                                    <span class="bg-amber-50 dark:bg-amber-950/20 text-amber-600 dark:text-amber-400 border border-amber-500/20 px-2 py-0.5 rounded text-[9px] font-bold uppercase">Pending</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-4 text-xs text-slate-500 dark:text-slate-400">{{ $port->notes ?? '-' }}</td>
                                            <td class="px-4 py-4 text-center">
                                                <form action="{{ route('asesi.portfolio.delete', $port->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-rose-600 hover:text-rose-800 font-bold uppercase text-[10px]">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-4 py-8 text-center text-slate-400 text-xs">Belum ada berkas portofolio diunggah.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PANEL: SKEMA PELATIHAN -->
            <div id="panel-skema" class="role-panel hidden space-y-6">
                <div class="space-y-1">
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">Skema Pelatihan &amp; Modul</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-xs">Unduh modul pembelajaran kurikulum manajemen pendidikan Indonesia.</p>
                </div>

                @if($enrollments->isEmpty())
                    <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-12 text-center shadow-sm">
                        <p class="text-slate-400 text-sm">Anda belum terdaftar pada program pelatihan apapun.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($enrollments as $enr)
                            <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 space-y-4 shadow-sm">
                                <div class="border-b border-slate-100 dark:border-slate-800 pb-3">
                                    <span class="text-[9px] bg-blue-50 dark:bg-blue-950/20 text-blue-600 border border-blue-500/20 px-2.5 py-0.5 rounded-full font-bold uppercase tracking-wider">{{ $enr->trainingProgram?->category }}</span>
                                    <h3 class="text-base font-extrabold text-slate-800 dark:text-white mt-2">{{ $enr->trainingProgram?->title }}</h3>
                                </div>
                                
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between p-3 bg-white dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 rounded-xl">
                                        <div>
                                            <div class="text-xs font-bold text-slate-800 dark:text-white">Buku Panduan Tata Kelola Administrasi Madrasah</div>
                                            <div class="text-[10px] text-slate-400 font-mono">PDF — 4.2 MB</div>
                                        </div>
                                        <button type="button" onclick="alert('Mengunduh Modul Teori...');" class="bg-blue-50 dark:bg-blue-950/20 hover:bg-blue-600 hover:text-white border border-blue-500/20 text-blue-600 dark:text-blue-400 text-xs font-bold px-3 py-1.5 rounded-lg transition-all shrink-0">Unduh</button>
                                    </div>

                                    <div class="flex items-center justify-between p-3 bg-white dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 rounded-xl">
                                        <div>
                                            <div class="text-xs font-bold text-slate-800 dark:text-white">SOP Kepemimpinan dan Manajemen Mutu Sekolah</div>
                                            <div class="text-[10px] text-slate-400 font-mono">PDF — 2.8 MB</div>
                                        </div>
                                        <button type="button" onclick="alert('Mengunduh SOP...');" class="bg-blue-50 dark:bg-blue-950/20 hover:bg-blue-600 hover:text-white border border-blue-500/20 text-blue-600 dark:text-blue-400 text-xs font-bold px-3 py-1.5 rounded-lg transition-all shrink-0">Unduh</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- PANEL: JADWAL & UJIAN -->
            <div id="panel-jadwal" class="role-panel hidden space-y-6">
                <div class="space-y-1">
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">Jadwal Kelas &amp; Ujian Evaluasi</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-xs">Ikuti kelas dan kerjakan evaluasi kompetensi skema Anda.</p>
                </div>

                <!-- Ujian Evaluasi -->
                <div class="space-y-4">
                    <h3 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider">Ujian CBT Tersedia</h3>
                    @if($schemes->isEmpty())
                        <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-10 text-center text-slate-400 shadow-sm">
                            Belum ada ujian evaluasi aktif yang terbit.
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            @foreach($schemes as $scheme)
                                @php
                                    $attempt = $attempts[$scheme->id] ?? null;
                                    $isDone = $attempt && $attempt->status === 'completed';
                                    $isInProgress = $attempt && $attempt->status === 'in_progress';
                                @endphp
                                <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 flex flex-col gap-4 shadow-sm">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="font-extrabold text-sm text-slate-800 dark:text-white leading-tight">{{ $scheme->title }}</h4>
                                            <p class="text-slate-400 text-[11px] mt-1">{{ $scheme->description }}</p>
                                        </div>
                                        @if($isDone)
                                            <span class="bg-blue-50 text-blue-600 border border-blue-500/20 px-2.5 py-0.5 rounded-full text-[9px] font-black uppercase">
                                                Nilai: {{ $attempt->score }}%
                                            </span>
                                        @endif
                                    </div>
                                    <div class="flex gap-2">
                                        @if($isDone)
                                            <a href="{{ route('asesi.result', $attempt->id) }}" class="flex-1 text-center bg-white hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-800 dark:text-white font-extrabold text-xs uppercase py-2.5 rounded-xl transition-all">Lihat Hasil</a>
                                        @elseif($isInProgress)
                                            <a href="{{ route('asesi.exam.start', $scheme->id) }}" class="flex-1 text-center bg-amber-500 hover:bg-amber-600 text-white font-extrabold text-xs uppercase py-2.5 rounded-xl transition-all">Lanjutkan Ujian</a>
                                        @else
                                            <a href="{{ route('asesi.exam.start', $scheme->id) }}" class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs uppercase py-2.5 rounded-xl transition-all shadow-md shadow-blue-500/10">Mulai Ujian</a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Kehadiran Kelas -->
                <div class="space-y-4 pt-4">
                    <h3 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider">Presensi Kehadiran Kelas</h3>
                    <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm">
                        <div class="overflow-x-auto w-full">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-slate-100 dark:border-slate-800 text-slate-400 text-[10px] uppercase font-extrabold">
                                        <th class="px-5 py-3 text-left">Topik Kelas</th>
                                        <th class="px-5 py-3 text-left">Pengajar</th>
                                        <th class="px-5 py-3 text-left">Waktu</th>
                                        <th class="px-5 py-3 text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                    @forelse($schedules as $sch)
                                        <tr>
                                            <td class="px-5 py-4">
                                                <div class="font-bold text-slate-800 dark:text-white">{{ $sch->trainingProgram?->title }}</div>
                                                <div class="text-slate-400 text-xs mt-0.5">{{ $sch->topic }}</div>
                                            </td>
                                            <td class="px-5 py-4 text-slate-600 dark:text-slate-300 text-xs">{{ $sch->instructor?->name ?? '-' }}</td>
                                            <td class="px-5 py-4 text-slate-600 dark:text-slate-300 text-xs font-mono">{{ $sch->scheduled_at->format('d M Y H:i') }} WIB</td>
                                            <td class="px-5 py-4 text-center">
                                                <div id="attendance-status-{{ $sch->id }}">
                                                    @if(isset($attendances[$sch->id]))
                                                        <span class="bg-blue-50 text-blue-600 border border-blue-500/20 px-3 py-1.5 rounded-lg text-xs font-bold uppercase dark:bg-blue-950/20 dark:text-blue-400">✓ Hadir</span>
                                                    @else
                                                        <button type="button" onclick="recordServerAttendance('{{ $sch->id }}')" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-[10px] uppercase px-4 py-1.5 rounded-lg transition-all shadow-md shadow-blue-500/10">Presensi</button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="4" class="px-5 py-8 text-center text-slate-400">Belum ada jadwal kelas terdaftar.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PANEL: SERTIFIKAT DIGITAL -->
            <div id="panel-sertifikat" class="role-panel hidden space-y-6">
                <div class="space-y-1">
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">E-Sertifikat Kelulusan</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-xs">Unduh sertifikat kelulusan resmi kompetensi Manajemen Pendidikan Indonesia Anda.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($enrollments as $enr)
                        <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 flex flex-col justify-between gap-4 shadow-sm relative overflow-hidden">
                            @if($enr->status === 'LULUS')
                                <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-blue-500/5 rounded-full"></div>
                            @endif
                            <div>
                                <div class="flex justify-between items-start gap-2">
                                    <h3 class="font-bold text-slate-800 dark:text-white text-sm">{{ $enr->trainingProgram?->title }}</h3>
                                    @if($enr->status === 'LULUS')
                                        <span class="bg-blue-55/20 text-blue-600 border border-blue-500/20 px-2 py-0.5 rounded-full text-[9px] font-black uppercase shrink-0">LULUS</span>
                                    @else
                                        <span class="bg-white text-slate-500 dark:text-slate-400 border border-slate-200 dark:bg-slate-800 dark:border-slate-700 px-2 py-0.5 rounded-full text-[9px] font-black uppercase shrink-0">DIKLAT AKTIF</span>
                                    @endif
                                </div>
                                <p class="text-slate-400 text-xs mt-2 font-mono">NIK: {{ $enr->nik }}</p>
                            </div>

                            <div class="border-t border-slate-100 dark:border-slate-800/80 pt-4 flex items-center justify-between">
                                @if($enr->status === 'LULUS')
                                    <div>
                                        <div class="text-[9px] text-slate-400 uppercase font-extrabold">Nomor Sertifikat</div>
                                        <div class="text-xs font-mono font-bold text-slate-800 dark:text-slate-100">{{ $enr->certificate_number }}</div>
                                    </div>
                                    <a href="{{ route('asesi.certificate.download', $enr->id) }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-[10px] uppercase px-4 py-2 rounded-xl transition-all shadow-md shadow-blue-500/10">Unduh PDF</a>
                                @else
                                    <span class="text-slate-400 text-xs italic">Sertifikat terbit setelah dinyatakan kompeten</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-12 text-center shadow-sm md:col-span-2">
                            <p class="text-slate-400 text-sm">Belum ada riwayat diklat.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </main>
    </div>

    <!-- SCRIPTS -->
    <script>
        const panels = ['dasbor', 'profil', 'portofolio', 'skema', 'jadwal', 'sertifikat'];
        
        function updateDocumentTitle(panelId) {
            let sectionTitle = "";
            switch(panelId) {
                case 'dasbor': sectionTitle = "Dasbor Asesi"; break;
                case 'profil': sectionTitle = "Profil & Dokumen"; break;
                case 'portofolio': sectionTitle = "Portofolio APL-02"; break;
                case 'skema': sectionTitle = "Skema Pelatihan"; break;
                case 'jadwal': sectionTitle = "Jadwal & Ujian"; break;
                case 'sertifikat': sectionTitle = "E-Sertifikat"; break;
                default: sectionTitle = "Dasbor";
            }
            const siteName = "{{ $siteName }}";
            document.title = `${sectionTitle} — Asesi — ${siteName}`;
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

            localStorage.setItem('asesi_active_panel', id);
            
            updateDocumentTitle(id);
            
            // Auto close sidebar on mobile after clicking link
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

        function updateThemeUI() {
            const icon = document.getElementById('theme-icon');
            const label = document.getElementById('theme-label');
            const isDark = document.documentElement.classList.contains('dark');
            if (icon) icon.textContent = isDark ? '🌙' : '☀️';
            if (label) label.textContent = isDark ? 'Mode Gelap' : 'Mode Terang';
        }

        function recordServerAttendance(id) {
            fetch("{{ route('asesi.attendance.record') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ class_schedule_id: id })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    updateAttendanceUI(id);
                    alert(data.message);
                } else {
                    alert("Gagal mencatat presensi.");
                }
            })
            .catch(err => {
                console.error(err);
                alert("Terjadi kesalahan jaringan.");
            });
        }

        function updateAttendanceUI(id) {
            const container = document.getElementById('attendance-status-' + id);
            if (container) {
                container.innerHTML = '<span class="bg-blue-50 text-blue-600 border border-blue-500/20 px-3 py-1.5 rounded-lg text-xs font-bold uppercase dark:bg-blue-950/20 dark:text-blue-400">✓ Hadir</span>';
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
    </script>

    @include('layouts.partials.live_refresh', [
        'statsUrl' => route('asesi.stats'),
        'statMap'  => [
            'stat-schemes'  => 'schemes',
            'stat-attempts' => 'attempts',
            'stat-lulus'    => 'lulus',
        ]
    ])
</body>
</html>
