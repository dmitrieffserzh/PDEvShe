<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($profiles as $profile)
        <url>
            <loc>{{ route('catalog.profile', ['section' => \App\Helpers::getGirlSectionUrlValue($profile->section), 'slug' => $profile->slug] ) }}</loc>
            <lastmod>{{ $profile->updated_at->toAtomString() }}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>1.0</priority>
        </url>
    @endforeach
</urlset>