{!! '<' . '?xml version="1.0" encoding="UTF-8"?' . '>' !!}
<OAI-PMH xmlns="http://www.openarchives.org/OAI/2.0/"
         xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:schemaLocation="http://www.openarchives.org/OAI/2.0/ http://www.openarchives.org/OAI/2.0/OAI-PMH.xsd">
    <responseDate>{{ now()->format('Y-m-d\TH:i:s\Z') }}</responseDate>
    <request verb="{{ $verb }}" @if($metadataPrefix) metadataPrefix="{{ $metadataPrefix }}" @endif @if($identifier) identifier="{{ $identifier }}" @endif>{{ route('website.oai') }}</request>

    @if($verb === 'Identify')
        <Identify>
            <repositoryName>IGNITE Academic Publishing Repository - Yayasan Satriabudi Dharma Setia</repositoryName>
            <baseURL>{{ route('website.oai') }}</baseURL>
            <protocolVersion>2.0</protocolVersion>
            <adminEmail>editor@ignite.ysds.or.id</adminEmail>
            <earliestDatestamp>2020-01-01T00:00:00Z</earliestDatestamp>
            <deletedRecord>persistent</deletedRecord>
            <granularity>YYYY-MM-DDThh:mm:ssZ</granularity>
        </Identify>
    @elseif($verb === 'ListMetadataFormats')
        <ListMetadataFormats>
            <metadataFormat>
                <metadataPrefix>oai_dc</metadataPrefix>
                <schema>http://www.openarchives.org/OAI/2.0/oai_dc.xsd</schema>
                <metadataNamespace>http://www.openarchives.org/OAI/2.0/oai_dc/</metadataNamespace>
            </metadataFormat>
        </ListMetadataFormats>
    @elseif($verb === 'GetRecord')
        <GetRecord>
            @foreach($articles as $article)
                @php
                    $journal = $article->issue?->journal;
                    $authors = $article->submission?->authors ?? collect();
                @endphp
                <record>
                    <header>
                        <identifier>oai:ignite.ysds.or.id:article/{{ $article->id }}</identifier>
                        <datestamp>{{ ($article->published_at ?? $article->created_at)->format('Y-m-d\TH:i:s\Z') }}</datestamp>
                        <setSpec>{{ $journal?->slug ?? 'default' }}</setSpec>
                    </header>
                    <metadata>
                        <oai_dc:dc xmlns:oai_dc="http://www.openarchives.org/OAI/2.0/oai_dc/"
                                   xmlns:dc="http://purl.org/dc/elements/1.1/"
                                   xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                                   xsi:schemaLocation="http://www.openarchives.org/OAI/2.0/oai_dc/ http://www.openarchives.org/OAI/2.0/oai_dc.xsd">
                            <dc:title><![CDATA[{{ $article->title }}]]></dc:title>
                            @forelse($authors as $author)
                                <dc:creator><![CDATA[{{ $author->name }}]]></dc:creator>
                            @empty
                                @if($article->submission?->author)
                                    <dc:creator><![CDATA[{{ $article->submission->author->name }}]]></dc:creator>
                                @endif
                            @endforelse
                            @if(!empty($article->keywords) && is_array($article->keywords))
                                @foreach($article->keywords as $kw)
                                    <dc:subject><![CDATA[{{ trim($kw) }}]]></dc:subject>
                                @endforeach
                            @endif
                            <dc:description><![CDATA[{{ $article->abstract }}]]></dc:description>
                            <dc:publisher><![CDATA[Yayasan Satriabudi Dharma Setia]]></dc:publisher>
                            <dc:date>{{ ($article->published_at ?? $article->created_at)->format('Y-m-d') }}</dc:date>
                            <dc:type>info:eu-repo/semantics/article</dc:type>
                            <dc:type>text</dc:type>
                            <dc:format>application/pdf</dc:format>
                            <dc:identifier>{{ route('website.articles.show', $article->slug) }}</dc:identifier>
                            @if($article->doi)
                                <dc:identifier>doi:{{ $article->doi }}</dc:identifier>
                            @endif
                            @if($journal)
                                <dc:source><![CDATA[{{ $journal->name }}, Vol. {{ $article->issue?->volume }}, No. {{ $article->issue?->number }} ({{ $article->issue?->publication_year }})]]></dc:source>
                            @endif
                            <dc:language>id</dc:language>
                            <dc:rights>info:eu-repo/semantics/openAccess</dc:rights>
                            <dc:rights>Creative Commons Attribution 4.0 International</dc:rights>
                        </oai_dc:dc>
                    </metadata>
                </record>
            @endforeach
        </GetRecord>
    @else
        {{-- Default / ListRecords --}}
        <ListRecords>
            @foreach($articles as $article)
                @php
                    $journal = $article->issue?->journal;
                    $authors = $article->submission?->authors ?? collect();
                @endphp
                <record>
                    <header>
                        <identifier>oai:ignite.ysds.or.id:article/{{ $article->id }}</identifier>
                        <datestamp>{{ ($article->published_at ?? $article->created_at)->format('Y-m-d\TH:i:s\Z') }}</datestamp>
                        <setSpec>{{ $journal?->slug ?? 'default' }}</setSpec>
                    </header>
                    <metadata>
                        <oai_dc:dc xmlns:oai_dc="http://www.openarchives.org/OAI/2.0/oai_dc/"
                                   xmlns:dc="http://purl.org/dc/elements/1.1/"
                                   xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                                   xsi:schemaLocation="http://www.openarchives.org/OAI/2.0/oai_dc/ http://www.openarchives.org/OAI/2.0/oai_dc.xsd">
                            <dc:title><![CDATA[{{ $article->title }}]]></dc:title>
                            @forelse($authors as $author)
                                <dc:creator><![CDATA[{{ $author->name }}]]></dc:creator>
                            @empty
                                @if($article->submission?->author)
                                    <dc:creator><![CDATA[{{ $article->submission->author->name }}]]></dc:creator>
                                @endif
                            @endforelse
                            @if(!empty($article->keywords) && is_array($article->keywords))
                                @foreach($article->keywords as $kw)
                                    <dc:subject><![CDATA[{{ trim($kw) }}]]></dc:subject>
                                @endforeach
                            @endif
                            <dc:description><![CDATA[{{ $article->abstract }}]]></dc:description>
                            <dc:publisher><![CDATA[Yayasan Satriabudi Dharma Setia]]></dc:publisher>
                            <dc:date>{{ ($article->published_at ?? $article->created_at)->format('Y-m-d') }}</dc:date>
                            <dc:type>info:eu-repo/semantics/article</dc:type>
                            <dc:type>text</dc:type>
                            <dc:format>application/pdf</dc:format>
                            <dc:identifier>{{ route('website.articles.show', $article->slug) }}</dc:identifier>
                            @if($article->doi)
                                <dc:identifier>doi:{{ $article->doi }}</dc:identifier>
                            @endif
                            @if($journal)
                                <dc:source><![CDATA[{{ $journal->name }}, Vol. {{ $article->issue?->volume }}, No. {{ $article->issue?->number }} ({{ $article->issue?->publication_year }})]]></dc:source>
                            @endif
                            <dc:language>id</dc:language>
                            <dc:rights>info:eu-repo/semantics/openAccess</dc:rights>
                            <dc:rights>Creative Commons Attribution 4.0 International</dc:rights>
                        </oai_dc:dc>
                    </metadata>
                </record>
            @endforeach
        </ListRecords>
    @endif
</OAI-PMH>
