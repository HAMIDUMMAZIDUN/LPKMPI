<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstrukturController extends Controller
{
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
