@php
$isIndo = (app()->getLocale() === 'id' || true); // Default to Indonesian

// Translations
$t = [
'title' => $isIndo ? 'Portal Masuk | ' . ($siteTitle ?? 'LPK MPI') : 'Login Portal | ' . ($siteTitle ?? 'LPK MPI'),
'login_title' => $isIndo ? 'PORTAL MASUK' : 'LOGIN PORTAL',
'login_subtitle' => $isIndo ? 'Silakan masuk menggunakan nama pengguna dan kata sandi Anda.' : 'Please sign in using your username and password.',
'login_username_label' => $isIndo ? 'Nama Pengguna (Username)' : 'Username',
'login_password_label' => $isIndo ? 'Kata Sandi' : 'Password',
'login_submit' => $isIndo ? 'MASUK' : 'LOG IN',
'login_or_divider' => $isIndo ? 'Atau masuk dengan' : 'Or sign in with',
'google_login' => $isIndo ? 'MASUK DENGAN GOOGLE' : 'SIGN IN WITH GOOGLE',
'back_home' => $isIndo ? ' Kembali ke Beranda' : ' Back to Homepage',

// Register Card
'reg_badge' => $isIndo ? 'Formulir Registrasi' : 'Registration Form',
'reg_title' => $isIndo ? 'PENDAFTARAN PROGRAM PENDIDIKAN KERJA' : 'TRAINING ENROLLMENT',
'reg_subtitle' => $isIndo ? 'Lengkapi formulir di bawah ini untuk mendaftar program pendidikan kerja.' : 'Fill in the form below to register for a training program.',
'reg_program' => $isIndo ? 'Program Pendidikan' : 'Training Program',
'reg_choose_program' => $isIndo ? 'Pilih Program Pendidikan...' : 'Select Training Program...',
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
'reg_cat_guru' => $isIndo ? 'Pencari Kerja / Magang' : 'Job Seeker / Intern',
'reg_cat_mhs' => $isIndo ? 'Pelajar / Mahasiswa' : 'Student',
'reg_cat_kerja' => $isIndo ? 'Umum / Pekerja' : 'General / Worker',

'reg_company' => $isIndo ? 'Nama Sekolah / Perusahaan' : 'School / Company Name',
'reg_company_placeholder' => $isIndo ? 'Nama Sekolah / Perusahaan Asal' : 'School or Company Name',
'reg_position' => $isIndo ? 'Status / Jabatan' : 'Status / Position',
'reg_position_placeholder' => $isIndo ? 'Contoh: Siswa / Lulusan / Staf' : 'e.g. Student / Graduate / Staff',

'reg_submit' => $isIndo ? 'DAFTAR SEKARANG' : 'REGISTER NOW',

// Success Card
'success_title' => $isIndo ? 'Pendaftaran Berhasil!' : 'Registration Successful!',
'success_desc' => $isIndo ? 'Selamat! Anda telah terdaftar dan sistem telah menerbitkan Sertifikat Kelulusan Pelatihan LPK MPI.' : 'Congratulations! You have successfully registered and the system has issued a LPK MPI Training Graduation Certificate.',
'cert_title' => $isIndo ? 'Sertifikat Kelulusan Pelatihan' : 'Training Graduation Certificate',
'cert_awarded' => $isIndo ? 'Diberikan Kepada:' : 'Awarded To:',
'cert_competent' => $isIndo ? 'Telah menyelesaikan pelatihan kompetensi dengan predikat KOMPETEN pada program:' : 'Has successfully completed the competency training with a COMPETENT rating in:',
'cert_no' => $isIndo ? 'No. Sertifikat:' : 'Certificate No:',
'cert_date' => $isIndo ? 'Tanggal Terbit:' : 'Date of Issue:',
'btn_copy' => $isIndo ? 'Salin Nomor Sertifikat' : 'Copy Certificate Number',
'btn_again' => $isIndo ? 'Daftar Lagi' : 'Register Again',
];
@endphp
@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800;900&display=swap" rel="stylesheet">
<style>
    body {
        background: linear-gradient(rgba(15, 23, 42, 0.78), rgba(15, 23, 42, 0.78)),
        url('{{ !empty($settings["login_bg_image"]) ? asset("storage/" . $settings["login_bg_image"]) : "https://images.unsplash.com/photo-1540575467063-178a50c2df87?q=80&w=2000" }}') no-repeat center center fixed !important;
        background-size: cover !important;
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

    *,
    ::before,
    ::after {
        border-radius: 0px !important;
    }

    .text-\[9px\] {
        font-size: 0.75rem !important;
    }

    .text-\[10px\] {
        font-size: 0.75rem !important;
    }

    .text-\[11px\] {
        font-size: 0.875rem !important;
    }
</style>

<div class="flex items-center justify-center min-h-[70vh] py-8">
    <!-- Main Container Card -->
    <div class="w-full max-w-5xl bg-white dark:bg-slate-900 rounded-2xl overflow-hidden shadow-2xl flex flex-col md:flex-row border border-slate-100 dark:border-slate-800/80 transition-all duration-300 min-h-[620px]">

        <!-- Left Side: Branding Panel -->
        <div class="w-full md:w-5/12 bg-[#1e5afb] p-12 md:p-14 flex flex-col justify-between text-white select-none relative overflow-hidden">
            <!-- Background Glow inside panel -->
            <div class="absolute -right-24 -top-24 w-48 h-48 bg-blue-500/20 rounded-full blur-2xl pointer-events-none"></div>

            <div class="relative z-10">
                <h2 class="outfit-font text-[#facc15] font-black text-3xl tracking-wide uppercase leading-tight">
                    {{ $settings['login_left_title_1'] ?? 'LEMBAGA PENDIDIKAN' }}<br>{{ $settings['login_left_title_2'] ?? 'KERJA' }}
                </h2>
                <span class="text-white/90 font-bold text-sm uppercase tracking-widest block mt-2">
                    {{ $settings['login_left_sub'] ?? 'LPK MPI' }}
                </span>
                <h1 class="outfit-font text-white font-black text-4xl md:text-5xl mt-8 leading-none tracking-tight uppercase">
                    {!! nl2br(e($settings['login_left_main'] ?? "MANAJEMEN\nPENDIDIKAN\nINDONESIA")) !!}
                </h1>
            </div>

            <div class="relative z-10 mt-14 md:mt-0">
                <h3 class="outfit-font text-white font-black text-base tracking-widest uppercase">
                    {{ $settings['login_left_footer_title'] ?? 'LPK MPI' }}
                </h3>
                <p class="text-white/80 text-xs mt-1.5 leading-relaxed font-medium">
                    {{ $settings['login_left_footer_desc'] ?? 'Pusat Pendidikan & Sertifikasi Kerja Manajemen Pendidikan Indonesia Terintegrasi' }}
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
                    <div class="mb-5 p-4 bg-rose-500/10 border border-rose-500/20 text-rose-700 dark:text-rose-400 rounded-xl text-xs space-y-1">
                        @foreach ($errors->all() as $error)
                        <p>• {{ $error }}</p>
                        @endforeach
                    </div>
                    @endif

                    <form action="/login" method="POST" class="space-y-4">
                        @csrf
                        <div class="flex flex-col gap-1.5">
                            <label for="login-username" class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">{{ $t['login_username_label'] }}</label>
                            <input type="text" id="login-username" name="username" value="{{ old('username') }}" placeholder="Contoh: admin" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-md px-4 py-3 text-base text-slate-900 dark:text-slate-200 focus:outline-none focus:border-[#1e5afb] dark:focus:border-blue-400 focus:bg-white dark:focus:bg-slate-900 transition-all placeholder:text-slate-400 dark:placeholder:text-slate-600">
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label for="login-password" class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">{{ $t['login_password_label'] }}</label>
                            <div class="relative w-full">
                                <input type="password" id="login-password" name="password" placeholder="••••••••" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-md pl-4 pr-11 py-3 text-base text-slate-900 dark:text-slate-200 focus:outline-none focus:border-[#1e5afb] dark:focus:border-blue-400 focus:bg-white dark:focus:bg-slate-900 transition-all placeholder:text-slate-400 dark:placeholder:text-slate-600">
                                <button type="button" onclick="togglePasswordVisibility(this)" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-[#1e5afb] hover:bg-[#1546cb] text-white font-bold py-4 px-8 rounded-md shadow-md transition duration-300 flex items-center justify-center gap-2 uppercase text-base tracking-wider outfit-font">
                            {{ $t['login_submit'] }}
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </form>

                    <!-- Google SSO Option -->
                    <div class="relative flex py-4 items-center">
                        <div class="flex-grow border-t border-slate-200 dark:border-slate-800"></div>
                        <span class="flex-shrink mx-4 text-slate-400 text-xs font-semibold uppercase tracking-wider">{{ $t['login_or_divider'] }}</span>
                        <div class="flex-grow border-t border-slate-200 dark:border-slate-800"></div>
                    </div>

                    <a href="{{ route('auth.google') }}" class="w-full bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700/50 text-slate-700 dark:text-slate-300 font-bold py-3.5 px-8 rounded-md shadow-sm transition duration-300 flex items-center justify-center gap-3 uppercase text-sm tracking-wider outfit-font">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path fill="#EA4335" d="M12 5.04c1.66 0 3.2.57 4.38 1.69l3.27-3.27C17.67 1.54 14.98 1 12 1 7.35 1 3.37 3.67 1.39 7.56l3.85 2.99c.92-2.77 3.5-4.51 6.76-4.51z"/>
                            <path fill="#4285F4" d="M23.49 12.27c0-.81-.07-1.59-.2-2.34H12v4.44h6.44c-.28 1.48-1.12 2.73-2.38 3.58l3.69 2.87c2.16-1.99 3.74-4.92 3.74-8.55z"/>
                            <path fill="#FBBC05" d="M5.24 14.75c-.24-.72-.38-1.49-.38-2.29s.14-1.57.38-2.29L1.39 7.18C.5 8.97 0 10.97 0 13s.5 4.03 1.39 5.82l3.85-3.07z"/>
                            <path fill="#34A853" d="M12 23c3.24 0 5.97-1.07 7.96-2.91l-3.69-2.87c-1.02.68-2.33 1.09-3.92 1.09-3.26 0-5.84-1.74-6.76-4.51l-3.85 3.07C3.37 20.33 7.35 23 12 23z"/>
                        </svg>
                        {{ $t['google_login'] }}
                    </a>


                </div>

                <div class="mt-8 border-t border-slate-100 dark:border-slate-800/80 pt-6">
                    <div class="flex flex-col items-center gap-3 text-center">
                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            {{ $isIndo ? 'Belum terdaftar?' : 'Not registered?' }}
                            <button type="button" id="link-to-register" class="text-[#1e5afb] dark:text-blue-400 font-bold hover:underline ml-1">
                                {{ $isIndo ? 'Daftar di sini' : 'Register here' }}
                            </button>
                        </p>
                        <a href="/" class="text-sm text-slate-500 hover:text-[#1e5afb] dark:text-slate-400 dark:hover:text-blue-400 font-medium flex items-center gap-1 transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            <span>{{ $t['back_home'] }}</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- 2. REGISTRATION CARD VIEW -->
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
                    <form id="enrollment-form" action="{{ route('enroll') }}" method="POST" enctype="multipart/form-data" class="space-y-4 max-h-[350px] overflow-y-auto custom-scrollbar pr-2.5">
                        @csrf
                        <div class="flex flex-col gap-1.5">
                            <label for="enroll-program" class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">{{ $t['reg_program'] }}</label>
                            <select id="enroll-program" name="program_id" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-md px-4 py-3 text-base text-slate-900 dark:text-slate-200 focus:outline-none focus:border-[#1e5afb] dark:focus:border-blue-400 focus:bg-white dark:focus:bg-slate-900 transition-all">
                                <option value="" disabled selected class="dark:bg-slate-900">{{ $t['reg_choose_program'] }}</option>
                                @foreach($programs as $prog)
                                <option value="{{ $prog->id }}" class="dark:bg-slate-900">{{ $prog->title }} ({{ $prog->price }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="flex flex-col gap-1.5">
                                <label for="enroll-name" class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">{{ $t['reg_name'] }}</label>
                                <input type="text" id="enroll-name" name="name" placeholder="Contoh: Dr. Hamidun, M.Pd" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-md px-4 py-3 text-base text-slate-900 dark:text-slate-200 focus:outline-none focus:border-[#1e5afb] dark:focus:border-blue-400 focus:bg-white dark:focus:bg-slate-900 transition-all placeholder:text-slate-400 dark:placeholder:text-slate-600 font-semibold">
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label for="enroll-nik" class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">{{ $t['reg_nik'] }}</label>
                                <input type="text" id="enroll-nik" name="nik" maxlength="16" placeholder="16 Digit NIK" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-md px-4 py-3 text-base text-slate-900 dark:text-slate-200 focus:outline-none focus:border-[#1e5afb] dark:focus:border-blue-400 focus:bg-white dark:focus:bg-slate-900 transition-all placeholder:text-slate-400 dark:placeholder:text-slate-600 font-mono">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="flex flex-col gap-1.5">
                                <label for="enroll-email" class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">{{ $t['reg_email'] }}</label>
                                <input type="email" id="enroll-email" name="email" placeholder="nama@gmail.com" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-md px-4 py-3 text-base text-slate-900 dark:text-slate-200 focus:outline-none focus:border-[#1e5afb] dark:focus:border-blue-400 focus:bg-white dark:focus:bg-slate-900 transition-all placeholder:text-slate-400 dark:placeholder:text-slate-600">
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label for="enroll-phone" class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">{{ $t['reg_phone'] }}</label>
                                <input type="text" id="enroll-phone" name="phone" placeholder="08xxxxxxxxx" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-md px-4 py-3 text-base text-slate-900 dark:text-slate-200 focus:outline-none focus:border-[#1e5afb] dark:focus:border-blue-400 focus:bg-white dark:focus:bg-slate-900 transition-all placeholder:text-slate-400 dark:placeholder:text-slate-600">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="flex flex-col gap-1.5">
                                <label for="enroll-education" class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">{{ $t['reg_education'] }}</label>
                                <select id="enroll-education" name="education" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-md px-4 py-3 text-base text-slate-900 dark:text-slate-200 focus:outline-none focus:border-[#1e5afb] dark:focus:border-blue-400 focus:bg-white dark:focus:bg-slate-900 transition-all">
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
                                <select id="enroll-category" name="category" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-md px-4 py-3 text-base text-slate-900 dark:text-slate-200 focus:outline-none focus:border-[#1e5afb] dark:focus:border-blue-400 focus:bg-white dark:focus:bg-slate-900 transition-all">
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
                                <input type="text" id="enroll-company" name="company" placeholder="{{ $t['reg_company_placeholder'] }}" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-md px-4 py-3 text-base text-slate-900 dark:text-slate-200 focus:outline-none focus:border-[#1e5afb] dark:focus:border-blue-400 focus:bg-white dark:focus:bg-slate-900 transition-all placeholder:text-slate-400 dark:placeholder:text-slate-600">
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label for="enroll-position" class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">{{ $t['reg_position'] }}</label>
                                <input type="text" id="enroll-position" name="position" placeholder="{{ $t['reg_position_placeholder'] }}" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-md px-4 py-3 text-base text-slate-900 dark:text-slate-200 focus:outline-none focus:border-[#1e5afb] dark:focus:border-blue-400 focus:bg-white dark:focus:bg-slate-900 transition-all placeholder:text-slate-400 dark:placeholder:text-slate-600">
                            </div>
                        </div>

                        <!-- KTP and Ijazah file upload (Requirements) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="flex flex-col gap-1.5">
                                <label for="enroll-ktp" class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Berkas KTP (Maks. 2MB)</label>
                                <input type="file" id="enroll-ktp" name="ktp" accept="image/*" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-md px-3 py-2 text-xs text-slate-900 dark:text-slate-200 focus:outline-none focus:border-[#1e5afb] dark:focus:border-blue-400 transition-all file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-[10px] file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <label for="enroll-ijazah" class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Berkas Ijazah (Maks. 2MB)</label>
                                <input type="file" id="enroll-ijazah" name="ijazah" accept="image/*" required class="w-full bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-md px-3 py-2 text-xs text-slate-900 dark:text-slate-200 focus:outline-none focus:border-[#1e5afb] dark:focus:border-blue-400 transition-all file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-[10px] file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
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
                            {{ $t['reg_submit'] }}
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                            </svg>
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

            <!-- 3. PAYMENT CHECKOUT VIEW -->
            <div id="payment-checkout-card" class="hidden flex flex-col justify-between h-full transition-all duration-300">
                <div>
                    <div class="mb-4">
                        <span class="inline-block bg-blue-600/10 text-blue-700 dark:text-blue-400 px-3 py-1 rounded text-[10px] font-bold uppercase tracking-wider mb-2">Langkah 2: Pembayaran</span>
                        <h2 class="outfit-font text-2xl font-black text-slate-900 dark:text-white tracking-tight uppercase">
                            Checkout Pembayaran
                        </h2>
                        <p class="text-slate-500 dark:text-slate-400 text-xs mt-1 leading-relaxed">
                            Silakan pilih metode pembayaran Anda untuk menyelesaikan proses registrasi program pelatihan.
                        </p>
                    </div>

                    <div class="bg-slate-50 dark:bg-slate-950/40 border border-slate-200/60 dark:border-white/5 rounded-xl p-4 mb-5">
                        <div class="flex justify-between items-center text-xs border-b border-slate-200 dark:border-white/5 pb-2.5 mb-2.5">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Program Pelatihan:</span>
                            <span class="font-bold text-slate-900 dark:text-white text-right" id="checkout-program-title">-</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-500 dark:text-slate-400 font-medium">Total Tagihan:</span>
                            <span class="text-lg font-black text-blue-700 dark:text-blue-400" id="checkout-amount">-</span>
                        </div>
                    </div>

                    <form id="payment-form" class="space-y-4">
                        <input type="hidden" id="checkout-enrollment-id" name="enrollment_id">

                        <div class="flex flex-col gap-1.5">
                            <label class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Pilih Metode Pembayaran</label>

                            <div class="grid grid-cols-1 gap-2.5 max-h-[220px] overflow-y-auto pr-1.5 custom-scrollbar">
                                <!-- Bank Transfer -->
                                <label class="payment-method-option flex items-center justify-between p-3.5 border border-slate-200 dark:border-slate-800 rounded-lg cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800/40 transition">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="payment_method" value="Bank Transfer (Virtual Account)" checked class="text-[#1e5afb] focus:ring-[#1e5afb]">
                                        <div class="flex flex-col text-left">
                                            <span class="text-xs font-bold text-slate-900 dark:text-white">Transfer Bank (VA)</span>
                                            <span class="text-[10px] text-slate-400">BCA, Mandiri, BNI, BRI</span>
                                        </div>
                                    </div>
                                    <span class="text-[10px] bg-blue-500/10 text-blue-700 dark:text-blue-400 px-2 py-0.5 rounded font-bold">Instan</span>
                                </label>

                                <!-- E-Wallet -->
                                <label class="payment-method-option flex items-center justify-between p-3.5 border border-slate-200 dark:border-slate-800 rounded-lg cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800/40 transition">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="payment_method" value="E-Wallet (QRIS/GoPay/OVO/DANA)" class="text-[#1e5afb] focus:ring-[#1e5afb]">
                                        <div class="flex flex-col text-left">
                                            <span class="text-xs font-bold text-slate-900 dark:text-white">E-Wallet (QRIS)</span>
                                            <span class="text-[10px] text-slate-400">GoPay, OVO, DANA, LinkAja</span>
                                        </div>
                                    </div>
                                    <span class="text-[10px] bg-blue-500/10 text-blue-600 px-2 py-0.5 rounded font-bold">Otomatis</span>
                                </label>

                                <!-- Modern Retail -->
                                <label class="payment-method-option flex items-center justify-between p-3.5 border border-slate-200 dark:border-slate-800 rounded-lg cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800/40 transition">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="payment_method" value="Gerai Retail (Alfamart/Indomaret)" class="text-[#1e5afb] focus:ring-[#1e5afb]">
                                        <div class="flex flex-col text-left">
                                            <span class="text-xs font-bold text-slate-900 dark:text-white">Gerai Retail Modern</span>
                                            <span class="text-[10px] text-slate-400">Alfamart, Indomaret</span>
                                        </div>
                                    </div>
                                    <span class="text-[10px] bg-amber-500/10 text-amber-600 px-2 py-0.5 rounded font-bold">Manual Code</span>
                                </label>
                            </div>
                        </div>

                        <button type="submit" id="btn-pay-now" class="w-full bg-[#1e5afb] hover:bg-[#1546cb] text-white font-bold py-4 px-8 rounded-md shadow-md transition duration-300 flex items-center justify-center gap-2 uppercase text-base tracking-wider outfit-font">
                            Simulasikan Pembayaran
                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            <!-- 4. PAYMENT RECEIPT VIEW -->
            <div id="payment-receipt-card" class="hidden flex flex-col justify-between h-full transition-all duration-300 text-center">
                <div class="my-auto py-2">
                    <div class="w-14 h-14 rounded-full bg-blue-500/10 border border-blue-500/25 flex items-center justify-center mx-auto mb-4 shadow-sm text-blue-600 dark:text-blue-400">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h3 class="outfit-font text-2xl font-extrabold text-slate-900 dark:text-white mb-2 tracking-tight uppercase">Pembayaran Sukses!</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-xs mb-6 max-w-sm mx-auto leading-relaxed">
                        Terima kasih. Transaksi Anda telah berhasil diverifikasi. Detail pembayaran Anda tercantum di bawah ini.
                    </p>

                    <div class="rounded-xl p-5 text-left border border-slate-200/50 dark:border-white/5 bg-slate-50/50 dark:bg-slate-950/40 mb-6 max-w-md mx-auto text-xs space-y-3">
                        <div class="flex justify-between py-1.5 border-b border-slate-200/50 dark:border-white/5">
                            <span class="text-slate-400">Nomor Referensi</span>
                            <span class="font-mono font-bold text-slate-900 dark:text-white" id="receipt-ref">-</span>
                        </div>
                        <div class="flex justify-between py-1.5 border-b border-slate-200/50 dark:border-white/5">
                            <span class="text-slate-400">Nama Lengkap</span>
                            <span class="font-bold text-slate-900 dark:text-white" id="receipt-name">-</span>
                        </div>
                        <div class="flex justify-between py-1.5 border-b border-slate-200/50 dark:border-white/5">
                            <span class="text-slate-400">Skema / Program</span>
                            <span class="font-semibold text-slate-900 dark:text-slate-200 text-right" id="receipt-program">-</span>
                        </div>
                        <div class="flex justify-between py-1.5 border-b border-slate-200/50 dark:border-white/5">
                            <span class="text-slate-400">Jumlah Dibayar</span>
                            <span class="font-bold text-blue-700 dark:text-blue-400" id="receipt-amount">-</span>
                        </div>
                        <div class="flex justify-between py-1.5 border-b border-slate-200/50 dark:border-white/5">
                            <span class="text-slate-400">Metode Pembayaran</span>
                            <span class="font-semibold text-slate-900 dark:text-white" id="receipt-method">-</span>
                        </div>
                        <div class="flex justify-between py-1.5">
                            <span class="text-slate-400">Waktu Transaksi</span>
                            <span class="font-semibold text-slate-900 dark:text-white" id="receipt-date">-</span>
                        </div>
                    </div>

                    <div class="flex justify-center gap-3">
                        <button class="bg-[#1e5afb] hover:bg-[#1546cb] text-white font-bold py-2.5 px-5 rounded-md text-xs uppercase tracking-wider transition-all shadow-md" id="print-receipt-btn">
                            Cetak Kuitansi
                        </button>
                        <a href="/" class="bg-white dark:bg-slate-900 hover:bg-slate-50 dark:hover:bg-slate-800 border border-slate-300 dark:border-slate-700 text-slate-600 dark:text-slate-400 py-2.5 px-5 rounded-md text-xs uppercase tracking-wider transition-all flex items-center">
                            Kembali Ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- WhatsApp Floating Notification Toast -->
    <div id="whatsapp-toast" class="fixed bottom-6 right-6 z-50 transform translate-y-20 opacity-0 pointer-events-none transition-all duration-500 max-w-sm w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-2xl overflow-hidden flex flex-col">
        <div class="bg-blue-600 text-white px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="bg-white/20 px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-wider">WA</div>
                <span class="text-xs font-bold uppercase tracking-wider">Hotline LPK MPI</span>
            </div>
            <button onclick="hideWAToast()" class="text-white/70 hover:text-white font-black text-sm">&times;</button>
        </div>
        <div class="p-4 flex gap-3 items-start">
            <div class="bg-blue-500/10 text-blue-600 dark:text-blue-400 px-2 py-1 rounded-lg border border-blue-500/20 shrink-0 text-xs font-bold uppercase tracking-wider">
                WA
            </div>
            <div class="flex-1 min-w-0 text-left">
                <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider">WhatsApp Terkirim</span>
                <p class="text-slate-700 dark:text-slate-300 text-xs mt-1 leading-relaxed whitespace-pre-line" id="whatsapp-toast-msg">
                    Kuitansi pendaftaran Anda telah berhasil dikirim ke nomor WhatsApp Anda.
                </p>
            </div>
        </div>
    </div>

    <!-- Theme Toggle logic & AJAX logic -->
    <script>
        // WhatsApp toast functions
        function showWAToast(message) {
            const toast = document.getElementById('whatsapp-toast');
            document.getElementById('whatsapp-toast-msg').innerHTML = message;
            toast.classList.remove('translate-y-20', 'opacity-0', 'pointer-events-none');
            toast.classList.add('translate-y-0', 'opacity-100');
            setTimeout(() => {
                hideWAToast();
            }, 10000);
        }

        function hideWAToast() {
            const toast = document.getElementById('whatsapp-toast');
            toast.classList.add('translate-y-20', 'opacity-0', 'pointer-events-none');
            toast.classList.remove('translate-y-0', 'opacity-100');
        }

        // Switching card views
        const loginCard = document.getElementById('login-card');
        const registerCard = document.getElementById('register-card');
        const checkoutCard = document.getElementById('payment-checkout-card');
        const receiptCard = document.getElementById('payment-receipt-card');

        function showRegisterView() {
            loginCard.classList.add('hidden');
            checkoutCard.classList.add('hidden');
            receiptCard.classList.add('hidden');
            registerCard.classList.remove('hidden');
        }

        function showLoginView() {
            registerCard.classList.add('hidden');
            checkoutCard.classList.add('hidden');
            receiptCard.classList.add('hidden');
            loginCard.classList.remove('hidden');
        }

        function showCheckoutView() {
            loginCard.classList.add('hidden');
            registerCard.classList.add('hidden');
            receiptCard.classList.add('hidden');
            checkoutCard.classList.remove('hidden');
        }

        function showReceiptView() {
            loginCard.classList.add('hidden');
            registerCard.classList.add('hidden');
            checkoutCard.classList.add('hidden');
            receiptCard.classList.remove('hidden');
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

        // AJAX Form Submission (Register & Upload Files)
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
                        btnResendOtp.innerHTML = 'Kirim Ulang';
                    } else {
                        btnResendOtp.innerHTML = `Kirim Ulang (${seconds}s)`;
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
                    body: JSON.stringify({
                        email
                    })
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
                    btnResendOtp.innerHTML = 'Mengirim...';
                    const data = await sendOtpRequest(email, csrfToken);
                    startCountdown();
                    if (data.debug_code) {
                        otpDebugHelper.classList.remove('hidden');
                        otpDebugHelper.innerHTML = `[Developer Mode] Kode verifikasi Anda adalah: <strong class="text-blue-700 dark:text-blue-400 font-mono text-sm underline">${data.debug_code}</strong>`;
                    } else {
                        otpDebugHelper.classList.add('hidden');
                    }
                    alert('Kode verifikasi telah dikirim ulang ke email Anda!');
                } catch (error) {
                    btnResendOtp.disabled = false;
                    btnResendOtp.innerHTML = 'Kirim Ulang';
                    let errMsg = 'Gagal mengirim kode verifikasi.';
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
                    p.innerHTML = '• Alamat email harus menggunakan domain @gmail.com.';
                    errorBox.appendChild(p);
                    return;
                }

                // 2. If OTP section is not visible yet, send OTP first
                if (otpSection.classList.contains('hidden')) {
                    try {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = `
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block align-middle" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Mengirim Kode...
                        `;

                        const data = await sendOtpRequest(email, csrfToken);

                        submitBtn.disabled = false;
                        submitBtn.innerHTML = 'Verifikasi &amp; Daftar';
                        otpSection.classList.remove('hidden');
                        otpCodeInput.required = true;
                        otpCodeInput.focus();

                        startCountdown();

                        if (data.debug_code) {
                            otpDebugHelper.classList.remove('hidden');
                            otpDebugHelper.innerHTML = `[Developer Mode] Kode verifikasi Anda adalah: <strong class="text-blue-700 dark:text-blue-400 font-mono text-sm underline">${data.debug_code}</strong>`;
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
                            p.innerHTML = `• ${error.message || 'Terjadi kesalahan sistem.'}`;
                            errorBox.appendChild(p);
                        }
                    }
                    return;
                }

                // 3. Main submission with file uploads
                const formData = new FormData(form);
                try {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = `
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block align-middle" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Memproses Pendaftaran...
                    `;

                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken
                        }
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
                            throw new Error(data.message || 'Terjadi kesalahan sistem.');
                        }
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = 'Verifikasi &amp; Daftar';
                        return;
                    }

                    // Initial registration successful, now show payment checkout!
                    const enrollment = data.enrollment;
                    document.getElementById('checkout-program-title').textContent = enrollment.program_title;
                    document.getElementById('checkout-amount').textContent = enrollment.payment_amount_formatted;
                    document.getElementById('checkout-enrollment-id').value = enrollment.id;

                    form.reset();
                    otpSection.classList.add('hidden');
                    otpCodeInput.required = false;
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalSubmitText;

                    showCheckoutView();
                } catch (error) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Verifikasi &amp; Daftar';
                    alert(error.message || 'Terjadi kesalahan jaringan.');
                }
            });
        }

        // AJAX Payment Submission
        const paymentForm = document.getElementById('payment-form');
        if (paymentForm) {
            paymentForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const payBtn = document.getElementById('btn-pay-now');
                const originalPayText = payBtn.innerHTML;
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const enrollmentId = document.getElementById('checkout-enrollment-id').value;
                const paymentMethod = paymentForm.querySelector('input[name="payment_method"]:checked').value;

                try {
                    payBtn.disabled = true;
                    payBtn.innerHTML = `
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block align-middle" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Memproses Transaksi...
                    `;

                    const response = await fetch("{{ route('enroll.payment') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            enrollment_id: enrollmentId,
                            payment_method: paymentMethod
                        })
                    });

                    const data = await response.json();
                    if (!response.ok) {
                        throw new Error(data.message || 'Gagal memproses pembayaran.');
                    }

                    const receipt = data.receipt;
                    document.getElementById('receipt-ref').textContent = receipt.reference;
                    document.getElementById('receipt-name').textContent = receipt.name;
                    document.getElementById('receipt-program').textContent = receipt.program;
                    document.getElementById('receipt-amount').textContent = receipt.amount;
                    document.getElementById('receipt-method').textContent = receipt.method;
                    document.getElementById('receipt-date').textContent = receipt.date;

                    payBtn.disabled = false;
                    payBtn.innerHTML = originalPayText;

                    showReceiptView();

                    // Simulate Auto Confirmation Notification via WhatsApp Toast
                    const waMessage = `*Hotline LPK MPI*\n\nSelamat, Pembayaran pendaftaran Anda berhasil!\n\n*No. Transaksi:* ${receipt.reference}\n*Peserta:* ${receipt.name}\n*Skema:* ${receipt.program}\n*Metode:* ${receipt.method}\n*Status:* LUNAS (PAID)\n\nPendaftaran sedang diproses oleh admin. Kuitansi PDF resmi dikirimkan via email Anda.`;
                    showWAToast(waMessage);

                    // Print handler
                    document.getElementById('print-receipt-btn').onclick = () => {
                        window.print();
                    };
                } catch (error) {
                    payBtn.disabled = false;
                    payBtn.innerHTML = originalPayText;
                    alert(error.message || 'Terjadi kesalahan jaringan.');
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
    @endsection
