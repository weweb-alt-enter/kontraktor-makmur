<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisLayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JenisLayananController extends Controller
{
    public function index()
    {
        $jenisLayanan = JenisLayanan::latest()->paginate(10);
        return view('admin.jenis-layanan.index', compact('jenisLayanan'));
    }

    public function create()
    {
        return view('admin.jenis-layanan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
        ]);

        $validated['slug'] = Str::slug($validated['nama_layanan']);

        JenisLayanan::create($validated);

        return redirect()->route('admin.jenis-layanan.index')
            ->with('success', 'Jenis layanan berhasil ditambahkan');
    }

    public function edit(JenisLayanan $jenisLayanan)
    {
        return view('admin.jenis-layanan.edit', compact('jenisLayanan'));
    }

    public function update(Request $request, JenisLayanan $jenisLayanan)
    {
        $validated = $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
        ]);

        // Update slug jika nama berubah
        if ($jenisLayanan->nama_layanan !== $validated['nama_layanan']) {
            $baseSlug = Str::slug($validated['nama_layanan']);
            $slug = $baseSlug;
            $counter = 1;
            
            while (JenisLayanan::where('slug', $slug)->where('id', '!=', $jenisLayanan->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            
            $validated['slug'] = $slug;
        }

        $jenisLayanan->update($validated);

        return redirect()->route('admin.jenis-layanan.index')
            ->with('success', 'Jenis layanan berhasil diupdate');
    }

    public function destroy(JenisLayanan $jenisLayanan)
    {
        // Cek apakah ada portofolio yang menggunakan layanan ini
        $count = $jenisLayanan->portofolio()->count();
        
        if ($count > 0) {
            return redirect()->back()->with('error', 
                "Tidak bisa menghapus. Ada {$count} portofolio yang menggunakan layanan ini.");
        }

        $jenisLayanan->delete();

        return redirect()->route('admin.jenis-layanan.index')
            ->with('success', 'Jenis layanan berhasil dihapus');
    }
}