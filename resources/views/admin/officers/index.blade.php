@extends('layouts.main')

@section('breadcrumbs')
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
        <a href="{{ route('website.settings') }}" class="hover:text-red-600">Website</a>
        <span>/</span>
        <span class="font-semibold text-gray-800">Manajemen Pengurus & Struktur Organisasi</span>
    </div>
@endsection

@section('content')
    <div class="grid w-full space-y-6">
        <!-- Header & Action Button -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Struktur Organisasi & Dewan Pengurus</h1>
                <p class="text-xs text-gray-500 mt-1">Kelola data Dewan Pembina, Pengawas, Pimpinan Harian, Dewan Redaksi, dan Tim Ahli yayasan/jurnal.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('website.officers.public') }}" target="_blank" class="kt-btn kt-btn-outline text-xs">
                    <i class="ki-filled ki-eye mr-1"></i> Pratinjau Publik
                </a>
                <a href="{{ route('website.settings') }}" class="kt-btn kt-btn-outline text-xs">
                    <i class="ki-filled ki-setting-2 mr-1"></i> Pengaturan CMS
                </a>
                <button type="button" onclick="openAddModal()" class="kt-btn kt-btn-primary text-white text-xs font-semibold px-4 py-2.5">
                    <i class="ki-filled ki-plus text-white mr-1"></i> Tambah Pengurus Baru
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
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl font-black">
                    <i class="ki-filled ki-crown"></i>
                </div>
                <div>
                    <div class="text-xl font-extrabold text-gray-900">{{ $countLevel1 }}</div>
                    <div class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Level 1: Pembina / Pengawas</div>
                </div>
            </div>

            <div class="kt-card p-5 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-xl font-black">
                    <i class="ki-filled ki-profile-user"></i>
                </div>
                <div>
                    <div class="text-xl font-extrabold text-gray-900">{{ $countLevel2 }}</div>
                    <div class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Level 2: Ketua / Pimpinan</div>
                </div>
            </div>

            <div class="kt-card p-5 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl font-black">
                    <i class="ki-filled ki-people"></i>
                </div>
                <div>
                    <div class="text-xl font-extrabold text-gray-900">{{ $countLevel3 }}</div>
                    <div class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Level 3: Pengurus Harian</div>
                </div>
            </div>

            <div class="kt-card p-5 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-black">
                    <i class="ki-filled ki-book-open"></i>
                </div>
                <div>
                    <div class="text-xl font-extrabold text-gray-900">{{ $countLevel4 }}</div>
                    <div class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Level 4: Redaksi & Ahli</div>
                </div>
            </div>
        </div>

        <!-- Filter & Table Card -->
        <div class="kt-card shadow-sm">
            <div class="kt-card-header min-h-16 py-4 border-b border-gray-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <form method="GET" action="{{ route('website.officers.index') }}" class="flex flex-wrap items-center gap-3 w-full md:w-auto">
                    <div class="relative w-full sm:w-64">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, jabatan, afiliasi..." class="kt-input w-full text-xs pe-8" />
                        @if(request('search'))
                            <a href="{{ route('website.officers.index', request()->except('search')) }}" class="absolute right-2.5 top-2.5 text-gray-400 hover:text-gray-600">
                                <i class="ki-filled ki-cross text-xs"></i>
                            </a>
                        @endif
                    </div>

                    <select name="hierarchy_level" onchange="this.form.submit()" class="kt-select text-xs">
                        <option value="">Semua Tingkat Hierarki</option>
                        <option value="1" {{ request('hierarchy_level') == '1' ? 'selected' : '' }}>Tingkat 1: Dewan Pembina & Pengawas</option>
                        <option value="2" {{ request('hierarchy_level') == '2' ? 'selected' : '' }}>Tingkat 2: Pimpinan Harian / Ketua</option>
                        <option value="3" {{ request('hierarchy_level') == '3' ? 'selected' : '' }}>Tingkat 3: Sekretaris / Manajemen</option>
                        <option value="4" {{ request('hierarchy_level') == '4' ? 'selected' : '' }}>Tingkat 4: Dewan Redaksi & Ahli</option>
                    </select>

                    <select name="category" onchange="this.form.submit()" class="kt-select text-xs">
                        <option value="">Semua Kategori</option>
                        <option value="pembina" {{ request('category') == 'pembina' ? 'selected' : '' }}>Dewan Pembina</option>
                        <option value="pengawas" {{ request('category') == 'pengawas' ? 'selected' : '' }}>Dewan Pengawas</option>
                        <option value="pengurus_harian" {{ request('category') == 'pengurus_harian' ? 'selected' : '' }}>Pengurus Harian</option>
                        <option value="dewan_redaksi" {{ request('category') == 'dewan_redaksi' ? 'selected' : '' }}>Dewan Redaksi Jurnal</option>
                        <option value="tim_ahli" {{ request('category') == 'tim_ahli' ? 'selected' : '' }}>Komite Ilmiah & Tim Ahli</option>
                    </select>

                    <button type="submit" class="kt-btn kt-btn-outline kt-btn-sm text-xs">
                        <i class="ki-filled ki-filter text-xs mr-1"></i> Filter
                    </button>
                </form>
            </div>

            <div class="kt-card-body p-0 overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50/50 text-[11px] font-bold uppercase text-gray-500 tracking-wider">
                            <th class="py-3 px-4">Pengurus</th>
                            <th class="py-3 px-4">Jabatan & Kategori</th>
                            <th class="py-3 px-4 text-center">Tingkat Hierarki</th>
                            <th class="py-3 px-4 text-center">Urutan</th>
                            <th class="py-3 px-4 text-center">Status</th>
                            <th class="py-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-xs">
                        @forelse($officers as $officer)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-3">
                                        @if($officer->photo_path)
                                            <img src="{{ asset('storage/' . $officer->photo_path) }}" alt="{{ $officer->name }}" class="w-10 h-10 rounded-full object-cover border border-gray-200 shrink-0" />
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-sm border border-gray-200 shrink-0">
                                                {{ strtoupper(substr($officer->name, 0, 2)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-bold text-gray-900">{{ $officer->full_name_with_title }}</div>
                                            @if($officer->affiliation)
                                                <div class="text-[11px] text-gray-500">{{ $officer->affiliation }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="font-semibold text-gray-900">{{ $officer->position }}</div>
                                    <span class="inline-block mt-0.5 px-2 py-0.5 rounded text-[10px] font-bold 
                                        {{ $officer->category === 'pembina' ? 'bg-amber-100 text-amber-800' : '' }}
                                        {{ $officer->category === 'pengawas' ? 'bg-purple-100 text-purple-800' : '' }}
                                        {{ $officer->category === 'pengurus_harian' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $officer->category === 'dewan_redaksi' ? 'bg-red-100 text-red-800' : '' }}
                                        {{ $officer->category === 'tim_ahli' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                    ">
                                        {{ $officer->category_label }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-[11px] font-bold border
                                        {{ $officer->hierarchy_level === 1 ? 'bg-amber-50 text-amber-700 border-amber-200' : '' }}
                                        {{ $officer->hierarchy_level === 2 ? 'bg-red-50 text-red-700 border-red-200' : '' }}
                                        {{ $officer->hierarchy_level === 3 ? 'bg-blue-50 text-blue-700 border-blue-200' : '' }}
                                        {{ $officer->hierarchy_level === 4 ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : '' }}
                                    ">
                                        Tingkat {{ $officer->hierarchy_level }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-center font-semibold text-gray-700">
                                    {{ $officer->order_no }}
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <form action="{{ route('website.officers.toggle', $officer->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-2.5 py-1 rounded-full text-[10px] font-bold transition cursor-pointer {{ $officer->is_active ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                                            {{ $officer->is_active ? 'Aktif' : 'Non-Aktif' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <button type="button" onclick="openEditModal({{ json_encode($officer) }})" class="kt-btn kt-btn-outline kt-btn-sm text-xs p-1.5" title="Edit Pengurus">
                                            <i class="ki-filled ki-pencil text-xs"></i>
                                        </button>
                                        <form action="{{ route('website.officers.destroy', $officer->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pengurus ini?');" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="kt-btn kt-btn-outline kt-btn-sm text-xs text-red-600 hover:bg-red-50 p-1.5" title="Hapus">
                                                <i class="ki-filled ki-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-gray-400">
                                    <i class="ki-filled ki-information-2 text-3xl mb-2 block"></i>
                                    Belum ada data pengurus yang tercatat. Silakan klik tombol "Tambah Pengurus Baru".
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($officers->hasPages())
                <div class="kt-card-footer p-4 border-t border-gray-200">
                    {{ $officers->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Form Tambah / Edit Pengurus -->
    <div id="officerModal" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-xs flex items-center justify-center hidden">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between sticky top-0 bg-white z-10">
                <h3 id="modalTitle" class="text-base font-bold text-gray-900">Tambah Pengurus Baru</h3>
                <button type="button" onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="ki-filled ki-cross text-lg"></i>
                </button>
            </div>

            <form id="officerForm" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <div id="methodField"></div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="kt-label text-xs font-bold text-gray-700">Gelar Depan</label>
                        <input type="text" name="title_prefix" id="title_prefix" class="kt-input w-full text-xs" placeholder="dr. / Prof. / Dr." />
                    </div>
                    <div class="md:col-span-2">
                        <label class="kt-label text-xs font-bold text-gray-700">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" required class="kt-input w-full text-xs" placeholder="Nama Lengkap" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="kt-label text-xs font-bold text-gray-700">Gelar Belakang</label>
                        <input type="text" name="title_suffix" id="title_suffix" class="kt-input w-full text-xs" placeholder="M.Ked., Sp.PK / Ph.D" />
                    </div>
                    <div>
                        <label class="kt-label text-xs font-bold text-gray-700">Jabatan Resmi <span class="text-red-500">*</span></label>
                        <input type="text" name="position" id="position" required class="kt-input w-full text-xs" placeholder="Contoh: Ketua Yayasan / Dewan Pembina" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="kt-label text-xs font-bold text-gray-700">Kategori Penugasan <span class="text-red-500">*</span></label>
                        <select name="category" id="category" required class="kt-select w-full text-xs">
                            <option value="pembina">Dewan Pembina</option>
                            <option value="pengawas">Dewan Pengawas</option>
                            <option value="pengurus_harian" selected>Pengurus Harian</option>
                            <option value="dewan_redaksi">Dewan Redaksi Jurnal</option>
                            <option value="tim_ahli">Komite Ilmiah & Tim Ahli</option>
                        </select>
                    </div>
                    <div>
                        <label class="kt-label text-xs font-bold text-gray-700">Tingkat Hierarki Bagan <span class="text-red-500">*</span></label>
                        <select name="hierarchy_level" id="hierarchy_level" required class="kt-select w-full text-xs">
                            <option value="1">Tingkat 1: Dewan Pembina & Pengawas</option>
                            <option value="2">Tingkat 2: Pimpinan Harian / Ketua</option>
                            <option value="3">Tingkat 3: Sekretaris / Manajemen Eksekutif</option>
                            <option value="4">Tingkat 4: Dewan Redaksi Jurnal & Tim Ahli</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="kt-label text-xs font-bold text-gray-700">Afiliasi / Instansi</label>
                        <input type="text" name="affiliation" id="affiliation" class="kt-input w-full text-xs" placeholder="Yayasan Satriabudi Dharma Setia / Universitas" />
                    </div>
                    <div>
                        <label class="kt-label text-xs font-bold text-gray-700">Nomor Urut Tampilan</label>
                        <input type="number" name="order_no" id="order_no" value="0" min="0" class="kt-input w-full text-xs" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="kt-label text-xs font-bold text-gray-700">Email Resmi</label>
                        <input type="email" name="email" id="email" class="kt-input w-full text-xs" placeholder="nama@dharma.or.id" />
                    </div>
                    <div>
                        <label class="kt-label text-xs font-bold text-gray-700">Profil LinkedIn URL</label>
                        <input type="url" name="linkedin_url" id="linkedin_url" class="kt-input w-full text-xs" placeholder="https://linkedin.com/in/username" />
                    </div>
                </div>

                <div>
                    <label class="kt-label text-xs font-bold text-gray-700">Foto Profil Pengurus</label>
                    <input type="file" name="photo" id="photo" accept="image/png, image/jpeg, image/webp" class="kt-input w-full text-xs p-2" />
                    <p class="text-[11px] text-gray-400 mt-1">Format: JPG, PNG, WEBP. Maksimal 2MB. Disarankan rasio 1:1.</p>
                </div>

                <div>
                    <label class="kt-label text-xs font-bold text-gray-700">Biografi Singkat / Profil Profesional</label>
                    <textarea name="bio" id="bio" rows="3" class="kt-input w-full text-xs p-3" placeholder="Uraian ringkas pengalaman, keahlian medis/ilmiah, atau riwayat pengabdian."></textarea>
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <input type="checkbox" name="is_active" id="is_active" value="1" checked class="kt-checkbox" />
                    <label for="is_active" class="text-xs font-semibold text-gray-700">Tampilkan pengurus ini di halaman publik</label>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" onclick="closeModal()" class="kt-btn kt-btn-outline text-xs">Batal</button>
                    <button type="submit" class="kt-btn kt-btn-primary text-white text-xs font-semibold px-5">Simpan Data Pengurus</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('modalTitle').innerText = 'Tambah Pengurus Baru';
            document.getElementById('officerForm').action = "{{ route('website.officers.store') }}";
            document.getElementById('methodField').innerHTML = '';
            document.getElementById('officerForm').reset();
            document.getElementById('is_active').checked = true;
            document.getElementById('officerModal').classList.remove('hidden');
        }

        function openEditModal(officer) {
            document.getElementById('modalTitle').innerText = 'Edit Data Pengurus';
            document.getElementById('officerForm').action = `/admin/website/officers/${officer.id}`;
            document.getElementById('methodField').innerHTML = '@method("PUT")';
            
            document.getElementById('name').value = officer.name || '';
            document.getElementById('title_prefix').value = officer.title_prefix || '';
            document.getElementById('title_suffix').value = officer.title_suffix || '';
            document.getElementById('position').value = officer.position || '';
            document.getElementById('category').value = officer.category || 'pengurus_harian';
            document.getElementById('hierarchy_level').value = officer.hierarchy_level || 2;
            document.getElementById('affiliation').value = officer.affiliation || '';
            document.getElementById('order_no').value = officer.order_no || 0;
            document.getElementById('email').value = officer.email || '';
            document.getElementById('linkedin_url').value = officer.linkedin_url || '';
            document.getElementById('bio').value = officer.bio || '';
            document.getElementById('is_active').checked = Boolean(officer.is_active);

            document.getElementById('officerModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('officerModal').classList.add('hidden');
        }
    </script>
@endsection
