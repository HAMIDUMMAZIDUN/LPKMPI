<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Peserta — LPK MPI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { darkMode: 'class' }</script>
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .dark .glass { background: rgba(15,23,42,0.85); border-color: rgba(255,255,255,0.07); }
        html:not(.dark) .glass { background: rgba(248,250,252,0.85); border-color: rgba(0,0,0,0.08); }
        .glass { backdrop-filter: blur(20px); transition: all 0.3s ease; }
        *, ::before, ::after { border-radius: 0px !important; }
        .text-\[9px\]  { font-size: 0.75rem !important; }
        .text-\[10px\] { font-size: 0.75rem !important; }
        .text-\[11px\] { font-size: 0.875rem !important; }

        /* ======== ICON SIDEBAR ======== */
        #asi-sidebar {
            position: fixed; top: 0; left: 0; height: 100%;
            width: 64px;
            transition: width 0.3s cubic-bezier(.4,0,.2,1);
            overflow: hidden; white-space: nowrap;
            background: #0f172a;
            border-right: 1px solid rgba(255,255,255,0.07);
            display: flex; flex-direction: column; z-index: 40;
        }
        #asi-sidebar:hover { width: 220px; }
        #asi-main { margin-left: 64px; }

        .nav-item {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 18px; cursor: pointer; border: none; background: none;
            width: 100%; color: #94a3b8; font-size: 11px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.08em;
            transition: background 0.15s, color 0.15s; text-align: left; text-decoration: none;
        }
        .nav-item:hover, .nav-item.active { background: rgba(139,92,246,0.12); color: #fff; }
        .nav-item.active { color: #a78bfa; }
        .nav-item .nav-icon { flex-shrink: 0; width: 22px; height: 22px; display: flex; align-items: center; justify-content: center; }
        .nav-item .nav-label { opacity: 0; transition: opacity 0.2s ease 0.05s; overflow: hidden; }
        #asi-sidebar:hover .nav-label { opacity: 1; }
        .nav-divider { border-top: 1px solid rgba(255,255,255,0.07); margin: 6px 0; }
        .nav-section-title {
            padding: 10px 18px 4px; font-size: 9px; font-weight: 900;
            letter-spacing: 0.12em; text-transform: uppercase; color: #475569;
            opacity: 0; transition: opacity 0.2s ease; white-space: nowrap;
        }
        #asi-sidebar:hover .nav-section-title { opacity: 1; }
        .sidebar-logo { display: flex; align-items: center; gap: 12px; padding: 18px 18px 14px; border-bottom: 1px solid rgba(255,255,255,0.07); }
        .sidebar-logo .logo-icon {
            flex-shrink: 0; width: 28px; height: 28px;
            background: linear-gradient(135deg, #7c3aed, #4f46e5);
            border-radius: 8px !important; display: flex; align-items: center;
            justify-content: center; font-size: 13px; font-weight: 900; color: #fff;
        }
        .sidebar-logo .logo-text { opacity: 0; transition: opacity 0.2s ease; }
        #asi-sidebar:hover .logo-text { opacity: 1; }
        .sidebar-footer { padding: 12px 0; border-top: 1px solid rgba(255,255,255,0.07); }

        /* Light mode */
        html:not(.dark) body { background-color: #f1f5f9 !important; color: #0f172a !important; }
        html:not(.dark) #asi-sidebar { background: #fff; border-right: 1px solid #e2e8f0; }
        html:not(.dark) .nav-item { color: #64748b; }
        html:not(.dark) .nav-item:hover, html:not(.dark) .nav-item.active { background: rgba(139,92,246,0.08); color: #4c1d95; }
        html:not(.dark) .sidebar-logo, html:not(.dark) .sidebar-footer { border-color: #e2e8f0; }
        html:not(.dark) .nav-divider { border-color: #e2e8f0; }
        html:not(.dark) .text-white { color: #0f172a !important; }
        html:not(.dark) .text-slate-400 { color: #475569 !important; }
        html:not(.dark) .border-slate-800 { border-color: #cbd5e1 !important; }
        html:not(.dark) .bg-slate-900\/80 { background-color: rgba(255,255,255,0.9) !important; border-color: #cbd5e1 !important; }
        html:not(.dark) .sticky h1 { color: #0f172a !important; }
    </style>
</head>
<body class="min-h-screen bg-slate-100 dark:bg-slate-950 text-slate-950 dark:text-white transition-colors duration-300">

    <!-- ICON SIDEBAR — Peserta -->
    <aside id="asi-sidebar">
        <div class="sidebar-logo">
            <div class="logo-icon">P</div>
            <div class="logo-text">
                <div style="font-size:11px;font-weight:900;color:#a78bfa;letter-spacing:.1em;line-height:1;">LPK MPI</div>
                <div style="font-size:10px;color:#94a3b8;font-weight:600;">Peserta</div>
            </div>
        </div>

        <nav style="flex:1;overflow-y:auto;overflow-x:hidden;padding:12px 0;">
            <div class="nav-section-title">Menu Peserta</div>

            <button onclick="showAsiPanel('p-exam-list')" id="btn-p-exam-list" class="nav-item">
                <span class="nav-icon"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg></span>
                <span class="nav-label">Ujian &amp; Evaluasi</span>
            </button>

            <button onclick="showAsiPanel('p-modules')" id="btn-p-modules" class="nav-item">
                <span class="nav-icon"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg></span>
                <span class="nav-label">Modul Belajar</span>
            </button>

            <button onclick="showAsiPanel('p-attendance')" id="btn-p-attendance" class="nav-item">
                <span class="nav-icon"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M16 2v4M8 2v4M3 10h18m-9 4l2 2 4-4"/></svg></span>
                <span class="nav-label">Absensi</span>
            </button>

            <button onclick="showAsiPanel('p-certificates')" id="btn-p-certificates" class="nav-item">
                <span class="nav-icon"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg></span>
                <span class="nav-label">Sertifikat</span>
            </button>

            <button onclick="showAsiPanel('p-payments')" id="btn-p-payments" class="nav-item">
                <span class="nav-icon"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg></span>
                <span class="nav-label">Keuangan</span>
            </button>

            <div class="nav-divider"></div>

            <a href="{{ route('home') }}" class="nav-item">
                <span class="nav-icon"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg></span>
                <span class="nav-label">Website Utama</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <button onclick="showAsiPanel('p-profile')" id="btn-p-profile" class="nav-item">
                <span class="nav-icon"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="7" r="4"/><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/></svg></span>
                <span class="nav-label">Profil Saya</span>
            </button>

            <button onclick="toggleAsiTheme()" class="nav-item">
                <span class="nav-icon"><span id="asi-theme-icon" style="font-size:18px;">🌙</span></span>
                <span class="nav-label" id="asi-theme-label">Mode Gelap</span>
            </button>

            <form action="{{ route('logout') }}" method="POST">@csrf
                <button type="submit" class="nav-item" style="color:#f87171;">
                    <span class="nav-icon"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg></span>
                    <span class="nav-label">Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div id="asi-main" class="min-h-screen">
        <!-- Topbar -->
        <div class="sticky top-0 z-30 bg-slate-900/80 backdrop-blur border-b border-slate-800 px-6 py-4 flex items-center justify-between">
            <div>
                <div class="text-xs font-black uppercase tracking-widest text-violet-400 mb-0.5">LPK MPI</div>
                <h1 class="font-black text-white text-sm">Selamat Datang, {{ auth()->user()->name }}</h1>
            </div>
            <div class="flex items-center gap-2">
                <div class="hidden sm:flex items-center gap-2 bg-violet-500/10 border border-violet-500/20 px-3 py-1.5 rounded-full">
                    <span class="w-1.5 h-1.5 rounded-full bg-violet-400 animate-pulse"></span>
                    <span class="text-[10px] font-bold text-violet-400 uppercase tracking-wider">Peserta Aktif</span>
                </div>
            </div>
        </div>

    <div class="max-w-5xl mx-auto p-6 space-y-8">
        @if(session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                <svg class="w-4.5 h-4.5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div id="p-exam-list" class="asi-panel space-y-6">
        <div>
            <h2 class="text-2xl font-black text-white mb-2">Ujian & Evaluasi Tersedia</h2>
            <p class="text-slate-400 text-sm">Pilih ujian/evaluasi program yang ingin Anda kerjakan. Setiap evaluasi hanya dapat dikerjakan sekali.</p>
        </div>

        @if($schemes->isEmpty())
            <div class="glass rounded-2xl p-16 text-center flex flex-col items-center justify-center">
                <svg class="w-16 h-16 text-slate-500 mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 13.5h3.86a2.25 2.25 0 012.008 1.24l.885 1.77a2.25 2.25 0 002.007 1.24h1.98a2.25 2.25 0 002.007-1.24l.885-1.77a2.25 2.25 0 012.007-1.24h3.86m-18 0h18m-18 0V9a2.25 2.25 0 012.25-2.25h13.5a2.25 2.25 0 012.25 2.25v4.5m-18 0V18a2.25 2.25 0 002.25 2.25h13.5A2.25 2.25 0 0021 18v-4.5m-9-9h.008v.008H12V3.75z"></path>
                </svg>
                <h3 class="text-white font-bold text-lg mb-2">Belum Ada Ujian Tersedia</h3>
                <p class="text-slate-400 text-sm">Pengajar belum mempublikasikan ujian atau evaluasi untuk program ini.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                @foreach($schemes as $scheme)
                    @php
                        $attempt = $attempts[$scheme->id] ?? null;
                        $isDone = $attempt && $attempt->status === 'completed';
                        $isInProgress = $attempt && $attempt->status === 'in_progress';
                    @endphp
                    <div class="glass rounded-2xl p-6 flex flex-col gap-4 {{ $isDone ? 'opacity-75' : '' }} hover:border-blue-500/30 transition-all">
                        <div class="flex items-start justify-between gap-2">
                            <div class="flex-1">
                                <h3 class="font-bold text-white text-base leading-tight mb-1">{{ $scheme->title }}</h3>
                                @if($scheme->description)
                                    <p class="text-slate-400 text-xs leading-relaxed">{{ $scheme->description }}</p>
                                @endif
                            </div>
                            @if($isDone)
                                @php $grade = $attempt->score >= 70 ? 'Lulus' : 'Belum Lulus' @endphp
                                <span class="shrink-0 {{ $attempt->score >= 70 ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' : 'bg-rose-500/10 text-rose-400 border-rose-500/20' }} border px-2 py-0.5 rounded-full text-[9px] font-black uppercase">
                                    {{ $attempt->score }}%
                                </span>
                            @endif
                        </div>

                        <div class="grid grid-cols-3 gap-3 text-center">
                            <div class="bg-slate-900/60 rounded-lg p-2">
                                <div class="text-base font-black text-white">{{ $scheme->questions_count }}</div>
                                <div class="text-[9px] text-slate-500 font-bold uppercase">Soal</div>
                            </div>
                            <div class="bg-slate-900/60 rounded-lg p-2">
                                <div class="text-base font-black text-white">{{ $scheme->duration_minutes }}</div>
                                <div class="text-[9px] text-slate-500 font-bold uppercase">Menit</div>
                            </div>
                            <div class="bg-slate-900/60 rounded-lg p-2">
                                <div class="text-base font-black text-white">{{ $scheme->asesor?->name ? substr($scheme->asesor->name, 0, 8) . (strlen($scheme->asesor->name) > 8 ? '...' : '') : '-' }}</div>
                                <div class="text-[9px] text-slate-500 font-bold uppercase">Instruktur</div>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            @if($isDone)
                                <a href="{{ route('asesi.result', $attempt->id) }}"
                                    class="flex-1 text-center bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs uppercase tracking-wider py-2.5 rounded-lg transition-all">
                                    Lihat Hasil
                                </a>
                                <div class="{{ $attempt->score >= 70 ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-rose-500/10 text-rose-400 border border-rose-500/20' }} text-xs font-bold uppercase px-3 py-2.5 rounded-lg">
                                    {{ $grade }}
                                </div>
                            @elseif($isInProgress)
                                <a href="{{ route('asesi.exam.start', $scheme->id) }}"
                                    class="flex-1 text-center bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs uppercase tracking-wider py-2.5 rounded-lg transition-all">
                                    Lanjutkan Ujian
                                </a>
                            @else
                                <a href="{{ route('asesi.exam.start', $scheme->id) }}"
                                    class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase tracking-wider py-2.5 rounded-lg transition-all shadow-lg shadow-blue-500/20">
                                    Mulai Kerjakan
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        </div>

        {{-- Panel: Akses Modul --}}
        <div id="p-modules" class="asi-panel hidden space-y-6">
            <div>
                <h2 class="text-2xl font-black text-white mb-2">Akses Modul Belajar</h2>
                <p class="text-slate-400 text-sm">Unduh materi pembelajaran, standard operating procedure (SOP), dan buku panduan pelatihan.</p>
            </div>

            @if($enrollments->isEmpty())
                <div class="glass rounded-2xl p-12 text-center">
                    <p class="text-slate-400">Anda belum terdaftar di program pelatihan apapun. Silakan daftar program terlebih dahulu.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($enrollments as $enr)
                        <div class="glass rounded-2xl p-6 space-y-4">
                            <div class="border-b border-slate-800 pb-3">
                                <span class="text-[10px] bg-blue-500/10 text-blue-400 border border-blue-500/20 px-2.5 py-0.5 rounded font-bold uppercase tracking-wider">{{ $enr->trainingProgram?->category }}</span>
                                <h3 class="text-lg font-bold text-white mt-2">{{ $enr->trainingProgram?->title }}</h3>
                            </div>
                            
                            <div class="space-y-3">
                                <div class="flex items-center justify-between p-3 bg-slate-900/60 border border-slate-800 rounded-lg">
                                    <div>
                                        <div class="text-xs font-bold text-white">Buku Panduan Teori Dasar</div>
                                        <div class="text-[10px] text-slate-500 font-mono">PDF — 4.2 MB</div>
                                    </div>
                                    <a href="#" onclick="alert('Mengunduh Modul Teori Dasar...'); return false;" class="bg-blue-600/10 hover:bg-blue-600 hover:text-white border border-blue-500/20 text-blue-400 text-xs font-bold px-3 py-1.5 rounded transition-all">Unduh</a>
                                </div>

                                <div class="flex items-center justify-between p-3 bg-slate-900/60 border border-slate-800 rounded-lg">
                                    <div>
                                        <div class="text-xs font-bold text-white">Standard Operating Procedure (SOP)</div>
                                        <div class="text-[10px] text-slate-500 font-mono">PDF — 2.8 MB</div>
                                    </div>
                                    <a href="#" onclick="alert('Mengunduh SOP Praktik...'); return false;" class="bg-blue-600/10 hover:bg-blue-600 hover:text-white border border-blue-500/20 text-blue-400 text-xs font-bold px-3 py-1.5 rounded transition-all">Unduh</a>
                                </div>

                                <div class="flex items-center justify-between p-3 bg-slate-900/60 border border-slate-800 rounded-lg">
                                    <div>
                                        <div class="text-xs font-bold text-white">Materi Praktikum &amp; Studi Kasus</div>
                                        <div class="text-[10px] text-slate-500 font-mono">PDF — 8.5 MB</div>
                                    </div>
                                    <a href="#" onclick="alert('Mengunduh Materi Praktikum...'); return false;" class="bg-blue-600/10 hover:bg-blue-600 hover:text-white border border-blue-500/20 text-blue-400 text-xs font-bold px-3 py-1.5 rounded transition-all">Unduh</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Panel: Absensi / Presensi --}}
        <div id="p-attendance" class="asi-panel hidden space-y-6">
            <div>
                <h2 class="text-2xl font-black text-white mb-2">Presensi Kehadiran Kelas</h2>
                <p class="text-slate-400 text-sm">Lihat jadwal kelas pembelajaran aktif dan lakukan check-in kehadiran mandiri.</p>
            </div>

            <div class="glass rounded-2xl overflow-hidden">
                <div class="overflow-x-auto w-full">
                    <table class="w-full text-sm">
                        <thead><tr class="border-b border-slate-800 text-slate-400 text-[10px] uppercase font-bold">
                            <th class="px-5 py-3 text-left">Program &amp; Topik Kelas</th>
                            <th class="px-5 py-3 text-left">Instruktur</th>
                            <th class="px-5 py-3 text-left">Waktu Pelaksanaan</th>
                            <th class="px-5 py-3 text-left">Tautan / Lokasi</th>
                            <th class="px-5 py-3 text-center">Status Kehadiran</th>
                        </tr></thead>
                        <tbody class="divide-y divide-slate-800">
                            @forelse($schedules as $sch)
                                <tr>
                                    <td class="px-5 py-3">
                                        <div class="font-bold text-white">{{ $sch->trainingProgram?->title }}</div>
                                        <div class="text-slate-400 text-xs mt-0.5">{{ $sch->topic }}</div>
                                    </td>
                                    <td class="px-5 py-3 text-slate-300 text-xs">{{ $sch->instructor?->name ?? '-' }}</td>
                                    <td class="px-5 py-3 text-slate-300 text-xs font-mono">{{ $sch->scheduled_at->format('d M Y H:i') }} WIB</td>
                                    <td class="px-5 py-3 text-slate-400 text-xs">{{ $sch->location }}</td>
                                    <td class="px-5 py-3 text-center">
                                        <div id="attendance-status-{{ $sch->id }}">
                                            <button onclick="recordLocalAttendance({{ $sch->id }})" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase px-4 py-1.5 rounded transition-all">Absen Hadir</button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="px-5 py-8 text-center text-slate-500">Belum ada jadwal kelas terdaftar untuk program Anda.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Panel: Sertifikat Digital --}}
        <div id="p-certificates" class="asi-panel hidden space-y-6">
            <div>
                <h2 class="text-2xl font-black text-white mb-2">Sertifikat Digital Saya</h2>
                <p class="text-slate-400 text-sm">Unduh sertifikat resmi kelulusan setelah Anda berhasil menyelesaikan seluruh rangkaian pelatihan.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($enrollments as $enr)
                    <div class="glass rounded-2xl p-6 flex flex-col justify-between gap-4">
                        <div>
                            <div class="flex justify-between items-start">
                                <h3 class="font-bold text-white text-base">{{ $enr->trainingProgram?->title }}</h3>
                                @if($enr->status === 'LULUS')
                                    <span class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-2 py-0.5 rounded text-[10px] font-bold uppercase">Lulus</span>
                                @else
                                    <span class="bg-amber-500/10 text-amber-400 border border-amber-500/20 px-2 py-0.5 rounded text-[10px] font-bold uppercase">Aktif / Belum Evaluasi</span>
                                @endif
                            </div>
                            <p class="text-slate-400 text-xs mt-2">Nomor NIK: {{ $enr->nik }}</p>
                        </div>

                        <div class="border-t border-slate-800 pt-4 flex items-center justify-between">
                            @if($enr->status === 'LULUS')
                                <div>
                                    <div class="text-[10px] text-slate-500 uppercase font-bold">No. Sertifikat</div>
                                    <div class="text-xs font-mono font-bold text-white">{{ $enr->certificate_number }}</div>
                                </div>
                                <a href="{{ route('asesi.certificate.download', $enr->id) }}" target="_blank" class="bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs uppercase px-4 py-2 rounded transition-all shadow-lg shadow-amber-500/10">Buka Sertifikat</a>
                            @else
                                <span class="text-slate-500 text-xs italic">Sertifikat belum diterbitkan</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="glass rounded-2xl p-12 text-center md:col-span-2">
                        <p class="text-slate-400">Belum ada riwayat pendaftaran program.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Panel: Keuangan / Riwayat Pembayaran --}}
        <div id="p-payments" class="asi-panel hidden space-y-6">
            <div>
                <h2 class="text-2xl font-black text-white mb-2">Riwayat Pembayaran &amp; Keuangan</h2>
                <p class="text-slate-400 text-sm">Pantau status pembayaran biaya investasi program pelatihan Anda secara detail.</p>
            </div>

            <div class="glass rounded-2xl overflow-hidden">
                <div class="overflow-x-auto w-full">
                    <table class="w-full text-sm">
                        <thead><tr class="border-b border-slate-800 text-slate-400 text-[10px] uppercase font-bold">
                            <th class="px-5 py-3 text-left">Program Pelatihan</th>
                            <th class="px-5 py-3 text-left">Biaya Investasi</th>
                            <th class="px-5 py-3 text-left">Nomor Referensi</th>
                            <th class="px-5 py-3 text-left">Tanggal Daftar</th>
                            <th class="px-5 py-3 text-center">Status Pembayaran</th>
                        </tr></thead>
                        <tbody class="divide-y divide-slate-800">
                            @forelse($enrollments as $enr)
                                <tr>
                                    <td class="px-5 py-3 font-bold text-white">{{ $enr->trainingProgram?->title }}</td>
                                    <td class="px-5 py-3 text-slate-300 font-bold font-mono">Rp {{ number_format($enr->trainingProgram?->price ?? 0, 0, ',', '.') }}</td>
                                    <td class="px-5 py-3 text-slate-400 text-xs font-mono">{{ $enr->payment_reference ?? '-' }}</td>
                                    <td class="px-5 py-3 text-slate-300 text-xs">{{ $enr->created_at->format('d M Y') }}</td>
                                    <td class="px-5 py-3 text-center">
                                        @if($enr->payment_status === 'PAID')
                                            <span class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-2 py-0.5 rounded text-[10px] font-bold uppercase">Lunas</span>
                                        @elseif($enr->payment_status === 'PENDING')
                                            <span class="bg-amber-500/10 text-amber-400 border border-amber-500/20 px-2 py-0.5 rounded text-[10px] font-bold uppercase">Pending Verifikasi</span>
                                        @else
                                            <span class="bg-rose-500/10 text-rose-400 border border-rose-500/20 px-2 py-0.5 rounded text-[10px] font-bold uppercase">Belum Bayar</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="px-5 py-8 text-center text-slate-500">Belum ada riwayat transaksi keuangan.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Panel: Profil Saya --}}
        <div id="p-profile" class="asi-panel hidden space-y-6">
            <div>
                <h2 class="text-2xl font-black text-white mb-2">Profil Saya</h2>
                <p class="text-slate-400 text-sm">Ubah nama pengguna, email, dan kata sandi akun Peserta Anda.</p>
            </div>
            <div class="glass rounded-2xl p-6 max-w-2xl">
                <form action="{{ route('asesi.profile.update') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Username</label>
                        <input type="text" name="username" value="{{ auth()->user()->username }}" required
                            class="w-full bg-slate-900 border border-slate-800 rounded-lg px-4 py-2.5 text-sm text-white focus:outline-none focus:border-blue-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Email</label>
                        <input type="email" name="email" value="{{ auth()->user()->email }}" required placeholder="peserta@gmail.com"
                            class="w-full bg-slate-900 border border-slate-800 rounded-lg px-4 py-2.5 text-sm text-white focus:outline-none focus:border-blue-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Kata Sandi Baru (Kosongkan jika tidak diubah)</label>
                        <input type="password" name="password" placeholder="Min 6 karakter"
                            class="w-full bg-slate-900 border border-slate-800 rounded-lg px-4 py-2.5 text-sm text-white focus:outline-none focus:border-blue-500 transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi baru"
                            class="w-full bg-slate-900 border border-slate-800 rounded-lg px-4 py-2.5 text-sm text-white focus:outline-none focus:border-blue-500 transition-all">
                    </div>
                    <div class="flex justify-end pt-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase tracking-wider px-6 py-3 rounded-lg transition-all shadow-lg shadow-blue-500/20">
                            Simpan Profil
                        </button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    <script>
        const allAsiPanels = ['p-exam-list', 'p-modules', 'p-attendance', 'p-certificates', 'p-payments', 'p-profile'];
        function showAsiPanel(id) {
            allAsiPanels.forEach(p => {
                const el = document.getElementById(p);
                if(el) el.classList.add('hidden');
            });
            const activeEl = document.getElementById(id);
            if(activeEl) activeEl.classList.remove('hidden');

            document.querySelectorAll('.nav-item').forEach(b => b.classList.remove('active'));
            const btn = document.getElementById('btn-' + id);
            if(btn) btn.classList.add('active');

            localStorage.setItem('asesi_panel', id);
        }

        function toggleAsiTheme() {
            const html = document.documentElement;
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.setItem('lpk_theme', 'light');
            } else {
                html.classList.add('dark');
                localStorage.setItem('lpk_theme', 'dark');
            }
            updateAsiThemeIcon();
        }

        function updateAsiThemeIcon() {
            const icon  = document.getElementById('asi-theme-icon');
            const label = document.getElementById('asi-theme-label');
            const isDark = document.documentElement.classList.contains('dark');
            if (icon)  icon.textContent  = isDark ? '🌙' : '☀️';
            if (label) label.textContent = isDark ? 'Mode Gelap' : 'Mode Terang';
        }


        function recordLocalAttendance(id) {
            localStorage.setItem('attendance_' + id, 'present');
            updateAttendanceUI(id);
            alert('Kehadiran Anda berhasil dicatat untuk sesi ini!');
        }

        function updateAttendanceUI(id) {
            const container = document.getElementById('attendance-status-' + id);
            if (container) {
                container.innerHTML = '<span class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-3 py-1.5 rounded text-xs font-bold uppercase">✓ Hadir</span>';
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            showAsiPanel(localStorage.getItem('asesi_panel') || 'p-exam-list');
            updateAsiThemeIcon();

            // Restore attendance status from localStorage
            document.querySelectorAll('[id^="attendance-status-"]').forEach(el => {
                const id = el.id.replace('attendance-status-', '');
                if (localStorage.getItem('attendance_' + id) === 'present') {
                    updateAttendanceUI(id);
                }
            });
        });
    </script>
    </div><!-- end #asi-main -->
</body>
</html>

