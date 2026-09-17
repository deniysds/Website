@extends('layouts.main')

@section('breadcrumbs')
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
        <a href="{{ route('website.settings') }}" class="hover:text-red-600">Website</a>
        <span>/</span>
        <span class="font-semibold text-gray-800">Kolaborasi & Penyerahan Alat</span>
    </div>
@endsection

@section('content')
    <div class="grid w-full space-y-6">
        <!-- Header & Action Button -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Kolaborasi & Penyerahan Peralatan Instansi</h1>
                <p class="text-xs text-gray-500 mt-1">Kelola data instansi mitra penerima bantuan peralatan riset/kesehatan serta inventaris peralatan yang diserahkan.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('website.collaborations.public') }}" target="_blank" class="kt-btn kt-btn-outline text-xs">
                    <i class="ki-filled ki-eye mr-1"></i> Pratinjau Publik
                </a>
                <a href="{{ route('website.settings') }}" class="kt-btn kt-btn-outline text-xs">
                    <i class="ki-filled ki-setting-2 mr-1"></i> Pengaturan CMS
                </a>
                <button type="button" onclick="openAddModal()" class="kt-btn kt-btn-primary text-white text-xs font-semibold px-4 py-2.5">
                    <i class="ki-filled ki-plus text-white mr-1"></i> Tambah Instansi Baru
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-xl bg-green-50 text-green-700 border border-green-200 text-sm flex items-center gap-2">
                <i class="ki-filled ki-check-circle text-green-600 text-lg"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="p-4 rounded-xl bg-red-50 text-red-700 border border-red-200 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <p class="flex items-center gap-1.5"><i class="ki-filled ki-information text-red-600"></i> {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Stat Counter Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
            <div class="kt-card p-5 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-xl font-black">
                    <i class="ki-filled ki-bank"></i>
                </div>
                <div>
                    <div class="text-xl font-extrabold text-gray-900">{{ $totalInstitutions }}</div>
                    <div class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Total Instansi Mitra</div>
                </div>
            </div>

            <div class="kt-card p-5 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-black">
                    <i class="ki-filled ki-check-circle"></i>
                </div>
                <div>
                    <div class="text-xl font-extrabold text-gray-900">{{ $totalActiveInstitutions }}</div>
                    <div class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Instansi Aktif (Publik)</div>
                </div>
            </div>

            <div class="kt-card p-5 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl font-black">
                    <i class="ki-filled ki-element-11"></i>
                </div>
                <div>
                    <div class="text-xl font-extrabold text-gray-900">{{ $totalItemsCount }}</div>
                    <div class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Jenis Peralatan</div>
                </div>
            </div>

            <div class="kt-card p-5 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl font-black">
                    <i class="ki-filled ki-cube-2"></i>
                </div>
                <div>
                    <div class="text-xl font-extrabold text-gray-900">{{ number_format($totalUnitsSum) }}</div>
                    <div class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Total Unit Diserahkan</div>
                </div>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div class="kt-card p-4">
            <form action="{{ route('website.collaborations.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="grow relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama instansi, PIC, lokasi, atau nama peralatan..." class="kt-input w-full text-xs pl-9" />
                    <i class="ki-filled ki-magnifier absolute left-3 top-2.5 text-gray-400 text-sm"></i>
                </div>
                <div class="w-full sm:w-56">
                    <select name="category" class="kt-select w-full text-xs">
                        <option value="">-- Semua Kategori Instansi --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="kt-btn kt-btn-primary text-white text-xs px-4">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'category']))
                    <a href="{{ route('website.collaborations.index') }}" class="kt-btn kt-btn-outline text-xs px-3">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Table List Instansi -->
        <div class="kt-card">
            <div class="p-6">
                <div class="table-responsive">
                    <table class="table w-full text-xs text-left">
                        <thead class="bg-gray-50 text-gray-600 uppercase font-semibold">
                            <tr>
                                <th class="px-4 py-3 w-14 text-center">Urutan</th>
                                <th class="px-4 py-3">Logo</th>
                                <th class="px-4 py-3">Nama Instansi</th>
                                <th class="px-4 py-3">Kategori & Lokasi</th>
                                <th class="px-4 py-3">Tgl Penyerahan</th>
                                <th class="px-4 py-3 text-center">Peralatan Diserahkan</th>
                                <th class="px-4 py-3 text-center">Status</th>
                                <th class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-150">
                            @forelse($collaborations as $collab)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="px-4 py-3 font-mono font-bold text-gray-700 text-center">{{ $collab->order_no }}</td>
                                    <td class="px-4 py-3">
                                        @if($collab->institution_logo)
                                            <img src="{{ Storage::url($collab->institution_logo) }}" alt="{{ $collab->institution_name }}" class="h-9 max-w-[100px] object-contain rounded bg-white p-1 border border-gray-200 shadow-2xs" />
                                        @else
                                            <div class="w-9 h-9 rounded-xl bg-slate-900 text-white font-black flex items-center justify-center text-[10px] uppercase shadow-xs">
                                                {{ strtoupper(substr($collab->institution_name, 0, 2)) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="font-bold text-gray-900 text-sm hover:text-red-600 transition">
                                            <a href="{{ route('website.collaborations.show', $collab->id) }}">{{ $collab->institution_name }}</a>
                                        </div>
                                        @if($collab->pic_name)
                                            <div class="text-[11px] text-gray-500 mt-0.5 flex items-center gap-1">
                                                <i class="ki-filled ki-profile-user text-gray-400"></i> PIC: {{ $collab->pic_name }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($collab->category)
                                            <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-blue-50 text-blue-700 border border-blue-100 mb-1">
                                                {{ $collab->category }}
                                            </span>
                                        @endif
                                        @if($collab->location)
                                            <div class="text-[11px] text-gray-500 flex items-center gap-1">
                                                <i class="ki-filled ki-geolocation text-red-500"></i> {{ $collab->location }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 font-mono text-gray-600">
                                        {{ $collab->handover_date ? $collab->handover_date->translatedFormat('d M Y') : '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <a href="{{ route('website.collaborations.show', $collab->id) }}" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-red-50 hover:text-red-700 border border-slate-200 text-slate-700 font-bold transition">
                                            <i class="ki-filled ki-cube-2 text-xs"></i>
                                            <span>{{ $collab->items_count }} Jenis ({{ (int) $collab->items->sum('quantity') }} Unit)</span>
                                        </a>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <form action="{{ route('website.collaborations.toggle', $collab->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-2 py-0.5 rounded text-[10px] font-bold uppercase cursor-pointer transition {{ $collab->is_active ? 'bg-green-50 text-green-700 border border-green-200 hover:bg-green-100' : 'bg-gray-100 text-gray-500 border border-gray-200 hover:bg-gray-200' }}">
                                                {{ $collab->is_active ? 'Aktif' : 'Non-Aktif' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-4 py-3 text-right space-x-1">
                                        <a href="{{ route('website.collaborations.show', $collab->id) }}" class="kt-btn kt-btn-xs kt-btn-ghost text-primary hover:bg-blue-50" title="Kelola Inventaris Peralatan">
                                            <i class="ki-filled ki-cube-2"></i> Alat
                                        </a>
                                        <button type="button" onclick="openEditModal({{ json_encode($collab) }})" class="kt-btn kt-btn-xs kt-btn-ghost text-warning hover:bg-amber-50">
                                            <i class="ki-filled ki-pencil"></i> Edit
                                        </button>
                                        <form action="{{ route('website.collaborations.destroy', $collab->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus instansi {{ $collab->institution_name }} beserta seluruh riwayat peralatannya?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="kt-btn kt-btn-xs kt-btn-ghost text-danger hover:bg-red-50">
                                                <i class="ki-filled ki-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-8 text-center text-gray-500">Belum ada data kolaborasi instansi yang sesuai.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $collaborations->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Instansi Baru -->
    <div id="addCollabModal" class="fixed inset-0 bg-slate-900/60 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-xl w-full p-6 shadow-2xl border border-gray-150 space-y-5 animate-fade-in max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between border-b border-gray-200 pb-3">
                <h3 class="text-base font-bold text-gray-900">Tambah Instansi Kolaborasi Baru</h3>
                <button type="button" onclick="closeAddModal()" class="text-gray-400 hover:text-gray-600 text-lg">&times;</button>
            </div>

            <form action="{{ route('website.collaborations.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf
                <div class="space-y-1">
                    <label class="font-bold text-gray-700">Nama Instansi / Rumah Sakit / Universitas <span class="text-red-500">*</span></label>
                    <input type="text" name="institution_name" required class="kt-input w-full text-xs" placeholder="Contoh: RSUP Dr. Sardjito Yogyakarta" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Kategori Instansi</label>
                        <input type="text" name="category" class="kt-input w-full text-xs" placeholder="Rumah Sakit, Perguruan Tinggi, Lab Riset..." />
                    </div>
                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Lokasi / Wilayah</label>
                        <input type="text" name="location" class="kt-input w-full text-xs" placeholder="Contoh: Sleman, D.I. Yogyakarta" />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Tanggal Serah Terima (BAST)</label>
                        <input type="date" name="handover_date" class="kt-input w-full text-xs" />
                    </div>
                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Nama PIC / Pimpinan Penerima</label>
                        <input type="text" name="pic_name" class="kt-input w-full text-xs" placeholder="Contoh: Direktur Utama / Kepala Lab" />
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="font-bold text-gray-700">Deskripsi / Catatan Kerjasama</label>
                    <textarea name="description" rows="3" class="kt-input w-full text-xs py-2" placeholder="Catatan lingkup kerjasama atau nomor dokumen BAST..."></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Logo / Foto Instansi (PNG/JPG - Max 2MB)</label>
                        <input type="file" name="institution_logo" accept="image/*" class="kt-input w-full text-xs" />
                    </div>
                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Nomor Urutan (Order No)</label>
                        <input type="number" name="order_no" value="0" class="kt-input w-full text-xs" />
                    </div>
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <input type="checkbox" name="is_active" value="1" id="is_active_add" checked class="rounded border-gray-300 text-red-600 focus:ring-red-500" />
                    <label for="is_active_add" class="text-xs text-gray-700 font-medium">Tampilkan di Halaman Publik (Aktif)</label>
                </div>

                <div class="pt-4 border-t border-gray-200 flex justify-end gap-2">
                    <button type="button" onclick="closeAddModal()" class="kt-btn kt-btn-outline text-xs">Batal</button>
                    <button type="submit" class="kt-btn kt-btn-primary text-white text-xs font-bold px-4">Simpan & Lanjutkan ke Alat</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Instansi -->
    <div id="editCollabModal" class="fixed inset-0 bg-slate-900/60 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-xl w-full p-6 shadow-2xl border border-gray-150 space-y-5 animate-fade-in max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between border-b border-gray-200 pb-3">
                <h3 class="text-base font-bold text-gray-900">Ubah Data Instansi Kolaborasi</h3>
                <button type="button" onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 text-lg">&times;</button>
            </div>

            <form id="editCollabForm" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf
                @method('PUT')
                <div class="space-y-1">
                    <label class="font-bold text-gray-700">Nama Instansi / Rumah Sakit / Universitas <span class="text-red-500">*</span></label>
                    <input type="text" name="institution_name" id="edit_institution_name" required class="kt-input w-full text-xs" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Kategori Instansi</label>
                        <input type="text" name="category" id="edit_category" class="kt-input w-full text-xs" />
                    </div>
                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Lokasi / Wilayah</label>
                        <input type="text" name="location" id="edit_location" class="kt-input w-full text-xs" />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Tanggal Serah Terima (BAST)</label>
                        <input type="date" name="handover_date" id="edit_handover_date" class="kt-input w-full text-xs" />
                    </div>
                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Nama PIC / Pimpinan Penerima</label>
                        <input type="text" name="pic_name" id="edit_pic_name" class="kt-input w-full text-xs" />
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="font-bold text-gray-700">Deskripsi / Catatan Kerjasama</label>
                    <textarea name="description" id="edit_description" rows="3" class="kt-input w-full text-xs py-2"></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Ganti Logo / Foto (Opsional)</label>
                        <input type="file" name="institution_logo" accept="image/*" class="kt-input w-full text-xs" />
                    </div>
                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Nomor Urutan (Order No)</label>
                        <input type="number" name="order_no" id="edit_order_no" class="kt-input w-full text-xs" />
                    </div>
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <input type="checkbox" name="is_active" value="1" id="edit_is_active" class="rounded border-gray-300 text-red-600 focus:ring-red-500" />
                    <label for="edit_is_active" class="text-xs text-gray-700 font-medium">Tampilkan di Halaman Publik (Aktif)</label>
                </div>

                <div class="pt-4 border-t border-gray-200 flex justify-end gap-2">
                    <button type="button" onclick="closeEditModal()" class="kt-btn kt-btn-outline text-xs">Batal</button>
                    <button type="submit" class="kt-btn kt-btn-primary text-white text-xs font-bold px-4">Perbarui Instansi</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('addCollabModal').classList.remove('hidden');
        }

        function closeAddModal() {
            document.getElementById('addCollabModal').classList.add('hidden');
        }

        function openEditModal(collab) {
            const form = document.getElementById('editCollabForm');
            form.action = `/admin/website/collaborations/${collab.id}`;

            document.getElementById('edit_institution_name').value = collab.institution_name || '';
            document.getElementById('edit_category').value = collab.category || '';
            document.getElementById('edit_location').value = collab.location || '';
            document.getElementById('edit_handover_date').value = collab.handover_date ? collab.handover_date.substring(0, 10) : '';
            document.getElementById('edit_pic_name').value = collab.pic_name || '';
            document.getElementById('edit_description').value = collab.description || '';
            document.getElementById('edit_order_no').value = collab.order_no || 0;
            document.getElementById('edit_is_active').checked = Boolean(collab.is_active);

            document.getElementById('editCollabModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editCollabModal').classList.add('hidden');
        }
    </script>
@endsection
