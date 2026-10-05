<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembaruan Status Permohonan Bantuan Fasilitas Kesehatan YSDS</title>
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
            background-color: #0f172a;
            color: #ffffff;
            padding: 26px 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 19px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }
        .header p {
            margin: 6px 0 0 0;
            font-size: 11px;
            color: #94a3b8;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .content {
            padding: 30px;
            font-size: 14px;
            line-height: 1.6;
        }
        .status-card {
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
        }
        .status-badge {
            display: inline-block;
            font-size: 13px;
            font-weight: 800;
            padding: 6px 16px;
            border-radius: 9999px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
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
        .notes-box {
            background-color: #f1f5f9;
            border-left: 4px solid #475569;
            border-radius: 6px;
            padding: 16px;
            margin: 20px 0;
            font-size: 13px;
            color: #1e293b;
        }
        .btn {
            display: inline-block;
            background-color: #dc2626;
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
                <p>Informasi Perkembangan Permohonan Bantuan</p>
                <h1>YAYASAN SATRIABUDI DHARMA SETIA</h1>
            </div>

            <div class="content">
                <p>Kepada Yth. <strong>{{ $assistanceRequest->pic_name }}</strong>,</p>
                <p>Tim verifikasi Yayasan Satriabudi Dharma Setia (YSDS) telah memperbarui status permohonan bantuan kesehatan untuk <strong>{{ $assistanceRequest->institution_name }}</strong> (Nomor Tiket: <strong>{{ $assistanceRequest->ticket_code }}</strong>).</p>

                <div class="status-card" style="
                    @if($assistanceRequest->status === 'approved')
                        background-color: #f0fdf4; border: 1px solid #bbf7d0;
                    @elseif($assistanceRequest->status === 'distributed')
                        background-color: #faf5ff; border: 1px solid #e9d5ff;
                    @elseif($assistanceRequest->status === 'rejected')
                        background-color: #fef2f2; border: 1px solid #fecaca;
                    @else
                        background-color: #eff6ff; border: 1px solid #bfdbfe;
                    @endif
                ">
                    <div style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #64748b; margin-bottom: 6px;">Status Terkini</div>
                    <span class="status-badge" style="
                        @if($assistanceRequest->status === 'approved')
                            background-color: #16a34a; color: #ffffff;
                        @elseif($assistanceRequest->status === 'distributed')
                            background-color: #7e22ce; color: #ffffff;
                        @elseif($assistanceRequest->status === 'rejected')
                            background-color: #dc2626; color: #ffffff;
                        @else
                            background-color: #2563eb; color: #ffffff;
                        @endif
                    ">
                        {{ $assistanceRequest->status_label }}
                    </span>
                </div>

                @if($assistanceRequest->admin_notes)
                    <strong>Catatan Tim Verifikasi / Tindak Lanjut:</strong>
                    <div class="notes-box">
                        {{ $assistanceRequest->admin_notes }}
                    </div>
                @endif

                <div class="card-info">
                    <div class="meta-row">
                        <span class="meta-label">Nomor Tiket:</span>
                        <span class="meta-val" style="font-family: monospace; font-weight: 800; color: #dc2626;">{{ $assistanceRequest->ticket_code }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Nama Instansi:</span>
                        <span class="meta-val">{{ $assistanceRequest->institution_name }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Alat yang Dimohon:</span>
                        <span class="meta-val">{{ $assistanceRequest->assistance_type }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Waktu Pembaruan:</span>
                        <span class="meta-val">{{ now()->format('d M Y, H:i') }} WIB</span>
                    </div>
                </div>

                <div style="text-align: center; margin: 24px 0 10px 0;">
                    <a href="{{ route('website.assistance.track', ['ticket' => $assistanceRequest->ticket_code, 'email' => $assistanceRequest->pic_email]) }}" class="btn">
                        Lihat Status & Riwayat Lengkap &rarr;
                    </a>
                </div>
            </div>

            <div class="footer">
                <p>Email ini dikirim secara otomatis oleh sistem portal resmi YSDS.<br>
                Yayasan Satriabudi Dharma Setia &bull; <a href="mailto:admin@dharma.or.id" style="color: #dc2626;">admin@dharma.or.id</a></p>
                <p style="margin-top: 8px;">&copy; {{ date('Y') }} Yayasan Satriabudi Dharma Setia &bull; dharma.or.id</p>
            </div>
        </div>
    </div>
</body>
</html>
