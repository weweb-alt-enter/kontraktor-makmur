<?php

namespace App\Http\Controllers;

use App\Models\PortofolioProyek;
use App\Models\Testimoni;

class AboutController extends Controller
{
    public function index()
    {
        $about = config('about');
        
        // Calculate dynamic stats
        $about['stats']['projects_completed'] = PortofolioProyek::where('status_proyek', 'selesai')->count();
        $about['stats']['happy_clients'] = Testimoni::where('is_published', true)->count();
        $about['stats']['total_area'] = PortofolioProyek::where('status_proyek', 'selesai')->sum('luas_bangunan');

        return view('frontend.about', compact('about'));
    }
}