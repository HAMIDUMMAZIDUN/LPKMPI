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
        // Jika perlu passing data, bisa dilakukan di sini
        return view('dashboard.instruktur', [
            'user' => Auth::user(),
        ]);
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
