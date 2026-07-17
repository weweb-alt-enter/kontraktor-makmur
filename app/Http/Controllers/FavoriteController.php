<?php

namespace App\Http\Controllers;

use App\Models\Favorit;
use App\Models\PortofolioProyek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        $sessionId = Cookie::get('session_id');
        
        if (!$sessionId) {
            return view('frontend.favorites', ['favorites' => collect()]);
        }

        // HANYA tampilkan favorit yang portofolionya masih published (status selesai)
        $favorites = Favorit::with(['portofolio' => function($q) {
                $q->where('status_proyek', 'selesai'); // Filter hanya yang published
            }, 'portofolio.jenisLayanan', 'portofolio.jenisBangunan'])
            ->where('session_id', $sessionId)
            ->whereHas('portofolio', function($q) {
                $q->where('status_proyek', 'selesai'); // Hanya yang status selesai
            })
            ->latest()
            ->get();

        return view('frontend.favorites', compact('favorites'));
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'portofolio_id' => 'required|exists:portofolio_proyek,id',
        ]);

        $sessionId = Cookie::get('session_id');
        
        if (!$sessionId) {
            return response()->json(['error' => 'Session not found'], 400);
        }

        $favorit = Favorit::where('session_id', $sessionId)
            ->where('portofolio_id', $request->portofolio_id)
            ->first();

        if ($favorit) {
            $favorit->delete();
            $isFavorited = false;
        } else {
            Favorit::create([
                'session_id' => $sessionId,
                'portofolio_id' => $request->portofolio_id,
            ]);
            $isFavorited = true;
        }

        return response()->json([
            'success' => true,
            'is_favorited' => $isFavorited,
            'count' => Favorit::where('session_id', $sessionId)->count(),
        ]);
    }

    public function remove(Request $request)
    {
        $request->validate([
            'portofolio_id' => 'required|exists:portofolio_proyek,id',
        ]);

        $sessionId = Cookie::get('session_id');
        
        if ($sessionId) {
            Favorit::where('session_id', $sessionId)
                ->where('portofolio_id', $request->portofolio_id)
                ->delete();
        }

        return redirect()->back()->with('success', 'Proyek dihapus dari favorit');
    }
}