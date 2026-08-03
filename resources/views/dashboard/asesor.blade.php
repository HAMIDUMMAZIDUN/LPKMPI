<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Instruktur — LPK MPI</title>
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
        #asr-sidebar {
            width: 64px;
            transition: width 0.3s cubic-bezier(.4,0,.2,1);
            overflow: hidden;
            white-space: nowrap;
        }
        #asr-sidebar:hover { width: 220px; }
        #asr-main { margin-left: 64px; }

        .nav-item {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 18px; cursor: pointer; border: none; background: none;
            width: 100%; color: #94a3b8; font-size: 11px; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.08em;
            transition: background 0.15s, color 0.15s; text-align: left; text-decoration: none;
        }
        .nav-item:hover, .nav-item.active { background: rgba(16,185,129,0.10); color: #fff; }
        .nav-item.active { color: #34d399; }
        .nav-item .nav-icon { flex-shrink: 0; width: 22px; height: 22px; display: flex; align-items: center; justify-content: center; }
        .nav-item .nav-label { opacity: 0; transition: opacity 0.2s ease 0.05s; overflow: hidden; }
        #asr-sidebar:hover .nav-label { opacity: 1; }
        .nav-divider { border-top: 1px solid rgba(255,255,255,0.07); margin: 6px 0; }
        .nav-section-title {
            padding: 10px 18px 4px; font-size: 9px; font-weight: 900;
            letter-spacing: 0.12em; text-transform: uppercase; color: #475569;
            opacity: 0; transition: opacity 0.2s ease; white-space: nowrap;
        }
        #asr-sidebar:hover .nav-section-title { opacity: 1; }
        .sidebar-logo { display: flex; align-items: center; gap: 12px; padding: 18px 18px 14px; border-bottom: 1px solid rgba(255,255,255,0.07); }
        .sidebar-logo .logo-icon {
            flex-shrink: 0; width: 28px; height: 28px;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 8px !important; display: flex; align-items: center;
            justify-content: center; font-size: 13px; font-weight: 900; color: #fff;
        }
        .sidebar-logo .logo-text { opacity: 0; transition: opacity 0.2s ease; }
        #asr-sidebar:hover .logo-text { opacity: 1; }
        .sidebar-footer { padding: 12px 0; border-top: 1px solid rgba(255,255,255,0.07); }

        /* Light mode */
        html:not(.dark) body { background-color: #f1f5f9 !important; color: #0f172a !important; }
        html:not(.dark) #asr-main { background-color: #f1f5f9 !important; }
        html:not(.dark) #asr-main .text-white, html:not(.dark) #asr-main .text-slate-100, html:not(.dark) #asr-main .text-slate-200 { color: #0f172a !important; }
        html:not(.dark) #asr-main [class*="bg-emerald"] .text-white, html:not(.dark) #asr-main [class*="bg-rose"] .text-white { color: #fff !important; }
        html:not(.dark) #asr-main .text-slate-400, html:not(.dark) #asr-main .text-slate-500 { color: #475569 !important; }
        html:not(.dark) #asr-main .border-slate-800, html:not(.dark) #asr-main .border-slate-700 { border-color: #cbd5e1 !important; }
        html:not(.dark) #asr-main .sticky { background-color: rgba(255,255,255,0.9) !important; border-color: #cbd5e1 !important; }
        html:not(.dark) #asr-main .sticky h1 { color: #0f172a !important; }
        html:not(.dark) #asr-sidebar { background: #fff; border-right: 1px solid #e2e8f0; }
        html:not(.dark) .nav-item { color: #64748b; }
        html:not(.dark) .nav-item:hover, html:not(.dark) .nav-item.active { background: rgba(16,185,129,0.08); color: #065f46; }
        html:not(.dark) .sidebar-logo, html:not(.dark) .sidebar-footer { border-color: #e2e8f0; }
    </style>
</head>
<body class="min-h-screen bg-slate-100 dark:bg-slate-950 text-slate-950 dark:text-white transition-colors duration-300">

    <!-- ICON SIDEBAR - Instruktur -->
    <aside id="asr-sidebar" class="fixed top-0 left-0 h-full bg-slate-900 border-r border-slate-800 flex flex-col z-40">
        <div class="sidebar-logo">
            <div class="logo-icon">I</div>
            <div class="logo-text">
                <div style="font-size:11px;font-weight:900;color:#34d399;letter-spacing:.1em;line-height:1;">LPK MPI</div>
                <div style="font-size:10px;color:#94a3b8;font-weight:600;">Instruktur</div>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto py-3" style="overflow-x:hidden;">
            <div class="nav-section-title">Menu</div>

            <button onclick="showPanel('p-schemes')" id="btn-p-schemes" class="nav-item">
                <span class="nav-icon"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg></span>
                <span class="nav-label">Evaluasi Saya</span>
            </button>

            <button onclick="showPanel('p-schedules')" id="btn-p-schedules" class="nav-item">
                <span class="nav-icon"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M16 2v4M8 2v4M3 10h18"/></svg></span>
                <span class="nav-label">Jadwal Kelas</span>
            </button>

            <button onclick="showPanel('p-syllabus')" id="btn-p-syllabus" class="nav-item">
                <span class="nav-icon"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg></span>
                <span class="nav-label">Silabus Program</span>
            </button>

            <button onclick="showPanel('p-progress')" id="btn-p-progress" class="nav-item">
                <span class="nav-icon"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg></span>
                <span class="nav-label">Progress &amp; Nilai</span>
            </button>

            <div class="nav-divider"></div>

            <a href="{{ route('home') }}" class="nav-item">
                <span class="nav-icon"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg></span>
                <span class="nav-label">Website Utama</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <button onclick="showPanel('p-profile')" id="btn-p-profile" class="nav-item">
                <span class="nav-icon"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="7" r="4"/><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/></svg></span>
                <span class="nav-label">Profil Saya</span>
            </button>

            <form action="{{ route('logout') }}" method="POST">@csrf
                <button type="submit" class="nav-item" style="color:#f87171;">
                    <span class="nav-icon"><svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg></span>
                    <span class="nav-label">Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <div id="asr-main" style="margin-left:64px;" class="min-h-screen transition-all duration-300">
        <div class="sticky top-0 z-20 bg-slate-900/80 backdrop-blur border-b border-slate-800 px-6 py-4 flex items-center justify-between">
            <div>
                <h1 class="text-sm font-black text-white">Dashboard Instruktur</h1>
                <p class="text-[10px] text-slate-500 uppercase tracking-wider">Buat &amp; Kelola Evaluasi Pelatihan</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2 bg-emerald-500/10 border border-emerald-500/20 px-3 py-1.5 rounded-full">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="text-[10px] font-bold text-emerald-400 uppercase tracking-wider">Instruktur Aktif</span>
                </div>
            </div>
        </div>

        <div class="p-8">
            @if(session('success'))
                <div class="mb-6 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 px-4 py-3 rounded-xl text-sm">✓ {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-6 bg-rose-500/10 border border-rose-500/30 text-rose-400 px-4 py-3 rounded-xl text-sm">✕ {{ session('error') }}</div>
            @endif

            {{-- Panel: Skema Saya --}}
            <div id="p-schemes" class="dashboard-panel space-y-8">
                {{-- Create New Scheme --}}
                <div class="glass rounded-2xl p-6 mb-8">
                <h3 class="font-bold text-white mb-4 text-sm">Buat Evaluasi Baru</h3>
                <form action="{{ route('asesor.scheme.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    @csrf
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Judul Evaluasi</label>
                        <input type="text" name="title" required placeholder="cth: Evaluasi Kelas Kepemimpinan" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Durasi (menit)</label>
                        <input type="number" name="duration_minutes" value="60" min="5" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-emerald-500">
                    </div>
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider px-6 py-2.5 rounded-lg transition-all">Buat Evaluasi</button>
                </form>
            </div>

            {{-- Schemes List --}}
            <div>
                <h2 class="text-xl font-black mb-4">Evaluasi Saya</h2>
                @if($schemes->isEmpty())
                    <div class="glass rounded-2xl p-12 text-center">
                        <div class="text-5xl mb-4">📋</div>
                        <p class="text-slate-400 text-sm">Belum ada evaluasi. Buat evaluasi pertama Anda di atas.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($schemes as $s)
                            <div class="glass rounded-2xl p-5 flex flex-col gap-3 hover:border-emerald-500/30 transition-all">
                                <div class="flex items-start justify-between gap-2">
                                    <h3 class="font-bold text-white text-sm leading-tight flex-1">{{ $s->title }}</h3>
                                    @if($s->status === 'published')
                                        <span class="shrink-0 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-2 py-0.5 rounded-full text-[9px] font-black uppercase">Live</span>
                                    @else
                                        <span class="shrink-0 bg-amber-500/10 text-amber-400 border border-amber-500/20 px-2 py-0.5 rounded-full text-[9px] font-black uppercase">Draft</span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-4 text-xs text-slate-400">
                                    <span>⏱ {{ $s->duration_minutes }} menit</span>
                                    <span>📝 {{ $s->questions_count }} soal</span>
                                </div>
                                <div class="flex gap-2 pt-1">
                                    <a href="{{ route('asesor.scheme.edit', $s->id) }}" class="flex-1 bg-slate-800 hover:bg-slate-700 text-white text-xs font-bold uppercase tracking-wider py-2 rounded-lg text-center transition-all">
                                        Edit Soal
                                    </a>
                                    <form action="{{ route('asesor.scheme.delete', $s->id) }}" method="POST" onsubmit="return confirm('Hapus evaluasi ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-rose-600/10 hover:bg-rose-600/20 text-rose-400 border border-rose-500/20 text-xs font-bold uppercase tracking-wider px-3 py-2 rounded-lg transition-all">✕</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            </div>

            {{-- Panel: Jadwal Kelas --}}
            <div id="p-schedules" class="dashboard-panel hidden space-y-8">
                <div class="glass rounded-2xl p-6">
                    <h3 class="font-bold text-white mb-4 text-sm">Tambah Jadwal Kelas Baru</h3>
                    <form action="{{ route('asesor.schedule.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 items-end">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Program Pelatihan</label>
                            <select name="training_program_id" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-emerald-500">
                                <option value="">-- Pilih Program --</option>
                                @foreach($programs as $p)
                                    <option value="{{ $p->id }}">{{ $p->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Topik Pembelajaran</label>
                            <input type="text" name="topic" required placeholder="cth: Pengenalan Alat Ukur" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-emerald-500">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Waktu Pelaksanaan</label>
                            <input type="datetime-local" name="scheduled_at" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-emerald-500">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Lokasi / Tautan Zoom</label>
                            <input type="text" name="location" required placeholder="cth: Ruang 203 / Zoom Link" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-emerald-500">
                        </div>
                        <div class="lg:col-span-4 flex justify-end">
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider px-6 py-2.5 rounded-lg transition-all">Tambah Jadwal</button>
                        </div>
                    </form>
                </div>

                <div class="glass rounded-2xl overflow-hidden">
                    <div class="p-5 border-b border-slate-800"><h3 class="font-bold text-white">Daftar Jadwal Kelas Saya</h3></div>
                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-sm">
                            <thead><tr class="border-b border-slate-800 text-slate-400 text-[10px] uppercase font-bold">
                                <th class="px-5 py-3 text-left">Program Pelatihan</th>
                                <th class="px-5 py-3 text-left">Topik</th>
                                <th class="px-5 py-3 text-left">Waktu</th>
                                <th class="px-5 py-3 text-left">Lokasi/Tautan</th>
                                <th class="px-5 py-3 text-right">Aksi</th>
                            </tr></thead>
                            <tbody class="divide-y divide-slate-800">
                                @forelse($schedules as $sch)
                                    <tr>
                                        <td class="px-5 py-3 font-bold text-white">{{ $sch->trainingProgram?->title }}</td>
                                        <td class="px-5 py-3 text-slate-300 text-xs">{{ $sch->topic }}</td>
                                        <td class="px-5 py-3 text-slate-300 text-xs font-mono">{{ $sch->scheduled_at->format('d M Y H:i') }} WIB</td>
                                        <td class="px-5 py-3 text-slate-400 text-xs">{{ $sch->location }}</td>
                                        <td class="px-5 py-3 text-right">
                                            <form action="{{ route('asesor.schedule.destroy', $sch->id) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-rose-500 hover:text-rose-400 font-bold text-xs uppercase">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="px-5 py-8 text-center text-slate-500">Belum ada jadwal kelas yang diatur.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Panel: Silabus Program --}}
            <div id="p-syllabus" class="dashboard-panel hidden space-y-8">
                <div class="mb-6">
                    <h2 class="text-xl font-black text-white">Manajemen Silabus &amp; Kurikulum</h2>
                    <p class="text-slate-500 text-sm mt-1">Perbarui kurikulum, materi, dan deskripsi silabus program pelatihan.</p>
                </div>

                <div class="grid grid-cols-1 gap-6">
                    @foreach($programs as $prog)
                        <div class="glass rounded-2xl p-6 space-y-4">
                            <div class="flex justify-between items-start border-b border-slate-800 pb-3">
                                <div>
                                    <h3 class="text-base font-bold text-white">{{ $prog->title }}</h3>
                                    <span class="text-[10px] bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-2 py-0.5 rounded-full font-bold uppercase tracking-wider">{{ $prog->category }}</span>
                                </div>
                                <span class="text-slate-400 text-xs font-semibold">⏱ {{ $prog->duration }}</span>
                            </div>

                            <form action="{{ route('asesor.syllabus.update', $prog->id) }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Deskripsi Program</label>
                                    <textarea name="description" required rows="3" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-emerald-500">{{ $prog->description }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Materi / Manfaat Pelatihan (Satu per baris)</label>
                                    <textarea name="benefits" rows="4" placeholder="Masukkan materi pelatihan baru, pisahkan dengan baris baru" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-emerald-500">@if(is_array($prog->benefits)){{ implode("\n", $prog->benefits) }}@else{{ $prog->benefits }}@endif</textarea>
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider px-5 py-2 rounded-lg transition-all">Perbarui Silabus</button>
                                </div>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Panel: Progress & Nilai Siswa --}}
            <div id="p-progress" class="dashboard-panel hidden">
                <h2 class="text-xl font-black mb-6 text-white font-heading">Progress &amp; Nilai Ujian Peserta</h2>
                
                <div class="glass rounded-2xl overflow-hidden">
                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-sm">
                            <thead><tr class="border-b border-slate-800 text-slate-400 text-[10px] uppercase font-bold">
                                <th class="px-5 py-3 text-left">Nama Peserta</th>
                                <th class="px-5 py-3 text-left">Evaluasi Pelatihan</th>
                                <th class="px-5 py-3 text-center">Status Pengerjaan</th>
                                <th class="px-5 py-3 text-center">Skor Akhir</th>
                                <th class="px-5 py-3 text-left">Tanggal Ujian</th>
                            </tr></thead>
                            <tbody class="divide-y divide-slate-800">
                                @forelse($attempts as $att)
                                    <tr>
                                        <td class="px-5 py-3 font-bold text-white">{{ $att->asesi?->name }}</td>
                                        <td class="px-5 py-3 text-slate-300 text-xs">{{ $att->scheme?->title }}</td>
                                        <td class="px-5 py-3 text-center">
                                            @if($att->status === 'completed')
                                                <span class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-2 py-0.5 rounded text-[10px] font-bold uppercase">Selesai</span>
                                            @else
                                                <span class="bg-amber-500/10 text-amber-400 border border-amber-500/20 px-2 py-0.5 rounded text-[10px] font-bold uppercase">Pengerjaan</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-3 text-center">
                                            @if($att->status === 'completed')
                                                <span class="font-mono font-bold text-white text-sm bg-slate-800 px-2.5 py-1 border border-slate-700">{{ $att->score }} / 100</span>
                                            @else
                                                <span class="text-slate-500 text-xs font-mono">-</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-3 text-slate-400 text-xs">
                                            <div>Mulai: {{ $att->started_at?->format('d M Y H:i') ?? '-' }}</div>
                                            @if($att->completed_at)
                                                <div class="mt-0.5 text-slate-500">Selesai: {{ $att->completed_at->format('d M Y H:i') }}</div>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="px-5 py-8 text-center text-slate-500">Belum ada aktivitas ujian dari peserta.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Panel: Profil Saya --}}
            <div id="p-profile" class="dashboard-panel hidden">
                <div class="mb-6">
                    <h2 class="text-xl font-black text-white font-heading">Profil Saya</h2>
                    <p class="text-slate-500 text-sm mt-1">Ubah nama pengguna, email, dan kata sandi akun Instruktur Anda.</p>
                </div>

                <div class="glass rounded-2xl p-6 max-w-2xl">
                    <form action="{{ route('asesor.profile.update') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Username</label>
                            <input type="text" name="username" value="{{ auth()->user()->username }}" required
                                class="w-full bg-slate-900 border border-slate-800 rounded-lg px-4 py-2.5 text-sm text-white focus:outline-none focus:border-emerald-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Email</label>
                            <input type="email" name="email" value="{{ auth()->user()->email }}" required placeholder="instruktur@gmail.com"
                                class="w-full bg-slate-900 border border-slate-800 rounded-lg px-4 py-2.5 text-sm text-white focus:outline-none focus:border-emerald-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Kata Sandi Baru (Kosongkan jika tidak diubah)</label>
                            <input type="password" name="password" placeholder="Min 6 karakter"
                                class="w-full bg-slate-900 border border-slate-800 rounded-lg px-4 py-2.5 text-sm text-white focus:outline-none focus:border-emerald-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi baru"
                                class="w-full bg-slate-900 border border-slate-800 rounded-lg px-4 py-2.5 text-sm text-white focus:outline-none focus:border-emerald-500 transition-all">
                        </div>
                        <div class="flex justify-end pt-2">
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider px-6 py-3 rounded-lg transition-all shadow-lg shadow-emerald-500/20">
                                Simpan Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <script>
        const allPanels = ['p-schemes', 'p-schedules', 'p-syllabus', 'p-progress', 'p-profile'];
        function showPanel(id) {
            allPanels.forEach(p => {
                const el = document.getElementById(p);
                if(el) el.classList.add('hidden');
            });
            const activeEl = document.getElementById(id);
            if(activeEl) activeEl.classList.remove('hidden');

            document.querySelectorAll('.sidebar-btn').forEach(b => {
                b.classList.remove('bg-slate-800','text-white');
                b.classList.add('text-slate-400','hover:bg-slate-800','hover:text-white');
            });
            const btn = document.getElementById('btn-'+id);
            if(btn){
                btn.classList.remove('text-slate-400','hover:bg-slate-800','hover:text-white');
                btn.classList.add('bg-slate-800','text-white');
            }
            localStorage.setItem('asesor_panel', id);

            // Auto-collapse sidebar on mobile after clicking
            if (window.innerWidth < 1024) {
                const sidebar = document.getElementById('asr-sidebar');
                const overlay = document.getElementById('asr-overlay');
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }

        function toggleAsrSidebar() {
            const sidebar = document.getElementById('asr-sidebar');
            const main    = document.getElementById('asr-main');
            const overlay = document.getElementById('asr-overlay');
            const isOpen  = !sidebar.classList.contains('-translate-x-full');
            const isMobile = window.innerWidth < 1024;

            if (isOpen) {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
                if (!isMobile) {
                    main.classList.remove('lg:ml-64');
                    main.classList.add('ml-0');
                }
                overlay.classList.add('hidden');
            } else {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
                if (!isMobile) {
                    main.classList.remove('ml-0');
                    main.classList.add('lg:ml-64');
                } else {
                    overlay.classList.remove('hidden');
                }
            }
            if (!isMobile) {
                const isNowOpen = !sidebar.classList.contains('-translate-x-full');
                localStorage.setItem('asr_sidebar_open', isNowOpen ? '1' : '0');
            }
        }

        function toggleAsrMenuGroup(groupId, btn) {
            const groupEl = document.getElementById(groupId);
            const arrow = btn.querySelector('.arrow-icon');
            
            if (groupEl.classList.contains('hidden')) {
                groupEl.classList.remove('hidden');
                if (arrow) arrow.classList.remove('-rotate-90');
            } else {
                groupEl.classList.add('hidden');
                if (arrow) arrow.classList.add('-rotate-90');
            }
            
            localStorage.setItem('asr_group_' + groupId, groupEl.classList.contains('hidden') ? 'collapsed' : 'open');
        }

        function toggleAsrTheme() {
            const html = document.documentElement;
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.setItem('lpk_theme', 'light');
            } else {
                html.classList.add('dark');
                localStorage.setItem('lpk_theme', 'dark');
            }
            updateAsrThemeIcon();
        }

        function updateAsrThemeIcon() {
            const icon = document.getElementById('asr-theme-icon');
            if (!icon) return;
            const isDark = document.documentElement.classList.contains('dark');
            icon.textContent = isDark ? '🌙' : '☀️';
        }

        document.addEventListener('DOMContentLoaded', () => {
            showPanel(localStorage.getItem('asesor_panel') || 'p-schemes');
            updateAsrThemeIcon();
            const isMobile = window.innerWidth < 1024;
            const sidebar = document.getElementById('asr-sidebar');
            const main    = document.getElementById('asr-main');
            const savedOpen = localStorage.getItem('asr_sidebar_open');

            if (savedOpen === '0' || isMobile) {
                if (sidebar) {
                    sidebar.classList.add('-translate-x-full');
                    sidebar.classList.remove('translate-x-0');
                }
                if (main) {
                    main.classList.remove('lg:ml-64');
                    main.classList.add('ml-0');
                }
            } else {
                if (sidebar) {
                    sidebar.classList.remove('-translate-x-full');
                    sidebar.classList.add('translate-x-0');
                }
                if (main) {
                    main.classList.add('lg:ml-64');
                    main.classList.remove('ml-0');
                }
            }

            // Restore group open/collapsed states
            const groups = ['group-menu-asesor'];
            groups.forEach(gId => {
                const savedState = localStorage.getItem('asr_group_' + gId);
                const groupEl = document.getElementById(gId);
                const btn = document.querySelector(`button[onclick*="${gId}"]`);
                if (groupEl && btn) {
                    const arrow = btn.querySelector('.arrow-icon');
                    if (savedState === 'collapsed') {
                        groupEl.classList.add('hidden');
                        if (arrow) arrow.classList.add('-rotate-90');
                    } else {
                        groupEl.classList.remove('hidden');
                        if (arrow) arrow.classList.remove('-rotate-90');
                    }
                }
            });
        });
    </script>
</body>
</html>
