<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisBangunan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JenisBangunanController extends Controller
{
    public function index()
    {
        $jenisBangunan = JenisBangunan::latest()->paginate(10);
        return view('admin.jenis-bangunan.index', compact('jenisBangunan'));
    }

    public function create()
    {
        return view('admin.jenis-bangunan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_bangunan' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
        ]);

        $validated['slug'] = Str::slug($validated['nama_bangunan']);

        JenisBangunan::create($validated);

        return redirect()->route('admin.jenis-bangunan.index')
            ->with('success', 'Jenis bangunan berhasil ditambahkan');
    }

    public function edit(JenisBangunan $jenisBangunan)
    {
        return view('admin.jenis-bangunan.edit', compact('jenisBangunan'));
    }

    public function update(Request $request, JenisBangunan $jenisBangunan)
    {
        $validated = $request->validate([
            'nama_bangunan' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
        ]);

        // Update slug jika nama berubah
        if ($jenisBangunan->nama_bangunan !== $validated['nama_bangunan']) {
            $baseSlug = Str::slug($validated['nama_bangunan']);
            $slug = $baseSlug;
            $counter = 1;
            
            while (JenisBangunan::where('slug', $slug)->where('id', '!=', $jenisBangunan->id)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            
            $validated['slug'] = $slug;
        }

        $jenisBangunan->update($validated);

        return redirect()->route('admin.jenis-bangunan.index')
            ->with('success', 'Jenis bangunan berhasil diupdate');
    }

    public function destroy(JenisBangunan $jenisBangunan)
    {
        $count = $jenisBangunan->portofolio()->count();
        
        if ($count > 0) {
            return redirect()->back()->with('error', 
                "Tidak bisa menghapus. Ada {$count} portofolio yang menggunakan jenis bangunan ini.");
        }

        $jenisBangunan->delete();

        return redirect()->route('admin.jenis-bangunan.index')
            ->with('success', 'Jenis bangunan berhasil dihapus');
    }
}