<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Penerimaan Donasi - Yayasan Satriabudi Dharma Setia</title>
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
        .code-box {
            background: linear-gradient(135deg, #f0fdf4, #ecfdf5);
            border: 2px dashed #34d399;
            border-radius: 12px;
            padding: 18px;
            text-align: center;
            margin: 20px 0;
        }
        .code-title {
            font-size: 11px;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 1px;
            color: #065f46;
            margin-bottom: 4px;
        }
        .code-val {
            font-size: 22px;
            font-weight: 900;
            letter-spacing: 2px;
            color: #047857;
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
                <p>Tanda Terima Konfirmasi Donasi</p>
                <h1>YAYASAN SATRIABUDI DHARMA SETIA</h1>
            </div>

            <div class="content">
                <p>Kepada Yth. <strong>{{ $donation->display_name }}</strong>,</p>
                <p>Terima kasih atas kepedulian dan donasi yang Anda salurkan melalui Yayasan Satriabudi Dharma Setia (YSDS). Dukungan Anda sangat berarti bagi keberlanjutan program kesehatan diagnostik, beasiswa pendidikan, dan literasi daerah 3T di Indonesia.</p>

                <div class="code-box">
                    <div class="code-title">Nomor Registrasi Donasi</div>
                    <div class="code-val">{{ $donation->donation_code }}</div>
                    <div style="font-size: 11px; color: #065f46; margin-top: 4px;">
                        Jumlah: <strong>{{ $donation->formatted_amount }}</strong>
                    </div>
                </div>

                <div class="card-info">
                    <div class="meta-row">
                        <span class="meta-label">Program Sasaran:</span>
                        <span class="meta-val">{{ $donation->program_target_label }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Bank Penerima:</span>
                        <span class="meta-val">{{ $donation->bank_name }} a.n. Yayasan Satriabudi Dharma Setia</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Tanggal Transfer:</span>
                        <span class="meta-val">{{ $donation->transfer_date ? $donation->transfer_date->format('d M Y') : now()->format('d M Y') }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Status Verifikasi:</span>
                        <span class="meta-val" style="color: #d97706; font-weight: 800;">Menunggu Verifikasi Administrasi</span>
                    </div>
                </div>

                <p style="font-size: 13px; color: #64748b; line-height: 1.6;">
                    Tim administrasi YSDS akan melakukan rekonsiliasi mutasi bank dan memverifikasi tanda terima donasi Anda. Seluruh penyaluran donasi dilaporkan secara berkala dalam transparansi publik yayasan.
                </p>
            </div>

            <div class="footer">
                <p>Surel ini dikirimkan secara otomatis oleh sistem portal resmi YSDS.<br>
                Kontak: <a href="mailto:admin@dharma.or.id" style="color: #dc2626;">admin@dharma.or.id</a> &bull; Telp: 021-5020-8805</p>
                <p style="margin-top: 8px;">&copy; {{ date('Y') }} Yayasan Satriabudi Dharma Setia &bull; dharma.or.id</p>
            </div>
        </div>
    </div>
</body>
</html>
