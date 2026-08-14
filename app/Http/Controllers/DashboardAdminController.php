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

        return redirect()->route('admin.dashboard', ['open' => 'panel-articles'])->with('success', 'Artikel berhasil diterbitkan!');
    }

    /** Hapus artikel */
    public function destroyArticle($id)
    {
        $this->checkRole();
        $article = Article::findOrFail($id);
        $article->delete();

        return redirect()->route('admin.dashboard', ['open' => 'panel-articles'])->with('success', 'Artikel berhasil dihapus!');
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

        return redirect()->route('admin.dashboard', ['open' => 'panel-articles'])->with('success', 'Artikel berhasil diperbarui!');
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

    public function bulkVerifyPayment(Request $request)
    {
        $this->checkRole();
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:trainee_enrollments,id',
        ]);

        $count = 0;
        foreach ($request->ids as $id) {
            $trainee = TraineeEnrollment::find($id);
            if ($trainee && $trainee->payment_status !== 'PAID') {
                $refNumber = 'MPI-PAY-' . strtoupper(Str::random(10));
                $trainee->update([
                    'payment_status' => 'PAID',
                    'payment_method' => 'Manual Transfer (Verified Bulk)',
                    'payment_reference' => $refNumber,
                ]);
                $count++;
            }
        }

        return redirect()->route('admin.dashboard', ['open' => 'panel-verifikasi'])
            ->with('success', $count . ' pembayaran asesi berhasil diverifikasi!');
    }

    public function bulkDestroyTrainees(Request $request)
    {
        $this->checkRole();
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:trainee_enrollments,id',
        ]);

        $count = 0;
        foreach ($request->ids as $id) {
            $trainee = TraineeEnrollment::find($id);
            if ($trainee) {
                $trainee->delete();
                $count++;
            }
        }

        return redirect()->route('admin.dashboard', ['open' => 'panel-verifikasi'])
            ->with('success', $count . ' data pendaftaran asesi berhasil dihapus!');
    }

    public function updateSettings(Request $request)
    {
        $this->checkRole();

        // 1. Handle dynamic CMS item deletion
        if ($request->has('delete_cms_type') && $request->has('delete_cms_key')) {
            $type = $request->input('delete_cms_type'); // 'program', 'jadwal', or 'fasilitas'
            $keyToRemove = $request->input('delete_cms_key');
            
            $settingKey = "cms_{$type}_keys";
            $default = $type === 'program' ? 'manajemen,administrasi,kepemimpinan' : ($type === 'jadwal' ? '1,2,3' : 'belajar,perpustakaan,asrama');
            $currentKeys = explode(',', LandingSetting::getValue($settingKey, $default));
            
            $newKeys = array_filter($currentKeys, function($k) use ($keyToRemove) {
                return trim($k) !== trim($keyToRemove);
            });
            
            LandingSetting::updateOrCreate(['key' => $settingKey], ['value' => implode(',', $newKeys)]);
            
            // Clean up from landing_settings table
            LandingSetting::where('key', 'LIKE', "prog_{$keyToRemove}_%")->delete();
            LandingSetting::where('key', 'LIKE', "jadwal_{$keyToRemove}_%")->delete();
            LandingSetting::where('key', 'LIKE', "fasilitas_{$keyToRemove}_%")->delete();
            
            $activePanel = $request->input('active_panel', 'panel-program');
            return redirect()->route('admin.dashboard', ['open' => $activePanel])
                ->with('success', 'Item CMS berhasil dihapus!');
        }

        // 2. Handle dynamic CMS item addition
        if ($request->has('add_cms_type')) {
            $type = $request->input('add_cms_type'); // 'program', 'jadwal', or 'fasilitas'
            $newKey = $type . '_' . time();
            
            $settingKey = "cms_{$type}_keys";
            $default = $type === 'program' ? 'manajemen,administrasi,kepemimpinan' : ($type === 'jadwal' ? '1,2,3' : 'belajar,perpustakaan,asrama');
            $currentKeys = explode(',', LandingSetting::getValue($settingKey, $default));
            $currentKeys[] = $newKey;
            
            LandingSetting::updateOrCreate(['key' => $settingKey], ['value' => implode(',', array_filter($currentKeys))]);
            
            if ($type === 'program') {
                LandingSetting::updateOrCreate(['key' => "prog_{$newKey}_title"], ['value' => $request->input('new_title', 'Program Baru')]);
                LandingSetting::updateOrCreate(['key' => "prog_{$newKey}_durasi"], ['value' => $request->input('new_durasi', '')]);
                LandingSetting::updateOrCreate(['key' => "prog_{$newKey}_harga"], ['value' => $request->input('new_harga', '')]);
                LandingSetting::updateOrCreate(['key' => "prog_{$newKey}_desc"], ['value' => $request->input('new_desc', '')]);
                LandingSetting::updateOrCreate(['key' => "prog_{$newKey}_silabus"], ['value' => $request->input('new_silabus', '')]);
                LandingSetting::updateOrCreate(['key' => "prog_{$newKey}_prospek"], ['value' => $request->input('new_prospek', '')]);
            } elseif ($type === 'jadwal') {
                LandingSetting::updateOrCreate(['key' => "jadwal_{$newKey}_nama"], ['value' => $request->input('new_nama', 'Jadwal Baru')]);
                LandingSetting::updateOrCreate(['key' => "jadwal_{$newKey}_batas"], ['value' => $request->input('new_batas', '')]);
                LandingSetting::updateOrCreate(['key' => "jadwal_{$newKey}_waktu"], ['value' => $request->input('new_waktu', '')]);
                LandingSetting::updateOrCreate(['key' => "jadwal_{$newKey}_metode"], ['value' => $request->input('new_metode', '')]);
                LandingSetting::updateOrCreate(['key' => "jadwal_{$newKey}_quota"], ['value' => $request->input('new_quota', '')]);
            } elseif ($type === 'fasilitas') {
                LandingSetting::updateOrCreate(['key' => "fasilitas_{$newKey}_judul"], ['value' => $request->input('new_judul', 'Fasilitas Baru')]);
                LandingSetting::updateOrCreate(['key' => "fasilitas_{$newKey}_desc"], ['value' => $request->input('new_desc', '')]);
                if ($request->hasFile('new_foto')) {
                    $path = $request->file('new_foto')->store('landing/facilities', 'public');
                    LandingSetting::updateOrCreate(['key' => "fasilitas_{$newKey}_foto"], ['value' => $path]);
                }
            }
            
            $activePanel = $request->input('active_panel', 'panel-program');
            return redirect()->route('admin.dashboard', ['open' => $activePanel])
                ->with('success', 'Item CMS baru berhasil ditambahkan!');
        }

        // 3. Normal update of setting keys (both static and dynamic)
        $validationRules = [
            'site_logo'      => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'hero_image'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'login_bg_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'org_image'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ];

        foreach ($request->allFiles() as $fileKey => $file) {
            $validationRules[$fileKey] = 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048';
        }

        $request->validate($validationRules);

        foreach ($request->all() as $key => $value) {
            if (in_array($key, ['_token', 'active_panel', 'delete_cms_type', 'delete_cms_key', 'add_cms_type']) || $request->hasFile($key)) {
                continue;
            }
            LandingSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        foreach ($request->allFiles() as $key => $file) {
            $oldPath = LandingSetting::getValue($key);
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
            
            $dir = 'landing';
            if (str_starts_with($key, 'fasilitas_')) {
                $dir = 'landing/facilities';
            } elseif (str_starts_with($key, 'instruktur_')) {
                $dir = 'landing/instructors';
            } elseif ($key === 'site_logo') {
                $dir = 'landing/logo';
            } elseif ($key === 'login_bg_image') {
                $dir = 'landing/login';
            } elseif ($key === 'org_image') {
                $dir = 'landing/org';
            }
            
            $path = $file->store($dir, 'public');
            LandingSetting::updateOrCreate(['key' => $key], ['value' => $path]);
        }

        $activePanel = $request->input('active_panel', 'panel-landing');
        return redirect()->route('admin.dashboard', ['open' => $activePanel])
            ->with('success', 'Semua konten beranda berhasil diperbarui!');
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

    public function sendScheduleEmail(Request $request, $id)
    {
        $this->checkRole();
        
        $request->validate([
            'schedule_time' => 'required|string|max:255',
            'bank_info'     => 'required|string|max:500',
        ]);
        
        $trainee = TraineeEnrollment::findOrFail($id);
        
        try {
            $programTitle = $trainee->trainingProgram?->title ?? '-';
            $priceFormatted = $trainee->trainingProgram?->price ?? 'Rp 0';
            
            $emailContent = "Halo {$trainee->name},\n\n"
                . "Terima kasih telah mendaftar di LPK MPI untuk program pelatihan:\n"
                . "» {$programTitle}\n\n"
                . "Berikut adalah informasi penting mengenai jadwal pelatihan Anda:\n"
                . "» Hari/Tanggal: {$request->schedule_time}\n\n"
                . "Untuk melanjutkan pendaftaran dan aktivasi akun Anda, silakan lakukan pembayaran sebesar {$priceFormatted} ke nomor rekening resmi kami berikut:\n"
                . "» {$request->bank_info}\n\n"
                . "Setelah melakukan transfer, harap kirimkan bukti transfer kepada admin kami melalui live chat di portal LPK MPI atau membalas email ini.\n\n"
                . "Salam hangat,\n"
                . "Sekretariat LPK MPI";

            Mail::raw($emailContent, function ($message) use ($trainee) {
                $message->to($trainee->email)
                        ->subject("Jadwal Pelatihan & Informasi Pembayaran - LPK MPI");
            });
            
        } catch (\Exception $e) {
            logger()->error('Failed to send trainee schedule email: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengirim email: ' . $e->getMessage());
        }
        
        return redirect()->route('admin.dashboard', ['open' => 'panel-trainees-db'])
            ->with('success', 'Email jadwal pelatihan & info pembayaran untuk ' . $trainee->name . ' berhasil dikirim!');
    }
}
