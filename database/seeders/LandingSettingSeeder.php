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
            'site_title' => 'LPK Manajemen Pendidikan Indonesia',
            'hero_title' => 'LPK Lembaga Pelatihan Kerja Manajemen Pendidikan Indonesia',
            'hero_subtitle' => 'Membangun Kompetensi, Menguatkan Tata Kelola, Mewujudkan Pendidikan Indonesia yang Profesional, Berintegritas, dan Berdaya Saing Global.',
            'hero_image' => null,
            'site_logo' => 'landing/logo/logo.png',
            
            'why_choose_title' => 'Mengapa Memilih LPK Manajemen Pendidikan Indonesia?',
            'stat_count' => 4,
            'stat_1_val' => '100%',
            'stat_1_lbl' => 'Kurikulum SKKNI',
            'stat_2_val' => '20+',
            'stat_2_lbl' => 'Madrasah & Lembaga Didampingi',
            'stat_3_val' => '3,000+',
            'stat_3_lbl' => 'Alumni Kompeten',
            'stat_4_val' => '24/7',
            'stat_4_lbl' => 'Layanan Konsultasi',
            
            'step_count' => 3,
            'step_1_title' => 'Pendaftaran online',
            'step_2_title' => 'Pelatihan & Bimbingan',
            'step_3_title' => 'Sertifikasi LSP',
            
            'feature_count' => 4,
            'feature_1_title' => 'Kurikulum Aplikatif & Terstandar',
            'feature_1_desc' => 'Silabus pelatihan disusun berdasarkan kebutuhan nyata di lapangan dan diselaraskan dengan Standar Kompetensi Kerja Nasional Indonesia (SKKNI) bidang manajemen pendidikan.',
            'feature_2_title' => 'Instruktur Ahli & Bersertifikat',
            'feature_2_desc' => 'Didukung oleh akademisi senior (guru besar/doktor), praktisi manajemen pendidikan berpengalaman, serta asesor kompetensi berlisensi resmi.',
            'feature_3_title' => 'Fasilitas Modern & Kondusif',
            'feature_3_desc' => 'Ruang kelas ber-AC, laboratorium komputer, akses internet cepat, perpustakaan referensi, serta platform e-learning (LMS) yang mudah diakses.',
            'feature_4_title' => 'Jaringan & Mitra Luas',
            'feature_4_desc' => 'Memiliki kemitraan yang kuat dengan berbagai asosiasi profesi pendidikan, dinas pendidikan daerah, kementerian terkait, dan jejaring alumni di seluruh Indonesia.',
            
            'tentang_profil_1' => 'Lembaga Pelatihan Kerja Manajemen Pendidikan Indonesia (LPK MPI) merupakan Lembaga Pelatihan Kerja Swasta yang secara hukum didirikan pada tanggal 2 Juli 2026 berdasarkan Akta Pendirian Nomor 01 oleh Notaris Dr. Adderi Yusdi, S.H., M.Kn. dengan Pengesahan Kemenkumham AHU-0053283.AH.01.01 Tahun 2026.',
            'tentang_profil_2' => 'LPK MPI berkomitmen untuk menyelenggarakan pelatihan kerja, pengembangan kompetensi, sertifikasi profesi, konsultansi, pendampingan, penjaminan mutu, dan inovasi manajemen pendidikan bagi para pengelola yayasan, kepala sekolah/madrasah, dosen, praktisi, dan tenaga kependidikan demi mewujudkan tata kelola pendidikan Indonesia yang profesional, berintegritas, dan berdaya saing global.',
            'tentang_visi' => 'Menjadi Lembaga Pelatihan Kerja terdepan dan terpercaya di Indonesia dalam membangun sumber daya manusia yang kompeten, berintegritas, dan berdaya saing tinggi di bidang manajemen pendidikan untuk mewujudkan pendidikan nasional yang bermutu dan profesional.',
            'tentang_misi' => "1. Menyelenggarakan program pelatihan kerja bidang manajemen pendidikan yang berbasis pada standar kompetensi kerja nasional dan internasional.\n2. Memfasilitasi pengembangan kompetensi kepala sekolah, pengawas, dosen, praktisi, dan tenaga kependidikan agar memiliki kapasitas kepemimpinan dan pengelolaan yang unggul.\n3. Memperkuat tata kelola, transparansi, akuntabilitas, dan penjaminan mutu lembaga pendidikan melalui pendampingan dan konsultansi yang profesional.\n4. Mengembangkan kemitraan strategis dengan pemerintah, dunia usaha/dunia industri (DUDI), perguruan tinggi, dan lembaga sertifikasi profesi di tingkat nasional maupun global.\n5. Menghasilkan inovasi program pelatihan dan pengelolaan pendidikan yang relevan dengan perkembangan zaman dan teknologi.",
            
            'org_director_dewan' => 'Prof. Dr. H. Badrudin, M.Ag.',
            'org_director_lpk' => 'Dr. H. Cece Hidayat, M.Si.',
            
            'faq_count' => 4,
            'faq_1_q' => 'Bagaimana legalitas LPK MPI?',
            'faq_1_a' => 'LPK MPI terdaftar secara resmi sebagai Lembaga Pelatihan Kerja Swasta berdasarkan Akta Pendirian Nomor 01 tanggal 2 Juli 2026, Notaris Dr. Adderi Yusdi, S.H., M.Kn., Pengesahan Kemenkumham AHU-0053283.AH.01.01 Tahun 2026, NPWP 1000.0000.1032.0458, dengan KBLI 85579 (Pendidikan Swasta Lainnya / Pelatihan Kerja Manajemen).',
            'faq_2_q' => 'Apa saja program unggulan yang ditawarkan?',
            'faq_2_a' => 'Kami menawarkan Pelatihan Kompetensi Manajemen Pendidikan, Bimbingan & Pendampingan Sertifikasi Profesi, Konsultansi & Penjaminan Mutu Sekolah, serta Pelatihan Teknologi Pembelajaran & Administrasi.',
            'faq_3_q' => 'Bagaimana metode pelatihan yang digunakan?',
            'faq_3_a' => 'Pelatihan kami menggunakan metode Interactive Learning, Hands-on Practice (simulasi praktis dokumen mutu), Mentoring & Feedback dari instruktur berpengalaman, serta Uji Kompetensi bekerja sama dengan Lembaga Sertifikasi Profesi (LSP).',
            'faq_4_q' => 'Siapa saja pimpinan LPK MPI?',
            'faq_4_a' => 'LPK MPI dipimpin oleh Komisaris Utama Prof. Dr. H. Badrudin, M.Ag. dan Direktur Utama Dr. H. Cece Hidayat, M.Si.',
        ];

        foreach ($settings as $key => $value) {
            LandingSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}

