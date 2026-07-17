<?php

namespace App\Http\Controllers;

use App\Models\PortofolioProyek;
use App\Models\Blog;
use App\Models\InspirasiDesain;
use App\Models\Testimoni;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q');
        
        $portofolios = collect();
        $blogs = collect();
        $inspirasi = collect();
        $testimonis = collect();
        
        $totalResults = 0;

        if ($query) {
            // Portofolio - hanya yang status selesai
            $portofolios = PortofolioProyek::with(['jenisLayanan', 'jenisBangunan'])
                ->where(function ($q) use ($query) {
                    $q->where('nama_proyek', 'like', "%{$query}%")
                      ->orWhere('lokasi', 'like', "%{$query}%")
                      ->orWhere('deskripsi', 'like', "%{$query}%")
                      ->orWhere('klien_nama', 'like', "%{$query}%")
                      ->orWhereHas('jenisLayanan', function($q) use ($query) {
                          $q->where('nama_layanan', 'like', "%{$query}%");
                      })
                      ->orWhereHas('jenisBangunan', function($q) use ($query) {
                          $q->where('nama_bangunan', 'like', "%{$query}%");
                      });
                })
                ->where('status_proyek', 'selesai')
                ->latest()
                ->paginate(12, ['*'], 'portofolio_page')
                ->appends(['q' => $query, 'tab' => 'portofolio']);

            // Blog - hanya yang published
            $blogs = Blog::published()
                ->where(function ($q) use ($query) {
                    $q->where('judul', 'like', "%{$query}%")
                      ->orWhere('konten', 'like', "%{$query}%")
                      ->orWhere('excerpt', 'like', "%{$query}%")
                      ->orWhere('tags', 'like', "%{$query}%");
                })
                ->latest('published_at')
                ->paginate(12, ['*'], 'blog_page')
                ->appends(['q' => $query, 'tab' => 'blog']);

            // Inspirasi Desain - hanya yang published
            $inspirasi = InspirasiDesain::with(['kategori', 'konsep'])
                ->published()
                ->where(function ($q) use ($query) {
                    $q->where('judul', 'like', "%{$query}%")
                      ->orWhere('deskripsi', 'like', "%{$query}%")
                      ->orWhere('tags', 'like', "%{$query}%")
                      ->orWhere('warna_dominan', 'like', "%{$query}%")
                      ->orWhereHas('kategori', function($q) use ($query) {
                          $q->where('nama_kategori', 'like', "%{$query}%");
                      })
                      ->orWhereHas('konsep', function($q) use ($query) {
                          $q->where('nama_konsep', 'like', "%{$query}%");
                      });
                })
                ->latest('published_at')
                ->paginate(12, ['*'], 'inspirasi_page')
                ->appends(['q' => $query, 'tab' => 'inspirasi']);

            // Testimoni - hanya yang published
            $testimonis = Testimoni::with('portofolio')
                ->where('is_published', true)
                ->where(function ($q) use ($query) {
                    $q->where('nama_client', 'like', "%{$query}%")
                      ->orWhere('isi_testimoni', 'like', "%{$query}%");
                })
                ->latest()
                ->paginate(12, ['*'], 'testimoni_page')
                ->appends(['q' => $query, 'tab' => 'testimoni']);

            // Hitung total results
            $totalResults = $portofolios->total() + $blogs->total() + $inspirasi->total() + $testimonis->total();
        }

        return view('frontend.search-results', compact(
            'portofolios', 'blogs', 'inspirasi', 'testimonis', 'query', 'totalResults'
        ));
    }
}