<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Superadmin — LPK MPI</title>
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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(226, 232, 240, 0.8);
        }
        .dark .glass {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(51, 65, 85, 0.5);
        }
        #sa-sidebar {
            width: 280px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        @media (max-width: 1024px) {
            #sa-sidebar {
                transform: translateX(-100%);
            }
            #sa-sidebar.open {
                transform: translateX(0);
            }
        }
    </style>
</head>
<body class="min-h-screen bg-white dark:bg-slate-950 text-slate-800 dark:text-slate-100 transition-colors duration-300 flex">

    <!-- SIDEBAR -->
    <aside id="sa-sidebar" class="fixed inset-y-0 left-0 z-40 bg-white dark:bg-slate-950 border-r border-slate-200 dark:border-slate-800 flex flex-col justify-between shrink-0 overflow-y-auto">
        <div class="flex flex-col">
            <!-- Sidebar Header -->
            <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800/80 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-blue-600 flex items-center justify-center text-white font-extrabold shadow-md shadow-blue-600/10">
                        ⚡
                    </div>
                    <div>
                        <div class="font-extrabold text-sm text-slate-900 dark:text-white tracking-tight">LPK MPI</div>
                        <div class="text-[10px] text-blue-600 font-bold tracking-widest uppercase">Super Admin</div>
                    </div>
                </div>
                <button onclick="toggleSidebar()" class="lg:hidden text-slate-500 hover:text-slate-800 dark:hover:text-slate-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="p-4 space-y-2" id="sidebar-nav">
                <!-- Dasbor Utama (standalone) -->
                <button onclick="showPanel('panel-dasbor')" id="btn-dasbor" class="sidebar-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all text-left">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"/></svg>
                    <span>Dasbor Utama</span>
                </button>

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
                        <button onclick="showPanel('panel-identity')" id="btn-identity" class="sidebar-btn w-full text-left px-3 py-2 rounded-lg text-xs text-slate-600 dark:text-slate-450 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all font-semibold flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            Identitas & Logo
                        </button>
                        <button onclick="showPanel('panel-login-branding')" id="btn-login-branding" class="sidebar-btn w-full text-left px-3 py-2 rounded-lg text-xs text-slate-600 dark:text-slate-450 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all font-semibold flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            Halaman Login
                        </button>
                        <button onclick="showPanel('panel-hero')" id="btn-hero" class="sidebar-btn w-full text-left px-3 py-2 rounded-lg text-xs text-slate-600 dark:text-slate-450 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all font-semibold flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            Banner Depan (Hero)
                        </button>
                        <button onclick="showPanel('panel-stats')" id="btn-stats" class="sidebar-btn w-full text-left px-3 py-2 rounded-lg text-xs text-slate-600 dark:text-slate-450 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all font-semibold flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            Statistik
                        </button>
                        <button onclick="showPanel('panel-steps')" id="btn-steps" class="sidebar-btn w-full text-left px-3 py-2 rounded-lg text-xs text-slate-600 dark:text-slate-450 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all font-semibold flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            Alur Registrasi
                        </button>
                        <button onclick="showPanel('panel-features')" id="btn-features" class="sidebar-btn w-full text-left px-3 py-2 rounded-lg text-xs text-slate-600 dark:text-slate-450 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all font-semibold flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            Keunggulan Fitur
                        </button>
                        <button onclick="showPanel('panel-gallery')" id="btn-gallery" class="sidebar-btn w-full text-left px-3 py-2 rounded-lg text-xs text-slate-600 dark:text-slate-450 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all font-semibold flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            Galeri Foto
                        </button>
                        <button onclick="showPanel('panel-tentang')" id="btn-tentang" class="sidebar-btn w-full text-left px-3 py-2 rounded-lg text-xs text-slate-600 dark:text-slate-450 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all font-semibold flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            Tentang Kami
                        </button>
                        <button onclick="showPanel('panel-program')" id="btn-program" class="sidebar-btn w-full text-left px-3 py-2 rounded-lg text-xs text-slate-600 dark:text-slate-450 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all font-semibold flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            Program Pelatihan
                        </button>
                        <button onclick="showPanel('panel-jadwal')" id="btn-jadwal" class="sidebar-btn w-full text-left px-3 py-2 rounded-lg text-xs text-slate-600 dark:text-slate-450 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all font-semibold flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            Jadwal Diklat
                        </button>
                        <button onclick="showPanel('panel-instruktur-landing')" id="btn-instruktur-landing" class="sidebar-btn w-full text-left px-3 py-2 rounded-lg text-xs text-slate-600 dark:text-slate-450 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all font-semibold flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            Instruktur
                        </button>
                        <button onclick="showPanel('panel-fasilitas')" id="btn-fasilitas" class="sidebar-btn w-full text-left px-3 py-2 rounded-lg text-xs text-slate-600 dark:text-slate-450 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all font-semibold flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            Fasilitas
                        </button>
                        <button onclick="showPanel('panel-faq')" id="btn-faq" class="sidebar-btn w-full text-left px-3 py-2 rounded-lg text-xs text-slate-600 dark:text-slate-450 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all font-semibold flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            FAQ
                        </button>
                        <button onclick="showPanel('panel-articles')" id="btn-articles" class="sidebar-btn w-full text-left px-3 py-2 rounded-lg text-xs text-slate-600 dark:text-slate-450 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all font-semibold flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            Kabar & Artikel
                        </button>
                        <button onclick="showPanel('panel-kontak')" id="btn-kontak" class="sidebar-btn w-full text-left px-3 py-2 rounded-lg text-xs text-slate-600 dark:text-slate-450 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all font-semibold flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            Kontak LPK
                        </button>
                        <button onclick="showPanel('panel-preview')" id="btn-preview" class="sidebar-btn w-full text-left px-3 py-2 rounded-lg text-xs text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all font-bold flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-300 shrink-0"></span>
                            👁️ Live Preview Website
                        </button>
                    </div>
                </div>

                <!-- Accordion: Pengaturan Sistem -->
                <div class="accordion-group">
                    <button class="accordion-trigger w-full flex items-center justify-between gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all text-left" onclick="toggleAccordion(this)">
                        <span class="flex items-center gap-3">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Pengaturan Sistem</span>
                        </span>
                        <svg class="accordion-arrow w-4 h-4 shrink-0 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="accordion-content hidden pl-4 mt-1 space-y-1 border-l-2 border-blue-100 dark:border-blue-900 ml-6">
                        <button onclick="showPanel('panel-programs-db')" id="btn-programs-db" class="sidebar-btn w-full text-left px-3 py-2 rounded-lg text-xs text-slate-600 dark:text-slate-450 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all font-semibold flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            Data Program Pelatihan
                        </button>
                        <button onclick="showPanel('panel-trainees-db')" id="btn-trainees-db" class="sidebar-btn w-full text-left px-3 py-2 rounded-lg text-xs text-slate-600 dark:text-slate-450 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all font-semibold flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            Data Pendaftaran Peserta
                        </button>
                        <button onclick="showPanel('panel-users')" id="btn-users" class="sidebar-btn w-full text-left px-3 py-2 rounded-lg text-xs text-slate-600 dark:text-slate-450 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all font-semibold flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            Manajemen User
                        </button>
                        <button onclick="showPanel('panel-profile')" id="btn-profile" class="sidebar-btn w-full text-left px-3 py-2 rounded-lg text-xs text-slate-600 dark:text-slate-450 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all font-semibold flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            Profil Superadmin
                        </button>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-slate-100 dark:border-slate-800 shrink-0">
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
    <div class="flex-1 flex flex-col min-w-0 overflow-x-hidden lg:pl-[280px]">

        <!-- TOPBAR -->
        <header class="h-16 bg-white dark:bg-slate-950 border-b border-slate-200 dark:border-slate-800 px-6 flex items-center justify-between sticky top-0 z-30">
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()" class="lg:hidden text-slate-500 hover:text-slate-800 dark:hover:text-slate-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <span class="text-xs font-black uppercase tracking-widest text-blue-600 block">SYSTEM CONSOLE</span>
            </div>

            <!-- Profile & Notifications -->
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-3 pl-3 border-l border-slate-250 dark:border-slate-800">
                    <div class="text-right hidden sm:block">
                        <div class="text-xs font-bold text-slate-850 dark:text-slate-200">{{ auth()->user()->name }}</div>
                        <div class="text-[9px] font-bold text-slate-400 uppercase">Super Admin / IT</div>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-blue-650 flex items-center justify-center text-white text-xs font-bold shadow-md shadow-blue-500/10">
                        SA
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
                <!-- System Status Widgets -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-950/20 text-blue-650 flex items-center justify-center text-2xl">🖥️</div>
                        <div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Server Uptime</div>
                            <div class="text-xl font-black text-slate-850 dark:text-white mt-1">99.98% (Online)</div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-950/20 text-blue-650 flex items-center justify-center text-2xl">🛢️</div>
                        <div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Database Status</div>
                            <div class="text-xl font-black text-slate-850 dark:text-white mt-1">Connected (Active)</div>
                        </div>
                    </div>
                </div>

                <!-- CMS Quick Actions -->
                <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm space-y-4">
                    <h3 class="font-extrabold text-sm text-slate-800 dark:text-white uppercase tracking-wider">Aksi Cepat CMS</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <button onclick="showPanel('panel-hero')" class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 hover:border-blue-500 rounded-xl p-4 text-left transition-all">
                            <span class="block text-lg mb-1">🖼️</span>
                            <span class="block text-xs font-bold text-slate-800 dark:text-white">Ubah Banner Depan</span>
                        </button>
                        <button onclick="showPanel('panel-faq')" class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 hover:border-blue-500 rounded-xl p-4 text-left transition-all">
                            <span class="block text-lg mb-1">❓</span>
                            <span class="block text-xs font-bold text-slate-800 dark:text-white">Update FAQ</span>
                        </button>
                        <button onclick="showPanel('panel-articles')" class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 hover:border-blue-500 rounded-xl p-4 text-left transition-all">
                            <span class="block text-lg mb-1">📰</span>
                            <span class="block text-xs font-bold text-slate-800 dark:text-white">Kelola Artikel</span>
                        </button>
                    </div>
                </div>

                <!-- User Statistics -->
                <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm space-y-4">
                    <h3 class="font-extrabold text-sm text-slate-800 dark:text-white uppercase tracking-wider">Statistik Pengguna</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
                        <div class="bg-white dark:bg-slate-950 rounded-xl p-3 border border-slate-200 dark:border-slate-800">
                            <div class="text-xl font-bold text-slate-850 dark:text-white">{{ $admins->count() }}</div>
                            <div class="text-[9px] text-slate-400 font-bold uppercase mt-1">Admin</div>
                        </div>
                        <div class="bg-white dark:bg-slate-950 rounded-xl p-3 border border-slate-200 dark:border-slate-800">
                            <div class="text-xl font-bold text-slate-850 dark:text-white">10</div>
                            <div class="text-[9px] text-slate-400 font-bold uppercase mt-1">Instruktur</div>
                        </div>
                        <div class="bg-white dark:bg-slate-950 rounded-xl p-3 border border-slate-200 dark:border-slate-800">
                            <div class="text-xl font-bold text-slate-850 dark:text-white">{{ $asesors->count() }}</div>
                            <div class="text-[9px] text-slate-400 font-bold uppercase mt-1">Asesor</div>
                        </div>
                        <div class="bg-white dark:bg-slate-950 rounded-xl p-3 border border-slate-200 dark:border-slate-800">
                            <div class="text-xl font-bold text-slate-850 dark:text-white">150</div>
                            <div class="text-[9px] text-slate-400 font-bold uppercase mt-1">Asesi</div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities Log -->
                <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm">
                    <div class="p-5 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                        <h3 class="font-extrabold text-sm text-slate-800 dark:text-white uppercase tracking-wider">Log Aktivitas Sistem Terbaru</h3>
                    </div>
                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-slate-100 dark:border-slate-800 text-slate-400 text-[10px] uppercase font-extrabold">
                                    <th class="px-5 py-3 text-left">Waktu</th>
                                    <th class="px-5 py-3 text-left">User ID / Akun</th>
                                    <th class="px-5 py-3 text-left">Aksi / Kegiatan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-xs">
                                <tr>
                                    <td class="px-5 py-3 text-slate-450 font-mono">Baru saja</td>
                                    <td class="px-5 py-3 font-bold text-slate-800 dark:text-white">superadmin</td>
                                    <td class="px-5 py-3 text-slate-600 dark:text-slate-350">Update konfigurasi branding website LPK Manajemen Pendidikan Islam.</td>
                                </tr>
                                <tr>
                                    <td class="px-5 py-3 text-slate-450 font-mono">10 menit lalu</td>
                                    <td class="px-5 py-3 font-bold text-slate-800 dark:text-white">admin_lpk</td>
                                    <td class="px-5 py-3 text-slate-600 dark:text-slate-350">Verifikasi dokumen registrasi (APL-01) asesi Ahmad Faisal.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- PANEL: IDENTITAS & LOGO -->
            <div id="panel-identity" class="role-panel hidden space-y-6">
                <div class="space-y-1">
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">Identitas &amp; Branding</h2>
                    <p class="text-slate-500 text-xs">Atur nama singkat dan logo resmi LPK Manajemen Pendidikan Islam.</p>
                </div>
                <form action="{{ route('superadmin.settings.update') }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 space-y-5 shadow-sm">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Nama Singkat / Judul Situs (Site Title)</label>
                        <input type="text" name="site_title" value="{{ $settings['site_title'] ?? 'LPK-MI' }}" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Logo Website (Site Logo)</label>
                        @if(!empty($settings['site_logo']))
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $settings['site_logo']) }}" class="h-10 w-auto object-contain rounded-xl border border-slate-200 dark:border-slate-800 p-2 bg-white dark:bg-slate-950" alt="Site Logo">
                            </div>
                        @endif
                        <input type="file" name="site_logo" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                    <div class="flex justify-end pt-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs uppercase px-6 py-3 rounded-xl shadow-md shadow-blue-500/10">Simpan Perubahan</button>
                    </div>
                </form>
            </div>

            <!-- PANEL: HALAMAN LOGIN -->
            <div id="panel-login-branding" class="role-panel hidden space-y-6">
                <div class="space-y-1">
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">Halaman Login</h2>
                    <p class="text-slate-500 text-xs">Sesuaikan informasi teks branding dan latar belakang halaman masuk.</p>
                </div>
                <form action="{{ route('superadmin.settings.update') }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 space-y-5 shadow-sm">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Branding Kiri: Judul 1 (Blue Bold)</label>
                            <input type="text" name="login_left_title_1" value="{{ $settings['login_left_title_1'] ?? 'LEMBAGA SERTIFIKASI' }}" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Branding Kiri: Judul 2 (Blue Bold)</label>
                            <input type="text" name="login_left_title_2" value="{{ $settings['login_left_title_2'] ?? 'PROFESI' }}" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Branding Kiri: Subtitle Kecil</label>
                        <input type="text" name="login_left_sub" value="{{ $settings['login_left_sub'] ?? '(lpk) p3' }}" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Branding Kiri: Judul Utama Besar</label>
                        <textarea name="login_left_main" rows="3" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">{{ $settings['login_left_main'] ?? 'MANAJEMEN PENDIDIKAN ISLAM' }}</textarea>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Branding Kiri: Label Kaki</label>
                        <input type="text" name="login_left_footer_title" value="{{ $settings['login_left_footer_title'] ?? 'SKKNI' }}" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Branding Kiri: Deskripsi Kaki</label>
                        <textarea name="login_left_footer_desc" rows="3" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">{{ $settings['login_left_footer_desc'] ?? 'Standar Kompetensi Kerja Khusus Manajemen Pendidikan Islam' }}</textarea>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Gambar Latar Belakang Login</label>
                        @if(!empty($settings['login_bg_image']))
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $settings['login_bg_image']) }}" class="h-20 w-auto object-contain rounded-xl border border-slate-200 dark:border-slate-800" alt="Login Background">
                            </div>
                        @endif
                        <input type="file" name="login_bg_image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                    <div class="flex justify-end pt-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs uppercase px-6 py-3 rounded-xl shadow-md shadow-blue-500/10">Simpan Perubahan</button>
                    </div>
                </form>
            </div>

            <!-- PANEL: BANNER DEPAN (HERO) -->
            <div id="panel-hero" class="role-panel hidden space-y-6">
                <div class="space-y-1">
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">Banner Utama (Hero)</h2>
                    <p class="text-slate-500 text-xs">Ubah judul, sub-judul, dan gambar banner utama di halaman beranda.</p>
                </div>
                <form action="{{ route('superadmin.settings.update') }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 space-y-5 shadow-sm">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Judul Banner (Hero Title)</label>
                        <input type="text" name="hero_title" value="{{ $settings['hero_title'] ?? 'Persiapkan Kompetensi Anda Untuk Sertifikasi Profesional' }}" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Sub-Judul (Hero Subtitle)</label>
                        <textarea name="hero_subtitle" rows="4" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">{{ $settings['hero_subtitle'] ?? '' }}</textarea>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Foto Sampul Utama</label>
                        @if(!empty($settings['hero_image']))
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $settings['hero_image']) }}" class="h-28 w-auto object-contain rounded-xl border border-slate-200 dark:border-slate-800" alt="Hero Image">
                            </div>
                        @endif
                        <input type="file" name="hero_image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                    <div class="flex justify-end pt-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs uppercase px-6 py-3 rounded-xl shadow-md shadow-blue-500/10">Simpan Perubahan</button>
                    </div>
                </form>
            </div>

            <!-- PANEL: STATISTIK -->
            <div id="panel-stats" class="role-panel hidden space-y-6">
                <div class="space-y-1">
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">Statistik Halaman Utama</h2>
                    <p class="text-slate-500 text-xs">Ubah data angka dan pencapaian instansi.</p>
                </div>
                <form action="{{ route('superadmin.settings.update') }}" method="POST" class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 space-y-6 shadow-sm">
                    @csrf
                    <input type="hidden" name="stat_count" id="stat_count_input" value="{{ $settings['stat_count'] ?? 3 }}">
                    <div class="flex items-center gap-3">
                        <button type="button" onclick="adjustCount('stat', 1)" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase px-4 py-2 rounded-xl transition shadow">＋ Tambah Statistik</button>
                        <button type="button" onclick="adjustCount('stat', -1)" class="bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs uppercase px-4 py-2 rounded-xl transition shadow">－ Hapus Terakhir</button>
                    </div>
                    <div id="stat-container" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @php $statCount = (int) ($settings['stat_count'] ?? 3); @endphp
                        @for($i = 1; $i <= $statCount; $i++)
                            <div class="bg-white dark:bg-slate-950 p-4 border border-slate-200 dark:border-slate-800 rounded-xl space-y-3 stat-card" data-index="{{ $i }}">
                                <div class="text-[10px] font-bold text-slate-400 uppercase">Statistik {{ $i }}</div>
                                <div>
                                    <label class="block text-[9px] font-bold text-slate-400 uppercase mb-1">Nilai</label>
                                    <input type="text" name="stat_{{ $i }}_val" value="{{ $settings['stat_' . $i . '_val'] ?? '' }}" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-lg px-3 py-1.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-bold text-slate-400 uppercase mb-1">Label</label>
                                    <input type="text" name="stat_{{ $i }}_lbl" value="{{ $settings['stat_' . $i . '_lbl'] ?? '' }}" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-lg px-3 py-1.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                                </div>
                            </div>
                        @endfor
                    </div>
                    <div class="flex justify-end pt-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs uppercase px-6 py-3 rounded-xl shadow-md shadow-blue-500/10">Simpan Perubahan</button>
                    </div>
                </form>
            </div>

            <!-- PANEL: ALUR REGISTRASI -->
            <div id="panel-steps" class="role-panel hidden space-y-6">
                <div class="space-y-1">
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">Alur Langkah Registrasi</h2>
                    <p class="text-slate-500 text-xs">Ubah rincian judul tahapan pendaftaran asesi.</p>
                </div>
                <form action="{{ route('superadmin.settings.update') }}" method="POST" class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 space-y-5 shadow-sm">
                    @csrf
                    <input type="hidden" name="step_count" id="step_count_input" value="{{ $settings['step_count'] ?? 3 }}">
                    <div class="flex items-center gap-3 mb-4">
                        <button type="button" onclick="adjustCount('step', 1)" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase px-4 py-2 rounded-xl transition shadow">＋ Tambah Langkah</button>
                        <button type="button" onclick="adjustCount('step', -1)" class="bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs uppercase px-4 py-2 rounded-xl transition shadow">－ Hapus Terakhir</button>
                    </div>
                    <div id="step-container" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @php $stepCount = (int) ($settings['step_count'] ?? 3); @endphp
                        @for($i = 1; $i <= $stepCount; $i++)
                            <div class="bg-white dark:bg-slate-950 p-4 border border-slate-200 dark:border-slate-800 rounded-xl space-y-2 step-card" data-index="{{ $i }}">
                                <label class="block text-[10px] font-bold text-slate-400 uppercase">Langkah {{ $i }}</label>
                                <input type="text" name="step_{{ $i }}_title" value="{{ $settings['step_' . $i . '_title'] ?? '' }}" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-lg px-3 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                            </div>
                        @endfor
                    </div>
                    <div class="flex justify-end pt-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs uppercase px-6 py-3 rounded-xl shadow-md shadow-blue-500/10">Simpan Perubahan</button>
                    </div>
                </form>
            </div>

            <!-- PANEL: KEUNGGULAN FITUR -->
            <div id="panel-features" class="role-panel hidden space-y-6">
                <div class="space-y-1">
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">Keunggulan &amp; Fitur</h2>
                    <p class="text-slate-500 text-xs">Ubah detail keunggulan LPK Manajemen Pendidikan Islam.</p>
                </div>
                <form action="{{ route('superadmin.settings.update') }}" method="POST" class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 space-y-6 shadow-sm">
                    @csrf
                    <input type="hidden" name="feature_count" id="feature_count_input" value="{{ $settings['feature_count'] ?? 3 }}">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Judul Utama Seksi Keunggulan</label>
                        <input type="text" name="why_choose_title" value="{{ $settings['why_choose_title'] ?? 'Mengapa Memilih LPK-MI?' }}" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                    </div>
                    <div class="flex items-center gap-3 mb-4">
                        <button type="button" onclick="adjustCount('feature', 1)" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase px-4 py-2 rounded-xl transition shadow">＋ Tambah Fitur</button>
                        <button type="button" onclick="adjustCount('feature', -1)" class="bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs uppercase px-4 py-2 rounded-xl transition shadow">－ Hapus Terakhir</button>
                    </div>
                    <div id="feature-container" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @php $featureCount = (int) ($settings['feature_count'] ?? 3); @endphp
                        @for($i = 1; $i <= $featureCount; $i++)
                            <div class="bg-white dark:bg-slate-950 p-4 border border-slate-200 dark:border-slate-800 rounded-xl space-y-2 feature-card" data-index="{{ $i }}">
                                <span class="text-[10px] font-bold text-slate-400 uppercase">Fitur {{ $i }}</span>
                                <div>
                                    <label class="block text-[9px] font-bold text-slate-450 uppercase mb-0.5">Judul</label>
                                    <input type="text" name="feature_{{ $i }}_title" value="{{ $settings['feature_' . $i . '_title'] ?? '' }}" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-lg px-3 py-1.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-[9px] font-bold text-slate-450 uppercase mb-0.5">Deskripsi</label>
                                    <textarea name="feature_{{ $i }}_desc" rows="3" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-lg px-3 py-1.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 resize-none">{{ $settings['feature_' . $i . '_desc'] ?? '' }}</textarea>
                                </div>
                            </div>
                        @endfor
                    </div>
                    <div class="flex justify-end pt-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs uppercase px-6 py-3 rounded-xl shadow-md shadow-blue-500/10">Simpan Perubahan</button>
                    </div>
                </form>
            </div>

            <!-- PANEL: GALERI FOTO -->
            <div id="panel-gallery" class="role-panel hidden space-y-6">
                <div class="space-y-1">
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">Galeri Kegiatan</h2>
                    <p class="text-slate-500 text-xs">Ubah judul, sub-judul, dan item galeri (foto/video) beranda.</p>
                </div>
                <form action="{{ route('superadmin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <input type="hidden" name="active_panel" value="panel-gallery">
                    <input type="hidden" name="gallery_count" id="gallery_count_input" value="{{ $settings['gallery_count'] ?? 6 }}">
                    <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 space-y-4 shadow-sm">
                        <h3 class="font-extrabold text-sm text-slate-800 dark:text-white uppercase tracking-wider">Header Seksi</h3>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Judul Galeri</label>
                            <input type="text" name="gallery_title" value="{{ $settings['gallery_title'] ?? 'Galeri & Dokumentasi Kegiatan' }}" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Subjudul / Deskripsi</label>
                            <textarea name="gallery_subtitle" rows="2" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">{{ $settings['gallery_subtitle'] ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="button" onclick="adjustCount('gallery', 1)" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase px-4 py-2 rounded-xl transition shadow">＋ Tambah Item Galeri</button>
                        <button type="button" onclick="adjustCount('gallery', -1)" class="bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs uppercase px-4 py-2 rounded-xl transition shadow">－ Hapus Terakhir</button>
                    </div>
                    <div id="gallery-container" class="space-y-4">
                        @php $galleryCount = (int) ($settings['gallery_count'] ?? 6); @endphp
                        @for($i = 1; $i <= $galleryCount; $i++)
                            <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 space-y-4 shadow-sm gallery-card" data-index="{{ $i }}">
                                <h3 class="font-extrabold text-xs text-blue-600 dark:text-blue-400 uppercase tracking-wider">Item Galeri #{{ $i }}</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Kategori</label>
                                        <input type="text" name="gallery_item_{{ $i }}_category" value="{{ $settings['gallery_item_'.$i.'_category'] ?? '' }}" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Judul Item</label>
                                        <input type="text" name="gallery_item_{{ $i }}_title" value="{{ $settings['gallery_item_'.$i.'_title'] ?? '' }}" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Deskripsi</label>
                                    <textarea name="gallery_item_{{ $i }}_desc" rows="2" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 resize-none">{{ $settings['gallery_item_'.$i.'_desc'] ?? '' }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Link Video (YouTube / Dll - Opsional)</label>
                                    <input type="text" name="gallery_item_{{ $i }}_video_url" value="{{ $settings['gallery_item_'.$i.'_video_url'] ?? '' }}" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Foto Galeri</label>
                                    @if(!empty($settings['gallery_item_'.$i.'_image']))
                                        <img src="{{ asset('storage/' . $settings['gallery_item_'.$i.'_image']) }}" class="h-16 w-24 object-cover rounded-xl border border-slate-200 dark:border-slate-800 mb-2">
                                    @endif
                                    <input type="file" name="gallery_item_{{ $i }}_image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                </div>
                            </div>
                        @endfor
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs uppercase px-8 py-3 rounded-xl shadow-md shadow-blue-500/10">Simpan Perubahan Galeri</button>
                    </div>
                </form>
            </div>

            <!-- PANEL: TENTANG KAMI -->
            <div id="panel-tentang" class="role-panel hidden space-y-6">
                <div class="space-y-1">
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">Tentang Kami</h2>
                    <p class="text-slate-500 text-xs">Edit teks profil, visi, misi, legalitas, dan struktur organisasi.</p>
                </div>
                <form action="{{ route('superadmin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <input type="hidden" name="active_panel" value="panel-tentang">
                    <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 space-y-4 shadow-sm">
                        <h3 class="font-extrabold text-sm text-slate-800 dark:text-white uppercase tracking-wider">Profil Lembaga</h3>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Paragraf Profil 1</label>
                            <textarea name="tentang_profil_1" rows="4" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">{{ $settings['tentang_profil_1'] ?? '' }}</textarea>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Paragraf Profil 2</label>
                            <textarea name="tentang_profil_2" rows="3" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">{{ $settings['tentang_profil_2'] ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 space-y-4 shadow-sm">
                        <h3 class="font-extrabold text-sm text-slate-800 dark:text-white uppercase tracking-wider">Visi &amp; Misi</h3>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Visi</label>
                            <textarea name="tentang_visi" rows="2" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">{{ $settings['tentang_visi'] ?? '' }}</textarea>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Misi</label>
                            <textarea name="tentang_misi" rows="4" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">{{ $settings['tentang_misi'] ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 space-y-4 shadow-sm">
                        <h3 class="font-extrabold text-sm text-slate-800 dark:text-white uppercase tracking-wider">Struktur Organisasi</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Dewan Pembina</label>
                                <input type="text" name="org_director_dewan" value="{{ $settings['org_director_dewan'] ?? '' }}" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Direktur LPK</label>
                                <input type="text" name="org_director_lpk" value="{{ $settings['org_director_lpk'] ?? '' }}" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Bagan Organisasi (Organogram)</label>
                            @if(!empty($settings['org_image']))
                                <img src="{{ asset('storage/' . $settings['org_image']) }}" class="max-w-md h-auto rounded-xl border border-slate-200 dark:border-slate-800 mb-2">
                            @endif
                            <input type="file" name="org_image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs uppercase px-8 py-3 rounded-xl shadow-md shadow-blue-500/10">Simpan Perubahan</button>
                    </div>
                </form>
            </div>

            <!-- PANEL: PROGRAM PELATIHAN -->
            <div id="panel-program" class="role-panel hidden space-y-6">
                <div class="space-y-1">
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">Program Pelatihan</h2>
                    <p class="text-slate-500 text-xs">Ubah judul, harga, durasi, dan materi program pelatihan.</p>
                </div>
                <form action="{{ route('superadmin.settings.update') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="active_panel" value="panel-program">
                    @foreach([
                        ['key'=>'manajemen','label'=>'Program Manajemen Yayasan/Pesantren'],
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
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs uppercase px-8 py-3 rounded-xl shadow-md shadow-blue-500/10">Simpan Program Pelatihan</button>
                    </div>
                </form>
            </div>

            <!-- PANEL: JADWAL DIKLAT -->
            <div id="panel-jadwal" class="role-panel hidden space-y-6">
                <div class="space-y-1">
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">Jadwal Pelatihan &amp; Pendaftaran</h2>
                    <p class="text-slate-500 text-xs">Atur jadwal pelatihan terdekat, kuota, dan metode pelaksanaan.</p>
                </div>
                <form action="{{ route('superadmin.settings.update') }}" method="POST" class="space-y-6">
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
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs uppercase px-8 py-3 rounded-xl shadow-md shadow-blue-500/10">Simpan Jadwal Diklat</button>
                    </div>
                </form>
            </div>

            <!-- PANEL: INSTRUKTUR -->
            <div id="panel-instruktur-landing" class="role-panel hidden space-y-6">
                <div class="space-y-1">
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">Instruktur Publik</h2>
                    <p class="text-slate-500 text-xs">Edit data pengajar yang tertera di halaman depan.</p>
                </div>
                <form action="{{ route('superadmin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <input type="hidden" name="active_panel" value="panel-instruktur-landing">
                    <input type="hidden" name="instruktur_count" id="instruktur_count_input" value="{{ $settings['instruktur_count'] ?? 4 }}">
                    <div class="flex items-center gap-3">
                        <button type="button" onclick="adjustCount('instruktur', 1)" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase px-4 py-2 rounded-xl transition shadow">＋ Tambah Instruktur</button>
                        <button type="button" onclick="adjustCount('instruktur', -1)" class="bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs uppercase px-4 py-2 rounded-xl transition shadow">－ Hapus Terakhir</button>
                    </div>
                    <div id="instruktur-container" class="space-y-4">
                        @php $instrukturCount = (int) ($settings['instruktur_count'] ?? 4); @endphp
                        @for($i = 1; $i <= $instrukturCount; $i++)
                            <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 space-y-4 shadow-sm instruktur-card" data-index="{{ $i }}">
                                <h3 class="font-extrabold text-xs text-blue-600 dark:text-blue-400 uppercase tracking-wider">Instruktur #{{ $i }}</h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Nama Lengkap</label>
                                        <input type="text" name="instruktur_{{ $i }}_nama" value="{{ $settings['instruktur_'.$i.'_nama'] ?? '' }}" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Jabatan / Spesialisasi</label>
                                        <input type="text" name="instruktur_{{ $i }}_jabatan" value="{{ $settings['instruktur_'.$i.'_jabatan'] ?? '' }}" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Keahlian</label>
                                        <input type="text" name="instruktur_{{ $i }}_keahlian" value="{{ $settings['instruktur_'.$i.'_keahlian'] ?? '' }}" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Pengalaman</label>
                                        <input type="text" name="instruktur_{{ $i }}_pengalaman" value="{{ $settings['instruktur_'.$i.'_pengalaman'] ?? '' }}" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Foto Instruktur</label>
                                    @if(!empty($settings['instruktur_'.$i.'_foto']))
                                        <img src="{{ asset('storage/'.$settings['instruktur_'.$i.'_foto']) }}" class="h-16 w-16 object-cover rounded-xl border border-slate-200 dark:border-slate-800 mb-2">
                                    @endif
                                    <input type="file" name="instruktur_{{ $i }}_foto" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                </div>
                            </div>
                        @endfor
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs uppercase px-8 py-3 rounded-xl shadow-md shadow-blue-500/10">Simpan Instruktur</button>
                    </div>
                </form>
            </div>

            <!-- PANEL: FASILITAS -->
            <div id="panel-fasilitas" class="role-panel hidden space-y-6">
                <div class="space-y-1">
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">Fasilitas LPK</h2>
                    <p class="text-slate-500 text-xs">Ubah rincian fasilitas belajar, perpustakaan, dan asrama.</p>
                </div>
                <form action="{{ route('superadmin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
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
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs uppercase px-8 py-3 rounded-xl shadow-md shadow-blue-500/10">Simpan Fasilitas</button>
                    </div>
                </form>
            </div>

            <!-- PANEL: FAQ -->
            <div id="panel-faq" class="role-panel hidden space-y-6">
                <div class="space-y-1">
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">Pertanyaan Umum (FAQ)</h2>
                    <p class="text-slate-500 text-xs">Edit pertanyaan dan jawaban bantuan yang terbit di halaman muka.</p>
                </div>
                <form action="{{ route('superadmin.settings.update') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="active_panel" value="panel-faq">
                    <input type="hidden" name="faq_count" id="faq_count_input" value="{{ $settings['faq_count'] ?? 6 }}">
                    <div class="flex items-center gap-3">
                        <button type="button" onclick="adjustCount('faq', 1)" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase px-4 py-2 rounded-xl transition shadow">＋ Tambah FAQ</button>
                        <button type="button" onclick="adjustCount('faq', -1)" class="bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs uppercase px-4 py-2 rounded-xl transition shadow">－ Hapus Terakhir</button>
                    </div>
                    <div id="faq-container" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @php $faqCount = (int) ($settings['faq_count'] ?? 6); @endphp
                        @for($i = 1; $i <= $faqCount; $i++)
                            <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 space-y-3 shadow-sm faq-card" data-index="{{ $i }}">
                                <span class="text-[10px] font-bold text-blue-650 uppercase tracking-widest">FAQ #{{ $i }}</span>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Pertanyaan</label>
                                    <input type="text" name="faq_{{ $i }}_q" value="{{ $settings['faq_'.$i.'_q'] ?? '' }}" placeholder="Tulis pertanyaan..." class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Jawaban</label>
                                    <textarea name="faq_{{ $i }}_a" rows="2" placeholder="Tulis jawaban..." class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 resize-none font-semibold">{{ $settings['faq_'.$i.'_a'] ?? '' }}</textarea>
                                </div>
                            </div>
                        @endfor
                    </div>
                    <div class="flex justify-end pt-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs uppercase px-8 py-3 rounded-xl shadow-md shadow-blue-500/10">Simpan FAQ</button>
                    </div>
                </form>
            </div>

            <!-- PANEL: KABAR & ARTIKEL -->
            <div id="panel-articles" class="role-panel hidden space-y-6">
                <div class="space-y-1">
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">Kabar &amp; Artikel Publik</h2>
                    <p class="text-slate-500 text-xs">Unggah atau hapus artikel berita pengembangan kompetensi madrasah.</p>
                </div>
                <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 mb-6 shadow-sm space-y-4">
                    <h3 class="font-extrabold text-sm text-slate-800 dark:text-white uppercase tracking-wider">Tulis Artikel Baru</h3>
                    <form action="{{ route('superadmin.articles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Judul Artikel</label>
                            <input type="text" name="title" required placeholder="Tulis judul artikel..." class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Konten / Isi Artikel</label>
                            <textarea name="content" rows="6" required placeholder="Tulis isi berita lengkap..." class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold"></textarea>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Gambar Cover (Opsional)</label>
                            <input type="file" name="image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-650 hover:bg-blue-700 text-white font-extrabold text-xs uppercase px-6 py-3 rounded-xl shadow-md shadow-blue-500/10">Terbitkan Artikel</button>
                        </div>
                    </form>
                </div>

                <!-- Form Edit Artikel -->
                <div id="form-edit-article" class="hidden bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 mb-6 shadow-sm space-y-4">
                    <h3 class="font-extrabold text-sm text-slate-800 dark:text-white uppercase tracking-wider">Edit Artikel</h3>
                    <form id="edit-article-form-action" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Judul Artikel</label>
                            <input type="text" name="title" id="edit-article-title" required placeholder="Tulis judul artikel..." class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Konten / Isi Artikel</label>
                            <textarea name="content" id="edit-article-content" rows="6" required placeholder="Tulis isi berita lengkap..." class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold"></textarea>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Gambar Cover Baru (Opsional, kosongkan jika tidak diubah)</label>
                            <input type="file" name="image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                        <div class="flex justify-end gap-3">
                            <button type="button" onclick="cancelEditArticle()" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase px-4 py-2.5 rounded-xl">Batal</button>
                            <button type="submit" class="bg-blue-650 hover:bg-blue-700 text-white font-extrabold text-xs uppercase px-6 py-3 rounded-xl shadow-md shadow-blue-500/10">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>

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
                                        <button onclick='editArticle({!! json_encode($art) !!})' class="text-blue-600 hover:text-blue-850 text-[10px] font-bold uppercase">Edit</button>
                                        <form action="{{ route('superadmin.articles.destroy', $art->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-rose-600 hover:text-rose-800 text-[10px] font-bold uppercase">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-slate-500 text-xs py-4">Belum ada artikel diterbitkan.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- PANEL: KONTAK LPK -->
            <div id="panel-kontak" class="role-panel hidden space-y-6">
                <div class="space-y-1">
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">Kontak Publik</h2>
                    <p class="text-slate-500 text-xs">Ubah alamat kantor, nomor telepon, dan jam operasional LPK.</p>
                </div>
                <form action="{{ route('superadmin.settings.update') }}" method="POST" class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 space-y-5 shadow-sm">
                    @csrf
                    <input type="hidden" name="active_panel" value="panel-kontak">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Alamat Kantor</label>
                        <textarea name="kontak_alamat" rows="3" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">{{ $settings['kontak_alamat'] ?? '' }}</textarea>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">WhatsApp</label>
                        <input type="text" name="kontak_wa" value="{{ $settings['kontak_wa'] ?? '' }}" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Email</label>
                        <input type="email" name="kontak_email" value="{{ $settings['kontak_email'] ?? '' }}" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Jam Kerja</label>
                        <input type="text" name="kontak_jam" value="{{ $settings['kontak_jam'] ?? '' }}" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                    </div>
                    <div class="flex justify-end pt-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs uppercase px-6 py-3 rounded-xl shadow-md shadow-blue-500/10">Simpan Perubahan</button>
                    </div>
                </form>
            </div>

            <!-- PANEL: LIVE PREVIEW -->
            <div id="panel-preview" class="role-panel hidden space-y-6">
                <div class="space-y-1">
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">Pratinjau Langsung Website</h2>
                    <p class="text-slate-500 text-xs">Simulasi pratinjau halaman beranda utama.</p>
                </div>
                <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden h-[500px] shadow-sm relative">
                    <iframe id="preview-iframe" src="{{ route('home', ['preview' => 1]) }}" class="w-full h-full border-0 bg-white"></iframe>
                </div>
            </div>

            <!-- PANEL: MANAJEMEN USER -->
            <div id="panel-users" class="role-panel hidden space-y-6">
                <div class="space-y-1">
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">Kelola Akun Pengguna</h2>
                    <p class="text-slate-500 text-xs">Buat dan hapus hak akses user administrator atau asesor.</p>
                </div>
                <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm space-y-4">
                    <h3 class="font-extrabold text-sm text-slate-800 dark:text-white uppercase tracking-wider">Registrasi Akun Baru</h3>
                    <form action="{{ route('superadmin.user.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Username</label>
                                <input type="text" name="username" required placeholder="Contoh: admin_baru" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Email</label>
                                <input type="email" name="email" required placeholder="email@gmail.com" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-mono">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Role / Peran</label>
                                <select name="role" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                                    <option value="admin">Admin LPK</option>
                                    <option value="asesor">Asesor</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Password</label>
                                <input type="password" name="password" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Ulangi Password</label>
                                <input type="password" name="password_confirmation" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                            </div>
                        </div>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs uppercase px-6 py-3 rounded-xl shadow-md shadow-blue-500/10">Registrasi User</button>
                    </form>
                </div>

                <!-- Form Edit User -->
                <div id="form-edit-user" class="hidden bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm space-y-4">
                    <h3 class="font-extrabold text-sm text-slate-800 dark:text-white uppercase tracking-wider">Edit Akun Pengguna</h3>
                    <form id="edit-user-form-action" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Username</label>
                                <input type="text" name="username" id="edit-user-username" required placeholder="Contoh: admin_baru" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Email</label>
                                <input type="email" name="email" id="edit-user-email" required placeholder="email@gmail.com" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-mono font-semibold">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Role / Peran</label>
                                <select name="role" id="edit-user-role" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                                    <option value="admin">Admin LPK</option>
                                    <option value="asesor">Asesor</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Password Baru (Kosongkan jika tidak diubah)</label>
                                <input type="password" name="password" placeholder="Minimal 8 karakter" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <button type="button" onclick="cancelEditUser()" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase px-4 py-2.5 rounded-xl">Batal</button>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs uppercase px-6 py-3 rounded-xl shadow-md shadow-blue-500/10">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>

                <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm space-y-4">
                    <h3 class="font-extrabold text-sm text-slate-800 dark:text-white uppercase tracking-wider">Daftar Admin &amp; Asesor</h3>
                    <div class="space-y-2">
                        @foreach($admins as $admin)
                            <div class="flex items-center justify-between p-3 bg-white dark:bg-slate-950 rounded-xl border border-slate-200 dark:border-slate-800 text-xs">
                                <div>
                                    <div class="font-bold text-slate-800 dark:text-white">{{ $admin->name }}</div>
                                    <div class="text-slate-400 font-mono">{{ $admin->email }}</div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="bg-blue-50 text-blue-600 border border-blue-500/20 px-2 py-0.5 rounded font-bold uppercase text-[9px]">Admin</span>
                                    <div class="flex items-center gap-2">
                                        <button type="button" onclick='showUserDetail({!! json_encode($admin) !!})' class="text-[#155dfc] hover:underline font-bold uppercase text-[10px]">Detail</button>
                                        <button type="button" onclick='editUser({!! json_encode($admin) !!})' class="text-blue-600 hover:text-blue-800 font-bold uppercase text-[10px]">Edit</button>
                                        <form action="{{ route('superadmin.user.destroy', $admin->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-rose-600 hover:text-rose-800 font-bold uppercase text-[10px]">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        @foreach($asesors as $asesor)
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
                                        <form action="{{ route('superadmin.user.destroy', $asesor->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
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

            <!-- PANEL: DATA PROGRAM PELATIH -->
            <div id="panel-programs-db" class="role-panel hidden space-y-6">
                <div class="flex items-center justify-between">
                    <div class="space-y-1">
                        <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">Data Program Pelatihan</h2>
                        <p class="text-slate-500 text-xs">Kelola data program pelatihan yang aktif di database.</p>
                    </div>
                    <button onclick="toggleAddProgramForm()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase px-4 py-2.5 rounded-xl shadow-md shadow-blue-500/10">
                        + Tambah Program
                    </button>
                </div>

                <!-- Form Tambah Program -->
                <div id="form-add-program" class="hidden bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm space-y-4">
                    <h3 class="font-extrabold text-sm text-slate-800 dark:text-white uppercase tracking-wider">Program Pelatihan Baru</h3>
                    <form action="{{ route('superadmin.programs.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">ID / Slug Unik (misal: ssw_prog)</label>
                                <input type="text" name="id" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Judul Program</label>
                                <input type="text" name="title" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Kategori</label>
                                <input type="text" name="category" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Durasi</label>
                                <input type="text" name="duration" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Harga</label>
                                <input type="text" name="price" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Kata Kunci LSP (LSP Keyword)</label>
                                <input type="text" name="lsp_keyword" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Deskripsi</label>
                            <textarea name="description" required rows="3" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500"></textarea>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Manfaat / Fasilitas Tambahan (Pisahkan dengan koma)</label>
                            <input type="text" name="benefits" placeholder="Sertifikat LPK, Modul Pembelajaran, Konsultasi" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                        </div>
                        <div class="flex justify-end gap-3">
                            <button type="button" onclick="toggleAddProgramForm()" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase px-4 py-2.5 rounded-xl">Batal</button>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase px-4 py-2.5 rounded-xl">Simpan Program</button>
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
                                <input type="text" id="edit-program-id" disabled class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-450 font-semibold font-mono">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Judul Program</label>
                                <input type="text" name="title" id="edit-program-title" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Kategori</label>
                                <input type="text" name="category" id="edit-program-category" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Durasi</label>
                                <input type="text" name="duration" id="edit-program-duration" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Harga</label>
                                <input type="text" name="price" id="edit-program-price" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Kata Kunci LSP (LSP Keyword)</label>
                                <input type="text" name="lsp_keyword" id="edit-program-lsp-keyword" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Deskripsi</label>
                            <textarea name="description" id="edit-program-description" required rows="3" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500"></textarea>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Manfaat / Fasilitas Tambahan (Pisahkan dengan koma)</label>
                            <input type="text" name="benefits" id="edit-program-benefits" placeholder="Sertifikat LPK, Modul Pembelajaran, Konsultasi" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                        </div>
                        <div class="flex justify-end gap-3">
                            <button type="button" onclick="cancelEditProgram()" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs uppercase px-4 py-2.5 rounded-xl">Batal</button>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase px-4 py-2.5 rounded-xl">Simpan Perubahan</button>
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
                                            <div class="font-bold text-blue-600 dark:text-blue-400">{{ $prog->price }}</div>
                                            <div class="text-[10px] text-slate-400">{{ $prog->duration }}</div>
                                        </td>
                                        <td class="px-5 py-4">
                                            <div class="flex items-center justify-center gap-2">
                                                <button onclick='editProgram({!! json_encode($prog) !!})' class="text-blue-600 hover:text-blue-800 font-bold uppercase text-[10px]">Edit</button>
                                                <form action="{{ route('superadmin.programs.destroy', $prog->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus program ini?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-rose-600 hover:text-rose-800 font-bold uppercase text-[10px]">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-5 py-8 text-center text-slate-500">Belum ada program pelatihan di database.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                <!-- PANEL: DATA PENDAFTARAN PESERTA -->
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
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs uppercase px-6 py-3 rounded-xl shadow-md shadow-blue-500/10">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>

                <!-- Tabel List Pendaftaran -->
                <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm">
                    <div class="p-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                        <h3 class="font-extrabold text-sm text-slate-800 dark:text-white uppercase tracking-wider">Semua Pendaftaran</h3>
                        <input type="text" id="trainee-search" onkeyup="filterTrainees()" placeholder="Cari nama, NIK, atau program..." class="bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 w-64">
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
                                            <div class="text-slate-600 dark:text-slate-350">{{ $t->email }}</div>
                                            <div class="text-[10px] text-slate-400">{{ $t->phone }}</div>
                                        </td>
                                        <td class="px-5 py-4 trainee-program">
                                            <span class="font-medium text-slate-700 dark:text-slate-300">{{ $t->trainingProgram?->title ?? '-' }}</span>
                                        </td>
                                        <td class="px-5 py-4">
                                            @if($t->payment_status === 'PAID')
                                                <span class="bg-blue-50 text-blue-600 border border-blue-500/25 px-2 py-0.5 rounded font-bold uppercase text-[9px]">Lunas</span>
                                                <div class="text-[9px] text-slate-400 mt-1 font-mono">{{ $t->payment_method }}</div>
                                            @else
                                                <span class="bg-amber-50 text-amber-600 border border-amber-500/25 px-2 py-0.5 rounded font-bold uppercase text-[9px]">Belum Lunas</span>
                                                <form action="{{ route('superadmin.trainees.verify-payment', $t->id) }}" method="POST" class="mt-2">
                                                    @csrf
                                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-[9px] uppercase px-2 py-1 rounded">Verifikasi Lunas</button>
                                                </form>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4">
                                            @if($t->status === 'LULUS')
                                                <span class="bg-blue-50 text-blue-605 border border-blue-500/25 px-2 py-0.5 rounded font-bold uppercase text-[9px]">Kompeten (Lulus)</span>
                                                <div class="text-[9px] text-slate-450 mt-1 font-mono font-bold">{{ $t->certificate_number }}</div>
                                            @else
                                                <span class="bg-slate-100 text-slate-655 border border-slate-200 px-2 py-0.5 rounded font-bold uppercase text-[9px]">Menunggu Ujian / Kelulusan</span>
                                                <form action="{{ route('superadmin.trainees.approve', $t->id) }}" method="POST" class="mt-2">
                                                    @csrf
                                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-[9px] uppercase px-2 py-1 rounded">Terbitkan Sertifikat</button>
                                                </form>
                                            @endif
                                        </td>
                                        <td class="px-5 py-4">
                                            <div class="flex items-center justify-center gap-2">
                                                <button type="button" onclick='editTrainee({!! json_encode($t) !!})' class="text-blue-600 hover:text-blue-800 font-bold uppercase text-[10px]">Edit</button>
                                                <form action="{{ route('superadmin.trainees.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pendaftaran ini?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-rose-600 hover:text-rose-800 font-bold uppercase text-[10px]">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-5 py-8 text-center text-slate-500">Belum ada data pendaftaran di database.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- PANEL: PROFIL SUPERADMIN -->
            <div id="panel-profile" class="role-panel hidden space-y-6">
                <div class="space-y-1">
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">Profil IT Superadmin</h2>
                    <p class="text-slate-500 text-xs">Perbarui kredensial administrasi konsol Anda.</p>
                </div>
                <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 max-w-2xl shadow-sm">
                    <form action="{{ route('superadmin.profile.update') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Username</label>
                            <input type="text" name="username" value="{{ auth()->user()->username }}" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold font-mono">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Email</label>
                            <input type="email" name="email" value="{{ auth()->user()->email }}" required class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold font-mono">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Password Baru (Kosongkan jika tidak diubah)</label>
                            <input type="password" name="password" placeholder="Minimal 8 karakter" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Ulangi Password Baru</label>
                            <input type="password" name="password_confirmation" placeholder="Minimal 8 karakter" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                        </div>
                        <div class="flex justify-end pt-2">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs uppercase px-6 py-3 rounded-xl shadow-md shadow-blue-500/10">Perbarui Profil</button>
                        </div>
                    </form>
                </div>
            </div>

        </main>
    </div>

    <!-- SCRIPTS -->
    <script>
        const panels = [
            'panel-dasbor', 'panel-identity', 'panel-login-branding', 'panel-hero', 'panel-stats', 
            'panel-steps', 'panel-features', 'panel-gallery', 'panel-tentang', 'panel-program', 
            'panel-jadwal', 'panel-instruktur-landing', 'panel-fasilitas', 'panel-faq', 'panel-articles', 
            'panel-kontak', 'panel-preview', 'panel-users', 'panel-profile', 'panel-programs-db', 'panel-trainees-db'
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
            document.getElementById('edit-program-form-action').action = `/dashboard/superadmin/programs/${prog.id}`;
            
            // Scroll to form
            editDiv.scrollIntoView({ behavior: 'smooth' });
        }

        function cancelEditProgram() {
            document.getElementById('form-edit-program').classList.add('hidden');
        }

        // Dynamic items count modifier and templates
        function getInstrukturHtml(index) {
            return `
                <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 space-y-4 shadow-sm instruktur-card" data-index="${index}">
                    <h3 class="font-extrabold text-xs text-blue-600 dark:text-blue-400 uppercase tracking-wider">Instruktur #${index}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Nama Lengkap</label>
                            <input type="text" name="instruktur_${index}_nama" value="" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Jabatan / Spesialisasi</label>
                            <input type="text" name="instruktur_${index}_jabatan" value="" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Keahlian</label>
                            <input type="text" name="instruktur_${index}_keahlian" value="" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Pengalaman</label>
                            <input type="text" name="instruktur_${index}_pengalaman" value="" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Foto Instruktur</label>
                        <input type="file" name="instruktur_${index}_foto" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                </div>
            `;
        }

        function getGalleryHtml(index) {
            return `
                <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 space-y-4 shadow-sm gallery-card" data-index="${index}">
                    <h3 class="font-extrabold text-xs text-blue-600 dark:text-blue-400 uppercase tracking-wider">Item Galeri #${index}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Kategori</label>
                            <input type="text" name="gallery_item_${index}_category" value="" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Judul Item</label>
                            <input type="text" name="gallery_item_${index}_title" value="" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Deskripsi</label>
                        <textarea name="gallery_item_${index}_desc" rows="2" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 resize-none"></textarea>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Link Video (YouTube / Dll - Opsional)</label>
                        <input type="text" name="gallery_item_${index}_video_url" value="" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Foto Galeri</label>
                        <input type="file" name="gallery_item_${index}_image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>
                </div>
            `;
        }

        function getFaqHtml(index) {
            return `
                <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 space-y-3 shadow-sm faq-card" data-index="${index}">
                    <span class="text-[10px] font-bold text-blue-650 uppercase tracking-widest">FAQ #${index}</span>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Pertanyaan</label>
                        <input type="text" name="faq_${index}_q" value="" placeholder="Tulis pertanyaan..." class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Jawaban</label>
                        <textarea name="faq_${index}_a" rows="2" placeholder="Tulis jawaban..." class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 resize-none font-semibold"></textarea>
                    </div>
                </div>
            `;
        }

        function getStepHtml(index) {
            return `
                <div class="bg-white dark:bg-slate-950 p-4 border border-slate-200 dark:border-slate-800 rounded-xl space-y-2 step-card" data-index="${index}">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase">Langkah ${index}</label>
                    <input type="text" name="step_${index}_title" value="" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-lg px-3 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                </div>
            `;
        }

        function getFeatureHtml(index) {
            return `
                <div class="bg-white dark:bg-slate-950 p-4 border border-slate-200 dark:border-slate-800 rounded-xl space-y-2 feature-card" data-index="${index}">
                    <span class="text-[10px] font-bold text-slate-400 uppercase">Fitur ${index}</span>
                    <div>
                        <label class="block text-[9px] font-bold text-slate-450 uppercase mb-0.5">Judul</label>
                        <input type="text" name="feature_${index}_title" value="" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-lg px-3 py-1.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-[9px] font-bold text-slate-450 uppercase mb-0.5">Deskripsi</label>
                        <textarea name="feature_${index}_desc" rows="3" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-lg px-3 py-1.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 resize-none"></textarea>
                    </div>
                </div>
            `;
        }

        function getStatHtml(index) {
            return `
                <div class="bg-white dark:bg-slate-950 p-4 border border-slate-200 dark:border-slate-800 rounded-xl space-y-3 stat-card" data-index="${index}">
                    <div class="text-[10px] font-bold text-slate-400 uppercase">Statistik ${index}</div>
                    <div>
                        <label class="block text-[9px] font-bold text-slate-400 uppercase mb-1">Nilai</label>
                        <input type="text" name="stat_${index}_val" value="" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-lg px-3 py-1.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-[9px] font-bold text-slate-400 uppercase mb-1">Label</label>
                        <input type="text" name="stat_${index}_lbl" value="" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-lg px-3 py-1.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500">
                    </div>
                </div>
            `;
        }

        function adjustCount(type, delta) {
            const input = document.getElementById(type + '_count_input');
            const container = document.getElementById(type + '-container');
            if (!input || !container) return;

            let count = parseInt(input.value) || 0;
            let newCount = count + delta;

            if (newCount < 1) return;

            if (delta > 0) {
                let html = '';
                if (type === 'instruktur') html = getInstrukturHtml(newCount);
                else if (type === 'gallery') html = getGalleryHtml(newCount);
                else if (type === 'faq') html = getFaqHtml(newCount);
                else if (type === 'step') html = getStepHtml(newCount);
                else if (type === 'feature') html = getFeatureHtml(newCount);
                else if (type === 'stat') html = getStatHtml(newCount);

                container.insertAdjacentHTML('beforeend', html);
            } else {
                const cards = container.querySelectorAll('.' + type + '-card');
                if (cards.length > 0) {
                    cards[cards.length - 1].remove();
                }
            }

            input.value = newCount;
        }

        function editUser(user) {
            const editDiv = document.getElementById('form-edit-user');
            editDiv.classList.remove('hidden');
            document.getElementById('edit-user-username').value = user.username;
            document.getElementById('edit-user-email').value = user.email;
            document.getElementById('edit-user-role').value = user.role;
            document.getElementById('edit-user-form-action').action = `/dashboard/superadmin/users/${user.id}`;
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
            document.getElementById('edit-article-form-action').action = `/dashboard/superadmin/articles/${art.id}`;
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
            document.getElementById('edit-trainee-form-action').action = `/dashboard/superadmin/trainees/${t.id}`;
            editDiv.scrollIntoView({ behavior: 'smooth' });
        }

        function cancelEditTrainee() {
            document.getElementById('form-edit-trainee').classList.add('hidden');
        }

        // Trainee search filter
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

        function showPanel(id) {
            panels.forEach(p => {
                const el = document.getElementById(p);
                if (el) el.classList.add('hidden');
            });
            const activeEl = document.getElementById(id);
            if (activeEl) activeEl.classList.remove('hidden');

            document.querySelectorAll('#sa-sidebar button, #sa-sidebar a').forEach(b => {
                b.classList.remove('bg-blue-50', 'dark:bg-blue-950/20', 'text-blue-600', 'dark:text-blue-400');
                b.classList.add('text-slate-600', 'dark:text-slate-400');
            });

            // Find matching button id
            const rawId = id.replace('panel-', '');
            const btn = document.getElementById('btn-' + rawId);
            if (btn) {
                btn.classList.add('bg-blue-50', 'dark:bg-blue-950/20', 'text-blue-600', 'dark:text-blue-400');
                btn.classList.remove('text-slate-600', 'dark:text-slate-400');
            }

            localStorage.setItem('superadmin_active_panel', id);

            if (window.innerWidth < 1024) {
                document.getElementById('sa-sidebar').classList.remove('open');
            }
        }

        function toggleSidebar() {
            document.getElementById('sa-sidebar').classList.toggle('open');
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
            // Close other accordions
            document.querySelectorAll('.accordion-content').forEach(c => {
                if (c !== content) c.classList.add('hidden');
            });
            document.querySelectorAll('.accordion-arrow').forEach(a => {
                if (a !== arrow) a.style.transform = '';
            });
            if (!isOpen) {
                content.classList.remove('hidden');
                arrow.style.transform = 'rotate(180deg)';
            } else {
                content.classList.add('hidden');
                arrow.style.transform = '';
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
            const openPanel = urlParams.get('open') || localStorage.getItem('superadmin_active_panel') || 'panel-dasbor';
            showPanel(openPanel);
            updateThemeUI();

            const rawId = openPanel.replace('panel-', '');
            const activeBtn = document.getElementById('btn-' + rawId);
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
                    <span id="detail-user-email" class="font-semibold text-slate-800 dark:text-white font-mono">email@gmail.com</span>
                </div>
                <div class="border-b border-slate-100 dark:border-slate-800/80 pb-3">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Password Terdaftar</span>
                    <div class="flex items-center justify-between mt-1">
                        <span id="detail-user-password" class="font-bold text-slate-800 dark:text-white font-mono bg-slate-50 dark:bg-slate-900 px-2 py-1 rounded select-all">password</span>
                        <button onclick="togglePasswordVisibility()" class="text-blue-600 hover:underline font-bold uppercase text-[10px]">Tampilkan/Sembunyikan</button>
                    </div>
                </div>
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Akun Dibuat Pada</span>
                    <span id="detail-user-created" class="font-semibold text-slate-600 dark:text-slate-350">date</span>
                </div>
            </div>
            
            <div class="flex justify-end pt-2">
                <button onclick="closeUserDetailModal()" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-white font-extrabold text-xs uppercase tracking-wider rounded-xl transition duration-200">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</body>
</html>
