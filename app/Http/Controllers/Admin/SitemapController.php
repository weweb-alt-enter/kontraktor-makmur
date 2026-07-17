<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortofolioProyek;
use App\Models\InspirasiDesain;
use App\Models\Blog;

class SitemapController extends Controller
{
    public function generate()
    {
        try {
            $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');

            // Static pages
            $staticPages = [
                ['url' => route('home'), 'priority' => '1.0', 'changefreq' => 'daily'],
                ['url' => route('portofolio.index'), 'priority' => '0.9', 'changefreq' => 'weekly'],
                ['url' => route('about'), 'priority' => '0.7', 'changefreq' => 'monthly'],
                ['url' => route('contact'), 'priority' => '0.7', 'changefreq' => 'monthly'],
                ['url' => route('testimonials'), 'priority' => '0.6', 'changefreq' => 'weekly'],
                ['url' => route('blog.index'), 'priority' => '0.8', 'changefreq' => 'weekly'],
            ];

            foreach ($staticPages as $page) {
                $url = $xml->addChild('url');
                $url->addChild('loc', $page['url']);
                $url->addChild('changefreq', $page['changefreq']);
                $url->addChild('priority', $page['priority']);
            }

            // Portofolio pages - HANYA yang status selesai
            $portofolios = PortofolioProyek::where('status_proyek', 'selesai')->get();
            foreach ($portofolios as $portofolio) {
                $url = $xml->addChild('url');
                $url->addChild('loc', route('portofolio.detail', $portofolio->slug));
                $url->addChild('lastmod', $portofolio->updated_at->toAtomString());
                $url->addChild('changefreq', 'monthly');
                $url->addChild('priority', '0.8');
            }

            // Blog pages - hanya yang published
            $blogs = Blog::published()->get();
            foreach ($blogs as $blog) {
                $url = $xml->addChild('url');
                $url->addChild('loc', route('blog.show', $blog->slug));
                $url->addChild('lastmod', $blog->updated_at->toAtomString());
                $url->addChild('changefreq', 'monthly');
                $url->addChild('priority', '0.7');
            }

            // Inspirasi Desain pages
            $inspirasis = InspirasiDesain::get();
            foreach ($inspirasis as $inspirasi) {
                $url = $xml->addChild('url');
                $url->addChild('loc', route('inspirasi.index', $inspirasi->slug));
                $url->addChild('lastmod', $inspirasi->updated_at->toAtomString());
                $url->addChild('changefreq', 'weekly');
                $url->addChild('priority', '0.6');
            }

            $xml->asXML(public_path('sitemap.xml'));

            return redirect()->route('admin.dashboard')
                ->with('success', 'Sitemap berhasil digenerate!');
        } catch (\Exception $e) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Gagal generate sitemap: ' . $e->getMessage());
        }
    }
}