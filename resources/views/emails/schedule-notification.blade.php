<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undangan Jadwal Pelatihan</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; background: #f1f5f9; color: #1e293b; }
        .wrapper { max-width: 600px; margin: 32px auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .header { background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 60%, #3b82f6 100%); padding: 40px 32px; text-align: center; }
        .header .logo-circle { width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-size: 28px; backdrop-filter: blur(8px); border: 2px solid rgba(255,255,255,0.3); }
        .header h1 { color: #ffffff; font-size: 22px; font-weight: 800; letter-spacing: -0.5px; }
        .header p { color: rgba(255,255,255,0.85); font-size: 13px; margin-top: 6px; }
        .body { padding: 32px; }
        .greeting { font-size: 15px; color: #374151; margin-bottom: 16px; line-height: 1.6; }
        .greeting strong { color: #1d4ed8; }
        .badge { display: inline-flex; align-items: center; gap: 6px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; padding: 4px 12px; border-radius: 999px; margin-bottom: 20px; }
        .badge-online { background: #dbeafe; color: #1d4ed8; border: 1px solid #bfdbfe; }
        .badge-offline { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
        .schedule-card { background: #f8faff; border: 1px solid #e0e7ff; border-radius: 12px; padding: 24px; margin: 20px 0; }
        .schedule-card h3 { font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #6b7280; margin-bottom: 16px; }
        .schedule-row { display: flex; align-items: flex-start; gap: 12px; padding: 10px 0; border-bottom: 1px solid #e0e7ff; }
        .schedule-row:last-child { border-bottom: none; }
        .schedule-icon { width: 36px; height: 36px; background: #eff6ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; }
        .schedule-label { font-size: 11px; font-weight: 700; text-transform: uppercase; color: #9ca3af; letter-spacing: 0.06em; }
        .schedule-value { font-size: 14px; font-weight: 600; color: #1e293b; margin-top: 2px; }
        .cta-section { text-align: center; margin: 28px 0 16px; }
        .btn-primary { display: inline-block; background: linear-gradient(135deg, #1d4ed8, #2563eb); color: #ffffff; text-decoration: none; font-size: 14px; font-weight: 700; padding: 14px 32px; border-radius: 10px; letter-spacing: 0.02em; }
        .btn-primary:hover { opacity: 0.9; }
        .btn-secondary { display: inline-block; background: #f1f5f9; color: #1e293b; text-decoration: none; font-size: 13px; font-weight: 600; padding: 10px 24px; border-radius: 8px; margin-top: 10px; border: 1px solid #e2e8f0; }
        .info-box { background: #fafafa; border-left: 3px solid #2563eb; border-radius: 0 8px 8px 0; padding: 14px 16px; margin: 20px 0; font-size: 13px; color: #374151; line-height: 1.6; }
        .footer { background: #f8faff; border-top: 1px solid #e0e7ff; padding: 24px 32px; text-align: center; }
        .footer p { font-size: 12px; color: #9ca3af; line-height: 1.7; }
        .footer strong { color: #1d4ed8; }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Header -->
        <div class="header">
            <div class="logo-circle">📅</div>
            <h1>Undangan Jadwal Pelatihan</h1>
            <p>{{ $siteName }} — Manajemen Pendidikan Indonesia</p>
        </div>

        <!-- Body -->
        <div class="body">
            <p class="greeting">
                Halo, <strong>{{ $participantName }}</strong>! 👋<br><br>
                Kami dengan bangga menyampaikan bahwa <strong>jadwal pelatihan Anda</strong> telah resmi dijadwalkan. Berikut adalah informasi lengkap mengenai sesi pelatihan yang akan datang:
            </p>

            @if ($schedule->type === 'online')
                <span class="badge badge-online">🌐 Pelatihan Online</span>
            @else
                <span class="badge badge-offline">📍 Pelatihan Offline / Tatap Muka</span>
            @endif

            <!-- Schedule Info Card -->
            <div class="schedule-card">
                <h3>Rincian Jadwal</h3>

                <div class="schedule-row">
                    <div class="schedule-icon">📚</div>
                    <div>
                        <div class="schedule-label">Program Pelatihan</div>
                        <div class="schedule-value">{{ $schedule->trainingProgram?->title ?? $schedule->topic }}</div>
                    </div>
                </div>

                <div class="schedule-row">
                    <div class="schedule-icon">📝</div>
                    <div>
                        <div class="schedule-label">Topik / Materi</div>
                        <div class="schedule-value">{{ $schedule->topic }}</div>
                    </div>
                </div>

                <div class="schedule-row">
                    <div class="schedule-icon">🗓️</div>
                    <div>
                        <div class="schedule-label">Tanggal & Waktu</div>
                        <div class="schedule-value">
                            {{ \Carbon\Carbon::parse($schedule->scheduled_at)->translatedFormat('l, d F Y') }}<br>
                            <span style="color:#2563eb">{{ \Carbon\Carbon::parse($schedule->scheduled_at)->format('H:i') }} WIB</span>
                        </div>
                    </div>
                </div>

                @if ($schedule->type === 'online')
                <div class="schedule-row">
                    <div class="schedule-icon">💻</div>
                    <div>
                        <div class="schedule-label">Platform / Media</div>
                        <div class="schedule-value">{{ $schedule->location }}</div>
                    </div>
                </div>
                @else
                <div class="schedule-row">
                    <div class="schedule-icon">🏫</div>
                    <div>
                        <div class="schedule-label">Lokasi</div>
                        <div class="schedule-value">{{ $schedule->location }}</div>
                    </div>
                </div>
                @endif
            </div>

            <!-- CTA Button -->
            @if ($schedule->type === 'online' && $schedule->online_link)
                <div class="cta-section">
                    <p style="font-size:13px;color:#6b7280;margin-bottom:12px;">Klik tombol di bawah untuk bergabung ke sesi pelatihan online:</p>
                    <a href="{{ $schedule->online_link }}" class="btn-primary">🔗 Bergabung ke Sesi Online</a>
                    <br>
                    <p style="font-size:11px;color:#9ca3af;margin-top:10px;">Link: {{ $schedule->online_link }}</p>
                </div>
            @elseif ($schedule->type === 'offline' && $schedule->share_location)
                <div class="cta-section">
                    <p style="font-size:13px;color:#6b7280;margin-bottom:12px;">Klik tombol di bawah untuk melihat lokasi pelatihan di peta:</p>
                    <a href="{{ $schedule->share_location }}" class="btn-primary">📍 Lihat Lokasi di Maps</a>
                    <br>
                    <p style="font-size:11px;color:#9ca3af;margin-top:10px;">Maps: {{ $schedule->share_location }}</p>
                </div>
            @endif

            <div class="info-box">
                💡 <strong>Harap hadir tepat waktu.</strong> Apabila ada kendala atau pertanyaan, jangan ragu untuk menghubungi panitia pelaksana. Persiapkan diri Anda dengan baik untuk mendapatkan hasil pelatihan yang maksimal.
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>
                Email ini dikirim otomatis oleh sistem <strong>{{ $siteName }}</strong>.<br>
                Jika Anda merasa menerima email ini karena kesalahan, abaikan saja.<br>
                © {{ date('Y') }} {{ $siteName }} — Lembaga Pendidikan &amp; Pelatihan Kerja
            </p>
        </div>
    </div>
</body>
</html>
