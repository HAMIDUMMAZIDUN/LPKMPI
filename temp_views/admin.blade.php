<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin — LPK-MI</title>
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
        .glass {
            backdrop-filter: blur(20px);
            transition: all 0.3s ease;
        }
        .sidebar-btn { transition: all .15s; }
        *, ::before, ::after { border-radius: 0px !important; }
        .text-\[9px\] { font-size: 0.75rem !important; }
        .text-\[10px\] { font-size: 0.75rem !important; }
        .text-\[11px\] { font-size: 0.875rem !important; }

        /* Light mode overrides */
        html:not(.dark) body {
            background-color: #f1f5f9 !important;
            color: #0f172a !important;
        }
        html:not(.dark) #adm-main {
            background-color: #f1f5f9 !important;
        }
        html:not(.dark) #adm-main .text-white,
        html:not(.dark) #adm-main .text-slate-100,
        html:not(.dark) #adm-main .text-slate-200 {
            color: #0f172a !important;
        }
        html:not(.dark) #adm-main button .text-white,
        html:not(.dark) #adm-main a .text-white,
        html:not(.dark) #adm-main button.text-white,
        html:not(.dark) #adm-main a.text-white,
        html:not(.dark) #adm-main [class*="bg-emerald"] .text-white,
        html:not(.dark) #adm-main [class*="bg-blue"] .text-white,
        html:not(.dark) #adm-main [class*="bg-rose"] .text-white,
        html:not(.dark) #adm-main [class*="bg-amber"] .text-white {
            color: #ffffff !important;
        }
        html:not(.dark) #adm-main .text-slate-400,
        html:not(.dark) #adm-main .text-slate-500 {
            color: #475569 !important;
        }
        html:not(.dark) #adm-main .border-slate-800,
        html:not(.dark) #adm-main .border-slate-700 {
            border-color: #cbd5e1 !important;
        }
        html:not(.dark) #adm-main .sticky {
            background-color: rgba(255, 255, 255, 0.9) !important;
            border-color: #cbd5e1 !important;
        }
        html:not(.dark) #adm-main .sticky h1 {
            color: #0f172a !important;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-100 dark:bg-slate-950 text-slate-950 dark:text-white transition-colors duration-300">

    <aside id="adm-sidebar" class="fixed top-0 left-0 h-full w-64 bg-slate-900 border-r border-slate-800 flex flex-col z-40 transition-transform duration-300 ease-in-out -translate-x-full">
        <div class="p-6 border-b border-slate-800 flex justify-between items-center">
            <div>
                <div class="text-xs font-black uppercase tracking-widest text-blue-400 mb-1">LPK-MI</div>
                <div class="text-lg font-black text-white">Admin</div>
                <div class="text-xs text-slate-500 mt-0.5">{{ auth()->user()->name }}</div>
            </div>
            <button onclick="toggleAdmSidebar()" class="w-9 h-9 rounded-lg border border-slate-800 bg-slate-900 flex flex-col items-center justify-center gap-1.5 hover:bg-slate-800 transition-all text-slate-400 hover:text-white" title="Sembunyikan Sidebar">
                <span class="block w-4.5 h-0.5 bg-slate-300 rounded-full transition-all duration-300" style="width:18px"></span>
                <span class="block h-0.5 bg-slate-300 rounded-full transition-all duration-300" style="width:14px"></span>
                <span class="block h-0.5 bg-slate-300 rounded-full transition-all duration-300" style="width:18px"></span>
            </button>
        </div>
        <nav class="flex-1 p-4 space-y-1">
            <!-- Group: Manajemen Data -->
            <div class="menu-group">
                <button onclick="toggleAdmMenuGroup('group-manajemen-data', this)" class="w-full flex justify-between items-center px-4 py-2 text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-white transition-colors duration-200">
                    <span>Manajemen Data</span>
                    <svg class="w-3.5 h-3.5 transform transition-transform duration-200 arrow-icon text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="group-manajemen-data" class="space-y-1 pl-2 mt-1">
                    <button onclick="showPanel('p-overview')"    id="btn-p-overview"    class="sidebar-btn w-full text-left px-4 py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider">Overview</button>
                    <button onclick="showPanel('p-schemes')"     id="btn-p-schemes"     class="sidebar-btn w-full text-left px-4 py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider">Skema Penilaian</button>
                    <button onclick="showPanel('p-trainees')"    id="btn-p-trainees"    class="sidebar-btn w-full text-left px-4 py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider">Data Peserta</button>
                </div>
            </div>

            <!-- Group: Kelola Pengguna -->
            <div class="menu-group pt-4 border-t border-slate-800">
                <button onclick="toggleAdmMenuGroup('group-kelola-pengguna', this)" class="w-full flex justify-between items-center px-4 py-2 text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-white transition-colors duration-200">
                    <span>Kelola Pengguna</span>
                    <svg class="w-3.5 h-3.5 transform transition-transform duration-200 arrow-icon text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="group-kelola-pengguna" class="space-y-1 pl-2 mt-1">
                    <button onclick="showPanel('p-asesor')"      id="btn-p-asesor"      class="sidebar-btn w-full text-left px-4 py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider">Kelola Asesor</button>
                    <button onclick="showPanel('p-asesi')"       id="btn-p-asesi"       class="sidebar-btn w-full text-left px-4 py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider">Kelola Asesi</button>
                </div>
            </div>

            <!-- Group: Pengaturan -->
            <div class="menu-group pt-4 border-t border-slate-800">
                <button onclick="toggleAdmMenuGroup('group-pengaturan', this)" class="w-full flex justify-between items-center px-4 py-2 text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-white transition-colors duration-200">
                    <span>Pengaturan</span>
                    <svg class="w-3.5 h-3.5 transform transition-transform duration-200 arrow-icon text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="group-pengaturan" class="space-y-1 pl-2 mt-1">
                    <button onclick="showPanel('p-profile')"      id="btn-p-profile"      class="sidebar-btn w-full text-left px-4 py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider text-slate-400 hover:bg-slate-800 hover:text-white transition-all">Profil Saya</button>
                </div>
            </div>

            <div class="pt-4 mt-4 border-t border-slate-800">
                <a href="{{ route('home') }}" class="flex items-center px-4 py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider text-slate-400 hover:bg-slate-800 hover:text-white transition-all">Website Utama</a>
            </div>
        </nav>
        <div class="p-4 border-t border-slate-800">
            <form action="{{ route('logout') }}" method="POST">@csrf
                <button type="submit" class="w-full bg-rose-600/10 hover:bg-rose-600/20 text-rose-400 border border-rose-500/20 font-bold text-xs uppercase py-2.5 rounded-lg transition-all">Keluar</button>
            </form>
        </div>
    </aside>

    {{-- Sidebar Overlay (mobile) --}}
    <div id="adm-overlay" onclick="toggleAdmSidebar()" class="fixed inset-0 bg-black/40 z-30 hidden backdrop-blur-sm"></div>

    <div id="adm-main" class="ml-0 lg:ml-64 min-h-screen transition-all duration-300 ease-in-out">
        <div class="sticky top-0 z-20 bg-slate-900/80 backdrop-blur border-b border-slate-800 px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <button onclick="toggleAdmSidebar()" title="Sembunyikan / Tampilkan Sidebar"
                    class="w-9 h-9 rounded-lg border border-slate-800 bg-slate-900 flex flex-col items-center justify-center gap-1.5 hover:bg-slate-800 transition-all">
                    <span class="block w-4.5 h-0.5 bg-slate-300 rounded-full" style="width:18px"></span>
                    <span class="block h-0.5 bg-slate-300 rounded-full" style="width:14px"></span>
                    <span class="block h-0.5 bg-slate-300 rounded-full" style="width:18px"></span>
                </button>
                <div>
                    <h1 class="text-sm font-black text-white">Dashboard Admin LPK-MI</h1>
                    <p class="text-[10px] text-slate-500 uppercase tracking-wider">Pantau & Kelola Asesor, Asesi, dan Skema</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <button onclick="toggleAdmTheme()" title="Ganti Tema" class="w-9 h-9 rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-100 dark:bg-slate-900 flex items-center justify-center text-slate-655 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-800 transition-all text-sm shadow-sm">
                    <span id="adm-theme-icon">☀️</span>
                </button>
                <div class="flex items-center gap-2 bg-blue-500/10 border border-blue-500/20 px-3 py-1.5 rounded-full">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></span>
                    <span class="text-[10px] font-bold text-blue-400 uppercase tracking-wider">Admin/Asesor Aktif</span>
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
                        <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Total Asesor</div>
                    </div>
                    <div class="glass rounded-2xl p-5 border border-violet-500/10 bg-violet-500/5">
                        <div class="text-3xl font-black text-white mb-1">{{ $asesis->count() }}</div>
                        <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Total Asesi</div>
                    </div>
                    <div class="glass rounded-2xl p-5 border border-emerald-500/10 bg-emerald-500/5">
                        <div class="text-3xl font-black text-white mb-1">{{ $schemes->where('status','published')->count() }}</div>
                        <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Skema Published</div>
                    </div>
                    <div class="glass rounded-2xl p-5 border border-amber-500/10 bg-amber-500/5">
                        <div class="text-3xl font-black text-white mb-1">{{ $certCount }}</div>
                        <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Sertifikat Terbit</div>
                    </div>
                </div>

                <div class="glass rounded-2xl overflow-hidden">
                    <div class="p-5 border-b border-slate-800"><h3 class="font-bold text-white">Aktivitas Asesor</h3></div>
                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-sm">
                            <thead><tr class="border-b border-slate-800 text-slate-400 text-[10px] uppercase tracking-wider font-bold">
                                <th class="px-5 py-3 text-left">Username Asesor</th>
                                <th class="px-5 py-3 text-left">Email</th>
                                <th class="px-5 py-3 text-center">Jumlah Skema</th>
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
                                    <tr><td colspan="3" class="px-5 py-8 text-center text-slate-500">Belum ada asesor terdaftar.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- KELOLA ASESOR --}}
            <div id="p-asesor" class="dashboard-panel hidden">
                <h2 class="text-xl font-black mb-6">Kelola Asesor</h2>

                <div class="glass rounded-2xl p-6 mb-6">
                    <h3 class="font-bold text-white mb-4 text-sm">Daftarkan Asesor Baru</h3>
                    <form action="{{ route('admin.asesor.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Username Asesor</label>
                            <input type="text" name="username" required placeholder="Contoh: asesor_baru" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Email</label>
                            <input type="email" name="email" required placeholder="asesor@gmail.com" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-blue-500">
                        </div>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase tracking-wider px-6 py-2.5 rounded-lg transition-all">Daftarkan</button>
                    </form>
                </div>

                <div class="glass rounded-2xl overflow-hidden">
                    <div class="p-5 border-b border-slate-800"><h3 class="font-bold text-white">Daftar Asesor</h3></div>
                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-sm">
                            <thead><tr class="border-b border-slate-800 text-slate-400 text-[10px] uppercase tracking-wider font-bold">
                                <th class="px-5 py-3 text-left">Username</th>
                                <th class="px-5 py-3 text-left">Email</th>
                                <th class="px-5 py-3 text-center">Skema</th>
                                <th class="px-5 py-3 text-right">Aksi</th>
                            </tr></thead>
                            <tbody class="divide-y divide-slate-800">
                                @forelse($asetors as $a)
                                    <tr>
                                        <td class="px-5 py-3 font-bold text-white">{{ $a->name }}</td>
                                        <td class="px-5 py-3 text-slate-400 font-mono text-xs">{{ $a->email }}</td>
                                        <td class="px-5 py-3 text-center text-slate-300">{{ $a->schemes_count }}</td>
                                        <td class="px-5 py-3 text-right">
                                            <form action="{{ route('admin.user.destroy', $a->id) }}" method="POST" onsubmit="return confirm('Hapus asesor {{ $a->name }}?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-rose-500 hover:text-rose-400 font-bold text-xs uppercase tracking-wider">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="px-5 py-8 text-center text-slate-500">Belum ada asesor.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- KELOLA ASESI --}}
            <div id="p-asesi" class="dashboard-panel hidden">
                <h2 class="text-xl font-black mb-6">Kelola Asesi</h2>
                <div class="glass rounded-2xl p-6 mb-6">
                    <h3 class="font-bold text-white mb-4 text-sm">Daftarkan Asesi Baru</h3>
                    <form action="{{ route('admin.asesi.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Username</label>
                            <input type="text" name="username" required placeholder="Contoh: asesi_baru" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-violet-500">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Email</label>
                            <input type="email" name="email" required placeholder="asesi@gmail.com" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-violet-500">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Password</label>
                            <div class="relative w-full">
                                <input type="password" name="password" required placeholder="Min 6 karakter" class="w-full bg-slate-900 border border-slate-700 rounded-lg pl-3 pr-10 py-2 text-sm text-white focus:outline-none focus:border-violet-500">
                                <button type="button" onclick="togglePasswordVisibility(this)" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-450 hover:text-slate-350 transition-colors">
                                    <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <button type="submit" class="bg-violet-600 hover:bg-violet-700 text-white font-bold text-xs uppercase tracking-wider px-6 py-2.5 rounded-lg transition-all">Daftarkan</button>
                    </form>
                </div>

                <div class="glass rounded-2xl overflow-hidden">
                    <div class="p-5 border-b border-slate-800"><h3 class="font-bold text-white">Daftar Asesi</h3></div>
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
                                            <form action="{{ route('admin.user.destroy', $asi->id) }}" method="POST" onsubmit="return confirm('Hapus asesi {{ $asi->name }}?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-rose-500 hover:text-rose-400 font-bold text-xs uppercase tracking-wider">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="px-5 py-8 text-center text-slate-500">Belum ada asesi.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- SKEMA PENILAIAN --}}
            <div id="p-schemes" class="dashboard-panel hidden">
                <h2 class="text-xl font-black mb-6">Skema Penilaian</h2>

                {{-- Form Assign Skema --}}
                <div class="glass rounded-2xl p-6 mb-6">
                    <h3 class="font-bold text-white mb-4 text-sm">Tugaskan Skema ke Asesor</h3>
                    <form action="{{ route('admin.scheme.assign') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Pilih Skema</label>
                            <select name="scheme_id" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-emerald-500">
                                <option value="">-- Pilih Skema --</option>
                                @foreach($schemes as $s)
                                    <option value="{{ $s->id }}">{{ $s->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Pilih Asesor</label>
                            <select name="asesor_id" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-emerald-500">
                                <option value="">-- Pilih Asesor --</option>
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
                    <div class="p-5 border-b border-slate-800"><h3 class="font-bold text-white">Semua Skema</h3></div>
                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-sm">
                            <thead><tr class="border-b border-slate-800 text-slate-400 text-[10px] uppercase font-bold">
                                <th class="px-5 py-3 text-left">Judul Skema</th>
                                <th class="px-5 py-3 text-left">Asesor</th>
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
                                    <tr><td colspan="4" class="px-5 py-8 text-center text-slate-500">Belum ada skema.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- DATA PESERTA --}}
            <div id="p-trainees" class="dashboard-panel hidden">
                <h2 class="text-xl font-black mb-6">Data Peserta & Sertifikat</h2>
                <div class="glass rounded-2xl overflow-hidden">
                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-sm">
                            <thead><tr class="border-b border-slate-800 text-slate-400 text-[10px] uppercase font-bold">
                                <th class="px-5 py-3 text-left">Nama</th>
                                <th class="px-5 py-3 text-left">NIK</th>
                                <th class="px-5 py-3 text-left">Program</th>
                                <th class="px-5 py-3 text-center">Status</th>
                                <th class="px-5 py-3 text-right">Aksi</th>
                            </tr></thead>
                            <tbody class="divide-y divide-slate-800">
                                @forelse($trainees as $t)
                                    <tr>
                                        <td class="px-5 py-3 font-bold text-white">{{ $t->name }}</td>
                                        <td class="px-5 py-3 font-mono text-xs text-slate-400">{{ $t->nik }}</td>
                                        <td class="px-5 py-3 text-slate-300 text-xs">{{ $t->trainingProgram?->title }}</td>
                                        <td class="px-5 py-3 text-center">
                                            @if($t->status === 'LULUS')
                                                <span class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-2 py-0.5 rounded-full text-[10px] font-bold uppercase">Lulus</span>
                                            @else
                                                <span class="bg-amber-500/10 text-amber-400 border border-amber-500/20 px-2 py-0.5 rounded-full text-[10px] font-bold uppercase">Proses</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-3 text-right">
                                            @if($t->status !== 'LULUS')
                                                <form action="{{ route('admin.trainees.approve', $t->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-[9px] font-bold uppercase tracking-wider px-3 py-1.5 rounded-md transition-all">ACC</button>
                                                </form>
                                            @else
                                                <span class="text-slate-600 text-xs">✓ Terbit</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="px-5 py-8 text-center text-slate-500">Belum ada data peserta.</td></tr>
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
                    <p class="text-slate-500 text-sm mt-1">Ubah nama pengguna, email, dan kata sandi akun Admin Anda.</p>
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
    const allPanels = ['p-overview','p-asesor','p-asesi','p-schemes','p-trainees','p-profile'];
    function showPanel(id) {
        allPanels.forEach(p => document.getElementById(p).classList.add('hidden'));
        document.getElementById(id).classList.remove('hidden');
        document.querySelectorAll('.sidebar-btn').forEach(b => {
            b.classList.remove('bg-slate-800','text-white');
            b.classList.add('text-slate-400','hover:bg-slate-800','hover:text-white');
        });
        const btn = document.getElementById('btn-'+id);
        if(btn){ btn.classList.remove('text-slate-400','hover:bg-slate-800','hover:text-white'); btn.classList.add('bg-slate-800','text-white'); }
        localStorage.setItem('admin_panel', id);

        // Auto-collapse sidebar on mobile after clicking
        if (window.innerWidth < 1024) {
            const sidebar = document.getElementById('adm-sidebar');
            const overlay = document.getElementById('adm-overlay');
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }
    }

    function toggleAdmSidebar() {
        const sidebar = document.getElementById('adm-sidebar');
        const main    = document.getElementById('adm-main');
        const overlay = document.getElementById('adm-overlay');
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
            localStorage.setItem('adm_sidebar_open', isNowOpen ? '1' : '0');
        }
    }

    function toggleAdmMenuGroup(groupId, btn) {
        const groupEl = document.getElementById(groupId);
        const arrow = btn.querySelector('.arrow-icon');
        
        if (groupEl.classList.contains('hidden')) {
            groupEl.classList.remove('hidden');
            if (arrow) arrow.classList.remove('-rotate-90');
        } else {
            groupEl.classList.add('hidden');
            if (arrow) arrow.classList.add('-rotate-90');
        }
        
        localStorage.setItem('adm_group_' + groupId, groupEl.classList.contains('hidden') ? 'collapsed' : 'open');
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
        const icon = document.getElementById('adm-theme-icon');
        if (!icon) return;
        const isDark = document.documentElement.classList.contains('dark');
        icon.textContent = isDark ? '🌙' : '☀️';
    }

    document.addEventListener('DOMContentLoaded', () => {
        showPanel(localStorage.getItem('admin_panel') || 'p-overview');
        updateAdmThemeIcon();

        const isMobile = window.innerWidth < 1024;
        const sidebar = document.getElementById('adm-sidebar');
        const main    = document.getElementById('adm-main');
        const savedOpen = localStorage.getItem('adm_sidebar_open');

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
        const groups = ['group-manajemen-data', 'group-kelola-pengguna', 'group-pengaturan'];
        groups.forEach(gId => {
            const savedState = localStorage.getItem('adm_group_' + gId);
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

    function togglePasswordVisibility(btn) {
        const input = btn.previousElementSibling;
        if (input.type === 'password') {
            input.type = 'text';
            btn.innerHTML = `
                <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                </svg>
            `;
        } else {
            input.type = 'password';
            btn.innerHTML = `
                <svg class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            `;
        }
    }
</script>
</body>
</html>
