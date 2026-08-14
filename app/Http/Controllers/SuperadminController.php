<?php

namespace App\Http\Controllers;

use App\Models\LandingSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SuperadminController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'superadmin') {
            return redirect()->route('home')->with('error', 'Akses ditolak.');
        }

        $settings = LandingSetting::pluck('value', 'key');
        $admins   = User::where('role', 'admin')->latest()->get();
        $asesors  = User::where('role', 'asesor')->latest()->get();
        $articles = \App\Models\Article::latest()->get();
        
        $programs = \App\Models\TrainingProgram::all();
        $trainees = \App\Models\TraineeEnrollment::with('trainingProgram')->latest()->get();

        return view('dashboard.superadmin', compact('settings', 'admins', 'asesors', 'articles', 'programs', 'trainees'));
    }

    /** Live stats endpoint — polled by the dashboard every 30 s */
    public function stats()
    {
        if (Auth::user()->role !== 'superadmin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        return response()->json([
            'users'    => \App\Models\User::count(),
            'admins'   => \App\Models\User::where('role', 'admin')->count(),
            'asesors'  => \App\Models\User::where('role', 'asesor')->count(),
            'trainees' => \App\Models\TraineeEnrollment::count(),
            'lulus'    => \App\Models\TraineeEnrollment::where('status', 'LULUS')->count(),
            'pending'  => \App\Models\TraineeEnrollment::where('payment_status', 'PENDING')->count(),
            'programs' => \App\Models\TrainingProgram::count(),
            'articles' => \App\Models\Article::count(),
            'ts'       => now()->toDateTimeString(),
        ]);
    }

    public function storeUser(Request $request)
    {
        if (Auth::user()->role !== 'superadmin') {
            return redirect()->back()->with('error', 'Akses Ditolak.');
        }

        $request->validate([
            'username' => 'required|string|unique:users,username|max:255',
            'email'    => ['required', 'email', 'unique:users,email', 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/i'],
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'required|in:admin,asesor',
        ], [
            'email.regex' => 'Alamat email harus menggunakan domain @gmail.com.',
        ]);

        User::create([
            'name'     => $request->username,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => $request->password, // auto-hashed by model cast
            'password_plain' => $request->password,
            'role'     => $request->role,
        ]);

        return redirect()->route('superadmin.dashboard', ['open' => 'panel-users'])
            ->with('success', "Akun {$request->role} '{$request->username}' berhasil dibuat!");
    }

    public function destroyUser(Request $request, int $id)
    {
        if (Auth::user()->role !== 'superadmin') {
            return redirect()->back()->with('error', 'Akses Ditolak.');
        }

        $user = User::findOrFail($id);

        if ($user->role === 'superadmin') {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun Superadmin.');
        }

        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('superadmin.dashboard', ['open' => 'panel-users'])
            ->with('success', "Akun {$user->name} berhasil dihapus.");
    }

    public function updateSettings(Request $request)
    {
        if (Auth::user()->role !== 'superadmin') {
            return redirect()->back()->with('error', 'Akses Ditolak.');
        }

        // 1. Handle dynamic CMS item deletion
        if ($request->has('delete_cms_type') && $request->has('delete_cms_key')) {
            $type = $request->input('delete_cms_type'); // 'program', 'jadwal', or 'fasilitas'
            $keyToRemove = $request->input('delete_cms_key');
            
            $settingKey = "cms_{$type}_keys";
            $default = $type === 'program' ? 'manajemen,administrasi,kepemimpinan' : ($type === 'jadwal' ? '1,2,3' : 'belajar,perpustakaan,asrama');
            $currentKeys = explode(',', LandingSetting::getValue($settingKey, $default));
            
            $newKeys = array_filter($currentKeys, fn($k) => trim($k) !== trim($keyToRemove));
            
            LandingSetting::updateOrCreate(['key' => $settingKey], ['value' => implode(',', $newKeys)]);
            
            // Clean up from landing_settings table
            LandingSetting::where('key', 'LIKE', "prog_{$keyToRemove}_%")->delete();
            LandingSetting::where('key', 'LIKE', "jadwal_{$keyToRemove}_%")->delete();
            LandingSetting::where('key', 'LIKE', "fasilitas_{$keyToRemove}_%")->delete();
            
            $activePanel = $request->input('active_panel', 'panel-program');
            return redirect()->route('superadmin.dashboard', ['open' => $activePanel])
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
            return redirect()->route('superadmin.dashboard', ['open' => $activePanel])
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
        return redirect()->route('superadmin.dashboard', ['open' => $activePanel])
            ->with('success', 'Semua konten beranda berhasil diperbarui!');
    }

    public function storeArticle(Request $request)
    {
        if (Auth::user()->role !== 'superadmin') {
            return redirect()->back()->with('error', 'Akses Ditolak.');
        }
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('articles', 'public');
        }

        \App\Models\Article::create([
            'title' => $request->title,
            'slug' => \Illuminate\Support\Str::slug($request->title),
            'content' => $request->content,
            'image_path' => $imagePath,
            'author' => Auth::user()->name,
            'published_at' => now(),
        ]);

        return redirect()->route('superadmin.dashboard', ['open' => 'panel-articles'])->with('success', 'Artikel berhasil diterbitkan!');
    }

    public function destroyArticle(int $id)
    {
        if (Auth::user()->role !== 'superadmin') {
            return redirect()->back()->with('error', 'Akses Ditolak.');
        }
        $article = \App\Models\Article::findOrFail($id);
        
        if ($article->image_path && Storage::disk('public')->exists($article->image_path)) {
            Storage::disk('public')->delete($article->image_path);
        }
        
        $article->delete();

        return redirect()->route('superadmin.dashboard', ['open' => 'panel-articles'])->with('success', 'Artikel berhasil dihapus!');
    }

    public function updateProfile(Request $request)
    {
        if (Auth::user()->role !== 'superadmin') {
            return redirect()->back()->with('error', 'Akses Ditolak.');
        }

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . Auth::id(),
            'email'    => ['required', 'email', 'unique:users,email,' . Auth::id(), 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/i'],
            'password' => 'nullable|string|min:8|confirmed',
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
        }

        User::findOrFail(Auth::id())->update($data);

        return redirect()->route('superadmin.dashboard', ['open' => 'panel-profile'])->with('success', 'Profil berhasil diperbarui!');
    }

    public function storeProgram(Request $request)
    {
        if (Auth::user()->role !== 'superadmin') {
            return redirect()->back()->with('error', 'Akses Ditolak.');
        }

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

        \App\Models\TrainingProgram::create([
            'id' => $request->id,
            'title' => $request->title,
            'category' => $request->category,
            'duration' => $request->duration,
            'description' => $request->description,
            'benefits' => $benefitsArray,
            'price' => $request->price,
            'lsp_keyword' => $request->lsp_keyword,
        ]);

        return redirect()->route('superadmin.dashboard', ['open' => 'panel-programs-db'])
            ->with('success', 'Program pelatihan berhasil ditambahkan!');
    }

    public function updateProgram(Request $request, int|string $id)
    {
        if (Auth::user()->role !== 'superadmin') {
            return redirect()->back()->with('error', 'Akses Ditolak.');
        }

        $program = \App\Models\TrainingProgram::findOrFail($id);

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

        return redirect()->route('superadmin.dashboard', ['open' => 'panel-programs-db'])
            ->with('success', 'Program pelatihan berhasil diperbarui!');
    }

    public function destroyProgram(int|string $id)
    {
        if (Auth::user()->role !== 'superadmin') {
            return redirect()->back()->with('error', 'Akses Ditolak.');
        }

        $program = \App\Models\TrainingProgram::findOrFail($id);
        $program->delete();

        return redirect()->route('superadmin.dashboard', ['open' => 'panel-programs-db'])
            ->with('success', 'Program pelatihan berhasil dihapus!');
    }

    public function approveTrainee(int $id)
    {
        if (Auth::user()->role !== 'superadmin') {
            return redirect()->back()->with('error', 'Akses Ditolak.');
        }

        $trainee = \App\Models\TraineeEnrollment::findOrFail($id);
        if ($trainee->status !== 'LULUS') {
            do {
                $certNumber = 'LPK-MPI-' . date('Y') . '-' . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
            } while (\App\Models\TraineeEnrollment::where('certificate_number', $certNumber)->exists());
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
            $certNumber   = $trainee->fresh()->certificate_number;
            $certDate     = $trainee->fresh()->certificate_date
                                ? $trainee->fresh()->certificate_date->format('d M Y')
                                : now()->format('d M Y');

            $emailContent = "Selamat! Pendaftaran Anda di LPK MPI telah DISETUJUI dan sertifikat Anda telah diterbitkan.\n\n"
                . "Detail Sertifikat:\n"
                . "- Nama Peserta   : {$trainee->name}\n"
                . "- No. Sertifikat : {$certNumber}\n"
                . "- Tanggal        : {$certDate}\n\n"
                . "Akun Login Dashboard LPK MPI Anda:\n"
                . "- URL Login  : {$loginUrl}\n"
                . "- Username   : {$existingUser->username}\n"
                . "- Email      : {$existingUser->email}\n"
                . "- Password   : {$passwordText}\n\n"
                . "Silakan login dengan kredensial di atas untuk melihat sertifikat dan mengikuti ujian kompetensi.\n"
                . "Simpan informasi ini di tempat yang aman.\n\n"
                . "Hormat kami,\n"
                . "Superadmin LPK MPI";

            Mail::raw($emailContent, function ($message) use ($trainee, $certNumber) {
                $message->to($trainee->email)
                        ->subject("Selamat! Sertifikat LPK MPI Anda [{$certNumber}] Telah Diterbitkan");
            });
        } catch (\Exception $e) {
            logger()->error('Failed to send approval email: ' . $e->getMessage());
        }

        return redirect()->route('superadmin.dashboard', ['open' => 'panel-trainees-db'])
            ->with('success', 'Sertifikat ' . $trainee->name . ' berhasil diterbitkan & email notifikasi dikirim!');
    }

    public function verifyPayment(int $id)
    {
        if (Auth::user()->role !== 'superadmin') {
            return redirect()->back()->with('error', 'Akses Ditolak.');
        }

        $trainee = \App\Models\TraineeEnrollment::findOrFail($id);
        
        $refNumber = 'MPI-PAY-' . strtoupper(\Illuminate\Support\Str::random(10));
        
        $trainee->update([
            'payment_status' => 'PAID',
            'payment_method' => 'Manual Transfer (Verified by Superadmin)',
            'payment_reference' => $refNumber,
        ]);
        
        return redirect()->route('superadmin.dashboard', ['open' => 'panel-trainees-db'])
            ->with('success', 'Pembayaran untuk ' . $trainee->name . ' berhasil diverifikasi!');
    }

    public function destroyTrainee(int $id)
    {
        if (Auth::user()->role !== 'superadmin') {
            return redirect()->back()->with('error', 'Akses Ditolak.');
        }

        $trainee = \App\Models\TraineeEnrollment::findOrFail($id);
        $trainee->delete();

        return redirect()->route('superadmin.dashboard', ['open' => 'panel-trainees-db'])
            ->with('success', 'Pendaftaran/peserta berhasil dihapus!');
    }

    public function updateUser(Request $request, int $id)
    {
        if (Auth::user()->role !== 'superadmin') {
            return redirect()->back()->with('error', 'Akses Ditolak.');
        }

        $user = User::findOrFail($id);

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email'    => ['required', 'email', 'unique:users,email,' . $id, 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/i'],
            'password' => 'nullable|string|min:8',
            'role'     => 'required|in:admin,asesor',
        ], [
            'email.regex' => 'Alamat email harus menggunakan domain @gmail.com.',
        ]);

        $data = [
            'name'     => $request->username,
            'username' => $request->username,
            'email'    => $request->email,
            'role'     => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
            $data['password_plain'] = $request->password;
        }

        $user->update($data);

        return redirect()->route('superadmin.dashboard', ['open' => 'panel-users'])
            ->with('success', "Akun '{$user->username}' berhasil diperbarui!");
    }

    public function updateArticle(Request $request, int $id)
    {
        if (Auth::user()->role !== 'superadmin') {
            return redirect()->back()->with('error', 'Akses Ditolak.');
        }

        $article = \App\Models\Article::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = [
            'title' => $request->title,
            'slug' => \Illuminate\Support\Str::slug($request->title),
            'content' => $request->content,
        ];

        if ($request->hasFile('image')) {
            if ($article->image_path && Storage::disk('public')->exists($article->image_path)) {
                Storage::disk('public')->delete($article->image_path);
            }
            $data['image_path'] = $request->file('image')->store('articles', 'public');
        }

        $article->update($data);

        return redirect()->route('superadmin.dashboard', ['open' => 'panel-articles'])
            ->with('success', 'Artikel berhasil diperbarui!');
    }

    public function updateTrainee(Request $request, int $id)
    {
        if (Auth::user()->role !== 'superadmin') {
            return redirect()->back()->with('error', 'Akses Ditolak.');
        }

        $trainee = \App\Models\TraineeEnrollment::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'status' => 'required|string',
            'payment_status' => 'required|string',
        ]);

        $trainee->update($request->only('name', 'nik', 'email', 'phone', 'status', 'payment_status'));

        return redirect()->route('superadmin.dashboard', ['open' => 'panel-trainees-db'])
            ->with('success', 'Data pendaftaran ' . $trainee->name . ' berhasil diperbarui!');
    }
}
