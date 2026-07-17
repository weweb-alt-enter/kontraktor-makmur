<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\PortofolioProyek;
use App\Models\Blog;
use App\Models\InspirasiDesain;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        
        $stats = [
            'total_portofolio' => PortofolioProyek::where('created_by', $userId)->count(),
            'total_blog' => Blog::where('created_by', $userId)->count(),
            'total_inspirasi' => InspirasiDesain::where('created_by', $userId)->count(),
        ];

        return view('content.dashboard', compact('stats'));
    }
}