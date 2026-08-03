<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Asesor — LPK-MI</title>
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
        *, ::before, ::after { border-radius: 0px !important; }
        .text-\[9px\] { font-size: 0.75rem !important; }
        .text-\[10px\] { font-size: 0.75rem !important; }
        .text-\[11px\] { font-size: 0.875rem !important; }

        /* Light mode overrides */
        html:not(.dark) body {
            background-color: #f1f5f9 !important;
            color: #0f172a !important;
        }
        html:not(.dark) #asr-main {
            background-color: #f1f5f9 !important;
        }
        html:not(.dark) #asr-main .text-white,
        html:not(.dark) #asr-main .text-slate-100,
        html:not(.dark) #asr-main .text-slate-200 {
            color: #0f172a !important;
        }
        html:not(.dark) #asr-main button .text-white,
        html:not(.dark) #asr-main a .text-white,
        html:not(.dark) #asr-main button.text-white,
        html:not(.dark) #asr-main a.text-white,
        html:not(.dark) #asr-main [class*="bg-emerald"] .text-white,
        html:not(.dark) #asr-main [class*="bg-blue"] .text-white,
        html:not(.dark) #asr-main [class*="bg-rose"] .text-white,
        html:not(.dark) #asr-main [class*="bg-amber"] .text-white {
            color: #ffffff !important;
        }
        html:not(.dark) #asr-main .text-slate-400,
        html:not(.dark) #asr-main .text-slate-500 {
            color: #475569 !important;
        }
        html:not(.dark) #asr-main .border-slate-800,
        html:not(.dark) #asr-main .border-slate-700 {
            border-color: #cbd5e1 !important;
        }
        html:not(.dark) #asr-main .sticky {
            background-color: rgba(255, 255, 255, 0.9) !important;
            border-color: #cbd5e1 !important;
        }
        html:not(.dark) #asr-main .sticky h1 {
            color: #0f172a !important;
        }
    </style>
</head>
<body class="min-h-screen bg-slate-100 dark:bg-slate-950 text-slate-950 dark:text-white transition-colors duration-300">

    <aside id="asr-sidebar" class="fixed top-0 left-0 h-full w-64 bg-slate-900 border-r border-slate-800 flex flex-col z-40 transition-transform duration-300 ease-in-out -translate-x-full">
        <div class="p-6 border-b border-slate-800 flex justify-between items-center">
            <div>
                <div class="text-xs font-black uppercase tracking-widest text-emerald-400 mb-1">LPK-MI</div>
                <div class="text-lg font-black text-white">Asesor</div>
                <div class="text-xs text-slate-500 mt-0.5">{{ auth()->user()->name }}</div>
            </div>
            <button onclick="toggleAsrSidebar()" class="w-9 h-9 rounded-lg border border-slate-800 bg-slate-900 flex flex-col items-center justify-center gap-1.5 hover:bg-slate-800 transition-all text-slate-400 hover:text-white" title="Sembunyikan Sidebar">
                <span class="block w-4.5 h-0.5 bg-slate-300 rounded-full transition-all duration-300" style="width:18px"></span>
                <span class="block h-0.5 bg-slate-300 rounded-full transition-all duration-300" style="width:14px"></span>
                <span class="block h-0.5 bg-slate-300 rounded-full transition-all duration-300" style="width:18px"></span>
            </button>
        </div>
        <nav class="flex-1 p-4 space-y-1">
            <!-- Group: Menu Asesor -->
            <div class="menu-group">
                <button onclick="toggleAsrMenuGroup('group-menu-asesor', this)" class="w-full flex justify-between items-center px-4 py-2 text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-white transition-colors duration-200">
                    <span>Menu Asesor</span>
                    <svg class="w-3.5 h-3.5 transform transition-transform duration-200 arrow-icon text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="group-menu-asesor" class="space-y-1 pl-2 mt-1">
                    <button onclick="showPanel('p-schemes')" id="btn-p-schemes" class="sidebar-btn w-full text-left px-4 py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider text-slate-400 hover:bg-slate-800 hover:text-white transition-all">Skema Saya</button>
                    <button onclick="showPanel('p-profile')" id="btn-p-profile" class="sidebar-btn w-full text-left px-4 py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider text-slate-400 hover:bg-slate-800 hover:text-white transition-all">Profil Saya</button>
                </div>
            </div>
        </nav>
        <div class="p-4 border-t border-slate-800">
            <form action="{{ route('logout') }}" method="POST">@csrf
                <button type="submit" class="w-full bg-rose-600/10 hover:bg-rose-600/20 text-rose-400 border border-rose-500/20 font-bold text-xs uppercase py-2.5 rounded-lg transition-all">Keluar</button>
            </form>
        </div>
    </aside>

    {{-- Sidebar Overlay (mobile) --}}
    <div id="asr-overlay" onclick="toggleAsrSidebar()" class="fixed inset-0 bg-black/40 z-30 hidden backdrop-blur-sm"></div>

    <div id="asr-main" class="ml-0 lg:ml-64 min-h-screen transition-all duration-300 ease-in-out">
        <div class="sticky top-0 z-20 bg-slate-900/80 backdrop-blur border-b border-slate-800 px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <button onclick="toggleAsrSidebar()" title="Sembunyikan / Tampilkan Sidebar"
                    class="w-9 h-9 rounded-lg border border-slate-800 bg-slate-900 flex flex-col items-center justify-center gap-1.5 hover:bg-slate-800 transition-all">
                    <span class="block w-4.5 h-0.5 bg-slate-300 rounded-full" style="width:18px"></span>
                    <span class="block h-0.5 bg-slate-300 rounded-full" style="width:14px"></span>
                    <span class="block h-0.5 bg-slate-300 rounded-full" style="width:18px"></span>
                </button>
                <div>
                    <h1 class="text-sm font-black text-white">Dashboard Asesor</h1>
                    <p class="text-[10px] text-slate-500 uppercase tracking-wider">Buat & Kelola Skema Penilaian</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <button onclick="toggleAsrTheme()" title="Ganti Tema" class="w-9 h-9 rounded-lg border border-slate-200 dark:border-slate-800 bg-slate-100 dark:bg-slate-900 flex items-center justify-center text-slate-655 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-800 transition-all text-sm shadow-sm">
                    <span id="asr-theme-icon">☀️</span>
                </button>
                <div class="flex items-center gap-2 bg-emerald-500/10 border border-emerald-500/20 px-3 py-1.5 rounded-full">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="text-[10px] font-bold text-emerald-400 uppercase tracking-wider">Asesor Aktif</span>
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
                <h3 class="font-bold text-white mb-4 text-sm">Buat Skema Penilaian Baru</h3>
                <form action="{{ route('asesor.scheme.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    @csrf
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Judul Skema</label>
                        <input type="text" name="title" required placeholder="cth: Skema K3 Konstruksi Tingkat I" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-emerald-500">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Durasi (menit)</label>
                        <input type="number" name="duration_minutes" value="60" min="5" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-emerald-500">
                    </div>
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs uppercase tracking-wider px-6 py-2.5 rounded-lg transition-all">Buat Skema</button>
                </form>
            </div>

            {{-- Schemes List --}}
            <div>
                <h2 class="text-xl font-black mb-4">Skema Penilaian Saya</h2>
                @if($schemes->isEmpty())
                    <div class="glass rounded-2xl p-12 text-center">
                        <div class="text-5xl mb-4">📋</div>
                        <p class="text-slate-400 text-sm">Belum ada skema. Buat skema pertama Anda di atas.</p>
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
                                    <form action="{{ route('asesor.scheme.delete', $s->id) }}" method="POST" onsubmit="return confirm('Hapus skema ini?')">
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

            {{-- Panel: Profil Saya --}}
            <div id="p-profile" class="dashboard-panel hidden">
                <div class="mb-6">
                    <h2 class="text-xl font-black text-white font-heading">Profil Saya</h2>
                    <p class="text-slate-500 text-sm mt-1">Ubah nama pengguna, email, dan kata sandi akun Asesor Anda.</p>
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
                            <input type="email" name="email" value="{{ auth()->user()->email }}" required placeholder="asesor@gmail.com"
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
        const allPanels = ['p-schemes', 'p-profile'];
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
