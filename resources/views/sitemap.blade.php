<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    {{-- Static pages --}}
    @foreach($staticUrls as $url)
        <url>
            <loc>{{ $url }}</loc>
            <lastmod>{{ now()->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.9</priority>
        </url>
    @endforeach

    {{-- Marker groups --}}
    @foreach($groups as $group)
        <url>
            <loc>{{ url('/markers/groups/' . $group->slug) }}</loc>

            <lastmod>
                {{ $group->updated_at?->toAtomString() ?? now()->toAtomString() }}
            </lastmod>

            <changefreq>weekly</changefreq>

            <priority>0.8</priority>
        </url>
    @endforeach

    {{-- Marker pages --}}
    @foreach($markers as $marker)
        <url>
            <loc>{{ url('/markers/' . $marker->slug) }}</loc>

            <lastmod>
                {{ $marker->updated_at?->toAtomString() ?? now()->toAtomString() }}
            </lastmod>

            <changefreq>weekly</changefreq>

            <priority>0.8</priority>
        </url>
    @endforeach

    {{-- Plans --}}
    @foreach($plans as $plan)
        <url>
            <loc>{{ url('/plans/' . $plan->slug) }}</loc>

            <lastmod>
                {{ $plan->updated_at?->toAtomString() ?? now()->toAtomString() }}
            </lastmod>

            <changefreq>weekly</changefreq>

            <priority>0.7</priority>
        </url>
    @endforeach

</urlset>