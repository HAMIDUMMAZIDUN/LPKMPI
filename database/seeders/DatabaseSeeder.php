<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Superadmin ────────────────────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'hamidun@gmail.com'],
            [
                'name' => 'Hamidun',
                'username' => 'hamidun',
                'password' => Hash::make('hamidun123'),
                'password_plain' => 'hamidun123',
                'role' => 'superadmin'
            ]
        );

        // ─── Admin ─────────────────────────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'admin.lpk@gmail.com'],
            [
                'name' => 'Admin LPK',
                'username' => 'admin_lpk',
                'password' => Hash::make('password123'),
                'password_plain' => 'password123',
                'role' => 'admin'
            ]
        );

        // ─── Asesor ────────────────────────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'asesor.lpk@gmail.com'],
            [
                'name' => 'Asesor LPK',
                'username' => 'asesor_lpk',
                'password' => Hash::make('password123'),
                'password_plain' => 'password123',
                'role' => 'asesor'
            ]
        );

        // ─── Asesi ─────────────────────────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'asesi.lpk@gmail.com'],
            [
                'name' => 'Asesi LPK',
                'username' => 'asesi_lpk',
                'password' => Hash::make('password123'),
                'password_plain' => 'password123',
                'role' => 'asesi'
            ]
        );

        $this->call([
            TrainingProgramSeeder::class,
            LandingSettingSeeder::class,
            TraineeEnrollmentSeeder::class,
        ]);

        \App\Models\TraineeEnrollment::updateOrCreate(
            ['email' => 'asesi.lpk@gmail.com'],
            [
                'name' => 'Asesi LPK',
                'nik' => '3205123456789012',
                'phone' => '089876543210',
                'education' => 'SMA',
                'category' => 'umum',
                'company' => 'Mandiri',
                'position' => 'Peserta Didik',
                'training_program_id' => 'mi_prog',
                'certificate_number' => 'LPK-MPI-2026-8899',
                'certificate_date' => '2026-08-01',
                'status' => 'LULUS',
                'payment_status' => 'PAID',
                'payment_method' => 'TRANSFER',
                'payment_reference' => 'MPI-PAY-INIT-001',
                'payment_amount' => 1500000
            ]
        );

        // ─── Assessment Scheme ──────────────────────────────────────────────
        $asesor = User::where('role', 'asesor')->first();
        if ($asesor) {
            $scheme = \App\Models\AssessmentScheme::updateOrCreate(
                ['title' => 'Uji Kompetensi Kepemimpinan & Manajemen Madrasah'],
                [
                    'description' => 'Skema uji kompetensi untuk mengukur kemampuan manajerial, kewirausahaan, dan supervisi kepala madrasah sesuai standar LSP-MPI.',
                    'asesor_id' => $asesor->id,
                    'status' => 'published',
                    'duration_minutes' => 60
                ]
            );

            // Seed questions for this scheme
            $q1 = \App\Models\Question::updateOrCreate(
                ['scheme_id' => $scheme->id, 'question_text' => 'Manakah di bawah ini yang merupakan kompetensi utama kepala madrasah menurut standar nasional?'],
                [
                    'question_type' => 'multiple_choice',
                    'order' => 1,
                    'points' => 25
                ]
            );
            \App\Models\QuestionOption::updateOrCreate(
                ['question_id' => $q1->id, 'option_text' => 'Kompetensi Kuliner'],
                ['is_correct' => false, 'order' => 1]
            );
            \App\Models\QuestionOption::updateOrCreate(
                ['question_id' => $q1->id, 'option_text' => 'Kompetensi Manajerial, Kewirausahaan, dan Supervisi'],
                ['is_correct' => true, 'order' => 2]
            );
            \App\Models\QuestionOption::updateOrCreate(
                ['question_id' => $q1->id, 'option_text' => 'Kompetensi Teknik Otomotif'],
                ['is_correct' => false, 'order' => 3]
            );
            \App\Models\QuestionOption::updateOrCreate(
                ['question_id' => $q1->id, 'option_text' => 'Kompetensi Navigasi Pelayaran'],
                ['is_correct' => false, 'order' => 4]
            );

            $q2 = \App\Models\Question::updateOrCreate(
                ['scheme_id' => $scheme->id, 'question_text' => 'Apa kepanjangan dari LSP-MPI dalam konteks sertifikasi kepemimpinan madrasah?'],
                [
                    'question_type' => 'multiple_choice',
                    'order' => 2,
                    'points' => 25
                ]
            );
            \App\Models\QuestionOption::updateOrCreate(
                ['question_id' => $q2->id, 'option_text' => 'Lembaga Sertifikasi Profesi Manajemen Pendidikan Indonesia'],
                ['is_correct' => true, 'order' => 1]
            );
            \App\Models\QuestionOption::updateOrCreate(
                ['question_id' => $q2->id, 'option_text' => 'Lembaga Sertifikasi Pelatihan Mandiri Indonesia'],
                ['is_correct' => false, 'order' => 2]
            );
            \App\Models\QuestionOption::updateOrCreate(
                ['question_id' => $q2->id, 'option_text' => 'Layanan Sertifikasi Pendidikan Madrasah Internasional'],
                ['is_correct' => false, 'order' => 3]
            );
            \App\Models\QuestionOption::updateOrCreate(
                ['question_id' => $q2->id, 'option_text' => 'Lembaga Swadaya Pemuda Indonesia'],
                ['is_correct' => false, 'order' => 4]
            );

            $q3 = \App\Models\Question::updateOrCreate(
                ['scheme_id' => $scheme->id, 'question_text' => 'Jelaskan rencana strategis Anda dalam meningkatkan mutu kelulusan dan akreditasi madrasah di bawah kepemimpinan Anda!'],
                [
                    'question_type' => 'essay',
                    'order' => 3,
                    'points' => 50
                ]
            );
        }
    }
}
