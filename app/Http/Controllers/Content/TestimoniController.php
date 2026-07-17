<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\Testimoni;
use App\Models\PortofolioProyek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimoniController extends Controller
{
    public function index()
    {
        $testimonis = Testimoni::with('portofolio')
            ->latest()
            ->paginate(10);

        return view('content.testimoni.index', compact('testimonis'));
    }

    public function create()
    {
        $portofolios = PortofolioProyek::where('created_by', auth()->id())
            ->where('status_proyek', 'selesai')
            ->get();

        return view('content.testimoni.create', compact('portofolios'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_client' => 'required|string|max:255',
            'isi_testimoni' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'portofolio_id' => 'nullable|exists:portofolio_proyek,id',
            'is_published' => 'boolean',
            'foto_client' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $validated['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('foto_client')) {
            $validated['foto_client'] = $request->file('foto_client')
                ->store('testimoni', 'public');
        }

        Testimoni::create($validated);

        return redirect()->route('content.testimoni.index')
            ->with('success', 'Testimoni berhasil ditambahkan');
    }

    public function edit(Testimoni $testimoni)
    {
        $portofolios = PortofolioProyek::where('created_by', auth()->id())
            ->where('status_proyek', 'selesai')
            ->get();

        return view('content.testimoni.edit', compact('testimoni', 'portofolios'));
    }

    public function update(Request $request, Testimoni $testimoni)
    {
        $validated = $request->validate([
            'nama_client' => 'required|string|max:255',
            'isi_testimoni' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'portofolio_id' => 'nullable|exists:portofolio_proyek,id',
            'is_published' => 'boolean',
            'foto_client' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $validated['is_published'] = $request->boolean('is_published');

        if ($request->hasFile('foto_client')) {
            if ($testimoni->foto_client) {
                Storage::disk('public')->delete($testimoni->foto_client);
            }
            $validated['foto_client'] = $request->file('foto_client')
                ->store('testimoni', 'public');
        }

        $testimoni->update($validated);

        return redirect()->route('content.testimoni.index')
            ->with('success', 'Testimoni berhasil diupdate');
    }

    public function destroy(Testimoni $testimoni)
    {
        if ($testimoni->foto_client) {
            Storage::disk('public')->delete($testimoni->foto_client);
        }

        $testimoni->delete();

        return redirect()->route('content.testimoni.index')
            ->with('success', 'Testimoni berhasil dihapus');
    }
}