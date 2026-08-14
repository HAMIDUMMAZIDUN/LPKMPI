@extends('layouts.app')

@section('content')
    <div class="glow-bg glow-1"></div>
    <div class="glow-bg glow-2"></div>

    <main class="max-w-5xl mx-auto py-12">

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
                        <li class="leading-relaxed">Kirim pendaftaran. Anda akan langsung menerima <strong class="text-blue-700 dark:text-blue-400">Sertifikat Kompetensi Pelatihan LPK-MPI</strong> secara otomatis.</li>
                    </ol>
                    <div class="bg-blue-50 dark:bg-blue-950/20 border border-blue-200 dark:border-blue-800/40 rounded-xl p-4 flex gap-3 mt-6">
                        <p class="text-xs text-blue-800 dark:text-blue-200 leading-relaxed font-semibold">
                            <strong>Note Integrasi:</strong> Sertifikat dari LPK-MPI ini terintegrasi langsung dengan Lembaga Sertifikasi Profesi (LSP-MPI) untuk verifikasi kompetensi lulusan secara real-time.
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
                                <option value="pimpinan" class="dark:bg-slate-900">Kepala Sekolah / Madrasah / Pimpinan Lembaga</option>
                                <option value="pendidik" class="dark:bg-slate-900">Guru / Pendidik / Dosen / Praktisi Pendidikan</option>
                                <option value="staff" class="dark:bg-slate-900">Tenaga Kependidikan / Staff IT / Administrasi</option>
                                <option value="yayasan" class="dark:bg-slate-900">Pengurus Yayasan / Komite Lembaga</option>
                                <option value="umum" class="dark:bg-slate-900">Umum / Profesional / Praktisi Manajemen</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="flex flex-col gap-2">
                            <label for="enroll-company" class="text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Nama Instansi / Perusahaan</label>
                            <input type="text" id="enroll-company" name="company" placeholder="Contoh: Yayasan Al-Iman, Madrasah, Kampus, Perusahaan" required class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-lg px-4 py-3 text-sm text-slate-900 dark:text-slate-200 focus:outline-none focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/15 transition-all placeholder:text-slate-400 dark:placeholder:text-slate-700">
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="enroll-position" class="text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Jabatan Saat Ini</label>
                            <input type="text" id="enroll-position" name="position" placeholder="Contoh: Kepala Madrasah, Dosen, Ketua Yayasan, Staff IT" required class="w-full bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-800 rounded-lg px-4 py-3 text-sm text-slate-900 dark:text-slate-200 focus:outline-none focus:border-blue-500 dark:focus:border-blue-400 focus:ring-2 focus:ring-blue-500/15 transition-all placeholder:text-slate-400 dark:placeholder:text-slate-700">
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


                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold py-3.5 px-6 rounded-lg hover:brightness-110 shadow-lg shadow-blue-600/20 transition-all duration-300 flex items-center justify-center gap-2 text-xs uppercase tracking-wider mt-2">
                        Daftar Sekarang
                    </button>
                </form>
            </div>
        </div>
    </main>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // AJAX Form Submission
        const form = document.getElementById('enrollment-form');
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalSubmitText = submitBtn.innerHTML;

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const errorBox = document.getElementById('form-errors');
            errorBox.classList.add('hidden');
            errorBox.innerHTML = '';
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

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
                    submitBtn.innerHTML = originalSubmitText;
                    return;
                }
                
                // Success flow
                form.reset();
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalSubmitText;

                Swal.fire({
                    title: 'Pendaftaran Berhasil!',
                    text: 'Data Anda telah tersimpan. Silakan periksa email Anda secara berkala untuk detail jadwal pelatihan dan petunjuk pembayaran selanjutnya.',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#2563eb'
                }).then(() => {
                    window.location.href = "{{ url('/') }}";
                });
                
            } catch (error) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalSubmitText;
                Swal.fire({
                    title: 'Terjadi Kesalahan',
                    text: error.message || 'Terjadi kesalahan jaringan.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#ef4444'
                });
            }
        });

        // Auto-select program if query parameter 'program' is present
        const urlParams = new URLSearchParams(window.location.search);
        const programId = urlParams.get('program');
        if (programId) {
            const selectEl = document.getElementById('enroll-program');
            if (selectEl) {
                selectEl.value = programId;
            }
        }
    </script>
@endsection
