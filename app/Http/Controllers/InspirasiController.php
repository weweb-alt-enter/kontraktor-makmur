<?php

namespace App\Http\Controllers;

use App\Models\InspirasiDesain;
use Illuminate\Http\Request;

class InspirasiController extends Controller
{
    public function index(Request $request)
    {
        $query = InspirasiDesain::with('creator')->published();

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter konsep
        if ($request->filled('konsep')) {
            $query->where('konsep', $request->konsep);
        }

        $inspirasi = $query->latest('published_at')->paginate(12)->appends($request->all());

        // Get unique kategori & konsep untuk filter
        $kategoriList = InspirasiDesain::published()
            ->whereNotNull('kategori')
            ->distinct()
            ->pluck('kategori');
            
        $konsepList = InspirasiDesain::published()
            ->whereNotNull('konsep')
            ->distinct()
            ->pluck('konsep');

        return view('frontend.inspirasi-index', compact('inspirasi', 'kategoriList', 'konsepList'));
    }

    public function show($slug)
    {
        $inspirasi = InspirasiDesain::with(['creator', 'galleries'])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedInspirasi = InspirasiDesain::published()
            ->where('id', '!=', $inspirasi->id)
            ->where(function($q) use ($inspirasi) {
                $q->where('kategori', $inspirasi->kategori)
                  ->orWhere('konsep', $inspirasi->konsep);
            })
            ->latest('published_at')
            ->take(4)
            ->get();

        return view('frontend.inspirasi-show', compact('inspirasi', 'relatedInspirasi'));
    }
}