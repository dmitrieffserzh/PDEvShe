<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <sitemap>
        <loc>{{ url('sitemap/articles') }}</loc>
        <lastmod>{{ $articles->updated_at->toAtomString() }}</lastmod>
    </sitemap>
    <sitemap>
        <loc>{{ url('sitemap/pages') }}</loc>
        <lastmod>{{ $pages->updated_at->toAtomString() }}</lastmod>
    </sitemap>
    <sitemap>
        <loc>{{ url('sitemap/profiles') }}</loc>
        <lastmod>{{ $profiles->updated_at->toAtomString() }}</lastmod>
    </sitemap>
</sitemapindex>