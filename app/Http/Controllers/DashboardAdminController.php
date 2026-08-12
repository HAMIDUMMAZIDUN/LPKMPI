<?php

namespace App\Http\Controllers;

use App\Models\AssessmentScheme;
use App\Models\SchemeAssignment;
use App\Models\TraineeEnrollment;
use App\Models\Article;
use App\Models\User;
use App\Models\LandingSetting;
use App\Models\TrainingProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DashboardAdminController extends Controller
{
    private function checkRole()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses ditolak.');
        }
    }

    public function index()
    {
        $this->checkRole();

        $asetors    = User::where('role', 'asesor')->withCount('schemes')->get();
        $asesis     = User::where('role', 'asesi')->latest()->get();
        $schemes    = AssessmentScheme::with('asesor')->latest()->get();
        $assignments = SchemeAssignment::with(['scheme', 'asesor'])->latest()->get();
        $trainees   = TraineeEnrollment::with('trainingProgram')->latest()->get();
        $articles   = Article::latest()->get();
        $settings   = LandingSetting::pluck('value', 'key');
        $programs   = TrainingProgram::latest()->get();

        $traineesCount = $trainees->count();
        $certCount  = $trainees->where('status', 'LULUS')->count();

        return view('dashboard.admin', compact(
            'asetors',
            'asesis',
            'schemes',
            'assignments',
            'trainees',
            'traineesCount',
            'certCount',
            'articles',
            'settings',
            'programs'
        ));
    }

    /** Live stats JSON – polled every 30 s by the dashboard */
    public function stats()
    {
        $this->checkRole();
        return response()->json([
            'trainees' => TraineeEnrollment::count(),
            'lulus'    => TraineeEnrollment::where('status', 'LULUS')->count(),
            'pending'  => TraineeEnrollment::where('payment_status', 'PENDING')->count(),
            'asesis'   => \App\Models\User::where('role', 'asesi')->count(),
            'asesors'  => \App\Models\User::where('role', 'asesor')->count(),
            'programs' => \App\Models\TrainingProgram::count(),
            'articles' => \App\Models\Article::count(),
            'chats'    => \App\Models\ChatMessage::selectRaw('COUNT(DISTINCT session_id) as cnt')->value('cnt') ?? 0,
            'ts'       => now()->toDateTimeString(),
        ]);
    }

    /** Daftarkan akun Asesor baru */
    public function storeAsesor(Request $request)
    {
        $this->checkRole();
        $request->validate([
            'username' => 'required|string|unique:users,username|max:255',
            'email'    => ['required', 'email', 'unique:users,email', 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/i'],
        ], [
            'email.regex' => 'Alamat email harus menggunakan domain @gmail.com.',
        ]);

        $plainPass = 'asesor-' . rand(1000, 9999);
        User::create([
            'name'     => $request->username,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($plainPass),
            'password_plain' => $plainPass,
            'role'     => 'asesor',
        ]);

        return redirect()->route('admin.dashboard', ['open' => 'panel-users'])->with('success', 'Asesor ' . $request->username . ' berhasil didaftarkan!');
    }

    /** Daftarkan akun Asesi baru */
    public function storeAsesi(Request $request)
    {
        $this->checkRole();
        $request->validate([
            'username' => 'required|string|unique:users,username|max:255',
            'email'    => ['required', 'email', 'unique:users,email', 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/i'],
            'password' => 'required|string|min:6',
        ], [
            'email.regex' => 'Alamat email harus menggunakan domain @gmail.com.',
        ]);

        User::create([
            'name'     => $request->username,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'password_plain' => $request->password,
            'role'     => 'asesi',
        ]);

        return redirect()->route('admin.dashboard', ['open' => 'panel-users'])->with('success', 'Asesi ' . $request->username . ' berhasil didaftarkan!');
    }

    /** Hapus user Asesor/Asesi */
    public function destroyUser($id)
    {
        $this->checkRole();
        $user = User::findOrFail($id);

        if (in_array($user->role, ['superadmin', 'admin'])) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun Superadmin / Admin.');
        }

        $user->delete();
        return redirect()->route('admin.dashboard', ['open' => 'panel-users'])->with('success', 'Akun ' . $user->name . ' berhasil dihapus.');
    }

    /** Tugaskan skema ke asesor */
    public function assignScheme(Request $request)
    {
        $this->checkRole();
        $request->validate([
            'scheme_id'  => 'required|exists:assessment_schemes,id',
            'asesor_id'  => 'required|exists:users,id',
        ]);

        SchemeAssignment::updateOrCreate(
            ['scheme_id' => $request->scheme_id, 'asesor_id' => $request->asesor_id],
            ['assigned_by' => auth()->id(), 'assigned_at' => now()]
        );

        return redirect()->route('admin.dashboard', ['open' => 'panel-plotting'])->with('success', 'Skema berhasil ditugaskan!');
    }

    /** Cabut penugasan skema */
    public function revokeAssignment($id)
    {
        $this->checkRole();
        $assignment = SchemeAssignment::findOrFail($id);
        $assignment->delete();
        return redirect()->route('admin.dashboard', ['open' => 'panel-plotting'])->with('success', 'Penugasan skema berhasil dicabut.');
    }

    /** ACC pendaftaran asesi (keluarkan sertifikat) */
    public function approveTrainee($id)
    {
        $this->checkRole();
        $trainee = TraineeEnrollment::findOrFail($id);
        if ($trainee->status !== 'LULUS') {
            do {
                $certNumber = 'LPK-MPI-' . date('Y') . '-' . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
            } while (TraineeEnrollment::where('certificate_number', $certNumber)->exists());
            $trainee->update([
                'certificate_number' => $certNumber,
                'certificate_date'   => now()->toDateString(),
                'status'             => 'LULUS'
            ]);
        }

        // Create asesi user account if not already exists
        $existingUser = User::where('email', $trainee->email)->first();
        $plainPassword = null;
        if (!$existingUser) {
            $plainPassword = 'mpi-' . rand(100000, 999999);
            $existingUser = User::create([
                'name'           => $trainee->name,
                'email'          => $trainee->email,
                'password'       => Hash::make($plainPassword),
                'password_plain' => $plainPassword,
                'role'           => 'asesi',
            ]);
        }

        // Send approval & credentials email
        try {
            $loginUrl     = route('login');
            $passwordText = $plainPassword ?? $existingUser->password_plain ?? '(Gunakan password Anda yang sudah terdaftar)';
            $freshTrainee = $trainee->fresh();
            $certNum      = $freshTrainee->certificate_number;
            $certDate     = $freshTrainee->certificate_date
                                ? $freshTrainee->certificate_date->format('d M Y')
                                : now()->format('d M Y');

            $emailContent = "Selamat! Pendaftaran Anda di LPK MPI telah DISETUJUI dan sertifikat Anda telah diterbitkan.\n\n"
                . "Detail Sertifikat:\n"
                . "- Nama Peserta   : {$trainee->name}\n"
                . "- No. Sertifikat : {$certNum}\n"
                . "- Tanggal        : {$certDate}\n\n"
                . "Akun Login Dashboard LPK MPI Anda:\n"
                . "- URL Login  : {$loginUrl}\n"
                . "- Username   : {$existingUser->username}\n"
                . "- Email      : {$existingUser->email}\n"
                . "- Password   : {$passwordText}\n\n"
                . "Silakan login dengan kredensial di atas untuk melihat sertifikat dan mengikuti ujian kompetensi.\n"
                . "Simpan informasi ini di tempat yang aman.\n\n"
                . "Hormat kami,\n"
                . "Admin LPK MPI";

            Mail::raw($emailContent, function ($message) use ($trainee, $certNum) {
                $message->to($trainee->email)
                        ->subject("Selamat! Sertifikat LPK MPI Anda [{$certNum}] Telah Diterbitkan");
            });
        } catch (\Exception $e) {
            logger()->error('Failed to send admin approval email: ' . $e->getMessage());
        }

        return redirect()->route('admin.dashboard', ['open' => 'panel-sertifikat'])
            ->with('success', 'Sertifikat ' . $trainee->name . ' berhasil diterbitkan & email notifikasi dikirim!');
    }

    public function updateProfile(Request $request)
    {
        $this->checkRole();

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . auth()->id(),
            'email'    => ['required', 'email', 'unique:users,email,' . auth()->id(), 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/i'],
            'password' => 'nullable|string|min:6|confirmed',
        ], [
            'email.regex' => 'Alamat email harus menggunakan domain @gmail.com.',
        ]);

        $data = [
            'name'     => $request->username,
            'username' => $request->username,
            'email'    => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
            $data['password_plain'] = $request->password;
        }

        auth()->user()->update($data);

        return redirect()->route('admin.dashboard', ['open' => 'panel-profil'])->with('success', 'Profil Anda berhasil diperbarui!');
    }

    /** Simpan artikel baru */
    public function storeArticle(Request $request)
    {
        $this->checkRole();
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('articles', 'public');
        }

        Article::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'image_path' => $imagePath,
            'author' => auth()->user()->name,
            'published_at' => now(),
        ]);

        return redirect()->route('admin.dashboard', ['open' => 'panel-users'])->with('success', 'Artikel berhasil diterbitkan!');
    }

    /** Hapus artikel */
    public function destroyArticle($id)
    {
        $this->checkRole();
        $article = Article::findOrFail($id);
        $article->delete();

        return redirect()->route('admin.dashboard', ['open' => 'panel-users'])->with('success', 'Artikel berhasil dihapus!');
    }

    /** Verifikasi pembayaran peserta manually */
    public function verifyPayment($id)
    {
        $this->checkRole();
        $trainee = TraineeEnrollment::findOrFail($id);

        $refNumber = 'MPI-PAY-' . strtoupper(Str::random(10));

        $trainee->update([
            'payment_status' => 'PAID',
            'payment_method' => 'Manual Transfer (Verified)',
            'payment_reference' => $refNumber,
        ]);

        return redirect()->route('admin.dashboard', ['open' => 'panel-verifikasi'])->with('success', 'Pembayaran untuk ' . $trainee->name . ' berhasil diverifikasi!');
    }

    /** Unduh Laporan Excel/CSV Peserta */
    public function generateReport()
    {
        $this->checkRole();
        $trainees = TraineeEnrollment::with('trainingProgram')->latest()->get();

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=Laporan_Peserta_LPK_" . date('Ymd') . ".csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['ID', 'Nama Lengkap', 'NIK', 'Email', 'No. HP', 'Pendidikan', 'Program Pelatihan', 'Status Pembayaran', 'Metode Pembayaran', 'Status Kelulusan', 'No. Sertifikat'];

        $callback = function () use ($trainees, $columns) {
            $file = fopen('php://output', 'w');

            // Add UTF-8 BOM to open correctly in Excel
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, $columns, ';');

            foreach ($trainees as $t) {
                fputcsv($file, [
                    $t->id,
                    $t->name,
                    "'" . $t->nik,
                    $t->email,
                    $t->phone,
                    $t->education,
                    $t->trainingProgram?->title ?? '-',
                    $t->payment_status,
                    $t->payment_method ?? '-',
                    $t->status,
                    $t->certificate_number ?? '-'
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function updateUser(Request $request, $id)
    {
        $this->checkRole();
        $user = User::findOrFail($id);

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email'    => ['required', 'email', 'unique:users,email,' . $id, 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/i'],
            'password' => 'nullable|string|min:6',
        ], [
            'email.regex' => 'Alamat email harus menggunakan domain @gmail.com.',
        ]);

        $data = [
            'name'     => $request->username,
            'username' => $request->username,
            'email'    => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
            $data['password_plain'] = $request->password;
        }

        $user->update($data);

        return redirect()->route('admin.dashboard', ['open' => 'panel-users'])->with('success', 'Akun ' . $user->name . ' berhasil diperbarui!');
    }

    public function updateArticle(Request $request, $id)
    {
        $this->checkRole();
        $article = Article::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
        ];

        if ($request->hasFile('image')) {
            if ($article->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($article->image_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($article->image_path);
            }
            $data['image_path'] = $request->file('image')->store('articles', 'public');
        }

        $article->update($data);

        return redirect()->route('admin.dashboard', ['open' => 'panel-users'])->with('success', 'Artikel berhasil diperbarui!');
    }

    public function updateTrainee(Request $request, $id)
    {
        $this->checkRole();
        $trainee = TraineeEnrollment::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'status' => 'required|string',
            'payment_status' => 'required|string',
        ]);

        $trainee->update($request->only('name', 'nik', 'email', 'phone', 'status', 'payment_status'));

        return redirect()->route('admin.dashboard', ['open' => 'panel-verifikasi'])->with('success', 'Data peserta ' . $trainee->name . ' berhasil diperbarui!');
    }

    public function destroyTrainee($id)
    {
        $this->checkRole();
        $trainee = TraineeEnrollment::findOrFail($id);
        $trainee->delete();

        return redirect()->route('admin.dashboard', ['open' => 'panel-verifikasi'])->with('success', 'Peserta berhasil dihapus!');
    }

    public function updateSettings(Request $request)
    {
        $this->checkRole();

        $validationRules = [
            'site_title'         => 'required|string|max:255',
            'hero_title'         => 'required|string|max:255',
            'hero_subtitle'      => 'required|string|max:1000',
            'why_choose_title'   => 'required|string|max:255',
            'gallery_title'      => 'required|string|max:255',
            'gallery_subtitle'   => 'required|string|max:500',
            'hero_image'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'site_logo'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'login_left_title_1' => 'nullable|string|max:255',
            'login_left_title_2' => 'nullable|string|max:255',
            'login_left_sub'     => 'nullable|string|max:255',
            'login_left_main'    => 'nullable|string|max:1000',
            'login_left_footer_title' => 'nullable|string|max:255',
            'login_left_footer_desc'  => 'nullable|string|max:500',
            'login_bg_image'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'stat_count'         => 'nullable|integer',
            'step_count'         => 'nullable|integer',
            'feature_count'      => 'nullable|integer',
            'instruktur_count'   => 'nullable|integer',
            'gallery_count'      => 'nullable|integer',
            'faq_count'          => 'nullable|integer',
            'org_image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'fasilitas_belajar_foto'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'fasilitas_perpustakaan_foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'fasilitas_asrama_foto'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];

        $instrukturCount = (int) $request->input('instruktur_count', 4);
        for ($i = 1; $i <= $instrukturCount; $i++) {
            $validationRules["instruktur_{$i}_foto"] = 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048';
        }

        $galleryCount = (int) $request->input('gallery_count', 6);
        for ($i = 1; $i <= $galleryCount; $i++) {
            $validationRules["gallery_item_{$i}_image"] = 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048';
        }

        $request->validate($validationRules);

        $keys = [
            'site_title',
            'hero_title',
            'hero_subtitle',
            'why_choose_title',
            'gallery_title',
            'gallery_subtitle',
            'login_left_title_1',
            'login_left_title_2',
            'login_left_sub',
            'login_left_main',
            'login_left_footer_title',
            'login_left_footer_desc',
            'stat_count',
            'step_count',
            'feature_count',
            'instruktur_count',
            'gallery_count',
            'faq_count',

            // Tentang Kami
            'tentang_profil_1',
            'tentang_profil_2',
            'tentang_visi',
            'tentang_misi',
            'org_director_dewan',
            'org_director_lpk',
            'org_manager_pelatihan',
            'org_komite_program',
            'org_manager_mutu',

            // Program Pelatihan
            'prog_manajemen_title',
            'prog_manajemen_durasi',
            'prog_manajemen_harga',
            'prog_manajemen_desc',
            'prog_manajemen_silabus',
            'prog_manajemen_prospek',
            'prog_administrasi_title',
            'prog_administrasi_durasi',
            'prog_administrasi_harga',
            'prog_administrasi_desc',
            'prog_administrasi_silabus',
            'prog_administrasi_prospek',
            'prog_kepemimpinan_title',
            'prog_kepemimpinan_durasi',
            'prog_kepemimpinan_harga',
            'prog_kepemimpinan_desc',
            'prog_kepemimpinan_silabus',
            'prog_kepemimpinan_prospek',

            // Jadwal Diklat
            'jadwal_1_nama',
            'jadwal_1_batas',
            'jadwal_1_waktu',
            'jadwal_1_metode',
            'jadwal_1_quota',
            'jadwal_2_nama',
            'jadwal_2_batas',
            'jadwal_2_waktu',
            'jadwal_2_metode',
            'jadwal_2_quota',
            'jadwal_3_nama',
            'jadwal_3_batas',
            'jadwal_3_waktu',
            'jadwal_3_metode',
            'jadwal_3_quota',

            // Fasilitas
            'fasilitas_belajar_judul',
            'fasilitas_belajar_desc',
            'fasilitas_perpustakaan_judul',
            'fasilitas_perpustakaan_desc',
            'fasilitas_asrama_judul',
            'fasilitas_asrama_desc',

            // Kontak
            'kontak_alamat',
            'kontak_wa',
            'kontak_email',
            'kontak_jam',
        ];

        // Stats keys
        $statCount = (int) $request->input('stat_count', 3);
        for ($i = 1; $i <= $statCount; $i++) {
            $keys[] = "stat_{$i}_val";
            $keys[] = "stat_{$i}_lbl";
        }

        // Steps keys
        $stepCount = (int) $request->input('step_count', 3);
        for ($i = 1; $i <= $stepCount; $i++) {
            $keys[] = "step_{$i}_title";
        }

        // Features keys
        $featureCount = (int) $request->input('feature_count', 3);
        for ($i = 1; $i <= $featureCount; $i++) {
            $keys[] = "feature_{$i}_title";
            $keys[] = "feature_{$i}_desc";
        }

        // Instruktur keys
        for ($i = 1; $i <= $instrukturCount; $i++) {
            $keys[] = "instruktur_{$i}_nama";
            $keys[] = "instruktur_{$i}_jabatan";
            $keys[] = "instruktur_{$i}_keahlian";
            $keys[] = "instruktur_{$i}_pengalaman";
        }

        // FAQ keys
        $faqCount = (int) $request->input('faq_count', 6);
        for ($i = 1; $i <= $faqCount; $i++) {
            $keys[] = "faq_{$i}_q";
            $keys[] = "faq_{$i}_a";
        }

        // Gallery item text keys
        for ($i = 1; $i <= $galleryCount; $i++) {
            $keys[] = "gallery_item_{$i}_category";
            $keys[] = "gallery_item_{$i}_title";
            $keys[] = "gallery_item_{$i}_desc";
            $keys[] = "gallery_item_{$i}_video_url";
        }

        foreach ($keys as $key) {
            if ($request->has($key)) {
                LandingSetting::updateOrCreate(['key' => $key], ['value' => $request->input($key)]);
            }
        }

        // Hero image upload
        if ($request->hasFile('hero_image')) {
            $oldPath = LandingSetting::getValue('hero_image');
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('hero_image')->store('landing', 'public');
            LandingSetting::updateOrCreate(['key' => 'hero_image'], ['value' => $path]);
        }

        // Site logo upload
        if ($request->hasFile('site_logo')) {
            $oldPath = LandingSetting::getValue('site_logo');
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('site_logo')->store('landing/logo', 'public');
            LandingSetting::updateOrCreate(['key' => 'site_logo'], ['value' => $path]);
        }

        // Login background image upload
        if ($request->hasFile('login_bg_image')) {
            $oldPath = LandingSetting::getValue('login_bg_image');
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('login_bg_image')->store('landing/login', 'public');
            LandingSetting::updateOrCreate(['key' => 'login_bg_image'], ['value' => $path]);
        }

        // Org chart image upload
        if ($request->hasFile('org_image')) {
            $oldPath = LandingSetting::getValue('org_image');
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('org_image')->store('landing/org', 'public');
            LandingSetting::updateOrCreate(['key' => 'org_image'], ['value' => $path]);
        }

        // Instruktur photos upload
        for ($i = 1; $i <= $instrukturCount; $i++) {
            if ($request->hasFile("instruktur_{$i}_foto")) {
                $oldPath = LandingSetting::getValue("instruktur_{$i}_foto");
                if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
                $path = $request->file("instruktur_{$i}_foto")->store('landing/instructors', 'public');
                LandingSetting::updateOrCreate(['key' => "instruktur_{$i}_foto"], ['value' => $path]);
            }
        }

        // Fasilitas photos upload
        foreach (['belajar', 'perpustakaan', 'asrama'] as $fKey) {
            if ($request->hasFile("fasilitas_{$fKey}_foto")) {
                $oldPath = LandingSetting::getValue("fasilitas_{$fKey}_foto");
                if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
                $path = $request->file("fasilitas_{$fKey}_foto")->store('landing/facilities', 'public');
                LandingSetting::updateOrCreate(['key' => "fasilitas_{$fKey}_foto"], ['value' => $path]);
            }
        }

        // Gallery item image uploads
        for ($i = 1; $i <= $galleryCount; $i++) {
            if ($request->hasFile("gallery_item_{$i}_image")) {
                $oldPath = LandingSetting::getValue("gallery_item_{$i}_image");
                if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
                $path = $request->file("gallery_item_{$i}_image")->store('landing/gallery', 'public');
                LandingSetting::updateOrCreate(['key' => "gallery_item_{$i}_image"], ['value' => $path]);
            }
        }

        $activePanel = $request->input('active_panel', 'panel-landing');
        return redirect()->route('admin.dashboard', ['open' => $activePanel])->with('success', 'Semua konten beranda berhasil diperbarui!');
    }

    public function storeProgram(Request $request)
    {
        $this->checkRole();

        $request->validate([
            'id' => 'required|string|unique:training_programs,id|max:100',
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'description' => 'required|string',
            'benefits' => 'nullable|string',
            'price' => 'required|string|max:255',
            'lsp_keyword' => 'required|string|max:255',
        ]);

        $benefitsArray = [];
        if ($request->filled('benefits')) {
            $benefitsArray = array_map('trim', explode(',', $request->benefits));
        }

        TrainingProgram::create([
            'id' => $request->id,
            'title' => $request->title,
            'category' => $request->category,
            'duration' => $request->duration,
            'description' => $request->description,
            'benefits' => $benefitsArray,
            'price' => $request->price,
            'lsp_keyword' => $request->lsp_keyword,
        ]);

        return redirect()->route('admin.dashboard', ['open' => 'panel-programs-db'])
            ->with('success', 'Program pelatihan berhasil ditambahkan!');
    }

    public function updateProgram(Request $request, $id)
    {
        $this->checkRole();

        $program = TrainingProgram::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'description' => 'required|string',
            'benefits' => 'nullable|string',
            'price' => 'required|string|max:255',
            'lsp_keyword' => 'required|string|max:255',
        ]);

        $benefitsArray = [];
        if ($request->filled('benefits')) {
            $benefitsArray = array_map('trim', explode(',', $request->benefits));
        }

        $program->update([
            'title' => $request->title,
            'category' => $request->category,
            'duration' => $request->duration,
            'description' => $request->description,
            'benefits' => $benefitsArray,
            'price' => $request->price,
            'lsp_keyword' => $request->lsp_keyword,
        ]);

        return redirect()->route('admin.dashboard', ['open' => 'panel-programs-db'])
            ->with('success', 'Program pelatihan berhasil diperbarui!');
    }

    public function destroyProgram($id)
    {
        $this->checkRole();

        $program = TrainingProgram::findOrFail($id);
        $program->delete();

        return redirect()->route('admin.dashboard', ['open' => 'panel-programs-db'])
            ->with('success', 'Program pelatihan berhasil dihapus!');
    }

    public function getChats()
    {
        $this->checkRole();

        // Get the distinct list of sessions with their most recent message
        $sessions = \App\Models\ChatMessage::selectRaw('session_id, name, email, MAX(created_at) as last_activity')
            ->groupBy('session_id', 'name', 'email')
            ->orderBy('last_activity', 'desc')
            ->get()
            ->map(function ($chat) {
                $lastMsg = \App\Models\ChatMessage::where('session_id', $chat->session_id)
                    ->latest()
                    ->first();

                $lastClaimed = \App\Models\ChatMessage::where('session_id', $chat->session_id)
                    ->whereNotNull('claimed_by_admin_id')
                    ->with('claimedByAdmin')
                    ->latest()
                    ->first();

                $claimedAdminId = $lastClaimed ? $lastClaimed->claimed_by_admin_id : null;
                $claimedAdmin   = ($lastClaimed && $lastClaimed->claimedByAdmin)
                    ? $lastClaimed->claimedByAdmin->name
                    : null;

                return [
                    'session_id'          => $chat->session_id,
                    'name'                => $chat->name,
                    'email'               => $chat->email,
                    'last_message'        => $lastMsg ? $lastMsg->message : '',
                    'last_activity'       => $chat->last_activity,
                    'claimed_by_admin_id' => $claimedAdminId,
                    'claimed_by'          => $claimedAdmin,
                ];
            });

        return response()->json([
            'success' => true,
            'chats'   => $sessions
        ]);
    }

    public function getChatDetail($sessionId)
    {
        $this->checkRole();

        $messages = \App\Models\ChatMessage::where('session_id', $sessionId)
            ->oldest()
            ->with('admin')
            ->get()
            ->map(function ($msg) {
                return [
                    'id'          => $msg->id,
                    'message'     => $msg->message,
                    'sender_role' => $msg->sender_role,
                    'admin_id'    => $msg->admin_id,
                    'admin_name'  => $msg->admin ? $msg->admin->name : null,
                    'time'        => $msg->created_at->format('H:i'),
                ];
            });

        $claimedAdmin = null;
        $lastClaimed = \App\Models\ChatMessage::where('session_id', $sessionId)
            ->whereNotNull('claimed_by_admin_id')
            ->with('claimedByAdmin')
            ->latest()
            ->first();
        if ($lastClaimed && $lastClaimed->claimedByAdmin) {
            $claimedAdmin = $lastClaimed->claimedByAdmin->name;
        }

        return response()->json([
            'success' => true,
            'messages' => $messages,
            'claimed_by' => $claimedAdmin,
            'current_admin_id' => auth()->id()
        ]);
    }

    public function claimChat($sessionId)
    {
        $this->checkRole();

        \App\Models\ChatMessage::where('session_id', $sessionId)
            ->update(['claimed_by_admin_id' => auth()->id()]);

        return response()->json([
            'success' => true,
            'message' => 'Chat berhasil diambil alih oleh Anda.',
            'admin_name' => auth()->user()->name
        ]);
    }

    public function replyChat(Request $request, $sessionId)
    {
        $this->checkRole();
        $request->validate([
            'message' => 'required|string'
        ]);

        $visitor = \App\Models\ChatMessage::where('session_id', $sessionId)
            ->where('sender_role', 'visitor')
            ->first();

        if (!$visitor) {
            return response()->json([
                'success' => false,
                'message' => 'Chat session tidak ditemukan.'
            ], 404);
        }

        $reply = \App\Models\ChatMessage::create([
            'session_id' => $sessionId,
            'name' => $visitor->name,
            'email' => $visitor->email,
            'message' => $request->message,
            'sender_role' => 'admin',
            'admin_id' => auth()->id(),
            'claimed_by_admin_id' => auth()->id()
        ]);

        \App\Models\ChatMessage::where('session_id', $sessionId)
            ->update(['claimed_by_admin_id' => auth()->id()]);

        return response()->json([
            'success' => true,
            'message' => 'Balasan berhasil dikirim!',
            'data' => [
                'id' => $reply->id,
                'message' => $reply->message,
                'sender_role' => $reply->sender_role,
                'time' => $reply->created_at->format('H:i'),
            ]
        ]);
    }
}
