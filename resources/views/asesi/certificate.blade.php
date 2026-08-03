<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Digital — {{ $enrollment->name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;700;800&family=Montserrat:wght@400;500;600;700&family=Playfair+Display:ital,wght@1,600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #e2e8f0;
            font-family: 'Montserrat', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .certificate-wrapper {
            background-color: #ffffff;
            width: 1000px;
            height: 700px;
            padding: 30px;
            box-sizing: border-box;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            position: relative;
        }

        .certificate-border {
            border: 20px solid #1e293b; /* slate-800 */
            height: 100%;
            width: 100%;
            box-sizing: border-box;
            position: relative;
            padding: 40px;
            border-image: linear-gradient(to bottom right, #b45309, #f59e0b, #b45309) 20; /* Gold gradient */
        }

        .inner-border {
            border: 2px solid #b45309; /* Gold border */
            height: 100%;
            width: 100%;
            box-sizing: border-box;
            padding: 30px;
            text-align: center;
            background: radial-gradient(circle, rgba(255,255,255,1) 60%, rgba(254,243,199,0.3) 100%);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .header .org-title {
            font-family: 'Cinzel', serif;
            font-size: 28px;
            font-weight: 800;
            color: #1e293b;
            letter-spacing: 2px;
            margin: 0;
        }

        .header .subtitle {
            font-size: 11px;
            color: #d97706; /* amber-600 */
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 3px;
            margin-top: 5px;
            margin-bottom: 20px;
        }

        .cert-title {
            font-family: 'Cinzel', serif;
            font-size: 40px;
            color: #d97706;
            margin: 0;
            font-weight: 700;
            letter-spacing: 4px;
        }

        .cert-to {
            font-size: 14px;
            text-transform: uppercase;
            color: #64748b;
            letter-spacing: 2px;
            margin: 15px 0 5px 0;
        }

        .student-name {
            font-family: 'Playfair Display', serif;
            font-size: 38px;
            font-style: italic;
            color: #1e293b;
            border-bottom: 2px solid #cbd5e1;
            display: inline-block;
            padding-bottom: 5px;
            margin: 5px 0;
            min-width: 60%;
        }

        .cert-text {
            font-size: 14px;
            color: #475569;
            line-height: 1.6;
            max-width: 80%;
            margin: 10px auto;
        }

        .program-title {
            font-weight: 700;
            color: #1e293b;
        }

        .footer-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 30px;
            padding: 0 40px;
        }

        .signature-block {
            text-align: center;
            width: 200px;
        }

        .signature-line {
            border-top: 1px solid #94a3b8;
            margin-top: 50px;
            padding-top: 5px;
            font-size: 12px;
            font-weight: 600;
            color: #475569;
        }

        .cert-id {
            font-family: 'Montserrat', sans-serif;
            font-size: 10px;
            color: #94a3b8;
            font-weight: 500;
        }

        .btn-print {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #d97706;
            color: #ffffff;
            border: none;
            padding: 12px 24px;
            font-family: 'Montserrat', sans-serif;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.2s;
            border-radius: 4px;
        }

        .btn-print:hover {
            background-color: #b45309;
        }

        @media print {
            body {
                background-color: #ffffff;
            }
            .btn-print {
                display: none;
            }
            .certificate-wrapper {
                box-shadow: none;
                width: 100%;
                height: 100vh;
                padding: 0;
            }
        }
    </style>
</head>
<body>

    <div class="certificate-wrapper">
        <div class="certificate-border">
            <div class="inner-border">
                <div class="header">
                    <h1 class="org-title">LPK MULTI PRIMA INDONESIA</h1>
                    <div class="subtitle">Lembaga Pelatihan Kerja Terakreditasi</div>
                </div>

                <div>
                    <h2 class="cert-title">SERTIFIKAT KELULUSAN</h2>
                    <div class="cert-to">Diberikan kepada</div>
                    <div class="student-name">{{ $enrollment->name }}</div>
                    <p class="cert-text">
                        telah dinyatakan <span style="font-weight:700; color:#10b981;">LULUS / KOMPETEN</span> pada Program Pelatihan Kerja:<br>
                        <span class="program-title">"{{ $enrollment->trainingProgram?->title }}"</span><br>
                        yang diselenggarakan oleh LPK Multi Prima Indonesia dengan hasil evaluasi teori & praktik yang memenuhi standar kelulusan lembaga.
                    </p>
                </div>

                <div class="footer-section">
                    <div class="signature-block">
                        <div style="font-size: 11px; color: #64748b;">No. Sertifikat</div>
                        <div style="font-size: 12px; font-weight: 700; color: #1e293b; font-family: monospace; margin-top: 2px;">{{ $enrollment->certificate_number }}</div>
                    </div>

                    <div style="text-align: center;">
                        <!-- Golden Star/Seal watermark mockup -->
                        <div style="font-size: 40px; color: #fbbf24; opacity: 0.85;">★</div>
                        <div class="cert-id">Verifikasi Valid: LPK-MPI-ONLINE</div>
                    </div>

                    <div class="signature-block">
                        <div style="font-size: 11px; color: #64748b;">Yogyakarta, {{ $enrollment->certificate_date?->format('d M Y') ?? now()->format('d M Y') }}</div>
                        <div class="signature-line">
                            <strong>Direktur LPK-MPI</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button onclick="window.print()" class="btn-print">Cetak Sertifikat</button>

</body>
</html>
