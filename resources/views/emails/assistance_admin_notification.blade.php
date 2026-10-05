<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permohonan Bantuan Fasilitas Kesehatan Baru</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f8fafc;
            color: #334155;
            margin: 0;
            padding: 0;
        }
        .wrapper {
            width: 100%;
            background-color: #f8fafc;
            padding: 30px 15px;
        }
        .container {
            max-width: 620px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        .header {
            background-color: #dc2626;
            color: #ffffff;
            padding: 26px 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }
        .header p {
            margin: 6px 0 0 0;
            font-size: 11px;
            color: #fee2e2;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .content {
            padding: 30px;
            font-size: 14px;
            line-height: 1.6;
        }
        .ticket-badge {
            display: inline-block;
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            font-weight: 800;
            font-size: 14px;
            padding: 4px 12px;
            border-radius: 8px;
            margin-bottom: 12px;
            font-family: monospace;
        }
        .card-info {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 18px 20px;
            margin: 20px 0;
        }
        .meta-row {
            display: flex;
            margin-bottom: 8px;
            font-size: 13px;
        }
        .meta-label {
            width: 160px;
            font-weight: 700;
            color: #64748b;
        }
        .meta-val {
            font-weight: 600;
            color: #0f172a;
        }
        .box-highlight {
            background-color: #fff1f2;
            border-left: 4px solid #dc2626;
            padding: 16px;
            border-radius: 6px;
            margin: 20px 0;
            font-size: 13px;
            color: #881337;
            line-height: 1.6;
        }
        .btn {
            display: inline-block;
            background-color: #0f172a;
            color: #ffffff !important;
            padding: 12px 24px;
            font-size: 13px;
            font-weight: 700;
            border-radius: 10px;
            text-decoration: none;
            margin-top: 10px;
        }
        .footer {
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
            padding: 20px 30px;
            text-align: center;
            font-size: 11px;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <p>Notifikasi Permohonan Masuk</p>
                <h1>YAYASAN SATRIABUDI DHARMA SETIA</h1>
            </div>

            <div class="content">
                <span class="ticket-badge">{{ $assistanceRequest->ticket_code }}</span>
                <p>Halo Tim Verifikasi & Pengurus YSDS,</p>
                <p>Ada permohonan bantuan fasilitas kesehatan / alat diagnostik baru yang diajukan melalui portal resmi YSDS:</p>

                <div class="card-info">
                    <div class="meta-row">
                        <span class="meta-label">Nama Instansi / Faskes:</span>
                        <span class="meta-val">{{ $assistanceRequest->institution_name }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Jenis Instansi:</span>
                        <span class="meta-val">{{ $assistanceRequest->institution_type }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Kota / Provinsi:</span>
                        <span class="meta-val">{{ $assistanceRequest->city ?: '-' }}, {{ $assistanceRequest->province ?: '-' }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Penanggung Jawab (PIC):</span>
                        <span class="meta-val">{{ $assistanceRequest->pic_name }} ({{ $assistanceRequest->pic_position ?: 'PIC' }})</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Telepon / WhatsApp:</span>
                        <span class="meta-val">{{ $assistanceRequest->pic_phone }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Email PIC:</span>
                        <span class="meta-val">{{ $assistanceRequest->pic_email }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Jenis Bantuan:</span>
                        <span class="meta-val">{{ $assistanceRequest->assistance_type }}</span>
                    </div>
                </div>

                <strong>Alat / Fasilitas yang Dibutuhkan:</strong>
                <div class="box-highlight">
                    {{ $assistanceRequest->equipment_needed }}
                </div>

                @if($assistanceRequest->urgency_reason)
                    <strong>Alasan Kebutuhan / Urgensi Medis:</strong>
                    <div style="background-color: #f1f5f9; padding: 14px; border-radius: 8px; font-size: 13px; margin: 10px 0 20px 0; color: #334155;">
                        {{ $assistanceRequest->urgency_reason }}
                    </div>
                @endif

                <div style="text-align: center; margin: 24px 0 10px 0;">
                    <a href="{{ route('website.assistance.show', $assistanceRequest->id) }}" class="btn">
                        Buka & Tinjau Permohonan di Dashboard Admin &rarr;
                    </a>
                </div>
            </div>

            <div class="footer">
                <p>&copy; {{ date('Y') }} Yayasan Satriabudi Dharma Setia (YSDS) &bull; Sistem Informasi Bantuan Kesehatan</p>
            </div>
        </div>
    </div>
</body>
</html>
