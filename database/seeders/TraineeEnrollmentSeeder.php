<?php

namespace Database\Seeders;

use App\Models\TraineeEnrollment;
use Illuminate\Database\Seeder;

class TraineeEnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trainees = [
            [
                'name' => 'Dr. Hamidun, M.Pd',
                'nik' => '1234567890123456',
                'email' => 'hamidun@gmail.com',
                'phone' => '081234567890',
                'education' => 'S3',
                'category' => 'mahasiswa',
                'company' => 'Universitas Negeri Sunan Kalijaga',
                'position' => 'Dosen Kepala',
                'training_program_id' => 'ptki_prog',
                'certificate_number' => 'LPK-MPI-2026-9042',
                'certificate_date' => '2026-07-05',
                'status' => 'LULUS'
            ],
            [
                'name' => 'Siti Rahmawati, S.Pd.I',
                'nik' => '3201928374820192',
                'email' => 'siti.rahma@madrasah.sch.id',
                'phone' => '085712345678',
                'education' => 'S1',
                'category' => 'guru',
                'company' => 'MI Al-Hidayah Bandung',
                'position' => 'Waka Kurikulum',
                'training_program_id' => 'mi_prog',
                'certificate_number' => 'LPK-MPI-2026-1024',
                'certificate_date' => '2026-06-01',
                'status' => 'LULUS'
            ],
            [
                'name' => 'M. Yusuf Al-Farabi, M.Ag',
                'nik' => '3504829302910394',
                'email' => 'yusuf.farabi@mtsn.sch.id',
                'phone' => '081398765432',
                'education' => 'S2',
                'category' => 'guru',
                'company' => 'MTs Negeri 1 Yogyakarta',
                'position' => 'Guru Utama',
                'training_program_id' => 'mts_prog',
                'certificate_number' => 'LPK-MPI-2026-5819',
                'certificate_date' => '2026-05-12',
                'status' => 'LULUS'
            ],
            [
                'name' => 'Ahmad Roni, S.Kom',
                'nik' => '3205123456780001',
                'email' => 'ahmad.roni@gmail.com',
                'phone' => '087812345678',
                'education' => 'S1',
                'category' => 'umum',
                'company' => 'PT Solusi Teknologi Nusantara',
                'position' => 'Staff IT',
                'training_program_id' => 'ma_prog',
                'certificate_number' => null,
                'certificate_date' => null,
                'status' => 'PROSES'
            ]
        ];

        foreach ($trainees as $trainee) {
            TraineeEnrollment::updateOrCreate(['nik' => $trainee['nik']], $trainee);
        }
    }
}
