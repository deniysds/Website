<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lembar Disposisi Permohonan Bantuan - {{ $assistanceRequest->ticket_code }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1e293b;
            background-color: #f8fafc;
        }
        @media print {
            body {
                background-color: #ffffff;
                color: #000000;
            }
            .no-print {
                display: none !important;
            }
            .print-container {
                box-shadow: none !important;
                border: none !important;
                margin: 0 !important;
                padding: 0 !important;
                max-width: 100% !important;
            }
            @page {
                size: A4 portrait;
                margin: 1.5cm;
            }
        }
    </style>
</head>
<body class="py-8 px-4 sm:px-6">

    <!-- Floating Action Bar (Hidden during print) -->
    <div class="no-print max-w-4xl mx-auto mb-6 flex items-center justify-between bg-white border border-slate-200 p-4 rounded-2xl shadow-sm">
        <div class="flex items-center gap-3">
            <a href="{{ route('website.assistance.show', $assistanceRequest->id) }}" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition">
                &larr; Kembali ke Rincian
            </a>
            <span class="text-slate-300">|</span>
            <span class="text-xs font-bold text-slate-700">Lembar Disposisi &amp; Telaah Medis</span>
        </div>
        <div class="flex items-center gap-2">
            <button onclick="window.print()" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold text-white bg-red-600 hover:bg-red-700 shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak / Simpan PDF
            </button>
        </div>
    </div>

    <!-- Official Document Sheet -->
    <div class="print-container max-w-4xl mx-auto bg-white border border-slate-200 p-8 sm:p-12 rounded-3xl shadow-md space-y-6">

        <!-- Kop Surat YSDS -->
        <div class="border-b-2 border-slate-900 pb-5 flex items-start justify-between gap-6">
            <div class="space-y-1">
                <div class="text-xs font-extrabold tracking-widest uppercase text-red-600">YAYASAN SATRIABUDI DHARMA SETIA</div>
                <h1 class="text-lg sm:text-xl font-black text-slate-900 tracking-tight">LEMBAR DISPOSISI &amp; TELAAH KELAYAKAN BANTUAN</h1>
                <p class="text-xs text-slate-600 font-medium">Fasilitas Kesehatan, Rumah Sakit &amp; Laboratorium Diagnostik Daerah</p>
            </div>
            <div class="text-right text-xs font-mono space-y-1 shrink-0">
                <div class="font-bold text-slate-900 bg-slate-100 px-3 py-1 rounded-lg border border-slate-200">{{ $assistanceRequest->ticket_code }}</div>
                <div class="text-slate-500">Tanggal: {{ $assistanceRequest->created_at->format('d/m/Y H:i') }} WIB</div>
                <div class="text-slate-500">Status: <span class="font-bold uppercase text-slate-800">{{ $assistanceRequest->status_label }}</span></div>
            </div>
        </div>

        <!-- 1. Data Pemohon / Instansi -->
        <div class="space-y-2">
            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-900 border-b border-slate-200 pb-1">
                I. Data Instansi &amp; Penanggung Jawab (PIC)
            </h2>
            <table class="w-full text-xs text-slate-800 border-collapse">
                <tbody>
                    <tr class="border-b border-slate-100">
                        <td class="py-1.5 font-bold w-44 text-slate-500">Nama Instansi / Faskes</td>
                        <td class="py-1.5 font-semibold text-slate-900">: {{ $assistanceRequest->institution_name }}</td>
                    </tr>
                    <tr class="border-b border-slate-100">
                        <td class="py-1.5 font-bold text-slate-500">Jenis Instansi</td>
                        <td class="py-1.5">: {{ $assistanceRequest->institution_type }}</td>
                    </tr>
                    <tr class="border-b border-slate-100">
                        <td class="py-1.5 font-bold text-slate-500">Wilayah / Lokasi</td>
                        <td class="py-1.5">: {{ $assistanceRequest->city ?: '-' }}, {{ $assistanceRequest->province ?: '-' }}</td>
                    </tr>
                    <tr class="border-b border-slate-100">
                        <td class="py-1.5 font-bold text-slate-500">Alamat Lengkap</td>
                        <td class="py-1.5">: {{ $assistanceRequest->address ?: '-' }}</td>
                    </tr>
                    <tr class="border-b border-slate-100">
                        <td class="py-1.5 font-bold text-slate-500">Penanggung Jawab (PIC)</td>
                        <td class="py-1.5 font-semibold">: {{ $assistanceRequest->pic_name }} ({{ $assistanceRequest->pic_position ?: 'PIC' }})</td>
                    </tr>
                    <tr class="border-b border-slate-100">
                        <td class="py-1.5 font-bold text-slate-500">Kontak Telepon / WhatsApp</td>
                        <td class="py-1.5">: {{ $assistanceRequest->pic_phone }}</td>
                    </tr>
                    <tr>
                        <td class="py-1.5 font-bold text-slate-500">Alamat Email PIC</td>
                        <td class="py-1.5">: {{ $assistanceRequest->pic_email }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- 2. Rincian Kebutuhan & Urgensi -->
        <div class="space-y-2">
            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-900 border-b border-slate-200 pb-1">
                II. Rincian Bantuan &amp; Urgensi Klinis
            </h2>
            <div class="space-y-2 text-xs">
                <div>
                    <span class="font-bold text-slate-500 block mb-0.5">Kategori Bantuan:</span>
                    <span class="font-semibold text-slate-900">{{ $assistanceRequest->assistance_type }}</span>
                </div>
                <div>
                    <span class="font-bold text-slate-500 block mb-0.5">Alat / Reagen yang Dibutuhkan:</span>
                    <div class="p-3 rounded-lg bg-slate-50 border border-slate-200 text-slate-800 whitespace-pre-line leading-relaxed font-mono text-[11px]">
                        {{ $assistanceRequest->equipment_needed }}
                    </div>
                </div>
                @if($assistanceRequest->urgency_reason)
                <div>
                    <span class="font-bold text-slate-500 block mb-0.5">Alasan Kebutuhan / Urgensi Pelayanan Medis:</span>
                    <div class="p-3 rounded-lg bg-slate-50 border border-slate-200 text-slate-800 whitespace-pre-line leading-relaxed text-[11px]">
                        {{ $assistanceRequest->urgency_reason }}
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- 3. Catatan Telaah Tim Verifikasi YSDS -->
        <div class="space-y-2">
            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-900 border-b border-slate-200 pb-1">
                III. Hasil Telaah Tim Verifikasi Medik YSDS
            </h2>
            <div class="p-3 rounded-lg bg-slate-50 border border-slate-200 text-xs min-h-[70px] space-y-1">
                <div class="flex items-center justify-between text-[11px] text-slate-500 font-bold border-b border-slate-200 pb-1">
                    <span>Tanggal Telaah: {{ $assistanceRequest->reviewed_at ? $assistanceRequest->reviewed_at->format('d/m/Y H:i') : '-' }}</span>
                    <span>Status Verifikasi: {{ $assistanceRequest->status_label }}</span>
                </div>
                <p class="text-slate-800 leading-relaxed pt-1">
                    {{ $assistanceRequest->admin_notes ?: 'Belum ada catatan internal tambahan.' }}
                </p>
            </div>
        </div>

        <!-- 4. Kolom Disposisi Dewan Pengurus Yayasan -->
        <div class="space-y-2">
            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-900 border-b border-slate-200 pb-1">
                IV. Lembar Disposisi Dewan Pengurus Yayasan
            </h2>
            <div class="border border-slate-300 rounded-lg p-3 text-xs space-y-3">
                <div class="flex items-center gap-6 font-semibold">
                    <span>Keputusan:</span>
                    <label class="flex items-center gap-1.5"><input type="checkbox" {{ $assistanceRequest->status === 'approved' || $assistanceRequest->status === 'distributed' ? 'checked' : '' }} /> Disetujui</label>
                    <label class="flex items-center gap-1.5"><input type="checkbox" {{ $assistanceRequest->status === 'rejected' ? 'checked' : '' }} /> Ditolak</label>
                    <label class="flex items-center gap-1.5"><input type="checkbox" {{ $assistanceRequest->status === 'reviewed' ? 'checked' : '' }} /> Ditunda / Klarifikasi Lanjutan</label>
                </div>
                <div class="grid grid-cols-2 gap-4 pt-2 border-t border-slate-200">
                    <div>
                        <span class="text-slate-500 font-bold block mb-1">Catatan Disposisi Pengurus:</span>
                        <div class="h-16 border border-dashed border-slate-300 rounded p-2 text-[11px] text-slate-400">
                            (Diisi oleh Pengurus Yayasan)
                        </div>
                    </div>
                    <div>
                        <span class="text-slate-500 font-bold block mb-1">Rencana Alokasi / Pengadaan:</span>
                        <div class="h-16 border border-dashed border-slate-300 rounded p-2 text-[11px] text-slate-400">
                            (Unit alkes / nomor batch / sumber pendanaan)
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tanda Tangan & Pengesahan -->
        <div class="pt-6 grid grid-cols-3 gap-6 text-center text-xs">
            <div class="space-y-16">
                <div>
                    <div class="font-bold text-slate-800">Pemohon / Faskes</div>
                    <div class="text-[11px] text-slate-500">{{ $assistanceRequest->institution_name }}</div>
                </div>
                <div>
                    <div class="font-bold underline text-slate-900">{{ $assistanceRequest->pic_name }}</div>
                    <div class="text-[10px] text-slate-500">{{ $assistanceRequest->pic_position ?: 'Penanggung Jawab' }}</div>
                </div>
            </div>

            <div class="space-y-16">
                <div>
                    <div class="font-bold text-slate-800">Tim Verifikasi Medik</div>
                    <div class="text-[11px] text-slate-500">Yayasan Satriabudi Dharma Setia</div>
                </div>
                <div>
                    <div class="font-bold underline text-slate-900">dr. Vincent / dr. Yunianti Lafau</div>
                    <div class="text-[10px] text-slate-500">Tim Telaah Teknis &amp; Medis YSDS</div>
                </div>
            </div>

            <div class="space-y-16">
                <div>
                    <div class="font-bold text-slate-800">Dewan Pengurus Yayasan</div>
                    <div class="text-[11px] text-slate-500">Yayasan Satriabudi Dharma Setia</div>
                </div>
                <div>
                    <div class="font-bold underline text-slate-900">dr. Vincent, Sp.PK</div>
                    <div class="text-[10px] text-slate-500">Ketua Pengurus Yayasan</div>
                </div>
            </div>
        </div>

        <!-- Footer Dokumen -->
        <div class="pt-6 border-t border-slate-200 flex items-center justify-between text-[10px] text-slate-400 font-mono">
            <span>Sistem Informasi Bantuan Kesehatan YSDS &bull; dharma.or.id</span>
            <span>Dicetak pada: {{ now()->format('d/m/Y H:i') }} WIB</span>
        </div>

    </div>

</body>
</html>
