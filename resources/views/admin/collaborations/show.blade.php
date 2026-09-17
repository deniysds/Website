@extends('layouts.main')

@section('breadcrumbs')
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
        <a href="{{ route('website.settings') }}" class="hover:text-red-600">Website</a>
        <span>/</span>
        <a href="{{ route('website.collaborations.index') }}" class="hover:text-red-600">Kolaborasi & Penyerahan Alat</a>
        <span>/</span>
        <span class="font-semibold text-gray-800">{{ $collaboration->institution_name }}</span>
    </div>
@endsection

@section('content')
    <div class="grid w-full space-y-6">
        <!-- Header & Action Button -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('website.collaborations.index') }}" class="kt-btn kt-btn-outline kt-btn-icon text-gray-600">
                    <i class="ki-filled ki-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $collaboration->institution_name }}</h1>
                    <p class="text-xs text-gray-500 mt-1">Rincian profil instansi dan daftar peralatan yang telah diserahkan (nomor, nama, satuan, jumlah).</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('website.collaborations.public') }}" target="_blank" class="kt-btn kt-btn-outline text-xs">
                    <i class="ki-filled ki-eye mr-1"></i> Pratinjau Publik
                </a>
                <button type="button" onclick="openAddItemModal()" class="kt-btn kt-btn-primary text-white text-xs font-semibold px-4 py-2.5">
                    <i class="ki-filled ki-plus text-white mr-1"></i> Tambah Peralatan
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

        <!-- Card Informasi Instansi -->
        <div class="kt-card p-6">
            <div class="flex flex-col md:flex-row items-start justify-between gap-6">
                <div class="flex items-start gap-4">
                    @if($collaboration->institution_logo)
                        <img src="{{ Storage::url($collaboration->institution_logo) }}" alt="{{ $collaboration->institution_name }}" class="w-16 h-16 object-contain rounded-xl bg-white p-1 border border-gray-200 shadow-xs shrink-0" />
                    @else
                        <div class="w-16 h-16 rounded-xl bg-slate-900 text-white font-black flex items-center justify-center text-xl uppercase shadow-xs shrink-0">
                            {{ strtoupper(substr($collaboration->institution_name, 0, 2)) }}
                        </div>
                    @endif

                    <div class="space-y-1.5">
                        <div class="flex flex-wrap items-center gap-2">
                            <h2 class="text-lg font-bold text-gray-900">{{ $collaboration->institution_name }}</h2>
                            @if($collaboration->category)
                                <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase bg-blue-50 text-blue-700 border border-blue-100">
                                    {{ $collaboration->category }}
                                </span>
                            @endif
                            <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase {{ $collaboration->is_active ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-gray-100 text-gray-500 border border-gray-200' }}">
                                {{ $collaboration->is_active ? 'Publik / Aktif' : 'Draft / Non-Aktif' }}
                            </span>
                        </div>

                        <div class="flex flex-wrap items-center gap-4 text-xs text-gray-600">
                            @if($collaboration->location)
                                <div class="flex items-center gap-1">
                                    <i class="ki-filled ki-geolocation text-red-500"></i> {{ $collaboration->location }}
                                </div>
                            @endif
                            @if($collaboration->pic_name)
                                <div class="flex items-center gap-1">
                                    <i class="ki-filled ki-profile-user text-gray-500"></i> PIC: <strong class="text-gray-800">{{ $collaboration->pic_name }}</strong>
                                </div>
                            @endif
                            @if($collaboration->handover_date)
                                <div class="flex items-center gap-1 font-mono">
                                    <i class="ki-filled ki-calendar text-gray-500"></i> Serah Terima: {{ $collaboration->handover_date->translatedFormat('d F Y') }}
                                </div>
                            @endif
                        </div>

                        @if($collaboration->description)
                            <p class="text-xs text-gray-600 pt-2 leading-relaxed max-w-3xl">
                                {{ $collaboration->description }}
                            </p>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-2 self-start shrink-0">
                    <form action="{{ route('website.collaborations.toggle', $collaboration->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="kt-btn kt-btn-outline kt-btn-sm text-xs">
                            {{ $collaboration->is_active ? 'Non-aktifkan' : 'Aktifkan' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabel Inventaris Peralatan yang Diserahkan -->
        <div class="kt-card shadow-sm">
            <div class="kt-card-header min-h-14 py-4 px-6 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h3 class="kt-card-title text-base font-bold text-gray-900 flex items-center gap-2">
                        <i class="ki-filled ki-cube-2 text-red-600 text-lg"></i>
                        Daftar Peralatan yang Telah Diserahkan
                    </h3>
                    <p class="text-xs text-gray-500 mt-0.5">Rincian spesifikasi, satuan, dan jumlah unit peralatan hibah/bantuan resmi yayasan.</p>
                </div>
                <button type="button" onclick="openAddItemModal()" class="kt-btn kt-btn-primary text-white text-xs font-semibold px-3.5 py-2">
                    <i class="ki-filled ki-plus text-white mr-1"></i> Tambah Peralatan
                </button>
            </div>

            <div class="p-6">
                <div class="table-responsive">
                    <table class="table w-full text-xs text-left">
                        <thead class="bg-gray-50 text-gray-600 uppercase font-semibold">
                            <tr>
                                <th class="px-4 py-3 w-28 text-center">Nomor</th>
                                <th class="px-4 py-3">Nama Peralatan</th>
                                <th class="px-4 py-3 text-center w-28">Satuan</th>
                                <th class="px-4 py-3 text-center w-28">Jumlah</th>
                                <th class="px-4 py-3">Spesifikasi / Catatan</th>
                                <th class="px-4 py-3 text-right w-24">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-150">
                            @forelse($collaboration->items as $item)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="px-4 py-3 font-mono font-bold text-gray-800 text-center bg-gray-50/40 rounded">
                                        {{ $item->item_number }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="font-bold text-gray-900 text-sm">{{ $item->name }}</div>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="px-2.5 py-1 rounded bg-slate-100 text-slate-700 font-bold uppercase text-[10px] border border-slate-200">
                                            {{ $item->unit }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span class="px-3 py-1 rounded-lg bg-red-50 text-red-700 font-extrabold text-sm border border-red-100">
                                            {{ number_format($item->quantity) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-gray-500 leading-relaxed">
                                        {{ $item->specifications ?: '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-right space-x-1">
                                        <button type="button" onclick="openEditItemModal({{ json_encode($item) }})" class="kt-btn kt-btn-xs kt-btn-ghost text-warning hover:bg-amber-50">
                                            <i class="ki-filled ki-pencil"></i>
                                        </button>
                                        <form action="{{ route('website.collaborations.items.destroy', [$collaboration->id, $item->id]) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus peralatan {{ $item->name }}?');">
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
                                    <td colspan="6" class="px-4 py-10 text-center text-gray-500 space-y-2">
                                        <div class="w-12 h-12 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center mx-auto text-xl">
                                            <i class="ki-filled ki-cube-2"></i>
                                        </div>
                                        <div class="font-semibold text-gray-700">Belum ada peralatan yang ditambahkan untuk instansi ini.</div>
                                        <button type="button" onclick="openAddItemModal()" class="kt-btn kt-btn-primary text-white text-xs mt-2">
                                            <i class="ki-filled ki-plus text-white mr-1"></i> Tambah Peralatan Pertama
                                        </button>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if($collaboration->items->isNotEmpty())
                            <tfoot class="bg-gray-50/80 font-bold border-t border-gray-200">
                                <tr>
                                    <td colspan="2" class="px-4 py-3 text-right uppercase text-[11px] text-gray-600">Total Akumulasi Peralatan:</td>
                                    <td class="px-4 py-3 text-center text-gray-700 font-mono text-xs">{{ $collaboration->items->count() }} Jenis</td>
                                    <td class="px-4 py-3 text-center text-red-600 font-mono text-base font-black">
                                        {{ number_format($collaboration->items->sum('quantity')) }} Unit
                                    </td>
                                    <td colspan="2" class="px-4 py-3 text-gray-400 text-[11px]">Tercatat dalam BAST</td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Peralatan -->
    <div id="addItemModal" class="fixed inset-0 bg-slate-900/60 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-gray-150 space-y-5 animate-fade-in">
            <div class="flex items-center justify-between border-b border-gray-200 pb-3">
                <h3 class="text-base font-bold text-gray-900">Tambah Peralatan yang Diserahkan</h3>
                <button type="button" onclick="closeAddItemModal()" class="text-gray-400 hover:text-gray-600 text-lg">&times;</button>
            </div>

            <form action="{{ route('website.collaborations.items.store', $collaboration->id) }}" method="POST" class="space-y-4 text-xs">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="space-y-1 sm:col-span-1">
                        <label class="font-bold text-gray-700">Nomor <span class="text-red-500">*</span></label>
                        <input type="text" name="item_number" required value="{{ $collaboration->items->count() + 1 }}" class="kt-input w-full text-xs" placeholder="Contoh: 1 atau EQ-01" />
                        <p class="text-[10px] text-gray-400">Nomor urut / kode inventaris.</p>
                    </div>

                    <div class="space-y-1 sm:col-span-2">
                        <label class="font-bold text-gray-700">Nama Peralatan <span class="text-red-500">*</span></label>
                        <input type="text" name="name" required class="kt-input w-full text-xs" placeholder="Contoh: Real-Time PCR Detection System" />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Satuan <span class="text-red-500">*</span></label>
                        <input type="text" name="unit" required list="unit_options" class="kt-input w-full text-xs" placeholder="Unit / Set / Pcs / Paket" />
                        <datalist id="unit_options">
                            <option value="Unit">
                            <option value="Set">
                            <option value="Pcs">
                            <option value="Paket">
                            <option value="Buah">
                            <option value="Kotak">
                        </datalist>
                    </div>

                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Jumlah <span class="text-red-500">*</span></label>
                        <input type="number" name="quantity" required min="1" value="1" class="kt-input w-full text-xs" />
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="font-bold text-gray-700">Spesifikasi / Merk / Catatan Kondisi</label>
                    <textarea name="specifications" rows="2" class="kt-input w-full text-xs py-2" placeholder="Merk, tipe, serial number, atau kelengkapan aksesoris..."></textarea>
                </div>

                <div class="pt-4 border-t border-gray-200 flex justify-end gap-2">
                    <button type="button" onclick="closeAddItemModal()" class="kt-btn kt-btn-outline text-xs">Batal</button>
                    <button type="submit" class="kt-btn kt-btn-primary text-white text-xs font-bold px-4">Simpan Peralatan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Peralatan -->
    <div id="editItemModal" class="fixed inset-0 bg-slate-900/60 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-gray-150 space-y-5 animate-fade-in">
            <div class="flex items-center justify-between border-b border-gray-200 pb-3">
                <h3 class="text-base font-bold text-gray-900">Ubah Data Peralatan</h3>
                <button type="button" onclick="closeEditItemModal()" class="text-gray-400 hover:text-gray-600 text-lg">&times;</button>
            </div>

            <form id="editItemForm" method="POST" class="space-y-4 text-xs">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="space-y-1 sm:col-span-1">
                        <label class="font-bold text-gray-700">Nomor <span class="text-red-500">*</span></label>
                        <input type="text" name="item_number" id="edit_item_number" required class="kt-input w-full text-xs" />
                    </div>

                    <div class="space-y-1 sm:col-span-2">
                        <label class="font-bold text-gray-700">Nama Peralatan <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="edit_item_name" required class="kt-input w-full text-xs" />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Satuan <span class="text-red-500">*</span></label>
                        <input type="text" name="unit" id="edit_item_unit" required class="kt-input w-full text-xs" />
                    </div>

                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Jumlah <span class="text-red-500">*</span></label>
                        <input type="number" name="quantity" id="edit_item_quantity" required min="1" class="kt-input w-full text-xs" />
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="font-bold text-gray-700">Spesifikasi / Merk / Catatan Kondisi</label>
                    <textarea name="specifications" id="edit_item_specifications" rows="2" class="kt-input w-full text-xs py-2"></textarea>
                </div>

                <div class="pt-4 border-t border-gray-200 flex justify-end gap-2">
                    <button type="button" onclick="closeEditItemModal()" class="kt-btn kt-btn-outline text-xs">Batal</button>
                    <button type="submit" class="kt-btn kt-btn-primary text-white text-xs font-bold px-4">Perbarui Peralatan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAddItemModal() {
            document.getElementById('addItemModal').classList.remove('hidden');
        }

        function closeAddItemModal() {
            document.getElementById('addItemModal').classList.add('hidden');
        }

        function openEditItemModal(item) {
            const form = document.getElementById('editItemForm');
            form.action = `/admin/website/collaborations/{{ $collaboration->id }}/items/${item.id}`;

            document.getElementById('edit_item_number').value = item.item_number || '';
            document.getElementById('edit_item_name').value = item.name || '';
            document.getElementById('edit_item_unit').value = item.unit || '';
            document.getElementById('edit_item_quantity').value = item.quantity || 1;
            document.getElementById('edit_item_specifications').value = item.specifications || '';

            document.getElementById('editItemModal').classList.remove('hidden');
        }

        function closeEditItemModal() {
            document.getElementById('editItemModal').classList.add('hidden');
        }
    </script>
@endsection
