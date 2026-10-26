@extends('website::layouts.public')

@section('public_content')
    <div class="max-w-4xl mx-auto space-y-8 pb-16">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-xs text-slate-500 flex-wrap">
            <a href="{{ route('website.home') }}" class="hover:text-red-600 transition">{{ __('Beranda') }}</a>
            <span>/</span>
            <a href="{{ route('website.news.index') }}" class="hover:text-red-600 transition">{{ __('Warta & Artikel') }}</a>
            <span>/</span>
            <a href="{{ route('website.news.index', ['category' => $article->category]) }}" class="hover:text-red-600 transition">{{ $article->category }}</a>
            <span>/</span>
            <span class="text-slate-800 font-semibold truncate max-w-xs">{{ $article->title }}</span>
        </nav>

        <!-- Article Header -->
        <header class="space-y-4">
            <div class="flex flex-wrap items-center gap-2.5">
                <span class="px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-red-50 text-red-700 border border-red-200">
                    {{ $article->category }}
                </span>
                @if($article->is_featured)
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase bg-amber-100 text-amber-800 border border-amber-200">
                        {{ __('Sorotan') }}
                    </span>
                @endif
                <span class="text-xs text-slate-400 font-mono">•</span>
                <span class="text-xs text-slate-500 font-mono flex items-center gap-1">
                    <i class="ki-filled ki-calendar text-slate-400"></i>
                    {{ $article->published_at ? $article->published_at->translatedFormat('d F Y') : '-' }}
                </span>
                <span class="text-xs text-slate-400 font-mono">•</span>
                <span class="text-xs text-slate-500 font-medium">
                    {{ $article->reading_time }}
                </span>
                <span class="text-xs text-slate-400 font-mono">•</span>
                <span class="text-xs text-slate-500 flex items-center gap-1">
                    <i class="ki-filled ki-eye text-slate-400"></i>
                    {{ number_format($article->views_count) }} {{ __('tayangan') }}
                </span>
            </div>

            <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black text-slate-900 leading-tight tracking-tight">
                {{ $article->title_localized }}
            </h1>

            <div class="flex items-center gap-3 pt-2 text-xs text-slate-600">
                <div class="w-9 h-9 rounded-full bg-red-600 text-white font-black flex items-center justify-center text-sm shadow-xs">
                    {{ strtoupper(substr($article->author_name ?: 'Y', 0, 1)) }}
                </div>
                <div>
                    <div class="font-bold text-slate-900">{{ $article->author_name ?: 'Tim Redaksi YSDS' }}</div>
                    <div class="text-[11px] text-slate-500">{{ __('Yayasan Satriabudi Dharma Setia') }}</div>
                </div>
            </div>
        </header>

        <!-- Summary / Lead Box -->
        @if($article->summary_localized)
            <div class="p-5 sm:p-6 rounded-2xl bg-gradient-to-r from-red-50/70 via-slate-50 to-white border-l-4 border-red-600 shadow-xs">
                <p class="text-sm sm:text-base text-slate-700 leading-relaxed font-medium italic">
                    "{{ $article->summary_localized }}"
                </p>
            </div>
        @endif

        <!-- Cover Image -->
        @if($article->image_url)
            <div class="rounded-3xl overflow-hidden shadow-lg border border-slate-200/80 bg-slate-900">
                <img src="{{ $article->image_url }}" alt="{{ $article->title_localized }}" class="w-full max-h-[500px] object-cover" />
            </div>
        @endif

        <!-- Article Content -->
        <article class="prose prose-red max-w-none text-slate-800 text-sm sm:text-base leading-relaxed text-justify prose-img:rounded-2xl prose-img:shadow-md prose-headings:font-bold prose-headings:text-slate-900 prose-a:text-red-600 hover:prose-a:text-red-700">
            @php $currentContent = $article->content_localized; @endphp
            @if(strip_tags($currentContent) !== $currentContent)
                {!! $currentContent !!}
            @else
                <div class="space-y-5 whitespace-pre-line">
                    {!! nl2br(e($currentContent)) !!}
                </div>
            @endif
        </article>

        <!-- Tags -->
        @if(!empty($article->tags_array))
            <div class="pt-6 border-t border-slate-200/80 flex flex-wrap items-center gap-2">
                <span class="text-xs font-bold uppercase text-slate-500 mr-1 flex items-center gap-1">
                    <i class="ki-filled ki-tag text-slate-400"></i> Tagar:
                </span>
                @foreach($article->tags_array as $tag)
                    <span class="px-3 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-700 hover:bg-slate-200 transition">
                        #{{ $tag }}
                    </span>
                @endforeach
            </div>
        @endif

        <!-- Share Bar -->
        <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <span class="text-xs font-bold text-slate-700 uppercase tracking-wider flex items-center gap-2">
                <i class="ki-filled ki-share text-red-600"></i> {{ __('Bagikan Artikel Ini:') }}
            </span>
            <div class="flex items-center gap-2 flex-wrap">
                <a href="https://api.whatsapp.com/send?text={{ urlencode($article->title . ' ' . url()->current()) }}" target="_blank" class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs flex items-center gap-1.5 transition">
                    <span>WhatsApp</span>
                </a>
                <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(url()->current()) }}" target="_blank" class="px-3 py-1.5 rounded-xl bg-black hover:bg-slate-800 text-white font-bold text-xs flex items-center gap-1.5 transition">
                    <span>X (Twitter)</span>
                </a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" target="_blank" class="px-3 py-1.5 rounded-xl bg-blue-700 hover:bg-blue-800 text-white font-bold text-xs flex items-center gap-1.5 transition">
                    <span>LinkedIn</span>
                </a>
                <button type="button" onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan artikel berhasil disalin ke clipboard!');" class="px-3 py-1.5 rounded-xl bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 font-bold text-xs flex items-center gap-1.5 transition">
                    <i class="ki-filled ki-copy"></i>
                    <span>{{ __('Salin Tautan') }}</span>
                </button>
            </div>
        </div>

        <!-- Back to News -->
        <div class="pt-4">
            <a href="{{ route('website.news.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-red-600 hover:text-red-700">
                &larr; {{ __('Kembali ke Semua Warta & Artikel') }}
            </a>
        </div>

        <!-- Artikel Terkait -->
        @if($relatedArticles->isNotEmpty())
            <div class="pt-10 border-t border-slate-200/80 space-y-6">
                <div class="space-y-1">
                    <span class="text-xs font-bold text-red-600 uppercase tracking-widest">{{ __('Rekomendasi Lainnya') }}</span>
                    <h3 class="text-xl sm:text-2xl font-black text-slate-900">{{ __('Artikel Terkait') }}</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedArticles as $rel)
                        <article class="bg-white rounded-2xl border border-slate-200/80 hover:shadow-lg transition overflow-hidden flex flex-col justify-between group">
                            <div class="w-full h-36 bg-slate-900 relative overflow-hidden">
                                @if($rel->image_url)
                                    <img src="{{ $rel->image_url }}" alt="{{ $rel->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" />
                                @else
                                    <div class="w-full h-full bg-gradient-to-tr from-slate-900 to-red-950 p-4 flex items-end text-white">
                                        <span class="text-[10px] font-mono text-slate-300">{{ $rel->category }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-5 space-y-2 grow flex flex-col justify-between">
                                <div class="space-y-1.5">
                                    <span class="text-[10px] font-bold uppercase text-red-600 bg-red-50 px-2 py-0.5 rounded border border-red-100">{{ $rel->category }}</span>
                                    <h4 class="font-bold text-slate-900 text-sm leading-snug group-hover:text-red-600 transition">
                                        <a href="{{ route('website.news.show', $rel->slug) }}">
                                            {{ $rel->title }}
                                        </a>
                                    </h4>
                                </div>
                                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400">
                                    <span>{{ $rel->published_at ? $rel->published_at->format('d M Y') : '-' }}</span>
                                    <a href="{{ route('website.news.show', $rel->slug) }}" class="font-bold text-red-600 hover:underline">
                                        {{ __('Baca') }} &rarr;
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
