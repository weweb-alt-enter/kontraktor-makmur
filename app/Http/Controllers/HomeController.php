<?php

namespace App\Http\Controllers;

use App\Models\PortofolioProyek;
use App\Models\JenisLayanan;
use App\Models\Testimoni;
use App\Models\InspirasiDesain;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Portofolio Unggulan
        $featuredPortofolio = PortofolioProyek::with(['jenisLayanan', 'jenisBangunan'])
            ->where('is_featured', true)
            ->where('status_proyek', 'selesai')
            ->latest()
            ->take(6)
            ->get();

        // Inspirasi Desain Terbaru (menggantikan Proyek Terbaru)
        $latestInspirasi = InspirasiDesain::with('creator')
            ->published()
            ->latest('published_at')
            ->take(6)
            ->get();

        $jenisLayanan = JenisLayanan::all();

        // Statistics
        $totalProyek = PortofolioProyek::where('status_proyek', 'selesai')->count();
        $totalKlien = Testimoni::where('is_published', true)->count();
        $totalLuas = PortofolioProyek::where('status_proyek', 'selesai')->sum('luas_bangunan');

        return view('frontend.home', compact(
            'featuredPortofolio', 
            'latestInspirasi', 
            'jenisLayanan',
            'totalProyek',
            'totalKlien',
            'totalLuas'
        ));
    }
}