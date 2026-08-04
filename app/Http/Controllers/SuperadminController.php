<?php

namespace App\Http\Controllers;

use App\Models\LandingSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class SuperadminController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'superadmin') {
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

    public function storeUser(Request $request)
    {
        if (auth()->user()->role !== 'superadmin') {
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
            'role'     => $request->role,
        ]);

        return redirect()->route('superadmin.dashboard', ['open' => 'panel-users'])
            ->with('success', "Akun {$request->role} '{$request->username}' berhasil dibuat!");
    }

    public function destroyUser(Request $request, $id)
    {
        if (auth()->user()->role !== 'superadmin') {
            return redirect()->back()->with('error', 'Akses Ditolak.');
        }

        $user = User::findOrFail($id);

        if ($user->role === 'superadmin') {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun Superadmin.');
        }

        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('superadmin.dashboard', ['open' => 'panel-users'])
            ->with('success', "Akun {$user->name} berhasil dihapus.");
    }

    public function updateSettings(Request $request)
    {
        if (auth()->user()->role !== 'superadmin') {
            return redirect()->back()->with('error', 'Akses Ditolak.');
        }

        $request->validate([
            'site_title'         => 'nullable|string|max:100',
            'site_logo'          => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:1024',
            'hero_title'         => 'nullable|string|max:255',
            'hero_subtitle'      => 'nullable|string',
            'hero_image'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'why_choose_title'   => 'nullable|string|max:255',
            'gallery_title'      => 'nullable|string|max:255',
            'gallery_subtitle'   => 'nullable|string|max:500',
            'login_left_title_1' => 'nullable|string|max:100',
            'login_left_title_2' => 'nullable|string|max:100',
            'login_left_sub'     => 'nullable|string|max:100',
            'login_left_main'    => 'nullable|string|max:255',
            'login_left_footer_title' => 'nullable|string|max:100',
            'login_left_footer_desc'  => 'nullable|string|max:500',
            'login_bg_image'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'stat_count'         => 'nullable|integer',
            'step_count'         => 'nullable|integer',
            'feature_count'      => 'nullable|integer',
            'org_image'          => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'instruktur_1_foto'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'instruktur_2_foto'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'instruktur_3_foto'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'instruktur_4_foto'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'fasilitas_belajar_foto'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'fasilitas_perpustakaan_foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'fasilitas_asrama_foto'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $keys = [
            'site_title', 'hero_title', 'hero_subtitle',
            'why_choose_title',
            'gallery_title', 'gallery_subtitle',
            'login_left_title_1', 'login_left_title_2', 'login_left_sub', 'login_left_main', 'login_left_footer_title', 'login_left_footer_desc',
            'stat_count', 'step_count', 'feature_count',
            
            // Tentang Kami
            'tentang_profil_1', 'tentang_profil_2', 'tentang_visi', 'tentang_misi',
            'org_director_dewan', 'org_director_lpk', 'org_manager_pelatihan', 'org_komite_program', 'org_manager_mutu',
            
            // Program Pelatihan
            'prog_manajemen_title', 'prog_manajemen_durasi', 'prog_manajemen_harga', 'prog_manajemen_desc', 'prog_manajemen_silabus', 'prog_manajemen_prospek',
            'prog_administrasi_title', 'prog_administrasi_durasi', 'prog_administrasi_harga', 'prog_administrasi_desc', 'prog_administrasi_silabus', 'prog_administrasi_prospek',
            'prog_kepemimpinan_title', 'prog_kepemimpinan_durasi', 'prog_kepemimpinan_harga', 'prog_kepemimpinan_desc', 'prog_kepemimpinan_silabus', 'prog_kepemimpinan_prospek',
            
            // Jadwal Diklat
            'jadwal_1_nama', 'jadwal_1_batas', 'jadwal_1_waktu', 'jadwal_1_metode', 'jadwal_1_quota',
            'jadwal_2_nama', 'jadwal_2_batas', 'jadwal_2_waktu', 'jadwal_2_metode', 'jadwal_2_quota',
            'jadwal_3_nama', 'jadwal_3_batas', 'jadwal_3_waktu', 'jadwal_3_metode', 'jadwal_3_quota',
            
            // Fasilitas
            'fasilitas_belajar_judul', 'fasilitas_belajar_desc',
            'fasilitas_perpustakaan_judul', 'fasilitas_perpustakaan_desc',
            'fasilitas_asrama_judul', 'fasilitas_asrama_desc',
            
            // Kontak
            'kontak_alamat', 'kontak_wa', 'kontak_email', 'kontak_jam',
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

        // Instruktur keys (1 to 4)
        for ($i = 1; $i <= 4; $i++) {
            $keys[] = "instruktur_{$i}_nama";
            $keys[] = "instruktur_{$i}_jabatan";
            $keys[] = "instruktur_{$i}_keahlian";
            $keys[] = "instruktur_{$i}_pengalaman";
        }

        // FAQ keys (1 to 6)
        for ($i = 1; $i <= 6; $i++) {
            $keys[] = "faq_{$i}_q";
            $keys[] = "faq_{$i}_a";
        }

        // Gallery item text keys (1 to 6)
        for ($i = 1; $i <= 6; $i++) {
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

        // Instruktur photos upload (1 to 4)
        for ($i = 1; $i <= 4; $i++) {
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
        for ($i = 1; $i <= 6; $i++) {
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
        return redirect()->route('superadmin.dashboard', ['open' => $activePanel])->with('success', 'Semua konten beranda berhasil diperbarui!');
    }

    public function storeArticle(Request $request)
    {
        if (auth()->user()->role !== 'superadmin') {
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
            'author' => auth()->user()->name,
            'published_at' => now(),
        ]);

        return redirect()->route('superadmin.dashboard', ['open' => 'panel-articles'])->with('success', 'Artikel berhasil diterbitkan!');
    }

    public function destroyArticle($id)
    {
        if (auth()->user()->role !== 'superadmin') {
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
        if (auth()->user()->role !== 'superadmin') {
            return redirect()->back()->with('error', 'Akses Ditolak.');
        }

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . auth()->id(),
            'email'    => ['required', 'email', 'unique:users,email,' . auth()->id(), 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/i'],
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

        auth()->user()->update($data);

        return redirect()->route('superadmin.dashboard', ['open' => 'panel-profile'])->with('success', 'Profil berhasil diperbarui!');
    }

    public function storeProgram(Request $request)
    {
        if (auth()->user()->role !== 'superadmin') {
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

    public function updateProgram(Request $request, $id)
    {
        if (auth()->user()->role !== 'superadmin') {
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

    public function destroyProgram($id)
    {
        if (auth()->user()->role !== 'superadmin') {
            return redirect()->back()->with('error', 'Akses Ditolak.');
        }

        $program = \App\Models\TrainingProgram::findOrFail($id);
        $program->delete();

        return redirect()->route('superadmin.dashboard', ['open' => 'panel-programs-db'])
            ->with('success', 'Program pelatihan berhasil dihapus!');
    }

    public function approveTrainee($id)
    {
        if (auth()->user()->role !== 'superadmin') {
            return redirect()->back()->with('error', 'Akses Ditolak.');
        }

        $trainee = \App\Models\TraineeEnrollment::findOrFail($id);
        if ($trainee->status !== 'LULUS') {
            do {
                $certNumber = 'LPK-MPI-' . date('Y') . '-' . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
            } while (\App\Models\TraineeEnrollment::where('certificate_number', $certNumber)->exists());
            $trainee->update([
                'certificate_number' => $certNumber, 
                'certificate_date' => now()->toDateString(), 
                'status' => 'LULUS'
            ]);
        }
        return redirect()->route('superadmin.dashboard', ['open' => 'panel-trainees-db'])
            ->with('success', 'Sertifikat ' . $trainee->name . ' berhasil diterbitkan!');
    }

    public function verifyPayment($id)
    {
        if (auth()->user()->role !== 'superadmin') {
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

    public function destroyTrainee($id)
    {
        if (auth()->user()->role !== 'superadmin') {
            return redirect()->back()->with('error', 'Akses Ditolak.');
        }

        $trainee = \App\Models\TraineeEnrollment::findOrFail($id);
        $trainee->delete();

        return redirect()->route('superadmin.dashboard', ['open' => 'panel-trainees-db'])
            ->with('success', 'Pendaftaran/peserta berhasil dihapus!');
    }
}
