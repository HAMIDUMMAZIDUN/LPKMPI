<?php

namespace App\Http\Controllers;

use App\Models\AssessmentScheme;
use App\Models\SchemeAssignment;
use App\Models\TraineeEnrollment;
use App\Models\Article;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        
        $traineesCount = $trainees->count();
        $certCount  = $trainees->where('status', 'LULUS')->count();

        return view('dashboard.admin', compact(
            'asetors', 'asesis', 'schemes', 'assignments', 
            'trainees', 'traineesCount', 'certCount', 'articles'
        ));
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

        User::create([
            'name'     => $request->username,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make('asesor-' . rand(1000, 9999)),
            'role'     => 'asesor',
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Asesor ' . $request->username . ' berhasil didaftarkan!');
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
            'role'     => 'asesi',
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Asesi ' . $request->username . ' berhasil didaftarkan!');
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
        return redirect()->route('admin.dashboard')->with('success', 'Akun ' . $user->name . ' berhasil dihapus.');
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

        return redirect()->route('admin.dashboard')->with('success', 'Skema berhasil ditugaskan!');
    }

    /** Cabut penugasan skema */
    public function revokeAssignment($id)
    {
        $this->checkRole();
        $assignment = SchemeAssignment::findOrFail($id);
        $assignment->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Penugasan skema berhasil dicabut.');
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
                'certificate_date' => now()->toDateString(), 
                'status' => 'LULUS'
            ]);
        }
        return redirect()->route('admin.dashboard')->with('success', 'Sertifikat ' . $trainee->name . ' berhasil diterbitkan!');
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
        }

        auth()->user()->update($data);

        return redirect()->route('admin.dashboard')->with('success', 'Profil Anda berhasil diperbarui!');
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

        return redirect()->route('admin.dashboard')->with('success', 'Artikel berhasil diterbitkan!');
    }

    /** Hapus artikel */
    public function destroyArticle($id)
    {
        $this->checkRole();
        $article = Article::findOrFail($id);
        $article->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Artikel berhasil dihapus!');
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
        
        return redirect()->route('admin.dashboard')->with('success', 'Pembayaran untuk ' . $trainee->name . ' berhasil diverifikasi!');
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

        $callback = function() use($trainees, $columns) {
            $file = fopen('php://output', 'w');
            
            // Add UTF-8 BOM to open correctly in Excel
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
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
}
