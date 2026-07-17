<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\PortofolioProyek;
use App\Models\PortofolioGallery;
use App\Models\JenisLayanan;
use App\Models\JenisBangunan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PortofolioController extends Controller
{
    public function index()
    {
        $portofolios = PortofolioProyek::with(['jenisLayanan', 'jenisBangunan'])
            ->where('created_by', auth()->id())
            ->latest()
            ->paginate(10);

        return view('content.portofolio.index', compact('portofolios'));
    }

    public function create()
    {
        $jenisLayanan = JenisLayanan::all();
        $jenisBangunan = JenisBangunan::all();
        
        return view('content.portofolio.create', compact('jenisLayanan', 'jenisBangunan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_proyek' => [
                'required',
                'string',
                'max:255',
                // Custom validation rule untuk cek slug unik
                function ($attribute, $value, $fail) {
                    $slug = Str::slug($value);
                    if (PortofolioProyek::where('slug', $slug)->exists()) {
                        $fail('Nama proyek "' . $value . '" sudah digunakan. Silakan gunakan nama yang berbeda.');
                    }
                },
            ],
            'jenis_layanan_id' => 'nullable|exists:jenis_layanan,id',
            'jenis_bangunan_id' => 'nullable|exists:jenis_bangunan,id',
            'estimasi_budget' => 'nullable|numeric|min:0',
            'lokasi' => 'required|string',
            'koordinat_lat' => 'nullable|numeric|between:-90,90',
            'koordinat_lng' => 'nullable|numeric|between:-180,180',
            'luas_bangunan' => 'nullable|integer|min:0',
            'durasi_pengerjaan' => 'nullable|string|max:100',
            'tahun_selesai' => 'nullable|digits:4|integer|min:1900|max:' . (date('Y') + 5),
            'klien_nama' => 'nullable|string|max:255',
            'deskripsi' => 'required|string',
            'status_proyek' => 'required|in:selesai,berjalan,direncanakan',
            'is_featured' => 'boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'image_captions.*' => 'nullable|string|max:255',
            'is_before.*' => 'nullable|boolean',
        ], [
            // Custom error messages
            'nama_proyek.required' => 'Nama proyek wajib diisi.',
            'nama_proyek.max' => 'Nama proyek maksimal 255 karakter.',
            'lokasi.required' => 'Lokasi proyek wajib diisi.',
            'deskripsi.required' => 'Deskripsi proyek wajib diisi.',
            'images.*.image' => 'File harus berupa gambar.',
            'images.*.mimes' => 'Format gambar harus JPG, PNG, atau WebP.',
            'images.*.max' => 'Ukuran gambar maksimal 5MB.',
        ]);

        $validated['slug'] = Str::slug($validated['nama_proyek']);
        $validated['created_by'] = auth()->id();
        $validated['is_featured'] = $request->boolean('is_featured');

        $portofolio = PortofolioProyek::create($validated);

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                if ($image && $image->isValid()) {
                    $path = $image->store('portofolio/' . $portofolio->id, 'public');
                    
                    PortofolioGallery::create([
                        'portofolio_id' => $portofolio->id,
                        'image_path' => $path,
                        'caption' => $request->image_captions[$index] ?? null,
                        'is_before' => $request->has('is_before') && isset($request->is_before[$index]) ? true : false,
                        'sort_order' => $index,
                    ]);
                }
            }
        }

        return redirect()->route('content.portofolio.index')
            ->with('success', 'Portofolio "' . $validated['nama_proyek'] . '" berhasil ditambahkan! 🎉');
    }

    public function edit(PortofolioProyek $portofolio)
    {
        if ($portofolio->created_by !== auth()->id()) {
            abort(403);
        }

        $jenisLayanan = JenisLayanan::all();
        $jenisBangunan = JenisBangunan::all();
        
        return view('content.portofolio.edit', compact('portofolio', 'jenisLayanan', 'jenisBangunan'));
    }

    public function update(Request $request, PortofolioProyek $portofolio)
    {
        if ($portofolio->created_by !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'nama_proyek' => [
                'required',
                'string',
                'max:255',
                // Custom validation untuk update (abaikan slug milik sendiri)
                function ($attribute, $value, $fail) use ($portofolio) {
                    $slug = Str::slug($value);
                    $exists = PortofolioProyek::where('slug', $slug)
                        ->where('id', '!=', $portofolio->id)
                        ->exists();
                    
                    if ($exists) {
                        $fail('Nama proyek "' . $value . '" sudah digunakan oleh proyek lain. Silakan gunakan nama yang berbeda.');
                    }
                },
            ],
            'jenis_layanan_id' => 'nullable|exists:jenis_layanan,id',
            'jenis_bangunan_id' => 'nullable|exists:jenis_bangunan,id',
            'estimasi_budget' => 'nullable|numeric|min:0',
            'lokasi' => 'required|string',
            'koordinat_lat' => 'nullable|numeric|between:-90,90',
            'koordinat_lng' => 'nullable|numeric|between:-180,180',
            'luas_bangunan' => 'nullable|integer|min:0',
            'durasi_pengerjaan' => 'nullable|string|max:100',
            'tahun_selesai' => 'nullable|digits:4|integer|min:1900|max:' . (date('Y') + 5),
            'klien_nama' => 'nullable|string|max:255',
            'deskripsi' => 'required|string',
            'status_proyek' => 'required|in:selesai,berjalan,direncanakan',
            'is_featured' => 'boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'image_captions.*' => 'nullable|string|max:255',
            'is_before.*' => 'nullable|boolean',
        ], [
            'nama_proyek.required' => 'Nama proyek wajib diisi.',
            'lokasi.required' => 'Lokasi proyek wajib diisi.',
            'deskripsi.required' => 'Deskripsi proyek wajib diisi.',
        ]);

        // Update slug jika nama berubah
        if ($portofolio->nama_proyek !== $validated['nama_proyek']) {
            $validated['slug'] = Str::slug($validated['nama_proyek']);
        }
        
        $validated['is_featured'] = $request->boolean('is_featured');

        $portofolio->update($validated);

        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                if ($image && $image->isValid()) {
                    $path = $image->store('portofolio/' . $portofolio->id, 'public');
                    
                    PortofolioGallery::create([
                        'portofolio_id' => $portofolio->id,
                        'image_path' => $path,
                        'caption' => $request->image_captions[$index] ?? null,
                        'is_before' => $request->has('is_before') && isset($request->is_before[$index]) ? true : false,
                        'sort_order' => $portofolio->galleries()->count(),
                    ]);
                }
            }
        }

        return redirect()->route('content.portofolio.index')
            ->with('success', 'Portofolio "' . $validated['nama_proyek'] . '" berhasil diupdate! ✅');
    }

    public function destroy(PortofolioProyek $portofolio)
    {
        if ($portofolio->created_by !== auth()->id()) {
            abort(403);
        }

        // Delete all images
        foreach ($portofolio->galleries as $gallery) {
            Storage::disk('public')->delete($gallery->image_path);
        }
        
        Storage::disk('public')->deleteDirectory('portofolio/' . $portofolio->id);

        $portofolio->delete();

        return redirect()->route('content.portofolio.index')
            ->with('success', 'Portofolio berhasil dihapus');
    }

    public function deleteGallery(PortofolioGallery $gallery)
    {
        if ($gallery->portofolio->created_by !== auth()->id()) {
            abort(403);
        }

        Storage::disk('public')->delete($gallery->image_path);
        $gallery->delete();

        return response()->json(['success' => true]);
    }

    public function updateGalleryOrder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*' => 'integer|exists:portofolio_galleries,id',
        ]);

        foreach ($request->orders as $index => $id) {
            PortofolioGallery::where('id', $id)->update(['sort_order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}