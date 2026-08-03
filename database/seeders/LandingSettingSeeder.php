<?php

namespace Database\Seeders;

use App\Models\LandingSetting;
use Illuminate\Database\Seeder;

class LandingSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'site_title' => 'LPK Manajemen Pendidikan Islam',
            'hero_title' => 'LPK Manajemen Pendidikan Islam – Lembaga Pelatihan Kerja',
            'hero_subtitle' => 'Lembaga Pelatihan Kerja Manajemen Pendidikan Islam yang berkomitmen mengembangkan SDM berkualitas melalui program pelatihan kerja yang unggul.',
            'hero_image' => null,
            
            'why_choose_title' => 'Mengapa Memilih LPK Manajemen Pendidikan Islam?',
            'stat_count' => 3,
            'stat_1_val' => '100%',
            'stat_1_lbl' => 'Pelatihan & Uji Kompetensi',
            'stat_2_val' => '4',
            'stat_2_lbl' => 'Program Pelatihan',
            'stat_3_val' => '50+',
            'stat_3_lbl' => 'Instruktur Berpengalaman',
            
            'step_count' => 3,
            'step_1_title' => 'PILIH PROGRAM',
            'step_2_title' => 'ISI BIODATA & PERSYARATAN',
            'step_3_title' => 'IKUT PELATIHAN',
            
            'feature_count' => 3,
            'feature_1_title' => 'Terdaftar Resmi',
            'feature_1_desc' => 'Lembaga Pelatihan Kerja (LPK) resmi terdaftar untuk menyelenggarakan pelatihan kerja.',
            'feature_2_title' => 'Standar Nasional Berwawasan Global',
            'feature_2_desc' => 'Menggunakan Standar Kompetensi Kerja Nasional Indonesia (SKKNI) Berwawasan Global.',
            'feature_3_title' => 'Instruktur Berpengalaman',
            'feature_3_desc' => 'Didukung oleh instruktur profesional dengan pengalaman puluhan tahun di bidangnya.',
        ];

        foreach ($settings as $key => $value) {
            LandingSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}
