<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin — LPK MPI</title>
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
        .dark .glass {
            background: rgba(15,23,42,0.85);
            border-color: rgba(255,255,255,0.07);
        }
        html:not(.dark) .glass {
            background: rgba(248,250,252,0.85);
            border-color: rgba(0,0,0,0.08);
        }
        .glass { backdrop-filter: blur(20px); transition: all 0.3s ease; }
        *, ::before, ::after { border-radius: 0px !important; }
        .text-\[9px\]  { font-size: 0.75rem !important; }
        .text-\[10px\] { font-size: 0.75rem !important; }
        .text-\[11px\] { font-size: 0.875rem !important; }

        /* ======== ICON SIDEBAR ======== */
        #adm-sidebar {
            width: 64px;
            transition: width 0.3s cubic-bezier(.4,0,.2,1);
            overflow: hidden;
            white-space: nowrap;
        }
        #adm-sidebar:hover {
            width: 220px;
        }
        #adm-main {
            margin-left: 64px;
            transition: margin-left 0.3s cubic-bezier(.4,0,.2,1);
        }
        /* Nav items: icon + label */
        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 18px;
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            color: #94a3b8;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            transition: background 0.15s, color 0.15s;
            text-align: left;
            text-decoration: none;
        }
        .nav-item:hover, .nav-item.active {
            background: rgba(59,130,246,0.10);
            color: #fff;
        }
        .nav-item.active { color: #60a5fa; }
        .nav-item .nav-icon {
            flex-shrink: 0;
            width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .nav-item .nav-label {
            opacity: 0;
            transition: opacity 0.2s ease 0.05s;
            overflow: hidden;
        }
        #adm-sidebar:hover .nav-label { opacity: 1; }
        .nav-divider {
            border-top: 1px solid rgba(255,255,255,0.07);
            margin: 6px 0;
        }
        .nav-section-title {
            padding: 10px 18px 4px;
            font-size: 9px;
            font-weight: 900;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #475569;
            opacity: 0;
            transition: opacity 0.2s ease;
            white-space: nowrap;
        }
        #adm-sidebar:hover .nav-section-title { opacity: 1; }
        /* Logo area */
        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 18px 18px 14px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }
        .sidebar-logo .logo-icon {
            flex-shrink: 0;
            width: 28px;
            height: 28px;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            border-radius: 8px !important;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 900;
            color: #fff;
        }
        .sidebar-logo .logo-text {
            opacity: 0;
            transition: opacity 0.2s ease;
        }
        #adm-sidebar:hover .logo-text { opacity: 1; }
        /* Logout */
        .sidebar-footer { padding: 12px 0; border-top: 1px solid rgba(255,255,255,0.07); }

        /* Light mode overrides */
        html:not(.dark) body { background-color: #f1f5f9 !important; color: #0f172a !important; }
        html:not(.dark) #adm-main { background-color: #f1f5f9 !important; }
        html:not(.dark) #adm-main .text-white,
        html:not(.dark) #adm-main .text-slate-100,
        html:not(.dark) #adm-main .text-slate-200 { color: #0f172a !important; }
        html:not(.dark) #adm-main button .text-white,
        html:not(.dark) #adm-main a .text-white,
        html:not(.dark) #adm-main [class*="bg-emerald"] .text-white,
        html:not(.dark) #adm-main [class*="bg-blue"] .text-white,
        html:not(.dark) #adm-main [class*="bg-rose"] .text-white { color: #ffffff !important; }
        html:not(.dark) #adm-main .text-slate-400,
        html:not(.dark) #adm-main .text-slate-500 { color: #475569 !important; }
        html:not(.dark) #adm-main .border-slate-800,
        html:not(.dark) #adm-main .border-slate-700 { border-color: #cbd5e1 !important; }
        html:not(.dark) #adm-main .sticky { background-color: rgba(255,255,255,0.9) !important; border-color: #cbd5e1 !important; }
        html:not(.dark) #adm-main .sticky h1 { color: #0f172a !important; }

        /* Light mode sidebar */
        html:not(.dark) #adm-sidebar { background: #fff; border-right: 1px solid #e2e8f0; }
        html:not(.dark) .nav-item { color: #64748b; }
        html:not(.dark) .nav-item:hover, html:not(.dark) .nav-item.active { background: rgba(59,130,246,0.08); color: #1e40af; }
        html:not(.dark) .nav-divider { border-color: #e2e8f0; }
        html:not(.dark) .sidebar-logo, html:not(.dark) .sidebar-footer { border-color: #e2e8f0; }
        html:not(.dark) .nav-section-title { color: #94a3b8; }
    </style>
</head>
<body class="min-h-screen bg-slate-100 dark:bg-slate-950 text-slate-950 dark:text-white transition-colors duration-300">

    <!-- ICON SIDEBAR -->
    <aside id="adm-sidebar" class="fixed top-0 left-0 h-full bg-slate-900 border-r border-slate-800 flex flex-col z-40">

        <!-- Logo / Brand -->
        <div class="sidebar-logo">
            <div class="logo-icon">L</div>
            <div class="logo-text">
                <div style="font-size:11px;font-weight:900;color:#60a5fa;letter-spacing:.1em;line-height:1;">LPK-MI</div>
                <div style="font-size:10px;color:#94a3b8;font-weight:600;">Admin</div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto py-3" style="overflow-x:hidden;">

            <!-- Manajemen Data -->
            <div class="nav-section-title">Data</div>

            <button onclick="showPanel('p-overview')" id="btn-p-overview" class="nav-item">
                <span class="nav-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
                </span>
                <span class="nav-label">Overview</span>
            </button>

            <button onclick="showPanel('p-schemes')" id="btn-p-schemes" class="nav-item">
                <span class="nav-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </span>
                <span class="nav-label">Evaluasi Pelatihan</span>
            </button>

            <button onclick="showPanel('p-trainees')" id="btn-p-trainees" class="nav-item">
                <span class="nav-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </span>
                <span class="nav-label">Data Peserta</span>
            </button>

            <div class="nav-divider"></div>

            <!-- Kelola Pengguna -->
            <div class="nav-section-title">Pengguna</div>

            <button onclick="showPanel('p-asesor')" id="btn-p-asesor" class="nav-item">
                <span class="nav-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 20v-1a6 6 0 0112 0v1"/><path stroke-linecap="round" stroke-linejoin="round" d="M19 11l2 2-2 2"/></svg>
                </span>
                <span class="nav-label">Kelola Instruktur</span>
            </button>

            <button onclick="showPanel('p-asesi')" id="btn-p-asesi" class="nav-item">
                <span class="nav-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 20v-1a6 6 0 0112 0v1"/></svg>
                </span>
                <span class="nav-label">Kelola Peserta</span>
            </button>

            <div class="nav-divider"></div>

            <!-- CMS Blog -->
            <div class="nav-section-title">Konten</div>

            <button onclick="showPanel('p-blog')" id="btn-p-blog" class="nav-item">
                <span class="nav-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </span>
                <span class="nav-label">Kelola Artikel</span>
            </button>

            <div class="nav-divider"></div>

            <!-- Website -->
            <a href="{{ route('home') }}" class="nav-item">
                <span class="nav-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                </span>
                <span class="nav-label">Website Utama</span>
            </a>

        </nav>

        <!-- Footer: Profile + Logout -->
        <div class="sidebar-footer">
            <button onclick="showPanel('p-profile')" id="btn-p-profile" class="nav-item">
                <span class="nav-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="7" r="4"/><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </span>
                <span class="nav-label">Profil Saya</span>
            </button>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-item" style="color:#f87171;">
                    <span class="nav-icon">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </span>
                    <span class="nav-label">Keluar</span>
                </button>
            </form>

            <!-- Theme Toggle -->
            <button onclick="toggleAdmTheme()" class="nav-item">
                <span class="nav-icon">
                    <span id="adm-theme-icon" style="font-size:18px;">🌙</span>
                </span>
                <span class="nav-label" id="adm-theme-label">Mode Gelap</span>
            </button>
        </div>
    </aside>

    <!-- No overlay needed for hover sidebar -->

    <div id="adm-main" style="margin-left:64px;" class="min-h-screen transition-all duration-300">
        <div class="sticky top-0 z-20 bg-slate-900/80 backdrop-blur border-b border-slate-800 px-6 py-4 flex items-center justify-between">
            <div>
                <h1 class="text-sm font-black text-white">Dashboard Admin LPK MPI</h1>
                <p class="text-[10px] text-slate-500 uppercase tracking-wider">Pantau &amp; Kelola Instruktur, Peserta, dan Evaluasi</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-2 bg-blue-500/10 border border-blue-500/20 px-3 py-1.5 rounded-full">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></span>
                    <span class="text-[10px] font-bold text-blue-400 uppercase tracking-wider">Admin Aktif</span>
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
            @if($errors->any())
                <div class="mb-6 bg-rose-500/10 border border-rose-500/30 text-rose-400 px-4 py-3 rounded-xl text-sm font-medium">
                    <strong class="block mb-1">Gagal menyimpan data:</strong>
                    <ul class="list-disc pl-5 space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- OVERVIEW --}}
            <div id="p-overview" class="dashboard-panel">
                <h2 class="text-xl font-black mb-6">Overview</h2>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <div class="glass rounded-2xl p-5 border border-blue-500/10 bg-blue-500/5">
                        <div class="text-3xl font-black text-white mb-1">{{ $asetors->count() }}</div>
                        <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Total Instruktur</div>
                    </div>
                    <div class="glass rounded-2xl p-5 border border-violet-500/10 bg-violet-500/5">
                        <div class="text-3xl font-black text-white mb-1">{{ $asesis->count() }}</div>
                        <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Total Peserta</div>
                    </div>
                    <div class="glass rounded-2xl p-5 border border-emerald-500/10 bg-emerald-500/5">
                        <div class="text-3xl font-black text-white mb-1">{{ $schemes->where('status','published')->count() }}</div>
                        <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Evaluasi Diterbitkan</div>
                    </div>
                    <div class="glass rounded-2xl p-5 border border-amber-500/10 bg-amber-500/5">
                        <div class="text-3xl font-black text-white mb-1">{{ $certCount }}</div>
                        <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Sertifikat Terbit</div>
                    </div>
                </div>

                <div class="glass rounded-2xl overflow-hidden">
                    <div class="p-5 border-b border-slate-800"><h3 class="font-bold text-white">Aktivitas Instruktur</h3></div>
                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-sm">
                            <thead><tr class="border-b border-slate-800 text-slate-400 text-[10px] uppercase tracking-wider font-bold">
                                <th class="px-5 py-3 text-left">Username Instruktur</th>
                                <th class="px-5 py-3 text-left">Email</th>
                                <th class="px-5 py-3 text-center">Jumlah Evaluasi</th>
                            </tr></thead>
                            <tbody class="divide-y divide-slate-800">
                                @forelse($asetors as $a)
                                    <tr>
                                        <td class="px-5 py-3 font-bold text-white">{{ $a->name }}</td>
                                        <td class="px-5 py-3 text-slate-400 font-mono text-xs">{{ $a->email }}</td>
                                        <td class="px-5 py-3 text-center">
                                            <span class="bg-blue-500/10 text-blue-400 border border-blue-500/20 px-2.5 py-0.5 rounded-full text-xs font-bold">{{ $a->schemes_count }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="px-5 py-8 text-center text-slate-500">Belum ada instruktur terdaftar.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- KELOLA ASESOR --}}
            <div id="p-asesor" class="dashboard-panel hidden">
                <h2 class="text-xl font-black mb-6">Kelola Instruktur</h2>

                <div class="glass rounded-2xl p-6 mb-6">
                    <h3 class="font-bold text-white mb-4 text-sm">Daftarkan Instruktur Baru</h3>
                    <form action="{{ route('admin.asesor.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Username Instruktur</label>
                            <input type="text" name="username" required placeholder="Contoh: instruktur_baru" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Email</label>
                            <input type="email" name="email" required placeholder="instruktur@gmail.com" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-blue-500">
                        </div>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase tracking-wider px-6 py-2.5 rounded-lg transition-all">Daftarkan</button>
                    </form>
                </div>

                <div class="glass rounded-2xl overflow-hidden">
                    <div class="p-5 border-b border-slate-800"><h3 class="font-bold text-white">Daftar Instruktur</h3></div>
                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-sm">
                            <thead><tr class="border-b border-slate-800 text-slate-400 text-[10px] uppercase tracking-wider font-bold">
                                <th class="px-5 py-3 text-left">Username</th>
                                <th class="px-5 py-3 text-left">Email</th>
                                <th class="px-5 py-3 text-center">Evaluasi</th>
                                <th class="px-5 py-3 text-right">Aksi</th>
                            </tr></thead>
                            <tbody class="divide-y divide-slate-800">
                                @forelse($asetors as $a)
                                    <tr>
                                        <td class="px-5 py-3 font-bold text-white">{{ $a->name }}</td>
                                        <td class="px-5 py-3 text-slate-400 font-mono text-xs">{{ $a->email }}</td>
                                        <td class="px-5 py-3 text-center text-slate-300">{{ $a->schemes_count }}</td>
                                        <td class="px-5 py-3 text-right">
                                            <form action="{{ route('admin.user.destroy', $a->id) }}" method="POST" onsubmit="return confirm('Hapus instruktur {{ $a->name }}?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-rose-500 hover:text-rose-400 font-bold text-xs uppercase tracking-wider">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="px-5 py-8 text-center text-slate-500">Belum ada instruktur.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- KELOLA ASESI --}}
            <div id="p-asesi" class="dashboard-panel hidden">
                <h2 class="text-xl font-black mb-6">Kelola Peserta</h2>
                <div class="glass rounded-2xl p-6 mb-6">
                    <h3 class="font-bold text-white mb-4 text-sm">Daftarkan Peserta Baru</h3>
                    <form action="{{ route('admin.asesi.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Username</label>
                            <input type="text" name="username" required placeholder="Contoh: peserta_baru" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-violet-500">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Email</label>
                            <input type="email" name="email" required placeholder="peserta@gmail.com" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-violet-500">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Password</label>
                            <div class="relative w-full">
                                <input type="password" name="password" required placeholder="Min 6 karakter" class="w-full bg-slate-900 border border-slate-700 rounded-lg pl-3 pr-10 py-2 text-sm text-white focus:outline-none focus:border-violet-500">
                                <button type="button" onclick="togglePasswordVisibility(this)" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-450 hover:text-slate-350 transition-colors text-xs font-bold font-sans">
                                    Lihat
                                </button>
                            </div>
                        </div>
                        <button type="submit" class="bg-violet-600 hover:bg-violet-700 text-white font-bold text-xs uppercase tracking-wider px-6 py-2.5 rounded-lg transition-all">Daftarkan</button>
                    </form>
                </div>

                <div class="glass rounded-2xl overflow-hidden">
                    <div class="p-5 border-b border-slate-800"><h3 class="font-bold text-white">Daftar Peserta</h3></div>
                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-sm">
                            <thead><tr class="border-b border-slate-800 text-slate-400 text-[10px] uppercase tracking-wider font-bold">
                                <th class="px-5 py-3 text-left">Username</th>
                                <th class="px-5 py-3 text-left">Email</th>
                                <th class="px-5 py-3 text-right">Aksi</th>
                            </tr></thead>
                            <tbody class="divide-y divide-slate-800">
                                @forelse($asesis as $asi)
                                    <tr>
                                        <td class="px-5 py-3 font-bold text-white">{{ $asi->name }}</td>
                                        <td class="px-5 py-3 text-slate-400 font-mono text-xs">{{ $asi->email }}</td>
                                        <td class="px-5 py-3 text-right">
                                            <form action="{{ route('admin.user.destroy', $asi->id) }}" method="POST" onsubmit="return confirm('Hapus peserta {{ $asi->name }}?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-rose-500 hover:text-rose-400 font-bold text-xs uppercase tracking-wider">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="px-5 py-8 text-center text-slate-500">Belum ada peserta.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- SKEMA PENILAIAN --}}
            <div id="p-schemes" class="dashboard-panel hidden">
                <h2 class="text-xl font-black mb-6">Evaluasi Pelatihan</h2>

                {{-- Form Assign Skema --}}
                <div class="glass rounded-2xl p-6 mb-6">
                    <h3 class="font-bold text-white mb-4 text-sm">Tugaskan Evaluasi ke Instruktur</h3>
                    <form action="{{ route('admin.scheme.assign') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Pilih Evaluasi</label>
                            <select name="scheme_id" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-emerald-500">
                                <option value="">-- Pilih Evaluasi --</option>
                                @foreach($schemes as $s)
                                    <option value="{{ $s->id }}">{{ $s->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Pilih Instruktur</label>
                            <select name="asesor_id" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-emerald-500">
                                <option value="">-- Pilih Instruktur --</option>
                                @foreach($asetors as $a)
                                    <option value="{{ $a->id }}">{{ $a->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider px-6 py-2.5 rounded-lg transition-all">Tugaskan</button>
                    </form>
                </div>

                {{-- Tabel Skema --}}
                <div class="glass rounded-2xl overflow-hidden">
                    <div class="p-5 border-b border-slate-800"><h3 class="font-bold text-white">Semua Evaluasi</h3></div>
                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-sm">
                            <thead><tr class="border-b border-slate-800 text-slate-400 text-[10px] uppercase font-bold">
                                <th class="px-5 py-3 text-left">Judul Evaluasi</th>
                                <th class="px-5 py-3 text-left">Instruktur</th>
                                <th class="px-5 py-3 text-center">Status</th>
                                <th class="px-5 py-3 text-center">Soal</th>
                            </tr></thead>
                            <tbody class="divide-y divide-slate-800">
                                @forelse($schemes as $s)
                                    <tr>
                                        <td class="px-5 py-3 font-bold text-white">{{ $s->title }}</td>
                                        <td class="px-5 py-3 text-slate-400 text-xs">{{ $s->asesor?->name ?? '-' }}</td>
                                        <td class="px-5 py-3 text-center">
                                            @if($s->status === 'published')
                                                <span class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-2.5 py-0.5 rounded-full text-xs font-bold">Published</span>
                                            @else
                                                <span class="bg-amber-500/10 text-amber-400 border border-amber-500/20 px-2.5 py-0.5 rounded-full text-xs font-bold">Draft</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-3 text-center text-slate-300">{{ $s->questions->count() }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="px-5 py-8 text-center text-slate-500">Belum ada evaluasi.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- DATA PESERTA --}}
            <div id="p-trainees" class="dashboard-panel hidden">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-black font-heading text-white">Data Peserta &amp; Sertifikat</h2>
                    <a href="{{ route('admin.report') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase tracking-wider px-4 py-2 rounded-lg transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"></path>
                        </svg>
                        Unduh Laporan (CSV)
                    </a>
                </div>
                <div class="glass rounded-2xl overflow-hidden">
                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-sm">
                            <thead><tr class="border-b border-slate-800 text-slate-400 text-[10px] uppercase font-bold">
                                <th class="px-5 py-3 text-left">Nama / NIK</th>
                                <th class="px-5 py-3 text-left">Program</th>
                                <th class="px-5 py-3 text-center">Dokumen Pendukung</th>
                                <th class="px-5 py-3 text-center">Pembayaran</th>
                                <th class="px-5 py-3 text-center">Status Kelulusan</th>
                                <th class="px-5 py-3 text-right">Aksi</th>
                            </tr></thead>
                            <tbody class="divide-y divide-slate-800">
                                @forelse($trainees as $t)
                                    <tr>
                                        <td class="px-5 py-3">
                                            <div class="font-bold text-white">{{ $t->name }}</div>
                                            <div class="text-[10px] text-slate-500 font-mono mt-0.5">NIK: {{ $t->nik }}</div>
                                        </td>
                                        <td class="px-5 py-3 text-slate-300 text-xs">{{ $t->trainingProgram?->title }}</td>
                                        <td class="px-5 py-3 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                @if($t->ktp_path)
                                                    <a href="{{ asset('storage/' . $t->ktp_path) }}" target="_blank" class="bg-blue-500/10 hover:bg-blue-500/20 text-blue-400 border border-blue-500/20 px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider">KTP</a>
                                                @else
                                                    <span class="text-slate-500 text-[10px] font-bold">-</span>
                                                @endif

                                                @if($t->ijazah_path)
                                                    <a href="{{ asset('storage/' . $t->ijazah_path) }}" target="_blank" class="bg-violet-500/10 hover:bg-violet-500/20 text-violet-400 border border-violet-500/20 px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider">Ijazah</a>
                                                @else
                                                    <span class="text-slate-500 text-[10px] font-bold">-</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-5 py-3 text-center">
                                            @if($t->payment_status === 'PAID')
                                                <span class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-2 py-0.5 rounded text-[10px] font-bold uppercase">Lunas ({{ $t->payment_method }})</span>
                                            @else
                                                <div class="flex flex-col items-center gap-1.5">
                                                    <span class="bg-amber-500/10 text-amber-400 border border-amber-500/20 px-2 py-0.5 rounded text-[10px] font-bold uppercase">Pending</span>
                                                    <form action="{{ route('admin.trainees.verify-payment', $t->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-[9px] font-bold uppercase tracking-wider px-2 py-1 rounded transition-all">Verifikasi</button>
                                                    </form>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-5 py-3 text-center">
                                            @if($t->status === 'LULUS')
                                                <span class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase">Lulus</span>
                                            @else
                                                <span class="bg-amber-500/10 text-amber-400 border border-amber-500/20 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase">Proses</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-3 text-right">
                                            @if($t->status !== 'LULUS')
                                                <form action="{{ route('admin.trainees.approve', $t->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-bold uppercase tracking-wider px-3 py-1.5 rounded transition-all">ACC</button>
                                                </form>
                                            @else
                                                <span class="text-slate-500 text-[10px] font-bold">✓ TERBIT</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="px-5 py-8 text-center text-slate-500">Belum ada data peserta.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Panel: Kelola Blog --}}
            <div id="p-blog" class="dashboard-panel hidden">
                <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h2 class="text-xl font-black text-white font-heading">Kelola Blog & Artikel</h2>
                        <p class="text-slate-500 text-sm mt-1">Publikasikan pengumuman resmi dan artikel berita seputar dunia pendidikan Islam.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Form Tambah Artikel -->
                    <div class="lg:col-span-1">
                        <div class="glass rounded-2xl p-6">
                            <h3 class="font-bold text-white mb-4 text-sm">Publikasikan Artikel Baru</h3>
                            <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Judul Artikel</label>
                                    <input type="text" name="title" required placeholder="Masukkan judul..." class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Gambar Utama (Optional)</label>
                                    <input type="file" name="image" accept="image/*" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-xs text-white focus:outline-none focus:border-blue-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-[10px] file:font-semibold file:bg-blue-500/10 file:text-blue-400 hover:file:bg-blue-500/20">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Konten / Isi Artikel</label>
                                    <textarea name="content" required rows="6" placeholder="Tulis konten artikel lengkap..." class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-blue-500"></textarea>
                                </div>
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase tracking-wider py-3 rounded-lg transition-all shadow-md">Terbitkan Artikel</button>
                            </form>
                        </div>
                    </div>

                    <!-- Daftar Artikel -->
                    <div class="lg:col-span-2">
                        <div class="glass rounded-2xl overflow-hidden">
                            <div class="p-5 border-b border-slate-800"><h3 class="font-bold text-white">Daftar Artikel Diterbitkan</h3></div>
                            <div class="overflow-x-auto w-full">
                                <table class="w-full text-sm">
                                    <thead><tr class="border-b border-slate-800 text-slate-400 text-[10px] uppercase font-bold">
                                        <th class="px-5 py-3 text-left">Judul</th>
                                        <th class="px-5 py-3 text-left">Penulis / Tanggal</th>
                                        <th class="px-5 py-3 text-right">Aksi</th>
                                    </tr></thead>
                                    <tbody class="divide-y divide-slate-800">
                                        @forelse($articles as $art)
                                            <tr>
                                                <td class="px-5 py-3">
                                                    <div class="flex items-center gap-3">
                                                        @if($art->image_path)
                                                            <img src="{{ asset('storage/' . $art->image_path) }}" alt="" class="w-10 h-10 object-cover rounded shrink-0">
                                                        @else
                                                            <div class="w-10 h-10 bg-slate-850 flex items-center justify-center rounded shrink-0 text-xs font-bold text-slate-400">
                                                                No
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <div class="font-bold text-white line-clamp-1">{{ $art->title }}</div>
                                                            <div class="text-[10px] text-slate-500 font-mono mt-0.5">{{ $art->slug }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-5 py-3">
                                                    <div class="text-xs text-slate-300 font-semibold">{{ $art->author }}</div>
                                                    <div class="text-[10px] text-slate-500 mt-0.5">{{ $art->published_at ? $art->published_at->format('d M Y H:i') : '-' }}</div>
                                                </td>
                                                <td class="px-5 py-3 text-right">
                                                    <form action="{{ route('admin.articles.destroy', $art->id) }}" method="POST" onsubmit="return confirm('Hapus artikel ini?')">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="text-rose-500 hover:text-rose-400 font-bold text-xs uppercase tracking-wider">Hapus</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr><td colspan="3" class="px-5 py-8 text-center text-slate-500">Belum ada artikel yang diterbitkan.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Panel: Profil Saya --}}
            <div id="p-profile" class="dashboard-panel hidden">
                <div class="mb-6">
                    <h2 class="text-xl font-black text-white font-heading">Profil Saya</h2>
                    <p class="text-slate-500 text-sm mt-1">Ubah nama pengguna, email, dan kata sandi akun Admin LPK Anda.</p>
                </div>

                <div class="glass rounded-2xl p-6 max-w-2xl">
                    <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Username</label>
                            <input type="text" name="username" value="{{ auth()->user()->username }}" required
                                class="w-full bg-slate-900 border border-slate-800 rounded-lg px-4 py-2.5 text-sm text-white focus:outline-none focus:border-blue-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Email</label>
                            <input type="email" name="email" value="{{ auth()->user()->email }}" required placeholder="admin@gmail.com"
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
    </div>

<script>
    const allPanels = ['p-overview','p-asesor','p-asesi','p-schemes','p-trainees','p-profile','p-blog'];

    function showPanel(id) {
        // Hide all panels
        allPanels.forEach(p => {
            const el = document.getElementById(p);
            if (el) el.classList.add('hidden');
        });
        // Show target panel
        const target = document.getElementById(id);
        if (target) target.classList.remove('hidden');

        // Update active state on nav-items
        document.querySelectorAll('.nav-item').forEach(b => b.classList.remove('active'));
        const btn = document.getElementById('btn-' + id);
        if (btn) btn.classList.add('active');

        localStorage.setItem('admin_panel', id);
    }

    function toggleAdmTheme() {
        const html = document.documentElement;
        if (html.classList.contains('dark')) {
            html.classList.remove('dark');
            localStorage.setItem('lpk_theme', 'light');
        } else {
            html.classList.add('dark');
            localStorage.setItem('lpk_theme', 'dark');
        }
        updateAdmThemeIcon();
    }

    function updateAdmThemeIcon() {
        const icon     = document.getElementById('adm-theme-icon');
        const label    = document.getElementById('adm-theme-label');
        const isDark   = document.documentElement.classList.contains('dark');
        if (icon)  icon.textContent  = isDark ? '🌙' : '☀️';
        if (label) label.textContent = isDark ? 'Mode Gelap' : 'Mode Terang';
    }

    document.addEventListener('DOMContentLoaded', () => {
        showPanel(localStorage.getItem('admin_panel') || 'p-overview');
        updateAdmThemeIcon();
    });

    function togglePasswordVisibility(btn) {
        const input = btn.previousElementSibling;
        if (input.type === 'password') {
            input.type = 'text';
            btn.innerHTML = `<span class="text-xs font-bold font-sans">Sembunyikan</span>`;
        } else {
            input.type = 'password';
            btn.innerHTML = `<span class="text-xs font-bold font-sans">Lihat</span>`;
        }
    }
</script>
</body>
</html>
