<?php

namespace Database\Seeders;

use App\Models\TrainingProgram;
use Illuminate\Database\Seeder;

class TrainingProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            [
                'id' => 'mi_prog',
                'title' => 'Pelatihan Kompetensi Manajemen',
                'category' => 'Pelatihan',
                'duration' => '40 Jam Pelajaran (JP)',
                'description' => 'Program pelatihan intensif bagi yayasan, kepala sekolah, madrasah, dan praktisi untuk menguasai perencanaan strategis, kepemimpinan, dan tata kelola modern.',
                'benefits' => ['Sertifikat Pelatihan LPK-MPI', 'Simulasi Soal Uji Kompetensi', 'Bimbingan Portofolio'],
                'price' => 'Rp 1.500.000',
                'lsp_keyword' => 'Manajemen'
            ],
            [
                'id' => 'mts_prog',
                'title' => 'Teknologi & Administrasi Digital',
                'category' => 'Pelatihan',
                'duration' => '48 Jam Pelajaran (JP)',
                'description' => 'Peningkatan kompetensi IT bagi pendidik dan tenaga kependidikan dalam mengelola e-learning, LMS, EMIS/DAPODIK, dan platform digital sekolah.',
                'benefits' => ['Sertifikat Pelatihan LPK-MPI', 'Akses LMS 30 Hari', 'Modul Digital Lengkap'],
                'price' => 'Rp 1.750.000',
                'lsp_keyword' => 'Teknologi'
            ],
            [
                'id' => 'ma_prog',
                'title' => 'Bimbingan Sertifikasi Profesi',
                'category' => 'Sertifikasi',
                'duration' => '50 Jam Pelajaran (JP)',
                'description' => 'Bimbingan teknis dan simulasi bagi asesi untuk mempersiapkan portofolio kompetensi dan uji kelayakan sertifikasi profesi nasional (LSP).',
                'benefits' => ['Sertifikat Pelatihan LPK-MPI', 'Bimbingan Penyusunan DIT', 'Review Portofolio oleh Asesor'],
                'price' => 'Rp 2.000.000',
                'lsp_keyword' => 'Sertifikasi'
            ],
            [
                'id' => 'ptki_prog',
                'title' => 'Konsultansi Penjaminan Mutu',
                'category' => 'Konsultansi',
                'duration' => '64 Jam Pelajaran (JP)',
                'description' => 'Pendampingan persiapan akreditasi BAN-PDM, penyusunan kurikulum operasional, evaluasi diri sekolah (EDS), serta pengembangan SPMI.',
                'benefits' => ['Sertifikat Pelatihan LPK-MPI', 'Studi Kasus Internasional', 'Rekomendasi Akreditasi'],
                'price' => 'Rp 3.500.000',
                'lsp_keyword' => 'Mutu'
            ]
        ];

        foreach ($programs as $prog) {
            TrainingProgram::updateOrCreate(['id' => $prog['id']], $prog);
        }
    }
}
