@extends('layouts.content-layout')

@section('title', 'Tambah Inspirasi Desain')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('content.inspirasi.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-primary-900 transition text-sm mb-4">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <h1 class="text-2xl font-heading font-bold text-gray-900">Tambah Inspirasi Desain</h1>
        <p class="text-gray-500 text-sm mt-1">Tambahkan inspirasi desain interior atau eksterior</p>
    </div>

    <form action="{{ route('content.inspirasi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8 mb-6">
            <h3 class="text-lg font-heading font-semibold text-gray-900 mb-6">Informasi Desain</h3>
            <div class="grid md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Judul *</label>
                    <input type="text" name="judul" value="{{ old('judul') }}" required
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm
                                  @error('judul') border-red-300 bg-red-50 @enderror"
                           placeholder="Masukkan judul inspirasi">
                    @error('judul')
                    <p class="text-red-500 text-xs mt-1 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                    <input type="text" name="kategori" value="{{ old('kategori') }}" 
                           placeholder="Contoh: Ruang Tamu, Dapur, Kamar Tidur"
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Konsep</label>
                    <input type="text" name="konsep" value="{{ old('konsep') }}" 
                           placeholder="Contoh: Minimalis, Industrial, Japandi"
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Warna Dominan</label>
                    <input type="text" name="warna_dominan" value="{{ old('warna_dominan') }}" 
                           placeholder="Contoh: Putih, Abu-abu, Navy"
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Estimasi Biaya/m² (Rp)</label>
                    <input type="number" name="estimasi_biaya" value="{{ old('estimasi_biaya') }}" 
                           placeholder="Contoh: 2500000"
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tags</label>
                    <input type="text" name="tags" value="{{ old('tags') }}" 
                           placeholder="minimalis, modern, interior (pisahkan dengan koma)"
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
                              class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm resize-none"
                              placeholder="Jelaskan inspirasi desain ini...">{{ old('deskripsi') }}</textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Featured Image</label>
                    <input type="file" name="gambar" accept="image/*" 
                           class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-primary-50 file:text-primary-900 hover:file:bg-primary-100">
                    <p class="text-xs text-gray-400 mt-1">Ukuran disarankan: 1200x800px. Maks 5MB.</p>
                </div>
                
                <div>
                    <label class="flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all
                                  {{ old('is_published') ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-gray-300' }}">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }} class="sr-only">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ old('is_published') ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-400' }}">
                            <i class="fas fa-check"></i>
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-gray-900">Publish Sekarang</span>
                            <p class="text-xs text-gray-500">Inspirasi akan langsung tayang di publik</p>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Gallery -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-heading font-semibold text-gray-900">Galeri Tambahan</h3>
                <button type="button" onclick="addGalleryItem()" 
                        class="text-primary-900 hover:text-primary-700 text-sm font-medium flex items-center gap-1">
                    <i class="fas fa-plus-circle"></i> Tambah Gambar
                </button>
            </div>
            <div id="galleryContainer" class="space-y-3">
                <div class="border-2 border-dashed border-gray-200 rounded-xl p-4 hover:border-primary-300 transition">
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
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-3">Format: JPG, PNG, WebP. Maks 5MB per gambar.</p>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('content.inspirasi.index') }}" 
               class="px-6 py-3 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50 transition font-medium text-sm">
                Batal
            </a>
            <button type="submit" 
                    class="px-8 py-3 bg-primary-900 text-white rounded-xl hover:bg-primary-800 transition font-medium text-sm flex items-center gap-2 shadow-lg shadow-primary-900/20">
                <i class="fas fa-save"></i> Simpan Inspirasi
            </button>
        </div>
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
</script>
@endpush
@endsection