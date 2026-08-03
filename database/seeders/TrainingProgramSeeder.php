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
                'id' => 'ginou_prog',
                'title' => 'Ginou Jisshu (Program Pemagangan Teknik)',
                'category' => 'Pemagangan Jepang',
                'duration' => '6 Bulan Kelas Intensif',
                'description' => 'Program magang resmi (Sending Organization) untuk mendapatkan keterampilan kerja di Jepang pada sektor konstruksi, pertanian, manufaktur, pengolahan makanan, dan industri pendukung.',
                'benefits' => ['Sertifikat Kompetensi LPK MMI', 'Simulasi Wawancara (Mansetsu)', 'Pelatihan Fisik, Mental, dan Disiplin (FMD)'],
                'price' => 'Rp 5.500.000',
                'lsp_keyword' => 'Magang'
            ],
            [
                'id' => 'ssw_prog',
                'title' => 'Tokutei Ginou (Specified Skilled Worker / SSW)',
                'category' => 'Pekerja Profesional',
                'duration' => '4 Bulan Kelas Intensif',
                'description' => 'Program kerja formal bagi tenaga ahli spesifik dengan status visa Tokutei Ginou. Fokus persiapan ujian skill bidang, ujian JFT-Basic/JLPT N4, dan kontrak kerja langsung.',
                'benefits' => ['Bimbingan Ujian JFT-Basic & SSW', 'Matching Wawancara Perusahaan Jepang', 'Pendampingan Berkas COE/Visa'],
                'price' => 'Rp 7.000.000',
                'lsp_keyword' => 'SSW'
            ],
            [
                'id' => 'bahasa_prog',
                'title' => 'Kelas Intensif Bahasa & Budaya Jepang (N5 - N4)',
                'category' => 'Bahasa & Budaya',
                'duration' => '3 Bulan Kelas',
                'description' => 'Kursus komprehensif menguasai tata bahasa, huruf (Hiragana, Katakana, Kanji), pendengaran (Choukai), percakapan (Kaiwa), serta pemahaman budaya kerja Jepang.',
                'benefits' => ['Modul Pembelajaran Minna no Nihongo', 'Sensei Eks-Japan Berpengalaman', 'Sertifikat Kelulusan Bahasa LPK'],
                'price' => 'Rp 3.500.000',
                'lsp_keyword' => 'Bahasa'
            ]
        ];

        foreach ($programs as $prog) {
            TrainingProgram::updateOrCreate(['id' => $prog['id']], $prog);
        }
    }
}
