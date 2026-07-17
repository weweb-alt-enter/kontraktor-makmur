@extends('layouts.content-layout')

@section('title', 'Edit Inspirasi Desain')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('content.inspirasi.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-primary-900 transition text-sm mb-4">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <h1 class="text-2xl font-heading font-bold text-gray-900">Edit Inspirasi Desain</h1>
        <p class="text-gray-500 text-sm mt-1">{{ $inspirasi->judul }}</p>
    </div>

    <!-- Existing Gallery -->
    @if($inspirasi->galleries->isNotEmpty())
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <h3 class="text-lg font-heading font-semibold text-gray-900 mb-4">Galeri Saat Ini</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($inspirasi->galleries as $gallery)
            <div class="relative group rounded-xl overflow-hidden bg-gray-100" data-id="{{ $gallery->id }}">
                <img src="{{ Storage::url($gallery->image_path) }}" class="w-full h-32 object-cover">
                @if($gallery->caption)
                <p class="text-xs text-gray-600 p-2 truncate">{{ $gallery->caption }}</p>
                @endif
                <button type="button" onclick="deleteGalleryImage({{ $gallery->id }})" 
                        class="absolute top-2 right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center 
                               opacity-0 group-hover:opacity-100 transition shadow-lg hover:bg-red-600"
                        title="Hapus gambar">
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- FORM UPDATE --}}
    <form action="{{ route('content.inspirasi.update', $inspirasi) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8 mb-6">
            <h3 class="text-lg font-heading font-semibold text-gray-900 mb-6">Informasi Desain</h3>
            <div class="grid md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Judul *</label>
                    <input type="text" name="judul" value="{{ old('judul', $inspirasi->judul) }}" required
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm
                                  @error('judul') border-red-300 bg-red-50 @enderror">
                    @error('judul')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                    <input type="text" name="kategori" value="{{ old('kategori', $inspirasi->kategori) }}"
                           placeholder="Contoh: Ruang Tamu, Dapur"
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Konsep</label>
                    <input type="text" name="konsep" value="{{ old('konsep', $inspirasi->konsep) }}"
                           placeholder="Contoh: Minimalis, Industrial"
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Warna Dominan</label>
                    <input type="text" name="warna_dominan" value="{{ old('warna_dominan', $inspirasi->warna_dominan) }}"
                           placeholder="Contoh: Putih, Abu-abu"
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Estimasi Biaya/m² (Rp)</label>
                    <input type="number" name="estimasi_biaya" value="{{ old('estimasi_biaya', $inspirasi->estimasi_biaya) }}"
                           placeholder="Contoh: 2500000"
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tags</label>
                    <input type="text" name="tags" value="{{ old('tags', $inspirasi->tags) }}"
                           placeholder="minimalis, modern, interior (pisah koma)"
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8 mb-6">
            <h3 class="text-lg font-heading font-semibold text-gray-900 mb-6">Deskripsi & Gambar</h3>
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                    <textarea name="deskripsi" rows="4" 
                              class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm resize-none">{{ old('deskripsi', $inspirasi->deskripsi) }}</textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Featured Image</label>
                    @if($inspirasi->gambar)
                    <div class="mb-3">
                        <img src="{{ Storage::url($inspirasi->gambar) }}" class="w-40 h-28 object-cover rounded-xl border border-gray-200">
                        <p class="text-xs text-gray-400 mt-1">Upload gambar baru untuk mengganti</p>
                    </div>
                    @endif
                    <input type="file" name="gambar" accept="image/*" 
                           class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-primary-50 file:text-primary-900 hover:file:bg-primary-100">
                </div>
                
                <div>
                    <label class="flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all
                                  {{ $inspirasi->is_published ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-gray-300' }}">
                        <input type="checkbox" name="is_published" value="1" {{ $inspirasi->is_published ? 'checked' : '' }} class="sr-only">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ $inspirasi->is_published ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-400' }}">
                            <i class="fas fa-check"></i>
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-gray-900">{{ $inspirasi->is_published ? 'Published' : 'Publish' }}</span>
                            <p class="text-xs text-gray-500">{{ $inspirasi->is_published ? 'Inspirasi sudah tayang di publik' : 'Centang untuk publish' }}</p>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Add New Gallery Images -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-heading font-semibold text-gray-900">Tambah Gambar Baru</h3>
                <button type="button" onclick="addGalleryItem()" 
                        class="text-primary-900 hover:text-primary-700 text-sm font-medium flex items-center gap-1">
                    <i class="fas fa-plus-circle"></i> Tambah Gambar
                </button>
            </div>
            <div id="galleryContainer" class="space-y-3"></div>
            <p class="text-xs text-gray-400 mt-3">Format: JPG, PNG, WebP. Maks 5MB per gambar.</p>
        </div>

        {{-- TOMBOL UPDATE (DALAM FORM INI) --}}
        <div class="flex justify-end gap-3">
            <a href="{{ route('content.inspirasi.index') }}" 
               class="px-6 py-3 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50 transition font-medium text-sm">
                Batal
            </a>
            <button type="submit" 
                    class="px-8 py-3 bg-primary-900 text-white rounded-xl hover:bg-primary-800 transition font-medium text-sm flex items-center gap-2 shadow-lg shadow-primary-900/20">
                <i class="fas fa-save"></i> Update Inspirasi
            </button>
        </div>
    </form>

    {{-- FORM DELETE DIPISAH --}}
    <form action="{{ route('content.inspirasi.destroy', $inspirasi) }}" method="POST" class="mt-4"
          onsubmit="return confirm('Yakin ingin menghapus inspirasi ini? Semua data dan gambar akan dihapus permanen.')">
        @csrf
        @method('DELETE')
        <button type="submit" 
                class="px-4 py-3 rounded-xl border border-red-200 text-red-600 hover:bg-red-50 transition font-medium text-sm flex items-center gap-2">
            <i class="fas fa-trash"></i> Hapus Inspirasi
        </button>
    </form>
</div>

@push('scripts')
<script>
function addGalleryItem() {
    const container = document.getElementById('galleryContainer');
    const newItem = document.createElement('div');
    newItem.className = 'border-2 border-dashed border-gray-200 rounded-xl p-4 relative hover:border-primary-300 transition';
    newItem.innerHTML = `
        <button type="button" onclick="this.parentElement.remove()" 
                class="absolute top-3 right-3 w-7 h-7 flex items-center justify-center rounded-full bg-red-100 text-red-500 hover:bg-red-200 transition">
            <i class="fas fa-times text-xs"></i>
        </button>
        <div class="grid md:grid-cols-2 gap-3">
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Pilih Gambar</label>
                <input type="file" name="galleries[]" accept="image/*" 
                       class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-primary-50 file:text-primary-900">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Caption</label>
                <input type="text" name="gallery_captions[]" placeholder="Deskripsi gambar" 
                       class="w-full rounded-lg border-gray-200 bg-gray-50 py-2 px-3 text-sm focus:border-primary-500">
            </div>
        </div>
    `;
    container.appendChild(newItem);
}

function deleteGalleryImage(id) {
    if (!confirm('Yakin ingin menghapus gambar ini?')) return;
    
    fetch(`/content/inspirasi-gallery/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const element = document.querySelector(`[data-id="${id}"]`);
            if (element) element.remove();
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
@endpush
@endsection