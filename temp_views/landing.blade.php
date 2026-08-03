@extends('layouts.app')

@section('content')
    <!-- Alert Messages -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 rounded-xl text-sm flex items-center gap-3 animate-fade-in shadow-sm">
            <span>✓</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-rose-500/10 border border-rose-500/20 text-rose-600 dark:text-rose-400 rounded-xl text-sm flex items-center gap-3 animate-fade-in shadow-sm">
            <span>✗</span>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Section: Beranda -->
    <section id="sec-beranda" class="tab-content block animate-fade-in relative">
        <!-- Ambient Background Glow Orb -->
        <div class="absolute -top-20 -left-20 w-80 h-80 rounded-full bg-blue-600/10 dark:bg-blue-500/25 blur-3xl pointer-events-none animate-soft-pulse"></div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center py-6 relative z-10">
            <div class="lg:col-span-7 flex flex-col items-start">
                <span class="inline-flex items-center gap-2 bg-blue-600/10 text-blue-700 dark:text-blue-300 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-wider mb-6 border border-blue-600/20 shadow-sm relative overflow-hidden group">
                    <span class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/30 to-transparent -translate-x-full animate-shine"></span>
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-600 animate-ping"></span>
                    Lembaga Pelatihan Kerja Terakreditasi
                </span>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight mb-6 tracking-tight text-slate-900 dark:text-white font-heading">
                    <span class="bg-gradient-to-r from-blue-800 via-indigo-650 to-sky-600 dark:from-blue-400 dark:via-indigo-400 dark:to-sky-400 bg-clip-text text-transparent drop-shadow-[0_2px_15px_rgba(59,130,246,0.18)] animate-gradient-flow">
                        {!! e($heroTitle) !!}
                    </span>
                </h1>
                <p class="text-slate-605 dark:text-slate-400 text-base sm:text-lg mb-8 max-w-xl leading-relaxed">
                    {{ $heroSubtitle }}
                </p>
                <div class="flex flex-wrap gap-4">
                    <button class="bg-gradient-to-r from-blue-700 to-sky-600 text-white font-bold py-3.5 px-7 rounded-lg shadow-lg shadow-blue-700/20 hover:brightness-110 transition-all duration-300 flex items-center gap-2 text-xs uppercase tracking-wider" id="explore-programs-btn">
                        Jelajahi Program
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
                    
                    <!-- Flow Preview (no icons, numbers only) -->
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
                @endif</div>
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
    </section>

    <!-- Section: Profil Lembaga -->
    <section id="sec-profil" class="tab-content py-20 border-t border-slate-200/60 dark:border-slate-800/40 animate-fade-in">
        <div class="max-w-3xl mx-auto text-center mb-12">
            <h2 class="text-3xl font-black mb-4 font-heading text-slate-900 dark:text-white tracking-tight flex items-center justify-center gap-3">
                Profil Lembaga LPK-MI
            </h2>
            <p class="text-slate-600 dark:text-slate-400 text-base leading-relaxed">
                Mengenal lebih dekat legalitas resmi hukum, visi misi strategis, dan tim pengelola di balik Lembaga Pelatihan Kerja Manajemen Industri.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            <!-- Left Card: Visi Misi -->
            <div class="glass-card rounded-2xl p-6 sm:p-8 border border-slate-200 dark:border-slate-800">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-6 border-b border-slate-100 dark:border-white/5 pb-3">Visi & Misi LPK-MI</h3>
                
                <div class="space-y-6">
                    <div>
                        <span class="text-[10px] font-black text-blue-700 dark:text-blue-400 uppercase tracking-wider block mb-2">Visi Lembaga</span>
                        <p class="text-slate-700 dark:text-slate-300 text-sm leading-relaxed font-semibold">
                            "Menjadi lembaga pelatihan kerja manajemen industri terdepan yang menghasilkan sumber daya manusia kompeten, berkarakter mulia, dan siap bersaing di pasar kerja global."
                        </p>
                    </div>
                    
                    <div class="w-full h-px bg-slate-200 dark:bg-white/5"></div>
                    
                    <div>
                        <span class="text-[10px] font-black text-blue-700 dark:text-blue-400 uppercase tracking-wider block mb-2">Misi Utama</span>
                        <ul class="space-y-2.5 text-slate-600 dark:text-slate-400 text-xs">
                            <li class="flex gap-2">
                                <span class="text-blue-700 dark:text-blue-400 font-bold shrink-0">•</span>
                                <span>Menyelenggarakan program pelatihan kerja berbasis kompetensi (CBT) yang selaras dengan kebutuhan dunia usaha dan dunia industri (DUDI).</span>
                            </li>
                            <li class="flex gap-2">
                                <span class="text-blue-700 dark:text-blue-400 font-bold shrink-0">•</span>
                                <span>Menyediakan fasilitas praktik berstandar modern guna mengoptimalkan asimilasi keterampilan kerja operasional asesi.</span>
                            </li>
                            <li class="flex gap-2">
                                <span class="text-blue-700 dark:text-blue-400 font-bold shrink-0">•</span>
                                <span>Memfasilitasi pengujian kompetensi nasional terakreditasi melalui kemitraan strategis dengan LSPMI.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Right Card: Legalitas & Akreditasi -->
            <div class="glass-card rounded-2xl p-6 sm:p-8 border border-slate-200 dark:border-slate-800 flex flex-col justify-between">
                <div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-6 border-b border-slate-100 dark:border-white/5 pb-3">Legalitas & Akreditasi Resmi</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-xs leading-relaxed mb-6">
                        Sebagai bukti kepatuhan administrasi negara, LPK-MI beroperasi secara legal di bawah naungan Kementerian Ketenagakerjaan RI dengan dokumen perizinan berikut:
                    </p>
                    
                    <div class="space-y-3.5">
                        <div class="flex justify-between items-center py-2 border-b border-slate-100 dark:border-white/5 text-xs">
                            <span class="text-slate-400 font-semibold">Nomor NIB (OSS)</span>
                            <span class="font-mono text-slate-800 dark:text-slate-200 font-bold">9120300481234</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-slate-100 dark:border-white/5 text-xs">
                            <span class="text-slate-400 font-semibold">Izin Disnaker</span>
                            <span class="font-mono text-slate-800 dark:text-slate-200 font-bold">560/124-LPK/Disnaker/2026</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-slate-100 dark:border-white/5 text-xs">
                            <span class="text-slate-400 font-semibold">Status Akreditasi</span>
                            <span class="text-emerald-700 dark:text-emerald-450 font-bold bg-emerald-500/10 px-2.5 py-0.5 rounded text-[10px]">TERAKREDITASI KEMNAKER</span>
                        </div>
                        <div class="flex justify-between items-center py-2 text-xs">
                            <span class="text-slate-400 font-semibold">Wilayah Kerja</span>
                            <span class="text-slate-800 dark:text-slate-200 font-semibold">DKI Jakarta & Nasional</span>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-600/5 dark:bg-blue-500/10 border border-blue-600/10 rounded-xl p-3 flex gap-2.5 mt-6 shadow-sm">
                    <p class="text-[10px] text-blue-800 dark:text-blue-250 leading-relaxed font-semibold">
                        <strong>Verifikasi Disnaker:</strong> Dokumen izin fisik selalu dipajang di lobi utama kantor LPK-MI dan dapat diverifikasi langsung oleh asesi atau auditor Kemnaker.
                    </p>
                </div>
            </div>
        </div>

        <!-- Team & Instructors Grid -->
        <div class="glass-card rounded-2xl p-6 sm:p-8 border border-slate-200 dark:border-slate-800">
            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Tim Manajemen & Instruktur Ahli</h3>
            <p class="text-slate-600 dark:text-slate-400 text-xs mb-8">Setiap pengajar di LPK-MI merupakan praktisi profesional bersertifikat kompetensi BNSP.</p>
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <!-- Person 1 -->
                <div class="bg-white/20 dark:bg-slate-900/40 border border-slate-200 dark:border-slate-800 rounded-xl p-5 text-center shadow-sm">
                    <div class="w-14 h-14 rounded-full bg-blue-700/10 text-blue-700 dark:text-blue-400 border border-blue-700/20 flex items-center justify-center text-lg font-black mx-auto mb-4">
                        DF
                    </div>
                    <h4 class="font-bold text-sm text-slate-900 dark:text-white">Dr. H. Ahmad Fauzi, M.T.</h4>
                    <span class="text-[9px] text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider block mt-1">Direktur LPK-MI</span>
                </div>
                
                <!-- Person 2 -->
                <div class="bg-white/20 dark:bg-slate-900/40 border border-slate-200 dark:border-slate-800 rounded-xl p-5 text-center shadow-sm">
                    <div class="w-14 h-14 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 flex items-center justify-center text-lg font-black mx-auto mb-4">
                        RH
                    </div>
                    <h4 class="font-bold text-sm text-slate-900 dark:text-white">Rahmat Hidayat, S.Kom.</h4>
                    <span class="text-[9px] text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider block mt-1">Kepala Instruktur IT</span>
                </div>
                
                <!-- Person 3 -->
                <div class="bg-white/20 dark:bg-slate-900/40 border border-slate-200 dark:border-slate-800 rounded-xl p-5 text-center shadow-sm">
                    <div class="w-14 h-14 rounded-full bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20 flex items-center justify-center text-lg font-black mx-auto mb-4">
                        IH
                    </div>
                    <h4 class="font-bold text-sm text-slate-900 dark:text-white">Ir. Hermawan, M.M.</h4>
                    <span class="text-[9px] text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider block mt-1">Instruktur Senior Manajemen</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Program Pelatihan -->
    <section id="sec-program" class="tab-content py-20 border-t border-slate-200/60 dark:border-slate-800/40 animate-fade-in">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <h2 class="text-3xl font-black mb-4 font-heading text-slate-900 dark:text-white tracking-tight">Program Pelatihan Unggulan</h2>
            <p class="text-slate-500 dark:text-slate-400 text-base">Pelatihan intensif terstruktur yang disesuaikan dengan skema uji kompetensi LSPMI.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($programs as $prog)
                <div class="glass-card rounded-2xl p-6 flex flex-col justify-between border border-slate-200 dark:border-slate-800" id="card-{{ $prog->id }}">
                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-xs font-bold uppercase text-sky-700 dark:text-sky-400 bg-sky-500/10 dark:bg-sky-500/5 px-2.5 py-1 rounded-md border border-sky-300 dark:border-sky-550/15">{{ $prog->category }}</span>
                            <span class="text-xs text-slate-500 dark:text-slate-400 font-semibold">{{ $prog->duration }}</span>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3 hover:text-blue-700 dark:hover:text-blue-400 transition-colors">{{ $prog->title }}</h3>
                        <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed mb-6">{{ $prog->description }}</p>
                        
                        <ul class="space-y-2 mb-6">
                            @foreach($prog->benefits as $b)
                                <li class="text-xs text-slate-500 dark:text-slate-400 flex items-center">
                                    <span class="text-blue-700 dark:text-blue-400 mr-2 font-bold">•</span> {{ $b }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <div class="flex justify-between items-center border-t border-slate-200 dark:border-slate-800 pt-5 mt-auto">
                        <div class="text-xl font-extrabold text-slate-900 dark:text-white font-heading">
                            {{ $prog->price }} <span class="text-[10px] text-slate-500 dark:text-slate-400 font-normal">/Peserta</span>
                        </div>
                        <button class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-2.5 px-4 rounded-lg text-xs uppercase tracking-wider transition-all shadow-md shadow-blue-700/10" onclick="selectProgramAndRegister('{{ $prog->id }}')">
                            Daftar Kelas
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </section>



    <!-- Section: Fasilitas -->
    <section id="sec-fasilitas" class="tab-content py-20 border-t border-slate-200/60 dark:border-slate-800/40 animate-fade-in">
        <div class="max-w-3xl mx-auto text-center mb-12">
            <h2 class="text-3xl font-black mb-4 font-heading text-slate-900 dark:text-white tracking-tight flex items-center justify-center gap-3">
                Fasilitas & Sarana Pembelajaran
            </h2>
            <p class="text-slate-605 dark:text-slate-400 text-base leading-relaxed">
                Kami menyediakan sarana fisik pendukung pelatihan berkualitas tinggi untuk menjamin lingkungan praktik kerja yang maksimal dan nyaman.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Facility 1 -->
            <div class="glass-card rounded-2xl p-6 border border-slate-200 dark:border-slate-800 flex gap-4 items-start">
                <div class="w-12 h-12 rounded-xl bg-blue-700/10 text-blue-700 dark:text-blue-400 border border-blue-700/20 flex items-center justify-center text-xs font-black shrink-0 shadow-sm">
                    LAB
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 dark:text-white text-base mb-1">Laboratorium Komputer Multimedia</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-xs leading-relaxed">
                        Dilengkapi dengan 30 Unit PC berspesifikasi Intel Core i7, pendingin ruangan (AC) penuh, konektivitas LAN Gigabit, serta proyektor HD interaktif untuk menunjang praktik IT terpadu.
                    </p>
                </div>
            </div>

            <!-- Facility 2 -->
            <div class="glass-card rounded-2xl p-6 border border-slate-200 dark:border-slate-800 flex gap-4 items-start">
                <div class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/20 flex items-center justify-center text-xs font-black shrink-0 shadow-sm">
                    CLS
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 dark:text-white text-base mb-1">Ruang Teori & Diskusi Kelompok</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-xs leading-relaxed">
                        Ruang kelas teori ergonomis berkapasitas 25 orang asesi dengan dukungan papan tulis kaca, sound system nirkabel, dan pencahayaan optimal untuk aktivitas pemaparan materi ajar.
                    </p>
                </div>
            </div>

            <!-- Facility 3 -->
            <div class="glass-card rounded-2xl p-6 border border-slate-200 dark:border-slate-800 flex gap-4 items-start">
                <div class="w-12 h-12 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20 flex items-center justify-center text-xs font-black shrink-0 shadow-sm">
                    SIM
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 dark:text-white text-base mb-1">Simulator Logistik & Rantai Pasok</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-xs leading-relaxed">
                        Ruang praktikum administrasi logistik yang dilengkapi simulator alur inventory fisik dan sistem perangkat lunak Enterprise Resource Planning (ERP) berlisensi pendidikan.
                    </p>
                </div>
            </div>

            <!-- Facility 4 -->
            <div class="glass-card rounded-2xl p-6 border border-slate-200 dark:border-slate-800 flex gap-4 items-start">
                <div class="w-12 h-12 rounded-xl bg-purple-500/10 text-purple-600 dark:text-purple-400 border border-purple-500/20 flex items-center justify-center text-xs font-black shrink-0 shadow-sm">
                    WIFI
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 dark:text-white text-base mb-1">Perpustakaan & Area Diskusi Bebas</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-xs leading-relaxed">
                        Koleksi buku panduan akademik fisik, akses internet nirkabel (Wi-Fi) berkecepatan 100 Mbps, serta area bersantai semi-outdoor yang dirancang nyaman untuk berkolaborasi.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Galeri -->
    <section id="sec-galeri" class="tab-content py-20 border-t border-slate-200/60 dark:border-slate-800/40 animate-fade-in">
        <div class="max-w-3xl mx-auto text-center mb-12">
            <h2 class="text-3xl font-black mb-4 font-heading text-slate-900 dark:text-white tracking-tight flex items-center justify-center gap-3">
                {{ $settings['gallery_title'] ?? 'Galeri & Dokumentasi Kegiatan' }}
            </h2>
            <p class="text-slate-605 dark:text-slate-400 text-base leading-relaxed">
                {{ $settings['gallery_subtitle'] ?? 'Melihat lebih dekat lingkungan belajar, ujian sertifikasi, dan aktivitas pengembangan kompetensi profesional asesi di LPK-MI.' }}
            </p>
        </div>

        @php
            $defaultGallery = [
                1 => [
                    'category' => 'Pelatihan IT',
                    'title' => 'Kelas Praktik Pemrograman',
                    'desc' => 'Sesi praktik coding asesi menggunakan framework Laravel, database SQL, dan arsitektur web modern di lab komputer utama.',
                    'gradient' => 'from-blue-700 to-sky-500',
                    'svg' => '<svg class="w-16 h-16 opacity-80" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75L22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3l-4.5 16.5"></path></svg>'
                ],
                2 => [
                    'category' => 'Uji Sertifikasi',
                    'title' => 'Evaluasi Kompetensi Mandiri',
                    'desc' => 'Momentum ujian akhir kelulusan asesi untuk menguji kelayakan sebelum pendaftaran uji kompetensi nasional di LSPMI.',
                    'gradient' => 'from-sky-600 to-emerald-500',
                    'svg' => '<svg class="w-16 h-16 opacity-80" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"></path></svg>'
                ],
                3 => [
                    'category' => 'Manajemen Industri',
                    'title' => 'Pelatihan Manajemen & Leadership',
                    'desc' => 'Sesi pembekalan soft-skills, kepemimpinan kerja, dan perencanaan alur rantai pasok industri untuk asesi tingkat mahir.',
                    'gradient' => 'from-indigo-700 to-purple-500',
                    'svg' => '<svg class="w-16 h-16 opacity-80" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0h.5m-10.5 0h.5m-2.25-10.5h12"></path></svg>'
                ],
                4 => [
                    'category' => 'Kemitraan',
                    'title' => 'Penandatanganan MoU Industri',
                    'desc' => 'Kolaborasi penyaluran lulusan kerja dengan PT Industri Kreatif Global guna menyerap alumni terbaik LPK-MI.',
                    'gradient' => 'from-blue-700 to-emerald-600',
                    'svg' => '<svg class="w-16 h-16 opacity-80" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path></svg>'
                ],
                5 => [
                    'category' => 'Studi Lapangan',
                    'title' => 'Kunjungan Industri & Logistik',
                    'desc' => 'Studi banding langsung para asesi LPK-MI ke gudang distribusi logistik modern milik mitra industri nasional.',
                    'gradient' => 'from-amber-600 to-rose-500',
                    'svg' => '<svg class="w-16 h-16 opacity-80" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h5.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-7.5 2.727m0 15.273V5.727m0 0L5.25 8.182m0 0v12.818"></path></svg>'
                ],
                6 => [
                    'category' => 'Kelulusan',
                    'title' => 'Penyerahan Sertifikat Kelulusan',
                    'desc' => 'Prosesi wisuda dan penyerahan lembar sertifikat resmi dari LPK-MI kepada asesi yang dinyatakan kompeten di akhir masa ajar.',
                    'gradient' => 'from-indigo-800 to-blue-600',
                    'svg' => '<svg class="w-16 h-16 opacity-80" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.62 48.62 0 0112 20.904a48.62 48.62 0 017.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A5.905 5.905 0 018 3.443m4.286 6.704a50.593 50.593 0 005.952-1.854 5.905 5.905 0 014.762-6.592M12 10.5V21m-6.425-4.5A48.647 48.647 0 0112 12.75a48.647 48.647 0 016.425 3.75"></path></svg>'
                ]
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @for($i = 1; $i <= 6; $i++)
                @php
                    $itemCategory = $settings["gallery_item_{$i}_category"] ?? $defaultGallery[$i]['category'];
                    $itemTitle = $settings["gallery_item_{$i}_title"] ?? $defaultGallery[$i]['title'];
                    $itemDesc = $settings["gallery_item_{$i}_desc"] ?? $defaultGallery[$i]['desc'];
                    $itemImage = $settings["gallery_item_{$i}_image"] ?? null;
                @endphp
                <div class="glass-card rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col hover:scale-[1.02] transition-all">
                    @if($itemImage)
                        <div class="h-44 w-full relative">
                            <img src="{{ asset('storage/' . $itemImage) }}" class="w-full h-full object-cover" alt="{{ $itemTitle }}">
                        </div>
                    @else
                        <div class="h-44 w-full bg-gradient-to-br {{ $defaultGallery[$i]['gradient'] }} flex items-center justify-center text-white relative">
                            {!! $defaultGallery[$i]['svg'] !!}
                        </div>
                    @endif
                    <div class="p-5">
                        <span class="text-[9px] font-black text-blue-700 dark:text-blue-400 uppercase tracking-wider block mb-2">{{ $itemCategory }}</span>
                        <h3 class="font-bold text-slate-900 dark:text-white text-sm mb-1">{{ $itemTitle }}</h3>
                        <p class="text-slate-600 dark:text-slate-400 text-[11px] leading-relaxed">
                            {{ $itemDesc }}
                        </p>
                    </div>
                </div>
            @endfor
        </div>
    </section>

    <!-- Section: Karir & Alumni -->
    <section id="sec-karir" class="tab-content py-20 border-t border-slate-200/60 dark:border-slate-800/40 animate-fade-in">
        <div class="max-w-3xl mx-auto text-center mb-12">
            <h2 class="text-3xl font-black mb-4 font-heading text-slate-900 dark:text-white tracking-tight flex items-center justify-center gap-3">
                Karir & Penyaluran Kerja Lulusan
            </h2>
            <p class="text-slate-600 dark:text-slate-400 text-base leading-relaxed">
                LPK-MI berkomitmen menyalurkan alumni secara langsung melalui program jejaring kemitraan rekrutmen bersama puluhan perusahaan nasional.
            </p>
        </div>

        <!-- Career Stats Counters -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-12">
            <div class="glass-card rounded-2xl p-6 text-center border border-slate-200 dark:border-slate-800 shadow-sm">
                <span class="block text-3xl font-black bg-gradient-to-r from-blue-700 to-sky-600 dark:from-blue-400 dark:to-sky-300 bg-clip-text text-transparent font-heading">95%</span>
                <span class="text-[10px] text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider mt-1 block">Tingkat Penyerapan Kerja</span>
            </div>
            
            <div class="glass-card rounded-2xl p-6 text-center border border-slate-200 dark:border-slate-800 shadow-sm">
                <span class="block text-3xl font-black bg-gradient-to-r from-blue-700 to-sky-600 dark:from-blue-400 dark:to-sky-300 bg-clip-text text-transparent font-heading">1.200+</span>
                <span class="text-[10px] text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider mt-1 block">Alumni Tersalurkan Kerja</span>
            </div>
            
            <div class="glass-card rounded-2xl p-6 text-center border border-slate-200 dark:border-slate-800 shadow-sm">
                <span class="block text-3xl font-black bg-gradient-to-r from-blue-700 to-sky-600 dark:from-blue-400 dark:to-sky-300 bg-clip-text text-transparent font-heading">45+</span>
                <span class="text-[10px] text-slate-500 dark:text-slate-400 font-bold uppercase tracking-wider mt-1 block">Mitra Perusahaan Aktif</span>
            </div>
        </div>

        <!-- Mock Job Board -->
        <div class="glass-card rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm">
            <div class="p-6 border-b border-slate-200 dark:border-slate-800 bg-white/30 dark:bg-slate-900/30">
                <h3 class="font-bold text-slate-900 dark:text-white text-base">Lowongan Kerja Mitra Eksklusif LPK-MI</h3>
                <p class="text-slate-500 dark:text-slate-400 text-xs mt-1">Hanya ditujukan untuk pendaftaran peserta didik dan asesi LPK-MI yang memiliki sertifikat lulus.</p>
            </div>
            
            <div class="premium-table-container border-none shadow-none overflow-x-auto w-full">
                <table class="premium-table">
                    <thead>
                        <tr>
                            <th>Posisi Lowongan</th>
                            <th>Perusahaan Mitra</th>
                            <th>Kebutuhan Keahlian</th>
                            <th>Lokasi Penempatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                        <tr>
                            <td class="font-bold text-slate-900 dark:text-white">Junior Web Programmer</td>
                            <td>PT Industri Kreatif Global</td>
                            <td>PHP Laravel, Tailwind CSS, Javascript</td>
                            <td>Jakarta Selatan</td>
                            <td><span class="text-blue-700 dark:text-blue-400 font-bold text-xs cursor-pointer hover:underline">Detail Lamar</span></td>
                        </tr>
                        <tr>
                            <td class="font-bold text-slate-900 dark:text-white">Staf Administrasi & Data Logistik</td>
                            <td>PT Logistik Trans Nusantara</td>
                            <td>Manajemen Inventory, Ms. Excel, ERP</td>
                            <td>Surabaya Utara</td>
                            <td><span class="text-blue-700 dark:text-blue-400 font-bold text-xs cursor-pointer hover:underline">Detail Lamar</span></td>
                        </tr>
                        <tr>
                            <td class="font-bold text-slate-900 dark:text-white">Supervisor Operasional Pabrik</td>
                            <td>PT Manufaktur Modern Utama</td>
                            <td>Manajemen Industri, K3, Ms. Project</td>
                            <td>Cikarang, Bekasi</td>
                            <td><span class="text-blue-700 dark:text-blue-400 font-bold text-xs cursor-pointer hover:underline">Detail Lamar</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Section: Kontak -->
    <section id="sec-kontak" class="tab-content py-20 border-t border-slate-200/60 dark:border-slate-800/40 animate-fade-in">
        <div class="max-w-3xl mx-auto text-center mb-12">
            <h2 class="text-3xl font-black mb-4 font-heading text-slate-900 dark:text-white tracking-tight flex items-center justify-center gap-3">
                Hubungi Kami & Layanan Informasi
            </h2>
            <p class="text-slate-606 dark:text-slate-400 text-base leading-relaxed">
                Mempunyai pertanyaan seputar biaya kelas, pendaftaran, beasiswa, atau kebutuhan audit Disnaker? Staf kami siap melayani Anda.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch">
            <!-- Left: Contact Details Card -->
            <div class="glass-card rounded-2xl p-6 sm:p-8 border border-slate-200 dark:border-slate-800 flex flex-col justify-between">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6 border-b border-slate-100 dark:border-white/5 pb-3">Informasi Kantor Pusat</h3>
                    
                    <div class="space-y-5 text-sm text-slate-700 dark:text-slate-300">
                        <div class="flex gap-3">
                            <span class="font-black text-blue-700 dark:text-blue-400 w-5 shrink-0">[A]</span>
                            <p class="text-xs leading-relaxed">
                                <strong>Alamat Fisik LPK:</strong><br>
                                Jl. Pembangunan Raya No. 45, Blok C-3, Kawasan Industri Manajemen, Kebayoran Baru, Jakarta Selatan, 12150.
                            </p>
                        </div>
                        
                        <div class="flex gap-3">
                            <span class="font-black text-emerald-600 dark:text-emerald-400 w-5 shrink-0">[W]</span>
                            <p class="text-xs">
                                <strong>WhatsApp Hotline:</strong><br>
                                +62 812-3456-7890 (Administrasi Pelatihan & Izin Magang)
                            </p>
                        </div>
                        
                        <div class="flex gap-3">
                            <span class="font-black text-purple-600 dark:text-purple-400 w-5 shrink-0">[E]</span>
                            <p class="text-xs">
                                <strong>E-mail Layanan Informasi:</strong><br>
                                info@lpk-mi.com / helpdesk@lpk-mi.com
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-3.5 flex gap-2.5 mt-8 shadow-sm">
                    <p class="text-[10px] text-slate-500 dark:text-slate-400 leading-relaxed font-semibold">
                        <strong>Jam Layanan Administrasi:</strong><br>
                        Senin s.d. Jumat pukul 08.00 - 17.00 WIB | Sabtu pukul 08.00 - 12.00 WIB (Minggu Libur).
                    </p>
                </div>
            </div>

            <!-- Right: Mock Google Maps View -->
            <div class="glass-card rounded-2xl p-6 border border-slate-200 dark:border-slate-800 flex flex-col justify-between bg-white/40 dark:bg-slate-900/40">
                <div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Peta Lokasi & Denah Fisik</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-xs leading-relaxed mb-6">
                        Navigasikan kendaraan Anda langsung menggunakan rute GPS yang telah terintegrasi dengan Google Maps.
                    </p>
                    
                    <!-- Fake Maps Graphic Grid -->
                    <div class="w-full h-48 bg-slate-200 dark:bg-slate-950/60 rounded-xl border border-slate-300 dark:border-slate-800/80 flex items-center justify-center text-center relative overflow-hidden shadow-inner">
                        <div class="absolute inset-0 opacity-20 dark:opacity-10 bg-[radial-gradient(#000_1px,transparent_1px)] [background-size:16px_16px]"></div>
                        <div class="relative z-10 flex flex-col items-center gap-2">
                            <span class="w-8 h-8 rounded-full bg-blue-700/10 text-blue-700 dark:text-blue-400 border border-blue-700/20 flex items-center justify-center text-xs font-black">
                                MAP
                            </span>
                            <span class="text-[10px] text-slate-600 dark:text-slate-400 font-bold uppercase tracking-wider">Kawasan LPK-MI Jakarta Selatan</span>
                        </div>
                    </div>
                </div>

                <a href="https://maps.google.com" target="_blank" class="w-full bg-gradient-to-r from-blue-700 to-sky-600 text-white font-bold py-3.5 px-6 rounded-lg text-center hover:brightness-110 shadow-lg shadow-blue-700/20 transition-all duration-300 text-xs uppercase tracking-wider mt-6">
                    Buka Google Maps Rute
                </a>
            </div>
        </div>
    </section>

    {{-- Role-based dashboards are now separate pages:
         Superadmin → /dashboard/superadmin
         Admin      → /dashboard/admin
         Asesor     → /dashboard/asesor
         Asesi      → /dashboard/asesi
    --}}
@endsection
