@extends('layouts.main')

@section('breadcrumbs')
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-4">
        <a href="{{ route('website.settings') }}" class="hover:text-red-600">Website</a>
        <span>/</span>
        <span class="font-semibold text-gray-800">Artikel Non-Jurnal &amp; Warta</span>
    </div>
@endsection

@section('content')
    <div class="grid w-full space-y-6">
        <!-- Header & Action Button -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Artikel &amp; Warta Non-Jurnal</h1>
                <p class="text-xs text-gray-500 mt-1">Kelola artikel populer, berita kegiatan yayasan, edukasi genomik/kesehatan, dan siaran pers publik.</p>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <a href="{{ route('website.news.index') }}" target="_blank" class="kt-btn kt-btn-outline text-xs">
                    <i class="ki-filled ki-eye mr-1"></i> Pratinjau Katalog Publik
                </a>
                <a href="{{ route('website.articles.admin.create') }}" class="kt-btn kt-btn-primary text-white text-xs font-semibold px-4 py-2.5">
                    <i class="ki-filled ki-plus text-white mr-1"></i> Tulis Artikel Baru
                </a>
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
                    <i class="ki-filled ki-notepad-edit"></i>
                </div>
                <div>
                    <div class="text-xl font-extrabold text-gray-900">{{ $totalArticles }}</div>
                    <div class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Total Artikel</div>
                </div>
            </div>

            <div class="kt-card p-5 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-black">
                    <i class="ki-filled ki-check-circle"></i>
                </div>
                <div>
                    <div class="text-xl font-extrabold text-gray-900">{{ $publishedCount }}</div>
                    <div class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Diterbitkan (Publik)</div>
                </div>
            </div>

            <div class="kt-card p-5 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl font-black">
                    <i class="ki-filled ki-document"></i>
                </div>
                <div>
                    <div class="text-xl font-extrabold text-gray-900">{{ $draftCount }}</div>
                    <div class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Draft / Arsip</div>
                </div>
            </div>

            <div class="kt-card p-5 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl font-black">
                    <i class="ki-filled ki-eye"></i>
                </div>
                <div>
                    <div class="text-xl font-extrabold text-gray-900">{{ number_format($totalViews) }}</div>
                    <div class="text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Total Tayangan</div>
                </div>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div class="kt-card p-4">
            <form action="{{ route('website.articles.admin.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="grow relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul artikel, penulis, ringkasan, atau tag..." class="kt-input w-full text-xs pl-9" />
                    <i class="ki-filled ki-magnifier absolute left-3 top-2.5 text-gray-400 text-sm"></i>
                </div>
                <div class="w-full sm:w-56">
                    <select name="category" class="kt-select w-full text-xs">
                        <option value="">-- Semua Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full sm:w-44">
                    <select name="status" class="kt-select w-full text-xs">
                        <option value="">-- Semua Status --</option>
                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Diterbitkan</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <button type="submit" class="kt-btn kt-btn-primary text-white text-xs px-4">
                        <i class="ki-filled ki-filter mr-1"></i> Filter
                    </button>
                    @if(request()->anyFilled(['search', 'category', 'status']))
                        <a href="{{ route('website.articles.admin.index') }}" class="kt-btn kt-btn-outline text-xs px-3">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Tabel Artikel -->
        <div class="kt-card shadow-sm">
            <div class="p-6">
                <div class="table-responsive">
                    <table class="table w-full text-xs text-left">
                        <thead class="bg-gray-50 text-gray-600 uppercase font-semibold">
                            <tr>
                                <th class="px-4 py-3 w-16 text-center">Sampul</th>
                                <th class="px-4 py-3">Judul &amp; Ringkasan</th>
                                <th class="px-4 py-3 w-36">Kategori</th>
                                <th class="px-4 py-3 w-36">Penulis</th>
                                <th class="px-4 py-3 text-center w-28">Status</th>
                                <th class="px-4 py-3 w-32">Tanggal Terbit</th>
                                <th class="px-4 py-3 text-center w-20">Dibaca</th>
                                <th class="px-4 py-3 text-right w-28">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-150">
                            @forelse($articles as $article)
                                <tr class="hover:bg-gray-50/50 transition">
                                    <td class="px-4 py-3 text-center">
                                        @if($article->image_url)
                                            <img src="{{ $article->image_url }}" alt="{{ $article->title }}" class="w-12 h-12 object-cover rounded-lg border border-gray-200 shadow-xs mx-auto" />
                                        @else
                                            <div class="w-12 h-12 rounded-lg bg-slate-100 border border-slate-200 text-slate-400 flex items-center justify-center mx-auto text-base">
                                                <i class="ki-filled ki-picture"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="font-bold text-gray-900 text-sm leading-snug">
                                            {{ $article->title }}
                                            @if($article->is_featured)
                                                <span class="ml-1.5 px-2 py-0.5 rounded text-[9px] font-extrabold uppercase bg-amber-100 text-amber-800 border border-amber-200">
                                                    Sorotan
                                                </span>
                                            @endif
                                            @if($article->has_english_translation)
                                                <span class="ml-1 px-1.5 py-0.5 rounded text-[9px] font-extrabold bg-blue-50 text-blue-700 border border-blue-200" title="Tersedia versi Bahasa Inggris">
                                                    EN
                                                </span>
                                            @endif
                                        </div>
                                        @if($article->summary)
                                            <p class="text-gray-500 text-xs mt-1 line-clamp-1 max-w-lg">{{ $article->summary }}</p>
                                        @endif
                                        <div class="text-[10px] text-gray-400 font-mono mt-0.5">slug: {{ $article->slug }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase bg-red-50 text-red-700 border border-red-100">
                                            {{ $article->category }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-gray-700 font-medium">
                                        {{ $article->author_name ?: 'Tim Redaksi' }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <form action="{{ route('website.articles.admin.toggle', $article->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase transition {{ $article->is_published ? 'bg-green-50 text-green-700 border border-green-200 hover:bg-green-100' : 'bg-gray-100 text-gray-500 border border-gray-200 hover:bg-gray-200' }}" title="Klik untuk mengubah status">
                                                {{ $article->is_published ? 'Terbit' : 'Draft' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-4 py-3 text-gray-600 font-mono">
                                        {{ $article->published_at ? $article->published_at->format('d M Y') : '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-center font-mono font-bold text-gray-700">
                                        {{ number_format($article->views_count) }}
                                    </td>
                                    <td class="px-4 py-3 text-right space-x-1 whitespace-nowrap">
                                        <a href="{{ route('website.news.show', $article->slug) }}" target="_blank" class="kt-btn kt-btn-xs kt-btn-ghost text-primary hover:bg-blue-50" title="Pratinjau Publik">
                                            <i class="ki-filled ki-eye"></i>
                                        </a>
                                        <a href="{{ route('website.articles.admin.edit', $article->id) }}" class="kt-btn kt-btn-xs kt-btn-ghost text-warning hover:bg-amber-50" title="Edit Artikel">
                                            <i class="ki-filled ki-pencil"></i>
                                        </a>
                                        <form action="{{ route('website.articles.admin.destroy', $article->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel \'{{ $article->title }}\'?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="kt-btn kt-btn-xs kt-btn-ghost text-danger hover:bg-red-50" title="Hapus Artikel">
                                                <i class="ki-filled ki-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-12 text-center text-gray-500 space-y-2">
                                        <div class="w-12 h-12 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center mx-auto text-xl">
                                            <i class="ki-filled ki-notepad-edit"></i>
                                        </div>
                                        <div class="font-semibold text-gray-700">Belum ada artikel non-jurnal yang dibuat.</div>
                                        <p class="text-xs text-gray-400">Mulai tulis artikel berita, warta kegiatan yayasan, atau edukasi kesehatan.</p>
                                        <a href="{{ route('website.articles.admin.create') }}" class="kt-btn kt-btn-primary text-white text-xs mt-2 inline-flex items-center gap-1">
                                            <i class="ki-filled ki-plus text-white"></i> Tulis Artikel Pertama
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($articles->hasPages())
                    <div class="pt-4 border-t border-gray-100">
                        {{ $articles->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
