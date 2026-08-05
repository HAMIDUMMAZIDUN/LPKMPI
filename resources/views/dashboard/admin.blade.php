<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin LPK — LPK MPI</title>
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
        @media (max-width: 768px) {
            #sidebar {
                transform: translateX(-100%);
            }
            #sidebar.open {
                transform: translateX(0);
            }
        }
    </style>
</head>
<body class="min-h-screen bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 transition-colors duration-300 flex">

    <!-- SIDEBAR -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 bg-white dark:bg-slate-950 border-r border-slate-200 dark:border-slate-800 flex flex-col justify-between shrink-0 overflow-y-auto">
        <div>
            <!-- Sidebar Header -->
            <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800/80 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-blue-600 flex items-center justify-center text-white font-extrabold shadow-md shadow-blue-600/10">
                        🏛️
                    </div>
                    <div>
                        <div class="font-extrabold text-sm text-slate-900 dark:text-white tracking-tight">LPK MPI</div>
                        <div class="text-[10px] text-blue-600 font-bold tracking-widest uppercase">Sekretariat</div>
                    </div>
                </div>
                <button onclick="toggleSidebar()" class="md:hidden text-slate-500 hover:text-slate-800 dark:hover:text-slate-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="p-4 space-y-1" id="sidebar-nav">

                <!-- Dasbor (standalone) -->
                <button onclick="showPanel('dasbor')" id="btn-dasbor" class="sidebar-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all text-left">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"/></svg>
                    <span>Dasbor</span>
                </button>

                <!-- Accordion: Manajemen Peserta -->
                <div class="accordion-group">
                    <button class="accordion-trigger w-full flex items-center justify-between gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all text-left" onclick="toggleAccordion(this)">
                        <span class="flex items-center gap-3">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Manajemen Peserta</span>
                        </span>
                        <svg class="accordion-arrow w-4 h-4 shrink-0 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="accordion-content hidden pl-4 mt-1 space-y-1 border-l-2 border-blue-100 dark:border-blue-900 ml-6">
                        <button onclick="showPanel('verifikasi')" id="btn-verifikasi" class="sidebar-btn w-full flex items-center gap-2 px-3 py-2.5 rounded-lg text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all text-left">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            Verifikasi Pendaftaran
                        </button>
                        <button onclick="showPanel('plotting')" id="btn-plotting" class="sidebar-btn w-full flex items-center gap-2 px-3 py-2.5 rounded-lg text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all text-left">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            Plotting & Skema
                        </button>
                    </div>
                </div>

                <!-- Accordion: Administrasi & Data -->
                <div class="accordion-group">
                    <button class="accordion-trigger w-full flex items-center justify-between gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all text-left" onclick="toggleAccordion(this)">
                        <span class="flex items-center gap-3">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span>Administrasi & Data</span>
                        </span>
                        <svg class="accordion-arrow w-4 h-4 shrink-0 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="accordion-content hidden pl-4 mt-1 space-y-1 border-l-2 border-blue-100 dark:border-blue-900 ml-6">
                        <button onclick="showPanel('sertifikat')" id="btn-sertifikat" class="sidebar-btn w-full flex items-center gap-2 px-3 py-2.5 rounded-lg text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all text-left">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            Penerbitan Sertifikat
                        </button>
                        <button onclick="showPanel('users')" id="btn-users" class="sidebar-btn w-full flex items-center gap-2 px-3 py-2.5 rounded-lg text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all text-left">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            Kelola Pengguna
                        </button>
                        <button onclick="showPanel('programs-db')" id="btn-programs-db" class="sidebar-btn w-full flex items-center gap-2 px-3 py-2.5 rounded-lg text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all text-left">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            Data Program Pelatihan
                        </button>
                        <button onclick="showPanel('trainees-db')" id="btn-trainees-db" class="sidebar-btn w-full flex items-center gap-2 px-3 py-2.5 rounded-lg text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all text-left">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            Data Pendaftaran Peserta
                        </button>
                        <button onclick="showPanel('chats')" id="btn-chats" class="sidebar-btn w-full flex items-center gap-2 px-3 py-2.5 rounded-lg text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all text-left">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            Live Chat Bantuan
                        </button>
                    </div>
                </div>

                <!-- Accordion: CMS Landing Page -->
                <div class="accordion-group">
                    <button class="accordion-trigger w-full flex items-center justify-between gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all text-left" onclick="toggleAccordion(this)">
                        <span class="flex items-center gap-3">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 4a2 2 0 012 2v6a2 2 0 01-2 2h-2m-4-6l3-3m0 0l3 3m-3-3v12"/></svg>
                            <span>CMS Landing Page</span>
                        </span>
                        <svg class="accordion-arrow w-4 h-4 shrink-0 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="accordion-content hidden pl-4 mt-1 space-y-1 border-l-2 border-blue-100 dark:border-blue-900 ml-6">
                        <button onclick="showPanel('program')" id="btn-program" class="sidebar-btn w-full flex items-center gap-2 px-3 py-2.5 rounded-lg text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all text-left">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            Program Pelatihan
                        </button>
                        <button onclick="showPanel('jadwal')" id="btn-jadwal" class="sidebar-btn w-full flex items-center gap-2 px-3 py-2.5 rounded-lg text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all text-left">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            Jadwal Pelatihan
                        </button>
                        <button onclick="showPanel('fasilitas')" id="btn-fasilitas" class="sidebar-btn w-full flex items-center gap-2 px-3 py-2.5 rounded-lg text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all text-left">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            Fasilitas LPK
                        </button>
                        <button onclick="showPanel('articles')" id="btn-articles" class="sidebar-btn w-full flex items-center gap-2 px-3 py-2.5 rounded-lg text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all text-left">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            Kabar & Artikel
                        </button>
                    </div>
                </div>

                <!-- Profil (standalone) -->
                <button onclick="showPanel('profil')" id="btn-profil" class="sidebar-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all text-left">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                    <span>Pengaturan Profil</span>
                </button>
            </nav>
        </div>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-slate-100 dark:border-slate-800">
            <button onclick="toggleTheme()" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 transition-all text-left">
                <span id="theme-icon">🌙</span>
                <span id="theme-label">Mode Gelap</span>
            </button>

            <a href="{{ route('home') }}" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-slate-800 dark:hover:text-slate-200 transition-all text-left">
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
    <div class="flex-1 flex flex-col min-w-0 overflow-x-hidden md:pl-[260px]">

        <!-- TOPBAR -->
        <header class="h-16 bg-white dark:bg-slate-950 border-b border-slate-200 dark:border-slate-800 px-6 flex items-center justify-between sticky top-0 z-30">
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()" class="md:hidden text-slate-500 hover:text-slate-800 dark:hover:text-slate-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <span class="text-xs font-black uppercase tracking-widest text-blue-600 block">ADMINISTRATOR LPK MPI</span>
            </div>

            <!-- Profile & Notifications -->
            <div class="flex items-center gap-4">
                <!-- Export CSV Button -->
                <a href="{{ route('admin.report') }}" class="hidden sm:inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs uppercase px-4 py-2 rounded-xl transition-all shadow-md shadow-blue-500/10">
                    📥 Ekspor CSV
                </a>
                
                <div class="relative cursor-pointer text-slate-500 hover:text-slate-800 dark:hover:text-slate-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    <span class="absolute top-0 right-0 w-2.5 h-2.5 bg-blue-500 rounded-full ring-2 ring-white dark:ring-slate-900"></span>
                </div>

                <div class="flex items-center gap-3 pl-3 border-l border-slate-200 dark:border-slate-800">
                    <div class="text-right hidden sm:block">
                        <div class="text-xs font-bold text-slate-800 dark:text-slate-200">{{ auth()->user()->name }}</div>
                        <div class="text-[9px] font-bold text-slate-400 uppercase">Sekretariat LPK</div>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-bold shadow-md shadow-blue-500/10">
                        AD
                    </div>
                </div>
            </div>
        </header>

        <!-- MAIN AREA -->
        <main class="flex-1 p-6 max-w-6xl mx-auto w-full space-y-6">

            @if(session('success'))
                <div class="p-4 bg-blue-500/10 border border-blue-500/20 text-blue-600 dark:text-blue-400 rounded-xl text-sm flex items-center gap-3 shadow-sm animate-fade-in">
                    <span>✓</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 bg-rose-500/10 border border-rose-500/20 text-rose-600 dark:text-rose-400 rounded-xl text-sm flex items-center gap-3 shadow-sm animate-fade-in">
                    <span>✗</span>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- PANEL: DASBOR -->
            <div id="panel-dasbor" class="role-panel space-y-6">
                <!-- Summary Widgets -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-950/20 text-blue-600 flex items-center justify-center text-2xl">👥</div>
                        <div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Pendaftar (Bulan Ini)</div>
                            <div class="text-2xl font-black text-slate-850 dark:text-white mt-1">{{ $traineesCount }}</div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-amber-50 dark:bg-amber-950/20 text-amber-600 flex items-center justify-center text-2xl">📝</div>
                        <div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Menunggu Verifikasi (APL-01)</div>
                            <div class="text-2xl font-black text-slate-850 dark:text-white mt-1">{{ $trainees->where('payment_status', '!=', 'PAID')->count() }}</div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-950/20 text-blue-600 flex items-center justify-center text-2xl">🎓</div>
                        <div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Sertifikat Siap Cetak</div>
                            <div class="text-2xl font-black text-slate-850 dark:text-white mt-1">{{ $certCount }}</div>
                        </div>
                    </div>
                </div>

                <!-- Schedule Card & Quick Actions -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                    <div class="md:col-span-8 bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm space-y-4">
                        <h3 class="font-extrabold text-sm text-slate-800 dark:text-white uppercase tracking-wider">Jadwal Ujian &amp; Pelatihan Hari Ini</h3>
                        <div class="divide-y divide-slate-100 dark:divide-slate-800/80">
                            <div class="py-3 flex items-center justify-between text-xs">
                                <div>
                                    <div class="font-bold text-slate-800 dark:text-white">Ujian CBT - Administrasi Sekolah</div>
                                    <div class="text-slate-400 mt-0.5">Asesor: Dr. H. Ahmad Fauzi</div>
                                </div>
                                <span class="bg-blue-50 text-blue-600 border border-blue-500/20 px-2 py-0.5 rounded-full font-bold">09:00 WIB</span>
                            </div>
                            <div class="py-3 flex items-center justify-between text-xs">
                                <div>
                                    <div class="font-bold text-slate-800 dark:text-white">Kelas Diklat Keuangan Syariah</div>
                                    <div class="text-slate-400 mt-0.5">Instruktur: M. Sobirin, M.E.I</div>
                                </div>
                                <span class="bg-blue-50 text-blue-600 border border-blue-500/20 px-2 py-0.5 rounded-full font-bold">13:30 WIB</span>
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-4 bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm flex flex-col justify-between gap-4">
                        <div class="space-y-1">
                            <span class="text-[10px] font-bold text-blue-600 uppercase tracking-widest block font-bold">AKSI CEPAT</span>
                            <h3 class="text-sm font-bold text-slate-800 dark:text-white">Data Laporan Excel</h3>
                        </div>
                        <a href="{{ route('admin.report') }}" class="w-full block text-center bg-blue-650 hover:bg-blue-700 text-white font-extrabold text-xs uppercase py-3.5 rounded-xl transition-all shadow-md shadow-blue-500/10">
                            Ekspor Data Pendaftar
                        </a>
                    </div>
                          <!-- PANEL: VERIFIKASI PENDAFTARAN -->
            <div id="panel-verifikasi" class="role-panel hidden space-y-6">
                <div class="space-y-1">
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">Verifikasi Berkas &amp; Pembayaran Asesi</h2>
                    <p class="text-slate-500 text-xs">Verifikasi pembayaran dan berkas data pendaftaran (APL-01) asesi.</p>
                </div>

                <!-- Form Edit Peserta -->
                <div id="form-edit-trainee" class="hidden bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm space-y-4">
                    <h3 class="font-extrabold text-sm text-slate-800 dark:text-white uppercase tracking-wider">Edit Data Peserta</h3>
                    <form id="edit-trainee-form-action" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Nama Lengkap</label>
                                <input type="text" name="name" id="edit-trainee-name" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">NIK (Nomor Induk Kependudukan)</label>
                                <input type="text" name="nik" id="edit-trainee-nik" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-mono">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Email</label>
                                <input type="email" name="email" id="edit-trainee-email" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">No. Handphone / WhatsApp</label>
                                <input type="text" name="phone" id="edit-trainee-phone" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-mono">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Status Pendaftaran</label>
                                <select name="status" id="edit-trainee-status" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                                    <option value="MENUNGGU UJIAN">Menunggu Ujian / Kelulusan</option>
                                    <option value="LULUS">Lulus (Kompeten)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Status Pembayaran</label>
                                <select name="payment_status" id="edit-trainee-payment-status" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                                    <option value="UNPAID">Belum Lunas</option>
                                    <option value="PAID">Lunas</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <button type="button" onclick="cancelEditTrainee()" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase px-4 py-2.5 rounded-xl">Batal</button>
                            <button type="submit" class="bg-blue-650 hover:bg-blue-700 text-white font-extrabold text-xs uppercase px-6 py-3 rounded-xl shadow-md shadow-blue-500/10">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>

                <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm">
                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-slate-100 dark:border-slate-800 text-slate-400 text-[10px] uppercase font-extrabold">
                                    <th class="px-5 py-3 text-left">Nama</th>
                                    <th class="px-5 py-3 text-left">Skema / Program</th>
                                    <th class="px-5 py-3 text-left">Tanggal Daftar</th>
                                    <th class="px-5 py-3 text-left">Status Dokumen</th>
                                    <th class="px-5 py-3 text-left">Verifikasi Pembayaran</th>
                                    <th class="px-5 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @forelse($trainees as $t)
                                    <tr>
                                        <td class="px-5 py-4">
                                            <div class="font-bold text-slate-850 dark:text-white">{{ $t->name }}</div>
                                            <div class="text-slate-455 text-xs font-mono mt-0.5">NIK: {{ $t->nik }}</div>
                                        </td>
                                        <td class="px-5 py-4 text-xs font-bold text-slate-705 dark:text-slate-300">
                                            {{ $t->trainingProgram?->title ?? '-' }}
                                        </td>
                                        <td class="px-5 py-4 text-xs text-slate-500 font-mono">
                                            {{ $t->created_at->format('d M Y') }}
                                        </td>
                                        <td class="px-5 py-4 text-xs">
                                            <span class="bg-blue-50 text-blue-600 border border-blue-500/20 px-2 py-0.5 rounded-full font-bold uppercase text-[9px]">Lengkap</span>
                                        </td>
                                        <td class="px-5 py-4">
                                            <div class="flex items-center gap-2">
                                                @if($t->payment_status !== 'PAID')
                                                    <form action="{{ route('admin.trainees.verify-payment', $t->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="bg-blue-650 hover:bg-blue-700 text-white font-extrabold text-[10px] uppercase px-3 py-1.5 rounded-lg transition-all shadow-md shadow-blue-500/10">Verifikasi</button>
                                                    </form>
                                                @else
                                                    <span class="bg-blue-50 text-blue-600 border border-blue-500/20 px-2.5 py-1 rounded-lg text-xs font-extrabold uppercase">✓ Lunas</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-5 py-4">
                                            <div class="flex items-center justify-center gap-2">
                                                <button type="button" onclick='editTrainee({!! json_encode($t) !!})' class="text-blue-600 hover:text-blue-800 font-bold uppercase text-[10px]">Edit</button>
                                                <form action="{{ route('admin.trainees.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pendaftaran ini?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-rose-600 hover:text-rose-800 font-bold uppercase text-[10px]">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="px-5 py-8 text-center text-slate-500">Belum ada asesi mendaftar.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- PANEL: PLOTTING & SKEMA -->
            <div id="panel-plotting" class="role-panel hidden space-y-6">
                <div class="space-y-1">
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">Plotting &amp; Distribusi Asesor</h2>
                    <p class="text-slate-500 text-xs">Tugaskan skema ujian kompetensi ke penilai (Asesor).</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Form Penugasan -->
                    <div class="md:col-span-1 bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm space-y-4">
                        <h3 class="font-extrabold text-sm text-slate-800 dark:text-white uppercase tracking-wider">Form Plotting</h3>
                        <form action="{{ route('admin.scheme.assign') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Skema Pelatihan</label>
                                <select name="scheme_id" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-950 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                                    @foreach($schemes as $s)
                                        <option value="{{ $s->id }}">{{ $s->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Asesor Penilai</label>
                                <select name="asesor_id" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-950 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                                    @foreach($asetors as $a)
                                        <option value="{{ $a->id }}">{{ $a->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs uppercase py-3 rounded-xl transition-all shadow-md shadow-blue-500/10">Tugaskan Asesor</button>
                        </form>
                    </div>

                    <!-- Daftar Penugasan -->
                    <div class="md:col-span-2 bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm">
                        <div class="overflow-x-auto w-full">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="border-b border-slate-100 dark:border-slate-800 text-slate-400 text-[10px] uppercase font-extrabold">
                                        <th class="px-5 py-3 text-left">Skema</th>
                                        <th class="px-5 py-3 text-left">Asesor</th>
                                        <th class="px-5 py-3 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                    @forelse($assignments as $asg)
                                        <tr>
                                            <td class="px-5 py-4 font-bold text-slate-800 dark:text-white text-xs">{{ $asg->scheme?->title ?? '-' }}</td>
                                            <td class="px-5 py-4 text-xs text-slate-650 dark:text-slate-300 font-semibold">{{ $asg->asesor?->name ?? '-' }}</td>
                                            <td class="px-5 py-4 text-center">
                                                <form action="{{ route('admin.scheme.revoke', $asg->id) }}" method="POST">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-rose-600 hover:text-rose-800 font-bold text-xs uppercase">Batal</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="3" class="px-5 py-8 text-center text-slate-500">Belum ada plotting asesor.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PANEL: PENERBITAN SERTIFIKAT -->
            <div id="panel-sertifikat" class="role-panel hidden space-y-6">
                <div class="space-y-1">
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">Penerbitan Sertifikat Kelulusan</h2>
                    <p class="text-slate-500 text-xs">Konfirmasi kelulusan asesi dan terbitkan nomor sertifikat resmi.</p>
                </div>

                <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm">
                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-slate-100 dark:border-slate-800 text-slate-400 text-[10px] uppercase font-extrabold">
                                    <th class="px-5 py-3 text-left">Nama</th>
                                    <th class="px-5 py-3 text-left">Program</th>
                                    <th class="px-5 py-3 text-left">No. Sertifikat</th>
                                    <th class="px-5 py-3 text-center">Terbitkan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @forelse($trainees as $t)
                                    <tr>
                                        <td class="px-5 py-4 font-bold text-slate-850 dark:text-white">{{ $t->name }}</td>
                                        <td class="px-5 py-4 text-xs text-slate-650 dark:text-slate-300 font-semibold">{{ $t->trainingProgram?->title ?? '-' }}</td>
                                        <td class="px-5 py-4 text-xs font-mono font-bold text-blue-600 dark:text-blue-400">{{ $t->certificate_number ?? 'Belum Terbit' }}</td>
                                        <td class="px-5 py-4 text-center">
                                            @if($t->status !== 'LULUS')
                                                <form action="{{ route('admin.trainees.approve', $t->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-[10px] uppercase px-3 py-1.5 rounded-lg transition-all shadow-md shadow-blue-500/10">Terbitkan</button>
                                                </form>
                                            @else
                                                <span class="bg-blue-50 text-blue-600 border border-blue-500/20 px-2 py-0.5 rounded-full font-bold uppercase text-[9px]">Selesai</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="px-5 py-8 text-center text-slate-500">Belum ada data asesi.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- PANEL: KELOLA PENGGUNA & ARTIKEL -->
            <div id="panel-users" class="role-panel hidden space-y-6">
                <!-- User Forms -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Form Asesi -->
                    <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm space-y-4">
                        <h3 class="font-extrabold text-sm text-slate-800 dark:text-white uppercase tracking-wider">Registrasi Akun Asesi Baru</h3>
                        <form action="{{ route('admin.asesi.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Nama Asesi / Username</label>
                                <input type="text" name="username" required placeholder="Contoh: ahmad_faisal" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Email</label>
                                <input type="email" name="email" required placeholder="Contoh: asesi@gmail.com" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold font-mono">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Kata Sandi</label>
                                <input type="password" name="password" required placeholder="Minimal 6 karakter" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                            </div>
                            <button type="submit" class="w-full bg-blue-650 hover:bg-blue-700 text-white font-extrabold text-xs uppercase py-3 rounded-xl transition-all shadow-md shadow-blue-500/10">Daftarkan Asesi</button>
                        </form>
                    </div>

                    <!-- Form Asesor -->
                    <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm space-y-4">
                        <h3 class="font-extrabold text-sm text-slate-800 dark:text-white uppercase tracking-wider">Registrasi Akun Asesor Baru</h3>
                        <form action="{{ route('admin.asesor.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Nama Asesor / Username</label>
                                <input type="text" name="username" required placeholder="Contoh: prof_ahmad" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Email</label>
                                <input type="email" name="email" required placeholder="Contoh: asesor@gmail.com" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold font-mono">
                            </div>
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs uppercase py-3 rounded-xl transition-all shadow-md shadow-blue-500/10">Daftarkan Asesor</button>
                        </form>
                                    <!-- Form Edit User -->
                <div id="form-edit-user" class="hidden bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm space-y-4">
                    <h3 class="font-extrabold text-sm text-slate-800 dark:text-white uppercase tracking-wider">Edit Akun Pengguna</h3>
                    <form id="edit-user-form-action" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Username / Nama</label>
                                <input type="text" name="username" id="edit-user-username" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Email</label>
                                <input type="email" name="email" id="edit-user-email" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-mono font-semibold">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Password Baru (Kosongkan jika tidak diubah)</label>
                            <input type="password" name="password" placeholder="Minimal 6 karakter" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                        </div>
                        <div class="flex gap-3">
                            <button type="button" onclick="cancelEditUser()" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase px-4 py-2.5 rounded-xl">Batal</button>
                            <button type="submit" class="bg-blue-650 hover:bg-blue-700 text-white font-extrabold text-xs uppercase px-6 py-3 rounded-xl shadow-md shadow-blue-500/10 font-bold">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>

                <!-- Daftar Admin & Asesor & Asesi -->
                <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm space-y-4">
                    <h3 class="font-extrabold text-sm text-slate-800 dark:text-white uppercase tracking-wider">Daftar Akun Pengguna</h3>
                    <div class="space-y-2">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block mb-2">Asesor</span>
                        @foreach($asetors as $asesor)
                            <div class="flex items-center justify-between p-3 bg-white dark:bg-slate-950 rounded-xl border border-slate-200 dark:border-slate-800 text-xs">
                                <div>
                                    <div class="font-bold text-slate-800 dark:text-white">{{ $asesor->name }}</div>
                                    <div class="text-slate-400 font-mono">{{ $asesor->email }}</div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="bg-blue-50 text-blue-600 border border-blue-500/20 px-2 py-0.5 rounded font-bold uppercase text-[9px]">Asesor</span>
                                    <div class="flex items-center gap-2">
                                        <button type="button" onclick='showUserDetail({!! json_encode($asesor) !!})' class="text-[#155dfc] hover:underline font-bold uppercase text-[10px]">Detail</button>
                                        <button type="button" onclick='editUser({!! json_encode($asesor) !!})' class="text-blue-600 hover:text-blue-800 font-bold uppercase text-[10px]">Edit</button>
                                        <form action="{{ route('admin.user.destroy', $asesor->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-rose-600 hover:text-rose-800 font-bold uppercase text-[10px]">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block mt-4 mb-2">Asesi</span>
                        @foreach($asesis as $asesi)
                            <div class="flex items-center justify-between p-3 bg-white dark:bg-slate-950 rounded-xl border border-slate-200 dark:border-slate-800 text-xs">
                                <div>
                                    <div class="font-bold text-slate-800 dark:text-white">{{ $asesi->name }}</div>
                                    <div class="text-slate-400 font-mono">{{ $asesi->email }}</div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="bg-blue-50 text-blue-600 border border-blue-500/20 px-2 py-0.5 rounded font-bold uppercase text-[9px]">Asesi</span>
                                    <div class="flex items-center gap-2">
                                        <button type="button" onclick='showUserDetail({!! json_encode($asesi) !!})' class="text-[#155dfc] hover:underline font-bold uppercase text-[10px]">Detail</button>
                                        <button type="button" onclick='editUser({!! json_encode($asesi) !!})' class="text-blue-600 hover:text-blue-800 font-bold uppercase text-[10px]">Edit</button>
                                        <form action="{{ route('admin.user.destroy', $asesi->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-rose-600 hover:text-rose-800 font-bold uppercase text-[10px]">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- PANEL: KABAR & ARTIKEL -->
            <div id="panel-articles" class="role-panel hidden space-y-6">
                <!-- CMS Artikel Form -->
                <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm space-y-4">
                    <h3 class="font-extrabold text-sm text-slate-800 dark:text-white uppercase tracking-wider">Tulis Artikel / Kabar Terbaru LPK</h3>
                    <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Judul Artikel</label>
                            <input type="text" name="title" required placeholder="Contoh: Tips Sukses Ujian Kompetensi MPI" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Isi Artikel</label>
                            <textarea name="content" required rows="5" placeholder="Tulis isi berita/artikel lengkap di sini..." class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold"></textarea>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Gambar Cover (Opsional)</label>
                            <input type="file" name="image" class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                        <button type="submit" class="bg-blue-650 hover:bg-blue-700 text-white font-extrabold text-xs uppercase px-6 py-3 rounded-xl transition-all shadow-md shadow-blue-500/10">Terbitkan Artikel</button>
                    </form>
                </div>

                <!-- Form Edit Artikel -->
                <div id="form-edit-article" class="hidden bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm space-y-4">
                    <h3 class="font-extrabold text-sm text-slate-800 dark:text-white uppercase tracking-wider">Edit Artikel</h3>
                    <form id="edit-article-form-action" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Judul Artikel</label>
                            <input type="text" name="title" id="edit-article-title" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Konten / Isi Artikel</label>
                            <textarea name="content" id="edit-article-content" rows="6" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold"></textarea>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Gambar Cover Baru (Opsional)</label>
                            <input type="file" name="image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                        <div class="flex justify-end gap-3">
                            <button type="button" onclick="cancelEditArticle()" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase px-4 py-2.5 rounded-xl">Batal</button>
                            <button type="submit" class="bg-blue-650 hover:bg-blue-700 text-white font-extrabold text-xs uppercase px-6 py-3 rounded-xl shadow-md shadow-blue-500/10 font-bold">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>

                <!-- Daftar Artikel Aktif -->
                <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm">
                    <h3 class="font-extrabold text-sm text-slate-800 dark:text-white uppercase tracking-wider mb-4">Daftar Artikel Aktif</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($articles as $art)
                            <div class="bg-white dark:bg-slate-950 rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 flex flex-col justify-between p-4">
                                <div class="space-y-2">
                                    <h4 class="font-bold text-slate-850 dark:text-white text-xs">{{ $art->title }}</h4>
                                    <p class="text-slate-500 text-[11px] line-clamp-2">{{ Str::limit(strip_tags($art->content), 80) }}</p>
                                </div>
                                <div class="flex items-center justify-between border-t border-slate-200/55 dark:border-slate-800/80 pt-3 mt-3">
                                    <span class="text-[10px] text-slate-400 font-mono">{{ $art->created_at->format('d M Y') }}</span>
                                    <div class="flex items-center gap-2">
                                        <button onclick='editArticle({!! json_encode($art) !!})' class="text-blue-600 hover:text-blue-850 text-[10px] font-bold uppercase font-bold">Edit</button>
                                        <form action="{{ route('admin.articles.destroy', $art->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-rose-600 hover:text-rose-800 text-[10px] font-bold uppercase font-bold">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-slate-500 text-xs py-4 font-semibold">Belum ada artikel diterbitkan.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- PANEL: PROGRAM PELATIHAN (CMS) -->
            <div id="panel-program" class="role-panel hidden space-y-6">
                <div class="space-y-1">
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">CMS Program Pelatihan</h2>
                    <p class="text-slate-500 text-xs">Ubah judul, harga, durasi, dan materi program pelatihan yang tampil di halaman depan.</p>
                </div>
                <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="active_panel" value="panel-program">
                    @foreach([
                        ['key'=>'manajemen','label'=>'Program Management Yayasan/Pesantren'],
                        ['key'=>'administrasi','label'=>'Program Administrasi Sekolah Islam'],
                        ['key'=>'kepemimpinan','label'=>'Program Kepemimpinan Kepala Sekolah'],
                    ] as $prog)
                        <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 space-y-4 shadow-sm">
                            <h3 class="font-extrabold text-sm text-slate-850 dark:text-white border-b border-slate-100 dark:border-slate-800 pb-2 uppercase tracking-wider">{{ $prog['label'] }}</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Judul Program</label>
                                    <input type="text" name="prog_{{ $prog['key'] }}_title" value="{{ $settings['prog_'.$prog['key'].'_title'] ?? $prog['label'] }}" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Durasi</label>
                                        <input type="text" name="prog_{{ $prog['key'] }}_durasi" value="{{ $settings['prog_'.$prog['key'].'_durasi'] ?? '' }}" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Harga</label>
                                        <input type="text" name="prog_{{ $prog['key'] }}_harga" value="{{ $settings['prog_'.$prog['key'].'_harga'] ?? '' }}" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Deskripsi</label>
                                <textarea name="prog_{{ $prog['key'] }}_desc" rows="3" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 resize-none">{{ $settings['prog_'.$prog['key'].'_desc'] ?? '' }}</textarea>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Materi Silabus</label>
                                <textarea name="prog_{{ $prog['key'] }}_silabus" rows="3" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 resize-none">{{ $settings['prog_'.$prog['key'].'_silabus'] ?? '' }}</textarea>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Prospek Karir / Output</label>
                                <textarea name="prog_{{ $prog['key'] }}_prospek" rows="2" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 resize-none">{{ $settings['prog_'.$prog['key'].'_prospek'] ?? '' }}</textarea>
                            </div>
                        </div>
                    @endforeach
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs uppercase px-8 py-3 rounded-xl shadow-md shadow-blue-500/10 font-bold">Simpan Program Pelatihan</button>
                    </div>
                </form>
            </div>

            <!-- PANEL: JADWAL DIKLAT (CMS) -->
            <div id="panel-jadwal" class="role-panel hidden space-y-6">
                <div class="space-y-1">
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">CMS Jadwal Pelatihan</h2>
                    <p class="text-slate-500 text-xs">Atur jadwal pelatihan terdekat, kuota, dan metode pelaksanaan yang tampil di halaman depan.</p>
                </div>
                <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="active_panel" value="panel-jadwal">
                    @for($i = 1; $i <= 3; $i++)
                        <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 space-y-4 shadow-sm">
                            <h3 class="font-extrabold text-sm text-slate-850 dark:text-white uppercase tracking-wider border-b border-slate-100 dark:border-slate-800 pb-2">Jadwal #{{ $i }}</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Nama Pelatihan</label>
                                    <input type="text" name="jadwal_{{ $i }}_nama" value="{{ $settings['jadwal_'.$i.'_nama'] ?? '' }}" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Batas Pendaftaran</label>
                                    <input type="text" name="jadwal_{{ $i }}_batas" value="{{ $settings['jadwal_'.$i.'_batas'] ?? '' }}" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Waktu Pelaksanaan</label>
                                    <input type="text" name="jadwal_{{ $i }}_waktu" value="{{ $settings['jadwal_'.$i.'_waktu'] ?? '' }}" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Metode Pelaksanaan</label>
                                    <input type="text" name="jadwal_{{ $i }}_metode" value="{{ $settings['jadwal_'.$i.'_metode'] ?? '' }}" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Status Kuota / Batas</label>
                                    <input type="text" name="jadwal_{{ $i }}_quota" value="{{ $settings['jadwal_'.$i.'_quota'] ?? '' }}" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                                </div>
                            </div>
                        </div>
                    @endfor
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs uppercase px-8 py-3 rounded-xl shadow-md shadow-blue-500/10 font-bold">Simpan Jadwal Diklat</button>
                    </div>
                </form>
            </div>

            <!-- PANEL: FASILITAS (CMS) -->
            <div id="panel-fasilitas" class="role-panel hidden space-y-6">
                <div class="space-y-1">
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">CMS Fasilitas LPK</h2>
                    <p class="text-slate-500 text-xs">Ubah rincian fasilitas belajar, perpustakaan, dan asrama yang tampil di halaman depan.</p>
                </div>
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <input type="hidden" name="active_panel" value="panel-fasilitas">
                    @foreach([
                        ['key'=>'belajar','label'=>'Ruang Belajar'],
                        ['key'=>'perpustakaan','label'=>'Perpustakaan'],
                        ['key'=>'asrama','label'=>'Asrama / Penginapan'],
                    ] as $fas)
                        <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 space-y-4 shadow-sm">
                            <h3 class="font-extrabold text-sm text-slate-850 dark:text-white border-b border-slate-100 dark:border-slate-800 pb-2 uppercase tracking-wider">{{ $fas['label'] }}</h3>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Judul Fasilitas</label>
                                <input type="text" name="fasilitas_{{ $fas['key'] }}_judul" value="{{ $settings['fasilitas_'.$fas['key'].'_judul'] ?? $fas['label'] }}" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Deskripsi</label>
                                <textarea name="fasilitas_{{ $fas['key'] }}_desc" rows="3" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 resize-none">{{ $settings['fasilitas_'.$fas['key'].'_desc'] ?? '' }}</textarea>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Foto</label>
                                @if(!empty($settings['fasilitas_'.$fas['key'].'_foto']))
                                    <img src="{{ asset('storage/' . $settings['fasilitas_'.$fas['key'].'_foto']) }}" class="max-w-xs h-auto object-cover rounded-xl border border-slate-200 dark:border-slate-800 mb-2">
                                @endif
                                <input type="file" name="fasilitas_{{ $fas['key'] }}_foto" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                        </div>
                    @endforeach
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs uppercase px-8 py-3 rounded-xl shadow-md shadow-blue-500/10 font-bold">Simpan Fasilitas</button>
                    </div>
                </form>
            </div>

            <!-- PANEL: DATA PROGRAM PELATIHAN (DATABASE CRUD) -->
            <div id="panel-programs-db" class="role-panel hidden space-y-6">
                <div class="flex items-center justify-between">
                    <div class="space-y-1">
                        <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">Data Program Pelatihan</h2>
                        <p class="text-slate-500 text-xs">Kelola data program pelatihan yang aktif di database.</p>
                    </div>
                    <button onclick="toggleAddProgramForm()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase px-4 py-2.5 rounded-xl shadow-md shadow-blue-500/10 font-bold">
                        + Tambah Program
                    </button>
                </div>

                <!-- Form Tambah Program -->
                <div id="form-add-program" class="hidden bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm space-y-4">
                    <h3 class="font-extrabold text-sm text-slate-800 dark:text-white uppercase tracking-wider">Program Pelatihan Baru</h3>
                    <form action="{{ route('admin.programs.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">ID / Slug Unik (misal: ssw_prog)</label>
                                <input type="text" name="id" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Judul Program</label>
                                <input type="text" name="title" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Kategori</label>
                                <input type="text" name="category" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Durasi</label>
                                <input type="text" name="duration" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Harga</label>
                                <input type="text" name="price" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Kata Kunci LSP (LSP Keyword)</label>
                                <input type="text" name="lsp_keyword" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Deskripsi</label>
                            <textarea name="description" required rows="3" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold"></textarea>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Manfaat / Fasilitas Tambahan (Pisahkan dengan koma)</label>
                            <input type="text" name="benefits" placeholder="Sertifikat LPK, Modul Pembelajaran, Konsultasi" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                        </div>
                        <div class="flex justify-end gap-3">
                            <button type="button" onclick="toggleAddProgramForm()" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase px-4 py-2.5 rounded-xl font-bold">Batal</button>
                            <button type="submit" class="bg-blue-650 hover:bg-blue-700 text-white font-extrabold text-xs uppercase px-6 py-3 rounded-xl transition-all shadow-md shadow-blue-500/10 font-bold">Simpan Program</button>
                        </div>
                    </form>
                </div>

                <!-- Form Edit Program -->
                <div id="form-edit-program" class="hidden bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm space-y-4">
                    <h3 class="font-extrabold text-sm text-slate-800 dark:text-white uppercase tracking-wider">Edit Program Pelatihan</h3>
                    <form id="edit-program-form-action" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">ID (Tidak Dapat Diubah)</label>
                                <input type="text" id="edit-program-id" disabled class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-450 font-bold font-mono">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Judul Program</label>
                                <input type="text" name="title" id="edit-program-title" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Kategori</label>
                                <input type="text" name="category" id="edit-program-category" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Durasi</label>
                                <input type="text" name="duration" id="edit-program-duration" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Harga</label>
                                <input type="text" name="price" id="edit-program-price" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Kata Kunci LSP (LSP Keyword)</label>
                                <input type="text" name="lsp_keyword" id="edit-program-lsp-keyword" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Deskripsi</label>
                            <textarea name="description" id="edit-program-description" required rows="3" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold"></textarea>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Manfaat / Fasilitas Tambahan (Pisahkan dengan koma)</label>
                            <input type="text" name="benefits" id="edit-program-benefits" placeholder="Sertifikat LPK, Modul Pembelajaran, Konsultasi" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                        </div>
                        <div class="flex justify-end gap-3">
                            <button type="button" onclick="cancelEditProgram()" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase px-4 py-2.5 rounded-xl font-bold">Batal</button>
                            <button type="submit" class="bg-blue-650 hover:bg-blue-700 text-white font-extrabold text-xs uppercase px-6 py-3 rounded-xl shadow-md shadow-blue-500/10 font-bold">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>

                <!-- Tabel List Program -->
                <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm">
                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 text-slate-400 text-[10px] uppercase font-extrabold">
                                    <th class="px-5 py-3 text-left">ID / Slug</th>
                                    <th class="px-5 py-3 text-left">Nama Program</th>
                                    <th class="px-5 py-3 text-left">Kategori</th>
                                    <th class="px-5 py-3 text-left">Durasi &amp; Harga</th>
                                    <th class="px-5 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-xs">
                                @forelse($programs as $prog)
                                    <tr>
                                        <td class="px-5 py-4 font-mono font-bold text-slate-500">{{ $prog->id }}</td>
                                        <td class="px-5 py-4 font-bold text-slate-800 dark:text-white">{{ $prog->title }}</td>
                                        <td class="px-5 py-4 text-slate-600 dark:text-slate-350">{{ $prog->category }}</td>
                                        <td class="px-5 py-4 text-slate-650 dark:text-slate-300">
                                            <div class="font-bold text-blue-600 dark:text-blue-400 font-bold">{{ $prog->price }}</div>
                                            <div class="text-[10px] text-slate-400 font-semibold">{{ $prog->duration }}</div>
                                        </td>
                                        <td class="px-5 py-4">
                                            <div class="flex items-center justify-center gap-2">
                                                <button onclick='editProgram({!! json_encode($prog) !!})' class="text-blue-600 hover:text-blue-800 font-bold uppercase text-[10px]">Edit</button>
                                                <form action="{{ route('admin.programs.destroy', $prog->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus program ini?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-rose-600 hover:text-rose-800 font-bold uppercase text-[10px]">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-5 py-8 text-center text-slate-500 font-semibold">Belum ada program pelatihan di database.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- PANEL: DATA PENDAFTARAN PESERTA (DATABASE CRUD) -->
            <div id="panel-trainees-db" class="role-panel hidden space-y-6">
                <div class="space-y-1">
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">Data Pendaftaran &amp; Peserta</h2>
                    <p class="text-slate-500 text-xs">Kelola status pembayaran, penerbitan sertifikat, dan data pendaftaran asesi.</p>
                </div>

                <!-- Form Edit Peserta -->
                <div id="form-edit-trainee" class="hidden bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm space-y-4">
                    <h3 class="font-extrabold text-sm text-slate-800 dark:text-white uppercase tracking-wider">Edit Data Peserta</h3>
                    <form id="edit-trainee-form-action" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Nama Lengkap</label>
                                <input type="text" name="name" id="edit-trainee-name" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">NIK (Nomor Induk Kependudukan)</label>
                                <input type="text" name="nik" id="edit-trainee-nik" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-mono font-semibold">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Email</label>
                                <input type="email" name="email" id="edit-trainee-email" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">No. Handphone / WhatsApp</label>
                                <input type="text" name="phone" id="edit-trainee-phone" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-mono font-semibold">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Status Pendaftaran</label>
                                <select name="status" id="edit-trainee-status" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                                    <option value="MENUNGGU UJIAN">Menunggu Ujian / Kelulusan</option>
                                    <option value="LULUS">Lulus (Kompeten)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Status Pembayaran</label>
                                <select name="payment_status" id="edit-trainee-payment-status" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                                    <option value="UNPAID">Belum Lunas</option>
                                    <option value="PAID">Lunas</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <button type="button" onclick="cancelEditTrainee()" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase px-4 py-2.5 rounded-xl font-bold">Batal</button>
                            <button type="submit" class="bg-blue-650 hover:bg-blue-700 text-white font-extrabold text-xs uppercase px-6 py-3 rounded-xl shadow-md shadow-blue-500/10 font-bold">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>

                <!-- Tabel List Pendaftaran -->
                <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm">
                    <div class="p-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                        <h3 class="font-extrabold text-sm text-slate-800 dark:text-white uppercase tracking-wider">Semua Pendaftaran</h3>
                        <input type="text" id="trainee-search" onkeyup="filterTrainees()" placeholder="Cari nama, NIK, atau program..." class="bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 w-64 font-semibold">
                    </div>
                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-sm" id="trainees-table">
                            <thead>
                                <tr class="border-b border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 text-slate-400 text-[10px] uppercase font-extrabold">
                                    <th class="px-5 py-3 text-left">Nama &amp; NIK</th>
                                    <th class="px-5 py-3 text-left">Kontak</th>
                                    <th class="px-5 py-3 text-left">Program</th>
                                    <th class="px-5 py-3 text-left">Pembayaran</th>
                                    <th class="px-5 py-3 text-left">Sertifikat / Status</th>
                                    <th class="px-5 py-3 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-xs">
                                @forelse($trainees as $t)
                                    <tr class="trainee-row">
                                        <td class="px-5 py-4">
                                            <div class="font-bold text-slate-800 dark:text-white trainee-name">{{ $t->name }}</div>
                                            <div class="text-[10px] text-slate-400 font-mono trainee-nik">NIK: {{ $t->nik }}</div>
                                        </td>
                                        <td class="px-5 py-4">
                                            <div class="text-slate-600 dark:text-slate-350 font-semibold">{{ $t->email }}</div>
                                            <div class="text-[10px] text-slate-400 font-mono">{{ $t->phone }}</div>
                                        </td>
                                        <td class="px-5 py-4 trainee-program">
                                            <span class="font-semibold text-slate-700 dark:text-slate-300">{{ $t->trainingProgram?->title ?? '-' }}</span>
                                        </td>
                                        <td class="px-5 py-4">
                                            @if($t->payment_status === 'PAID')
                                                <span class="bg-blue-50 text-blue-600 border border-blue-500/25 px-2 py-0.5 rounded font-bold uppercase text-[9px]">Lunas</span>
                                                <div class="text-[9px] text-slate-400 mt-1 font-mono font-bold">{{ $t->payment_method }}</div>
                                            @else
                                                <span class="bg-amber-50 text-amber-600 border border-amber-500/25 px-2 py-0.5 rounded font-bold uppercase text-[9px]">Belum Lunas</span>
                                                <form action="{{ route('admin.trainees.verify-payment', $t->id) }}" method="POST" class="mt-2">
                                                    @csrf
                                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-[9px] uppercase px-2 py-1 rounded transition-all shadow-md font-bold">Verifikasi Lunas</button>
                                                </form>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4">
                                            @if($t->status === 'LULUS')
                                                <span class="bg-blue-50 text-blue-605 border border-blue-500/25 px-2 py-0.5 rounded font-bold uppercase text-[9px]">Kompeten (Lulus)</span>
                                                <div class="text-[9px] text-slate-455 mt-1 font-mono font-bold">{{ $t->certificate_number }}</div>
                                            @else
                                                <span class="bg-slate-105 text-slate-655 border border-slate-200 px-2 py-0.5 rounded font-bold uppercase text-[9px]">Menunggu Ujian / Kelulusan</span>
                                                <form action="{{ route('admin.trainees.approve', $t->id) }}" method="POST" class="mt-2">
                                                    @csrf
                                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-[9px] uppercase px-2 py-1 rounded transition-all shadow-md font-bold">Terbitkan Sertifikat</button>
                                                </form>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4">
                                            <div class="flex items-center justify-center gap-2">
                                                <button type="button" onclick='editTrainee({!! json_encode($t) !!})' class="text-blue-600 hover:text-blue-800 font-bold uppercase text-[10px]">Edit</button>
                                                <form action="{{ route('admin.trainees.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pendaftaran ini?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-rose-600 hover:text-rose-800 font-bold uppercase text-[10px]">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-5 py-8 text-center text-slate-500 font-semibold">Belum ada data pendaftaran di database.</td>
                                    </tr>
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
                    <p class="text-slate-500 text-xs">Perbarui kredensial administrasi akun LPK Anda.</p>
                </div>

                <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 max-w-2xl shadow-sm">
                    <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Username / Nama</label>
                            <input type="text" name="username" value="{{ auth()->user()->username }}" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Alamat Email</label>
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
                            <button type="submit" class="bg-blue-650 hover:bg-blue-700 text-white font-extrabold text-xs uppercase px-6 py-3 rounded-xl transition-all shadow-md shadow-blue-500/10">Perbarui Profil</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- PANEL: LIVE CHAT BANTUAN -->
            <div id="panel-chats" class="role-panel hidden space-y-6">
                <div class="space-y-1">
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">Live Chat Bantuan</h2>
                    <p class="text-slate-500 text-xs">Kelola dan tangani pesan bantuan/pertanyaan masuk dari calon asesi secara real-time.</p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch min-h-[500px]">
                    <!-- Left: Chat List (4 cols) -->
                    <div class="lg:col-span-4 bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl flex flex-col overflow-hidden shadow-sm">
                        <div class="p-4 border-b border-slate-150 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/30">
                            <span class="font-extrabold text-slate-900 dark:text-white text-xs uppercase tracking-wider">Daftar Percakapan</span>
                        </div>
                        <div id="admin-chat-threads-container" class="flex-1 divide-y divide-slate-100 dark:divide-slate-800 overflow-y-auto max-h-[480px]">
                            <div class="p-6 text-center text-slate-400 font-semibold text-xs">Memuat daftar percakapan...</div>
                        </div>
                    </div>

                    <!-- Right: Chat Box (8 cols) -->
                    <div class="lg:col-span-8 bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl flex flex-col overflow-hidden shadow-sm relative">
                        <!-- Chat Box Header -->
                        <div id="admin-chat-header" class="p-4 border-b border-slate-150 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/30 flex justify-between items-center hidden">
                            <div>
                                <h4 id="admin-chat-header-name" class="font-bold text-slate-900 dark:text-white text-sm">Nama Tamu</h4>
                                <p id="admin-chat-header-email" class="text-[10px] text-slate-400 font-mono">email@gmail.com</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span id="admin-chat-header-status-badge" class="px-2.5 py-1 rounded text-[9px] font-bold uppercase tracking-wide">Status</span>
                                <button id="btn-admin-claim-chat" onclick="claimActiveChat()" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-[9px] uppercase px-3 py-1.5 rounded-lg transition-all hidden">Ambil Chat</button>
                            </div>
                        </div>

                        <!-- Chat Box Messages Container -->
                        <div id="admin-chat-messages-container" class="flex-1 p-4 space-y-4 overflow-y-auto max-h-[380px] bg-slate-50/50 dark:bg-slate-900/10 flex flex-col min-h-[300px]">
                            <!-- Placeholder -->
                            <div class="my-auto text-center text-slate-400 text-xs py-8">
                                <svg class="w-12 h-12 mx-auto text-slate-300 dark:text-slate-700 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/></svg>
                                <span class="font-bold">Pilih percakapan di sebelah kiri untuk mulai mengobrol</span>
                            </div>
                        </div>

                        <!-- Chat Box Input Bar -->
                        <div id="admin-chat-input-bar" class="p-3 border-t border-slate-150 dark:border-slate-800 bg-slate-50/20 dark:bg-slate-955/20 flex gap-2 items-center hidden">
                            <input type="text" id="admin-chat-input-field" onkeypress="handleAdminChatKeyPress(event)" placeholder="Ketik balasan Anda..." class="flex-1 bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                            <button onclick="sendAdminChatMessage()" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs uppercase px-4 py-2.5 rounded-xl shadow-md transition-all">Kirim</button>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <!-- SCRIPTS -->
    <script>
        const panels = [
            'dasbor', 'verifikasi', 'plotting', 'sertifikat', 'users', 'profil',
            'program', 'jadwal', 'fasilitas', 'programs-db', 'trainees-db', 'articles', 'chats'
        ];

        // Program DB panel helpers
        function toggleAddProgramForm() {
            const form = document.getElementById('form-add-program');
            form.classList.toggle('hidden');
            document.getElementById('form-edit-program').classList.add('hidden');
        }

        function editProgram(prog) {
            document.getElementById('form-add-program').classList.add('hidden');
            const editDiv = document.getElementById('form-edit-program');
            editDiv.classList.remove('hidden');
            
            // Populate fields
            document.getElementById('edit-program-id').value = prog.id;
            document.getElementById('edit-program-title').value = prog.title;
            document.getElementById('edit-program-category').value = prog.category;
            document.getElementById('edit-program-duration').value = prog.duration;
            document.getElementById('edit-program-price').value = prog.price;
            document.getElementById('edit-program-lsp-keyword').value = prog.lsp_keyword;
            document.getElementById('edit-program-description').value = prog.description;
            document.getElementById('edit-program-benefits').value = Array.isArray(prog.benefits) ? prog.benefits.join(', ') : '';
            
            // Set action URL
            document.getElementById('edit-program-form-action').action = `/dashboard/admin/programs/${prog.id}`;
            
            // Scroll to form
            editDiv.scrollIntoView({ behavior: 'smooth' });
        }

        function cancelEditProgram() {
            document.getElementById('form-edit-program').classList.add('hidden');
        }

        function filterTrainees() {
            const input = document.getElementById('trainee-search');
            const filter = input.value.toLowerCase();
            const rows = document.querySelectorAll('#trainees-table .trainee-row');
            
            rows.forEach(row => {
                const name = row.querySelector('.trainee-name').textContent.toLowerCase();
                const nik = row.querySelector('.trainee-nik').textContent.toLowerCase();
                const prog = row.querySelector('.trainee-program').textContent.toLowerCase();
                
                if (name.includes(filter) || nik.includes(filter) || prog.includes(filter)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function editUser(user) {
            const editDiv = document.getElementById('form-edit-user');
            editDiv.classList.remove('hidden');
            document.getElementById('edit-user-username').value = user.username;
            document.getElementById('edit-user-email').value = user.email;
            document.getElementById('edit-user-form-action').action = `/dashboard/admin/users/${user.id}`;
            editDiv.scrollIntoView({ behavior: 'smooth' });
        }

        function cancelEditUser() {
            document.getElementById('form-edit-user').classList.add('hidden');
        }

        function editArticle(art) {
            const editDiv = document.getElementById('form-edit-article');
            editDiv.classList.remove('hidden');
            document.getElementById('edit-article-title').value = art.title;
            document.getElementById('edit-article-content').value = art.content;
            document.getElementById('edit-article-form-action').action = `/dashboard/admin/articles/${art.id}`;
            editDiv.scrollIntoView({ behavior: 'smooth' });
        }

        function cancelEditArticle() {
            document.getElementById('form-edit-article').classList.add('hidden');
        }

        function editTrainee(t) {
            const editDiv = document.getElementById('form-edit-trainee');
            editDiv.classList.remove('hidden');
            document.getElementById('edit-trainee-name').value = t.name;
            document.getElementById('edit-trainee-nik').value = t.nik;
            document.getElementById('edit-trainee-email').value = t.email;
            document.getElementById('edit-trainee-phone').value = t.phone;
            document.getElementById('edit-trainee-status').value = t.status;
            document.getElementById('edit-trainee-payment-status').value = t.payment_status;
            document.getElementById('edit-trainee-form-action').action = `/dashboard/admin/trainees/${t.id}`;
            editDiv.scrollIntoView({ behavior: 'smooth' });
        }

        function cancelEditTrainee() {
            document.getElementById('form-edit-trainee').classList.add('hidden');
        }

        function showPanel(id) {
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

            localStorage.setItem('admin_active_panel', id);

            if (id === 'chats') {
                loadChatThreads();
                if (window.threadPollInterval) clearInterval(window.threadPollInterval);
                window.threadPollInterval = setInterval(loadChatThreads, 5000);
            } else {
                if (window.threadPollInterval) {
                    clearInterval(window.threadPollInterval);
                    window.threadPollInterval = null;
                }
                if (window.chatPollInterval) {
                    clearInterval(window.chatPollInterval);
                    window.chatPollInterval = null;
                }
            }

            if (window.innerWidth < 768) {
                document.getElementById('sidebar').classList.remove('open');
            }
        }

        let activeChatSessionId = null;

        function loadChatThreads() {
            const container = document.getElementById('admin-chat-threads-container');
            fetch("{{ route('admin.chats.list') }}", {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(res => {
                    if (!res.ok) throw new Error('HTTP ' + res.status);
                    return res.json();
                })
                .then(data => {
                    if (data.success) {
                        if (data.chats.length === 0) {
                            container.innerHTML = `<div class="p-6 text-center text-slate-400 font-semibold text-xs">Belum ada percakapan masuk.</div>`;
                            return;
                        }
                        
                        const currentAdminId = Number({{ auth()->id() ?? 0 }});
                        let html = '';
                        data.chats.forEach(chat => {
                            const isActive = chat.session_id === activeChatSessionId;
                            const isClaimedByMe = chat.claimed_by_admin_id === currentAdminId;
                            let statusText = '';
                            let statusColorClass = '';
                            
                            if (chat.claimed_by) {
                                statusText = isClaimedByMe ? 'Anda' : chat.claimed_by;
                                statusColorClass = isClaimedByMe 
                                    ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-950/20 dark:text-emerald-400 border border-emerald-500/20' 
                                    : 'bg-blue-50 text-blue-600 dark:bg-blue-950/20 dark:text-blue-400 border border-blue-500/20';
                            } else {
                                statusText = 'Belum Diambil';
                                statusColorClass = 'bg-amber-50 text-amber-600 dark:bg-amber-950/20 dark:text-amber-400 border border-amber-500/20';
                            }

                            html += `
                                <div onclick="selectChatSession('${chat.session_id}')" class="p-4 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-900/40 transition flex flex-col gap-2 ${isActive ? 'bg-blue-50/50 dark:bg-blue-950/10 border-l-4 border-blue-600' : ''}">
                                    <div class="flex justify-between items-start gap-2">
                                        <div class="truncate">
                                            <span class="font-extrabold text-xs text-slate-800 dark:text-white block truncate">${chat.name}</span>
                                            <span class="text-[10px] text-slate-400 dark:text-slate-500 font-mono block truncate">${chat.email}</span>
                                        </div>
                                        <span class="text-[9px] font-bold px-2 py-0.5 rounded ${statusColorClass} shrink-0 max-w-[100px] truncate" title="${chat.claimed_by ? 'Ditangani oleh ' + chat.claimed_by : 'Belum ditangani'}">
                                            ${chat.claimed_by ? '👤 ' + statusText : '⚠️ ' + statusText}
                                        </span>
                                    </div>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400 truncate mt-1">${chat.last_message}</p>
                                </div>
                            `;
                        });
                        container.innerHTML = html;
                    } else {
                        container.innerHTML = `<div class="p-6 text-center text-rose-400 font-semibold text-xs">Gagal memuat data: ${data.message || 'Unknown error'}</div>`;
                    }
                })
                .catch(err => {
                    console.error("Error loading chats:", err);
                    container.innerHTML = `<div class="p-6 text-center text-rose-400 font-semibold text-xs">Error: ${err.message}</div>`;
                });
        }

        function selectChatSession(sessionId) {
            activeChatSessionId = sessionId;
            
            document.getElementById('admin-chat-header').classList.remove('hidden');
            document.getElementById('admin-chat-input-bar').classList.remove('hidden');
            
            loadChatDetails();
            loadChatThreads();
            
            if (window.chatPollInterval) clearInterval(window.chatPollInterval);
            window.chatPollInterval = setInterval(loadChatDetails, 3000);
        }

        function loadChatDetails() {
            if (!activeChatSessionId) return;

            fetch(`/dashboard/admin/chats/${activeChatSessionId}`)
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const headerName = document.getElementById('admin-chat-header-name');
                        const headerEmail = document.getElementById('admin-chat-header-email');
                        const statusBadge = document.getElementById('admin-chat-header-status-badge');
                        const claimBtn = document.getElementById('btn-admin-claim-chat');

                        const activeThread = document.querySelector(`[onclick="selectChatSession('${activeChatSessionId}')"]`);
                        if (activeThread) {
                            const nameText = activeThread.querySelector('.font-extrabold').textContent;
                            const emailText = activeThread.querySelector('.font-mono').textContent;
                            headerName.textContent = nameText;
                            headerEmail.textContent = emailText;
                        }

                        if (data.claimed_by) {
                            claimBtn.classList.add('hidden');
                            statusBadge.classList.remove('hidden');
                            statusBadge.textContent = `Ditangani oleh: ${data.claimed_by}`;
                            statusBadge.className = "px-2.5 py-1 rounded text-[9px] font-bold uppercase tracking-wide bg-blue-50 text-blue-600 dark:bg-blue-950/20 dark:text-blue-400 border border-blue-500/20";
                        } else {
                            claimBtn.classList.remove('hidden');
                            statusBadge.classList.add('hidden');
                        }

                        const messagesContainer = document.getElementById('admin-chat-messages-container');
                        let html = '';
                        data.messages.forEach(msg => {
                            const isAdmin = msg.sender_role === 'admin';
                            const bubbleClass = isAdmin 
                                ? 'bg-blue-600 text-white rounded-l-2xl rounded-tr-2xl ml-auto text-right' 
                                : 'bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-150 rounded-r-2xl rounded-tl-2xl mr-auto';
                            
                            html += `
                                <div class="max-w-[75%] p-3.5 shadow-sm text-xs leading-relaxed ${bubbleClass}">
                                    <p class="whitespace-pre-wrap">${msg.message}</p>
                                    <span class="block text-[8px] opacity-75 mt-1 font-semibold">${msg.time}</span>
                                </div>
                            `;
                        });
                        
                        const isNearBottom = messagesContainer.scrollHeight - messagesContainer.clientHeight - messagesContainer.scrollTop < 100;
                        const originalHtml = messagesContainer.innerHTML;
                        
                        messagesContainer.innerHTML = html;
                        
                        if (isNearBottom || originalHtml.includes('Pilih percakapan')) {
                            messagesContainer.scrollTop = messagesContainer.scrollHeight;
                        }
                    }
                })
                .catch(err => console.error("Error loading chat detail:", err));
        }

        function claimActiveChat() {
            if (!activeChatSessionId) return;

            fetch(`/dashboard/admin/chats/${activeChatSessionId}/claim`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    loadChatDetails();
                    loadChatThreads();
                }
            })
            .catch(err => console.error("Error claiming chat:", err));
        }

        function sendAdminChatMessage() {
            if (!activeChatSessionId) return;
            const input = document.getElementById('admin-chat-input-field');
            const message = input.value.trim();
            if (!message) return;

            input.value = '';

            fetch(`/dashboard/admin/chats/${activeChatSessionId}/reply`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ message: message })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    loadChatDetails();
                    loadChatThreads();
                }
            })
            .catch(err => console.error("Error sending reply:", err));
        }

        function handleAdminChatKeyPress(event) {
            if (event.key === 'Enter') {
                sendAdminChatMessage();
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
            // Close all others
            document.querySelectorAll('.accordion-content').forEach(c => c.classList.add('hidden'));
            document.querySelectorAll('.accordion-arrow').forEach(a => a.style.transform = '');
            if (!isOpen) {
                content.classList.remove('hidden');
                arrow.style.transform = 'rotate(180deg)';
            }
        }

        let currentDetailUser = null;
        let isPassVisible = false;

        function showUserDetail(user) {
            currentDetailUser = user;
            isPassVisible = false;
            
            const modal = document.getElementById('user-detail-modal');
            const badge = document.getElementById('detail-user-role-badge');
            const username = document.getElementById('detail-user-username');
            const email = document.getElementById('detail-user-email');
            const passSpan = document.getElementById('detail-user-password');
            const created = document.getElementById('detail-user-created');

            badge.textContent = user.role.toUpperCase();
            username.textContent = user.username || user.name;
            email.textContent = user.email;
            
            const rawPass = user.password_plain || '• • • • • • • • (Hashed)';
            passSpan.setAttribute('data-raw', rawPass);
            passSpan.textContent = '• • • • • • • •';
            
            created.textContent = new Date(user.created_at).toLocaleString('id-ID', {
                year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit'
            });

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeUserDetailModal() {
            const modal = document.getElementById('user-detail-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function togglePasswordVisibility() {
            const passSpan = document.getElementById('detail-user-password');
            const raw = passSpan.getAttribute('data-raw');
            if (isPassVisible) {
                passSpan.textContent = '• • • • • • • •';
                isPassVisible = false;
            } else {
                passSpan.textContent = raw;
                isPassVisible = true;
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const activePanel = urlParams.get('open') || localStorage.getItem('admin_active_panel') || 'dasbor';
            showPanel(activePanel);
            updateThemeUI();
            // Auto-open accordion group that contains the active panel button
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

    <!-- User Detail Modal -->
    <div id="user-detail-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
        <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-3xl w-full max-w-sm p-6 space-y-6 shadow-2xl relative animate-fade-in">
            <button onclick="closeUserDetailModal()" class="absolute top-4 right-4 text-slate-450 hover:text-slate-655 dark:hover:text-white transition duration-205 text-lg font-bold">
                ✕
            </button>
            <div class="space-y-1">
                <span id="detail-user-role-badge" class="bg-blue-50 text-blue-600 border border-blue-500/20 px-2 py-0.5 rounded font-bold uppercase text-[9px] inline-block">Role</span>
                <h3 class="text-base font-extrabold text-slate-900 dark:text-white font-heading">Detail Akun Pengguna</h3>
            </div>
            
            <div class="space-y-4 text-xs">
                <div class="border-b border-slate-100 dark:border-slate-800/80 pb-3">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Username</span>
                    <span id="detail-user-username" class="font-semibold text-slate-800 dark:text-white font-mono text-sm">username</span>
                </div>
                <div class="border-b border-slate-100 dark:border-slate-800/80 pb-3">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Email</span>
                    <span id="detail-user-email" class="font-semibold text-slate-800 dark:text-white font-mono font-semibold">email@gmail.com</span>
                </div>
                <div class="border-b border-slate-100 dark:border-slate-800/80 pb-3">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Password Terdaftar</span>
                    <div class="flex items-center justify-between mt-1">
                        <span id="detail-user-password" class="font-bold text-slate-800 dark:text-white font-mono bg-slate-50 dark:bg-slate-900 px-2 py-1 rounded select-all font-semibold">password</span>
                        <button onclick="togglePasswordVisibility()" class="text-blue-600 hover:underline font-bold uppercase text-[10px]">Tampilkan/Sembunyikan</button>
                    </div>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Akun Dibuat Pada</span>
                    <span id="detail-user-created" class="font-semibold text-slate-600 dark:text-slate-350">date</span>
                </div>
            </div>
            
            <div class="flex justify-end pt-2">
                <button onclick="closeUserDetailModal()" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-white font-extrabold text-xs uppercase tracking-wider rounded-xl transition duration-200 font-bold">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</body>
</html>
