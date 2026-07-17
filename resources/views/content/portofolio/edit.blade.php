@extends('layouts.content-layout')

@section('title', 'Edit Portofolio')

@push('styles')
<style>
    .existing-gallery-item {
        transition: all 0.2s ease;
    }
    .existing-gallery-item:hover {
        transform: scale(1.02);
    }
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('content.portofolio.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-primary-900 transition text-sm mb-4">
            <i class="fas fa-arrow-left"></i> Kembali ke daftar
        </a>
        <h1 class="text-2xl font-heading font-bold text-gray-900">Edit Portofolio</h1>
        <p class="text-gray-500 text-sm mt-1">{{ $portofolio->nama_proyek }}</p>
    </div>

    <!-- Existing Gallery -->
    @if($portofolio->galleries->isNotEmpty())
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <h3 class="text-lg font-heading font-semibold text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-images text-primary-900"></i> Galeri Saat Ini
            <span class="text-sm font-normal text-gray-400">(Drag to reorder)</span>
        </h3>
        <div id="existingGallery" class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($portofolio->galleries as $gallery)
            <div class="existing-gallery-item relative group rounded-xl overflow-hidden bg-gray-100" data-id="{{ $gallery->id }}">
                <img src="{{ Storage::url($gallery->image_path) }}" alt="{{ $gallery->caption }}" 
                     class="w-full h-32 object-cover">
                
                @if($gallery->is_before)
                <span class="absolute top-2 left-2 bg-yellow-500 text-white text-[10px] px-2 py-0.5 rounded-full font-medium">Before</span>
                @endif
                
                <button type="button" onclick="deleteImage({{ $gallery->id }})" 
                        class="absolute top-2 right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center 
                               opacity-0 group-hover:opacity-100 transition shadow-lg hover:bg-red-600"
                        title="Hapus gambar">
                    <i class="fas fa-times text-xs"></i>
                </button>
                
                @if($gallery->caption)
                <p class="text-xs text-gray-600 p-2 truncate">{{ $gallery->caption }}</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <form action="{{ route('content.portofolio.update', $portofolio) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <!-- Same form fields as create -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8 mb-6">
            <h3 class="text-lg font-heading font-semibold text-gray-900 mb-6">Informasi Dasar</h3>
            <div class="grid md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Proyek *</label>
                    <input type="text" name="nama_proyek" value="{{ old('nama_proyek', $portofolio->nama_proyek) }}" required
                        class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm
                                @error('nama_proyek') border-red-300 bg-red-50 focus:border-red-500 focus:ring-red-100 @enderror">
                    @error('nama_proyek')
                    <div class="flex items-center gap-2 mt-2 text-sm text-red-600 bg-red-50 px-4 py-2 rounded-lg">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ $message }}</span>
                    </div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Layanan</label>
                    <select name="jenis_layanan_id" class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                        <option value="">Pilih Layanan</option>
                        @foreach($jenisLayanan as $layanan)
                        <option value="{{ $layanan->id }}" {{ old('jenis_layanan_id', $portofolio->jenis_layanan_id) == $layanan->id ? 'selected' : '' }}>
                            {{ $layanan->nama_layanan }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Bangunan</label>
                    <select name="jenis_bangunan_id" class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                        <option value="">Pilih Bangunan</option>
                        @foreach($jenisBangunan as $bangunan)
                        <option value="{{ $bangunan->id }}" {{ old('jenis_bangunan_id', $portofolio->jenis_bangunan_id) == $bangunan->id ? 'selected' : '' }}>
                            {{ $bangunan->nama_bangunan }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Lokasi *</label>
                    <input type="text" name="lokasi" value="{{ old('lokasi', $portofolio->lokasi) }}" required
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Klien</label>
                    <input type="text" name="klien_nama" value="{{ old('klien_nama', $portofolio->klien_nama) }}"
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8 mb-6">
            <h3 class="text-lg font-heading font-semibold text-gray-900 mb-6">Detail Proyek</h3>
            <div class="grid md:grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Budget (Rp)</label>
                    <input type="number" name="estimasi_budget" value="{{ old('estimasi_budget', $portofolio->estimasi_budget) }}"
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Luas (m²)</label>
                    <input type="number" name="luas_bangunan" value="{{ old('luas_bangunan', $portofolio->luas_bangunan) }}"
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Durasi</label>
                    <input type="text" name="durasi_pengerjaan" value="{{ old('durasi_pengerjaan', $portofolio->durasi_pengerjaan) }}"
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Selesai</label>
                    <input type="number" name="tahun_selesai" value="{{ old('tahun_selesai', $portofolio->tahun_selesai) }}"
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Latitude</label>
                    <input type="text" name="koordinat_lat" value="{{ old('koordinat_lat', $portofolio->koordinat_lat) }}"
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Longitude</label>
                    <input type="text" name="koordinat_lng" value="{{ old('koordinat_lng', $portofolio->koordinat_lng) }}"
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8 mb-6">
            <h3 class="text-lg font-heading font-semibold text-gray-900 mb-6">Status & Opsi</h3>
            <div class="grid md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status *</label>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach(['selesai' => ['green', 'check-circle'], 'berjalan' => ['yellow', 'spinner'], 'direncanakan' => ['blue', 'calendar']] as $status => $colors)
                        <label class="relative flex flex-col items-center gap-2 p-3 rounded-xl border-2 cursor-pointer transition-all
                                      {{ old('status_proyek', $portofolio->status_proyek) == $status ? 'border-'.$colors[0].'-500 bg-'.$colors[0].'-50' : 'border-gray-200 hover:border-gray-300' }}">
                            <input type="radio" name="status_proyek" value="{{ $status }}" 
                                   {{ old('status_proyek', $portofolio->status_proyek) == $status ? 'checked' : '' }} class="sr-only">
                            <i class="fas fa-{{ $colors[1] }} text-xl {{ old('status_proyek', $portofolio->status_proyek) == $status ? 'text-'.$colors[0].'-600' : 'text-gray-400' }}"></i>
                            <span class="text-xs font-medium">{{ ucfirst($status) }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                <div class="flex items-center">
                    <label class="relative flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all
                                  {{ old('is_featured', $portofolio->is_featured) ? 'border-accent-500 bg-accent-50' : 'border-gray-200 hover:border-gray-300' }}">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $portofolio->is_featured) ? 'checked' : '' }} class="sr-only">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ old('is_featured', $portofolio->is_featured) ? 'bg-accent-500 text-primary-900' : 'bg-gray-100 text-gray-400' }}">
                            <i class="fas fa-star"></i>
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-gray-900">Featured</span>
                            <p class="text-xs text-gray-500">Tampilkan di halaman utama</p>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8 mb-6">
            <h3 class="text-lg font-heading font-semibold text-gray-900 mb-6">Deskripsi</h3>
            <textarea name="deskripsi" rows="6" required
                      class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">{{ old('deskripsi', $portofolio->deskripsi) }}</textarea>
        </div>

        <!-- Add New Images -->
                <!-- ... semua field form di atas tetap sama ... -->

        <!-- Add New Images -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8 mb-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-heading font-semibold text-gray-900">Tambah Gambar Baru</h3>
                <button type="button" onclick="addGalleryItem()" 
                        class="text-primary-900 hover:text-primary-700 text-sm font-medium flex items-center gap-1">
                    <i class="fas fa-plus-circle"></i> Tambah
                </button>
            </div>
            <div id="galleryContainer" class="space-y-4"></div>
        </div>

        <!-- Submit Buttons - PERBAIKAN DI SINI -->
        <div class="flex justify-end gap-3">
            <a href="{{ route('content.portofolio.index') }}" 
               class="px-6 py-3 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50 transition font-medium text-sm">
                Batal
            </a>
            <button type="submit" 
                    class="px-8 py-3 bg-primary-900 text-white rounded-xl hover:bg-primary-800 transition font-medium text-sm flex items-center gap-2 shadow-lg shadow-primary-900/20">
                <i class="fas fa-save"></i> Update Portofolio
            </button>
        </div>
    </form>

    {{-- FORM DELETE DIPISAH --}}
    <form action="{{ route('content.portofolio.destroy', $portofolio) }}" method="POST" class="mt-4"
          onsubmit="return confirm('Yakin ingin menghapus portofolio ini? Semua data dan gambar akan dihapus permanen.')">
        @csrf
        @method('DELETE')
        <button type="submit" 
                class="px-4 py-3 rounded-xl border border-red-200 text-red-600 hover:bg-red-50 transition font-medium text-sm flex items-center gap-2">
            <i class="fas fa-trash"></i> Hapus Portofolio
        </button>
    </form>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
function addGalleryItem() {
    const container = document.getElementById('galleryContainer');
    const newItem = document.createElement('div');
    newItem.className = 'gallery-item border-2 border-dashed border-gray-200 rounded-xl p-4 hover:border-primary-300 transition relative';
    newItem.innerHTML = `
        <button type="button" onclick="this.parentElement.remove()" 
                class="absolute top-3 right-3 w-7 h-7 flex items-center justify-center rounded-full bg-red-100 text-red-500 hover:bg-red-200 transition">
            <i class="fas fa-times text-xs"></i>
        </button>
        <div class="grid md:grid-cols-3 gap-3">
            <div class="md:col-span-2">
                <label class="block text-xs font-medium text-gray-600 mb-1">Pilih Gambar</label>
                <input type="file" name="images[]" accept="image/*" 
                       class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-900">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Caption</label>
                <input type="text" name="image_captions[]" placeholder="Deskripsi" 
                       class="w-full rounded-lg border-gray-200 bg-gray-50 py-2 px-3 text-sm focus:border-primary-500 focus:ring-1 focus:ring-primary-100">
            </div>
        </div>
        <label class="flex items-center gap-2 mt-3 cursor-pointer">
            <input type="checkbox" name="is_before[]" value="1" class="w-4 h-4 rounded border-gray-300 text-primary-900 focus:ring-primary-500">
            <span class="text-sm text-gray-600">Gambar Sebelum (Before)</span>
        </label>
    `;
    container.appendChild(newItem);
}

function deleteImage(galleryId) {
    if (!confirm('Yakin ingin menghapus gambar ini?')) return;
    
    fetch(`/content/gallery/${galleryId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.querySelector(`[data-id="${galleryId}"]`)?.remove();
        }
    });
}

// Sortable
document.addEventListener('DOMContentLoaded', function() {
    const existingGallery = document.getElementById('existingGallery');
    if (existingGallery) {
        new Sortable(existingGallery, {
            animation: 150,
            handle: 'img',
            onEnd: function() {
                const ids = Array.from(existingGallery.children).map(el => el.dataset.id);
                fetch('{{ route("content.gallery.reorder") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ orders: ids })
                });
            }
        });
    }
});
</script>
@endpush
@endsection