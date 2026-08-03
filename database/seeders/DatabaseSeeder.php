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
                'certificate_number' => 'LPK-MI-2026-8899',
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
                ['title' => 'Uji Kompetensi Pemahaman Bahasa & Budaya Jepang Dasar'],
                [
                    'description' => 'Skema uji kompetensi untuk mengukur kemampuan komunikasi bahasa Jepang dasar (N5) dan pemahaman budaya kerja industri Jepang (5S/Kaizen).',
                    'asesor_id' => $asesor->id,
                    'status' => 'published',
                    'duration_minutes' => 60
                ]
            );

            // Seed questions for this scheme
            $q1 = \App\Models\Question::updateOrCreate(
                ['scheme_id' => $scheme->id, 'question_text' => 'Huruf alfabet Jepang mana yang digunakan secara khusus untuk menulis kata-kata serapan dari bahasa asing?'],
                [
                    'question_type' => 'multiple_choice',
                    'order' => 1,
                    'points' => 25
                ]
            );
            \App\Models\QuestionOption::updateOrCreate(
                ['question_id' => $q1->id, 'option_text' => 'Hiragana'],
                ['is_correct' => false, 'order' => 1]
            );
            \App\Models\QuestionOption::updateOrCreate(
                ['question_id' => $q1->id, 'option_text' => 'Katakana'],
                ['is_correct' => true, 'order' => 2]
            );
            \App\Models\QuestionOption::updateOrCreate(
                ['question_id' => $q1->id, 'option_text' => 'Kanji'],
                ['is_correct' => false, 'order' => 3]
            );
            \App\Models\QuestionOption::updateOrCreate(
                ['question_id' => $q1->id, 'option_text' => 'Romaji'],
                ['is_correct' => false, 'order' => 4]
            );

            $q2 = \App\Models\Question::updateOrCreate(
                ['scheme_id' => $scheme->id, 'question_text' => 'Manakah di bawah ini yang merupakan salah satu dari pilar konsep 5S dalam budaya disiplin kerja Jepang?'],
                [
                    'question_type' => 'multiple_choice',
                    'order' => 2,
                    'points' => 25
                ]
            );
            \App\Models\QuestionOption::updateOrCreate(
                ['question_id' => $q2->id, 'option_text' => 'Seiri (Ringkas)'],
                ['is_correct' => true, 'order' => 1]
            );
            \App\Models\QuestionOption::updateOrCreate(
                ['question_id' => $q2->id, 'option_text' => 'Shinsetsu (Ramah)'],
                ['is_correct' => false, 'order' => 2]
            );
            \App\Models\QuestionOption::updateOrCreate(
                ['question_id' => $q2->id, 'option_text' => 'Sensei (Guru)'],
                ['is_correct' => false, 'order' => 3]
            );
            \App\Models\QuestionOption::updateOrCreate(
                ['question_id' => $q2->id, 'option_text' => 'Suki (Suka)'],
                ['is_correct' => false, 'order' => 4]
            );

            $q3 = \App\Models\Question::updateOrCreate(
                ['scheme_id' => $scheme->id, 'question_text' => 'Jelaskan pemahaman Anda mengenai pentingnya tata krama sapaan (Aisatsu) dan kedisiplinan kerja saat berada di pabrik atau lingkungan kerja di Jepang!'],
                [
                    'question_type' => 'essay',
                    'order' => 3,
                    'points' => 50
                ]
            );
        }
    }
}
