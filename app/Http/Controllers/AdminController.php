<?php

namespace App\Http\Controllers;

use App\Models\ApiLog;
use App\Models\TraineeEnrollment;
use App\Models\TrainingProgram;
use App\Models\LandingSetting;
use App\Models\User;
use Database\Seeders\TraineeEnrollmentSeeder;
use Database\Seeders\TrainingProgramSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Redirect to the single page app hash route for the admin panel or return JSON statistics.
     */
    public function index()
    {
        // If requested via AJAX/fetch, return the real-time data
        if (request()->ajax() || request()->wantsJson()) {
            $traineesCount = TraineeEnrollment::count();
            $certificatesCount = TraineeEnrollment::where('status', 'LULUS')->count();
            $apiHitsCount = ApiLog::count();
            $trainees = TraineeEnrollment::with('trainingProgram')->latest()->get();

            return response()->json([
                'success' => true,
                'stats' => [
                    'total' => $traineesCount,
                    'cert' => $certificatesCount,
                    'api' => $apiHitsCount
                ],
                'trainees' => $trainees
            ]);
        }

        // Redirect browser visit directly to the SPA hash tab
        return redirect()->to('/#admin-panel');
    }

    /**
     * Trigger database seeding dynamically.
     */
    public function seed(Request $request)
    {
        // Seed programs first if empty
        if (TrainingProgram::count() == 0) {
            $programSeeder = new TrainingProgramSeeder();
            $programSeeder->run();
        }

        $traineeSeeder = new TraineeEnrollmentSeeder();
        $traineeSeeder->run();

        return redirect()->to('/#admin-panel')->with('success', 'Data sampel berhasil ditambahkan ke database!');
    }

    /**
     * Reset/Truncate all database tables related to LPK.
     */
    public function reset(Request $request)
    {
        TraineeEnrollment::truncate();
        ApiLog::truncate();

        return redirect()->to('/#admin-panel')->with('success', 'Database pendaftaran dan API log berhasil dikosongkan!');
    }

    /**
     * Update landing/welcome settings and handle image upload.
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'required|string',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'stat_1_val' => 'required|string|max:255',
            'stat_1_lbl' => 'required|string|max:255',
            'stat_2_val' => 'required|string|max:255',
            'stat_2_lbl' => 'required|string|max:255',
            'stat_3_val' => 'required|string|max:255',
            'stat_3_lbl' => 'required|string|max:255',
            'step_1_title' => 'required|string|max:255',
            'step_2_title' => 'required|string|max:255',
            'step_3_title' => 'required|string|max:255',
            'why_choose_title' => 'required|string|max:255',
            'feature_1_title' => 'required|string|max:255',
            'feature_1_desc' => 'required|string',
            'feature_2_title' => 'required|string|max:255',
            'feature_2_desc' => 'required|string',
            'feature_3_title' => 'required|string|max:255',
            'feature_3_desc' => 'required|string',
        ]);

        LandingSetting::updateOrCreate(['key' => 'hero_title'], ['value' => $request->hero_title]);
        LandingSetting::updateOrCreate(['key' => 'hero_subtitle'], ['value' => $request->hero_subtitle]);
        LandingSetting::updateOrCreate(['key' => 'stat_1_val'], ['value' => $request->stat_1_val]);
        LandingSetting::updateOrCreate(['key' => 'stat_1_lbl'], ['value' => $request->stat_1_lbl]);
        LandingSetting::updateOrCreate(['key' => 'stat_2_val'], ['value' => $request->stat_2_val]);
        LandingSetting::updateOrCreate(['key' => 'stat_2_lbl'], ['value' => $request->stat_2_lbl]);
        LandingSetting::updateOrCreate(['key' => 'stat_3_val'], ['value' => $request->stat_3_val]);
        LandingSetting::updateOrCreate(['key' => 'stat_3_lbl'], ['value' => $request->stat_3_lbl]);
        LandingSetting::updateOrCreate(['key' => 'step_1_title'], ['value' => $request->step_1_title]);
        LandingSetting::updateOrCreate(['key' => 'step_2_title'], ['value' => $request->step_2_title]);
        LandingSetting::updateOrCreate(['key' => 'step_3_title'], ['value' => $request->step_3_title]);
        LandingSetting::updateOrCreate(['key' => 'why_choose_title'], ['value' => $request->why_choose_title]);
        LandingSetting::updateOrCreate(['key' => 'feature_1_title'], ['value' => $request->feature_1_title]);
        LandingSetting::updateOrCreate(['key' => 'feature_1_desc'], ['value' => $request->feature_1_desc]);
        LandingSetting::updateOrCreate(['key' => 'feature_2_title'], ['value' => $request->feature_2_title]);
        LandingSetting::updateOrCreate(['key' => 'feature_2_desc'], ['value' => $request->feature_2_desc]);
        LandingSetting::updateOrCreate(['key' => 'feature_3_title'], ['value' => $request->feature_3_title]);
        LandingSetting::updateOrCreate(['key' => 'feature_3_desc'], ['value' => $request->feature_3_desc]);

        if ($request->hasFile('hero_image')) {
            // Delete old file if exists
            $oldPath = LandingSetting::getValue('hero_image');
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }

            // Save new file
            $path = $request->file('hero_image')->store('landing', 'public');
            LandingSetting::updateOrCreate(['key' => 'hero_image'], ['value' => $path]);
        }

        return redirect()->to('/#admin-panel')->with('success', 'Pengaturan halaman utama berhasil diperbarui!');
    }

    /**
     * Approve trainee enrollment and issue certificate (Admin role only).
     */
    public function approveTrainee(Request $request, $id)
    {
        // Enforce that only 'admin' role can approve
        if (auth()->user()->role !== 'admin') {
            return redirect()->to('/#admin-panel')->with('error', 'Akses Ditolak: Hanya pengguna dengan role Admin yang diizinkan untuk menyetujui pendaftaran (Superadmin tidak diperbolehkan).');
        }

        $trainee = TraineeEnrollment::findOrFail($id);

        if ($trainee->status !== 'LULUS') {
            // Generate unique certificate number
            do {
                $randomDigits = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
                $certNumber = 'LPK-MI-' . date('Y') . '-' . $randomDigits;
            } while (TraineeEnrollment::where('certificate_number', $certNumber)->exists());

            $trainee->update([
                'certificate_number' => $certNumber,
                'certificate_date' => now()->toDateString(),
                'status' => 'LULUS'
            ]);
        }

        return redirect()->to('/#admin-panel')->with('success', 'Pendaftaran ' . $trainee->name . ' berhasil disetujui dan sertifikat telah terbit!');
    }

    /**
     * Update Superadmin profile details (email & name).
     */
    public function updateProfile(Request $request)
    {
        if (auth()->user()->role !== 'superadmin') {
            return redirect()->to('/#admin-panel')->with('error', 'Akses Ditolak: Hanya Superadmin yang diizinkan mengubah email ini.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
        ]);

        auth()->user()->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->to('/#admin-panel')->with('success', 'Profil Superadmin berhasil diperbarui!');
    }

    /**
     * Store a new Admin role user (Superadmin only).
     */
    public function storeAdmin(Request $request)
    {
        if (auth()->user()->role !== 'superadmin') {
            return redirect()->to('/#admin-panel')->with('error', 'Akses Ditolak: Hanya Superadmin yang diizinkan mendaftarkan Admin baru.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('sso-only-' . rand(1000, 9999)),
            'role' => 'admin',
        ]);

        return redirect()->to('/#admin-panel')->with('success', 'Admin baru dengan email ' . $request->email . ' berhasil didaftarkan!');
    }

    /**
     * Revoke/Delete Admin role user (Superadmin only).
     */
    public function destroyAdmin(Request $request, $id)
    {
        if (auth()->user()->role !== 'superadmin') {
            return redirect()->to('/#admin-panel')->with('error', 'Akses Ditolak: Hanya Superadmin yang diizinkan mencabut akses Admin.');
        }

        $user = User::findOrFail($id);

        if ($user->role === 'superadmin') {
            return redirect()->to('/#admin-panel')->with('error', 'Akses Ditolak: Tidak dapat menghapus sesama akun Superadmin.');
        }

        $user->delete();

        return redirect()->to('/#admin-panel')->with('success', 'Akses Admin ' . $user->name . ' berhasil dicabut!');
    }
}
