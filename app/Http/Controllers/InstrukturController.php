<?php

namespace App\Http\Controllers;

use App\Models\ClassSchedule;
use App\Models\TrainingProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstrukturController extends Controller
{
    private function checkRole()
    {
        if (!auth()->check() || auth()->user()->role !== 'instruktur') {
            abort(403, 'Akses ditolak.');
        }
    }

    /**
     * Menampilkan dashboard instruktur.
     */
    public function index()
    {
        $user = Auth::user();

        // Jadwal mengajar instruktur ini (asesor_id = instruktur user id)
        $schedules = \App\Models\ClassSchedule::where('asesor_id', $user->id)
            ->with('trainingProgram')
            ->orderBy('scheduled_at')
            ->get();

        // Jadwal terdekat yang belum lewat
        $nextSchedule = $schedules->where('scheduled_at', '>=', now())->first();

        // Semua program pelatihan
        $programs = \App\Models\TrainingProgram::latest()->get();

        // Attempt asesi yang perlu dievaluasi (untuk skema dari asesor ini)
        $attempts = \App\Models\AsesiSchemeAttempt::whereHas('scheme', fn($q) => $q->where('asesor_id', $user->id))
            ->with(['asesi', 'scheme'])
            ->latest()
            ->get();

        return view('dashboard.instruktur', compact('user', 'schedules', 'nextSchedule', 'programs', 'attempts'));
    }

    /** Live stats JSON – polled every 30 s by the dashboard */
    public function stats()
    {
        $this->checkRole();
        return response()->json([
            'schedules' => ClassSchedule::count(),
            'programs'  => TrainingProgram::count(),
            'ts'        => now()->toDateTimeString(),
        ]);
    }

    /**
     * Menyimpan materi atau modul.
     */
    public function storeMateri(Request $request)
    {
        // Contoh stub untuk simpan materi
        return redirect()->back()->with('success', 'Materi berhasil ditambahkan.');
    }

    /**
     * Menyimpan tugas.
     */
    public function storeTask(Request $request)
    {
        // Contoh stub untuk simpan tugas
        return redirect()->back()->with('success', 'Tugas berhasil ditambahkan.');
    }
}
