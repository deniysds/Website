<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BAST Penyerahan Peralatan - {{ $collaboration->institution_name }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
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
            <a href="{{ route('website.collaborations.show', $collaboration->id) }}" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition">
                &larr; Kembali ke Rincian
            </a>
            <span class="text-slate-300">|</span>
            <span class="text-xs font-bold text-slate-700">Pratinjau Cetak BAST Peralatan</span>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('website.collaborations.items.export', $collaboration->id) }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition">
                <svg class="w-4 h-4 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Ekspor CSV / Excel
            </a>
            <button onclick="window.print()" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold text-white bg-red-600 hover:bg-red-700 shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak / Simpan PDF
            </button>
        </div>
    </div>

    <!-- Official BAST Paper Sheet -->
    <div class="print-container max-w-4xl mx-auto bg-white border border-slate-200 p-8 sm:p-12 rounded-3xl shadow-md space-y-8">
        
        <!-- Header Dokumen / Kop -->
        <div class="border-b-2 border-slate-900 pb-6 flex items-start justify-between gap-6">
            <div class="space-y-1">
                <div class="text-xs font-extrabold tracking-widest uppercase text-red-600">YAYASAN SATRIABUDI DHARMA SETIA</div>
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 tracking-tight">BERITA ACARA SERAH TERIMA (BAST)</h1>
                <p class="text-xs text-slate-600 font-medium">Bantuan Fasilitas Peralatan Riset Laboratorium &amp; Genomik Kesehatan</p>
            </div>
            <div class="text-right text-xs font-mono space-y-1 shrink-0">
                <div class="font-bold text-slate-900">NO: BAST/YSDS-IGNITE/{{ str_pad($collaboration->id, 4, '0', STR_PAD_LEFT) }}/{{ $collaboration->handover_date ? $collaboration->handover_date->format('Y') : date('Y') }}</div>
                <div class="text-slate-500">Tanggal: {{ $collaboration->handover_date ? $collaboration->handover_date->translatedFormat('d F Y') : date('d F Y') }}</div>
            </div>
        </div>

        <!-- Deskripsi Pernyataan Serah Terima -->
        <div class="text-xs text-slate-700 leading-relaxed space-y-3">
            <p>
                Pada hari ini, bertempat di <strong>{{ $collaboration->location ?: 'Indonesia' }}</strong>, telah dilakukan penyerahan fasilitas peralatan riset dan operasional laboratorium kesehatan/genomik dari <strong>Yayasan Satriabudi Dharma Setia (YSDS)</strong> kepada <strong>{{ $collaboration->institution_name }}</strong> sebagai berikut:
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-slate-50 p-4 rounded-xl border border-slate-200 my-3 text-xs">
                <div>
                    <span class="text-slate-400 font-bold uppercase text-[10px] block">Instansi Penerima:</span>
                    <strong class="text-slate-900 text-sm block">{{ $collaboration->institution_name }}</strong>
                    <span class="text-slate-600 text-xs block mt-0.5">{{ $collaboration->category ?: 'Mitra Fasilitas Kesehatan' }}</span>
                </div>
                <div>
                    <span class="text-slate-400 font-bold uppercase text-[10px] block">Penanggung Jawab (PIC):</span>
                    <strong class="text-slate-900 text-sm block">{{ $collaboration->pic_name ?: '-' }}</strong>
                    <span class="text-slate-600 text-xs block mt-0.5">Lokasi: {{ $collaboration->location ?: '-' }}</span>
                </div>
            </div>

            @if($collaboration->description)
                <p class="italic text-slate-600 bg-white p-3 rounded-lg border border-slate-150">
                    "{{ $collaboration->description }}"
                </p>
            @endif
        </div>

        <!-- Tabel Inventaris Peralatan -->
        <div class="space-y-2">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800">Daftar Rincian Peralatan yang Diserahkan:</h3>
            <table class="w-full border-collapse border border-slate-300 text-xs">
                <thead>
                    <tr class="bg-slate-100 text-slate-800 font-bold text-center">
                        <th class="border border-slate-300 px-3 py-2 w-16">No.</th>
                        <th class="border border-slate-300 px-3 py-2 text-left">Nama Peralatan</th>
                        <th class="border border-slate-300 px-3 py-2 w-24">Satuan</th>
                        <th class="border border-slate-300 px-3 py-2 w-20">Jumlah</th>
                        <th class="border border-slate-300 px-3 py-2 text-left">Spesifikasi / Merk / Catatan Kondisi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-300">
                    @forelse($collaboration->items as $item)
                        <tr>
                            <td class="border border-slate-300 px-3 py-2 text-center font-mono font-bold">{{ $item->item_number }}</td>
                            <td class="border border-slate-300 px-3 py-2 font-semibold text-slate-900">{{ $item->name }}</td>
                            <td class="border border-slate-300 px-3 py-2 text-center uppercase">{{ $item->unit }}</td>
                            <td class="border border-slate-300 px-3 py-2 text-center font-bold text-red-600">{{ number_format($item->quantity) }}</td>
                            <td class="border border-slate-300 px-3 py-2 text-slate-600">{{ $item->specifications ?: '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="border border-slate-300 px-3 py-6 text-center text-slate-500 italic">
                                Belum ada peralatan yang dicatat dalam daftar serah terima ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if($collaboration->items->isNotEmpty())
                    <tfoot>
                        <tr class="bg-slate-100 font-bold text-slate-900">
                            <td colspan="2" class="border border-slate-300 px-3 py-2.5 text-right uppercase text-[11px]">Total Akumulasi:</td>
                            <td class="border border-slate-300 px-3 py-2.5 text-center">{{ $collaboration->items->count() }} Jenis</td>
                            <td class="border border-slate-300 px-3 py-2.5 text-center text-red-600 font-extrabold text-sm">{{ number_format($collaboration->items->sum('quantity')) }} Unit</td>
                            <td class="border border-slate-300 px-3 py-2.5 text-slate-500 italic text-[11px]">Telah diperiksa dan diterima lengkap</td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>

        <!-- Pernyataan Penutup -->
        <p class="text-xs text-slate-600 leading-relaxed text-justify">
            Demikian Berita Acara Serah Terima (BAST) ini dibuat dan ditandatangani oleh kedua belah pihak dengan sebenar-benarnya dalam kondisi baik, lengkap, dan berfungsi untuk mendukung kegiatan riset kesehatan dan diagnostik genomik.
        </p>

        <!-- Kolom Tanda Tangan Para Pihak -->
        <div class="pt-8 grid grid-cols-2 gap-8 text-center text-xs">
            <div class="space-y-16">
                <div>
                    <span class="font-bold text-slate-800 uppercase block">PIHAK PERTAMA</span>
                    <span class="text-slate-500 text-[11px]">Yayasan Satriabudi Dharma Setia</span>
                </div>
                <div class="space-y-1">
                    <div class="w-48 mx-auto border-b border-slate-900"></div>
                    <span class="font-bold text-slate-900 block">( Perwakilan Resmi YSDS )</span>
                </div>
            </div>

            <div class="space-y-16">
                <div>
                    <span class="font-bold text-slate-800 uppercase block">PIHAK KEDUA</span>
                    <span class="text-slate-500 text-[11px]">{{ $collaboration->institution_name }}</span>
                </div>
                <div class="space-y-1">
                    <div class="w-48 mx-auto border-b border-slate-900"></div>
                    <span class="font-bold text-slate-900 block">( {{ $collaboration->pic_name ?: 'Pimpinan Instansi Penerima' }} )</span>
                </div>
            </div>
        </div>

    </div>

</body>
</html>
