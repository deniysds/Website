{!! '<' . '?xml version="1.0" encoding="UTF-8"?' . '>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
        http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">

    <!-- Core Public Pages -->
    <url>
        <loc>{{ route('website.home') }}</loc>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    <url>
        <loc>{{ route('website.about') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ route('website.officers.public') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ route('website.collaborations.public') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ route('website.visitations.public') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ route('website.assistance.public') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ route('website.donation.public') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>{{ route('website.documents.public') }}</loc>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ route('website.news.index') }}</loc>
        <changefreq>daily</changefreq>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ route('website.journals.index') }}</loc>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>{{ route('website.articles.index') }}</loc>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>{{ route('website.contact') }}</loc>
        <changefreq>monthly</changefreq>
        <priority>0.7</priority>
    </url>

    <!-- News & Media Releases -->
    @foreach($news as $item)
        <url>
            <loc>{{ route('website.news.show', $item->slug) }}</loc>
            <lastmod>{{ $item->updated_at ? $item->updated_at->tz('UTC')->toAtomString() : now()->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.7</priority>
        </url>
    @endforeach

    <!-- Field Visitations & Lab Handover -->
    @foreach($visitations as $visit)
        <url>
            <loc>{{ route('website.visitations.show', $visit->slug) }}</loc>
            <lastmod>{{ $visit->updated_at ? $visit->updated_at->tz('UTC')->toAtomString() : now()->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.7</priority>
        </url>
    @endforeach

    <!-- Scientific Journals -->
    @foreach($journals as $journal)
        <url>
            <loc>{{ route('website.journals.show', $journal->slug) }}</loc>
            <lastmod>{{ $journal->updated_at ? $journal->updated_at->tz('UTC')->toAtomString() : now()->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach

    <!-- Scientific Articles (IGNITE) -->
    @foreach($articles as $art)
        <url>
            <loc>{{ route('website.articles.show', $art->slug) }}</loc>
            <lastmod>{{ $art->published_at ? \Illuminate\Support\Carbon::parse($art->published_at)->tz('UTC')->toAtomString() : ($art->updated_at ? $art->updated_at->tz('UTC')->toAtomString() : now()->tz('UTC')->toAtomString()) }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.9</priority>
        </url>
    @endforeach
</urlset>
