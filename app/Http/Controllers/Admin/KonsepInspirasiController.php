<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KonsepInspirasi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KonsepInspirasiController extends Controller
{
    public function index()
    {
        $konsep = KonsepInspirasi::latest()->paginate(10);
        return view('admin.konsep-inspirasi.index', compact('konsep'));
    }

    public function create()
    {
        return view('admin.konsep-inspirasi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_konsep' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
        ]);

        $validated['slug'] = Str::slug($validated['nama_konsep']);
        KonsepInspirasi::create($validated);

        return redirect()->route('admin.konsep-inspirasi.index')
            ->with('success', 'Konsep berhasil ditambahkan');
    }

    public function edit(KonsepInspirasi $konsepInspirasi)
    {
        return view('admin.konsep-inspirasi.edit', compact('konsepInspirasi'));
    }

    public function update(Request $request, KonsepInspirasi $konsepInspirasi)
    {
        $validated = $request->validate([
            'nama_konsep' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
        ]);

        if ($konsepInspirasi->nama_konsep !== $validated['nama_konsep']) {
            $validated['slug'] = Str::slug($validated['nama_konsep']);
        }

        $konsepInspirasi->update($validated);

        return redirect()->route('admin.konsep-inspirasi.index')
            ->with('success', 'Konsep berhasil diupdate');
    }

    public function destroy(KonsepInspirasi $konsepInspirasi)
    {
        $count = $konsepInspirasi->inspirasi()->count();
        if ($count > 0) {
            return redirect()->back()->with('error', 
                "Tidak bisa menghapus. Ada {$count} inspirasi desain yang menggunakan konsep ini.");
        }

        $konsepInspirasi->delete();
        return redirect()->route('admin.konsep-inspirasi.index')
            ->with('success', 'Konsep berhasil dihapus');
    }
}