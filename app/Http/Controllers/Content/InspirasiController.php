<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\InspirasiDesain;
use App\Models\InspirasiDesainGallery;
use App\Helpers\StorageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class InspirasiController extends Controller
{
    public function index()
    {
        $inspirasi = InspirasiDesain::with('creator')
            ->where('created_by', auth()->id())
            ->latest()
            ->paginate(10);

        return view('content.inspirasi.index', compact('inspirasi'));
    }

    public function create()
    {
        return view('content.inspirasi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => [
                'required', 'string', 'max:255',
                function ($attribute, $value, $fail) {
                    $slug = Str::slug($value);
                    if (InspirasiDesain::where('slug', $slug)->exists()) {
                        $fail('Judul "' . $value . '" sudah digunakan. Silakan gunakan judul yang berbeda.');
                    }
                },
            ],
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'kategori_id' => 'nullable|exists:kategori_inspirasi,id',
            'konsep_id' => 'nullable|exists:konsep_inspirasi,id',
            'warna_dominan' => 'nullable|string|max:200',
            'estimasi_biaya' => 'nullable|integer|min:0',
            'tags' => 'nullable|string|max:255',
            'is_published' => 'boolean',
            'galleries.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'gallery_captions.*' => 'nullable|string|max:255',
        ]);

        $validated['slug'] = Str::slug($validated['judul']);
        $validated['created_by'] = auth()->id();
        $validated['is_published'] = $request->boolean('is_published');

        if ($validated['is_published']) {
            $validated['published_at'] = now();
        }

        // Handle featured image with flexible storage
        if ($request->hasFile('gambar')) {
            $uploaded = StorageHelper::upload($request->file('gambar'), 'inspirasi');
            $validated['gambar'] = $uploaded['path'];
        }

        $inspirasi = InspirasiDesain::create($validated);

        // Handle gallery images
        if ($request->hasFile('galleries')) {
            foreach ($request->file('galleries') as $index => $image) {
                if ($image && $image->isValid()) {
                    $uploaded = StorageHelper::upload($image, 'inspirasi/' . $inspirasi->id);
                    
                    InspirasiDesainGallery::create([
                        'inspirasi_id' => $inspirasi->id,
                        'image_path' => $uploaded['path'],
                        'caption' => $request->gallery_captions[$index] ?? null,
                        'sort_order' => $index,
                    ]);
                }
            }
        }

        return redirect()->route('content.inspirasi.index')
            ->with('success', 'Inspirasi desain "' . $validated['judul'] . '" berhasil ditambahkan! 🎉');
    }

    public function edit(InspirasiDesain $inspirasi)
    {
        if ($inspirasi->created_by !== auth()->id()) {
            abort(403);
        }

        return view('content.inspirasi.edit', compact('inspirasi'));
    }

    public function update(Request $request, InspirasiDesain $inspirasi)
    {
        if ($inspirasi->created_by !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'judul' => [
                'required', 'string', 'max:255',
                function ($attribute, $value, $fail) use ($inspirasi) {
                    $slug = Str::slug($value);
                    $exists = InspirasiDesain::where('slug', $slug)
                        ->where('id', '!=', $inspirasi->id)
                        ->exists();
                    if ($exists) {
                        $fail('Judul "' . $value . '" sudah digunakan. Silakan gunakan judul yang berbeda.');
                    }
                },
            ],
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'kategori_id' => 'nullable|exists:kategori_inspirasi,id',
            'konsep_id' => 'nullable|exists:konsep_inspirasi,id',
            'warna_dominan' => 'nullable|string|max:200',
            'estimasi_biaya' => 'nullable|integer|min:0',
            'tags' => 'nullable|string|max:255',
            'is_published' => 'boolean',
            'galleries.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'gallery_captions.*' => 'nullable|string|max:255',
        ]);

        if ($inspirasi->judul !== $validated['judul']) {
            $validated['slug'] = Str::slug($validated['judul']);
        }

        $wasPublished = $inspirasi->is_published;
        $validated['is_published'] = $request->boolean('is_published');

        if ($validated['is_published'] && !$wasPublished) {
            $validated['published_at'] = now();
        }
        if (!$validated['is_published']) {
            $validated['published_at'] = null;
        }

        // Handle featured image
        if ($request->hasFile('gambar')) {
            if ($inspirasi->gambar) {
                StorageHelper::delete($inspirasi->gambar);
            }
            $uploaded = StorageHelper::upload($request->file('gambar'), 'inspirasi');
            $validated['gambar'] = $uploaded['path'];
        }

        $inspirasi->update($validated);

        // Handle new gallery images
        if ($request->hasFile('galleries')) {
            foreach ($request->file('galleries') as $index => $image) {
                if ($image && $image->isValid()) {
                    $uploaded = StorageHelper::upload($image, 'inspirasi/' . $inspirasi->id);
                    
                    InspirasiDesainGallery::create([
                        'inspirasi_id' => $inspirasi->id,
                        'image_path' => $uploaded['path'],
                        'caption' => $request->gallery_captions[$index] ?? null,
                        'sort_order' => $inspirasi->galleries()->count(),
                    ]);
                }
            }
        }

        return redirect()->route('content.inspirasi.index')
            ->with('success', 'Inspirasi desain berhasil diupdate! ✅');
    }

    public function destroy(InspirasiDesain $inspirasi)
    {
        if ($inspirasi->created_by !== auth()->id()) {
            abort(403);
        }

        // Delete featured image
        if ($inspirasi->gambar) {
            StorageHelper::delete($inspirasi->gambar);
        }

        // Delete gallery images
        foreach ($inspirasi->galleries as $gallery) {
            StorageHelper::delete($gallery->image_path);
        }

        $inspirasi->delete();

        return redirect()->route('content.inspirasi.index')
            ->with('success', 'Inspirasi desain berhasil dihapus');
    }

    public function deleteGallery(InspirasiDesainGallery $gallery)
    {
        if ($gallery->inspirasi->created_by !== auth()->id()) {
            abort(403);
        }

        StorageHelper::delete($gallery->image_path);
        $gallery->delete();

        return response()->json(['success' => true]);
    }
}