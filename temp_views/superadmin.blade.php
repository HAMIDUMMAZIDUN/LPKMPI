<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Superadmin — LPK-MI</title>
    <script>
        // Apply saved theme before page renders to prevent flash
        (function() {
            const saved = localStorage.getItem('sa_theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (saved === 'dark' || (!saved && prefersDark)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { darkMode: 'class' }</script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass {
            background: rgba(15,23,42,0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.07);
        }
        .dark .glass {
            background: rgba(15,23,42,0.85);
            border-color: rgba(255,255,255,0.07);
        }
        html:not(.dark) .glass {
            background: rgba(248,250,252,0.85);
            border-color: rgba(0,0,0,0.08);
        }
        /* Smooth theme transition */
        *, *::before, *::after { transition: background-color 0.2s ease, border-color 0.2s ease, color 0.15s ease; }
        
        /* Strip all rounded corners */
        *, ::before, ::after { border-radius: 0px !important; }
        
        /* Standardize small text sizes to standard readable web dimensions */
        .text-\[9px\] { font-size: 0.75rem !important; }
        .text-\[10px\] { font-size: 0.75rem !important; }
        .text-\[11px\] { font-size: 0.875rem !important; }
    </style>
</head>
<body class="min-h-screen bg-slate-100 dark:bg-slate-950 text-slate-950 dark:text-white">

    {{-- Sidebar --}}
    <aside id="sa-sidebar" class="fixed top-0 left-0 h-full w-64 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 flex flex-col z-40 shadow-sm transition-transform duration-300 ease-in-out -translate-x-full">
        <div class="p-6 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center">
            <div>
                <div class="text-xs font-black uppercase tracking-widest text-indigo-500 dark:text-indigo-400 mb-1">LPK-MI</div>
                <div class="text-lg font-black text-slate-900 dark:text-white">Superadmin</div>
                <div class="text-xs text-slate-500 mt-0.5">{{ auth()->user()->name }}</div>
            </div>
            <button onclick="toggleSidebar()" class="w-9 h-9 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800 flex flex-col items-center justify-center gap-1.5 hover:bg-slate-200 dark:hover:bg-slate-700 transition-all" title="Sembunyikan Sidebar">
                <span class="block w-4.5 h-0.5 bg-slate-600 dark:bg-slate-300 rounded-full transition-all duration-300" style="width:18px"></span>
                <span class="block h-0.5 bg-slate-600 dark:bg-slate-300 rounded-full transition-all duration-300" style="width:14px"></span>
                <span class="block h-0.5 bg-slate-600 dark:bg-slate-300 rounded-full transition-all duration-300" style="width:18px"></span>
            </button>
        </div>

        <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
            <!-- Group: Navigasi Utama -->
            <div class="menu-group">
                <button onclick="toggleSaMenuGroup('group-navigasi-utama', this)" class="w-full flex justify-between items-center px-4 py-2 text-[9px] font-black uppercase tracking-widest text-slate-500 hover:text-slate-900 dark:hover:text-white transition-colors duration-200">
                    <span>Navigasi Utama</span>
                    <svg class="w-3.5 h-3.5 transform transition-transform duration-200 arrow-icon text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="group-navigasi-utama" class="space-y-1 pl-2 mt-1">
                    <button onclick="showPanel('panel-identity')" id="btn-identity"
                        class="sidebar-btn w-full text-left px-4 py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-all">
                        Identitas Situs
                    </button>
                    <button onclick="showPanel('panel-hero')" id="btn-hero"
                        class="sidebar-btn w-full text-left px-4 py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-all">
                        Hero Utama
                    </button>
                    <button onclick="showPanel('panel-stats')" id="btn-stats"
                        class="sidebar-btn w-full text-left px-4 py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-all">
                        Statistik
                    </button>
                    <button onclick="showPanel('panel-steps')" id="btn-steps"
                        class="sidebar-btn w-full text-left px-4 py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-all">
                        Alur Registrasi
                    </button>
                    <button onclick="showPanel('panel-features')" id="btn-features"
                        class="sidebar-btn w-full text-left px-4 py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-all">
                        Keunggulan & Fitur
                    </button>
                    <button onclick="showPanel('panel-gallery')" id="btn-gallery"
                        class="sidebar-btn w-full text-left px-4 py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-all">
                        Galeri
                    </button>
                    <button onclick="showPanel('panel-login-branding')" id="btn-login-branding"
                        class="sidebar-btn w-full text-left px-4 py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-all">
                        Halaman Login
                    </button>
                </div>
            </div>

            <!-- Group: Manajemen Pengguna -->
            <div class="menu-group pt-4 border-t border-slate-200 dark:border-slate-800">
                <button onclick="toggleSaMenuGroup('group-manajemen-pengguna', this)" class="w-full flex justify-between items-center px-4 py-2 text-[9px] font-black uppercase tracking-widest text-slate-500 hover:text-slate-900 dark:hover:text-white transition-colors duration-200">
                    <span>Manajemen Pengguna</span>
                    <svg class="w-3.5 h-3.5 transform transition-transform duration-200 arrow-icon text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="group-manajemen-pengguna" class="space-y-1 pl-2 mt-1">
                    <button onclick="showPanel('panel-users')" id="btn-users"
                        class="sidebar-btn w-full text-left px-4 py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-all">
                        Akun Admin & Asesor
                    </button>
                </div>
            </div>

            <!-- Group: Pengaturan Akun -->
            <div class="menu-group pt-4 border-t border-slate-200 dark:border-slate-800">
                <button onclick="toggleSaMenuGroup('group-pengaturan-akun', this)" class="w-full flex justify-between items-center px-4 py-2 text-[9px] font-black uppercase tracking-widest text-slate-500 hover:text-slate-900 dark:hover:text-white transition-colors duration-200">
                    <span>Pengaturan Akun</span>
                    <svg class="w-3.5 h-3.5 transform transition-transform duration-200 arrow-icon text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="group-pengaturan-akun" class="space-y-1 pl-2 mt-1">
                    <button onclick="showPanel('panel-profile')" id="btn-profile"
                        class="sidebar-btn w-full text-left px-4 py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-all">
                        Profil Saya
                    </button>
                </div>
            </div>

            <div class="pt-4 mt-4 border-t border-slate-200 dark:border-slate-800">
                <a href="{{ route('home') }}" class="flex items-center px-4 py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white transition-all">
                    Website Utama
                </a>
            </div>
        </nav>

        <div class="p-4 border-t border-slate-200 dark:border-slate-800">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-rose-600/10 hover:bg-rose-600/20 text-rose-500 dark:text-rose-400 border border-rose-500/20 font-bold text-xs uppercase tracking-wider py-2.5 rounded-lg transition-all">
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- Sidebar Overlay (mobile) --}}
    <div id="sa-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/40 z-30 hidden backdrop-blur-sm"></div>

    {{-- Main Content --}}
    <div id="sa-main" class="ml-0 lg:ml-64 min-h-screen transition-all duration-300 ease-in-out">
        {{-- Topbar --}}
        <div class="sticky top-0 z-20 bg-white/90 dark:bg-slate-900/80 backdrop-blur border-b border-slate-200 dark:border-slate-800 px-6 py-4 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-4">
                {{-- Hamburger Button --}}
                <button id="sa-hamburger" onclick="toggleSidebar()" title="Sembunyikan / Tampilkan Sidebar"
                    class="w-9 h-9 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800 flex flex-col items-center justify-center gap-1.5 hover:bg-slate-200 dark:hover:bg-slate-700 transition-all">
                    <span id="hb-line-1" class="block w-4.5 h-0.5 bg-slate-600 dark:bg-slate-300 rounded-full transition-all duration-300" style="width:18px"></span>
                    <span id="hb-line-2" class="block h-0.5 bg-slate-600 dark:bg-slate-300 rounded-full transition-all duration-300" style="width:14px"></span>
                    <span id="hb-line-3" class="block h-0.5 bg-slate-600 dark:bg-slate-300 rounded-full transition-all duration-300" style="width:18px"></span>
                </button>
                <div>
                    <h1 class="text-sm font-black tracking-tight text-slate-900 dark:text-white">Dashboard Superadmin</h1>
                    <p class="text-[10px] text-slate-500 uppercase tracking-wider">Kelola Konten Halaman Utama</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                {{-- Theme Toggle --}}
                <button id="sa-theme-toggle" onclick="toggleSATheme()"
                    title="Ganti Mode Terang / Gelap"
                    class="w-9 h-9 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 transition-all text-sm">
                    <span id="sa-theme-icon" class="select-none">☀️</span>
                </button>
                <div class="flex items-center gap-2 bg-indigo-500/10 border border-indigo-500/20 px-3 py-1.5 rounded-full">
                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-pulse"></span>
                    <span class="text-[10px] font-bold text-indigo-500 dark:text-indigo-400 uppercase tracking-wider">Superadmin Aktif</span>
                </div>
            </div>
        </div>

        <div class="p-8">
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="mb-6 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 px-4 py-3 rounded-xl text-sm font-medium animate-fade-in">
                    ✓ {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 bg-rose-500/10 border border-rose-500/30 text-rose-400 px-4 py-3 rounded-xl text-sm font-medium animate-fade-in">
                    ✕ {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div class="mb-6 bg-rose-500/10 border border-rose-500/30 text-rose-400 px-4 py-3 rounded-xl text-sm font-medium animate-fade-in">
                    <strong class="block mb-1">Gagal menyimpan data:</strong>
                    <ul class="list-disc pl-5 space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                      {{-- Panel: Hero Utama --}}
            <div id="panel-hero" class="dashboard-panel hidden">
                <div class="mb-6">
                    <h2 class="text-xl font-black text-slate-900 dark:text-white font-heading">Hero Utama</h2>
                    <p class="text-slate-600 dark:text-slate-400 text-sm mt-1">Ubah judul, sub-judul, dan gambar sampul utama di halaman beranda.</p>
                </div>

                <form action="{{ route('superadmin.settings.update') }}" method="POST" enctype="multipart/form-data" class="glass rounded-2xl p-6 space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="space-y-5">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-1.5">Judul Hero (Hero Title)</label>
                                <input type="text" name="hero_title" value="{{ $settings['hero_title'] ?? 'Persiapkan Kompetensi Anda Untuk Sertifikasi Profesional' }}" required
                                    class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500 transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-1.5">Sub-Judul (Hero Subtitle)</label>
                                <textarea name="hero_subtitle" rows="4" required
                                    class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500 transition-all resize-none">{{ $settings['hero_subtitle'] ?? 'LPK-MI membantu calon asesi, guru, dosen, dan praktisi menguasai standar kompetensi nasional sebelum menempuh ujian sertifikasi resmi di LSP.' }}</textarea>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-1.5">Foto Sampul (Hero Image)</label>
                            @if(!empty($settings['hero_image']))
                                <img src="{{ asset('storage/' . $settings['hero_image']) }}" class="w-full h-40 object-cover rounded-xl mb-3 border border-slate-300 dark:border-slate-700" alt="Hero Image">
                            @endif
                            <div class="border-2 border-dashed border-slate-300 dark:border-slate-700 rounded-xl p-6 text-center hover:border-indigo-500 transition-all">
                                <input type="file" name="hero_image" accept="image/*" class="hidden" id="hero-image-input"
                                    onchange="document.getElementById('hero-image-label').textContent = this.files[0]?.name || 'Pilih file...'">
                                <label for="hero-image-input" class="cursor-pointer">
                                    <div class="text-slate-600 dark:text-slate-400 text-sm">
                                        <span class="block text-2xl mb-2">📸</span>
                                        <span id="hero-image-label">Klik untuk upload foto (JPG, PNG, WebP - max 2MB)</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end pt-2">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs uppercase tracking-wider px-8 py-3 rounded-lg transition-all shadow-lg shadow-indigo-500/20">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            {{-- Panel: Statistik --}}
            <div id="panel-stats" class="dashboard-panel hidden">
                <div class="mb-6">
                    <h2 class="text-xl font-black text-slate-900 dark:text-white font-heading">Statistik Halaman Utama</h2>
                    <p class="text-slate-600 dark:text-slate-400 text-sm mt-1">Ubah data angka dan deskripsi singkat statistik pencapaian lembaga.</p>
                </div>

                <form action="{{ route('superadmin.settings.update') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="stat_count" id="stat_count_input" value="{{ $settings['stat_count'] ?? 3 }}">
                    <div id="stats-container" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @php
                            $statCount = (int) ($settings['stat_count'] ?? 3);
                        @endphp
                        @for($i = 1; $i <= $statCount; $i++)
                        <div class="glass rounded-2xl p-5 space-y-4 stat-card" data-index="{{ $i }}">
                            <div class="flex justify-between items-center">
                                <span class="text-[9px] font-black uppercase tracking-widest text-indigo-500 dark:text-indigo-400 font-heading">Statistik {{ $i }}</span>
                                @if($i > 3)
                                <button type="button" onclick="removeStatCard(this)" class="text-rose-600 dark:text-rose-400 hover:text-rose-500 text-xs font-bold uppercase tracking-wider">Hapus</button>
                                @endif
                            </div>
                            <div>
                                <label class="block text-[9px] font-bold text-slate-600 dark:text-slate-400 uppercase mb-1">Nilai (Value)</label>
                                <input type="text" name="stat_{{ $i }}_val" value="{{ $settings['stat_' . $i . '_val'] ?? '' }}"
                                    class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-3 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-[9px] font-bold text-slate-600 dark:text-slate-400 uppercase mb-1">Label</label>
                                <input type="text" name="stat_{{ $i }}_lbl" value="{{ $settings['stat_' . $i . '_lbl'] ?? '' }}"
                                    class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-3 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
                            </div>
                        </div>
                        @endfor
                    </div>
                    <div class="flex justify-between items-center pt-2">
                        <button type="button" id="add-stat-btn" class="bg-slate-105 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-900 dark:text-white font-bold text-xs uppercase tracking-wider px-4 py-2.5 rounded-lg transition-all border border-slate-300 dark:border-slate-700 shadow-md">
                            + Tambah Statistik
                        </button>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs uppercase tracking-wider px-8 py-3 rounded-lg transition-all shadow-lg shadow-indigo-500/20">
                            Simpan Statistik
                        </button>
                    </div>
                </form>
            </div>

            {{-- Panel: Alur Registrasi --}}
            <div id="panel-steps" class="dashboard-panel hidden">
                <div class="mb-6">
                    <h2 class="text-xl font-black text-slate-900 dark:text-white font-heading">Alur Langkah Registrasi</h2>
                    <p class="text-slate-600 dark:text-slate-400 text-sm mt-1">Ubah judul setiap tahapan alur pendaftaran dan sertifikasi.</p>
                </div>

                <form action="{{ route('superadmin.settings.update') }}" method="POST" class="glass rounded-2xl p-6 space-y-6">
                    @csrf
                    <input type="hidden" name="step_count" id="step_count_input" value="{{ $settings['step_count'] ?? 3 }}">
                    <div id="steps-container" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @php
                            $stepCount = (int) ($settings['step_count'] ?? 3);
                        @endphp
                        @for($i = 1; $i <= $stepCount; $i++)
                        <div class="space-y-2 step-card" data-index="{{ $i }}">
                            <div class="flex justify-between items-center mb-1.5">
                                <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Langkah {{ $i }}</label>
                                @if($i > 3)
                                <button type="button" onclick="removeStepCard(this)" class="text-rose-600 dark:text-rose-400 hover:text-rose-500 text-[10px] font-bold uppercase tracking-wider">Hapus</button>
                                @endif
                            </div>
                            <input type="text" name="step_{{ $i }}_title" value="{{ $settings['step_' . $i . '_title'] ?? '' }}"
                                class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
                        </div>
                        @endfor
                    </div>
                    <div class="flex justify-between items-center pt-2">
                        <button type="button" id="add-step-btn" class="bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs uppercase tracking-wider px-4 py-2.5 rounded-lg transition-all border border-slate-700 shadow-md">
                            + Tambah Langkah
                        </button>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs uppercase tracking-wider px-8 py-3 rounded-lg transition-all shadow-lg shadow-indigo-500/20">
                            Simpan Langkah
                        </button>
                    </div>
                </form>
            </div>

            {{-- Panel: Keunggulan & Fitur --}}
            <div id="panel-features" class="dashboard-panel hidden">
                <div class="mb-6">
                    <h2 class="text-xl font-black text-slate-900 dark:text-white font-heading">Keunggulan & Fitur</h2>
                    <p class="text-slate-600 dark:text-slate-400 text-sm mt-1">Ubah judul utama dan rincian ke-3 fitur unggulan lembaga.</p>
                </div>

                <form action="{{ route('superadmin.settings.update') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="feature_count" id="feature_count_input" value="{{ $settings['feature_count'] ?? 3 }}">
                    <div class="glass rounded-2xl p-6">
                        <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-1.5">Judul Utama Seksi Keunggulan</label>
                        <input type="text" name="why_choose_title" value="{{ $settings['why_choose_title'] ?? 'Mengapa Memilih LPK-MI?' }}"
                            class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
                    </div>

                    <div id="features-container" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        @php
                            $featureCount = (int) ($settings['feature_count'] ?? 3);
                        @endphp
                        @for($i = 1; $i <= $featureCount; $i++)
                        <div class="glass rounded-2xl p-5 space-y-3 feature-card" data-index="{{ $i }}">
                            <div class="flex justify-between items-center">
                                <span class="text-[9px] font-black uppercase tracking-widest text-indigo-505 dark:text-indigo-400 font-heading">Fitur {{ $i }}</span>
                                @if($i > 3)
                                <button type="button" onclick="removeFeatureCard(this)" class="text-rose-600 dark:text-rose-400 hover:text-rose-500 text-xs font-bold uppercase tracking-wider">Hapus</button>
                                @endif
                            </div>
                            <div>
                                <label class="block text-[9px] font-bold text-slate-600 dark:text-slate-400 uppercase mb-1">Judul Fitur</label>
                                <input type="text" name="feature_{{ $i }}_title" value="{{ $settings['feature_' . $i . '_title'] ?? '' }}"
                                    class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-3 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
                            </div>
                            <div>
                                <label class="block text-[9px] font-bold text-slate-600 dark:text-slate-400 uppercase mb-1">Deskripsi</label>
                                <textarea name="feature_{{ $i }}_desc" rows="3"
                                    class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-3 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500 resize-none">{{ $settings['feature_' . $i . '_desc'] ?? '' }}</textarea>
                            </div>
                        </div>
                        @endfor
                    </div>
                    <div class="flex justify-between items-center pt-2">
                        <button type="button" id="add-feature-btn" class="bg-slate-105 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-900 dark:text-white font-bold text-xs uppercase tracking-wider px-4 py-2.5 rounded-lg transition-all border border-slate-300 dark:border-slate-700 shadow-md">
                            + Tambah Fitur
                        </button>
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs uppercase tracking-wider px-8 py-3 rounded-lg transition-all shadow-lg shadow-indigo-500/20">
                            Simpan Fitur & Keunggulan
                        </button>
                    </div>
                </form>
            </div>

            {{-- Panel: Identitas Situs --}}
            <div id="panel-identity" class="dashboard-panel hidden">
                <div class="mb-6">
                    <h2 class="text-xl font-black text-slate-900 dark:text-white font-heading">Identitas & Branding Situs</h2>
                    <p class="text-slate-600 dark:text-slate-400 text-sm mt-1">Ubah nama judul website (Site Title) dan upload logo resmi instansi.</p>
                </div>

                <form action="{{ route('superadmin.settings.update') }}" method="POST" enctype="multipart/form-data" class="glass rounded-2xl p-6 space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="space-y-5">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-1.5">Nama Singkat / Judul Situs (Site Title)</label>
                                <input type="text" name="site_title" value="{{ $settings['site_title'] ?? 'LPK-MI' }}" required
                                    class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500 transition-all">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-1.5">Logo Website (Site Logo)</label>
                            @if(!empty($settings['site_logo']))
                                <div class="mb-3">
                                    <span class="block text-[9px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Preview Logo Saat Ini:</span>
                                    <img src="{{ asset('storage/' . $settings['site_logo']) }}" class="h-10 w-auto object-contain rounded border border-slate-200 dark:border-slate-700 p-2 bg-slate-100 dark:bg-slate-900" alt="Site Logo">
                                </div>
                            @endif
                            <div class="border-2 border-dashed border-slate-300 dark:border-slate-700 rounded-xl p-6 text-center hover:border-indigo-500 transition-all">
                                <input type="file" name="site_logo" accept="image/*" class="hidden" id="site-logo-input"
                                    onchange="document.getElementById('site-logo-label').textContent = this.files[0]?.name || 'Pilih file...'">
                                <label for="site-logo-input" class="cursor-pointer">
                                    <div class="text-slate-600 dark:text-slate-400 text-sm">
                                        <span class="block text-2xl mb-2">📸</span>
                                        <span id="site-logo-label">Klik untuk upload Logo (JPG, PNG, SVG, WebP - max 1MB)</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end pt-2">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs uppercase tracking-wider px-8 py-3 rounded-lg transition-all shadow-lg shadow-indigo-500/20">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            {{-- Panel: Halaman Login --}}
            <div id="panel-login-branding" class="dashboard-panel hidden">
                <div class="mb-6">
                    <h2 class="text-xl font-black text-slate-900 dark:text-white font-heading">Pengaturan Halaman Login & Registrasi</h2>
                    <p class="text-slate-600 dark:text-slate-400 text-sm mt-1">Sesuaikan teks branding panel kiri, judul/deskripsi, dan gambar latar belakang (background) pada halaman login.</p>
                </div>

                <form action="{{ route('superadmin.settings.update') }}" method="POST" enctype="multipart/form-data" class="glass rounded-2xl p-6 space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="space-y-5">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-1.5">Branding Kiri: Baris Judul 1 (Kuning, Bold)</label>
                                <input type="text" name="login_left_title_1" value="{{ $settings['login_left_title_1'] ?? 'LEMBAGA SERTIFIKASI' }}" required
                                    class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500 transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-1.5">Branding Kiri: Baris Judul 2 (Kuning, Bold)</label>
                                <input type="text" name="login_left_title_2" value="{{ $settings['login_left_title_2'] ?? 'PROFESI' }}" required
                                    class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500 transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-1.5">Branding Kiri: Subtitle Kecil (Putih)</label>
                                <input type="text" name="login_left_sub" value="{{ $settings['login_left_sub'] ?? '(lsp) p3' }}" required
                                    class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500 transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-1.5">Branding Kiri: Judul Utama Besar (Putih)</label>
                                <textarea name="login_left_main" rows="3" required
                                    class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500 transition-all resize-none">{{ $settings['login_left_main'] ?? 'MANAJEMEN PENDIDIKAN ISLAM' }}</textarea>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-1.5">Branding Kiri: Label Kaki (Putih, Bold)</label>
                                <input type="text" name="login_left_footer_title" value="{{ $settings['login_left_footer_title'] ?? 'SKKNI' }}" required
                                    class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500 transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-1.5">Branding Kiri: Deskripsi Kaki (Putih)</label>
                                <textarea name="login_left_footer_desc" rows="3" required
                                    class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500 transition-all resize-none">{{ $settings['login_left_footer_desc'] ?? 'Standar Kompetensi Kerja Khusus Manajemen Pendidikan Islam' }}</textarea>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-1.5">Foto Latar Belakang Login (Login Background Image)</label>
                            @if(!empty($settings['login_bg_image']))
                                <img src="{{ asset('storage/' . $settings['login_bg_image']) }}" class="w-full h-40 object-cover rounded-xl mb-3 border border-slate-300 dark:border-slate-700" alt="Login Background">
                            @else
                                <div class="mb-3 p-3 bg-slate-100 dark:bg-slate-900 rounded-xl text-xs text-slate-500 border border-slate-200 dark:border-slate-800">
                                    Menggunakan latar belakang default (Foto Seminar Unsplash).
                                </div>
                            @endif
                            <div class="border-2 border-dashed border-slate-300 dark:border-slate-700 rounded-xl p-6 text-center hover:border-indigo-500 transition-all">
                                <input type="file" name="login_bg_image" accept="image/*" class="hidden" id="login-bg-input"
                                    onchange="document.getElementById('login-bg-label').textContent = this.files[0]?.name || 'Pilih file...'">
                                <label for="login-bg-input" class="cursor-pointer">
                                    <div class="text-slate-600 dark:text-slate-400 text-sm">
                                        <span class="block text-2xl mb-2">📸</span>
                                        <span id="login-bg-label">Klik untuk upload foto latar (JPG, PNG, WebP - max 2MB)</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end pt-2">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs uppercase tracking-wider px-8 py-3 rounded-lg transition-all shadow-lg shadow-indigo-500/20">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            {{-- Panel: Profil --}}
            <div id="panel-profile" class="dashboard-panel hidden">
                <div class="mb-6">
                    <h2 class="text-xl font-black text-slate-900 dark:text-white font-heading">Profil Superadmin</h2>
                    <p class="text-slate-600 dark:text-slate-400 text-sm mt-1">Ubah nama atau alamat email akun Superadmin.</p>
                </div>

                <div class="max-w-lg">
                    <form action="{{ route('superadmin.profile.update') }}" method="POST" class="glass rounded-2xl p-6 space-y-5">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-1.5">Username</label>
                            <input type="text" name="username" value="{{ auth()->user()->username }}" required
                                class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-1.5">Email</label>
                            <input type="email" name="email" value="{{ auth()->user()->email }}" required
                                class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-1.5">Kata Sandi Baru (Kosongkan jika tidak diubah)</label>
                            <input type="password" name="password" placeholder="Min 8 karakter"
                                class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-1.5">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi baru"
                                class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500 transition-all">
                        </div>
                        <div class="flex justify-end pt-2">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs uppercase tracking-wider px-6 py-2.5 rounded-lg transition-all">
                                Simpan Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Panel: Galeri --}}
            <div id="panel-gallery" class="dashboard-panel hidden">
                <div class="mb-6">
                    <h2 class="text-xl font-black text-slate-900 dark:text-white font-heading">Pengaturan Galeri</h2>
                    <p class="text-slate-600 dark:text-slate-400 text-sm mt-1">Edit judul, subjudul, dan 6 item galeri (kategori, judul, deskripsi, dan foto) yang tampil di halaman utama.</p>
                </div>

                <form action="{{ route('superadmin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    {{-- Header Galeri --}}
                    <div class="glass rounded-2xl p-6 space-y-4">
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider border-b border-slate-200 dark:border-slate-700 pb-3">Header Seksi Galeri</h3>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-1.5">Judul Galeri</label>
                            <input type="text" name="gallery_title" value="{{ $settings['gallery_title'] ?? 'Galeri & Dokumentasi Kegiatan' }}"
                                class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-1.5">Subjudul / Deskripsi Galeri</label>
                            <textarea name="gallery_subtitle" rows="2"
                                class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500 transition-all resize-none">{{ $settings['gallery_subtitle'] ?? 'Melihat lebih dekat lingkungan belajar, ujian sertifikasi, dan aktivitas pengembangan kompetensi profesional asesi di LPK-MI.' }}</textarea>
                        </div>
                    </div>

                    {{-- 6 Gallery Items --}}
                    @for($i = 1; $i <= 6; $i++)
                    <div class="glass rounded-2xl p-6 space-y-4">
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider border-b border-slate-200 dark:border-slate-700 pb-3">Item Galeri #{{ $i }}</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-1.5">Kategori</label>
                                <input type="text" name="gallery_item_{{ $i }}_category"
                                    value="{{ $settings['gallery_item_'.$i.'_category'] ?? '' }}"
                                    placeholder="Contoh: Pelatihan IT"
                                    class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500 transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-1.5">Judul Item</label>
                                <input type="text" name="gallery_item_{{ $i }}_title"
                                    value="{{ $settings['gallery_item_'.$i.'_title'] ?? '' }}"
                                    placeholder="Contoh: Kelas Praktik Pemrograman"
                                    class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500 transition-all">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-1.5">Deskripsi</label>
                            <textarea name="gallery_item_{{ $i }}_desc" rows="2"
                                placeholder="Deskripsi singkat gambar galeri..."
                                class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500 transition-all resize-none">{{ $settings['gallery_item_'.$i.'_desc'] ?? '' }}</textarea>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-1.5">Foto Galeri</label>
                            @if(!empty($settings['gallery_item_'.$i.'_image']))
                                <div class="mb-2 flex items-center gap-3">
                                    <img src="{{ asset('storage/' . $settings['gallery_item_'.$i.'_image']) }}"
                                        class="h-16 w-24 object-cover rounded border border-slate-300 dark:border-slate-700" alt="Foto #{{ $i }}">
                                    <span class="text-[10px] text-slate-500 dark:text-slate-400">Foto saat ini. Upload baru untuk mengganti.</span>
                                </div>
                            @endif
                            <div class="border-2 border-dashed border-slate-300 dark:border-slate-700 rounded-xl p-4 text-center hover:border-indigo-500 transition-all">
                                <input type="file" name="gallery_item_{{ $i }}_image" accept="image/*" class="hidden" id="gallery-img-{{ $i }}"
                                    onchange="document.getElementById('gallery-lbl-{{ $i }}').textContent = this.files[0]?.name || 'Pilih foto...'">
                                <label for="gallery-img-{{ $i }}" class="cursor-pointer">
                                    <span class="block text-slate-600 dark:text-slate-400 text-xs">📷 <span id="gallery-lbl-{{ $i }}">Klik untuk upload foto (JPG, PNG, WebP - max 2MB)</span></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    @endfor

                    <div class="flex justify-end">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs uppercase tracking-wider px-8 py-3 rounded-lg transition-all shadow-lg shadow-indigo-500/20">
                            Simpan Semua Perubahan Galeri
                        </button>
                    </div>
                </form>
            </div>

            {{-- Panel: Manajemen Akun --}}
            <div id="panel-users" class="dashboard-panel hidden">
                <div class="mb-6">
                    <h2 class="text-xl font-black text-slate-900 dark:text-white font-heading">Manajemen Akun Admin & Asesor</h2>
                    <p class="text-slate-600 dark:text-slate-400 text-sm mt-1">Buat akun baru untuk Admin (manajemen sistem) dan Asesor (pembuat soal). Akun Asesi dibuat oleh Admin.</p>
                </div>

                {{-- Form Buat Akun Baru --}}
                <div class="glass rounded-2xl p-6 mb-6">
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider border-b border-slate-200 dark:border-slate-700 pb-3 mb-5">Buat Akun Baru</h3>
                    <form action="{{ route('superadmin.user.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-1.5">Username</label>
                                <input type="text" name="username" required placeholder="Contoh: admin_baru"
                                    class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-600 focus:outline-none focus:border-indigo-500 transition-all">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-1.5">Email</label>
                                <input type="email" name="email" required placeholder="email@gmail.com"
                                    class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-600 focus:outline-none focus:border-indigo-500 transition-all">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-1.5">Role</label>
                                <select name="role" required
                                    class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500 transition-all">
                                    <option value="admin" class="bg-white dark:bg-slate-900 text-slate-900 dark:text-white">Admin</option>
                                    <option value="asesor" class="bg-white dark:bg-slate-900 text-slate-900 dark:text-white">Asesor</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-1.5">Password</label>
                                <div class="relative w-full">
                                    <input type="password" name="password" required placeholder="Min. 8 karakter"
                                        class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg pl-4 pr-11 py-2.5 text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-600 focus:outline-none focus:border-indigo-500 transition-all">
                                    <button type="button" onclick="togglePasswordVisibility(this)" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider mb-1.5">Konfirmasi Password</label>
                                <div class="relative w-full">
                                    <input type="password" name="password_confirmation" required placeholder="Ulangi password"
                                        class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg pl-4 pr-11 py-2.5 text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-600 focus:outline-none focus:border-indigo-500 transition-all">
                                    <button type="button" onclick="togglePasswordVisibility(this)" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end pt-2">
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs uppercase tracking-wider px-6 py-3 rounded-lg transition-all shadow-lg shadow-indigo-500/20">
                                + Buat Akun
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Daftar Admin --}}
                <div class="glass rounded-2xl p-6 mb-6">
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider border-b border-slate-200 dark:border-slate-700 pb-3 mb-4">Daftar Akun Admin <span class="text-indigo-600 dark:text-indigo-400">({{ $admins->count() }})</span></h3>
                    @if($admins->isEmpty())
                        <p class="text-slate-600 dark:text-slate-400 text-sm text-center py-4">Belum ada akun Admin.</p>
                    @else
                        <div class="space-y-2">
                            @foreach($admins as $admin)
                                <div class="flex items-center justify-between bg-slate-100/60 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3">
                                    <div>
                                        <div class="text-sm font-bold text-slate-900 dark:text-white">{{ $admin->name }}</div>
                                        <div class="text-[11px] text-slate-600 dark:text-slate-400">{{ $admin->email }}</div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="text-[9px] font-black text-blue-600 dark:text-blue-400 bg-blue-500/10 border border-blue-500/20 px-2.5 py-1 rounded-full uppercase tracking-wider">Admin</span>
                                        <form action="{{ route('superadmin.user.destroy', $admin->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus akun {{ addslashes($admin->name) }}?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-[10px] font-bold text-rose-600 dark:text-rose-400 hover:text-rose-500 bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/20 px-3 py-1.5 rounded-lg transition-all">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Daftar Asesor --}}
                <div class="glass rounded-2xl p-6">
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider border-b border-slate-200 dark:border-slate-700 pb-3 mb-4">Daftar Akun Asesor <span class="text-emerald-600 dark:text-emerald-400">({{ $asesors->count() }})</span></h3>
                    @if($asesors->isEmpty())
                        <p class="text-slate-600 dark:text-slate-400 text-sm text-center py-4">Belum ada akun Asesor.</p>
                    @else
                        <div class="space-y-2">
                            @foreach($asesors as $asesor)
                                <div class="flex items-center justify-between bg-slate-100/60 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-3">
                                    <div>
                                        <div class="text-sm font-bold text-slate-900 dark:text-white">{{ $asesor->name }}</div>
                                        <div class="text-[11px] text-slate-600 dark:text-slate-400">{{ $asesor->email }}</div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="text-[9px] font-black text-emerald-600 dark:text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 px-2.5 py-1 rounded-full uppercase tracking-wider">Asesor</span>
                                        <form action="{{ route('superadmin.user.destroy', $asesor->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus akun {{ addslashes($asesor->name) }}?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-[10px] font-bold text-rose-600 dark:text-rose-400 hover:text-rose-500 bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/20 px-3 py-1.5 rounded-lg transition-all">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- Duplicate panel-profile removed --}}

        </div>
    </div>

<script>
    const panels = ['panel-identity', 'panel-hero', 'panel-stats', 'panel-steps', 'panel-features', 'panel-gallery', 'panel-login-branding', 'panel-users', 'panel-profile'];
    const btnMap  = {
        'panel-identity': 'btn-identity',
        'panel-hero':     'btn-hero',
        'panel-stats':    'btn-stats',
        'panel-steps':    'btn-steps',
        'panel-features': 'btn-features',
        'panel-gallery':  'btn-gallery',
        'panel-login-branding': 'btn-login-branding',
        'panel-users':    'btn-users',
        'panel-profile':  'btn-profile'
    };

    function showPanel(id) {
        panels.forEach(p => {
            const el = document.getElementById(p);
            if (el) el.classList.add('hidden');
        });
        const activePanel = document.getElementById(id);
        if (activePanel) activePanel.classList.remove('hidden');

        document.querySelectorAll('.sidebar-btn').forEach(b => {
            b.className = b.className.replace('bg-slate-800 text-white', '').trim();
            b.classList.add('text-slate-400', 'hover:bg-slate-800', 'hover:text-white');
        });
        const btn = document.getElementById(btnMap[id]);
        if (btn) {
            btn.classList.remove('text-slate-400', 'hover:bg-slate-800', 'hover:text-white');
            btn.classList.add('bg-slate-800', 'text-white');
        }

        localStorage.setItem('sa_panel', id);
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Prioritize ?open= query param (from redirects after form submit)
        const urlParams = new URLSearchParams(window.location.search);
        const openPanel = urlParams.get('open') || localStorage.getItem('sa_panel') || 'panel-identity';
        showPanel(openPanel);

        // Remove ?open= from URL without reload
        if (urlParams.has('open')) {
            const cleanUrl = window.location.pathname;
            window.history.replaceState({}, '', cleanUrl);
        }

        // Sync theme icon
        updateSAThemeIcon();
    });

    function toggleSATheme() {
        const html = document.documentElement;
        if (html.classList.contains('dark')) {
            html.classList.remove('dark');
            localStorage.setItem('lpk_theme', 'light');
        } else {
            html.classList.add('dark');
            localStorage.setItem('lpk_theme', 'dark');
        }
        updateSAThemeIcon();
    }

    function updateSAThemeIcon() {
        const icon = document.getElementById('sa-theme-icon');
        if (!icon) return;
        const isDark = document.documentElement.classList.contains('dark');
        icon.textContent = isDark ? '🌙' : '☀️';
    }

    function toggleSidebar() {
        const sidebar = document.getElementById('sa-sidebar');
        const main    = document.getElementById('sa-main');
        const overlay = document.getElementById('sa-overlay');
        const isOpen  = !sidebar.classList.contains('-translate-x-full');
        const isMobile = window.innerWidth < 1024;

        if (isOpen) {
            // Collapse sidebar
            sidebar.classList.add('-translate-x-full');
            sidebar.classList.remove('translate-x-0');
            if (!isMobile) {
                main.classList.remove('lg:ml-64');
                main.classList.add('ml-0');
            }
            overlay.classList.add('hidden');
        } else {
            // Expand sidebar
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
            if (!isMobile) {
                main.classList.remove('ml-0');
                main.classList.add('lg:ml-64');
            } else {
                overlay.classList.remove('hidden');
            }
        }

        // Persist sidebar state (desktop only)
        if (!isMobile) {
            const isNowOpen = !sidebar.classList.contains('-translate-x-full');
            localStorage.setItem('sa_sidebar_open', isNowOpen ? '1' : '0');
        }
    }

    function toggleSaMenuGroup(groupId, btn) {
        const groupEl = document.getElementById(groupId);
        const arrow = btn.querySelector('.arrow-icon');
        
        if (groupEl.classList.contains('hidden')) {
            groupEl.classList.remove('hidden');
            if (arrow) arrow.classList.remove('-rotate-90');
        } else {
            groupEl.classList.add('hidden');
            if (arrow) arrow.classList.add('-rotate-90');
        }
        
        localStorage.setItem('sa_group_' + groupId, groupEl.classList.contains('hidden') ? 'collapsed' : 'open');
    }

    // Restore sidebar and menu group state on load
    document.addEventListener('DOMContentLoaded', () => {
        const isMobile = window.innerWidth < 1024;
        const savedOpen = localStorage.getItem('sa_sidebar_open');
        
        const sidebar = document.getElementById('sa-sidebar');
        const main    = document.getElementById('sa-main');
        
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
        const groups = ['group-navigasi-utama', 'group-manajemen-pengguna', 'group-pengaturan-akun'];
        groups.forEach(gId => {
            const savedState = localStorage.getItem('sa_group_' + gId);
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
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                </svg>
            `;
        } else {
            input.type = 'password';
            btn.innerHTML = `
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            `;
        }
    }

    // Dynamic Stats Management
    document.getElementById('add-stat-btn')?.addEventListener('click', () => {
        const container = document.getElementById('stats-container');
        const inputCount = document.getElementById('stat_count_input');
        let count = parseInt(inputCount.value);
        count++;
        inputCount.value = count;

        const card = document.createElement('div');
        card.className = 'glass rounded-2xl p-5 space-y-4 stat-card';
        card.setAttribute('data-index', count);
        card.innerHTML = `
            <div class="flex justify-between items-center">
                <span class="text-[9px] font-black uppercase tracking-widest text-indigo-600 dark:text-indigo-400 font-heading">Statistik ${count}</span>
                <button type="button" onclick="removeStatCard(this)" class="text-rose-600 dark:text-rose-400 hover:text-rose-500 text-xs font-bold uppercase tracking-wider">Hapus</button>
            </div>
            <div>
                <label class="block text-[9px] font-bold text-slate-600 dark:text-slate-400 uppercase mb-1">Nilai (Value)</label>
                <input type="text" name="stat_${count}_val" placeholder="Contoh: 100+"
                    class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-3 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-[9px] font-bold text-slate-600 dark:text-slate-400 uppercase mb-1">Label</label>
                <input type="text" name="stat_${count}_lbl" placeholder="Contoh: Keunggulan"
                    class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-3 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
            </div>
        `;
        container.appendChild(card);
    });

    window.removeStatCard = function(btn) {
        const card = btn.closest('.stat-card');
        card.remove();
        const container = document.getElementById('stats-container');
        const cards = container.querySelectorAll('.stat-card');
        document.getElementById('stat_count_input').value = cards.length;
        cards.forEach((c, idx) => {
            const newIdx = idx + 1;
            c.setAttribute('data-index', newIdx);
            c.querySelector('.font-heading').textContent = `Statistik ${newIdx}`;
            c.querySelectorAll('input')[0].name = `stat_${newIdx}_val`;
            c.querySelectorAll('input')[1].name = `stat_${newIdx}_lbl`;
            // Manage delete button
            const delBtn = c.querySelector('button');
            if (newIdx <= 3) {
                if (delBtn) delBtn.remove();
            } else {
                if (!delBtn) {
                    const header = c.querySelector('.flex');
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'text-rose-600 dark:text-rose-400 hover:text-rose-500 text-xs font-bold uppercase tracking-wider';
                    btn.textContent = 'Hapus';
                    btn.onclick = function() { removeStatCard(this); };
                    header.appendChild(btn);
                }
            }
        });
    }

    // Dynamic Steps Management
    document.getElementById('add-step-btn')?.addEventListener('click', () => {
        const container = document.getElementById('steps-container');
        const inputCount = document.getElementById('step_count_input');
        let count = parseInt(inputCount.value);
        count++;
        inputCount.value = count;

        const card = document.createElement('div');
        card.className = 'space-y-2 step-card';
        card.setAttribute('data-index', count);
        card.innerHTML = `
            <div class="flex justify-between items-center mb-1.5">
                <label class="block text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Langkah ${count}</label>
                <button type="button" onclick="removeStepCard(this)" class="text-rose-600 dark:text-rose-400 hover:text-rose-500 text-[10px] font-bold uppercase tracking-wider">Hapus</button>
            </div>
            <input type="text" name="step_${count}_title" placeholder="Contoh: Langkah ${count}"
                class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-4 py-2.5 text-sm text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
        `;
        container.appendChild(card);
    });

    window.removeStepCard = function(btn) {
        const card = btn.closest('.step-card');
        card.remove();
        const container = document.getElementById('steps-container');
        const cards = container.querySelectorAll('.step-card');
        document.getElementById('step_count_input').value = cards.length;
        cards.forEach((c, idx) => {
            const newIdx = idx + 1;
            c.setAttribute('data-index', newIdx);
            c.querySelector('label').textContent = `Langkah ${newIdx}`;
            c.querySelector('input').name = `step_${newIdx}_title`;
            const delBtn = c.querySelector('button');
            if (newIdx <= 3) {
                if (delBtn) delBtn.remove();
            } else {
                if (!delBtn) {
                    const header = c.querySelector('.flex');
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'text-rose-600 dark:text-rose-400 hover:text-rose-500 text-[10px] font-bold uppercase tracking-wider';
                    btn.textContent = 'Hapus';
                    btn.onclick = function() { removeStepCard(this); };
                    header.appendChild(btn);
                }
            }
        });
    }

    // Dynamic Features Management
    document.getElementById('add-feature-btn')?.addEventListener('click', () => {
        const container = document.getElementById('features-container');
        const inputCount = document.getElementById('feature_count_input');
        let count = parseInt(inputCount.value);
        count++;
        inputCount.value = count;

        const card = document.createElement('div');
        card.className = 'glass rounded-2xl p-5 space-y-3 feature-card';
        card.setAttribute('data-index', count);
        card.innerHTML = `
            <div class="flex justify-between items-center">
                <span class="text-[9px] font-black uppercase tracking-widest text-indigo-600 dark:text-indigo-400 font-heading">Fitur ${count}</span>
                <button type="button" onclick="removeFeatureCard(this)" class="text-rose-600 dark:text-rose-400 hover:text-rose-500 text-xs font-bold uppercase tracking-wider">Hapus</button>
            </div>
            <div>
                <label class="block text-[9px] font-bold text-slate-600 dark:text-slate-400 uppercase mb-1">Judul Fitur</label>
                <input type="text" name="feature_${count}_title" placeholder="Contoh: Fitur ${count}"
                    class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-3 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500">
            </div>
            <div>
                <label class="block text-[9px] font-bold text-slate-600 dark:text-slate-400 uppercase mb-1">Deskripsi</label>
                <textarea name="feature_${count}_desc" rows="3" placeholder="Deskripsi singkat..."
                    class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-300 dark:border-slate-700 rounded-lg px-3 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-indigo-500 resize-none"></textarea>
            </div>
        `;
        container.appendChild(card);
    });

    window.removeFeatureCard = function(btn) {
        const card = btn.closest('.feature-card');
        card.remove();
        const container = document.getElementById('features-container');
        const cards = container.querySelectorAll('.feature-card');
        document.getElementById('feature_count_input').value = cards.length;
        cards.forEach((c, idx) => {
            const newIdx = idx + 1;
            c.setAttribute('data-index', newIdx);
            c.querySelector('.font-heading').textContent = `Fitur ${newIdx}`;
            c.querySelectorAll('input')[0].name = `feature_${newIdx}_title`;
            c.querySelector('textarea').name = `feature_${newIdx}_desc`;
            const delBtn = c.querySelector('button');
            if (newIdx <= 3) {
                if (delBtn) delBtn.remove();
            } else {
                if (!delBtn) {
                    const header = c.querySelector('.flex');
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'text-rose-600 dark:text-rose-400 hover:text-rose-500 text-xs font-bold uppercase tracking-wider';
                    btn.textContent = 'Hapus';
                    btn.onclick = function() { removeFeatureCard(this); };
                    header.appendChild(btn);
                }
            }
        });
    }
</script>
</body>
</html>
