<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Instruktur — LPK MPI</title>
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
                        <div class="text-[10px] text-blue-600 font-bold tracking-widest uppercase">Instruktur</div>
                    </div>
                </div>
                <button type="button" onclick="toggleSidebar()" class="md:hidden text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="p-4 space-y-1 overflow-y-auto flex-1" id="sidebar-nav">

                <!-- Dasbor (standalone) -->
                <button type="button" onclick="showPanel('dasbor')" id="btn-dasbor" class="sidebar-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all text-left">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"/></svg>
                    <span>Dasbor</span>
                </button>

                <!-- Accordion: Pengajaran -->
                <div class="accordion-group">
                    <button type="button" class="accordion-trigger w-full flex items-center justify-between gap-3 px-4 py-3 rounded-xl text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all text-left" onclick="toggleAccordion(this)">
                        <span class="flex items-center gap-3">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            <span>Pengajaran</span>
                        </span>
                        <svg class="accordion-arrow w-4 h-4 shrink-0 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div class="accordion-content hidden pl-4 mt-1 space-y-1 border-l-2 border-blue-100 dark:border-blue-900 ml-6">
                        <button type="button" onclick="showPanel('kelas')" id="btn-kelas" class="sidebar-btn w-full flex items-center gap-2 px-3 py-2.5 rounded-lg text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all text-left">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            Kelas Saya
                        </button>
                        <button type="button" onclick="showPanel('modul')" id="btn-modul" class="sidebar-btn w-full flex items-center gap-2 px-3 py-2.5 rounded-lg text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all text-left">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            Manajemen Modul
                        </button>
                        <button type="button" onclick="showPanel('evaluasi')" id="btn-evaluasi" class="sidebar-btn w-full flex items-center gap-2 px-3 py-2.5 rounded-lg text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-950/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all text-left">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-300 shrink-0"></span>
                            Evaluasi Tugas
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

            <!-- Profile & Notifications -->
            <div class="flex items-center gap-4">
                <div class="relative cursor-pointer text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    <span class="absolute top-0 right-0 w-2.5 h-2.5 bg-blue-500 rounded-full ring-2 ring-white dark:ring-slate-950"></span>
                </div>

                <div class="flex items-center gap-3 pl-3 border-l border-slate-200 dark:border-slate-800">
                    <div class="text-right hidden sm:block">
                        <div class="text-xs font-bold text-slate-800 dark:text-slate-200">Ust. Sobirin, M.E.I</div>
                        <div class="text-[9px] font-bold text-slate-400 uppercase">Instruktur / Pengajar</div>
                    </div>
                    <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-bold shadow-md shadow-blue-500/10">
                        IS
                    </div>
                </div>
            </div>
        </header>

        <!-- MAIN AREA -->
        <main class="flex-1 p-6 max-w-6xl mx-auto w-full space-y-6">

            <!-- PANEL: DASBOR -->
            <div id="panel-dasbor" class="role-panel space-y-6">
                <!-- Summary Widgets -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-950/20 text-blue-600 flex items-center justify-center text-2xl">🏫</div>
                        <div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Program Pelatihan</div>
                            <div id="stat-programs" class="text-2xl font-black text-slate-800 dark:text-white mt-1">{{ \App\Models\TrainingProgram::count() }} Program</div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-amber-50 dark:bg-amber-950/20 text-amber-600 flex items-center justify-center text-2xl">📅</div>
                        <div>
                            <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Jadwal Mengajar Terdaftar</div>
                            <div id="stat-schedules" class="text-2xl font-black text-slate-800 dark:text-white mt-1">{{ \App\Models\ClassSchedule::count() }} Sesi</div>
                        </div>
                    </div>
                </div>

                <!-- Schedule Card & Latest Modules -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                    <!-- Schedule Card -->
                    <div class="md:col-span-6 bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm space-y-4">
                        <h3 class="font-extrabold text-sm text-slate-800 dark:text-white uppercase tracking-wider">Jadwal Mengajar Terdekat</h3>
                        @if($nextSchedule)
                        <div class="bg-white dark:bg-slate-950/60 p-4 border border-slate-200 dark:border-slate-800 rounded-xl space-y-3">
                            <div>
                                <div class="text-xs font-bold text-slate-800 dark:text-white">{{ $nextSchedule->trainingProgram->title ?? $nextSchedule->topic }}</div>
                                <div class="text-[11px] text-slate-500 font-mono mt-0.5">{{ \Carbon\Carbon::parse($nextSchedule->scheduled_at)->translatedFormat('l, d M Y — H:i') }} WIB</div>
                                <div class="text-[10px] text-slate-500 mt-1">📍 {{ $nextSchedule->location }}</div>
                                <div class="text-[10px] text-blue-600 font-bold uppercase mt-1">
                                    @if(\Carbon\Carbon::parse($nextSchedule->scheduled_at)->isToday())
                                        Status: Hari Ini
                                    @else
                                        Status: Terjadwal
                                    @endif
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="text-center py-6 text-slate-400 text-xs">
                            <div class="text-3xl mb-2">📅</div>
                            Belum ada jadwal mengajar mendatang.
                        </div>
                        @endif
                    </div>

                    <!-- List View: Real Programs/Schedules -->
                    <div class="md:col-span-6 bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-5 shadow-sm space-y-4">
                        <h3 class="font-extrabold text-sm text-slate-800 dark:text-white uppercase tracking-wider">Program Pelatihan Terdaftar</h3>
                        <div class="space-y-2">
                            @forelse($programs->take(4) as $prog)
                            <div class="flex items-center justify-between p-3 bg-white dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 rounded-xl">
                                <div>
                                    <div class="text-xs font-bold text-slate-800 dark:text-white">{{ $prog->title }}</div>
                                    <div class="text-[10px] text-slate-400 font-mono">{{ $prog->duration }} · {{ $prog->category }}</div>
                                </div>
                                <span class="bg-blue-50 dark:bg-blue-950/20 text-blue-600 dark:text-blue-400 border border-blue-500/20 px-2 py-0.5 rounded text-[9px] font-bold uppercase">Aktif</span>
                            </div>
                            @empty
                            <p class="text-xs text-slate-400 text-center py-4">Belum ada program pelatihan.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div id="panel-kelas" class="role-panel hidden space-y-6">
                <div class="space-y-1">
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">Kelas Pengajaran Aktif</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-xs">Jadwal mengajar yang telah ditugaskan kepada Anda.</p>
                </div>
                <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 shadow-sm">
                    @if($schedules->isEmpty())
                    <p class="text-center text-slate-400 text-xs py-8">Belum ada jadwal kelas yang ditugaskan.</p>
                    @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($schedules as $sched)
                        <div class="p-4 bg-white dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 rounded-2xl space-y-2">
                            <h3 class="font-extrabold text-sm text-slate-800 dark:text-white">{{ $sched->trainingProgram->title ?? $sched->topic }}</h3>
                            <p class="text-xs text-slate-500">📅 {{ \Carbon\Carbon::parse($sched->scheduled_at)->translatedFormat('d M Y, H:i') }} WIB</p>
                            <p class="text-xs text-slate-500">📍 {{ $sched->location }}</p>
                            <span class="inline-block text-[9px] font-bold uppercase px-2 py-0.5 rounded {{ \Carbon\Carbon::parse($sched->scheduled_at)->isPast() ? 'bg-slate-100 dark:bg-slate-800 text-slate-500' : 'bg-blue-50 dark:bg-blue-950/20 text-blue-600 dark:text-blue-400' }}">
                                {{ \Carbon\Carbon::parse($sched->scheduled_at)->isPast() ? 'Selesai' : 'Mendatang' }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            <!-- PANEL: MODUL -->
            <div id="panel-modul" class="role-panel hidden space-y-6">
                <div class="space-y-1">
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">Manajemen Modul &amp; Bahan Ajar</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-xs">Unggah modul pembelajaran baru bagi asesi LPK.</p>
                </div>
                <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 max-w-xl shadow-sm space-y-4">
                    <h3 class="font-extrabold text-sm text-slate-800 dark:text-white uppercase tracking-wider">Unggah Materi Baru</h3>
                    <form onsubmit="alert('Modul berhasil diunggah!'); return false;" class="space-y-4">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Judul Materi</label>
                            <input type="text" required placeholder="Contoh: Modul Evaluasi Kurikulum" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">File Modul (PDF)</label>
                            <input type="file" required class="w-full text-xs file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-extrabold text-xs uppercase px-6 py-3 rounded-xl shadow-md shadow-blue-500/10">Unggah Materi</button>
                    </form>
                </div>
            </div>

            <!-- PANEL: EVALUASI -->
            <div id="panel-evaluasi" class="role-panel hidden space-y-6">
                <div class="space-y-1">
                    <h2 class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">Evaluasi Ujian Asesi</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-xs">Hasil ujian kompetensi asesi pada skema yang Anda kelola.</p>
                </div>
                <div class="bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm">
                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-slate-100 dark:border-slate-800 text-slate-400 text-[10px] uppercase font-extrabold">
                                    <th class="px-5 py-3 text-left">Nama Asesi</th>
                                    <th class="px-5 py-3 text-left">Skema Ujian</th>
                                    <th class="px-5 py-3 text-left">Tanggal Selesai</th>
                                    <th class="px-5 py-3 text-center">Skor</th>
                                    <th class="px-5 py-3 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @forelse($attempts as $attempt)
                                <tr>
                                    <td class="px-5 py-4 font-bold text-slate-800 dark:text-white">{{ $attempt->asesi->name ?? '-' }}</td>
                                    <td class="px-5 py-4 text-xs text-slate-600 dark:text-slate-300">{{ $attempt->scheme->title ?? '-' }}</td>
                                    <td class="px-5 py-4 text-xs font-mono text-slate-500 dark:text-slate-400">
                                        {{ $attempt->completed_at ? \Carbon\Carbon::parse($attempt->completed_at)->format('d M Y') : '-' }}
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        <span class="font-black text-sm {{ ($attempt->score ?? 0) >= 75 ? 'text-emerald-600' : 'text-rose-500' }}">
                                            {{ $attempt->score !== null ? $attempt->score . '%' : '-' }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        <span class="px-2 py-0.5 rounded text-[9px] font-bold uppercase
                                            {{ $attempt->status === 'completed' ? 'bg-emerald-50 dark:bg-emerald-950/20 text-emerald-600' : 'bg-amber-50 dark:bg-amber-950/20 text-amber-600' }}">
                                            {{ $attempt->status === 'completed' ? 'Selesai' : 'Berlangsung' }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-10 text-center text-slate-400 text-xs">Belum ada hasil ujian asesi.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <!-- SCRIPTS -->
    <script>
        const panels = ['dasbor', 'kelas', 'modul', 'evaluasi'];

        function updateDocumentTitle(panelId) {
            let sectionTitle = "";
            switch(panelId) {
                case 'dasbor': sectionTitle = "Dasbor Pengajaran"; break;
                case 'kelas': sectionTitle = "Kelas Saya"; break;
                case 'modul': sectionTitle = "Manajemen Modul"; break;
                case 'evaluasi': sectionTitle = "Evaluasi Tugas"; break;
                default: sectionTitle = "Dasbor";
            }
            const siteName = "{{ $siteName }}";
            document.title = `${sectionTitle} — Instruktur — ${siteName}`;
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

            localStorage.setItem('instruktur_active_panel', id);
            
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
    </script>

    @include('layouts.partials.live_refresh', [
        'statsUrl' => route('instruktur.stats'),
        'statMap'  => [
            'stat-programs'  => 'programs',
            'stat-schedules' => 'schedules',
        ]
    ])
</body>
</html>
