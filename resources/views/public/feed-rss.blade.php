{!! '<' . '?xml version="1.0" encoding="UTF-8"?' . '>' !!}
<rss version="2.0"
     xmlns:dc="http://purl.org/dc/elements/1.1/"
     xmlns:content="http://purl.org/rss/1.0/modules/content/"
     xmlns:atom="http://www.w3.org/2005/Atom">
  <channel>
    <title>IGNITE - Publikasi Jurnal &amp; Artikel Ilmiah YSDS</title>
    <link>{{ route('website.home') }}</link>
    <description>Indeks naskah ilmiah terbuka dan publikasi riset genomik medis Yayasan Satriabudi Dharma Setia</description>
    <language>id</language>
    <lastBuildDate>{{ now()->toRssString() }}</lastBuildDate>
    <atom:link href="{{ route('website.feed.rss') }}" rel="self" type="application/rss+xml" />

    @foreach($articles as $article)
      @php
        $journal = $article->issue?->journal;
        $authors = $article->submission?->authors ?? collect();
      @endphp
      <item>
        <title><![CDATA[{{ $article->title }}]]></title>
        <link>{{ route('website.articles.show', $article->slug) }}</link>
        <guid isPermaLink="true">{{ route('website.articles.show', $article->slug) }}</guid>
        <pubDate>{{ ($article->published_at ?? $article->created_at)->toRssString() }}</pubDate>
        @if($authors->isNotEmpty())
          <dc:creator><![CDATA[{{ $authors->pluck('name')->implode(', ') }}]]></dc:creator>
        @elseif($article->submission?->author)
          <dc:creator><![CDATA[{{ $article->submission->author->name }}]]></dc:creator>
        @endif
        @if($journal)
          <dc:source><![CDATA[{{ $journal->name }} (Vol. {{ $article->issue?->volume }}, No. {{ $article->issue?->number }})]]></dc:source>
        @endif
        @if($article->doi)
          <dc:identifier>doi:{{ $article->doi }}</dc:identifier>
        @else
          <dc:identifier>{{ route('website.articles.show', $article->slug) }}</dc:identifier>
        @endif
        @if(!empty($article->keywords) && is_array($article->keywords))
          @foreach($article->keywords as $kw)
            <category><![CDATA[{{ trim($kw) }}]]></category>
          @endforeach
        @endif
        <description><![CDATA[{{ $article->abstract }}]]></description>
      </item>
    @endforeach
  </channel>
</rss>
