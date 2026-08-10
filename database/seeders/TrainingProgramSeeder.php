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
                'title' => 'Pelatihan Kepemimpinan Kepala Madrasah Ibtidaiyah (MI)',
                'category' => 'Kategori Madrasah',
                'duration' => '40 Jam Pelajaran (JP)',
                'description' => 'Mempersiapkan kompetensi pedagogik, kepribadian, sosial, dan manajerial calon kepala madrasah tingkat Ibtidaiyah sesuai standar kelayakan sertifikasi LSP-MPI.',
                'benefits' => ['Sertifikat Pelatihan LPK-MPI', 'Simulasi Soal Uji Kompetensi', 'Bimbingan Portofolio'],
                'price' => 'Rp 1.500.000',
                'lsp_keyword' => 'Ibtidaiyah'
            ],
            [
                'id' => 'mts_prog',
                'title' => 'Pelatihan Kepemimpinan Kepala Madrasah Tsanawiyah (MTs)',
                'category' => 'Kategori Madrasah',
                'duration' => '48 Jam Pelajaran (JP)',
                'description' => 'Pelatihan tingkat lanjut bagi guru dan waka madrasah untuk meningkatkan keterampilan manajemen sekolah, supervisi guru, dan kewirausahaan madrasah.',
                'benefits' => ['Sertifikat Pelatihan LPK-MPI', 'Akses LMS 30 Hari', 'Modul Digital Lengkap'],
                'price' => 'Rp 1.750.000',
                'lsp_keyword' => 'Tsanawiyah'
            ],
            [
                'id' => 'ma_prog',
                'title' => 'Pelatihan Kepemimpinan Kepala Madrasah Aliyah (MA)',
                'category' => 'Kategori Madrasah',
                'duration' => '50 Jam Pelajaran (JP)',
                'description' => 'Menghasilkan pemimpin madrasah aliyah yang berdaya saing global, menguasai TI pendidikan, tata kelola kurikulum merdeka, dan standarisasi akreditasi nasional.',
                'benefits' => ['Sertifikat Pelatihan LPK-MPI', 'Bimbingan Penyusunan DIT', 'Review Portofolio oleh Asesor'],
                'price' => 'Rp 2.000.000',
                'lsp_keyword' => 'Aliyah'
            ],
            [
                'id' => 'ptki_prog',
                'title' => 'Pelatihan Kepemimpinan Pimpinan Perguruan Tinggi Keagamaan Indonesia (PTKI)',
                'category' => 'Kategori Pendidikan Tinggi',
                'duration' => '64 Jam Pelajaran (JP)',
                'description' => 'Dirancang khusus bagi Dosen/Pimpinan PTKI untuk menguasai tata kelola universitas, penjaminan mutu BAN-PT, kepemimpinan transformatif, dan kerja sama akademik.',
                'benefits' => ['Sertifikat Pelatihan LPK-MPI', 'Studi Kasus Internasional', 'Rekomendasi Akreditasi'],
                'price' => 'Rp 3.500.000',
                'lsp_keyword' => 'Perguruan Tinggi'
            ]
        ];

        foreach ($programs as $prog) {
            TrainingProgram::updateOrCreate(['id' => $prog['id']], $prog);
        }
    }
}
