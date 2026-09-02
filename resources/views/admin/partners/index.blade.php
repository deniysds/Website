@extends('layouts.main')

@section('breadcrumbs')
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
        <a href="{{ route('website.settings') }}" class="hover:text-red-600">Website</a>
        <span>/</span>
        <span class="font-semibold text-gray-800">Manajemen Mitra (Partners)</span>
    </div>
@endsection

@section('content')
    <div class="grid w-full space-y-6">
        <!-- Header & Action Button -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Manajemen Mitra Publikasi & Kolaborasi</h1>
                <p class="text-xs text-gray-500 mt-1">Kelola daftar logo Mitra Utama (Platinum) dan Mitra Pendukung (Perguruan Tinggi/Institusi) yang tampil di portal publik.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('website.settings') }}" class="kt-btn kt-btn-outline text-xs">
                    <i class="ki-filled ki-setting-2 mr-1"></i> Pengaturan CMS
                </a>
                <button type="button" onclick="openAddModal()" class="kt-btn kt-btn-primary text-white text-xs font-semibold px-4 py-2.5">
                    <i class="ki-filled ki-plus text-white mr-1"></i> Tambah Mitra Baru
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
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="kt-card p-6 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-xl font-black">
                    <i class="ki-filled ki-element-11"></i>
                </div>
                <div>
                    <div class="text-2xl font-extrabold text-gray-900">{{ $partners->total() }}</div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Mitra Terdaftar</div>
                </div>
            </div>

            <div class="kt-card p-6 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-slate-900 text-white flex items-center justify-center text-xl font-black">
                    <i class="ki-filled ki-crown"></i>
                </div>
                <div>
                    <div class="text-2xl font-extrabold text-gray-900">{{ $mainCount }}</div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Mitra Utama (Platinum)</div>
                </div>
            </div>

            <div class="kt-card p-6 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl font-black">
                    <i class="ki-filled ki-teacher"></i>
                </div>
                <div>
                    <div class="text-2xl font-extrabold text-gray-900">{{ $supportingCount }}</div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Mitra Pendukung (Universitas)</div>
                </div>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div class="kt-card p-4">
            <form action="{{ route('website.partners.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="grow relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama institusi / mitra..." class="kt-input w-full text-xs pl-9" />
                    <i class="ki-filled ki-magnifier absolute left-3 top-2.5 text-gray-400 text-sm"></i>
                </div>
                <div class="w-full sm:w-56">
                    <select name="type" class="kt-select w-full text-xs">
                        <option value="">-- Semua Kategori Mitra --</option>
                        <option value="main" {{ request('type') === 'main' ? 'selected' : '' }}>Mitra Utama (Main Partner)</option>
                        <option value="supporting" {{ request('type') === 'supporting' ? 'selected' : '' }}>Mitra Pendukung (Supporting)</option>
                    </select>
                </div>
                <button type="submit" class="kt-btn kt-btn-primary text-white text-xs px-4">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'type']))
                    <a href="{{ route('website.partners.index') }}" class="kt-btn kt-btn-outline text-xs px-3">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Table List -->
        <div class="kt-card">
            <div class="p-6">
                <div class="table-responsive">
                    <table class="table w-full text-xs text-left">
                        <thead class="bg-gray-50 text-gray-600 uppercase font-semibold">
                            <tr>
                                <th class="px-4 py-3 w-16 text-center">Urutan</th>
                                <th class="px-4 py-3">Logo</th>
                                <th class="px-4 py-3">Nama Mitra / Institusi</th>
                                <th class="px-4 py-3">Kategori</th>
                                <th class="px-4 py-3">Website Link</th>
                                <th class="px-4 py-3 text-center">Status</th>
                                <th class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-150">
                            @forelse($partners as $partner)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="px-4 py-3 font-mono font-bold text-gray-700 text-center">{{ $partner->order_no }}</td>
                                    <td class="px-4 py-3">
                                        @if($partner->logo_path)
                                            <img src="{{ Storage::url($partner->logo_path) }}" alt="{{ $partner->name }}" class="h-8 max-w-[120px] object-contain rounded bg-slate-900/5 p-1 border border-gray-200" />
                                        @else
                                            <div class="w-8 h-8 rounded-full bg-slate-900 text-white font-black flex items-center justify-center text-[10px] uppercase shadow-xs">
                                                {{ substr($partner->name, 0, 2) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 font-bold text-gray-900">{{ $partner->name }}</td>
                                    <td class="px-4 py-3">
                                        @if($partner->type === 'main')
                                            <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase bg-slate-900 text-white shadow-xs">Mitra Utama</span>
                                        @else
                                            <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase bg-blue-50 text-blue-700 border border-blue-100">Pendukung</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-gray-500 font-mono">
                                        @if($partner->website_url)
                                            <a href="{{ $partner->website_url }}" target="_blank" class="text-blue-600 hover:underline flex items-center gap-1">
                                                <span class="truncate max-w-[150px] inline-block">{{ $partner->website_url }}</span>
                                                <i class="ki-filled ki-exit-right-corner text-[10px]"></i>
                                            </a>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <form action="{{ route('website.partners.toggle', $partner->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-2 py-0.5 rounded text-[10px] font-bold uppercase cursor-pointer transition {{ $partner->is_active ? 'bg-green-50 text-green-700 border border-green-200 hover:bg-green-100' : 'bg-gray-100 text-gray-500 border border-gray-200 hover:bg-gray-200' }}">
                                                {{ $partner->is_active ? 'Aktif' : 'Non-Aktif' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-4 py-3 text-right space-x-1">
                                        <button type="button" onclick="openEditModal({{ json_encode($partner) }})" class="kt-btn kt-btn-xs kt-btn-ghost text-warning hover:bg-amber-50">
                                            <i class="ki-filled ki-pencil"></i> Edit
                                        </button>
                                        <form action="{{ route('website.partners.destroy', $partner->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus mitra ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="kt-btn kt-btn-xs kt-btn-ghost text-danger hover:bg-red-50">
                                                <i class="ki-filled ki-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-8 text-center text-gray-500">Belum ada data mitra yang sesuai.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $partners->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Mitra Baru -->
    <div id="addPartnerModal" class="fixed inset-0 bg-slate-900/60 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-gray-150 space-y-5 animate-fade-in">
            <div class="flex items-center justify-between border-b border-gray-200 pb-3">
                <h3 class="text-base font-bold text-gray-900">Tambah Logo Mitra Baru</h3>
                <button type="button" onclick="closeAddModal()" class="text-gray-400 hover:text-gray-600 text-lg">&times;</button>
            </div>

            <form action="{{ route('website.partners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf
                <div class="space-y-1">
                    <label class="font-bold text-gray-700">Nama Mitra / Perguruan Tinggi <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required class="kt-input w-full text-xs" placeholder="Contoh: Universitas Gadjah Mada" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Kategori Mitra <span class="text-red-500">*</span></label>
                        <select name="type" required class="kt-select w-full text-xs">
                            <option value="supporting">Mitra Pendukung (Universitas/Institusi)</option>
                            <option value="main">Mitra Utama (Platinum)</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Nomor Urutan (Order No)</label>
                        <input type="number" name="order_no" value="0" class="kt-input w-full text-xs" />
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="font-bold text-gray-700">Tautan Website (URL)</label>
                    <input type="url" name="website_url" class="kt-input w-full text-xs" placeholder="https://www.example.ac.id" />
                </div>

                <div class="space-y-1">
                    <label class="font-bold text-gray-700">File Logo (PNG, SVG, JPG, WEBP - Max 2MB)</label>
                    <input type="file" name="logo" accept="image/*" class="kt-input w-full text-xs" />
                    <p class="text-[10px] text-gray-400">Disarankan menggunakan format transparan (.png atau .svg).</p>
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <input type="checkbox" name="is_active" value="1" id="is_active_add" checked class="rounded border-gray-300 text-red-600 focus:ring-red-500" />
                    <label for="is_active_add" class="text-xs text-gray-700 font-medium">Tampilkan di Halaman Publik (Aktif)</label>
                </div>

                <div class="pt-4 border-t border-gray-200 flex justify-end gap-2">
                    <button type="button" onclick="closeAddModal()" class="kt-btn kt-btn-outline text-xs">Batal</button>
                    <button type="submit" class="kt-btn kt-btn-primary text-white text-xs font-bold px-4">Simpan Mitra</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Mitra -->
    <div id="editPartnerModal" class="fixed inset-0 bg-slate-900/60 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-gray-150 space-y-5 animate-fade-in">
            <div class="flex items-center justify-between border-b border-gray-200 pb-3">
                <h3 class="text-base font-bold text-gray-900">Ubah Data Mitra</h3>
                <button type="button" onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 text-lg">&times;</button>
            </div>

            <form id="editPartnerForm" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf
                @method('PUT')
                <div class="space-y-1">
                    <label class="font-bold text-gray-700">Nama Mitra / Perguruan Tinggi <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="edit_name" required class="kt-input w-full text-xs" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Kategori Mitra <span class="text-red-500">*</span></label>
                        <select name="type" id="edit_type" required class="kt-select w-full text-xs">
                            <option value="supporting">Mitra Pendukung (Universitas/Institusi)</option>
                            <option value="main">Mitra Utama (Platinum)</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="font-bold text-gray-700">Nomor Urutan (Order No)</label>
                        <input type="number" name="order_no" id="edit_order_no" class="kt-input w-full text-xs" />
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="font-bold text-gray-700">Tautan Website (URL)</label>
                    <input type="url" name="website_url" id="edit_website_url" class="kt-input w-full text-xs" />
                </div>

                <div class="space-y-1">
                    <label class="font-bold text-gray-700">Ganti File Logo (Opsional)</label>
                    <input type="file" name="logo" accept="image/*" class="kt-input w-full text-xs" />
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <input type="checkbox" name="is_active" value="1" id="edit_is_active" class="rounded border-gray-300 text-red-600 focus:ring-red-500" />
                    <label for="edit_is_active" class="text-xs text-gray-700 font-medium">Tampilkan di Halaman Publik (Aktif)</label>
                </div>

                <div class="pt-4 border-t border-gray-200 flex justify-end gap-2">
                    <button type="button" onclick="closeEditModal()" class="kt-btn kt-btn-outline text-xs">Batal</button>
                    <button type="submit" class="kt-btn kt-btn-primary text-white text-xs font-bold px-4">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('addPartnerModal').classList.remove('hidden');
        }
        function closeAddModal() {
            document.getElementById('addPartnerModal').classList.add('hidden');
        }
        function openEditModal(partner) {
            const form = document.getElementById('editPartnerForm');
            form.action = `/admin/website/partners/${partner.id}`;
            document.getElementById('edit_name').value = partner.name || '';
            document.getElementById('edit_type').value = partner.type || 'supporting';
            document.getElementById('edit_order_no').value = partner.order_no || 0;
            document.getElementById('edit_website_url').value = partner.website_url || '';
            document.getElementById('edit_is_active').checked = partner.is_active ? true : false;
            document.getElementById('editPartnerModal').classList.remove('hidden');
        }
        function closeEditModal() {
            document.getElementById('editPartnerModal').classList.add('hidden');
        }
    </script>
@endsection
