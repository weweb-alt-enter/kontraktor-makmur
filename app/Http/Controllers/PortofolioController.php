<?php

namespace App\Http\Controllers;

use App\Models\PortofolioProyek;
use App\Models\JenisLayanan;
use App\Models\JenisBangunan;
use App\Models\Konsultasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class PortofolioController extends Controller
{
    public function index(Request $request)
    {
        // HANYA tampilkan portofolio dengan status 'selesai'
        $query = PortofolioProyek::with(['jenisLayanan', 'jenisBangunan'])
            ->where('status_proyek', 'selesai'); // Filter publik

        // Filter by jenis layanan
        if ($request->filled('layanan')) {
            $query->whereIn('jenis_layanan_id', (array) $request->layanan);
        }

        // Filter by jenis bangunan
        if ($request->filled('bangunan')) {
            $query->whereIn('jenis_bangunan_id', (array) $request->bangunan);
        }

        // Filter by tahun
        if ($request->filled('tahun')) {
            $query->where('tahun_selesai', $request->tahun);
        }

        // Filter by budget range
        if ($request->filled('budget_min')) {
            $query->where('estimasi_budget', '>=', $request->budget_min);
        }
        if ($request->filled('budget_max')) {
            $query->where('estimasi_budget', '<=', $request->budget_max);
        }

        // Filter by lokasi
        if ($request->filled('lokasi')) {
            $query->where('lokasi', 'like', '%' . $request->lokasi . '%');
        }

        $portofolios = $query->latest()->paginate(12)->appends($request->all());

        $jenisLayanan = JenisLayanan::all();
        $jenisBangunan = JenisBangunan::all();
        $tahunRange = range(2020, 2026);

        // Data for map - hanya yang punya koordinat dan status selesai
        $mapData = $query->whereNotNull('koordinat_lat')
            ->whereNotNull('koordinat_lng')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nama' => $item->nama_proyek,
                    'lat' => (float) $item->koordinat_lat,
                    'lng' => (float) $item->koordinat_lng,
                    'layanan' => $item->jenisLayanan?->nama_layanan,
                    'url' => route('portofolio.detail', $item->slug),
                ];
            });

        return view('frontend.portofolio-index', compact(
            'portofolios',
            'jenisLayanan',
            'jenisBangunan',
            'tahunRange',
            'mapData'
        ));
    }

    public function detail($slug)
    {
        // HANYA tampilkan portofolio dengan status 'selesai' untuk publik
        $portofolio = PortofolioProyek::with([
            'jenisLayanan', 
            'jenisBangunan', 
            'galleries' => function($q) {
                $q->orderBy('sort_order');
            },
            'testimoni' => function($q) {
                $q->where('is_published', true);
            }
        ])
        ->where('slug', $slug)
        ->where('status_proyek', 'selesai') // HANYA yang selesai/published
        ->first();

        // Jika tidak ditemukan atau bukan status selesai, tampilkan 404
        if (!$portofolio) {
            abort(404, 'Proyek tidak ditemukan atau belum dipublikasikan.');
        }

        $jenisLayanan = JenisLayanan::all();
        
        // Check if favorited
        $sessionId = Cookie::get('session_id');
        $isFavorited = false;
        if ($sessionId) {
            $isFavorited = $portofolio->favorit()
                ->where('session_id', $sessionId)
                ->exists();
        }

        return view('frontend.portofolio-detail', compact(
            'portofolio', 
            'jenisLayanan', 
            'isFavorited'
        ));
    }

    public function storeKonsultasi(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'no_wa' => 'required|string|max:20',
            'deskripsi' => 'required|string|min:10',
            'source_type' => 'nullable|string|in:portofolio,inspirasi',
            'source_slug' => 'nullable|string',
            'source_judul' => 'nullable|string',
        ]);

        Konsultasi::create($validated + ['status' => 'pending']);

        \Log::info('Konsultasi baru diterima', $validated);

        return redirect()->back()->with('success', 
            'Terima kasih, tim kami akan menghubungi Anda dalam 1x24 jam');
    }
}