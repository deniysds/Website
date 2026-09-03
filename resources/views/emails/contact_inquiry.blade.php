<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salinan Pesan Pertanyaan Baru IGNITE</title>
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
            max-width: 600px;
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
            padding: 24px 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            font-weight: 800;
        }
        .header p {
            margin: 4px 0 0 0;
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
        .card-info {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 18px;
            margin: 20px 0;
        }
        .meta-row {
            display: flex;
            margin-bottom: 8px;
            font-size: 13px;
        }
        .meta-label {
            width: 130px;
            font-weight: 700;
            color: #64748b;
        }
        .meta-val {
            font-weight: 600;
            color: #0f172a;
        }
        .message-box {
            background-color: #fff1f2;
            border-left: 4px solid #dc2626;
            padding: 16px;
            border-radius: 6px;
            margin: 20px 0;
            font-size: 13px;
            color: #881337;
            white-space: pre-line;
            line-height: 1.6;
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
                <p>Formulir Pertanyaan Publik</p>
                <h1>IGNITE PORTAL INQUIRY</h1>
            </div>

            <div class="content">
                <p>Halo Tim Admin IGNITE,</p>
                <p>Ada pesan dan pertanyaan baru yang masuk melalui formulir kontak portal publik dengan rincian sebagai berikut:</p>

                <div class="card-info">
                    <div class="meta-row">
                        <span class="meta-label">Nama Pengirim:</span>
                        <span class="meta-val">{{ $contact->full_name }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Nomor Telepon:</span>
                        <span class="meta-val">{{ $contact->phone }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Email:</span>
                        <span class="meta-val">{{ $contact->email }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Waktu Pengiriman:</span>
                        <span class="meta-val">{{ $contact->created_at->format('d M Y, H:i') }} WIB</span>
                    </div>
                </div>

                <strong>Isi Pesan / Pertanyaan:</strong>
                <div class="message-box">{{ $contact->message }}</div>

                <p style="font-size: 12px; color: #64748b;">
                    Anda dapat membalas langsung pengirim melalui alamat email di atas atau menindaklanjuti status pesan pada Dashboard Admin IGNITE.
                </p>
            </div>

            <div class="footer">
                <p>&copy; {{ date('Y') }} Yayasan Satriabudi Dharma Setia - IGNITE Publishing Platform</p>
            </div>
        </div>
    </div>
</body>
</html>
