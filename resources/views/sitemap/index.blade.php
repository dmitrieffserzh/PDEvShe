<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <sitemap>
        <loc>{{ url('main.xml') }}</loc>
        <lastmod>{{ $main->updated_at->toAtomString() }}</lastmod>
    </sitemap>
    <sitemap>
        <loc>{{ url('articles.xml') }}</loc>
        <lastmod>{{ $articles->updated_at->toAtomString() }}</lastmod>
    </sitemap>
    <sitemap>
        <loc>{{ url('pages.xml') }}</loc>
        <lastmod>{{ $pages->updated_at->toAtomString() }}</lastmod>
    </sitemap>
    <sitemap>
        <loc>{{ url('profiles.xml') }}</loc>
        <lastmod>{{ $profiles->updated_at->toAtomString() }}</lastmod>
    </sitemap>
</sitemapindex>