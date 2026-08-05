@extends('layouts.app')

@section('content')
    <!-- CSS and Styling Overrides for LPK Manajemen Pendidikan Islam -->
    <style>
        /* Hide the default layout footer */
        #pub-main-wrap > footer {
            display: none !important;
        }

        /* Color custom utilities */
        .text-mpi-blue { color: #155dfc; }
        .bg-mpi-blue { background-color: #155dfc; }
        .border-mpi-blue { border-color: #155dfc; }
        
        .btn-mpi {
            background-color: #155dfc;
            color: #ffffff;
            transition: all 0.3s ease;
        }
        .btn-mpi:hover {
            background-color: #084be3;
            transform: translateY(-1px);
        }

        /* Custom scroll offset */
        .scroll-mt-section {
            scroll-margin-top: 100px;
        }

        /* Laser Scanline animation */
        @keyframes scan {
            0% { top: 0%; }
            50% { top: 100%; }
            100% { top: 0%; }
        }
        .animate-scanline {
            animation: scan 3s linear infinite;
        }
    </style>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-6 mt-6">
            <div class="p-4 bg-blue-500/10 border border-blue-500/20 text-blue-600 dark:text-blue-400 rounded-xl text-sm flex items-center gap-3 animate-fade-in shadow-sm">
                <span>✓</span>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-6 mt-6">
            <div class="p-4 bg-rose-500/10 border border-rose-500/20 text-rose-600 dark:text-rose-400 rounded-xl text-sm flex items-center gap-3 animate-fade-in shadow-sm">
                <span>✗</span>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- ========================================== -->
    <!-- SECTION 1: HERO & WELCOME (sec-beranda)    -->
    <!-- ========================================== -->
    <section id="sec-beranda" class="tab-content block animate-fade-in scroll-mt-section py-12 md:py-20 bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800/60">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <!-- Hero Text -->
                <div class="lg:col-span-7 flex flex-col items-start text-left">
                    <span class="text-xs font-extrabold tracking-widest text-[#155dfc] uppercase mb-4">
                        HOME
                    </span>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black leading-tight mb-6 tracking-tight text-slate-900 dark:text-white font-heading font-extrabold">
                        Selamat Datang di LPK Manajemen Pendidikan Islam
                    </h1>
                    <p class="text-slate-600 dark:text-slate-400 text-base sm:text-lg mb-8 max-w-2xl leading-relaxed">
                        LPK Manajemen Pendidikan Islam merupakan salah satu Lembaga Penyelenggara Pemagangan Luar Negeri (Sending Organization - SO) yang berdiri sejak tahun 2012, dan telah menempatkan lebih dari 3,000 peserta di berbagai Perusahaan di Jepang.
                    </p>
                </div>
                
                <!-- Hero Illustration -->
                <div class="lg:col-span-5 flex justify-center items-center">
                    <svg viewBox="0 0 500 400" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto max-w-md mx-auto">
                        <circle cx="250" cy="200" r="160" fill="#eef2ff" class="dark:fill-blue-950/15" />
                        <circle cx="380" cy="120" r="40" fill="#ffe0cc" class="dark:fill-blue-900/10" opacity="0.6"/>
                        <path d="M100 280C100 220 150 180 180 180C160 220 140 260 100 280Z" fill="#155dfc" opacity="0.8"/>
                        <path d="M130 320C130 270 170 230 200 230C180 270 160 300 130 320Z" fill="#ea580c" opacity="0.9"/>
                        <path d="M380 280C380 220 330 180 300 180C320 220 340 260 380 280Z" fill="#155dfc" opacity="0.8"/>
                        <path d="M350 320C350 270 310 230 280 230C300 270 320 300 350 320Z" fill="#ea580c" opacity="0.9"/>
                        <circle cx="250" cy="120" r="24" fill="#ffdbca"/>
                        <path d="M226 120C226 95 274 95 274 120C274 125 226 125 226 120Z" fill="#2d3748"/>
                        <path d="M226 120C226 135 235 140 235 140L230 145" stroke="#2d3748" stroke-width="4"/>
                        <path d="M274 120C274 135 265 140 265 140L270 145" stroke="#2d3748" stroke-width="4"/>
                        <path d="M225 170C225 150 275 150 275 170V230H225V170Z" fill="#155dfc"/>
                        <path d="M240 150H260V170H240V150Z" fill="#ffdbca"/>
                        <path d="M220 235H280L290 255H210L220 235Z" fill="#718096"/>
                        <path d="M225 235V205H275V235" fill="#e2e8f0" stroke="#718096" stroke-width="2"/>
                        <path d="M235 212H265" stroke="#cbd5e0" stroke-width="2" stroke-linecap="round"/>
                        <path d="M235 218H265" stroke="#cbd5e0" stroke-width="2" stroke-linecap="round"/>
                        <path d="M225 180L205 215L225 230" stroke="#ffdbca" stroke-width="8" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                        <path d="M275 180L295 215L275 230" stroke="#ffdbca" stroke-width="8" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                        <path d="M180 270C180 250 220 240 250 240C280 240 320 250 320 270C320 290 290 300 250 300C210 300 180 290 180 270Z" fill="#1a202c"/>
                    </svg>
                </div>
            </div>
            
            <!-- Partners Logo row -->
            <div class="mt-16 pt-8 border-t border-slate-100 dark:border-slate-800/60 text-center">
                <p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-6">
                    Kami berkolaborasi dengan Asosiasi & Perusahaan Terpercaya Jepang
                </p>
                <div class="flex flex-wrap justify-center items-center gap-10 opacity-60 dark:opacity-40">
                    <svg class="h-8 w-auto" viewBox="0 0 120 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="20" cy="20" r="15" fill="#155dfc"/>
                        <path d="M45 15H60V20H45V15ZM45 25H65V30H45V25Z" fill="currentColor" class="text-slate-900 dark:text-white"/>
                    </svg>
                    <svg class="h-8 w-auto" viewBox="0 0 120 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 10H30L20 30L10 10Z" fill="#155dfc"/>
                        <rect x="40" y="15" width="40" height="6" fill="currentColor" class="text-slate-900 dark:text-white"/>
                        <rect x="40" y="25" width="25" height="6" fill="currentColor" class="text-slate-900 dark:text-white"/>
                    </svg>
                    <svg class="h-8 w-auto" viewBox="0 0 120 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="20" cy="20" r="12" stroke="currentColor" class="text-slate-900 dark:text-white" stroke-width="6"/>
                        <circle cx="20" cy="20" r="4" fill="#155dfc"/>
                        <path d="M45 15H65V30H45V15Z" fill="currentColor" class="text-slate-900 dark:text-white" opacity="0.8"/>
                    </svg>
                    <svg class="h-8 w-auto" viewBox="0 0 120 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="10" y="10" width="20" height="20" rx="4" fill="#155dfc"/>
                        <path d="M15 15L25 25M25 15L15 25" stroke="white" stroke-width="4"/>
                        <path d="M45 15H65V20H45V15Z" fill="currentColor" class="text-slate-900 dark:text-white"/>
                    </svg>
                    <svg class="h-8 w-auto" viewBox="0 0 120 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 20C10 12 17 5 25 5C33 5 40 12 40 20C40 28 33 35 25 35C17 35 10 28 10 20Z" stroke="#155dfc" stroke-width="4"/>
                        <path d="M20 20H30" stroke="currentColor" class="text-slate-900 dark:text-white" stroke-width="4"/>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 2: COMPARISON TABLE (sec-tentang)  -->
    <!-- ========================================== -->
    <section id="sec-tentang" class="tab-content block animate-fade-in scroll-mt-section py-20 bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800/60">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-xs font-extrabold tracking-widest text-[#155dfc] uppercase mb-3 block">Jalur Karir</span>
                <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white font-heading font-extrabold">
                    3 Jalur Berkarir di Jepang
                </h2>
                <p class="text-slate-500 dark:text-slate-400 text-sm mt-3 leading-relaxed">
                    Pahami rincian persyaratan dan perbandingan setiap program karir yang diselenggarakan oleh LPK Manajemen Pendidikan Islam.
                </p>
            </div>

            <!-- Comparison Table Container -->
            <div class="max-w-6xl mx-auto bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl overflow-hidden shadow-sm">
                <div class="overflow-x-auto w-full">
                    <table class="w-full min-w-[800px] border-collapse text-xs sm:text-sm text-left">
                        <thead>
                            <tr class="border-b border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/60 font-extrabold">
                                <th class="p-4 sm:p-6 font-bold text-slate-900 dark:text-white w-1/4">Kategori Perbandingan</th>
                                <th class="p-4 sm:p-6 font-bold text-slate-900 dark:text-white w-1/4">Peserta Magang (Ginou Jisshusei)</th>
                                <!-- Highlighted Column Header -->
                                <th class="p-4 sm:p-6 font-bold text-[#155dfc] w-1/4 bg-[#eef2ff] dark:bg-blue-950/15 border-x border-blue-200 dark:border-blue-900/30 relative">
                                    Visa Kerja Keahlian Khusus (Tokutei Ginou)
                                    <span class="absolute top-0 right-4 transform -translate-y-1/2 bg-[#155dfc] text-white text-[9px] uppercase font-black px-2.5 py-0.5 rounded-full tracking-wider shadow">Paling Diminati</span>
                                </th>
                                <th class="p-4 sm:p-6 font-bold text-slate-900 dark:text-white w-1/4">Program Internship (Internship)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800/80">
                            <!-- Row 1: Biaya -->
                            <tr class="align-top">
                                <td class="p-4 sm:p-6 font-bold text-slate-800 dark:text-slate-200 bg-white/50 dark:bg-slate-900/20">Biaya-biaya</td>
                                <td class="p-4 sm:p-6 space-y-2.5 text-slate-600 dark:text-slate-400 leading-relaxed font-semibold">
                                    <div class="flex items-start gap-2">
                                        <span class="text-[#155dfc] font-bold">✔</span>
                                        <span>Biaya pelatihan bahasa dan keterampilan sebelum keberangkatan ditanggung mandiri/dana talangan.</span>
                                    </div>
                                    <div class="flex items-start gap-2">
                                        <span class="text-[#155dfc] font-bold">✔</span>
                                        <span>Biaya pengurusan dokumen visa dan COE ditanggung perusahaan penerima.</span>
                                    </div>
                                </td>
                                <!-- Highlighted Column cell -->
                                <td class="p-4 sm:p-6 space-y-2.5 text-slate-600 dark:text-slate-400 leading-relaxed bg-[#eef2ff] dark:bg-blue-950/20 border-x border-blue-200 dark:border-blue-900/30 font-semibold">
                                    <div class="flex items-start gap-2">
                                        <span class="text-[#155dfc] font-bold">✔</span>
                                        <span>Biaya pengurusan dokumen kerja & visa ditanggung oleh perusahaan penerima (Accepting Organization) di Jepang.</span>
                                    </div>
                                    <div class="flex items-start gap-2">
                                        <span class="text-[#155dfc] font-bold">✔</span>
                                        <span>Pemeriksaan medis awal (Medical Check-up) ditanggung mandiri.</span>
                                    </div>
                                </td>
                                <td class="p-4 sm:p-6 space-y-2.5 text-slate-600 dark:text-slate-400 leading-relaxed font-semibold">
                                    <div class="flex items-start gap-2">
                                        <span class="text-[#155dfc] font-bold">✔</span>
                                        <span>Biaya penempatan magang/internship ditanggung mandiri oleh mahasiswa atau disubsidi kampus asal.</span>
                                    </div>
                                </td>
                            </tr>
                            
                            <!-- Row 2: Persyaratan -->
                            <tr class="align-top">
                                <td class="p-4 sm:p-6 font-bold text-slate-800 dark:text-slate-200 bg-white/50 dark:bg-slate-900/20">Persyaratan Calon Kandidat</td>
                                <td class="p-4 sm:p-6 space-y-2.5 text-slate-600 dark:text-slate-400 leading-relaxed font-semibold">
                                    <div class="flex items-start gap-2">
                                        <span class="text-[#155dfc] font-bold">✔</span>
                                        <span>Pendidikan Minimal SMA/SMK sederajat.</span>
                                    </div>
                                    <div class="flex items-start gap-2">
                                        <span class="text-[#155dfc] font-bold">✔</span>
                                        <span>Pengalaman kerja sesuai bidang pemagangan (minimal 1 tahun).</span>
                                    </div>
                                    <div class="flex items-start gap-2">
                                        <span class="text-[#155dfc] font-bold">✔</span>
                                        <span>Belum pernah ke Jepang dengan program apapun.</span>
                                    </div>
                                </td>
                                <!-- Highlighted Column cell -->
                                <td class="p-4 sm:p-6 space-y-2.5 text-slate-600 dark:text-slate-400 leading-relaxed bg-[#eef2ff] dark:bg-blue-950/20 border-x border-blue-200 dark:border-blue-900/30 font-semibold">
                                    <div class="flex items-start gap-2">
                                        <span class="text-[#155dfc] font-bold">✔</span>
                                        <span>Alumni peserta magang (ginou jisshusei) yang bersertifikat minimal program technical intern training 2B (3 tahun).</span>
                                    </div>
                                    <div class="flex items-start gap-2">
                                        <span class="text-[#155dfc] font-bold">✔</span>
                                        <span>Untuk non alumni peserta magang:</span>
                                    </div>
                                    <div class="pl-6 space-y-1 font-semibold">
                                        <p>1. Memiliki sertifikat kemampuan bahasa Jepang minimal N4,</p>
                                        <p>2. Pendidikan minimal SMA/SMK sederajat, &amp;</p>
                                        <p>3. Lulus ujian kompetensi sesuai bidang pekerjaan.</p>
                                    </div>
                                </td>
                                <td class="p-4 sm:p-6 space-y-2.5 text-slate-600 dark:text-slate-400 leading-relaxed font-semibold">
                                    <div class="flex items-start gap-2">
                                        <span class="text-[#155dfc] font-bold">✔</span>
                                        <span>Calon Peserta Internsip merupakan Mahasiswa Aktif di salah satu Kampus/Universitas di Indonesia dan sudah bekerjasama dengan pihak Perusahaan di Jepang.</span>
                                    </div>
                                    <div class="flex items-start gap-2">
                                        <span class="text-[#155dfc] font-bold">✔</span>
                                        <span>Jurusan perkuliahan harus relevan dengan penempatan pekerjaan di Jepang.</span>
                                    </div>
                                    <div class="flex items-start gap-2">
                                        <span class="text-[#155dfc] font-bold">✔</span>
                                        <span>Calon Peserta Internsip ditentukan oleh Pihak Kampus.</span>
                                    </div>
                                    <div class="flex items-start gap-2">
                                        <span class="text-[#155dfc] font-bold">✔</span>
                                        <span>Peserta Internship yang telah menyelesaikan program magang...</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 3: PROGRAMS (sec-program)          -->
    <!-- ========================================== -->
    <section id="sec-program" class="tab-content block animate-fade-in scroll-mt-section py-20 bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800/60">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-xs font-extrabold tracking-widest text-[#155dfc] uppercase mb-3 block">Program Unggulan</span>
                <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white font-heading font-extrabold">
                    Pilih Program Karir Anda
                </h2>
                <p class="text-slate-500 dark:text-slate-400 text-sm mt-3 leading-relaxed">
                    LPK Manajemen Pendidikan Islam menyelenggarakan berbagai program pelatihan kerja dan magang terakreditasi menuju Jepang.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto text-left">
                <!-- Program 1: Pemagangan -->
                <div class="bg-white dark:bg-slate-950/40 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-8 flex flex-col justify-between hover:shadow-md transition duration-300">
                    <div class="space-y-6">
                        <!-- Custom illustration -->
                        <div class="w-full h-36 bg-[#eef2ff] dark:bg-blue-950/15 rounded-2xl flex items-center justify-center overflow-hidden border border-blue-100 dark:border-blue-900/20">
                            <svg viewBox="0 0 200 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-24 h-24">
                                <circle cx="100" cy="60" r="40" fill="#ffe0cc" class="dark:fill-blue-900/10"/>
                                <path d="M70 90C70 70 85 55 100 55C115 55 130 70 130 90H70Z" fill="#155dfc"/>
                                <circle cx="100" cy="40" r="12" fill="#ffdbca"/>
                            </svg>
                        </div>
                        <h3 class="font-extrabold text-slate-900 dark:text-white text-xl">Pemagangan ke Jepang</h3>
                        <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm leading-relaxed">
                            Program pelatihan intensif bahasa dan budaya Jepang untuk mempersiapkan Anda bekerja sebagai tenaga magang resmi di sektor industri permesinan, konstruksi, dan pertanian Jepang.
                        </p>
                    </div>
                    <button onclick="window.location.href='#pendaftaran'" class="w-full mt-8 py-3 rounded-xl font-extrabold text-xs uppercase tracking-wider btn-mpi">
                        Learn More
                    </button>
                </div>

                <!-- Program 2: Internship -->
                <div class="bg-white dark:bg-slate-950/40 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-8 flex flex-col justify-between hover:shadow-md transition duration-300">
                    <div class="space-y-6">
                        <!-- Custom illustration -->
                        <div class="w-full h-36 bg-[#eef2ff] dark:bg-blue-950/15 rounded-2xl flex items-center justify-center overflow-hidden border border-blue-100 dark:border-blue-900/20">
                            <svg viewBox="0 0 200 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-24 h-24">
                                <rect x="60" y="30" width="80" height="50" rx="4" fill="#155dfc" opacity="0.8"/>
                                <path d="M80 80L100 100L120 80H80Z" fill="#ea580c"/>
                                <circle cx="100" cy="55" r="8" fill="#ffffff"/>
                            </svg>
                        </div>
                        <h3 class="font-extrabold text-slate-900 dark:text-white text-xl">Program Internship</h3>
                        <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm leading-relaxed">
                            Program magang kerja khusus yang diperuntukkan bagi mahasiswa aktif perguruan tinggi Indonesia untuk mendapatkan pengalaman kerja global dan mengaplikasikan ilmu perkuliahan langsung di Jepang.
                        </p>
                    </div>
                    <button onclick="window.location.href='#pendaftaran'" class="w-full mt-8 py-3 rounded-xl font-extrabold text-xs uppercase tracking-wider btn-mpi">
                        Learn More
                    </button>
                </div>

                <!-- Program 3: Mandiri -->
                <div class="bg-white dark:bg-slate-950/40 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 sm:p-8 flex flex-col justify-between hover:shadow-md transition duration-300">
                    <div class="space-y-6">
                        <!-- Custom illustration -->
                        <div class="w-full h-36 bg-[#eef2ff] dark:bg-blue-950/15 rounded-2xl flex items-center justify-center overflow-hidden border border-blue-100 dark:border-blue-900/20">
                            <svg viewBox="0 0 200 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-24 h-24">
                                <circle cx="80" cy="60" r="25" fill="#155dfc"/>
                                <circle cx="120" cy="60" r="25" fill="#ea580c" opacity="0.7"/>
                                <rect x="90" y="50" width="20" height="20" fill="#ffffff"/>
                            </svg>
                        </div>
                        <h3 class="font-extrabold text-slate-900 dark:text-white text-xl">Program Usaha Mandiri</h3>
                        <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm leading-relaxed">
                            Dukungan permodalan, pembinaan wirausaha, serta pendampingan karir bagi alumni LPK Manajemen Pendidikan Islam sekembalinya dari Jepang untuk mendirikan bisnis mandiri yang sukses.
                        </p>
                    </div>
                    <button onclick="window.location.href='#pendaftaran'" class="w-full mt-8 py-3 rounded-xl font-extrabold text-xs uppercase tracking-wider btn-mpi">
                        Learn More
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 4: INSTRUKTUR (sec-instruktur)     -->
    <!-- ========================================== -->
    <section id="sec-instruktur" class="tab-content block animate-fade-in scroll-mt-section py-20 bg-white dark:bg-slate-950/40 border-b border-slate-100 dark:border-slate-800/60">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-xs font-extrabold tracking-widest text-[#155dfc] uppercase mb-3 block">Fasilitator Utama</span>
                <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white font-heading font-extrabold">
                    Instruktur & Pengajar Profesional
                </h2>
                <p class="text-slate-600 dark:text-slate-400 text-sm mt-3 leading-relaxed">
                    Setiap instruktur dan pemateri di LPK Manajemen Pendidikan Islam merupakan praktisi bersertifikat kompetensi dan berpengalaman di bidangnya masing-masing.
                </p>
            </div>

            @php
                $instrukturCount = (int) ($settings['instruktur_count'] ?? 3);
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                @for($i = 1; $i <= $instrukturCount; $i++)
                    @php
                        $iNameKey = "instruktur_{$i}_nama";
                        $iJabKey  = "instruktur_{$i}_jabatan";
                        $iKeahKey = "instruktur_{$i}_keahlian";
                        $iPengKey = "instruktur_{$i}_pengalaman";
                        $iFotoKey = "instruktur_{$i}_foto";

                        $defName = $i == 1 ? 'Prof. Dr. H. Badrudin, M.Ag.' : ($i == 2 ? 'Dr. Atep Suherman, M.Pd.' : ($i == 3 ? 'Chyril Futuhana Ahmad, M.Pd.' : ''));
                        $defJab  = $i == 1 ? 'Instruktur Kepala / Dewan Pengarah' : ($i == 2 ? 'Instruktur Mutu & Organisasi' : ($i == 3 ? 'Instruktur Tenaga Kependidikan' : ''));
                        $defKeah = $i == 1 ? 'Manajemen Mutu Pendidikan & Akreditasi' : ($i == 2 ? 'Tata Pamong Keuangan & Organisasi Yayasan' : ($i == 3 ? 'Administrasi EMIS & Manajemen Sarpras' : ''));
                        $defPeng = $i == 1 ? 'Guru Besar UIN SGD Bandung & Trainer Internasional' : ($i == 2 ? 'Trainer Kebijakan Publik & Pengawas Yayasan' : ($i == 3 ? 'Kepala Bidang Uji Kompetensi LPK' : ''));

                        $name = $settings[$iNameKey] ?? $defName;
                        $jab  = $settings[$iJabKey] ?? $defJab;
                        $keah = $settings[$iKeahKey] ?? $defKeah;
                        $peng = $settings[$iPengKey] ?? $defPeng;
                        $foto = $settings[$iFotoKey] ?? '';
                    @endphp

                    @if(!empty($name))
                        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 flex flex-col items-center text-center shadow-sm hover:shadow-md transition duration-300 {{ $i > 3 ? 'hidden instruktur-card-extra' : '' }}">
                            <div class="w-24 h-24 rounded-full overflow-hidden border-2 border-blue-600/20 mb-6 shrink-0 relative bg-white dark:bg-slate-800 flex items-center justify-center">
                                @if($foto)
                                    <img src="{{ asset('storage/' . $foto) }}" class="w-full h-full object-cover" alt="{{ $name }}">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-[#155dfc]/25 to-blue-700/10 text-[#155dfc] flex items-center justify-center font-bold text-xl uppercase">
                                        {{ implode('', array_map(fn($part) => $part[0] ?? '', explode(' ', $name))) }}
                                    </div>
                                @endif
                            </div>
                            
                            <h3 class="font-extrabold text-slate-900 dark:text-white text-base leading-tight mb-2">{{ $name }}</h3>
                            <span class="text-[#155dfc] dark:text-blue-500 font-bold text-xs uppercase tracking-wider mb-4 block">{{ $jab }}</span>
                            
                            <div class="border-t border-slate-100 dark:border-slate-800/80 pt-4 mt-2 w-full text-left space-y-3">
                                <div>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Keahlian</span>
                                    <p class="text-xs text-slate-600 dark:text-slate-400 mt-0.5 leading-relaxed">{{ $keah }}</p>
                                </div>
                                <div>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Pengalaman</span>
                                    <p class="text-xs text-slate-600 dark:text-slate-400 mt-0.5 leading-relaxed font-semibold">{{ $peng }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                @endfor
            </div>

            @if($instrukturCount > 3)
                <div class="flex justify-center mt-12">
                    <button id="btn-toggle-instruktur" onclick="toggleInstrukturExtra()" class="px-6 py-3 bg-[#155dfc] hover:bg-blue-700 text-white font-extrabold text-xs uppercase tracking-wider rounded-xl transition duration-300 shadow-lg shadow-blue-500/10 flex items-center gap-2">
                        <span>Lihat Semua</span>
                        <svg id="arrow-instruktur" class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                </div>
            @endif
        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 5: FASILITAS (sec-fasilitas)       -->
    <!-- ========================================== -->
    <section id="sec-fasilitas" class="tab-content block animate-fade-in scroll-mt-section py-20 bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800/60">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-xs font-extrabold tracking-widest text-[#155dfc] uppercase mb-3 block">Sarana Fisik</span>
                <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white font-heading font-extrabold">
                    Fasilitas & Prasarana Pembelajaran
                </h2>
                <p class="text-slate-600 dark:text-slate-400 text-sm mt-3 leading-relaxed">
                    Kami menyediakan sarana fisik pendukung untuk kenyamanan dan keefektifan belajar peserta diklat selama masa persiapan kerja.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto text-left">
                <!-- Fasilitas 1: Ruang Belajar -->
                <div class="bg-white dark:bg-slate-950/40 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 flex flex-col justify-between hover:shadow-md transition duration-300">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-blue-600/10 text-[#155dfc] flex items-center justify-center mb-6 border border-blue-600/20">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <h3 class="font-extrabold text-slate-900 dark:text-white text-lg mb-3">
                            {{ $settings['fasilitas_belajar_judul'] ?? 'Ruang Belajar & Teori Ergonomis' }}
                        </h3>
                        <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm leading-relaxed">
                            {{ $settings['fasilitas_belajar_desc'] ?? 'Kami memiliki ruang kelas berkapasitas 25 orang yang sejuk (AC penuh) dengan tata pencahayaan yang nyaman, papan tulis interaktif, serta sound system nirkabel untuk presentasi materi ajar.' }}
                        </p>
                    </div>
                </div>

                <!-- Fasilitas 2: Perpustakaan -->
                <div class="bg-white dark:bg-slate-950/40 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 flex flex-col justify-between hover:shadow-md transition duration-300">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-blue-600/10 text-[#155dfc] flex items-center justify-center mb-6 border border-blue-600/20">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <h3 class="font-extrabold text-slate-900 dark:text-white text-lg mb-3">
                            {{ $settings['fasilitas_perpustakaan_judul'] ?? 'Pusat Referensi & E-Learning' }}
                        </h3>
                        <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm leading-relaxed">
                            {{ $settings['fasilitas_perpustakaan_desc'] ?? 'Menyediakan koleksi lengkap buku modul pembelajaran Bahasa Jepang (Minna no Nihongo), tata kelola bisnis, regulasi imigrasi Jepang, serta akses portal referensi digital.' }}
                        </p>
                    </div>
                </div>

                <!-- Fasilitas 3: Asrama -->
                <div class="bg-white dark:bg-slate-950/40 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 flex flex-col justify-between hover:shadow-md transition duration-300">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-blue-600/10 text-[#155dfc] flex items-center justify-center mb-6 border border-blue-600/20">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        </div>
                        <h3 class="font-extrabold text-slate-900 dark:text-white text-lg mb-3">
                            {{ $settings['fasilitas_asrama_judul'] ?? 'Asrama & Penginapan Peserta' }}
                        </h3>
                        <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm leading-relaxed">
                            {{ $settings['fasilitas_asrama_desc'] ?? 'Bagi peserta dari luar kota, tersedia asrama eksklusif ber-AC dengan fasilitas kamar mandi dalam, akses internet WiFi 100 Mbps, dapur bersama, serta area olahraga semi-outdoor.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 6: PUBLICATIONS (sec-berita)       -->
    <!-- ========================================== -->
    <section id="sec-berita" class="tab-content block animate-fade-in scroll-mt-section py-20 bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800/60">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-xs font-extrabold tracking-widest text-[#155dfc] uppercase mb-3 block">Kabar & Publikasi</span>
                <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white font-heading font-extrabold font-extrabold">
                    Instagram & Youtube Terbaru
                </h2>
                <p class="text-slate-500 dark:text-slate-400 text-sm mt-3 leading-relaxed">
                    Ikuti kegiatan pelatihan harian, dokumentasi kelulusan, serta tips karir di Jepang melalui media sosial resmi kami.
                </p>
            </div>

              <!-- YouTube Featured Video -->
            <div class="max-w-4xl mx-auto bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl overflow-hidden shadow-sm mb-16">
                <div class="grid grid-cols-1 md:grid-cols-12 items-stretch">
                    <div class="md:col-span-7 bg-transparent aspect-video relative flex items-center justify-center group cursor-pointer" onclick="openVideoModal('https://www.youtube.com/watch?v=dQw4w9WgXcQ')">
                        <!-- Play Overlay -->
                        <div class="absolute inset-0 bg-slate-900/30 group-hover:bg-slate-900/10 transition z-10"></div>
                        <div class="w-16 h-16 rounded-full bg-[#155dfc] text-white flex items-center justify-center shadow-lg group-hover:scale-110 transition z-20">
                            <span class="ml-1 text-lg">▶</span>
                        </div>
                        @php $siteLogo = $settings['site_logo'] ?? ''; @endphp
                        @if($siteLogo)
                            <img src="{{ asset('storage/' . $siteLogo) }}" class="w-full h-full object-contain absolute inset-0 p-4" alt="Video Cover">
                        @else
                            <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=800&q=80" class="w-full h-full object-cover absolute inset-0" alt="Video Cover">
                        @endif
                    </div>
                    <div class="md:col-span-5 p-6 flex flex-col justify-between text-left">
                        <div>
                            <span class="bg-red-500/10 text-red-600 dark:text-red-400 font-extrabold text-[9px] px-2.5 py-0.5 rounded-full border border-red-500/20 uppercase tracking-widest">Featured Video</span>
                            <h3 class="font-extrabold text-slate-900 dark:text-white text-lg mt-3 leading-tight font-heading">Persiapan Calon Tenaga Kerja LPK Manajemen Pendidikan Islam</h3>
                            <p class="text-slate-500 dark:text-slate-400 text-xs mt-3 leading-relaxed font-semibold">
                                Tonton dokumentasi simulasi seleksi fisik, wawancara kerja (mensetsu) dengan user perusahaan Jepang, dan pelepasan keberangkatan angkatan 2026.
                            </p>
                        </div>
                        <span class="text-[10px] font-mono text-slate-400 mt-6 font-bold block font-semibold">DURASI: 12 MENIT • YOUTUBE</span>
                    </div>
                </div>
            </div>

            <!-- Social Media grids -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 max-w-6xl mx-auto text-left">
                <!-- Instagram Column -->
                <div>
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-black text-slate-900 dark:text-white text-lg font-heading">Dari Akun Instagram Kami</h3>
                        <a href="https://instagram.com" target="_blank" class="text-[#155dfc] hover:underline text-xs font-bold uppercase tracking-wider font-semibold">Kunjungi @lpk_mpi</a>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Instagram post cards -->
                        <div class="aspect-square bg-white dark:bg-slate-800 rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 relative group cursor-pointer" onclick="openVideoModal('https://instagram.com/p/123')">
                            <div class="absolute inset-0 bg-slate-950/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition text-white font-extrabold text-xs z-10"> Lihat Postingan </div>
                            @if($siteLogo)
                                <img src="{{ asset('storage/' . $siteLogo) }}" class="w-full h-full object-contain p-4" alt="IG 1">
                            @else
                                <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=400&q=80" class="w-full h-full object-cover" alt="IG 1">
                            @endif
                        </div>
                        <div class="aspect-square bg-white dark:bg-slate-800 rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 relative group cursor-pointer" onclick="openVideoModal('https://instagram.com/p/456')">
                            <div class="absolute inset-0 bg-slate-950/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition text-white font-extrabold text-xs z-10"> Lihat Postingan </div>
                            @if($siteLogo)
                                <img src="{{ asset('storage/' . $siteLogo) }}" class="w-full h-full object-contain p-4" alt="IG 2">
                            @else
                                <img src="https://images.unsplash.com/photo-1531535934200-873499955726?auto=format&fit=crop&w=400&q=80" class="w-full h-full object-cover" alt="IG 2">
                            @endif
                        </div>
                    </div>
                </div>

                <!-- YouTube Grid -->
                <div>
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-black text-slate-900 dark:text-white text-lg font-heading">Dari Kanal YouTube Kami</h3>
                        <a href="https://youtube.com" target="_blank" class="text-[#155dfc] hover:underline text-xs font-bold uppercase tracking-wider font-semibold">Kunjungi LPK Manajemen Pendidikan Islam TV</a>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <!-- YouTube post cards -->
                        <div class="aspect-square bg-white dark:bg-slate-800 rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 relative group cursor-pointer" onclick="openVideoModal('https://youtube.com/watch?v=1')">
                            <div class="absolute inset-0 bg-slate-950/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition text-white font-extrabold text-xs z-10"> Putar Video </div>
                            @if($siteLogo)
                                <img src="{{ asset('storage/' . $siteLogo) }}" class="w-full h-full object-contain p-4" alt="YT 1">
                            @else
                                <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?auto=format&fit=crop&w=400&q=80" class="w-full h-full object-cover" alt="YT 1">
                            @endif
                        </div>
                        <div class="aspect-square bg-white dark:bg-slate-800 rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 relative group cursor-pointer" onclick="openVideoModal('https://youtube.com/watch?v=2')">
                            <div class="absolute inset-0 bg-slate-950/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition text-white font-extrabold text-xs z-10"> Putar Video </div>
                            @if($siteLogo)
                                <img src="{{ asset('storage/' . $siteLogo) }}" class="w-full h-full object-contain p-4" alt="YT 2">
                            @else
                                <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=400&q=80" class="w-full h-full object-cover" alt="YT 2">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 7: KISAH ALUMNI (sec-alumni)       -->
    <!-- ========================================== -->
    <section id="sec-alumni" class="tab-content block animate-fade-in scroll-mt-section py-20 bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800/60">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-xs font-extrabold tracking-widest text-[#155dfc] uppercase mb-3 block">Jejak Sukses</span>
                <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white font-heading font-extrabold">
                    Kisah Sukses Alumni di Jepang
                </h2>
                <p class="text-slate-600 dark:text-slate-400 text-sm mt-3 leading-relaxed">
                    Melihat kisah inspiratif para alumni LPK Manajemen Pendidikan Islam yang kini telah sukses bekerja di berbagai sektor industri di Jepang.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto mb-16">
                <!-- Alumni 1 -->
                <div class="bg-white dark:bg-slate-950/40 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 flex flex-col justify-between shadow-sm hover:shadow-md transition duration-300">
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 italic leading-relaxed mb-6 font-semibold">
                        "Pelatihan di LPK Manajemen Pendidikan Islam sangat ketat tapi sangat membantu membentuk mental disiplin yang dibutuhkan di Jepang. Sekarang saya bekerja sebagai CNC Programmer di Prefektur Chiba dengan gaji yang sangat baik."
                    </p>
                    <div class="flex items-center gap-3 border-t border-slate-100 dark:border-slate-800 pt-4">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#155dfc] to-blue-700 text-white flex items-center justify-center font-bold text-xs uppercase shrink-0 font-extrabold">
                            HW
                        </div>
                        <div>
                            <h4 class="text-xs font-extrabold text-slate-900 dark:text-white uppercase font-extrabold">Wawan Hermawan</h4>
                            <span class="text-[10px] text-slate-400 font-bold block uppercase mt-0.5">CNC Programmer • Chiba, Japan</span>
                        </div>
                    </div>
                </div>

                <!-- Alumni 2 -->
                <div class="bg-white dark:bg-slate-950/40 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 flex flex-col justify-between shadow-sm hover:shadow-md transition duration-300">
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 italic leading-relaxed mb-6 font-semibold">
                        "Saya bersyukur mengikuti program Visa Kerja Khusus (Tokutei Ginou) melalui LPK Manajemen Pendidikan Islam. Selain diajarkan bahasa Jepang tingkat N4, kami juga diberikan sertifikat SSW Caregiver sehingga penempatan kerjanya lancar."
                    </p>
                    <div class="flex items-center gap-3 border-t border-slate-100 dark:border-slate-800 pt-4">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#155dfc] to-blue-700 text-white flex items-center justify-center font-bold text-xs uppercase shrink-0 font-extrabold">
                            NS
                        </div>
                        <div>
                            <h4 class="text-xs font-extrabold text-slate-900 dark:text-white uppercase font-extrabold">Nurul Sofia</h4>
                            <span class="text-[10px] text-slate-400 font-bold block uppercase mt-0.5">Caregiver (Kaigo) • Tokyo, Japan</span>
                        </div>
                    </div>
                </div>

                <!-- Alumni 3 -->
                <div class="bg-white dark:bg-slate-950/40 border border-slate-200 dark:border-slate-800 rounded-3xl p-6 flex flex-col justify-between shadow-sm hover:shadow-md transition duration-300">
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 italic leading-relaxed mb-6 font-semibold">
                        "Program Internship LPK membantu saya melakukan magang sambil kuliah. Hubungan kerjasama LPK Manajemen Pendidikan Islam dengan perusahaan manufaktur di Nagoya sangat kuat sehingga kepastian kontrak kerjanya terjamin."
                    </p>
                    <div class="flex items-center gap-3 border-t border-slate-100 dark:border-slate-800 pt-4">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#155dfc] to-blue-700 text-white flex items-center justify-center font-bold text-xs uppercase shrink-0 font-extrabold">
                            AS
                        </div>
                        <div>
                            <h4 class="text-xs font-extrabold text-slate-900 dark:text-white uppercase font-extrabold">Ahmad Solihin</h4>
                            <span class="text-[10px] text-slate-400 font-bold block uppercase mt-0.5">Staf Magang Manufaktur • Nagoya, Japan</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats grid -->
            <div class="bg-[#eef2ff] dark:bg-blue-950/10 border border-blue-200 dark:border-blue-900/30 rounded-3xl p-8 max-w-5xl mx-auto">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                    <div>
                        <span class="block text-3xl font-black text-[#155dfc] font-extrabold">120+</span>
                        <span class="text-[10px] uppercase tracking-wider text-slate-500 dark:text-slate-400 font-bold">Perusahaan Mitra</span>
                    </div>
                    <div>
                        <span class="block text-3xl font-black text-[#155dfc] font-extrabold">3,000+</span>
                        <span class="text-[10px] uppercase tracking-wider text-slate-500 dark:text-slate-400 font-bold">Alumni di Jepang</span>
                    </div>
                    <div>
                        <span class="block text-3xl font-black text-[#155dfc] font-extrabold">98%</span>
                        <span class="text-[10px] uppercase tracking-wider text-slate-500 dark:text-slate-400 font-bold">Tingkat Kelulusan</span>
                    </div>
                    <div>
                        <span class="block text-3xl font-black text-[#155dfc] font-extrabold">24/7</span>
                        <span class="text-[10px] uppercase tracking-wider text-slate-500 dark:text-slate-400 font-bold">Support di Jepang</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- SECTION 8: CONTACT INFO (sec-kontak)       -->
    <!-- ========================================== -->
    <section id="sec-kontak" class="tab-content block animate-fade-in scroll-mt-section py-20 bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800/60">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white font-heading font-extrabold">
                    Hubungi Kami
                </h2>
                <p class="text-slate-500 dark:text-slate-400 text-sm mt-3">
                    Staf admin LPK Manajemen Pendidikan Islam siap melayani pendaftaran pelatihan dan konsultasi.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch max-w-6xl mx-auto text-left">
                <!-- Col 1: Contact Details Card -->
                <div class="bg-white dark:bg-slate-950/40 rounded-3xl p-6 sm:p-8 border border-slate-200 dark:border-slate-800 flex flex-col justify-between shadow-sm">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6 border-b border-slate-100 dark:border-slate-800 pb-3 font-heading">Informasi Kontak</h3>
                        
                        <div class="space-y-5 text-sm text-slate-700 dark:text-slate-300">
                            <div class="flex gap-3">
                                <span class="font-extrabold text-[#155dfc] shrink-0">📍</span>
                                <p class="text-xs leading-relaxed font-semibold">
                                    <strong>Kantor Pusat:</strong><br>
                                    Jl. Ciragil II No.6;RT/RW 001/001 Kel. Rawa Barat, Kec.Kebayoran Baru Jakarta Selatan 12180.
                                </p>
                            </div>
                            
                            <div class="flex gap-3">
                                <span class="font-extrabold text-[#155dfc] shrink-0">📞</span>
                                <p class="text-xs font-semibold">
                                    <strong>Telepon Hotline:</strong><br>
                                    +62 21 38808080
                                </p>
                            </div>
                            
                            <div class="flex gap-3">
                                <span class="font-extrabold text-[#155dfc] shrink-0">✉</span>
                                <p class="text-xs font-semibold">
                                    <strong>E-mail Layanan:</strong><br>
                                    mail@lpk-mpi.org / info@lpk-mpi.org
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-4 flex gap-2.5 mt-8 shadow-inner">
                        <p class="text-[10px] text-slate-500 dark:text-slate-400 leading-relaxed font-semibold">
                            <strong>Jam Layanan Administrasi:</strong><br>
                            Senin s.d. Jumat pukul 08.00 - 17.00 WIB | Sabtu pukul 08.00 - 12.00 WIB (Minggu Libur).
                        </p>
                    </div>
                </div>

                <!-- Col 3: Google Map -->
                <div class="bg-white dark:bg-slate-950/40 rounded-3xl p-6 sm:p-8 border border-slate-200 dark:border-slate-800 flex flex-col justify-between shadow-sm">
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2 font-heading">Peta Lokasi &amp; Denah</h3>
                        <p class="text-slate-500 dark:text-slate-400 text-xs leading-relaxed mb-6">
                            Navigasikan kendaraan Anda langsung menggunakan rute GPS yang telah terintegrasi dengan Google Maps.
                        </p>
                        
                        <div class="w-full h-40 rounded-xl border border-slate-300 dark:border-slate-800 overflow-hidden shadow-inner">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.2483861271167!2d106.8122393!3d-6.2309503!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f1687f893e15%3A0xe54e6ffbcad3eb9a!2sJl.%20Ciragil%20II%20No.6%2C%20RT.1%2FRW.1%2C%20Rawa%20Barat%2C%20Kebayoran%20Baru%2C%20Jakarta%20Selatan%2C%2012180!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" class="w-full h-full border-0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>

                    <a href="https://maps.google.com/?q=Jl.+Ciragil+II+No.6+Jakarta+Selatan" target="_blank" class="w-full py-3 rounded-xl text-center font-extrabold text-xs uppercase tracking-wider btn-mpi shadow-lg shadow-blue-600/10 mt-6 font-extrabold">
                        Buka Google Maps
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section id="sec-faq" class="tab-content block animate-fade-in scroll-mt-section py-20 bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800/60">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-xs font-extrabold tracking-widest text-[#155dfc] uppercase mb-3 block">Pertanyaan Umum</span>
                <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white font-heading font-extrabold">
                    Frequently Asked Questions
                </h2>
                <p class="text-slate-500 dark:text-slate-400 text-sm mt-3 leading-relaxed">
                    Jawaban resmi atas pertanyaan yang paling sering diajukan mengenai program diklat LPK Manajemen Pendidikan Islam.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center max-w-6xl mx-auto text-left">
                <!-- FAQ Accordion List -->
                <div class="lg:col-span-7 space-y-4">
                    @php
                        $faqCount = (int) ($settings['faq_count'] ?? 3);
                    @endphp
                    @for($i = 1; $i <= $faqCount; $i++)
                        @php
                            $qKey = "faq_{$i}_q";
                            $aKey = "faq_{$i}_a";

                            $defQ = $i == 1 ? 'Bagaimana prosedur pendaftaran untuk program pemagangan ke Jepang?' : ($i == 2 ? 'Berapa lama durasi pelatihan bahasa Jepang pra-keberangkatan?' : ($i == 3 ? 'Apakah ada batasan usia untuk mendaftar program Tokutei Ginou?' : ''));
                            $defA = $i == 1 ? 'Calon peserta mendaftar online melalui portal pendaftaran, mengunggah scan KTP &amp; Ijazah, kemudian admin LPK akan melakukan verifikasi berkas dan menjadwalkan wawancara awal. Setelah lolos seleksi berkas, peserta mengikuti diklat bahasa Jepang di pusdiklat LPK Manajemen Pendidikan Islam.' : ($i == 2 ? 'Pelatihan bahasa Jepang pra-keberangkatan berlangsung selama 3 hingga 6 bulan (tergantung kesiapan peserta) untuk mencapai kompetensi setingkat N4/N5 yang dipersyaratkan oleh COE/Imigrasi Jepang.' : ($i == 3 ? 'Program Tokutei Ginou (Specified Skilled Worker - SSW) menerima pendaftar dengan batas usia produktif berkisar antara 18 hingga 35 tahun pada saat pendaftaran, berbadan sehat, serta bebas tato/tindik.' : ''));

                            $qVal = $settings[$qKey] ?? $defQ;
                            $aVal = $settings[$aKey] ?? $defA;
                        @endphp

                        @if(!empty($qVal))
                            <div id="faq-item-{{ $i }}" class="accordion-item border border-slate-200 dark:border-slate-800 rounded-2xl bg-white dark:bg-slate-900 overflow-hidden transition duration-300 {{ $i > 3 ? 'hidden faq-card-extra' : '' }}">
                                <button onclick="toggleAccordion('faq-item-{{ $i }}')" class="accordion-header w-full px-6 py-5 font-bold text-slate-900 dark:text-white flex justify-between items-center text-left text-sm gap-4">
                                    <span>{{ $qVal }}</span>
                                    <span class="accordion-icon text-xs text-slate-400 transition-transform">▼</span>
                                </button>
                                <div class="accordion-content hidden px-6 pb-5 text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed border-t border-slate-50 dark:border-slate-800/50 pt-4">
                                    {!! nl2br(e($aVal)) !!}
                                </div>
                            </div>
                        @endif
                    @endfor

                    @if($faqCount > 3)
                        <div class="flex justify-start mt-6">
                            <button id="btn-toggle-faq" onclick="toggleFaqExtra()" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-white font-extrabold text-xs uppercase tracking-wider rounded-xl transition duration-300 flex items-center gap-2">
                                <span>Lihat Semua FAQ</span>
                                <svg id="arrow-faq" class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>
                        </div>
                    @endif
                </div>

                <!-- FAQ Illustration -->
                <div class="lg:col-span-5 flex justify-center items-center">
                    <svg viewBox="0 0 400 350" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto max-w-sm mx-auto">
                        <circle cx="200" cy="175" r="130" fill="#eef2ff" class="dark:fill-blue-950/15" />
                        <path d="M120 250C120 200 150 160 200 160C250 160 280 200 280 250H120Z" fill="#2d3748"/>
                        <circle cx="200" cy="110" r="28" fill="#ffdbca"/>
                        <path d="M170 110C170 80 230 80 230 110H170Z" fill="#155dfc"/>
                        <path d="M160 170H240L250 190H150L160 170Z" fill="#718096"/>
                        <!-- Question Bubble Speech -->
                        <path d="M220 70C220 40 260 30 290 30C320 30 340 50 340 70C340 90 320 110 290 110C270 110 265 115 260 120C260 110 220 100 220 70Z" fill="#155dfc"/>
                        <!-- White Question Mark inside bubble -->
                        <path d="M285 55C285 50 295 50 295 55C295 60 290 62 290 65M290 75H291" stroke="#ffffff" stroke-width="4" stroke-linecap="round"/>
                    </svg>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- CUSTOM FOOTER FOR LPK Manajemen Pendidikan Islam INDONESIA      -->
    <!-- ========================================== -->
    <footer class="w-full bg-[#111827] border-t border-slate-800 py-16 text-xs text-slate-400 text-left">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
            <!-- Col 1: Logo & Jakarta Office -->
            <div class="space-y-4">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-[#155dfc] flex items-center justify-center text-white font-black text-xs">
                        MPI
                    </div>
                    <span class="font-extrabold text-sm text-white tracking-tight uppercase">LPK Manajemen Pendidikan Islam</span>
                </div>
                <p class="font-semibold text-slate-350">Kantor Pusat:</p>
                <p class="leading-relaxed">
                    Jl. Ciragil II No.6; RT/RW 001/001 Kel. Rawa Barat, Kec.Kebayoran Baru Jakarta Selatan 12180
                </p>
                <div class="space-y-1 font-mono text-[10px]">
                    <p>Phone: +62 21 38808080</p>
                    <p>Email: mail@lpk-mpi.org</p>
                </div>
            </div>

            <!-- Col 2: Bandung Pusdiklat -->
            <div class="space-y-4">
                <h4 class="font-bold text-white uppercase tracking-wider font-heading">Pusdiklat Bandung</h4>
                <p class="leading-relaxed">
                    Jl. Arcamanik Sindanglaya, KP. Sekesalam RT/RW 001/008, DS.Sindanglaya, Kec. Cimenyan, Kab. Bandung, Jawa Barat 40195
                </p>
            </div>

            <!-- Col 3: Follow Us -->
            <div class="space-y-4">
                <h4 class="font-bold text-white uppercase tracking-wider font-heading">Follow Us</h4>
                <ul class="space-y-2 font-medium">
                    <li><a href="#" class="hover:text-[#155dfc] transition">Facebook</a></li>
                    <li><a href="#" class="hover:text-[#155dfc] transition">Twitter</a></li>
                    <li><a href="#" class="hover:text-[#155dfc] transition">Youtube</a></li>
                    <li><a href="#" class="hover:text-[#155dfc] transition">Instagram</a></li>
                </ul>
            </div>

            <!-- Col 4: Partnership & Logos -->
            <div class="space-y-4">
                <h4 class="font-bold text-white uppercase tracking-wider font-heading">Partnership</h4>
                <div class="flex flex-wrap gap-4 opacity-70 font-semibold">
                    <div class="w-8 h-8 rounded bg-white/10 flex items-center justify-center text-[10px] font-black text-[#155dfc]">c</div>
                    <div class="w-8 h-8 rounded bg-white/10 flex items-center justify-center text-[10px] font-black">IGS</div>
                    <div class="w-8 h-8 rounded bg-white/10 flex items-center justify-center text-[10px] font-black">F</div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-6 border-t border-slate-800 pt-8 flex flex-col sm:flex-row justify-between items-center gap-4">
            <p class="text-slate-500 dark:text-slate-400 font-semibold">&copy; Copyright 2010 - LPK Manajemen Pendidikan Islam All Rights Reserved.</p>
            <div class="flex gap-4 text-slate-500 dark:text-slate-400 font-semibold">
                <a href="#" class="hover:text-[#155dfc] transition">Terms</a>
                <span>•</span>
                <a href="#" class="hover:text-[#155dfc] transition">Privacy</a>
                <span>•</span>
                <a href="#" class="hover:text-[#155dfc] transition">Cookies</a>
            </div>
        </div>
    </footer>

    <!-- Video Modal -->
    <div id="video-modal" class="fixed inset-0 z-50 overflow-y-auto hidden items-center justify-center p-4 bg-slate-950/85 backdrop-blur-sm transition-all duration-300">
        <div class="bg-white dark:bg-slate-900 w-full max-w-3xl border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-2xl flex flex-col">
            <div class="p-4 border-b border-slate-200 dark:border-slate-800 flex justify-between items-center bg-white dark:bg-slate-900/60">
                <h3 class="font-bold text-slate-900 dark:text-white text-sm uppercase tracking-wider font-heading">Video Preview</h3>
                <button onclick="closeVideoModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-white font-black text-xl">&times;</button>
            </div>
            <div class="p-2 bg-black aspect-video relative">
                <iframe id="video-modal-iframe" class="w-full h-full" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>
        </div>
    </div>

    <!-- Scripts for QR, Accordion, Guestbook, Enrollment & Verification -->
    <script>
        // Accordion script
        function toggleAccordion(id) {
            const item = document.getElementById(id);
            if (!item) return;
            const content = item.querySelector('.accordion-content');
            const icon = item.querySelector('.accordion-icon');
            const isExpanded = !content.classList.contains('hidden');
            
            // Close all other accordions
            document.querySelectorAll('.accordion-item').forEach(acc => {
                if (acc.id !== id) {
                    acc.querySelector('.accordion-content').classList.add('hidden');
                    const otherIcon = acc.querySelector('.accordion-icon');
                    if (otherIcon) {
                        otherIcon.style.transform = 'rotate(0deg)';
                        otherIcon.textContent = '▼';
                    }
                    acc.querySelector('.accordion-header').classList.remove('text-[#155dfc]');
                    acc.querySelector('.accordion-header').classList.add('text-slate-900', 'dark:text-white');
                }
            });

            if (isExpanded) {
                content.classList.add('hidden');
                if (icon) {
                    icon.style.transform = 'rotate(0deg)';
                    icon.textContent = '▼';
                }
                item.querySelector('.accordion-header').classList.remove('text-[#155dfc]');
                item.querySelector('.accordion-header').classList.add('text-slate-900', 'dark:text-white');
            } else {
                content.classList.remove('hidden');
                if (icon) {
                    icon.style.transform = 'rotate(180deg)';
                    icon.textContent = '▲';
                }
                item.querySelector('.accordion-header').classList.add('text-[#155dfc]');
                item.querySelector('.accordion-header').classList.remove('text-slate-900', 'dark:text-white');
            }
        }



        // Video modal functions
        function openVideoModal(url) {
            const modal = document.getElementById('video-modal');
            const iframe = document.getElementById('video-modal-iframe');
            if (!modal || !iframe) return;
            
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
            if (!modal || !iframe) return;
            iframe.src = '';
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function toggleInstrukturExtra() {
            const btn = document.getElementById('btn-toggle-instruktur');
            const arrow = document.getElementById('arrow-instruktur');
            const extras = document.querySelectorAll('.instruktur-card-extra');
            if (!btn || extras.length === 0) return;

            const isHidden = extras[0].classList.contains('hidden');
            extras.forEach(el => {
                if (isHidden) {
                    el.classList.remove('hidden');
                    el.classList.add('animate-fade-in');
                } else {
                    el.classList.add('hidden');
                }
            });

            if (isHidden) {
                btn.querySelector('span').textContent = 'Sembunyikan';
                if (arrow) arrow.style.transform = 'rotate(180deg)';
            } else {
                btn.querySelector('span').textContent = 'Lihat Semua';
                if (arrow) arrow.style.transform = 'rotate(0deg)';
            }
        }

        function toggleFaqExtra() {
            const btn = document.getElementById('btn-toggle-faq');
            const arrow = document.getElementById('arrow-faq');
            const extras = document.querySelectorAll('.faq-card-extra');
            if (!btn || extras.length === 0) return;

            const isHidden = extras[0].classList.contains('hidden');
            extras.forEach(el => {
                if (isHidden) {
                    el.classList.remove('hidden');
                    el.classList.add('animate-fade-in');
                } else {
                    el.classList.add('hidden');
                }
            });

            if (isHidden) {
                btn.querySelector('span').textContent = 'Sembunyikan';
                if (arrow) arrow.style.transform = 'rotate(180deg)';
            } else {
                btn.querySelector('span').textContent = 'Lihat Semua FAQ';
                if (arrow) arrow.style.transform = 'rotate(0deg)';
            }
        }


        // ==========================================
        // 💬 LIVE CHAT WIDGET LOGIC
        // ==========================================
        let floatUserName = localStorage.getItem('chat_name') || '';
        let floatUserEmail = localStorage.getItem('chat_email') || '';
        let floatSessionId = localStorage.getItem('chat_session_id') || '';
        let floatPollInterval = null;

        if (!floatSessionId) {
            floatSessionId = 'sess_' + Math.random().toString(36).substr(2, 9) + '_' + Date.now();
            localStorage.setItem('chat_session_id', floatSessionId);
        }

        function initFloatChatUI() {
            const setupForm = document.getElementById('float-setup-form');
            const messagesContainer = document.getElementById('float-messages-container');
            const inputBar = document.getElementById('float-input-bar');

            if (floatUserName && floatUserEmail) {
                setupForm.classList.add('hidden');
                messagesContainer.classList.remove('hidden');
                inputBar.classList.remove('hidden');
                
                loadFloatMessages();
                
                if (floatPollInterval) clearInterval(floatPollInterval);
                floatPollInterval = setInterval(loadFloatMessages, 3000);
            } else {
                setupForm.classList.remove('hidden');
                messagesContainer.classList.add('hidden');
                inputBar.classList.add('hidden');
            }
        }

        function submitFloatSetup() {
            const nameInput = document.getElementById('float-setup-name');
            const emailInput = document.getElementById('float-setup-email');
            
            const name = nameInput.value.trim();
            const email = emailInput.value.trim();

            if (!name) {
                alert('Silakan masukkan nama Anda.');
                return;
            }
            if (!email || !email.includes('@')) {
                alert('Silakan masukkan alamat email yang valid.');
                return;
            }

            floatUserName = name;
            floatUserEmail = email;

            localStorage.setItem('chat_name', name);
            localStorage.setItem('chat_email', email);

            initFloatChatUI();
        }

        function toggleFloatingChat() {
            const popup = document.getElementById('floating-chat-popup');
            const iconMsg = document.getElementById('float-chat-icon-msg');
            const iconClose = document.getElementById('float-chat-icon-close');
            
            if (popup.classList.contains('hidden')) {
                popup.classList.remove('hidden');
                popup.classList.add('flex');
                iconMsg.classList.add('hidden');
                iconClose.classList.remove('hidden');
                
                const messagesContainer = document.getElementById('float-messages-container');
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            } else {
                popup.classList.add('hidden');
                popup.classList.remove('flex');
                iconMsg.classList.remove('hidden');
                iconClose.classList.add('hidden');
            }
        }

        function loadFloatMessages() {
            if (!floatSessionId) return;

            fetch(`/api/chat/messages?session_id=${floatSessionId}`)
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        const container = document.getElementById('float-messages-container');
                        
                        const statusEl = document.getElementById('float-chat-status');
                        if (data.claimed_by) {
                            statusEl.innerHTML = `<span class="inline-block w-1.5 h-1.5 bg-emerald-400 rounded-full animate-ping"></span> Online (Admin: ${data.claimed_by})`;
                        } else {
                            statusEl.innerHTML = `<span class="inline-block w-1.5 h-1.5 bg-emerald-400 rounded-full animate-ping"></span> Online`;
                        }

                        if (data.messages.length === 0) {
                            container.innerHTML = `
                                <div class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-100 rounded-2xl rounded-tl-none p-3 text-xs max-w-[85%] self-start shadow-sm leading-relaxed relative">
                                    <p class="font-semibold text-[10px] text-[#155dfc] mb-1">Admin</p>
                                    Halo ${floatUserName}! Ada yang bisa kami bantu? Silakan kirim pesan Anda di sini.
                                    <span class="block text-[8px] text-slate-400 text-right mt-1 font-mono">Sekarang</span>
                                </div>
                            `;
                            return;
                        }

                        let html = '';
                        data.messages.forEach(msg => {
                            const isUser = msg.sender_role === 'visitor';
                            if (isUser) {
                                html += `
                                    <div class="bg-[#d9fdd3] dark:bg-emerald-950 text-slate-800 dark:text-slate-100 rounded-2xl rounded-tr-none p-3 text-xs max-w-[85%] self-end shadow-sm leading-relaxed relative animate-fade-in">
                                        <p class="font-semibold text-[10px] text-[#128c7e] mb-1">Anda</p>
                                        ${msg.message}
                                        <div class="flex items-center justify-end gap-1 mt-1">
                                            <span class="text-[8px] text-slate-400 font-mono">${msg.time}</span>
                                            <span class="text-[10px] text-blue-500 font-bold leading-none">✓✓</span>
                                        </div>
                                    </div>
                                `;
                            } else {
                                const senderName = msg.admin_name || 'Admin';
                                html += `
                                    <div class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-100 rounded-2xl rounded-tl-none p-3 text-xs max-w-[85%] self-start shadow-sm leading-relaxed relative animate-fade-in">
                                        <p class="font-semibold text-[10px] text-[#155dfc] mb-1">${senderName}</p>
                                        ${msg.message}
                                        <span class="block text-[8px] text-slate-400 text-right mt-1 font-mono">${msg.time}</span>
                                    </div>
                                `;
                            }
                        });

                        const isNearBottom = container.scrollHeight - container.clientHeight - container.scrollTop < 100;
                        const originalHtml = container.innerHTML;

                        container.innerHTML = html;

                        if (isNearBottom || originalHtml.includes('Halo! Ada yang bisa kami bantu?')) {
                            container.scrollTop = container.scrollHeight;
                        }
                    }
                })
                .catch(err => console.error("Error loading chat messages:", err));
        }

        function handleFloatKeyPress(event) {
            if (event.key === 'Enter') {
                sendFloatMessage();
            }
        }

        function sendFloatMessage() {
            const input = document.getElementById('float-input-field');
            const message = input.value.trim();
            if (!message) return;
            
            input.value = '';

            fetch("{{ route('api.chat.send') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    session_id: floatSessionId,
                    name: floatUserName,
                    email: floatUserEmail,
                    message: message
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    loadFloatMessages();
                }
            })
            .catch(err => console.error("Error sending float message:", err));
        }

        // Initialize after all DOM is ready — script is inside body so HTML below is not yet parsed
        // Use window.onload or defer via setTimeout to ensure widget HTML is available
        window.addEventListener('load', function() {
            initFloatChatUI();
        });
    </script>

    <!-- ======= FLOATING CHAT WIDGET HTML ======= -->
    <div class="fixed bottom-6 right-6 z-50 flex flex-col items-end gap-3 font-sans">
        <!-- Floating Chat Popup -->
        <div id="floating-chat-popup" class="hidden w-[330px] h-[440px] bg-[#efeae2] dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl shadow-2xl overflow-hidden flex-col animate-fade-in">
            <!-- Header -->
            <div class="bg-[#155dfc] p-4 flex items-center justify-between text-white shrink-0 shadow-md">
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <div class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center text-lg font-bold text-white overflow-hidden animate-pulse">
                            <span>💬</span>
                        </div>
                        <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-400 border-2 border-[#155dfc] rounded-full"></span>
                    </div>
                    <div>
                        <h4 class="text-xs font-black tracking-wide">Bantuan LPK MPI</h4>
                        <p id="float-chat-status" class="text-[9px] text-blue-100 font-bold flex items-center gap-1">
                            <span class="inline-block w-1.5 h-1.5 bg-emerald-400 rounded-full animate-ping"></span> Online
                        </p>
                    </div>
                </div>
                <button onclick="toggleFloatingChat()" class="text-white hover:text-slate-200 text-lg font-extrabold">&times;</button>
            </div>

            <!-- Setup Form -->
            <div id="float-setup-form" class="flex-1 p-6 flex flex-col justify-center space-y-4 bg-white dark:bg-slate-900 hidden">
                <div class="text-center space-y-1">
                    <h5 class="text-xs font-black text-slate-800 dark:text-white uppercase tracking-wider">Mulai Obrolan</h5>
                    <p class="text-[10px] text-slate-400 font-semibold">Silakan isi nama dan email Anda untuk memulai chat bantuan.</p>
                </div>
                <div class="space-y-3">
                    <div>
                        <label class="block text-[9px] font-bold text-slate-400 uppercase mb-1">Nama Lengkap</label>
                        <input type="text" id="float-setup-name" placeholder="Contoh: Ahmad" class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-3 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold">
                    </div>
                    <div>
                        <label class="block text-[9px] font-bold text-slate-400 uppercase mb-1">Alamat Email</label>
                        <input type="email" id="float-setup-email" placeholder="Contoh: ahmad@gmail.com" class="w-full bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl px-3 py-2 text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 font-semibold font-mono">
                    </div>
                </div>
                <button onclick="submitFloatSetup()" class="w-full bg-[#155dfc] hover:bg-blue-700 text-white font-extrabold text-xs uppercase py-2.5 rounded-xl shadow-md transition-all">Mulai Obrolan</button>
            </div>

            <!-- Messages Container -->
            <div id="float-messages-container" class="flex-1 p-4 overflow-y-auto space-y-3.5 flex flex-col min-h-0 hidden" style="background-image: url('https://user-images.githubusercontent.com/15075759/28719144-86dc0f70-73b1-11e7-911d-60d70fcded21.png'); background-size: cover; background-repeat: repeat; background-blend-mode: overlay; background-color: rgba(239, 234, 226, 0.95);">
                <!-- Initial messages will be dynamically injected here -->
            </div>

            <!-- Input Bar -->
            <div id="float-input-bar" class="bg-[#f0f0f0] dark:bg-slate-950 p-2.5 flex items-center gap-2 border-t border-slate-200 dark:border-slate-800 shrink-0 hidden">
                <input type="text" id="float-input-field" onkeypress="handleFloatKeyPress(event)" placeholder="Ketik pesan..." class="flex-1 bg-white dark:bg-slate-900 border-0 rounded-full px-4 py-2 text-xs text-slate-900 dark:text-white focus:outline-none shadow-sm font-semibold">
                <button onclick="sendFloatMessage()" class="w-9 h-9 rounded-full bg-[#155dfc] hover:bg-blue-700 text-white flex items-center justify-center shrink-0 shadow-md">
                    <svg class="w-4 h-4 transform rotate-45 -translate-x-0.5 translate-y-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M2 21l21-9L2 3v7l15 2-15 2v7z"/></svg>
                </button>
            </div>
        </div>

        <!-- Floating Chat Button -->
        <button onclick="toggleFloatingChat()" class="w-14 h-14 rounded-full bg-[#155dfc] hover:bg-blue-700 text-white flex items-center justify-center shadow-2xl relative transition-all active:scale-95 border-2 border-white/20">
            <svg id="float-chat-icon-msg" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            <div id="float-chat-icon-close" class="hidden items-center justify-center gap-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                <span class="text-xs font-black select-none">✕</span>
            </div>
        </button>
    </div>
@endsection

