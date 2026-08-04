@extends('layouts.app')

@section('content')
    <div class="glow-bg glow-1"></div>
    <div class="glow-bg glow-2"></div>

    <main class="max-w-5xl mx-auto my-12 px-6">

        <!-- Page Title -->
        <div class="text-center mb-10">
            <span class="inline-flex items-center gap-2 bg-blue-500/10 text-blue-700 dark:text-blue-300 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-wider mb-4 border border-blue-500/20">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-ping"></span>
                Pendaftaran Pelatihan
            </span>
            <h1 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white mb-3 tracking-tight">Formulir Pendaftaran Pelatihan</h1>
            <p class="text-slate-500 dark:text-slate-400 text-base max-w-xl mx-auto">Isi data diri Anda dengan lengkap dan benar. Sertifikat pelatihan akan diterbitkan otomatis setelah pendaftaran berhasil.</p>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-blue-500/10 border border-blue-500/20 text-blue-600 dark:text-blue-400 rounded-xl text-sm flex items-center gap-3">
                <span>✓</span><span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 p-4 bg-rose-500/10 border border-rose-500/20 text-rose-600 dark:text-rose-400 rounded-xl text-sm flex items-center gap-3">
                <span>✗</span><span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Main Content -->
        <div id="enrollment-form-row" class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <!-- Guide Left -->
            <div class="lg:col-span-5 space-y-6">
                <div class="glass-card rounded-2xl p-6 border border-slate-200 dark:border-slate-800">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Panduan Pendaftaran</h3>
                    <ol class="space-y-4 text-sm text-slate-600 dark:text-slate-400 list-decimal list-inside pl-1">
                        <li class="leading-relaxed">Pilih program pelatihan yang sesuai dengan kompetensi yang ingin Anda sertifikasi.</li>
                        <li class="leading-relaxed">Lengkapi data diri, instansi, dan kontak aktif Anda.</li>
                        <li class="leading-relaxed">Kirim pendaftaran. Anda akan langsung menerima <strong class="text-blue-700 dark:text-blue-400">Sertifikat Kompetensi Pelatihan LPK MMI</strong> secara otomatis.</li>
                    </ol>
                    <div class="bg-blue-50 dark:bg-blue-950/20 border border-blue-200 dark:border-blue-800/40 rounded-xl p-4 flex gap-3 mt-6">
                        <p class="text-xs text-blue-800 dark:text-blue-200 leading-relaxed font-semibold">
                            <strong>Note Integrasi:</strong> Sertifikat dari LPK MMI ini dapat digunakan sebagai bukti kelayakan program pemagangan kerja ke Jepang.
                        </p>
                    </div>
                </div>

                <!-- Stats Card -->
                <div class="glass-card rounded-2xl p-6 border border-slate-200 dark:border-slate-800">
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-4">Program Tersedia</h4>
                    <div class="space-y-2">
                        @foreach($programs as $prog)
                        <div class="flex justify-between items-center py-2 border-b border-slate-100 dark:border-white/5 text-xs">
                            <span class="text-slate-700 dark:text-slate-300 font-medium">{{ $prog->title }}</span>
                            <span class="text-blue-700 dark:text-blue-400 font-bold">{{ $prog->price ?? '-' }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Form Right -->
            <div class="lg:col-span-7 glass-card rounded-2xl p-8 border border-slate-200 dark:border-slate-800">
                <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-6">Data Pendaftar</h2>

                <div id="form-errors" class="hidden mb-6 p-4 bg-rose-500/10 border border-rose-500/20 text-rose-700 dark:text-rose-400 rounded-xl text-sm space-y-1"></div>

                <form id="enrollment-form" action="{{ route('enroll') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    <div class="flex flex-col gap-2">
                        <label for="enroll-program" class="text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Program Pelatihan</label>
                        <select id="enroll-program" name="program_id" required class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-lg px-4 py-3 text-sm text-slate-900 dark:text-slate-200 focus:outline-none focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/15 transition-all">
                            <option value="" disabled selected class="dark:bg-slate-900">Pilih Program Pelatihan...</option>
                            @foreach($programs as $prog)
                                <option value="{{ $prog->id }}" class="dark:bg-slate-900">{{ $prog->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="flex flex-col gap-2">
                            <label for="enroll-name" class="text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Nama Lengkap (Sesuai KTP)</label>
                            <input type="text" id="enroll-name" name="name" placeholder="Contoh: Dr. Hamidun, M.Pd" required class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-lg px-4 py-3 text-sm text-slate-900 dark:text-slate-200 focus:outline-none focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/15 transition-all placeholder:text-slate-400 dark:placeholder:text-slate-700">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="enroll-nik" class="text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">NIK</label>
                            <input type="text" id="enroll-nik" name="nik" maxlength="16" placeholder="16 Digit NIK" required class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-lg px-4 py-3 text-sm text-slate-900 dark:text-slate-200 focus:outline-none focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/15 transition-all placeholder:text-slate-400 dark:placeholder:text-slate-700 font-mono">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="flex flex-col gap-2">
                            <label for="enroll-email" class="text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Email Aktif</label>
                            <input type="email" id="enroll-email" name="email" placeholder="nama@email.com" required class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-lg px-4 py-3 text-sm text-slate-900 dark:text-slate-200 focus:outline-none focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/15 transition-all placeholder:text-slate-400 dark:placeholder:text-slate-700">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="enroll-phone" class="text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">No. HP / WhatsApp</label>
                            <input type="text" id="enroll-phone" name="phone" placeholder="08xxxxxxxxx" required class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-lg px-4 py-3 text-sm text-slate-900 dark:text-slate-200 focus:outline-none focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/15 transition-all placeholder:text-slate-400 dark:placeholder:text-slate-700">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="flex flex-col gap-2">
                            <label for="enroll-education" class="text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Pendidikan Terakhir</label>
                            <select id="enroll-education" name="education" required class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-lg px-4 py-3 text-sm text-slate-900 dark:text-slate-200 focus:outline-none focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/15 transition-all">
                                <option value="" disabled selected class="dark:bg-slate-900">Pilih Pendidikan...</option>
                                <option value="S3" class="dark:bg-slate-900">S3 / Doktor</option>
                                <option value="S2" class="dark:bg-slate-900">S2 / Magister</option>
                                <option value="S1" class="dark:bg-slate-900">S1 / Sarjana</option>
                                <option value="D4" class="dark:bg-slate-900">D4 / Diploma IV</option>
                                <option value="D3" class="dark:bg-slate-900">D3 / Diploma III</option>
                                <option value="SMA" class="dark:bg-slate-900">SMA / SMK / MA</option>
                            </select>
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="enroll-category" class="text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Kategori Pekerjaan</label>
                            <select id="enroll-category" name="category" required class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-lg px-4 py-3 text-sm text-slate-900 dark:text-slate-200 focus:outline-none focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/15 transition-all">
                                <option value="" disabled selected class="dark:bg-slate-900">Pilih Kategori...</option>
                                <option value="guru" class="dark:bg-slate-900">Guru Madrasah</option>
                                <option value="mahasiswa" class="dark:bg-slate-900">Mahasiswa / Dosen</option>
                                <option value="kerja" class="dark:bg-slate-900">Praktisi / Umum</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="flex flex-col gap-2">
                            <label for="enroll-company" class="text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Nama Instansi / Perusahaan</label>
                            <input type="text" id="enroll-company" name="company" placeholder="Nama Madrasah / Kampus" required class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-lg px-4 py-3 text-sm text-slate-900 dark:text-slate-200 focus:outline-none focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/15 transition-all placeholder:text-slate-400 dark:placeholder:text-slate-700">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="enroll-position" class="text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Jabatan Saat Ini</label>
                            <input type="text" id="enroll-position" name="position" placeholder="Contoh: Kepala Madrasah / Dosen" required class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-lg px-4 py-3 text-sm text-slate-900 dark:text-slate-200 focus:outline-none focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/15 transition-all placeholder:text-slate-400 dark:placeholder:text-slate-700">
                        </div>
                    </div>

                    <!-- Document Uploads -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="flex flex-col gap-2">
                            <label for="enroll-ktp" class="text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Unggah KTP (Gambar/Foto, maks 2MB)</label>
                            <input type="file" id="enroll-ktp" name="ktp" accept="image/*" required class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-lg px-4 py-2 text-xs text-slate-900 dark:text-slate-200 focus:outline-none focus:border-blue-500 dark:focus:border-blue-400">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="enroll-ijazah" class="text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Unggah Ijazah Terakhir (Gambar/Foto, maks 2MB)</label>
                            <input type="file" id="enroll-ijazah" name="ijazah" accept="image/*" required class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-lg px-4 py-2 text-xs text-slate-900 dark:text-slate-200 focus:outline-none focus:border-blue-500 dark:focus:border-blue-400">
                        </div>
                    </div>

                    <!-- OTP Verification Section (Hidden initially) -->
                    <div id="otp-section" class="hidden border border-blue-500/20 bg-blue-500/5 dark:bg-blue-950/20 p-5 rounded-lg space-y-4 transition-all duration-300">
                        <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800 pb-2.5">
                            <span class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Verifikasi Email Aktif</span>
                            <span class="text-[10px] text-blue-700 dark:text-blue-400 bg-blue-500/10 px-2 py-0.5 rounded font-black tracking-wider uppercase">OTP Required</span>
                        </div>
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                            Kami telah mengirimkan 6-digit kode verifikasi ke email Anda. Silakan periksa kotak masuk (atau folder spam).
                        </p>
                        
                        <!-- Local development debug helper -->
                        <div id="otp-debug-helper" class="hidden text-xs bg-amber-500/10 border border-amber-500/20 text-amber-600 dark:text-amber-400 p-3 rounded font-semibold leading-relaxed"></div>
                        
                        <div class="flex flex-col sm:flex-row gap-3">
                            <div class="flex-1">
                                <input type="text" id="otp-code-input" name="otp_code" placeholder="Masukkan 6-digit kode" class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-lg px-4 py-3 text-sm text-slate-900 dark:text-slate-200 focus:outline-none focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/15 transition-all placeholder:text-slate-400 dark:placeholder:text-slate-700 tracking-widest font-mono text-center text-lg">
                            </div>
                            <button type="button" id="btn-resend-otp" class="bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold text-xs uppercase tracking-wider px-5 py-3 rounded-lg transition-all flex items-center justify-center gap-2">
                                Kirim Ulang (<span id="otp-countdown">60</span>s)
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold py-3.5 px-6 rounded-lg hover:brightness-110 shadow-lg shadow-blue-600/20 transition-all duration-300 flex items-center justify-center gap-2 text-xs uppercase tracking-wider mt-2">
                        Daftar Sekarang &amp; Terbitkan Sertifikat Pelatihan
                    </button>
                </form>
            </div>
        </div>

        <!-- Success Card -->
        <div id="enrollment-success-card" class="glass-card rounded-2xl max-w-3xl mx-auto text-center p-8 sm:p-10 border border-slate-200 dark:border-slate-800 hidden animate-fade-in">
            <div class="w-14 h-14 rounded-full bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-500/25 flex items-center justify-center mx-auto mb-5 shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h3 class="text-2xl font-extrabold text-slate-900 dark:text-white mb-2 tracking-tight">Pendaftaran Pelatihan Berhasil!</h3>
            <p class="text-slate-600 dark:text-slate-400 text-sm mb-8 max-w-lg mx-auto leading-relaxed">
                Selamat! Anda telah terdaftar dan sistem telah menerbitkan <strong>Sertifikat Pelatihan LPK</strong> sebagai bukti kompetensi.
            </p>
            <div class="certificate-badge rounded-2xl p-6 sm:p-10 text-center shadow-lg mb-8">
                <div class="cert-header mb-6">
                    <h4 class="text-blue-800 dark:text-blue-300 text-sm sm:text-base font-bold tracking-[3px] uppercase">Sertifikat Kelulusan Pelatihan</h4>
                    <span class="text-[9px] sm:text-xs text-slate-500 uppercase tracking-widest block mt-1">LPK Manajemen Industri &amp; Kompetensi (LPK-MI)</span>
                </div>
                <div class="cert-body my-8">
                    <p class="text-[10px] sm:text-xs text-slate-500 italic">Diberikan Kepada:</p>
                    <h2 id="cert-holder-name" class="text-2xl sm:text-4xl font-extrabold text-slate-900 dark:text-white my-3 tracking-wide uppercase font-black">-</h2>
                    <p class="text-[10px] sm:text-xs text-slate-400 max-w-md mx-auto leading-relaxed">Telah menyelesaikan pelatihan kompetensi dengan predikat <strong class="text-blue-600 dark:text-blue-400">KOMPETEN</strong> pada program:</p>
                    <h3 id="cert-program-name" class="text-base sm:text-xl text-blue-700 dark:text-teal-400 font-bold mt-3 mb-6 tracking-wide">-</h3>
                    <div class="flex justify-center gap-8 sm:gap-12 text-xs border-t border-slate-200 dark:border-white/5 pt-6 max-w-sm mx-auto">
                        <div class="flex flex-col text-left">
                            <span class="text-[10px] text-slate-500">No. Sertifikat:</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-200 font-mono" id="cert-number-val">-</span>
                        </div>
                        <div class="flex flex-col text-left">
                            <span class="text-[10px] text-slate-500">Tanggal Terbit:</span>
                            <span class="font-semibold text-slate-800 dark:text-slate-200" id="cert-date-val">-</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap justify-center gap-4">
                <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg text-xs uppercase tracking-wider transition-all shadow-lg shadow-blue-600/10" id="copy-cert-num-btn">Salin Nomor Sertifikat</button>
                <button class="bg-white dark:bg-slate-900 hover:bg-slate-50 dark:hover:bg-slate-800 border border-slate-300 dark:border-slate-700 text-slate-500 dark:text-slate-400 py-3 px-6 rounded-lg text-xs uppercase tracking-wider transition-all" id="reset-enrollment-btn">Daftar Lagi</button>
            </div>
        </div>
    </main>

    <script>
        // AJAX Form Submission
        const form = document.getElementById('enrollment-form');
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
                body: JSON.stringify({ email: email })
            });
            const data = await response.json();
            if (!response.ok) {
                throw new Error(data.message || 'Gagal mengirim OTP.');
            }
            return data;
        }

        btnResendOtp.addEventListener('click', async () => {
            const email = document.getElementById('enroll-email').value;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            if (!email) return alert('Silakan isi email terlebih dahulu.');
            
            try {
                btnResendOtp.disabled = true;
                btnResendOtp.innerHTML = 'Mengirim...';
                const data = await sendOtpRequest(email, csrfToken);
                alert(data.message || 'OTP berhasil dikirim ulang.');
                startCountdown();
                
                // Show OTP debug helper in local/dev environment
                if (data.otp) {
                    otpDebugHelper.classList.remove('hidden');
                    otpDebugHelper.innerHTML = `<strong>[DEVELOPMENT MODE]</strong> OTP Code sent to email: <span class="font-mono text-sm underline font-black">${data.otp}</span>`;
                }
            } catch (err) {
                alert(err.message);
                btnResendOtp.disabled = false;
                btnResendOtp.innerHTML = 'Kirim Ulang';
            }
        });

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const errorBox = document.getElementById('form-errors');
            errorBox.classList.add('hidden');
            errorBox.innerHTML = '';
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const email = document.getElementById('enroll-email').value;

            // 1. If OTP section is not visible yet, send OTP first
            if (otpSection.classList.contains('hidden')) {
                try {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="animate-spin mr-2">⚙</span> Mengirim OTP...';
                    
                    const data = await sendOtpRequest(email, csrfToken);
                    
                    // Show OTP section
                    otpSection.classList.remove('hidden');
                    otpCodeInput.required = true;
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Verifikasi &amp; Terbitkan Sertifikat';
                    startCountdown();
                    
                    // Show OTP debug helper in local/dev environment
                    if (data.otp) {
                        otpDebugHelper.classList.remove('hidden');
                        otpDebugHelper.innerHTML = `<strong>[DEVELOPMENT MODE]</strong> OTP Code sent to email: <span class="font-mono text-sm underline font-black">${data.otp}</span>`;
                    }
                } catch (error) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalSubmitText;
                    errorBox.classList.remove('hidden');
                    const p = document.createElement('p');
                    p.innerHTML = `• ${error.message}`;
                    errorBox.appendChild(p);
                }
                return;
            }

            // 3. Main submission (OTP section is visible)
            const formData = new FormData(form);
            try {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="animate-spin mr-2">⚙</span> Memproses Pendaftaran...';
                
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
                        window.scrollTo({ top: errorBox.offsetTop - 120, behavior: 'smooth' });
                    } else {
                        throw new Error(data.message || 'Terjadi kesalahan sistem.');
                    }
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Verifikasi &amp; Terbitkan Sertifikat';
                    return;
                }
                
                // Success flow
                const trainee = data.trainee;
                document.getElementById('cert-holder-name').textContent = trainee.name.toUpperCase();
                document.getElementById('cert-program-name').textContent = trainee.program.title;
                document.getElementById('cert-number-val').textContent = trainee.cert_number;
                document.getElementById('cert-date-val').textContent = trainee.cert_date;
                form.reset();
                otpSection.classList.add('hidden');
                otpCodeInput.required = false;
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalSubmitText;
                
                document.getElementById('enrollment-form-row').classList.add('hidden');
                document.getElementById('enrollment-success-card').classList.remove('hidden');
                window.scrollTo({ top: 0, behavior: 'smooth' });
                document.getElementById('copy-cert-num-btn').onclick = () => {
                    navigator.clipboard.writeText(trainee.cert_number);
                    alert(`Nomor sertifikat ${trainee.cert_number} berhasil disalin!`);
                };
                document.getElementById('reset-enrollment-btn').onclick = () => {
                    document.getElementById('enrollment-success-card').classList.add('hidden');
                    document.getElementById('enrollment-form-row').classList.remove('hidden');
                };
            } catch (error) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Verifikasi &amp; Terbitkan Sertifikat';
                alert(error.message || 'Terjadi kesalahan jaringan.');
            }
        });
    </script>
@endsection
