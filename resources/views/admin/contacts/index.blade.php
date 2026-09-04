@extends('layouts.main')

@section('breadcrumbs')
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
        <a href="{{ route('website.settings') }}" class="hover:text-red-600">Website</a>
        <span>/</span>
        <span class="font-semibold text-gray-800">Kotak Masuk Pertanyaan Publik (Inquiries)</span>
    </div>
@endsection

@section('content')
    <div class="grid w-full space-y-6">
        <!-- Header & Statistics -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Kotak Masuk Pertanyaan & Kontak Publik</h1>
                <p class="text-xs text-gray-500 mt-1">Daftar pesan, pertanyaan, dan kebutuhan informasi yang dikirimkan pengunjung melalui formulir portal IGNITE.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('website.contacts.export', request()->query()) }}" class="kt-btn kt-btn-primary text-white text-xs font-semibold px-4 py-2.5">
                    <i class="ki-filled ki-file-down text-white mr-1"></i> Ekspor CSV
                </a>
                <a href="{{ route('website.settings') }}" class="kt-btn kt-btn-outline text-xs">
                    <i class="ki-filled ki-setting-2 mr-1"></i> Pengaturan CMS
                </a>
                <a href="{{ route('website.partners.index') }}" class="kt-btn kt-btn-outline text-xs">
                    <i class="ki-filled ki-element-11 mr-1"></i> Mitra Kami
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-xl bg-green-50 text-green-700 border border-green-200 text-sm flex items-center gap-2">
                <i class="ki-filled ki-check-circle text-green-600 text-lg"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Stat Counter Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-6">
            <div class="kt-card p-6 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-slate-900 text-white flex items-center justify-center text-xl font-black">
                    <i class="ki-filled ki-sms"></i>
                </div>
                <div>
                    <div class="text-2xl font-extrabold text-gray-900">{{ $contacts->total() }}</div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Pesan Masuk</div>
                </div>
            </div>

            <div class="kt-card p-6 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-xl font-black">
                    <i class="ki-filled ki-notification-on"></i>
                </div>
                <div>
                    <div class="text-2xl font-extrabold text-red-600">{{ $unreadCount }}</div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Belum Dibaca (Unread)</div>
                </div>
            </div>

            <div class="kt-card p-6 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl font-black">
                    <i class="ki-filled ki-eye"></i>
                </div>
                <div>
                    <div class="text-2xl font-extrabold text-blue-600">{{ $readCount }}</div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Telah Dibaca</div>
                </div>
            </div>

            <div class="kt-card p-6 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center text-xl font-black">
                    <i class="ki-filled ki-check-circle"></i>
                </div>
                <div>
                    <div class="text-2xl font-extrabold text-green-600">{{ $repliedCount }}</div>
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Sudah Dibalas</div>
                </div>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div class="kt-card p-4">
            <form action="{{ route('website.contacts.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="grow relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, nomor telepon, atau isi pesan..." class="kt-input w-full text-xs pl-9" />
                    <i class="ki-filled ki-magnifier absolute left-3 top-2.5 text-gray-400 text-sm"></i>
                </div>
                <div class="w-full sm:w-52">
                    <select name="status" class="kt-select w-full text-xs">
                        <option value="">-- Semua Status --</option>
                        <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>Belum Dibaca (Unread)</option>
                        <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Sudah Dibaca (Read)</option>
                        <option value="replied" {{ request('status') === 'replied' ? 'selected' : '' }}>Sudah Dibalas (Replied)</option>
                    </select>
                </div>
                <button type="submit" class="kt-btn kt-btn-primary text-white text-xs px-4">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'status']))
                    <a href="{{ route('website.contacts.index') }}" class="kt-btn kt-btn-outline text-xs px-3">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Table List Inquiries -->
        <div class="kt-card">
            <div class="p-6">
                <div class="table-responsive">
                    <table class="table w-full text-xs text-left">
                        <thead class="bg-gray-50 text-gray-600 uppercase font-semibold">
                            <tr>
                                <th class="px-4 py-3">Nama Pengirim</th>
                                <th class="px-4 py-3">Kontak (Email / Phone)</th>
                                <th class="px-4 py-3">Isi Ringkasan Pesan</th>
                                <th class="px-4 py-3">Waktu Masuk</th>
                                <th class="px-4 py-3 text-center">Status</th>
                                <th class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-150">
                            @forelse($contacts as $contact)
                                <tr class="hover:bg-gray-50/50 transition {{ $contact->status === 'unread' ? 'bg-red-50/20 font-bold' : '' }}">
                                    <td class="px-4 py-3">
                                        <div class="text-gray-900 font-bold">{{ $contact->full_name }}</div>
                                    </td>
                                    <td class="px-4 py-3 space-y-0.5 font-mono text-[11px]">
                                        <div class="text-blue-600 font-medium">{{ $contact->email }}</div>
                                        <div class="text-gray-500">{{ $contact->phone }}</div>
                                    </td>
                                    <td class="px-4 py-3 max-w-xs">
                                        <p class="text-gray-700 truncate">{{ $contact->message }}</p>
                                    </td>
                                    <td class="px-4 py-3 text-gray-500 font-mono text-[11px] whitespace-nowrap">
                                        {{ $contact->created_at->format('d M Y, H:i') }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        @if($contact->status === 'unread')
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-red-100 text-red-700 border border-red-200">Unread</span>
                                        @elseif($contact->status === 'read')
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-blue-50 text-blue-700 border border-blue-150">Read</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase bg-green-50 text-green-700 border border-green-200">Replied</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-right space-x-1 whitespace-nowrap">
                                        <a href="{{ route('website.contacts.show', $contact->id) }}" class="kt-btn kt-btn-xs kt-btn-ghost text-blue-600 hover:bg-blue-50">
                                            <i class="ki-filled ki-eye mr-1"></i> Buka Pesan
                                        </a>
                                        <form action="{{ route('website.contacts.destroy', $contact->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pesan ini dari sistem?');">
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
                                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">Belum ada pesan kontak yang masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $contacts->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
