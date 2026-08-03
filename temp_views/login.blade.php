@php
    $isIndo = (app()->getLocale() === 'id');
    
    // Translations
    $t = [
        'title' => $isIndo ? 'Portal Masuk | ' . ($siteTitle ?? 'LPK-MI') : 'Login Portal | ' . ($siteTitle ?? 'LPK-MI'),
        'login_title' => $isIndo ? 'PORTAL MASUK' : 'LOGIN PORTAL',
        'login_subtitle' => $isIndo ? 'Silakan masuk menggunakan nama pengguna & kata sandi atau akun Google Anda.' : 'Please sign in using your username & password or Google account.',
        'login_username_label' => $isIndo ? 'Nama Pengguna (Username)' : 'Username',
        'login_password_label' => $isIndo ? 'Kata Sandi' : 'Password',
        'login_submit' => $isIndo ? 'MASUK' : 'LOG IN',
        'login_or_divider' => $isIndo ? 'Atau masuk dengan' : 'Or sign in with',
        'google_login' => $isIndo ? 'MASUK DENGAN GOOGLE' : 'SIGN IN WITH GOOGLE',
        'back_home' => $isIndo ? ' Kembali ke Beranda' : ' Back to Homepage',
        
        // Register Card
        'reg_badge' => $isIndo ? 'Formulir Registrasi' : 'Registration Form',
        'reg_title' => $isIndo ? 'PENDAFTARAN PELATIHAN' : 'TRAINING ENROLLMENT',
        'reg_subtitle' => $isIndo ? 'Lengkapi formulir di bawah ini untuk mendaftar program pelatihan kerja.' : 'Fill in the form below to register for a training program.',
        'reg_program' => $isIndo ? 'Program Pelatihan' : 'Training Program',
        'reg_choose_program' => $isIndo ? 'Pilih Program Pelatihan...' : 'Select Training Program...',
        'reg_name' => $isIndo ? 'Nama Lengkap (Sesuai KTP)' : 'Full Name (as in Identity Card)',
        'reg_nik' => $isIndo ? 'NIK (16 Digit)' : 'National ID / NIK (16 Digits)',
        'reg_email' => $isIndo ? 'Email Aktif' : 'Active Email Address',
        'reg_phone' => $isIndo ? 'No. HP / WhatsApp' : 'Phone / WhatsApp Number',
        'reg_education' => $isIndo ? 'Pendidikan Terakhir' : 'Last Education',
        'reg_choose_edu' => $isIndo ? 'Pilih Pendidikan...' : 'Select Education...',
        'reg_edu_s3' => $isIndo ? 'S3 / Doktor' : 'Doctorate / S3',
        'reg_edu_s2' => $isIndo ? 'S2 / Magister' : 'Master / S2',
        'reg_edu_s1' => $isIndo ? 'S1 / Sarjana' : 'Bachelor / S1',
        'reg_edu_d4' => $isIndo ? 'D4 / Diploma IV' : 'Diploma IV / D4',
        'reg_edu_d3' => $isIndo ? 'D3 / Diploma III' : 'Diploma III / D3',
        'reg_edu_sma' => $isIndo ? 'SMA / SMK / MA' : 'High School / SMA / SMK',
        
        'reg_job_cat' => $isIndo ? 'Kategori Pekerjaan' : 'Job Category',
        'reg_choose_cat' => $isIndo ? 'Pilih Kategori...' : 'Select Category...',
        'reg_cat_guru' => $isIndo ? 'Guru Madrasah' : 'Madrasah Teacher',
        'reg_cat_mhs' => $isIndo ? 'Mahasiswa / Dosen' : 'Student / Lecturer',
        'reg_cat_kerja' => $isIndo ? 'Praktisi / Umum' : 'Practitioner / General Public',
        
        'reg_company' => $isIndo ? 'Nama Instansi / Perusahaan' : 'Company / Institution Name',
        'reg_company_placeholder' => $isIndo ? 'Nama Madrasah / Kampus' : 'School / Campus / Company Name',
        'reg_position' => $isIndo ? 'Jabatan Saat Ini' : 'Current Position',
        'reg_position_placeholder' => $isIndo ? 'Contoh: Guru / Dosen / Staf' : 'e.g. Teacher / Lecturer / Staff',
        
        'reg_submit' => $isIndo ? 'DAFTAR SEKARANG' : 'REGISTER NOW',
        
        // Success Card
        'success_title' => $isIndo ? 'Pendaftaran Berhasil!' : 'Registration Successful!',
        'success_desc' => $isIndo ? 'Selamat! Anda telah terdaftar dan sistem telah menerbitkan Sertifikat Pelatihan LPK sebagai bukti kompetensi.' : 'Congratulations! You have successfully registered and the system has issued a Training Competency Certificate.',
        'cert_title' => $isIndo ? 'Sertifikat Kelulusan Pelatihan' : 'Training Graduation Certificate',
        'cert_awarded' => $isIndo ? 'Diberikan Kepada:' : 'Awarded To:',
        'cert_competent' => $isIndo ? 'Telah menyelesaikan pelatihan kompetensi dengan predikat KOMPETEN pada program:' : 'Has successfully completed the competency training with a COMPETENT rating in:',
        'cert_no' => $isIndo ? 'No. Sertifikat:' : 'Certificate No:',
        'cert_date' => $isIndo ? 'Tanggal Terbit:' : 'Date of Issue:',
        'btn_copy' => $isIndo ? 'Salin Nomor Sertifikat' : 'Copy Certificate Number',
        'btn_again' => $isIndo ? 'Daftar Lagi' : 'Register Again',
    ];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $t['title'] }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Vite Assets (Tailwind & JS) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Google Fonts: Inter & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;550;600;700;800;900&family=Outfit:wght@400;600;800;900&display=swap" rel="stylesheet">

    <!-- Inline script to apply theme instantly -->
    <script>
        const savedTheme = localStorage.getItem('lpk_theme');
        const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        if (savedTheme === 'dark' || (!savedTheme && systemDark)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(rgba(15, 23, 42, 0.78), rgba(15, 23, 42, 0.78)), 
                        url('{{ !empty($settings["login_bg_image"]) ? asset("storage/" . $settings["login_bg_image"]) : "https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=2000" }}') no-repeat center center fixed;
            background-size: cover;
        }
        .outfit-font {
            font-family: 'Outfit', sans-serif;
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.3);
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(148, 163, 184, 0.5);
        }
        *, ::before, ::after { border-radius: 0px !important; }
        .text-\[9px\] { font-size: 0.75rem !important; }
        .text-\[10px\] { font-size: 0.75rem !important; }
        .text-\[11px\] { font-size: 0.875rem !important; }
    </style>
</head>
<body class="text-slate-950 dark:text-white min-h-screen flex flex-col justify-center items-center p-4 relative overflow-x-hidden transition-colors duration-300">

    <!-- Theme Toggle Floating Button -->
    <div class="absolute top-6 right-6 z-20">
        <button id="theme-toggle" class="bg-white/10 dark:bg-slate-900/40 hover:bg-white/20 dark:hover:bg-slate-800/60 text-white p-2.5 rounded-lg border border-white/15 shadow-sm transition flex items-center justify-center" aria-label="Ubah Tema">
            <svg class="w-4.5 h-4.5 hidden dark:block" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707.707M12 8a4 4 0 100 8 4 4 0 000-8z"></path>
            </svg>
            <svg class="w-4.5 h-4.5 block dark:hidden" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
            </svg>
        </button>
    </div>

    <!-- Main Container Card -->
    <main class="w-full max-w-5xl bg-white dark:bg-slate-900 rounded-2xl overflow-hidden shadow-2xl flex flex-col md:flex-row border border-slate-100 dark:border-slate-800/80 transition-all duration-300 min-h-[620px]">
        
        <!-- Left Side: Branding Panel -->
        <div class="w-full md:w-5/12 bg-[#1e5afb] p-12 md:p-14 flex flex-col justify-between text-white select-none relative overflow-hidden">
            <!-- Background Glow inside panel -->
            <div class="absolute -right-24 -top-24 w-48 h-48 bg-blue-500/20 rounded-full blur-2xl pointer-events-none"></div>
            
            <div class="relative z-10">
                <h2 class="outfit-font text-[#facc15] font-black text-3xl tracking-wide uppercase leading-tight">
                    {{ $settings['login_left_title_1'] ?? 'LEMBAGA SERTIFIKASI' }}<br>{{ $settings['login_left_title_2'] ?? 'PROFESI' }}
                </h2>
                <span class="text-white/90 font-bold text-sm uppercase tracking-widest block mt-2">
                    {{ $settings['login_left_sub'] ?? '(lsp) p3' }}
                </span>
                <h1 class="outfit-font text-white font-black text-4xl md:text-5xl mt-8 leading-none tracking-tight uppercase">
                    {!! nl2br(e($settings['login_left_main'] ?? "MANAJEMEN\nPENDIDIKAN\nISLAM")) !!}
                </h1>
            </div>

            <div class="relative z-10 mt-14 md:mt-0">
                <h3 class="outfit-font text-white font-black text-base tracking-widest uppercase">
                    {{ $settings['login_left_footer_title'] ?? 'SKKNI' }}
                </h3>
                <p class="text-white/80 text-xs mt-1.5 leading-relaxed font-medium">
                    {{ $settings['login_left_footer_desc'] ?? 'Standar Kompetensi Kerja Khusus Manajemen Pendidikan Islam' }}
                </p>
            </div>
        </div>

        <!-- Right Side: Forms Container -->
        <div class="w-full md:w-7/12 p-12 md:p-14 flex flex-col justify-between bg-white dark:bg-slate-900 relative">
            
            <!-- 1. LOGIN CARD VIEW -->
            <div id="login-card" class="flex flex-col justify-between h-full transition-all duration-300">
                <div class="my-auto py-4">
                    <div class="mb-8">
                        <h2 class="outfit-font text-3xl md:text-4xl font-black text-slate-900 dark:text-white tracking-tight uppercase">
                            {{ $t['login_title'] }}
                        </h2>
                        <p class="text-slate-500 dark:text-slate-400 text-sm mt-2 leading-relaxed">
                            {{ $t['login_subtitle'] }}
                        </p>
                    </div>

                    <!-- Validation Errors -->
                    @if ($errors->any())
                        <div class="mb-5 p-4 bg-rose-500/10 border border-rose-500/20 text-rose-700 dark:text-rose-455 rounded-xl text-xs space-y-1">
                            @foreach ($errors->all() as $error)
                                <p>• {{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form action="/login" method="POST" class="space-y-4">
                        @csrf
                        <div class="flex flex-col gap-1.5">
                            <label for="login-username" class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">{{ $t['login_username_label'] }}</label>
                            <input type="text" id="login-username" name="username" value="{{ old('username') }}" placeholder="Contoh: admin" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-md px-4 py-3 text-base text-slate-900 dark:text-slate-200 focus:outline-none focus:border-[#1e5afb] dark:focus:border-blue-400 focus:bg-white transition-all placeholder:text-slate-400 dark:placeholder:text-slate-600">
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label for="login-password" class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">{{ $t['login_password_label'] }}</label>
                            <div class="relative w-full">
                                <input type="password" id="login-password" name="password" placeholder="••••••••" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-md pl-4 pr-11 py-3 text-base text-slate-900 dark:text-slate-200 focus:outline-none focus:border-[#1e5afb] dark:focus:border-blue-400 focus:bg-white transition-all placeholder:text-slate-400 dark:placeholder:text-slate-600">
                                <button type="button" onclick="togglePasswordVisibility(this)" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-[#1e5afb] hover:bg-[#1546cb] text-white font-bold py-4 px-8 rounded-md shadow-md transition duration-300 flex items-center justify-center gap-2 uppercase text-base tracking-wider outfit-font">
                            {{ $t['login_submit'] }} →
                        </button>
                    </form>

                    <div class="relative flex py-4 items-center">
                        <div class="flex-grow border-t border-slate-100 dark:border-slate-800/80"></div>
                        <span class="flex-shrink mx-4 text-slate-400 dark:text-slate-500 text-xs font-bold uppercase tracking-widest">{{ $t['login_or_divider'] }}</span>
                        <div class="flex-grow border-t border-slate-100 dark:border-slate-800/80"></div>
                    </div>

                    <div>
                        <a href="{{ route('auth.google') }}" class="w-full bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-700 font-bold py-4.5 px-8 rounded-md shadow-sm transition duration-300 flex items-center justify-center gap-4.5 uppercase text-sm tracking-wider">
                            <svg class="w-5.5 h-5.5 fill-current" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.24 10.285V14.4h6.887c-.648 2.41-2.519 4.114-6.887 4.114-4.69 0-8.5-3.81-8.5-8.5s3.81-8.5 8.5-8.5c2.1 0 4.005.765 5.485 2.03l3.07-3.07C18.665.92 15.65 0 12.24 0 5.48 0 0 5.48 0 12.24s5.48 12.24 12.24 12.24c6.78 0 12.24-5.48 12.24-12.24 0-.82-.075-1.635-.225-2.425H12.24z"/>
                            </svg>
                            <span>{{ $t['google_login'] }}</span>
                        </a>
                    </div>
                </div>

                <div class="mt-8 border-t border-slate-100 dark:border-slate-800/80 pt-6">
                    <div class="flex flex-col sm:flex-row sm:justify-between items-center gap-3">
                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            {{ $isIndo ? 'Belum terdaftar?' : 'Not registered?' }}
                            <button type="button" id="link-to-register" class="text-[#1e5afb] dark:text-blue-400 font-bold hover:underline ml-1">
                                {{ $isIndo ? 'Daftar di sini' : 'Register here' }}
                            </button>
                        </p>
                        <a href="/" class="text-sm text-slate-500 hover:text-[#1e5afb] dark:text-slate-400 dark:hover:text-blue-400 font-medium flex items-center gap-1 transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            <span>{{ $t['back_home'] }}</span>
                        </a>
                    </div>
                </div>
            </div>            <!-- 2. REGISTRATION CARD VIEW -->
            <div id="register-card" class="hidden flex flex-col justify-between h-full transition-all duration-300">
                <div>
                    <div class="mb-4">
                        <h2 class="outfit-font text-3xl font-black text-slate-900 dark:text-white tracking-tight uppercase">
                            {{ $t['reg_title'] }}
                        </h2>
                        <p class="text-slate-500 dark:text-slate-400 text-base mt-1.5 leading-relaxed">
                            {{ $t['reg_subtitle'] }}
                        </p>
                    </div>

                    <div id="form-errors" class="hidden mb-4 p-4 bg-rose-500/10 border border-rose-500/20 text-rose-700 dark:text-rose-400 rounded-xl text-xs space-y-1"></div>

                    <!-- Scrollable Form Container to prevent overflow -->
                    <form id="enrollment-form" action="{{ route('enroll') }}" method="POST" class="space-y-4 max-h-[350px] overflow-y-auto custom-scrollbar pr-2.5">
                        @csrf
                        <div class="flex flex-col gap-1.5">
                            <label for="enroll-program" class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">{{ $t['reg_program'] }}</label>
                            <select id="enroll-program" name="program_id" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-md px-4 py-3 text-base text-slate-900 dark:text-slate-200 focus:outline-none focus:border-[#1e5afb] dark:focus:border-blue-400 focus:bg-white transition-all">
                                <option value="" disabled selected class="dark:bg-slate-900">{{ $t['reg_choose_program'] }}</option>
                                @foreach($programs as $prog)
                                    <option value="{{ $prog->id }}" class="dark:bg-slate-900">{{ $prog->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="flex flex-col gap-1.5">
                                <label for="enroll-name" class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">{{ $t['reg_name'] }}</label>
                                <input type="text" id="enroll-name" name="name" placeholder="Contoh: Dr. Hamidun, M.Pd" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-md px-4 py-3 text-base text-slate-900 dark:text-slate-200 focus:outline-none focus:border-[#1e5afb] dark:focus:border-blue-400 focus:bg-white transition-all placeholder:text-slate-400 dark:placeholder:text-slate-600">
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label for="enroll-nik" class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">{{ $t['reg_nik'] }}</label>
                                <input type="text" id="enroll-nik" name="nik" maxlength="16" placeholder="16 Digit NIK" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-md px-4 py-3 text-base text-slate-900 dark:text-slate-200 focus:outline-none focus:border-[#1e5afb] dark:focus:border-blue-400 focus:bg-white transition-all placeholder:text-slate-400 dark:placeholder:text-slate-600 font-mono">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="flex flex-col gap-1.5">
                                <label for="enroll-email" class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">{{ $t['reg_email'] }}</label>
                                <input type="email" id="enroll-email" name="email" placeholder="nama@email.com" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-md px-4 py-3 text-base text-slate-900 dark:text-slate-200 focus:outline-none focus:border-[#1e5afb] dark:focus:border-blue-400 focus:bg-white transition-all placeholder:text-slate-400 dark:placeholder:text-slate-600">
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label for="enroll-phone" class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">{{ $t['reg_phone'] }}</label>
                                <input type="text" id="enroll-phone" name="phone" placeholder="08xxxxxxxxx" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-md px-4 py-3 text-base text-slate-900 dark:text-slate-200 focus:outline-none focus:border-[#1e5afb] dark:focus:border-blue-400 focus:bg-white transition-all placeholder:text-slate-400 dark:placeholder:text-slate-600">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="flex flex-col gap-1.5">
                                <label for="enroll-education" class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">{{ $t['reg_education'] }}</label>
                                <select id="enroll-education" name="education" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-md px-4 py-3 text-base text-slate-900 dark:text-slate-200 focus:outline-none focus:border-[#1e5afb] dark:focus:border-blue-400 focus:bg-white transition-all">
                                    <option value="" disabled selected class="dark:bg-slate-900">{{ $t['reg_choose_edu'] }}</option>
                                    <option value="S3" class="dark:bg-slate-900">{{ $t['reg_edu_s3'] }}</option>
                                    <option value="S2" class="dark:bg-slate-900">{{ $t['reg_edu_s2'] }}</option>
                                    <option value="S1" class="dark:bg-slate-900">{{ $t['reg_edu_s1'] }}</option>
                                    <option value="D4" class="dark:bg-slate-900">{{ $t['reg_edu_d4'] }}</option>
                                    <option value="D3" class="dark:bg-slate-900">{{ $t['reg_edu_d3'] }}</option>
                                    <option value="SMA" class="dark:bg-slate-900">{{ $t['reg_edu_sma'] }}</option>
                                </select>
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label for="enroll-category" class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">{{ $t['reg_job_cat'] }}</label>
                                <select id="enroll-category" name="category" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-md px-4 py-3 text-base text-slate-900 dark:text-slate-200 focus:outline-none focus:border-[#1e5afb] dark:focus:border-blue-400 focus:bg-white transition-all">
                                    <option value="" disabled selected class="dark:bg-slate-900">{{ $t['reg_choose_cat'] }}</option>
                                    <option value="guru" class="dark:bg-slate-900">{{ $t['reg_cat_guru'] }}</option>
                                    <option value="mahasiswa" class="dark:bg-slate-900">{{ $t['reg_cat_mhs'] }}</option>
                                    <option value="kerja" class="dark:bg-slate-900">{{ $t['reg_cat_kerja'] }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="flex flex-col gap-1.5">
                                <label for="enroll-company" class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">{{ $t['reg_company'] }}</label>
                                <input type="text" id="enroll-company" name="company" placeholder="{{ $t['reg_company_placeholder'] }}" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-md px-4 py-3 text-base text-slate-900 dark:text-slate-200 focus:outline-none focus:border-[#1e5afb] dark:focus:border-blue-400 focus:bg-white transition-all placeholder:text-slate-400 dark:placeholder:text-slate-600">
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label for="enroll-position" class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">{{ $t['reg_position'] }}</label>
                                <input type="text" id="enroll-position" name="position" placeholder="{{ $t['reg_position_placeholder'] }}" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-md px-4 py-3 text-base text-slate-900 dark:text-slate-200 focus:outline-none focus:border-[#1e5afb] dark:focus:border-blue-400 focus:bg-white transition-all placeholder:text-slate-400 dark:placeholder:text-slate-600">
                            </div>
                        </div>

                        <!-- OTP Verification Section (Hidden initially) -->
                        <div id="otp-section" class="hidden border border-blue-500/20 bg-blue-500/5 dark:bg-blue-950/20 p-4 rounded-md space-y-3 transition-all duration-300">
                            <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800 pb-2">
                                <span class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Verifikasi Email Aktif</span>
                                <span class="text-[10px] text-blue-700 dark:text-blue-400 bg-blue-500/10 px-2 py-0.5 rounded font-black tracking-wider uppercase">OTP Required</span>
                            </div>
                            <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                                Kami telah mengirimkan 6-digit kode verifikasi ke email Anda. Silakan periksa kotak masuk (atau folder spam).
                            </p>
                            
                            <!-- Local development debug helper -->
                            <div id="otp-debug-helper" class="hidden text-xs bg-amber-500/10 border border-amber-500/20 text-amber-600 dark:text-amber-400 p-3 rounded font-semibold leading-relaxed"></div>
                            
                            <div class="flex flex-col sm:flex-row gap-2">
                                <div class="flex-1">
                                    <input type="text" id="otp-code-input" name="otp_code" placeholder="Masukkan 6-digit kode" class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-md px-4 py-2.5 text-base text-slate-900 dark:text-slate-200 focus:outline-none focus:border-[#1e5afb] dark:focus:border-blue-400 tracking-widest font-mono text-center text-lg">
                                </div>
                                <button type="button" id="btn-resend-otp" class="bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold text-xs uppercase tracking-wider px-4 py-2 rounded-md transition-all flex items-center justify-center gap-2">
                                    Kirim Ulang (<span id="otp-countdown">60</span>s)
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-[#1e5afb] hover:bg-[#1546cb] text-white font-bold py-4 px-8 rounded-md shadow-md transition duration-300 flex items-center justify-center gap-2 uppercase text-base tracking-wider outfit-font">
                            {{ $t['reg_submit'] }} →
                        </button>
                    </form>
                </div>

                <div class="mt-6 border-t border-slate-100 dark:border-slate-800/80 pt-4">
                    <p class="text-base text-slate-600 dark:text-slate-400">
                        {{ $isIndo ? 'Sudah memiliki akun?' : 'Already have an account?' }}
                        <button type="button" id="link-to-login" class="text-[#1e5afb] dark:text-blue-400 font-bold hover:underline ml-1">
                            {{ $isIndo ? 'Masuk di sini' : 'Login here' }}
                        </button>
                    </p>
                </div>
            </div>

            <!-- 3. SUCCESS CARD VIEW -->
            <div id="enrollment-success-card" class="hidden flex flex-col justify-between h-full transition-all duration-300 text-center">
                <div class="my-auto py-2">
                    <div class="w-14 h-14 rounded-full bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-emerald-500/25 flex items-center justify-center mx-auto mb-4 shadow-sm">
                        <svg class="w-6.5 h-6.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <h3 class="outfit-font text-2xl font-extrabold text-slate-900 dark:text-white mb-2 tracking-tight uppercase">{{ $t['success_title'] }}</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-sm mb-6 max-w-md mx-auto leading-relaxed">
                        {{ $t['success_desc'] }}
                    </p>
                    
                    <div class="certificate-badge rounded-xl p-5 text-center shadow-lg border border-slate-200/50 dark:border-white/5 bg-slate-50/50 dark:bg-slate-950/40 mb-6 max-w-md mx-auto">
                        <div class="cert-header mb-4">
                            <h4 class="text-blue-800 dark:text-blue-300 text-sm font-bold tracking-[2px] uppercase outfit-font">{{ $t['cert_title'] }}</h4>
                            <span class="text-xs text-slate-500 uppercase tracking-widest block mt-0.5">LPK-MI</span>
                        </div>
                        <div class="cert-body my-6">
                            <p class="text-xs text-slate-500 italic">{{ $t['cert_awarded'] }}</p>
                            <h2 id="cert-holder-name" class="text-xl font-extrabold text-slate-900 dark:text-white my-2 tracking-wide uppercase font-black">-</h2>
                            <p class="text-xs text-slate-400 max-w-xs mx-auto leading-relaxed">{{ $t['cert_competent'] }}</p>
                            <h3 id="cert-program-name" class="text-sm text-blue-700 dark:text-sky-400 font-bold mt-2 mb-4 tracking-wide">-</h3>
                            <div class="flex justify-center gap-6 text-xs border-t border-slate-200 dark:border-white/5 pt-4 max-w-xs mx-auto">
                                <div class="flex flex-col text-left">
                                    <span class="text-xs text-slate-500">{{ $t['cert_no'] }}</span>
                                    <span class="font-semibold text-slate-800 dark:text-slate-200 font-mono" id="cert-number-val">-</span>
                                </div>
                                <div class="flex flex-col text-left">
                                    <span class="text-xs text-slate-500">{{ $t['cert_date'] }}</span>
                                    <span class="font-semibold text-slate-800 dark:text-slate-200" id="cert-date-val">-</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap justify-center gap-3">
                        <button class="bg-[#1e5afb] hover:bg-[#1546cb] text-white font-bold py-2.5 px-4 rounded-md text-xs uppercase tracking-wider transition-all shadow-md" id="copy-cert-num-btn">{{ $t['btn_copy'] }}</button>
                        <button class="bg-white dark:bg-slate-900 hover:bg-slate-50 dark:hover:bg-slate-800 border border-slate-300 dark:border-slate-700 text-slate-600 dark:text-slate-400 py-2.5 px-4 rounded-md text-xs uppercase tracking-wider transition-all" id="reset-enrollment-btn">{{ $t['btn_again'] }}</button>
                    </div>
                </div>
            </div>

            <!-- Copyright footer at bottom of right column -->
            <div class="mt-8 text-center">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest block leading-relaxed">
                    © 2026 COPYRIGHT © 2026 {{ $siteTitle ?? 'LSP MPI' }}. ALL RIGHTS RESERVED.<br>SISTEM INFORMASI TERINTEGRASI
                </span>
            </div>

        </div>
    </main>

    <!-- Footer of the page (hidden or kept minimal) -->
    <div class="mt-6 text-center text-xs text-white/55">
        &copy; 2026 {{ $siteTitle ?? 'LSP MPI' }}. Lembaga Sertifikasi Profesi.
    </div>

    <!-- Theme Toggle logic & AJAX logic -->
    <script>
        // Theme toggle
        const toggleBtn = document.getElementById('theme-toggle');
        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('lpk_theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('lpk_theme', 'dark');
                }
            });
        }

        // Switching card views
        const loginCard = document.getElementById('login-card');
        const registerCard = document.getElementById('register-card');
        const successCard = document.getElementById('enrollment-success-card');

        function showRegisterView() {
            loginCard.classList.add('hidden');
            successCard.classList.add('hidden');
            registerCard.classList.remove('hidden');
        }

        function showLoginView() {
            registerCard.classList.add('hidden');
            successCard.classList.add('hidden');
            loginCard.classList.remove('hidden');
        }

        function showSuccessView() {
            loginCard.classList.add('hidden');
            registerCard.classList.add('hidden');
            successCard.classList.remove('hidden');
        }

        document.getElementById('link-to-register').addEventListener('click', showRegisterView);
        document.getElementById('link-to-login').addEventListener('click', showLoginView);

        // Pre-select program from URL query param and switch view
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const programId = urlParams.get('program');
            if (programId) {
                const select = document.getElementById('enroll-program');
                if (select) {
                    select.value = programId;
                }
                showRegisterView();
            }
        });

        // AJAX Form Submission
        const form = document.getElementById('enrollment-form');
        if (form) {
            const otpSection = document.getElementById('otp-section');
            const otpCodeInput = document.getElementById('otp-code-input');
            const otpDebugHelper = document.getElementById('otp-debug-helper');
            const btnResendOtp = document.getElementById('btn-resend-otp');
            const otpCountdown = document.getElementById('otp-countdown');
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalSubmitText = submitBtn.innerHTML;

            let countdownInterval = null;

            function startCountdown() {
                let seconds = 60;
                btnResendOtp.disabled = true;
                otpCountdown.textContent = seconds;
                clearInterval(countdownInterval);
                countdownInterval = setInterval(() => {
                    seconds--;
                    otpCountdown.textContent = seconds;
                    if (seconds <= 0) {
                        clearInterval(countdownInterval);
                        btnResendOtp.disabled = false;
                        btnResendOtp.innerHTML = '{{ $isIndo ? "Kirim Ulang" : "Resend" }}';
                    } else {
                        btnResendOtp.innerHTML = `{{ $isIndo ? "Kirim Ulang" : "Resend" }} (${seconds}s)`;
                    }
                }, 1000);
            }

            async function sendOtpRequest(email, csrfToken) {
                const response = await fetch("{{ route('enroll.send-otp') }}", {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken 
                    },
                    body: JSON.stringify({ email })
                });
                const data = await response.json();
                if (!response.ok) {
                    throw data;
                }
                return data;
            }

            btnResendOtp.addEventListener('click', async () => {
                const emailInput = document.getElementById('enroll-email');
                const email = emailInput.value;
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                try {
                    btnResendOtp.disabled = true;
                    btnResendOtp.innerHTML = '{{ $isIndo ? "Mengirim..." : "Sending..." }}';
                    const data = await sendOtpRequest(email, csrfToken);
                    startCountdown();
                    if (data.debug_code) {
                        otpDebugHelper.classList.remove('hidden');
                        otpDebugHelper.innerHTML = `[Developer Mode] Kode verifikasi Anda adalah: <strong class="text-blue-700 dark:text-blue-305 font-mono text-sm underline">${data.debug_code}</strong>`;
                    } else {
                        otpDebugHelper.classList.add('hidden');
                    }
                    alert('{{ $isIndo ? "Kode verifikasi telah dikirim ulang ke email Anda!" : "Verification code has been resent to your email!" }}');
                } catch (error) {
                    btnResendOtp.disabled = false;
                    btnResendOtp.innerHTML = '{{ $isIndo ? "Kirim Ulang" : "Resend" }}';
                    let errMsg = '{{ $isIndo ? "Gagal mengirim kode verifikasi." : "Failed to send verification code." }}';
                    if (error.errors && error.errors.email) {
                        errMsg = error.errors.email.join('\n');
                    }
                    alert(errMsg);
                }
            });

            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                const errorBox = document.getElementById('form-errors');
                errorBox.classList.add('hidden');
                errorBox.innerHTML = '';
                
                const emailInput = document.getElementById('enroll-email');
                const email = emailInput.value;
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // 1. Verify email ends with @gmail.com
                const gmailRegex = /^[a-zA-Z0-9._%+-]+@gmail\.com$/i;
                if (!gmailRegex.test(email)) {
                    errorBox.classList.remove('hidden');
                    const p = document.createElement('p');
                    p.innerHTML = '• {{ $isIndo ? "Alamat email harus menggunakan domain @gmail.com." : "Email address must use @gmail.com domain." }}';
                    errorBox.appendChild(p);
                    return;
                }

                // 2. If OTP section is not visible yet, send OTP first
                if (otpSection.classList.contains('hidden')) {
                    try {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<span class="animate-spin mr-2">⚙</span> {{ $isIndo ? "Mengirim Kode..." : "Sending Code..." }}';
                        
                        const data = await sendOtpRequest(email, csrfToken);
                        
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '{{ $isIndo ? "Verifikasi &amp; Daftar" : "Verify &amp; Register" }}';
                        otpSection.classList.remove('hidden');
                        otpCodeInput.required = true;
                        otpCodeInput.focus();
                        
                        startCountdown();
                        
                        if (data.debug_code) {
                            otpDebugHelper.classList.remove('hidden');
                            otpDebugHelper.innerHTML = `[Developer Mode] Kode verifikasi Anda adalah: <strong class="text-blue-700 dark:text-blue-305 font-mono text-sm underline">${data.debug_code}</strong>`;
                        } else {
                            otpDebugHelper.classList.add('hidden');
                        }
                    } catch (error) {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalSubmitText;
                        errorBox.classList.remove('hidden');
                        if (error.errors) {
                            Object.values(error.errors).forEach(errArray => {
                                errArray.forEach(err => {
                                    const p = document.createElement('p');
                                    p.innerHTML = `• ${err}`;
                                    errorBox.appendChild(p);
                                });
                            });
                        } else {
                            const p = document.createElement('p');
                            p.innerHTML = `• ${error.message || '{{ $isIndo ? "Terjadi kesalahan sistem." : "System error occurred." }}'}`;
                            errorBox.appendChild(p);
                        }
                    }
                    return;
                }

                // 3. Main submission (OTP section is visible)
                const formData = new FormData(form);
                try {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="animate-spin mr-2">⚙</span> {{ $isIndo ? "Memproses..." : "Processing..." }}';
                    
                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': csrfToken }
                    });
                    const data = await response.json();
                    if (!response.ok) {
                        if (data.errors) {
                            errorBox.classList.remove('hidden');
                            Object.values(data.errors).forEach(errArray => {
                                errArray.forEach(err => {
                                    const p = document.createElement('p');
                                    p.innerHTML = `• ${err}`;
                                    errorBox.appendChild(p);
                                });
                            });
                        } else {
                            throw new Error(data.message || '{{ $isIndo ? "Terjadi kesalahan sistem." : "System error occurred." }}');
                        }
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '{{ $isIndo ? "Verifikasi &amp; Daftar" : "Verify &amp; Register" }}';
                        return;
                    }
                    const trainee = data.trainee;
                    document.getElementById('cert-holder-name').textContent = trainee.name.toUpperCase();
                    document.getElementById('cert-program-name').textContent = trainee.program.title;
                    document.getElementById('cert-number-val').textContent = trainee.cert_number || '-';
                    document.getElementById('cert-date-val').textContent = trainee.cert_date || '-';
                    form.reset();
                    otpSection.classList.add('hidden');
                    otpCodeInput.required = false;
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalSubmitText;
                    
                    showSuccessView();
                    
                    document.getElementById('copy-cert-num-btn').onclick = () => {
                        if (trainee.cert_number) {
                            navigator.clipboard.writeText(trainee.cert_number);
                            alert(`{{ $isIndo ? "Nomor sertifikat berhasil disalin!" : "Certificate number copied successfully!" }} \n(${trainee.cert_number})`);
                        }
                    };
                    document.getElementById('reset-enrollment-btn').onclick = () => {
                        showRegisterView();
                    };
                } catch (error) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '{{ $isIndo ? "Verifikasi &amp; Daftar" : "Verify &amp; Register" }}';
                    alert(error.message || '{{ $isIndo ? "Terjadi kesalahan jaringan." : "Network error occurred." }}');
                }
            });
        }

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
    </script>
</body>
</html>
