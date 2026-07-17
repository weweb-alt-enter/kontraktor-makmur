<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriInspirasi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriInspirasiController extends Controller
{
    public function index()
    {
        $kategori = KategoriInspirasi::latest()->paginate(10);
        return view('admin.kategori-inspirasi.index', compact('kategori'));
    }

    public function create()
    {
        return view('admin.kategori-inspirasi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
        ]);

        $validated['slug'] = Str::slug($validated['nama_kategori']);
        KategoriInspirasi::create($validated);

        return redirect()->route('admin.kategori-inspirasi.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(KategoriInspirasi $kategoriInspirasi)
    {
        return view('admin.kategori-inspirasi.edit', compact('kategoriInspirasi'));
    }

    public function update(Request $request, KategoriInspirasi $kategoriInspirasi)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
        ]);

        if ($kategoriInspirasi->nama_kategori !== $validated['nama_kategori']) {
            $validated['slug'] = Str::slug($validated['nama_kategori']);
        }

        $kategoriInspirasi->update($validated);

        return redirect()->route('admin.kategori-inspirasi.index')
            ->with('success', 'Kategori berhasil diupdate');
    }

    public function destroy(KategoriInspirasi $kategoriInspirasi)
    {
        $count = $kategoriInspirasi->inspirasi()->count();
        if ($count > 0) {
            return redirect()->back()->with('error', 
                "Tidak bisa menghapus. Ada {$count} inspirasi desain yang menggunakan kategori ini.");
        }

        $kategoriInspirasi->delete();
        return redirect()->route('admin.kategori-inspirasi.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
}