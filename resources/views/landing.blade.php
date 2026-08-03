@extends('layouts.app')

@section('content')
<!-- Alert Messages -->
@if(session('success'))
<div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 rounded-xl text-sm flex items-center gap-3 animate-fade-in shadow-sm">
    <svg class="h-5 w-5 text-emerald-550 dark:text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <span>{{ session('success') }}</span>
</div>
@endif

@if(session('error'))
<div class="mb-6 p-4 bg-rose-500/10 border border-rose-500/20 text-rose-600 dark:text-rose-400 rounded-xl text-sm flex items-center gap-3 animate-fade-in shadow-sm">
    <svg class="h-5 w-5 text-rose-550 dark:text-rose-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <span>{{ session('error') }}</span>
</div>
@endif

<!-- ========================================================================= -->
<!-- SECTION 1: BERANDA -->
<!-- ========================================================================= -->
    <section id="sec-beranda" class="tab-content block animate-fade-in relative w-full pt-12 pb-20 bg-white dark:bg-slate-900 border-b border-slate-200/60 dark:border-slate-800/40">
    <div class="max-w-7xl mx-auto px-6">
        <!-- Ambient Background Glow Orb -->
        <div class="absolute -top-20 -left-20 w-80 h-80 rounded-full bg-blue-600/10 dark:bg-blue-500/25 blur-3xl pointer-events-none animate-soft-pulse"></div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center py-6 relative z-10">
            <div class="lg:col-span-7 flex flex-col items-start">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight mb-6 tracking-tight text-slate-900 dark:text-white font-heading">
                    <span class="bg-gradient-to-r from-blue-800 via-indigo-650 to-sky-600 dark:from-blue-400 dark:via-indigo-400 dark:to-sky-400 bg-clip-text text-transparent drop-shadow-[0_2px_15px_rgba(59,130,246,0.18)] animate-gradient-flow">
                        {!! e($heroTitle) !!}
                    </span>
                </h1>
                <p class="text-slate-600 dark:text-slate-400 text-base sm:text-lg mb-8 max-w-xl leading-relaxed">
                    {{ $heroSubtitle }}
                </p>
                <div class="flex flex-wrap gap-4">
                    <button class="bg-gradient-to-r from-blue-700 to-sky-600 text-white font-bold py-3.5 px-7 rounded-lg shadow-lg shadow-blue-700/20 hover:brightness-110 transition-all duration-300 flex items-center gap-2 text-xs uppercase tracking-wider" onclick="navigateToSection('sec-program-manajemen', 'program')">
                        Jelajahi Program
                    </button>
                    <button class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-750 hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-800 dark:text-slate-200 font-bold py-3.5 px-7 rounded-lg text-xs uppercase tracking-wider transition-all duration-300 flex items-center gap-2 shadow-sm" onclick="navigateToSection('sec-pendaftaran-formulir', 'pendaftaran')">
                        Daftar Online
                    </button>
                </div>
            </div>

            <div class="lg:col-span-5 flex flex-col gap-6 relative">
                @if($heroImage)
                <div class="rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-md h-72 relative">
                    <img src="{{ asset('storage/' . $heroImage) }}" alt="Hero Image" class="w-full h-full object-cover">
                </div>
                @else
                <!-- Stats Card -->
                <div class="glass-card rounded-2xl p-6 flex justify-around items-center border border-slate-200 dark:border-slate-800 flex-wrap gap-4 sm:gap-0">
                    @foreach($stats as $index => $stat)
                    @if($index > 0)
                    <div class="hidden sm:block w-px h-10 bg-slate-200 dark:bg-white/5"></div>
                    @endif
                    <div class="text-center flex-1 min-w-[80px]">
                        <span class="block text-3xl font-black bg-gradient-to-r from-blue-700 to-sky-600 dark:from-blue-400 dark:to-sky-300 bg-clip-text text-transparent font-heading">{{ $stat['val'] }}</span>
                        <span class="text-[10px] text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider mt-1 block">{{ $stat['lbl'] }}</span>
                    </div>
                    @endforeach
                </div>

                <!-- Flow Preview -->
                <div class="bg-white/80 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-800/80 rounded-2xl p-5 flex justify-between items-center gap-2 shadow-sm flex-wrap sm:flex-nowrap">
                    @foreach($steps as $index => $step)
                    @if($index > 0)
                    <div class="text-slate-400 dark:text-slate-600 text-sm font-bold">→</div>
                    @endif
                    <div class="flex flex-col items-center gap-2 text-center flex-1 min-w-[70px]">
                        <div class="w-9 h-9 rounded-full bg-blue-600/10 text-blue-700 dark:text-blue-400 border border-blue-600/25 flex items-center justify-center text-xs font-bold shadow-md shadow-blue-500/5">
                            {{ sprintf("%02d", $index + 1) }}
                        </div>
                        <span class="text-[9px] font-black text-blue-700 dark:text-blue-400 uppercase tracking-wider">{{ $step['title'] }}</span>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        <!-- Features Grid -->
        <div class="mt-20">
            <h2 class="text-2xl sm:text-3xl font-black text-center mb-12 font-heading tracking-tight text-slate-900 dark:text-white">{{ $whyChooseTitle }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($features as $index => $feature)
                <div class="glass-card rounded-2xl p-8 flex flex-col items-start gap-4 border border-slate-200 dark:border-slate-800">
                    <div class="w-12 h-12 rounded-xl bg-blue-600/10 text-blue-700 dark:text-blue-400 border border-blue-600/20 flex items-center justify-center text-sm font-black shadow-md">
                        {{ sprintf("%02d", $index + 1) }}
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mt-1">{{ $feature['title'] }}</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">
                        {{ $feature['desc'] }}
                    </p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- ========================================================================= -->
<!-- SECTION 2: TENTANG KAMI -->
<!-- ========================================================================= --<section id="sec-tentang" class="tab-content py-20 bg-slate-50 dark:bg-slate-950/60 border-b border-slate-200/60 dark:border-slate-800/40 animate-fade-in hidden">
    <div class="max-w-7xl mx-auto px-6">
        <div class="max-w-3xl mx-auto text-center mb-16">
            <span class="text-[10px] font-black text-blue-700 dark:text-blue-400 uppercase tracking-widest bg-blue-500/10 px-3.5 py-1 rounded-full border border-blue-550/15">Profil Institusi</span>
            <h2 class="text-3xl sm:text-4xl font-black mt-4 mb-4 font-heading text-slate-900 dark:text-white tracking-tight">LPK Manajemen Pendidikan Islam</h2>
            <p class="text-slate-600 dark:text-slate-400 text-base leading-relaxed">
                Membangun keterampilan kepemimpinan dan administrasi lembaga pendidikan Islam yang profesional.
            </p>
        </div>

        <!-- Sub-section: Profil LPK -->
        <div id="sec-tentang-profil" class="mb-20 scroll-mt-28">
            <div class="glass-card rounded-2xl p-8 border border-slate-200 dark:border-slate-800 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-7 space-y-4 text-left">
                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white">Tentang Lembaga Kami</h3>
                    <p class="text-slate-600 dark:text-slate-405 text-sm leading-relaxed">
                        LPK Manajemen Pendidikan Islam (LPK MPI) didirikan untuk menjawab tantangan global akan pentingnya standarisasi keahlian di lingkungan madrasah, sekolah Islam terpadu, pondok pesantren, dan yayasan keagamaan. Sebagai Lembaga Pelatihan Kerja resmi, kami berfokus melatih serta membekali keterampilan kerja para pimpinan yayasan, pengelola keuangan pesantren, kepala sekolah, dan staf administrasi.
                    </p>
                    <p class="text-slate-605 dark:text-slate-405 text-sm leading-relaxed">
                        Dengan kurikulum pelatihan yang terstruktur and dukungan jaringan instruktur yang ahli, kami memastikan setiap peserta didik memiliki bekal keahlian kerja yang unggul dan berdaya saing.
                    </p>
                </div>
                <div class="lg:col-span-5 bg-gradient-to-br from-blue-700 to-indigo-900 rounded-xl p-8 text-white text-center shadow-md relative overflow-hidden h-64 flex flex-col justify-center items-center">
                    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
                    <span class="text-4xl font-extrabold font-heading mb-2">LPK MPI</span>
                    <p class="text-xs text-blue-200 leading-relaxed max-w-xs font-semibold">Lembaga Pelatihan Kerja (LPK) Resmi Terdaftar & Terakreditasi</p>
                </div>
            </div>
        </div>

        <!-- Sub-section: Visi & Misi -->
        <div id="sec-tentang-visimisi" class="mb-20 scroll-mt-28">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 text-left">
                <div class="glass-card rounded-2xl p-8 border border-slate-200 dark:border-slate-800">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2.5">
                        <span class="w-1.5 h-6 bg-blue-700 rounded-full"></span>
                        Visi &amp; Tujuan Utama
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <span class="text-[9px] font-black text-blue-700 dark:text-blue-400 uppercase tracking-widest block mb-1">Visi Strategis</span>
                            <p class="text-slate-700 dark:text-slate-300 text-sm leading-relaxed font-semibold">
                                "Menjadi lembaga sertifikasi profesi terpercaya dan unggul dalam menciptakan manajemen pendidikan Islam yang kompeten dan profesional dalam menghadapi tantangan global."
                            </p>
                        </div>
                        <div class="h-px bg-slate-200 dark:bg-white/5 my-4"></div>
                        <div>
                            <span class="text-[9px] font-black text-blue-700 dark:text-blue-400 uppercase tracking-widest block mb-1">Tujuan Lembaga</span>
                            <p class="text-slate-600 dark:text-slate-400 text-xs leading-relaxed">
                                Mewujudkan standar tata kelola madrasah dan pesantren yang akuntabel, meningkatkan kualitas sumber daya manusia (SDM) pendidik dan tenaga kependidikan Islam, serta menjamin kompetensi kerja peserta didik melalui program pelatihan yang terstruktur.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="glass-card rounded-2xl p-8 border border-slate-200 dark:border-slate-800">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-6 flex items-center gap-2.5">
                        <span class="w-1.5 h-6 bg-emerald-600 rounded-full"></span>
                        Misi Utama Lembaga
                    </h3>
                    <ul class="space-y-3.5 text-slate-600 dark:text-slate-400 text-xs">
                        <li class="flex gap-2">
                            <span class="text-emerald-600 dark:text-emerald-400 font-bold shrink-0">•</span>
                            <span>Menyelenggarakan program pelatihan kerja manajemen pendidikan Islam yang berkualitas.</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="text-emerald-600 dark:text-emerald-400 font-bold shrink-0">•</span>
                            <span>Menyelenggarakan evaluasi pelatihan secara independen, objektif, jujur, transparan, dan profesional.</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="text-emerald-600 dark:text-emerald-400 font-bold shrink-0">•</span>
                            <span>Memformulasikan program pelatihan baru sesuai dengan tren dan kebutuhan operasional sekolah Islam terkini.</span>
                        </li>
                        <li class="flex gap-2">
                            <span class="text-emerald-600 dark:text-emerald-400 font-bold shrink-0">•</span>
                            <span>Menjalin kemitraan erat dengan lembaga pendidikan, organisasi kemasyarakatan, dunia usaha, dan regulator ketenagakerjaan.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Sub-section: Legalitas -->
        <div id="sec-tentang-legalitas" class="mb-20 scroll-mt-28">
            <div class="glass-card rounded-2xl p-8 border border-slate-200 dark:border-slate-800 text-left">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-4">Legalitas Hukum &amp; Perizinan</h3>
                <p class="text-slate-600 dark:text-slate-400 text-xs mb-6">
                    Lembaga Pelatihan Kerja (LPK) MPI beroperasi secara sah berdasarkan keputusan instansi terkait dan regulasi ketenagakerjaan berikut:
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-2.5 border-b border-slate-100 dark:border-white/5 text-xs">
                            <span class="text-slate-400 font-semibold">SK Kemenkumham RI</span>
                            <span class="font-mono text-slate-800 dark:text-slate-200 font-bold">AHU-0012345.AH.01.04</span>
                        </div>
                        <div class="flex justify-between items-center py-2.5 border-b border-slate-100 dark:border-white/5 text-xs">
                            <span class="text-slate-400 font-semibold">NIB (Nomor Induk Berusaha)</span>
                            <span class="font-mono text-slate-800 dark:text-slate-200 font-bold">9120304958372</span>
                        </div>
                        <div class="flex justify-between items-center py-2.5 border-b border-slate-100 dark:border-white/5 text-xs">
                            <span class="text-slate-400 font-semibold">Izin Operasional LPK</span>
                            <span class="font-mono text-slate-800 dark:text-slate-200 font-bold">No. LPK-1294-ID</span>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-2.5 border-b border-slate-100 dark:border-white/5 text-xs">
                            <span class="text-slate-400 font-semibold">Status Akreditasi</span>
                            <span class="text-emerald-700 dark:text-emerald-455 font-bold bg-emerald-500/10 px-2 py-0.5 rounded text-[10px]">TERAKREDITASI A</span>
                        </div>
                        <div class="flex justify-between items-center py-2.5 border-b border-slate-100 dark:border-white/5 text-xs">
                            <span class="text-slate-400 font-semibold">Mitra Regulator Utama</span>
                            <span class="text-slate-800 dark:text-slate-200 font-semibold">Kementerian Agama &amp; Kemnaker</span>
                        </div>
                        <div class="flex justify-between items-center py-2.5 border-b border-slate-100 dark:border-white/5 text-xs">
                            <span class="text-slate-400 font-semibold">Izin Wilayah Kerja</span>
                            <span class="text-slate-800 dark:text-slate-200 font-semibold">Seluruh Wilayah Indonesia</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sub-section: Struktur Organisasi -->
        <div id="sec-tentang-organisasi" class="scroll-mt-28">
            <div class="glass-card rounded-2xl p-8 border border-slate-200 dark:border-slate-800 text-center">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-8">Struktur Organisasi LPK MPI</h3>

                @if(!empty($settings['org_image']))
                    <div class="mb-8 max-w-xl mx-auto border border-slate-200 dark:border-slate-800 p-2 bg-white dark:bg-slate-900 rounded-2xl">
                        <img src="{{ asset('storage/' . $settings['org_image']) }}" class="w-full h-auto rounded-xl" alt="Bagan Struktur Organisasi">
                    </div>
                @endif

                <!-- Tree Organization Structure Map -->
                <div class="flex flex-col gap-6 max-w-2xl mx-auto text-xs font-semibold text-slate-700 dark:text-slate-355 font-sans">
                    <!-- Level 1 -->
                    <div class="flex justify-center">
                        <div class="bg-slate-100 dark:bg-slate-850 border border-slate-250 dark:border-slate-800 rounded-xl p-4 w-60 shadow-sm">
                            <span class="text-[9px] font-black text-blue-700 dark:text-blue-400 uppercase tracking-widest block mb-1">Ketua Dewan Pengarah</span>
                            <strong class="text-slate-900 dark:text-white font-black">{{ $settings['org_director_dewan'] ?? 'Prof. Dr. H. Badrudin, M.Ag.' }}</strong>
                        </div>
                    </div>

                    <!-- Line -->
                    <div class="w-px h-6 bg-slate-300 dark:bg-slate-800 mx-auto"></div>

                    <!-- Level 2 -->
                    <div class="flex justify-center">
                        <div class="bg-blue-600/5 dark:bg-blue-500/10 border border-blue-600/20 rounded-xl p-4 w-64 shadow-md">
                            <span class="text-[9px] font-black text-blue-700 dark:text-blue-400 uppercase tracking-widest block mb-1">Direktur Utama LPK</span>
                            <strong class="text-slate-900 dark:text-white font-black">{{ $settings['org_director_lpk'] ?? 'Dr. H. Ahmad Fauzi, M.T.' }}</strong>
                        </div>
                    </div>

                    <!-- Line -->
                    <div class="w-px h-6 bg-slate-300 dark:bg-slate-800 mx-auto"></div>

                    <!-- Level 3 -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-4 text-center">
                            <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest block mb-1">Manajer Pelatihan</span>
                            <strong class="text-slate-850 dark:text-slate-200">{{ $settings['org_manager_pelatihan'] ?? 'Chyril Futuhana Ahmad, M.Pd.' }}</strong>
                        </div>
                        <div class="bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-4 text-center">
                            <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest block mb-1">Komite Program</span>
                            <strong class="text-slate-850 dark:text-slate-200">{{ $settings['org_komite_program'] ?? 'Dr. Atep Suherman, M.Pd.' }}</strong>
                        </div>
                        <div class="bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-4 text-center">
                            <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest block mb-1">Manajer Penjaminan Mutu</span>
                            <strong class="text-slate-850 dark:text-slate-200">{{ $settings['org_manager_mutu'] ?? 'Dr. Hj. Atiyah Suharti, M.Pd.' }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- ========================================================================= -->
    <!-- SECTION 3: PROGRAM PELATIHAN -->
    <!-- ========================================================================= -->
    <section id="sec-program" class="tab-content py-20 bg-white dark:bg-slate-900 border-b border-slate-200/60 dark:border-slate-800/40 animate-fade-in hidden">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <span class="text-[10px] font-black text-blue-700 dark:text-blue-400 uppercase tracking-widest bg-blue-500/10 px-3.5 py-1 rounded-full border border-blue-550/15">Program Unggulan</span>
            <h2 class="text-3xl font-black mt-4 mb-4 font-heading text-slate-900 dark:text-white tracking-tight">Katalog Program Pelatihan Kerja</h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Pelatihan intensif terstruktur yang dirancang untuk membekali keterampilan dunia kerja.</p>
        </div>

        <div class="grid grid-cols-1 gap-12 max-w-5xl mx-auto text-left">
            <!-- Program 1: Manajemen Yayasan/Pesantren -->
            <div id="sec-program-manajemen" class="glass-card rounded-2xl p-8 border border-slate-200 dark:border-slate-800 scroll-mt-28">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-6 border-b border-slate-100 dark:border-white/5 pb-4">
                    <div>
                        <span class="text-xs font-bold uppercase text-blue-700 dark:text-blue-400 bg-blue-500/10 px-2.5 py-1 rounded-md">Program Pelatihan Pimpinan</span>
                        <h3 class="text-2xl font-bold text-slate-900 dark:text-white mt-2">{{ $settings['prog_manajemen_title'] ?? 'Manajemen Yayasan & Pesantren' }}</h3>
                    </div>
                    <div class="text-right">
                        <span class="text-xs text-slate-400 font-semibold block">Durasi: {{ $settings['prog_manajemen_durasi'] ?? '32 JP' }}</span>
                        <span class="text-xl font-black text-blue-700 dark:text-blue-450 block mt-1">{{ $settings['prog_manajemen_harga'] ?? 'Rp 1.500.000' }}</span>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-xs sm:text-sm">
                    <div class="space-y-4">
                        <div>
                            <strong class="text-slate-900 dark:text-white block mb-1">Deskripsi Program:</strong>
                            <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                                {{ $settings['prog_manajemen_desc'] ?? 'Pelatihan ini dirancang untuk membekali ketua yayasan dan pimpinan pondok pesantren dengan kompetensi tata kelola aset (wakaf), manajemen kurikulum kepesantrenan, dan sistem tata pamong keuangan syariah yang akuntabel.' }}
                            </p>
                        </div>
                        <div>
                            <strong class="text-slate-900 dark:text-white block mb-1">Materi Silabus Utama:</strong>
                            <ul class="space-y-1 text-slate-650 dark:text-slate-400 pl-4 list-disc">
                                @php
                                    $silabusManajemen = array_filter(array_map('trim', explode("\n", $settings['prog_manajemen_silabus'] ?? "Regulasi Wakaf & Pengelolaan Aset Yayasan\nManuangan Syariah Pesantren\nPenyusunan Rencana Strategis (Renstra) Lembaga")));
                                @endphp
                                @foreach($silabusManajemen as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <strong class="text-emerald-700 dark:text-emerald-450 block mb-1">Prospek Karir &amp; Output Kompetensi:</strong>
                            <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                                {{ $settings['prog_manajemen_prospek'] ?? 'Menjadi Pimpinan Yayasan/Pesantren yang memiliki bekal kompetensi resmi Pimpinan Unit LPK, Auditor Internal Lembaga Keagamaan, atau Konsultan Tata Pamong Madrasah.' }}
                            </p>
                        </div>
                        <div class="pt-4">
                            <button class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-3 px-6 rounded-lg text-xs uppercase tracking-wider transition-all" onclick="selectProgramAndRegister('ginou_prog')">
                                Daftar Kelas Manajemen Yayasan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Program 2: Administrasi Sekolah Islam -->
            <div id="sec-program-administrasi" class="glass-card rounded-2xl p-8 border border-slate-200 dark:border-slate-800 scroll-mt-28">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-6 border-b border-slate-100 dark:border-white/5 pb-4">
                    <div>
                        <span class="text-xs font-bold uppercase text-sky-700 dark:text-sky-400 bg-sky-500/10 px-2.5 py-1 rounded-md">Program Pelatihan Administrasi</span>
                        <h3 class="text-2xl font-bold text-slate-900 dark:text-white mt-2">{{ $settings['prog_administrasi_title'] ?? 'Administrasi & Tata Usaha Sekolah Islam' }}</h3>
                    </div>
                    <div class="text-right">
                        <span class="text-xs text-slate-400 font-semibold block">Durasi: {{ $settings['prog_administrasi_durasi'] ?? '40 JP' }}</span>
                        <span class="text-xl font-black text-blue-700 dark:text-blue-450 block mt-1">{{ $settings['prog_administrasi_harga'] ?? 'Rp 1.250.000' }}</span>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-xs sm:text-sm">
                    <div class="space-y-4">
                        <div>
                            <strong class="text-slate-900 dark:text-white block mb-1">Deskripsi Program:</strong>
                            <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                                {{ $settings['prog_administrasi_desc'] ?? 'Pelatihan khusus bagi tenaga kependidikan (tata usaha) di sekolah Islam terpadu atau madrasah. Fokus pada pengelolaan persuratan digital, penginputan data Dapodik/EMIS, dan manajemen sarana prasarana.' }}
                            </p>
                        </div>
                        <div>
                            <strong class="text-slate-900 dark:text-white block mb-1">Materi Silabus Utama:</strong>
                            <ul class="space-y-1 text-slate-650 dark:text-slate-400 pl-4 list-disc">
                                @php
                                    $silabusAdministrasi = array_filter(array_map('trim', explode("\n", $settings['prog_administrasi_silabus'] ?? "Manajemen Kearsipan Digital Sekolah\nSistem Informasi EMIS & Dapodik\nEtika Layanan Prima (Excellent Service) Pendidikan")));
                                @endphp
                                @foreach($silabusAdministrasi as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <strong class="text-emerald-700 dark:text-emerald-455 block mb-1">Prospek Karir &amp; Output Kompetensi:</strong>
                            <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                                {{ $settings['prog_administrasi_prospek'] ?? 'Lulusan kompeten sebagai Kepala Tata Usaha Madrasah, Staf Admin Sekolah Dasar/Menengah Islam, atau Pengelola Database Pendidikan.' }}
                            </p>
                        </div>
                        <div class="pt-4">
                            <button class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-3 px-6 rounded-lg text-xs uppercase tracking-wider transition-all" onclick="selectProgramAndRegister('ssw_prog')">
                                Daftar Kelas Administrasi
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Program 3: Kepemimpinan Kepala Sekolah -->
            <div id="sec-program-kepemimpinan" class="glass-card rounded-2xl p-8 border border-slate-200 dark:border-slate-800 scroll-mt-28">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-6 border-b border-slate-100 dark:border-white/5 pb-4">
                    <div>
                        <span class="text-xs font-bold uppercase text-purple-750 dark:text-purple-400 bg-purple-500/10 px-2.5 py-1 rounded-md">Program Pelatihan Kepemimpinan</span>
                        <h3 class="text-2xl font-bold text-slate-900 dark:text-white mt-2">{{ $settings['prog_kepemimpinan_title'] ?? 'Kepemimpinan Kepala Sekolah & Madrasah' }}</h3>
                    </div>
                    <div class="text-right">
                        <span class="text-xs text-slate-400 font-semibold block">Durasi: {{ $settings['prog_kepemimpinan_durasi'] ?? '48 JP' }}</span>
                        <span class="text-xl font-black text-blue-700 dark:text-blue-455 block mt-1">{{ $settings['prog_kepemimpinan_harga'] ?? 'Rp 1.800.000' }}</span>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-xs sm:text-sm">
                    <div class="space-y-4">
                        <div>
                            <strong class="text-slate-900 dark:text-white block mb-1">Deskripsi Program:</strong>
                            <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                                {{ $settings['prog_kepemimpinan_desc'] ?? 'Bimbingan kompetensi kepemimpinan transformasional untuk kepala madrasah dan sekolah Islam. Menyangkut supervisi akademik guru, manajemen mutu lulusan, dan kepemimpinan kewirausahaan madrasah.' }}
                            </p>
                        </div>
                        <div>
                            <strong class="text-slate-900 dark:text-white block mb-1">Materi Silabus Utama:</strong>
                            <ul class="space-y-1 text-slate-650 dark:text-slate-400 pl-4 list-disc">
                                @php
                                    $silabusKepemimpinan = array_filter(array_map('trim', explode("\n", $settings['prog_kepemimpinan_silabus'] ?? "Supervisi Akademik & Penilaian Kinerja Guru (PKG)\nKepemimpinan Kewirausahaan Madrasah Mandiri\nPengembangan Mutu Lulusan Berkarakter Islami")));
                                @endphp
                                @foreach($silabusKepemimpinan as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <strong class="text-emerald-700 dark:text-emerald-455 block mb-1">Prospek Karir &amp; Output Kompetensi:</strong>
                            <p class="text-slate-600 dark:text-slate-400 leading-relaxed">
                                {{ $settings['prog_kepemimpinan_prospek'] ?? 'Kepala Madrasah Ibtidaiyah/Tsanawiyah/Aliyah Kompeten dengan Sertifikat Kelulusan LPK, Pengawas Sekolah Yayasan, atau Konsultan Akreditasi Sekolah.' }}
                            </p>
                        </div>
                        <div class="pt-4">
                            <button class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-3 px-6 rounded-lg text-xs uppercase tracking-wider transition-all" onclick="selectProgramAndRegister('kaigo_prog')">
                                Daftar Kelas Kepemimpinan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Program 4: Jadwal Diklat -->
            <div id="sec-program-jadwal" class="glass-card rounded-2xl p-8 border border-slate-200 dark:border-slate-800 scroll-mt-28">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-4">Jadwal Diklat &amp; Pelatihan Terdekat</h3>
                <p class="text-slate-600 dark:text-slate-400 text-xs mb-6">
                    Berikut rincian jadwal pelaksanaan pelatihan, batas pendaftaran, dan metode belajar yang tersedia:
                </p>
                <div class="premium-table-container border-none shadow-none overflow-x-auto w-full">
                    <table class="premium-table text-xs">
                        <thead>
                            <tr>
                                <th>Nama Pelatihan</th>
                                <th>Batas Pendaftaran</th>
                                <th>Waktu Pelaksanaan</th>
                                <th>Metode Pelaksanaan</th>
                                <th>Status Quota</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                            <tr>
                                <td class="font-bold text-slate-900 dark:text-white">{{ $settings['jadwal_1_nama'] ?? 'Manajemen Yayasan/Pesantren' }}</td>
                                <td>{{ $settings['jadwal_1_batas'] ?? '15 Agustus 2026' }}</td>
                                <td>{{ $settings['jadwal_1_waktu'] ?? '22 - 25 Agustus 2026' }}</td>
                                <td>{{ $settings['jadwal_1_metode'] ?? 'Hybrid (Zoom & Bandung Offline)' }}</td>
                                <td>
                                    @php $q1 = $settings['jadwal_1_quota'] ?? 'Sisa 5 Kursi'; @endphp
                                    <span class="{{ stripos($q1, 'sisa') !== false ? 'text-amber-700 dark:text-amber-450' : 'text-emerald-700 dark:text-emerald-455' }} font-bold">{{ $q1 }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-bold text-slate-900 dark:text-white">{{ $settings['jadwal_2_nama'] ?? 'Administrasi Sekolah Islam' }}</td>
                                <td>{{ $settings['jadwal_2_batas'] ?? '1 September 2026' }}</td>
                                <td>{{ $settings['jadwal_2_waktu'] ?? '7 - 11 September 2026' }}</td>
                                <td>{{ $settings['jadwal_2_metode'] ?? 'Online Classroom (LMS & Zoom)' }}</td>
                                <td>
                                    @php $q2 = $settings['jadwal_2_quota'] ?? 'Tersedia'; @endphp
                                    <span class="{{ stripos($q2, 'sisa') !== false ? 'text-amber-700 dark:text-amber-450' : 'text-emerald-700 dark:text-emerald-455' }} font-bold">{{ $q2 }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="font-bold text-slate-900 dark:text-white">{{ $settings['jadwal_3_nama'] ?? 'Kepemimpinan Kepala Sekolah' }}</td>
                                <td>{{ $settings['jadwal_3_batas'] ?? '18 September 2026' }}</td>
                                <td>{{ $settings['jadwal_3_waktu'] ?? '24 - 28 September 2026' }}</td>
                                <td>{{ $settings['jadwal_3_metode'] ?? 'Tatap Muka (Full Boarding Bandung)' }}</td>
                                <td>
                                    @php $q3 = $settings['jadwal_3_quota'] ?? 'Tersedia'; @endphp
                                    <span class="{{ stripos($q3, 'sisa') !== false ? 'text-amber-700 dark:text-amber-455' : 'text-emerald-700 dark:text-emerald-455' }} font-bold">{{ $q3 }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
</section>

    <!-- ========================================================================= -->
    <!-- SECTION 4: INSTRUKTUR -->
    <!-- ========================================================================= -->
    <section id="sec-instruktur" class="tab-content py-20 bg-slate-50 dark:bg-slate-950/60 border-b border-slate-200/60 dark:border-slate-800/40 animate-fade-in hidden">
        <div class="max-w-7xl mx-auto px-6">
            <div class="max-w-3xl mx-auto text-center mb-16">
                <span class="text-[10px] font-black text-blue-700 dark:text-blue-400 uppercase tracking-widest bg-blue-500/10 px-3.5 py-1 rounded-full border border-blue-550/15">Fasilitator Utama</span>
                <h2 class="text-3xl font-black mt-4 mb-4 font-heading text-slate-900 dark:text-white tracking-tight">Instruktur &amp; Pengajar Profesional</h2>
                <p class="text-slate-655 dark:text-slate-400 text-sm leading-relaxed">
                    Setiap instruktur dan pemateri di LPK MPI merupakan praktisi bersertifikat kompetensi dan berpengalaman.
                </p>
            </div>

            <div class="max-w-5xl mx-auto px-4">
                <div class="premium-table-container border border-slate-200 dark:border-slate-800 shadow-sm overflow-x-auto w-full">
                    <table class="premium-table text-xs">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Nama Lengkap</th>
                                <th>Jabatan / Peran</th>
                                <th>Bidang Keahlian</th>
                                <th>Pengalaman Kerja / Akademik</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                            @for($i = 1; $i <= 4; $i++)
                                @php
                                    $iNameKey = "instruktur_{$i}_nama";
                                    $iJabKey  = "instruktur_{$i}_jabatan";
                                    $iKeahKey = "instruktur_{$i}_keahlian";
                                    $iPengKey = "instruktur_{$i}_pengalaman";
                                    $iFotoKey = "instruktur_{$i}_foto";

                                    $defName = $i == 1 ? 'Prof. Dr. H. Badrudin, M.Ag.' : ($i == 2 ? 'Dr. Atep Suherman, M.Pd.' : ($i == 3 ? 'Chyril Futuhana Ahmad, M.Pd.' : ''));
                                    $defJab  = $i == 1 ? 'Instruktur Kepala / Dewan Pengarah' : ($i == 2 ? 'Instruktur Mutu & Organisasi' : ($i == 3 ? 'Instruktur Tenaga Kependidikan' : ''));
                                    $defKeah = $i == 1 ? 'Manajemen Mutu Pendidikan & Akreditasi Madrasah' : ($i == 2 ? 'Tata Pamong Keuangan Pesantren & Organisasi Yayasan' : ($i == 3 ? 'Administrasi EMIS, Dapodik & Manajemen Sarpras' : ''));
                                    $defPeng = $i == 1 ? 'Guru Besar UIN SGD Bandung & Instruktur Lembaga Internasional' : ($i == 2 ? 'Trainer Bidang Kebijakan Publik Pendidikan & Pengawas Yayasan' : ($i == 3 ? 'Kepala Bidang Uji Kompetensi LPK Ketenagakerjaan' : ''));

                                    $name = $settings[$iNameKey] ?? $defName;
                                    $jab  = $settings[$iJabKey] ?? $defJab;
                                    $keah = $settings[$iKeahKey] ?? $defKeah;
                                    $peng = $settings[$iPengKey] ?? $defPeng;
                                    $foto = $settings[$iFotoKey] ?? '';
                                @endphp

                                @if(!empty($name))
                                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/50 transition-colors">
                                        <td class="w-16 py-3">
                                            @if($foto)
                                                <img src="{{ asset('storage/' . $foto) }}" class="w-12 h-12 object-cover rounded-none border border-slate-250 dark:border-slate-800" alt="{{ $name }}">
                                            @else
                                                <div class="w-12 h-12 bg-blue-700/10 border border-blue-750/20 text-blue-700 dark:text-blue-400 flex items-center justify-center font-bold text-xs uppercase rounded-none">
                                                    {{ implode('', array_map(fn($part) => $part[0] ?? '', explode(' ', $name))) }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="font-bold text-slate-900 dark:text-white py-3">{{ $name }}</td>
                                        <td class="text-blue-700 dark:text-blue-400 font-semibold py-3">{{ $jab }}</td>
                                        <td class="py-3 text-slate-600 dark:text-slate-400">{{ $keah }}</td>
                                        <td class="py-3 text-slate-600 dark:text-slate-400">{{ $peng }}</td>
                                    </tr>
                                @endif
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================================================= -->
    <!-- SECTION 5: FASILITAS -->
    <!-- ========================================================================= -->
    <section id="sec-fasilitas" class="tab-content py-20 bg-white dark:bg-slate-900 border-b border-slate-200/60 dark:border-slate-800/40 animate-fade-in hidden">
        <div class="max-w-7xl mx-auto px-6">
            <div class="max-w-3xl mx-auto text-center mb-16">
                <span class="text-[10px] font-black text-blue-700 dark:text-blue-400 uppercase tracking-widest bg-blue-500/10 px-3.5 py-1 rounded-full border border-blue-550/15">Sarana Fisik</span>
                <h2 class="text-3xl font-black mt-4 mb-4 font-heading text-slate-900 dark:text-white tracking-tight">Fasilitas &amp; Prasarana Pembelajaran</h2>
                <p class="text-slate-605 dark:text-slate-400 text-sm leading-relaxed">
                    Kami menyediakan sarana fisik pendukung untuk kenyamanan dan keefektifan belajar peserta diklat.
                </p>
            </div>
            <div class="grid grid-cols-1 gap-8 max-w-5xl mx-auto text-left">
                <!-- Sub-section: Ruang Belajar -->
                <div id="sec-fasilitas-belajar" class="glass-card rounded-2xl p-8 border border-slate-200 dark:border-slate-800 scroll-mt-28 grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
                    <div class="md:col-span-3 w-20 h-20 bg-blue-700/10 text-blue-700 dark:text-blue-400 border border-blue-700/20 flex items-center justify-center text-xs font-black shadow-sm mx-auto md:mx-0 overflow-hidden">
                        @if(!empty($settings['fasilitas_belajar_foto']))
                            <img src="{{ asset('storage/' . $settings['fasilitas_belajar_foto']) }}" class="w-full h-full object-cover" alt="Fasilitas Belajar">
                        @else
                            CLASS
                        @endif
                    </div>
                    <div class="md:col-span-9">
                        <h3 class="font-bold text-slate-900 dark:text-white text-lg mb-2">{{ $settings['fasilitas_belajar_judul'] ?? 'Ruang Belajar & Teori Ergonomis' }}</h3>
                        <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm leading-relaxed">
                            {{ $settings['fasilitas_belajar_desc'] ?? 'Kami memiliki ruang kelas berkapasitas 25 orang yang sejuk (AC penuh) dengan tata pencahayaan yang nyaman, papan tulis kaca interaktif, serta sound system nirkabel untuk presentasi materi ajar secara optimal.' }}
                        </p>
                    </div>
                </div>

                <!-- Sub-section: Perpustakaan -->
                <div id="sec-fasilitas-perpustakaan" class="glass-card rounded-2xl p-8 border border-slate-200 dark:border-slate-800 scroll-mt-28 grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
                    <div class="md:col-span-3 w-20 h-20 bg-emerald-500/10 text-emerald-650 dark:text-emerald-450 border border-emerald-500/20 flex items-center justify-center text-xs font-black shadow-sm mx-auto md:mx-0 overflow-hidden">
                        @if(!empty($settings['fasilitas_perpustakaan_foto']))
                            <img src="{{ asset('storage/' . $settings['fasilitas_perpustakaan_foto']) }}" class="w-full h-full object-cover" alt="Fasilitas Perpustakaan">
                        @else
                            BOOKS
                        @endif
                    </div>
                    <div class="md:col-span-9">
                        <h3 class="font-bold text-slate-900 dark:text-white text-lg mb-2">{{ $settings['fasilitas_perpustakaan_judul'] ?? 'Perpustakaan & Pusat Referensi Digital' }}</h3>
                        <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm leading-relaxed">
                            {{ $settings['fasilitas_perpustakaan_desc'] ?? 'Menyediakan koleksi buku panduan fisik mengenai tata kelola madrasah, undang-undang yayasan, kitab-kitab tata kelola syariah, serta akses ke e-library jurnal riset manajemen pendidikan nasional.' }}
                        </p>
                    </div>
                </div>

                <!-- Sub-section: Asrama / Penginapan -->
                <div id="sec-fasilitas-asrama" class="glass-card rounded-2xl p-8 border border-slate-200 dark:border-slate-800 scroll-mt-28 grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
                    <div class="md:col-span-3 w-20 h-20 bg-amber-500/10 text-amber-600 dark:text-amber-450 border border-amber-500/20 flex items-center justify-center text-xs font-black shadow-sm mx-auto md:mx-0 overflow-hidden">
                        @if(!empty($settings['fasilitas_asrama_foto']))
                            <img src="{{ asset('storage/' . $settings['fasilitas_asrama_foto']) }}" class="w-full h-full object-cover" alt="Fasilitas Asrama">
                        @else
                            ROOMS
                        @endif
                    </div>
                    <div class="md:col-span-9">
                        <h3 class="font-bold text-slate-900 dark:text-white text-lg mb-2">{{ $settings['fasilitas_asrama_judul'] ?? 'Asrama & Penginapan Peserta Diklat' }}</h3>
                        <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm leading-relaxed">
                            {{ $settings['fasilitas_asrama_desc'] ?? 'Bagi peserta diklat dari luar daerah kota Bandung, tersedia asrama eksklusif dengan fasilitas kamar mandi dalam, akses WiFi berkecepatan 100 Mbps, ruang makan/dapur bersama, dan area santai semi-outdoor.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
</section>

<!-- ========================================================================= -->
    <!-- SECTION 6: BERITA & ARTIKEL -->
    <!-- ========================================================================= -->
    <section id="sec-berita" class="tab-content py-20 bg-slate-50 dark:bg-slate-955 border-b border-slate-200/60 dark:border-slate-800/40 animate-fade-in hidden">
        <div class="max-w-7xl mx-auto px-6">
            <div class="max-w-3xl mx-auto text-center mb-16">
                <span class="text-[10px] font-black text-blue-700 dark:text-blue-400 uppercase tracking-widest bg-blue-500/10 px-3.5 py-1 rounded-full border border-blue-550/15">Berita &amp; Artikel</span>
                <h2 class="text-3xl font-black mt-4 mb-4 font-heading text-slate-900 dark:text-white tracking-tight">Kabar Informasi LPK MPI</h2>
                <p class="text-slate-600 dark:text-slate-400 text-sm">
                    Temukan berita kegiatan, artikel edukasi manajemen sekolah, dan galeri dokumentasi kami.
                </p>
            </div>

            <!-- Sub-section: Berita Kegiatan & Artikel Edukasi -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 max-w-6xl mx-auto text-left mb-16">
                <!-- Sub-tab ID: berita-kegiatan -->
                <div id="sec-berita-kegiatan" class="lg:col-span-2 scroll-mt-28 space-y-6">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white border-b border-slate-200 dark:border-slate-800 pb-2">Berita &amp; Artikel Terkini</h3>
                    @if($articles->isEmpty())
                    <div class="glass-card rounded-2xl p-12 text-center border border-slate-200 dark:border-slate-800">
                        <span class="text-slate-400 dark:text-slate-500 text-3xl block mb-3">📰</span>
                        <h3 class="font-bold text-slate-850 dark:text-slate-200 text-xs mb-1">Belum Ada Artikel</h3>
                        <p class="text-slate-500 dark:text-slate-450 text-[11px]">Silakan kembali beberapa saat lagi untuk mendapatkan berita terbaru.</p>
                    </div>
                    @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($articles as $article)
                        <div class="glass-card rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 flex flex-col justify-between hover:scale-[1.01] transition-all cursor-pointer shadow-sm group" onclick="openArticleModal('{{ $article->title }}', '{{ $article->author }}', '{{ $article->published_at ? $article->published_at->format('d M Y') : '-' }}', '{{ $article->image_path ? asset('storage/' . $article->image_path) : '' }}', '{{ addslashes(str_replace(["\r", "\n"], ["", " "], $article->content)) }}')">
                            <div>
                                <div class="h-40 w-full bg-slate-100 dark:bg-slate-950 relative overflow-hidden">
                                    @if($article->image_path)
                                    <img src="{{ asset('storage/' . $article->image_path) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                    <div class="w-full h-full bg-gradient-to-br from-blue-700/80 to-indigo-800/80 flex items-center justify-center text-white text-2xl font-black">
                                        MPI
                                    </div>
                                    @endif
                                </div>
                                <div class="p-5">
                                    <span class="text-[9px] font-black text-blue-700 dark:text-blue-400 uppercase tracking-wider block mb-2">{{ $article->author }} • {{ $article->published_at ? $article->published_at->format('d M Y') : '-' }}</span>
                                    <h4 class="text-sm font-extrabold text-slate-900 dark:text-white mb-2 line-clamp-2 group-hover:text-blue-700 dark:group-hover:text-blue-400 transition-colors">{{ $article->title }}</h4>
                                    <p class="text-slate-650 dark:text-slate-400 text-[11px] leading-relaxed line-clamp-2">{{ Str::limit(strip_tags($article->content), 80) }}</p>
                                </div>
                            </div>
                            <div class="px-5 pb-5 text-left">
                                <span class="text-blue-700 dark:text-blue-450 font-bold text-xs hover:underline inline-flex items-center gap-1">Baca Selengkapnya</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- Sub-tab ID: artikel-edukasi -->
                <div id="sec-artikel-edukasi" class="lg:col-span-1 scroll-mt-28 space-y-6">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white border-b border-slate-200 dark:border-slate-800 pb-2">Artikel Edukasi Pilihan</h3>
                    <div class="glass-card rounded-2xl p-6 border border-slate-200 dark:border-slate-800 space-y-4">
                        <div>
                            <span class="text-[9px] text-blue-700 dark:text-blue-400 font-bold uppercase tracking-widest block mb-1">01. Kebijakan</span>
                            <h4 class="text-xs font-black text-slate-850 dark:text-slate-250 mb-1">Pentingnya Akreditasi &amp; Standardisasi Madrasah</h4>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed">Penjelasan tentang regulasi terbaru BAN-PDM dan kaitan pelatihan LPK dalam audit.</p>
                        </div>
                        <div class="h-px bg-slate-100 dark:bg-white/5"></div>
                        <div>
                            <span class="text-[9px] text-blue-700 dark:text-blue-400 font-bold uppercase tracking-widest block mb-1">02. Tata Kelola</span>
                            <h4 class="text-xs font-black text-slate-850 dark:text-slate-250 mb-1">Manajemen Wakaf Produktif Yayasan Islam</h4>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed">Strategi pimpinan yayasan mengembangkan aset sekolah tanpa membebani biaya SPP.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sub-section: Galeri Media -->
            <div id="sec-galeri-media" class="scroll-mt-28 max-w-6xl mx-auto">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white border-b border-slate-200 dark:border-slate-800 pb-2 mb-8 text-left">Galeri Foto &amp; Media Kegiatan</h3>
                @php
                $defaultGallery = [
                1 => [
                'category' => 'Pelatihan Kepemimpinan',
                'title' => 'Pelatihan Kepemimpinan Kepala Sekolah',
                'desc' => 'Pelatihan kepemimpinan lisan dan pengisian portofolio para kepala madrasah se-Jawa Barat.',
                'gradient' => 'from-blue-700 to-sky-500',
                ],
                2 => [
                'category' => 'Pelatihan Administrasi',
                'title' => 'Bimtek EMIS & Dapodik Guru',
                'desc' => 'Pelatihan digital bagi para staf tata usaha guna meningkatkan keakuratan data dindikbud.',
                'gradient' => 'from-sky-600 to-emerald-500',
                ],
                3 => [
                'category' => 'Kerjasama Kelembagaan',
                'title' => 'MoU Bersama UIN Bandung',
                'desc' => 'Kemitraan program pelatihan kerja mahasiswa prodi Manajemen Pendidikan Islam.',
                'gradient' => 'from-indigo-700 to-purple-500',
                ]
                ];
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-left">
                    @for($i = 1; $i <= 6; $i++)
                        @php
                            $gCategory = $settings["gallery_item_{$i}_category"] ?? ($defaultGallery[$i]['category'] ?? '');
                            $gTitle = $settings["gallery_item_{$i}_title"] ?? ($defaultGallery[$i]['title'] ?? '');
                            $gDesc = $settings["gallery_item_{$i}_desc"] ?? ($defaultGallery[$i]['desc'] ?? '');
                            $gImage = $settings["gallery_item_{$i}_image"] ?? '';
                            $gVideo = $settings["gallery_item_{$i}_video_url"] ?? '';
                            $gGradient = $defaultGallery[$i]['gradient'] ?? 'from-indigo-600 to-pink-500';
                        @endphp
                        @if(!empty($gTitle))
                        <div class="glass-card rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col hover:scale-[1.02] transition-all relative group/gal">
                            <div class="h-44 w-full bg-slate-100 dark:bg-slate-955 relative overflow-hidden flex items-center justify-center">
                                @if(!empty($gImage))
                                    <img src="{{ asset('storage/' . $gImage) }}" class="w-full h-full object-cover group-hover/gal:scale-105 transition-transform duration-300" alt="{{ $gTitle }}">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br {{ $gGradient }} flex items-center justify-center text-white text-xs font-black tracking-widest uppercase p-4 text-center">
                                        {{ $gCategory }}
                                    </div>
                                @endif

                                @if(!empty($gVideo))
                                    <button onclick="openVideoModal('{{ $gVideo }}')" class="absolute inset-0 bg-black/40 hover:bg-black/50 transition-colors flex items-center justify-center group-hover/gal:opacity-100 duration-300">
                                        <div class="w-12 h-12 rounded-full bg-white/95 text-blue-700 hover:scale-110 transition-transform flex items-center justify-center shadow-lg">
                                            <svg class="w-6 h-6 fill-current ml-0.5" viewBox="0 0 24 24">
                                                <path d="M8 5v14l11-7z"/>
                                            </svg>
                                        </div>
                                        <span class="absolute bottom-3 text-[10px] text-white font-bold tracking-wider uppercase bg-black/60 px-2.5 py-0.5 rounded">Tonton Video</span>
                                    </button>
                                @endif
                            </div>
                            <div class="p-5 flex-1 flex flex-col justify-between">
                                <div>
                                    <span class="text-[9px] font-black text-blue-700 dark:text-blue-400 uppercase tracking-wider block mb-2">{{ $gCategory }}</span>
                                    <h4 class="font-bold text-slate-900 dark:text-white text-sm mb-1 line-clamp-1">{{ $gTitle }}</h4>
                                    <p class="text-slate-600 dark:text-slate-400 text-[11px] leading-relaxed line-clamp-3">
                                        {{ $gDesc }}
                                    </p>
                                </div>
                                @if(!empty($gVideo) && empty($gImage))
                                    <div class="mt-4 text-left">
                                        <button onclick="openVideoModal('{{ $gVideo }}')" class="text-xs font-bold text-blue-700 dark:text-blue-450 hover:underline flex items-center gap-1">
                                            ▶ Putar Video
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    @endfor
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================================================= -->
    <!-- SECTION 7: ALUMNI & TESTIMONI -->
    <!-- ========================================================================= -->
    <section id="sec-alumni" class="tab-content py-20 bg-white dark:bg-slate-900 border-b border-slate-200/60 dark:border-slate-800/40 animate-fade-in hidden">
        <div class="max-w-7xl mx-auto px-6">
            <div class="max-w-3xl mx-auto text-center mb-16">
                <span class="text-[10px] font-black text-blue-700 dark:text-blue-400 uppercase tracking-widest bg-blue-500/10 px-3.5 py-1 rounded-full border border-blue-550/15">Jejak Lulusan</span>
                <h2 class="text-3xl font-black mt-4 mb-4 font-heading text-slate-900 dark:text-white tracking-tight">Kisah Alumni &amp; Testimoni</h2>
                <p class="text-slate-600 dark:text-slate-400 text-sm">
                    Melihat kesuksesan lulusan kompeten yang kini berkarir di berbagai instansi pendidikan Islam.
                </p>
            </div>

            <!-- Sub-section: Kisah Sukses -->
            <div id="sec-alumni-kisah" class="scroll-mt-28 max-w-5xl mx-auto text-left mb-16">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white border-b border-slate-200 dark:border-slate-800 pb-2 mb-8">Kisah Sukses Alumni</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Testimonial 1 -->
                    <div class="glass-card rounded-2xl p-6 border border-slate-200 dark:border-slate-800 flex flex-col justify-between relative shadow-sm">
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed italic mb-6">
                            "Setelah mendapatkan pelatihan kepemimpinan Kepala Sekolah dari LPK MPI, tata kelola yayasan kami mendapatkan nilai akreditasi A. Sertifikat LPK sangat bernilai tinggi dalam membuktikan kapabilitas saya."
                        </p>
                        <div class="flex items-center gap-3 border-t border-slate-100 dark:border-white/5 pt-4">
                            <div class="w-9 h-9 rounded-full bg-blue-500/10 text-blue-700 dark:text-blue-400 flex items-center justify-center font-bold text-xs uppercase">
                                HW
                            </div>
                            <div>
                                <h4 class="text-xs font-black text-slate-900 dark:text-white uppercase">H. Wawan Hermawan, M.Ag.</h4>
                                <span class="text-[9px] text-slate-400 dark:text-slate-500 font-bold uppercase block">Kepala MA Darul Qur'an • Lulusan 2025</span>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial 2 -->
                    <div class="glass-card rounded-2xl p-6 border border-slate-200 dark:border-slate-800 flex flex-col justify-between relative shadow-sm">
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed italic mb-6">
                            "Pelatihan administrasi TU di madrasah membantu saya mempercepat data EMIS Kemenag 100% akurat. Penjelasan instrukturnya sangat aplikatif dengan sistem kerja tata usaha digital."
                        </p>
                        <div class="flex items-center gap-3 border-t border-slate-100 dark:border-white/5 pt-4">
                            <div class="w-9 h-9 rounded-full bg-emerald-500/10 text-emerald-650 dark:text-emerald-450 flex items-center justify-center font-bold text-xs uppercase">
                                NS
                            </div>
                            <div>
                                <h4 class="text-xs font-black text-slate-900 dark:text-white uppercase">Nurul Sofia, S.Pd.</h4>
                                <span class="text-[9px] text-slate-400 dark:text-slate-500 font-bold uppercase block">Staf TU MTs Al-Falah Bandung • Lulusan 2026</span>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial 3 -->
                    <div class="glass-card rounded-2xl p-6 border border-slate-200 dark:border-slate-800 flex flex-col justify-between relative shadow-sm">
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed italic mb-6">
                            "Pelatihan pengurus yayasan di LPK MPI meluruskan pemahaman kami mengenai regulasi pembagian harta wakaf dan operasional yayasan. Pelayanannya profesional, cepat, dan transparan."
                        </p>
                        <div class="flex items-center gap-3 border-t border-slate-100 dark:border-white/5 pt-4">
                            <div class="w-9 h-9 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-450 flex items-center justify-center font-bold text-xs uppercase">
                                AS
                            </div>
                            <div>
                                <h4 class="text-xs font-black text-slate-900 dark:text-white uppercase">Ahmad Solihin</h4>
                                <span class="text-[9px] text-slate-400 dark:text-slate-500 font-bold uppercase block">Ketua Yayasan Bina Insan Mulia • Lulusan 2024</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sub-section: Daftar Jaringan Alumni -->
            <div id="sec-alumni-jaringan" class="scroll-mt-28 max-w-5xl mx-auto text-left">
                <div class="glass-card rounded-2xl p-6 border border-slate-200 dark:border-slate-800">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Placements &amp; Jaringan Akreditasi Alumni</h3>
                    <p class="text-slate-500 dark:text-slate-405 text-xs mb-6">Lulusan kami telah tersertifikasi aktif dan mengabdi di berbagai instansi di Indonesia:</p>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                        <div class="bg-white/20 dark:bg-slate-900/30 p-4 border border-slate-100 dark:border-slate-800 rounded-xl">
                            <span class="block text-2xl font-black text-blue-700 dark:text-blue-400">120+</span>
                            <span class="text-[9px] uppercase tracking-wider text-slate-400 font-bold">Yayasan Islam</span>
                        </div>
                        <div class="bg-white/20 dark:bg-slate-900/30 p-4 border border-slate-100 dark:border-slate-800 rounded-xl">
                            <span class="block text-2xl font-black text-blue-700 dark:text-blue-400">340+</span>
                            <span class="text-[9px] uppercase tracking-wider text-slate-400 font-bold">Madrasah Aliyah</span>
                        </div>
                        <div class="bg-white/20 dark:bg-slate-900/30 p-4 border border-slate-100 dark:border-slate-800 rounded-xl">
                            <span class="block text-2xl font-black text-blue-700 dark:text-blue-400">85+</span>
                            <span class="text-[9px] uppercase tracking-wider text-slate-400 font-bold">Pondok Pesantren</span>
                        </div>
                        <div class="bg-white/20 dark:bg-slate-900/30 p-4 border border-slate-100 dark:border-slate-800 rounded-xl">
                            <span class="block text-2xl font-black text-blue-700 dark:text-blue-400">2,500+</span>
                            <span class="text-[9px] uppercase tracking-wider text-slate-400 font-bold">Alumni Terlatih</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================================================= -->
    <!-- SECTION 8: PENDAFTARAN ONLINE -->
    <!-- =======================================================    <section id="sec-pendaftaran" class="tab-content py-20 bg-slate-50 dark:bg-slate-950/60 border-b border-slate-200/60 dark:border-slate-800/40 animate-fade-in hidden">
        <div class="max-w-7xl mx-auto px-6">
            <div class="max-w-3xl mx-auto text-center mb-16">
                <span class="text-[10px] font-black text-blue-700 dark:text-blue-400 uppercase tracking-widest bg-blue-500/10 px-3.5 py-1 rounded-full border border-blue-550/15">Portal Penerimaan</span>
                <h2 class="text-3xl font-black mt-4 mb-4 font-heading text-slate-900 dark:text-white tracking-tight">Sistem Registrasi Online</h2>
                <p class="text-slate-600 dark:text-slate-400 text-sm">
                    Prosedur pendaftaran pelatihan kerja LPK MPI secara digital.
                </p>
            </div>

            <!-- Sub-section: Syarat & Ketentuan -->
            <div id="sec-pendaftaran-syarat" class="scroll-mt-28 max-w-5xl mx-auto text-left mb-12">
                <div class="glass-card rounded-2xl p-6 border border-slate-200 dark:border-slate-800">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-3">Persyaratan Dokumen Pendaftar</h3>
                    <p class="text-slate-500 dark:text-slate-450 text-xs mb-4">Calon peserta wajib mengunggah pindaian berkas persyaratan berikut saat melakukan pengisian formulir:</p>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                        <div class="bg-white/20 dark:bg-slate-900/40 p-4 border border-slate-100 dark:border-slate-800 rounded-lg">
                            <strong class="text-blue-705 dark:text-blue-400 block mb-1">1. KTP Asli</strong>
                            Format gambar (JPG, PNG) dengan resolusi jelas dan NIK terbaca.
                        </div>
                        <div class="bg-white/20 dark:bg-slate-900/40 p-4 border border-slate-100 dark:border-slate-800 rounded-lg">
                            <strong class="text-blue-705 dark:text-blue-400 block mb-1">2. Ijazah Terakhir</strong>
                            Pendidikan minimal SMA/SMK/MA untuk memenuhi persyaratan awal skema.
                        </div>
                        <div class="bg-white/20 dark:bg-slate-900/40 p-4 border border-slate-100 dark:border-slate-800 rounded-lg">
                            <strong class="text-blue-705 dark:text-blue-400 block mb-1">3. Surat Rekomendasi</strong>
                            Dari sekolah/yayasan asal (opsional, dilampirkan jika ada beasiswa).
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sub-section: Rincian Biaya -->
            <div id="sec-pendaftaran-biaya" class="scroll-mt-28 max-w-5xl mx-auto text-left mb-12">
                <div class="glass-card rounded-2xl p-6 border border-slate-200 dark:border-slate-800">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Rincian Investasi &amp; Biaya</h3>
                    <div class="premium-table-container border-none shadow-none overflow-x-auto w-full">
                        <table class="premium-table text-xs">
                            <thead>
                                <tr>
                                    <th>Program Pelatihan</th>
                                    <th>Biaya Investasi</th>
                                    <th>Fasilitas Termasuk</th>
                                    <th>Sertifikat Diterbitkan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                                <tr>
                                    <td class="font-bold">Manajemen Yayasan/Pesantren</td>
                                    <td class="text-blue-700 dark:text-blue-400 font-bold">Rp 1.500.000</td>
                                    <td>Buku Materi, Hybrid Zoom, Asrama (2 Hari)</td>
                                    <td>Sertifikat Diklat LPK &amp; Uji Kompetensi LPK</td>
                                </tr>
                                <tr>
                                    <td class="font-bold">Administrasi Sekolah Islam</td>
                                    <td class="text-blue-700 dark:text-blue-400 font-bold">Rp 1.250.000</td>
                                    <td>Akses LMS Selamanya, Modul Softcopy, E-Certificate</td>
                                    <td>Sertifikat Diklat LPK</td>
                                </tr>
                                <tr>
                                    <td class="font-bold">Kepemimpinan Kepala Sekolah</td>
                                    <td class="text-blue-700 dark:text-blue-400 font-bold">Rp 1.800.000</td>
                                    <td>Full Boarding Hotel, Tas &amp; ATK Diklat, Sertifikat Fisik</td>
                                    <td>Sertifikat Diklat LPK &amp; Uji Kompetensi LPK</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Sub-section: Formulir Pendaftaran -->
            <div id="sec-pendaftaran-formulir" class="scroll-mt-28 max-w-3xl mx-auto text-left">
                <div class="glass-card rounded-2xl p-8 border border-slate-200 dark:border-slate-800 bg-white/40 dark:bg-slate-900/40">
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-4">Formulir Pendaftaran &amp; Unggah Berkas</h3>
                    <p class="text-slate-500 dark:text-slate-450 text-xs mb-6">Pastikan mengisi data diri yang valid. Akun Anda untuk portal LMS &amp; ujian LPK akan dibuat otomatis.</p>

                    <div id="landing-form-errors" class="hidden mb-6 p-4 bg-rose-500/10 border border-rose-500/20 text-rose-705 dark:text-rose-400 rounded-xl text-xs space-y-1"></div>

                    <!-- Registration Success Output (Hidden initially) -->
                    <div id="landing-enrollment-success-card" class="hidden text-center py-6">
                        <div class="w-12 h-12 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/25 flex items-center justify-center mx-auto mb-4">
                            ✓
                        </div>
                        <h4 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Pendaftaran Berhasil Terkirim!</h4>
                        <p class="text-slate-655 dark:text-slate-400 text-xs mb-6">Pendaftaran Anda telah berhasil terverifikasi. Kami telah menerbitkan lembar kuitansi serta sertifikat kelulusan sementara LPK Anda.</p>

                        <div class="border-[4px] border-double border-blue-900/20 dark:border-blue-500/20 rounded-xl p-6 bg-slate-50/50 dark:bg-slate-955 max-w-md mx-auto text-left mb-6">
                            <span class="text-[9px] text-slate-455 uppercase font-black tracking-widest block mb-0.5">Nama Peserta:</span>
                            <strong class="text-slate-905 dark:text-white text-base block font-black uppercase" id="landing-cert-name">-</strong>

                            <div class="grid grid-cols-2 gap-4 mt-3 pt-3 border-t border-slate-200 dark:border-white/5 text-xs">
                                <div>
                                    <span class="text-[9px] text-slate-455 uppercase font-black block tracking-wider">No. Sertifikat:</span>
                                    <span class="font-mono text-slate-805 dark:text-slate-205 font-bold" id="landing-cert-number">-</span>
                                </div>
                                <div>
                                    <span class="text-[9px] text-slate-455 uppercase font-black block tracking-wider">Metode Uji:</span>
                                    <span class="text-blue-700 dark:text-blue-400 font-bold">PORTFOLIO</span>
                                </div>
                            </div>
                        </div>

                        <button class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-2.5 px-6 rounded-lg text-xs uppercase tracking-wider transition-all" id="btn-landing-reset-form">
                            Daftar Peserta Lain
                        </button>
                    </div>

                    <form id="landing-enrollment-form" action="{{ route('enroll') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div class="flex flex-col gap-1.5">
                            <label class="text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Pilih Program Pelatihan</label>
                            <select name="program_id" required class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-lg px-4 py-2.5 text-xs text-slate-900 dark:text-slate-200 focus:outline-none focus:border-blue-700 dark:focus:border-blue-400">
                                <option value="" disabled selected>Pilih Program Pelatihan...</option>
                                @foreach($programs as $prog)
                                <option value="{{ $prog->id }}">{{ $prog->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="flex flex-col gap-1.5">
                                <label class="text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Nama Lengkap (Gelar Lengkap)</label>
                                <input type="text" name="name" required placeholder="Contoh: Dr. Hamidun, M.Pd." class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-lg px-4 py-2.5 text-xs text-slate-900 dark:text-slate-200 focus:outline-none focus:border-blue-700 dark:focus:border-blue-400">
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Nomor Induk Kependudukan (NIK)</label>
                                <input type="text" name="nik" maxlength="16" required placeholder="16-Digit NIK" class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-lg px-4 py-2.5 text-xs text-slate-900 dark:text-slate-200 focus:outline-none focus:border-blue-700 dark:focus:border-blue-400 font-mono">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="flex flex-col gap-1.5">
                                <label class="text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Alamat Email (Gmail Aktif)</label>
                                <input type="email" id="landing-enroll-email" name="email" required placeholder="nama@gmail.com" class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-lg px-4 py-2.5 text-xs text-slate-900 dark:text-slate-200 focus:outline-none focus:border-blue-700 dark:focus:border-blue-400">
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">No. WhatsApp/HP Aktif</label>
                                <input type="tel" name="phone" required placeholder="Contoh: 0812XXXXXXXX" class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-lg px-4 py-2.5 text-xs text-slate-900 dark:text-slate-200 focus:outline-none focus:border-blue-700 dark:focus:border-blue-400">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="flex flex-col gap-1.5">
                                <label class="text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Pendidikan Terakhir</label>
                                <select name="education" required class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-lg px-4 py-2.5 text-xs text-slate-950 dark:text-slate-200 focus:outline-none focus:border-blue-700 dark:focus:border-blue-400">
                                    <option value="" disabled selected>Pilih Pendidikan...</option>
                                    <option value="S3">S3 / Doktor</option>
                                    <option value="S2">S2 / Magister</option>
                                    <option value="S1">S1 / Sarjana</option>
                                    <option value="D3">D3 / Diploma III</option>
                                    <option value="SMA">SMA / SMK / MA</option>
                                </select>
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Kategori Keanggotaan</label>
                                <select name="category" required class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-lg px-4 py-2.5 text-xs text-slate-955 dark:text-slate-200 focus:outline-none focus:border-blue-700 dark:focus:border-blue-400">
                                    <option value="" disabled selected>Pilih Kategori...</option>
                                    <option value="guru">Guru Madrasah</option>
                                    <option value="mahasiswa">Dosen / Mahasiswa</option>
                                    <option value="kerja">Praktisi Lembaga / Umum</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="flex flex-col gap-1.5">
                                <label class="text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Nama Instansi / Sekolah</label>
                                <input type="text" name="company" required placeholder="Nama Madrasah / Pesantren" class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-lg px-4 py-2.5 text-xs text-slate-900 dark:text-slate-200 focus:outline-none focus:border-blue-700 dark:focus:border-blue-400">
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Jabatan Saat Ini</label>
                                <input type="text" name="position" required placeholder="Contoh: Staf Administrasi / Kepala TU" class="bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-lg px-4 py-2.5 text-xs text-slate-900 dark:text-slate-200 focus:outline-none focus:border-blue-700 dark:focus:border-blue-400">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="flex flex-col gap-1.5">
                                <label class="text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Unggah Scan KTP (Gambar, maks 2MB)</label>
                                <input type="file" name="ktp" accept="image/*" required class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-lg px-4 py-2 text-xs text-slate-900 dark:text-slate-200 focus:outline-none focus:border-blue-700 dark:focus:border-blue-400">
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label class="text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Unggah Scan Ijazah (Gambar, maks 2MB)</label>
                                <input type="file" name="ijazah" accept="image/*" required class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-lg px-4 py-2 text-xs text-slate-900 dark:text-slate-200 focus:outline-none focus:border-blue-700 dark:focus:border-blue-400">
                            </div>
                        </div>

                        <!-- OTP Code Container (Hidden initially) -->
                        <div id="landing-otp-section" class="hidden border border-blue-500/20 bg-blue-500/5 dark:bg-blue-950/20 p-4 rounded-lg space-y-3 transition-all duration-300">
                            <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800 pb-2">
                                <span class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Email OTP Verification Required</span>
                                <span class="text-[9px] text-blue-705 dark:text-blue-400 bg-blue-500/10 px-2 py-0.5 rounded font-black">OTP</span>
                            </div>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">Kami telah mengirimkan 6-digit kode verifikasi ke email Anda. Periksa kotak masuk Gmail Anda.</p>

                            <div id="landing-otp-debug" class="hidden text-xs bg-amber-500/10 border border-amber-500/20 text-amber-600 dark:text-amber-450 p-2.5 rounded font-bold font-mono"></div>

                            <div class="flex gap-3">
                                <input type="text" id="landing-otp-code-input" name="otp_code" placeholder="Kode OTP" class="flex-1 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-lg px-4 py-2.5 text-xs text-slate-900 dark:text-slate-200 text-center tracking-widest font-mono font-bold">
                                <button type="button" id="btn-landing-resend-otp" class="bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-[10px] uppercase px-4 rounded-lg">Resend (<span id="landing-otp-timer">60</span>s)</button>
                            </div>
                        </div>

                        <button type="submit" id="btn-landing-enroll-submit" class="w-full bg-[#1e5afb] hover:bg-[#1546cb] text-white font-bold py-3 px-6 rounded-lg text-xs uppercase tracking-wider transition-all shadow-md flex items-center justify-center">
                            Kirim Pendaftaran &amp; Generate OTP
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================================================= -->
    <!-- SECTION 9: HUBUNGI KAMI (KONTAK) -->
    <!-- =====================================================    <section id="sec-kontak" class="tab-content py-20 bg-white dark:bg-slate-900 border-b border-slate-200/60 dark:border-slate-800/40 animate-fade-in hidden">
        <div class="max-w-7xl mx-auto px-6">
            <div class="max-w-3xl mx-auto text-center mb-12">
                <span class="text-[10px] font-black text-blue-700 dark:text-blue-400 uppercase tracking-widest bg-blue-500/10 px-3.5 py-1 rounded-full border border-blue-550/15">Hubungi Kami</span>
                <h2 class="text-3xl font-black mt-4 mb-4 font-heading text-slate-900 dark:text-white tracking-tight">Informasi Kantor &amp; Layanan Pelanggan</h2>
                <p class="text-slate-606 dark:text-slate-400 text-base leading-relaxed">
                    Staf admin LPK MPI siap melayani pendaftaran pelatihan, konsultasi, dan pengaduan.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-stretch max-w-6xl mx-auto">
                <!-- Col 1: Kontak Info -->
                <div class="glass-card rounded-2xl p-6 border border-slate-200 dark:border-slate-800 flex flex-col justify-between bg-white/40 dark:bg-slate-900/40 text-left">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6 border-b border-slate-100 dark:border-white/5 pb-3">Kantor Pusat LPK</h3>

                        <div class="space-y-5 text-xs sm:text-sm text-slate-750 dark:text-slate-300">
                            <div class="flex gap-3">
                                <div class="w-7 h-7 rounded-lg bg-blue-500/10 text-blue-700 dark:text-blue-400 border border-blue-500/20 flex items-center justify-center font-bold text-xs uppercase shrink-0">A</div>
                                <p class="text-xs leading-relaxed">
                                    <strong>Alamat Kantor Resmi:</strong><br>
                                    Jl. Gedebage Selatan No.137, Kel. Cisaranten Kidul, Kec. Gedebage, Kota Bandung, Jawa Barat 40295.
                                </p>
                            </div>

                            <div class="flex gap-3">
                                <div class="w-7 h-7 rounded-lg bg-emerald-500/10 text-emerald-650 dark:text-emerald-450 border border-emerald-500/20 flex items-center justify-center font-bold text-xs uppercase shrink-0">W</div>
                                <p class="text-xs leading-relaxed">
                                    <strong>WhatsApp Hotline:</strong><br>
                                    +62 812-3456-7890 (Administrasi Pendaftaran &amp; Pelatihan)
                                </p>
                            </div>

                            <div class="flex gap-3">
                                <div class="w-7 h-7 rounded-lg bg-purple-500/10 text-purple-650 dark:text-purple-400 border border-purple-500/20 flex items-center justify-center font-bold text-xs uppercase shrink-0">E</div>
                                <p class="text-xs leading-relaxed">
                                    <strong>E-mail Layanan:</strong><br>
                                    info@lpk-mpi.com / helpdesk@lpk-mpi.com
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3 mt-6">
                        <a href="https://wa.me/6281234567890?text=Halo%20LPK%20MPI%2C%20saya%20ingin%20tanya%20tentang%20pelatihan" target="_blank" class="w-full bg-emerald-655 hover:bg-emerald-700 text-white font-bold py-3 px-4 rounded-xl text-center shadow-md transition-all flex items-center justify-center gap-2 text-xs uppercase tracking-wider">
                            Hubungi via WhatsApp
                        </a>
                    </div>
                </div>

                <!-- Col 2: Pesan Direct Form -->
                <div class="glass-card rounded-2xl p-6 border border-slate-200 dark:border-slate-800 flex flex-col justify-between bg-white/40 dark:bg-slate-900/40 text-left">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4 border-b border-slate-100 dark:border-white/5 pb-3">Kirim Pesan (Mailable)</h3>

                        <form id="contact-us-form" class="space-y-3.5">
                            <div class="flex flex-col gap-1">
                                <label class="text-[9px] font-bold text-slate-650 dark:text-slate-400 uppercase tracking-wider">Nama Pengirim</label>
                                <input type="text" name="contact_name" required placeholder="Nama Lengkap" class="bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-lg px-3 py-2 text-xs text-slate-900 dark:text-slate-200 focus:outline-none focus:border-blue-700 dark:focus:border-blue-400">
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="text-[9px] font-bold text-slate-655 dark:text-slate-400 uppercase tracking-wider">Alamat Email</label>
                                <input type="email" name="contact_email" required placeholder="nama@gmail.com" class="bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-lg px-3 py-2 text-xs text-slate-900 dark:text-slate-200 focus:outline-none focus:border-blue-700 dark:focus:border-blue-400">
                            </div>
                            <div class="flex flex-col gap-1">
                                <label class="text-[9px] font-bold text-slate-655 dark:text-slate-400 uppercase tracking-wider">Isi Pertanyaan / Pesan</label>
                                <textarea name="contact_message" required placeholder="Tuliskan isi pesan Anda..." class="bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-lg px-3 py-2 text-xs text-slate-900 dark:text-slate-200 focus:outline-none focus:border-blue-700 dark:focus:border-blue-400 h-16 resize-none"></textarea>
                            </div>
                            <div id="contact-status-div" class="hidden text-[10px] p-2.5 rounded font-bold border"></div>
                            <button type="submit" class="w-full bg-[#1e5afb] hover:bg-[#1546cb] text-white font-bold py-2.5 px-4 rounded-lg text-xs uppercase tracking-wider transition-all shadow-md flex items-center justify-center">
                                Kirim Pertanyaan
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Col 3: Google Map -->
                <div class="glass-card rounded-2xl p-6 border border-slate-200 dark:border-slate-800 flex flex-col justify-between bg-white/40 dark:bg-slate-900/40 text-left">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Peta Lokasi Kantor</h3>
                        <p class="text-slate-500 dark:text-slate-405 text-[11px] leading-relaxed mb-4">
                            Peta penunjuk arah resmi kantor sekretariat LPK MPI di Bandung.
                        </p>

                        <!-- Peta Map -->
                        <div class="w-full h-36 bg-slate-200 dark:bg-slate-950/60 rounded-xl border border-slate-300 dark:border-slate-800/80 flex items-center justify-center relative overflow-hidden shadow-inner">
                            <div class="absolute inset-0 opacity-20 dark:opacity-10 bg-[radial-gradient(#000_1px,transparent_1px)] [background-size:16px_16px]"></div>
                            <div class="relative z-10 flex flex-col items-center gap-1 text-center p-2">
                                <span class="w-7 h-7 rounded-full bg-blue-700/10 text-blue-700 dark:text-blue-400 border border-blue-700/20 flex items-center justify-center text-[10px] font-black">
                                    MAP
                                </span>
                                <span class="text-[9px] text-slate-600 dark:text-slate-400 font-bold uppercase tracking-wider">Gedebage Selatan, Kota Bandung</span>
                            </div>
                        </div>
                    </div>

                    <a href="https://maps.google.com" target="_blank" class="w-full bg-gradient-to-r from-blue-700 to-sky-600 text-white font-bold py-3 px-4 rounded-xl text-center hover:brightness-110 shadow-lg shadow-blue-700/20 transition-all duration-300 text-xs uppercase tracking-wider mt-6">
                        Buka Rute Navigasi
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================================================= -->
    <!-- SECTION 10: SCAN QR & VERIFIKASI -->
    <!-- =====================================================    <section id="sec-scan-qr" class="tab-content py-20 bg-slate-50 dark:bg-slate-950/60 border-b border-slate-200/60 dark:border-slate-800/40 animate-fade-in hidden">
        <div class="max-w-7xl mx-auto px-6">
            <div class="max-w-3xl mx-auto text-center mb-10">
                <span class="text-[10px] font-black text-blue-700 dark:text-blue-400 uppercase tracking-widest bg-blue-500/10 px-3.5 py-1 rounded-full border border-blue-550/15">Validitas Data</span>
                <h2 class="text-3xl font-black mt-4 mb-4 font-heading text-slate-900 dark:text-white tracking-tight">Scan QR Buku Tamu &amp; Sertifikat</h2>
                <p class="text-slate-655 dark:text-slate-400 text-xs leading-relaxed max-w-2xl mx-auto">
                    Silakan lakukan pengisian Buku Tamu Resepsionis melalui pemindaian QR kunjungan atau verifikasi status legal sertifikat Anda.
                </p>

                <div class="flex justify-center gap-2 mt-6">
                    <button type="button" id="btn-subtab-guestbook" class="px-5 py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-all duration-300 bg-blue-700 text-white shadow-md" onclick="switchSubTab('guestbook')">
                        Buku Tamu Resepsionis
                    </button>
                    <button type="button" id="btn-subtab-verify" class="px-5 py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-all duration-300 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-350 hover:bg-slate-200 dark:hover:bg-slate-700" onclick="switchSubTab('verify')">
                        Verifikasi Sertifikat
                    </button>
                </div>
            </div>

            <!-- Subtab: Guestbook -->
            <div id="subtab-content-guestbook" class="space-y-12">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start max-w-6xl mx-auto text-left">
                    <div class="lg:col-span-5 glass-card rounded-2xl p-6 border border-slate-200 dark:border-slate-800 text-center flex flex-col justify-between h-full bg-white/40 dark:bg-slate-900/40">
                        <div>
                            <h3 class="text-base font-bold text-slate-900 dark:text-white mb-2">Simulasi Scan Resepsionis</h3>
                            <p class="text-slate-500 dark:text-slate-450 text-[11px] leading-relaxed mb-4">
                                Pindai QR Code di meja resepsionis LPK MPI atau klik tombol simulasi di bawah.
                            </p>

                            <div class="relative w-full aspect-square max-w-[240px] mx-auto bg-slate-950 rounded-xl overflow-hidden border-2 border-slate-800/80 flex flex-col items-center justify-center shadow-inner group">
                                <div id="scan-laser" class="absolute left-0 right-0 h-0.5 bg-gradient-to-r from-red-500 via-rose-500 to-red-500 opacity-80 animate-scanline z-20"></div>

                                <div class="absolute top-4 left-4 w-5 h-5 border-t-2 border-l-2 border-blue-500 z-10"></div>
                                <div class="absolute top-4 right-4 w-5 h-5 border-t-2 border-r-2 border-blue-500 z-10"></div>
                                <div class="absolute bottom-4 left-4 w-5 h-5 border-b-2 border-l-2 border-blue-500 z-10"></div>
                                <div class="absolute bottom-4 right-4 w-5 h-5 border-b-2 border-r-2 border-blue-500 z-10"></div>

                                <div id="scanner-view-content" class="relative z-10 flex flex-col items-center gap-3 p-4 text-center">
                                    <svg class="w-12 h-12 text-slate-500 animate-pulse" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z"></path>
                                    </svg>
                                    <span class="text-[10px] font-mono text-slate-400 uppercase tracking-widest" id="scanner-status-text">Kamera Siap Memindai</span>
                                </div>
                            </div>
                        </div>

                        <button type="button" id="btn-simulate-scan" class="w-full bg-slate-800 hover:bg-slate-700 text-white font-bold py-3 px-4 rounded-xl text-xs uppercase tracking-wider transition-all shadow-md mt-6 flex items-center justify-center gap-2">
                            Simulasi Scan QR
                        </button>
                    </div>

                    <div class="lg:col-span-7 glass-card rounded-2xl p-6 sm:p-8 border border-slate-200 dark:border-slate-800 bg-white/40 dark:bg-slate-900/40">
                        <h3 class="text-lg font-black text-slate-900 dark:text-white mb-6 border-b border-slate-100 dark:border-white/5 pb-3">Form Kehadiran Resepsionis</h3>

                        <form id="guest-book-form" class="space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="flex flex-col gap-1.5">
                                    <label class="text-xs font-bold text-slate-655 dark:text-slate-400 uppercase tracking-wider">Nama Lengkap</label>
                                    <input type="text" name="name" required placeholder="Contoh: Dr. Budi, M.Pd" class="bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-xs text-slate-900 dark:text-slate-200 focus:outline-none">
                                </div>
                                <div class="flex flex-col gap-1.5">
                                    <label class="text-xs font-bold text-slate-655 dark:text-slate-400 uppercase tracking-wider">No. WhatsApp</label>
                                    <input type="tel" name="phone" required placeholder="Contoh: 081234567890" class="bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-xs text-slate-900 dark:text-slate-200 focus:outline-none">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="flex flex-col gap-1.5">
                                    <label class="text-xs font-bold text-slate-655 dark:text-slate-400 uppercase tracking-wider">Nama Instansi</label>
                                    <input type="text" name="institution" required placeholder="Contoh: UIN Bandung" class="bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-xs text-slate-900 dark:text-slate-200 focus:outline-none">
                                </div>
                                <div class="flex flex-col gap-1.5">
                                    <label class="text-xs font-bold text-slate-655 dark:text-slate-400 uppercase tracking-wider">Jabatan</label>
                                    <input type="text" name="position" required placeholder="Contoh: Dosen MPI" class="bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-xs text-slate-900 dark:text-slate-200 focus:outline-none">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="flex flex-col gap-1.5">
                                    <label class="text-xs font-bold text-slate-655 dark:text-slate-400 uppercase tracking-wider">Tujuan</label>
                                    <select name="purpose" required class="bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-xs text-slate-950 dark:text-slate-200 focus:outline-none">
                                        <option value="">-- Pilih Tujuan --</option>
                                        <option value="Konsultasi Pelatihan Kerja">Konsultasi Pelatihan Kerja</option>
                                        <option value="Silaturahmi / Kunjungan Kerja">Silaturahmi / Kunjungan Kerja</option>
                                        <option value="Pengurusan Surat & Administrasi">Pengurusan Surat & Administrasi</option>
                                    </select>
                                </div>
                                <div class="flex flex-col gap-1.5">
                                    <label class="text-xs font-bold text-slate-655 dark:text-slate-400 uppercase tracking-wider">Bertemu Dengan</label>
                                    <select name="meet_with" required class="bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg px-4 py-2.5 text-xs text-slate-950 dark:text-slate-200 focus:outline-none">
                                        <option value="">-- Pilih Personil --</option>
                                        <option value="Prof. Dr. H. Badrudin, M.Ag. (Direktur)">Prof. Dr. H. Badrudin, M.Ag. (Direktur)</option>
                                        <option value="Chyril Futuhana Ahmad, M.Pd. (Sertifikasi)">Chyril Futuhana Ahmad, M.Pd. (Sertifikasi)</option>
                                        <option value="Petugas Resepsionis / Staf Adm">Petugas Resepsionis / Staf Adm</option>
                                    </select>
                                </div>
                            </div>

                            <div id="guest-book-status" class="hidden text-xs py-3 px-4 rounded-lg font-bold"></div>

                            <button type="submit" class="w-full bg-[#1e5afb] hover:bg-[#1546cb] text-white font-bold py-3 px-6 rounded-lg text-xs uppercase tracking-wider transition-all flex items-center justify-center">
                                Kirim Kehadiran
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Feed tamus -->
                <div class="max-w-4xl mx-auto border border-slate-200 dark:border-slate-800 rounded-2xl p-6 bg-slate-50/50 dark:bg-slate-950/20 shadow-sm text-left">
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-4 border-b border-slate-200 dark:border-slate-800 pb-2">
                        Pengunjung Resepsionis Hari Ini
                    </h4>
                    <div class="space-y-3" id="guest-feed-list">
                        <div class="text-center text-slate-400 py-6 text-xs font-semibold">Memuat daftar pengunjung...</div>
                    </div>
                </div>
            </div>

            <!-- Subtab: Verify Certificate -->
            <div id="subtab-content-verify" class="hidden">
                <div class="max-w-xl mx-auto text-left">
                    <div class="glass-card rounded-2xl p-6 sm:p-8 border border-slate-200 dark:border-slate-800 bg-white/40 dark:bg-slate-900/40">
                        <form id="verify-form" class="space-y-4">
                            <div class="flex flex-col gap-1.5">
                                <label for="verify-number" class="text-xs font-bold text-slate-655 dark:text-slate-400 uppercase tracking-wider">Masukkan Nomor Sertifikat</label>
                                <div class="flex flex-col sm:flex-row gap-3">
                                    <input type="text" id="verify-number" placeholder="Contoh: LPK-MPI-2026-0812" required class="flex-1 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-md px-4 py-3 text-base text-slate-900 dark:text-slate-200 focus:outline-none font-mono font-bold">
                                    <button type="submit" id="btn-verify-submit" class="bg-[#1e5afb] hover:bg-[#1546cb] text-white font-bold py-3.5 px-6 rounded-md text-xs uppercase tracking-wider transition-all flex items-center justify-center shrink-0">
                                        Cari Data
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Verification Output -->
                        <div id="verify-result-container" class="hidden mt-8 transition-all">
                            <div class="w-full h-px bg-slate-200 dark:bg-white/5 mb-6"></div>

                            <div id="verify-error-box" class="hidden p-5 bg-rose-500/10 border border-rose-500/20 text-rose-700 dark:text-rose-455 rounded-xl text-xs flex gap-3">
                                <div>
                                    <strong class="block mb-1">Verifikasi Gagal</strong>
                                    <span id="verify-error-msg">Sertifikat tidak terdaftar atau tidak valid.</span>
                                </div>
                            </div>

                            <div id="verify-cert-box" class="hidden text-center animate-fade-in relative overflow-hidden">
                                <div class="border-[6px] border-double border-blue-900/20 dark:border-blue-500/20 rounded-xl p-6 sm:p-8 bg-white/70 dark:bg-slate-955 shadow-lg relative text-left">
                                    <div class="text-center mb-6">
                                        <h4 class="text-blue-800 dark:text-blue-400 text-xs font-black tracking-[3px] uppercase">SERTIFIKAT KELULUSAN</h4>
                                        <span class="text-[9px] text-slate-500 uppercase tracking-widest block mt-0.5 font-bold">LPK MANAJEMEN PENDIDIKAN ISLAM</span>
                                        <div class="w-20 h-0.5 bg-blue-700 mx-auto mt-2.5"></div>
                                    </div>
                                    <div class="space-y-4 text-xs text-slate-700 dark:text-slate-350">
                                        <div>
                                            <span class="text-[9px] text-slate-400 uppercase font-black block tracking-wider">Nama Pemegang:</span>
                                            <strong class="text-slate-900 dark:text-white text-base font-black uppercase" id="v-cert-name">-</strong>
                                        </div>
                                        <div class="grid grid-cols-2 gap-4 border-t border-slate-100 dark:border-white/5 pt-3">
                                            <div>
                                                <span class="text-[9px] text-slate-400 uppercase font-black block tracking-wider">NIK (Masked)</span>
                                                <span id="v-cert-nik">-</span>
                                            </div>
                                            <div>
                                                <span class="text-[9px] text-slate-400 uppercase font-black block tracking-wider">Status Kelulusan</span>
                                                <span class="text-emerald-700 dark:text-emerald-455 font-bold bg-emerald-500/10 px-2 py-0.5 rounded">KOMPETEN</span>
                                            </div>
                                        </div>
                                        <div class="border-t border-slate-100 dark:border-white/5 pt-3">
                                            <span class="text-[9px] text-slate-400 uppercase font-black block tracking-wider">Program Pelatihan</span>
                                            <span class="text-blue-700 dark:text-blue-400 font-bold" id="v-cert-program">-</span>
                                        </div>
                                        <div class="grid grid-cols-2 gap-4 border-t border-slate-100 dark:border-white/5 pt-3">
                                            <div>
                                                <span class="text-[9px] text-slate-400 uppercase font-black block tracking-wider">Nomor Registrasi</span>
                                                <span class="font-mono text-slate-800 dark:text-slate-200" id="v-cert-number">-</span>
                                            </div>
                                            <div>
                                                <span class="text-[9px] text-slate-400 uppercase font-black block tracking-wider">Tanggal Terbit</span>
                                                <span id="v-cert-date">-</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================================================= -->
    <!-- SECTION 11: FAQ -->
    <!-- ========================================================================= -->
    <section id="sec-faq" class="tab-content py-20 bg-white dark:bg-slate-900 border-b border-slate-200/60 dark:border-slate-800/40 animate-fade-in hidden">
        <div class="max-w-7xl mx-auto px-6">
            <div class="max-w-3xl mx-auto text-center mb-12">
                <h2 class="text-3xl font-black mb-4 font-heading text-slate-900 dark:text-white tracking-tight flex items-center justify-center gap-3">
                    FAQ (Tanya Jawab Umum)
                </h2>
                <p class="text-slate-606 dark:text-slate-400 text-base leading-relaxed text-center">
                    Beberapa pertanyaan umum seputar biaya, kelulusan, dan masa berlaku sertifikat kompetensi.
                </p>
            </div>

            <div class="max-w-3xl mx-auto text-left space-y-4">
                <div class="glass-card rounded-2xl p-6 border border-slate-200 dark:border-slate-800">
                    <h4 class="font-bold text-slate-900 dark:text-white mb-2">Apakah sertifikat LPK MPI diakui secara nasional?</h4>
                    <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm">Ya, LPK MPI adalah Lembaga Pelatihan Kerja (LPK) resmi terdaftar. Sertifikat kelulusan yang diterbitkan diakui secara luas oleh instansi pendidikan dan dunia kerja.</p>
                </div>
                <div class="glass-card rounded-2xl p-6 border border-slate-200 dark:border-slate-800">
                    <h4 class="font-bold text-slate-900 dark:text-white mb-2">Berapa lama masa berlaku sertifikat kelulusan LPK?</h4>
                    <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm">Sertifikat kelulusan program LPK berlaku sebagai bukti kompetensi kerja yang sah dan tidak memiliki batas kedaluwarsa umum, namun disarankan melakukan penyegaran keahlian secara berkala.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Detail Artikel -->
    <div id="article-modal" class="fixed inset-0 z-50 overflow-y-auto hidden items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm transition-all duration-300">
        <div class="glass-card w-full max-w-2xl border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-2xl flex flex-col max-h-[90vh]">
            <div class="p-6 border-b border-slate-200 dark:border-white/5 flex justify-between items-center bg-white/20 dark:bg-slate-900/20">
                <h3 class="font-bold text-slate-900 dark:text-white text-sm uppercase">Detail Berita &amp; Informasi</h3>
                <button onclick="closeArticleModal()" class="text-slate-450 hover:text-slate-600 dark:hover:text-white font-black text-xl">&times;</button>
            </div>
            <div class="p-6 overflow-y-auto space-y-4 text-left">
                <div class="h-64 w-full rounded-xl overflow-hidden bg-slate-100 dark:bg-slate-950 relative hidden" id="modal-art-image-container">
                    <img id="modal-art-image" class="w-full h-full object-cover" alt="Article image">
                </div>
                <div class="flex items-center gap-3 text-slate-400 dark:text-slate-500 text-[10px] font-bold uppercase tracking-wider">
                    <span id="modal-art-author">-</span>
                    <span>•</span>
                    <span id="modal-art-date">-</span>
                </div>
                <h2 id="modal-art-title" class="text-2xl font-black text-slate-900 dark:text-white leading-tight">-</h2>
                <div id="modal-art-content" class="text-slate-700 dark:text-slate-300 text-sm leading-relaxed whitespace-pre-wrap">
                    -
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Video Preview -->
    <div id="video-modal" class="fixed inset-0 z-50 overflow-y-auto hidden items-center justify-center p-4 bg-slate-950/85 backdrop-blur-sm transition-all duration-300">
        <div class="glass-card w-full max-w-3xl border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-2xl flex flex-col">
            <div class="p-4 border-b border-slate-200 dark:border-white/5 flex justify-between items-center bg-white/20 dark:bg-slate-900/20">
                <h3 class="font-bold text-slate-900 dark:text-white text-sm uppercase tracking-wider">Video Preview</h3>
                <button onclick="closeVideoModal()" class="text-slate-450 hover:text-slate-600 dark:hover:text-white font-black text-xl">&times;</button>
            </div>
            <div class="p-2 bg-black aspect-video relative">
                <iframe id="video-modal-iframe" class="w-full h-full" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>
        </div>
    </div>

    <!-- Scripts for QR Guestbook and Enrollment -->
    <script>
        // Tab switching for Scan QR / Guestbook / Verify
        function switchSubTab(subTabId) {
            const guestbookContent = document.getElementById('subtab-content-guestbook');
            const verifyContent = document.getElementById('subtab-content-verify');
            const btnGuestbook = document.getElementById('btn-subtab-guestbook');
            const btnVerify = document.getElementById('btn-subtab-verify');

            if (!guestbookContent || !verifyContent) return;

            if (subTabId === 'guestbook') {
                guestbookContent.classList.remove('hidden');
                verifyContent.classList.add('hidden');
                btnGuestbook.className = "px-5 py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-all duration-300 bg-blue-700 text-white shadow-md";
                btnVerify.className = "px-5 py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-all duration-300 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-350 hover:bg-slate-200 dark:hover:bg-slate-700";
            } else {
                guestbookContent.classList.add('hidden');
                verifyContent.classList.remove('hidden');
                btnGuestbook.className = "px-5 py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-all duration-300 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-350 hover:bg-slate-200 dark:hover:bg-slate-700";
                btnVerify.className = "px-5 py-2.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-all duration-300 bg-blue-700 text-white shadow-md";
            }
        }

        // Live Visitors Feed Fetch
        async function fetchRecentVisitors() {
            const feedList = document.getElementById('guest-feed-list');
            if (!feedList) return;

            try {
                const response = await fetch("{{ route('api.guest-book.list') }}");
                const result = await response.json();

                if (result.success && result.data.length > 0) {
                    feedList.innerHTML = '';
                    result.data.forEach(g => {
                        const item = document.createElement('div');
                        item.className = "flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 p-4 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 rounded-xl hover:border-blue-500/30 transition-all duration-300";
                        item.innerHTML = `
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-blue-500/10 text-blue-700 dark:text-blue-400 border border-blue-500/20 flex items-center justify-center font-bold text-xs uppercase">
                                    ${g.name.charAt(0)}
                                </div>
                                <div class="text-left">
                                    <div class="text-xs font-black text-slate-900 dark:text-white uppercase">${g.name}</div>
                                    <div class="text-[10px] text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider">${g.institution} • ${g.position}</div>
                                </div>
                            </div>
                            <div class="text-left sm:text-right shrink-0">
                                <div class="text-[10px] font-bold text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded inline-block uppercase tracking-wider">${g.purpose}</div>
                                <div class="text-[9px] text-slate-400 dark:text-slate-500 mt-1 font-bold font-mono uppercase">${g.time} • Bertemu: ${g.meet_with}</div>
                            </div>
                        `;
                        feedList.appendChild(item);
                    });
                } else {
                    feedList.innerHTML = `
                        <div class="text-center text-slate-400 py-6 text-xs font-semibold">Belum ada daftar kunjungan tamu hari ini.</div>
                    `;
                }
            } catch (err) {
                console.error('Error fetching visitors:', err);
            }
        }

        // Article Modal logic
        function openArticleModal(title, author, date, imageUrl, content) {
            document.getElementById('modal-art-title').textContent = title;
            document.getElementById('modal-art-author').textContent = 'Oleh: ' + author;
            document.getElementById('modal-art-date').textContent = date;
            document.getElementById('modal-art-content').innerHTML = content.replace(/\n/g, '<br>');

            const imgContainer = document.getElementById('modal-art-image-container');
            const imgEl = document.getElementById('modal-art-image');
            if (imageUrl) {
                imgEl.src = imageUrl;
                imgContainer.classList.remove('hidden');
            } else {
                imgContainer.classList.add('hidden');
            }

            const modal = document.getElementById('article-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeArticleModal() {
            const modal = document.getElementById('article-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Video Modal logic
        function openVideoModal(url) {
            const modal = document.getElementById('video-modal');
            const iframe = document.getElementById('video-modal-iframe');
            
            let embedUrl = url;
            if (url.includes('youtube.com/watch') || url.includes('youtu.be/')) {
                let videoId = '';
                if (url.includes('youtube.com/watch')) {
                    const urlParams = new URLSearchParams(new URL(url).search);
                    videoId = urlParams.get('v');
                } else if (url.includes('youtu.be/')) {
                    videoId = url.split('/').pop().split('?')[0];
                }
                embedUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1`;
            } else if (url.includes('instagram.com/p/') || url.includes('instagram.com/reel/')) {
                let cleanUrl = url.split('?')[0];
                if (!cleanUrl.endsWith('/')) cleanUrl += '/';
                embedUrl = `${cleanUrl}embed`;
            }
            
            iframe.src = embedUrl;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeVideoModal() {
            const modal = document.getElementById('video-modal');
            const iframe = document.getElementById('video-modal-iframe');
            iframe.src = '';
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // On DOM Load
        document.addEventListener('DOMContentLoaded', () => {
            fetchRecentVisitors();

            // Simulate scanner button
            const btnSimulateScan = document.getElementById('btn-simulate-scan');
            if (btnSimulateScan) {
                btnSimulateScan.addEventListener('click', () => {
                    const statusText = document.getElementById('scanner-status-text');
                    const viewContent = document.getElementById('scanner-view-content');

                    if (statusText) {
                        statusText.textContent = "MEMINDAI QR CODE...";
                        statusText.className = "text-[10px] font-mono text-yellow-500 uppercase tracking-widest font-bold animate-pulse";
                    }

                    setTimeout(() => {
                        if (statusText) {
                            statusText.textContent = "SCAN BERHASIL!";
                            statusText.className = "text-[10px] font-mono text-emerald-500 uppercase tracking-widest font-black";
                        }

                        if (viewContent) {
                            viewContent.innerHTML = `
                                <div class="w-12 h-12 rounded-full bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-500 text-xl font-bold animate-bounce">
                                    ✓
                                </div>
                                <span class="text-[9px] font-bold text-emerald-500 uppercase tracking-widest">LPK MPI RECEPTION VERIFIED</span>
                            `;
                        }

                        const purposeSelect = document.querySelector('#guest-book-form select[name="purpose"]');
                        if (purposeSelect) {
                            purposeSelect.value = "Konsultasi Pelatihan Kerja";
                        }
                        const nameInput = document.querySelector('#guest-book-form input[name="name"]');
                        if (nameInput) {
                            nameInput.focus();
                        }

                        const statusDiv = document.getElementById('guest-book-status');
                        if (statusDiv) {
                            statusDiv.className = "block bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 text-xs py-3 px-4 rounded-lg font-bold";
                            statusDiv.textContent = "QR Code Resepsionis berhasil dipindai. Silakan lengkapi biodata kunjungan Anda di form.";
                        }
                    }, 1500);
                });
            }

            // Guest Book Form Submission
            const guestBookForm = document.getElementById('guest-book-form');
            if (guestBookForm) {
                guestBookForm.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    const formData = new FormData(guestBookForm);
                    const statusDiv = document.getElementById('guest-book-status');
                    const submitBtn = guestBookForm.querySelector('button[type="submit"]');

                    submitBtn.disabled = true;
                    submitBtn.innerHTML = 'Mengirim...';

                    try {
                        const response = await fetch("{{ route('api.guest-book.store') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: formData
                        });
                        const data = await response.json();

                        submitBtn.disabled = false;
                        submitBtn.innerHTML = 'Kirim Kehadiran';

                        if (response.ok) {
                            statusDiv.className = "block bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 text-xs py-3 px-4 rounded-lg font-bold";
                            statusDiv.textContent = data.message || 'Kehadiran Anda berhasil disimpan!';
                            guestBookForm.reset();
                            fetchRecentVisitors();
                        } else {
                            throw new Error(data.message || 'Gagal menyimpan.');
                        }
                    } catch (err) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = 'Kirim Kehadiran';
                        statusDiv.className = "block bg-rose-500/10 text-rose-700 border border-rose-500/20 text-xs py-3 px-4 rounded-lg font-bold";
                        statusDiv.textContent = err.message;
                    }
                });
            }

            // Contact Us Form Submission
            const contactForm = document.getElementById('contact-us-form');
            if (contactForm) {
                contactForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    const statusDiv = document.getElementById('contact-status-div');
                    const submitBtn = contactForm.querySelector('button[type="submit"]');

                    submitBtn.disabled = true;
                    submitBtn.innerHTML = 'Mengirim...';

                    setTimeout(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = 'Kirim Pertanyaan';
                        statusDiv.className = "block bg-emerald-500/10 text-emerald-600 dark:text-emerald-450 border border-emerald-500/20 text-[10px] p-2.5 rounded font-bold mb-3";
                        statusDiv.textContent = "Pesan Anda berhasil dikirim! Tim kami akan segera menghubungi Anda melalui email.";
                        statusDiv.classList.remove('hidden');
                        contactForm.reset();
                    }, 1200);
                });
            }
        });

        // Ajax Certificate Verification
        const verifyForm = document.getElementById('verify-form');
        if (verifyForm) {
            verifyForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const num = document.getElementById('verify-number').value;
                const submitBtn = document.getElementById('btn-verify-submit');
                const resultContainer = document.getElementById('verify-result-container');
                const errorBox = document.getElementById('verify-error-box');
                const certBox = document.getElementById('verify-cert-box');

                resultContainer.classList.remove('hidden');
                errorBox.classList.add('hidden');
                certBox.classList.add('hidden');

                try {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = 'Mencari...';

                    const response = await fetch(`/api/verify-certificate?number=${encodeURIComponent(num)}`);
                    const data = await response.json();

                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Cari Data';

                    if (!response.ok) {
                        throw new Error(data.message || 'Sertifikat tidak ditemukan.');
                    }

                    const c = data.certificate;
                    document.getElementById('v-cert-name').textContent = c.name;
                    document.getElementById('v-cert-nik').textContent = c.nik;
                    document.getElementById('v-cert-program').textContent = c.program;
                    document.getElementById('v-cert-number').textContent = c.number;
                    document.getElementById('v-cert-date').textContent = c.date;

                    certBox.classList.remove('hidden');
                } catch (error) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Cari Data';
                    errorBox.classList.remove('hidden');
                    document.getElementById('verify-error-msg').textContent = error.message;
                }
            });
        }

        // AJAX ENROLLMENT PORTAL LOGIC
        const lForm = document.getElementById('landing-enrollment-form');
        const lOtpSection = document.getElementById('landing-otp-section');
        const lOtpInput = document.getElementById('landing-otp-code-input');
        const lOtpDebug = document.getElementById('landing-otp-debug');
        const btnLResendOtp = document.getElementById('btn-landing-resend-otp');
        const lTimerSpan = document.getElementById('landing-otp-timer');
        const lSubmitBtn = document.getElementById('btn-landing-enroll-submit');

        let lCountdown = null;

        function startLCountdown() {
            let sec = 60;
            btnLResendOtp.disabled = true;
            lTimerSpan.textContent = sec;
            clearInterval(lCountdown);
            lCountdown = setInterval(() => {
                sec--;
                lTimerSpan.textContent = sec;
                if (sec <= 0) {
                    clearInterval(lCountdown);
                    btnLResendOtp.disabled = false;
                    btnLResendOtp.innerHTML = 'Resend OTP';
                } else {
                    btnLResendOtp.innerHTML = `Resend (${sec}s)`;
                }
            }, 1000);
        }

        async function sendLOtpRequest(email, csrf) {
            const res = await fetch("{{ route('enroll.send-otp') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrf
                },
                body: JSON.stringify({
                    email: email
                })
            });
            const data = await res.json();
            if (!res.ok) {
                throw new Error(data.message || 'Gagal mengirim OTP.');
            }
            return data;
        }

        btnLResendOtp.addEventListener('click', async () => {
            const email = document.getElementById('landing-enroll-email').value;
            const csrf = document.querySelector('input[name="_token"]').value;
            if (!email) return alert('Email wajib diisi.');

            try {
                btnLResendOtp.disabled = true;
                btnLResendOtp.innerHTML = 'Resending...';
                const data = await sendLOtpRequest(email, csrf);
                alert(data.message || 'OTP berhasil dikirim.');
                startLCountdown();
                if (data.debug_code) {
                    lOtpDebug.classList.remove('hidden');
                    lOtpDebug.innerHTML = `DEBUG OTP: ${data.debug_code}`;
                }
            } catch (e) {
                alert(e.message);
                btnLResendOtp.disabled = false;
                btnLResendOtp.innerHTML = 'Resend OTP';
            }
        });

        lForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const errBox = document.getElementById('landing-form-errors');
            errBox.classList.add('hidden');
            errBox.innerHTML = '';

            const csrf = document.querySelector('input[name="_token"]').value;
            const email = document.getElementById('landing-enroll-email').value;

            if (lOtpSection.classList.contains('hidden')) {
                try {
                    lSubmitBtn.disabled = true;
                    lSubmitBtn.innerHTML = 'Mengirim OTP...';
                    const data = await sendLOtpRequest(email, csrf);

                    lOtpSection.classList.remove('hidden');
                    lOtpInput.required = true;
                    lSubmitBtn.disabled = false;
                    lSubmitBtn.innerHTML = 'Verifikasi &amp; Konfirmasi Pendaftaran';
                    startLCountdown();
                    if (data.debug_code) {
                        lOtpDebug.classList.remove('hidden');
                        lOtpDebug.innerHTML = `DEBUG OTP: ${data.debug_code}`;
                    }
                } catch (err) {
                    lSubmitBtn.disabled = false;
                    lSubmitBtn.innerHTML = 'Kirim Pendaftaran &amp; Generate OTP';
                    errBox.classList.remove('hidden');
                    errBox.innerHTML = `<p>• ${err.message}</p>`;
                }
                return;
            }

            const formData = new FormData(lForm);
            try {
                lSubmitBtn.disabled = true;
                lSubmitBtn.innerHTML = 'Memproses Pendaftaran...';

                const response = await fetch(lForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrf
                    }
                });
                const data = await response.json();

                if (!response.ok) {
                    if (data.errors) {
                        errBox.classList.remove('hidden');
                        Object.values(data.errors).forEach(errArray => {
                            errArray.forEach(err => {
                                const p = document.createElement('p');
                                p.innerHTML = `• ${err}`;
                                errBox.appendChild(p);
                            });
                        });
                    } else {
                        throw new Error(data.message || 'Terjadi kesalahan.');
                    }
                    lSubmitBtn.disabled = false;
                    lSubmitBtn.innerHTML = 'Verifikasi &amp; Konfirmasi Pendaftaran';
                    return;
                }

                // Success
                document.getElementById('landing-cert-name').textContent = data.enrollment.name.toUpperCase();
                document.getElementById('landing-cert-number').textContent = 'UNPAID (Pending Payment)';

                lForm.reset();
                lOtpSection.classList.add('hidden');
                lOtpInput.required = false;
                lSubmitBtn.disabled = false;
                lSubmitBtn.innerHTML = 'Kirim Pendaftaran &amp; Generate OTP';

                lForm.classList.add('hidden');
                document.getElementById('landing-enrollment-success-card').classList.remove('hidden');

                document.getElementById('btn-landing-reset-form').onclick = () => {
                    document.getElementById('landing-enrollment-success-card').classList.add('hidden');
                    lForm.classList.remove('hidden');
                };
            } catch (err) {
                lSubmitBtn.disabled = false;
                lSubmitBtn.innerHTML = 'Verifikasi &amp; Konfirmasi Pendaftaran';
                alert(err.message);
            }
        });
    </script>
    @endsection