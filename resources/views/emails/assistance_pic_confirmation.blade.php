<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tanda Terima Permohonan Bantuan Fasilitas Kesehatan YSDS</title>
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
        .ticket-box {
            background: linear-gradient(135deg, #fef2f2, #fff1f2);
            border: 2px dashed #f87171;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
        }
        .ticket-title {
            font-size: 11px;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 1px;
            color: #991b1b;
            margin-bottom: 6px;
        }
        .ticket-code {
            font-size: 24px;
            font-weight: 900;
            letter-spacing: 2px;
            color: #b91c1c;
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
        .steps-box {
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 10px;
            padding: 16px;
            margin: 20px 0;
            font-size: 12px;
            color: #166534;
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
                <p>Tanda Terima Resmi Permohonan Bantuan</p>
                <h1>YAYASAN SATRIABUDI DHARMA SETIA</h1>
            </div>

            <div class="content">
                <p>Kepada Yth. <strong>{{ $assistanceRequest->pic_name }}</strong>,</p>
                <p>Terima kasih telah mengajukan permohonan bantuan fasilitas kesehatan/alat medis untuk <strong>{{ $assistanceRequest->institution_name }}</strong> ke Yayasan Satriabudi Dharma Setia (YSDS).</p>

                <p>Permohonan Anda telah berhasil terdaftar dalam sistem informasi kami dengan nomor registrasi unik berikut:</p>

                <div class="ticket-box">
                    <div class="ticket-title">Nomor Registrasi / Kode Tiket Permohonan</div>
                    <div class="ticket-code">{{ $assistanceRequest->ticket_code }}</div>
                    <div style="font-size: 11px; color: #7f1d1d; margin-top: 6px;">
                        Simpan nomor registrasi ini untuk melacak perkembangan status permohonan Anda.
                    </div>
                </div>

                <div class="card-info">
                    <div class="meta-row">
                        <span class="meta-label">Nama Instansi:</span>
                        <span class="meta-val">{{ $assistanceRequest->institution_name }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Jenis Instansi:</span>
                        <span class="meta-val">{{ $assistanceRequest->institution_type }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Wilayah:</span>
                        <span class="meta-val">{{ $assistanceRequest->city ?: '-' }}, {{ $assistanceRequest->province ?: '-' }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Jenis Bantuan:</span>
                        <span class="meta-val">{{ $assistanceRequest->assistance_type }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Status Awal:</span>
                        <span class="meta-val" style="color: #d97706; font-weight: 800;">Menunggu Verifikasi (Pending)</span>
                    </div>
                </div>

                <div class="steps-box">
                    <strong>Tahapan Selanjutnya:</strong>
                    <ol style="margin: 8px 0 0 0; padding-left: 18px; line-height: 1.6;">
                        <li><strong>Verifikasi Dokumen & Kebutuhan Medis:</strong> Tim medik YSDS akan menelaah profil faskes dan rincian alkes yang dibutuhkan.</li>
                        <li><strong>Konfirmasi PIC:</strong> Tim kami dapat menghubungi Anda via telepon/WhatsApp untuk validasi teknis lanjutan.</li>
                        <li><strong>Persetujuan & Berita Acara (BAST):</strong> Instansi yang disetujui akan dihubungi untuk persiapan alokasi dan penyerahan resmi.</li>
                    </ol>
                </div>

                <div style="text-align: center; margin: 24px 0 10px 0;">
                    <a href="{{ route('website.assistance.track', ['ticket' => $assistanceRequest->ticket_code, 'email' => $assistanceRequest->pic_email]) }}" class="btn">
                        Lacak Status Permohonan Online &rarr;
                    </a>
                </div>
            </div>

            <div class="footer">
                <p>Email ini dikirim secara otomatis oleh sistem portal resmi YSDS.<br>
                Jika Anda memiliki pertanyaan, hubungi kami melalui <a href="mailto:admin@dharma.or.id" style="color: #dc2626;">admin@dharma.or.id</a>.</p>
                <p style="margin-top: 8px;">&copy; {{ date('Y') }} Yayasan Satriabudi Dharma Setia &bull; dharma.or.id</p>
            </div>
        </div>
    </div>
</body>
</html>
