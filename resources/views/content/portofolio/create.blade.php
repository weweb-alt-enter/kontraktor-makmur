@extends('layouts.content-layout')

@section('title', 'Tambah Portofolio')

@push('styles')
<style>
    .gallery-item {
        transition: all 0.2s ease;
    }
    .gallery-item:hover {
        border-color: #1E3A8A;
        background-color: #f8fafc;
    }
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('content.portofolio.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-primary-900 transition text-sm mb-4">
            <i class="fas fa-arrow-left"></i> Kembali ke daftar
        </a>
        <h1 class="text-2xl font-heading font-bold text-gray-900">Tambah Portofolio Baru</h1>
        <p class="text-gray-500 text-sm mt-1">Lengkapi informasi proyek di bawah ini</p>
    </div>

    <form action="{{ route('content.portofolio.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- Basic Info -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8 mb-6">
            <h3 class="text-lg font-heading font-semibold text-gray-900 mb-6 flex items-center gap-2">
                <i class="fas fa-info-circle text-primary-900"></i> Informasi Dasar
            </h3>
            
            <div class="grid md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Proyek *</label>
                    <input type="text" name="nama_proyek" value="{{ old('nama_proyek') }}" required
                        class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm
                                @error('nama_proyek') border-red-300 bg-red-50 focus:border-red-500 focus:ring-red-100 @enderror"
                        placeholder="Masukkan nama proyek">
                    @error('nama_proyek')
                    <div class="flex items-center gap-2 mt-2 text-sm text-red-600 bg-red-50 px-4 py-2 rounded-lg">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ $message }}</span>
                    </div>
                    @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Layanan</label>
                    <select name="jenis_layanan_id" 
                            class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                        <option value="">Pilih Layanan</option>
                        @foreach($jenisLayanan as $layanan)
                        <option value="{{ $layanan->id }}" {{ old('jenis_layanan_id') == $layanan->id ? 'selected' : '' }}>
                            {{ $layanan->nama_layanan }}
                        </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Bangunan</label>
                    <select name="jenis_bangunan_id" 
                            class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                        <option value="">Pilih Bangunan</option>
                        @foreach($jenisBangunan as $bangunan)
                        <option value="{{ $bangunan->id }}" {{ old('jenis_bangunan_id') == $bangunan->id ? 'selected' : '' }}>
                            {{ $bangunan->nama_bangunan }}
                        </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Lokasi *</label>
                    <input type="text" name="lokasi" value="{{ old('lokasi') }}" required
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm"
                           placeholder="Alamat lengkap proyek">
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Klien</label>
                    <input type="text" name="klien_nama" value="{{ old('klien_nama') }}"
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm"
                           placeholder="Nama klien (opsional)">
                </div>
            </div>
        </div>

        <!-- Detail Proyek -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8 mb-6">
            <h3 class="text-lg font-heading font-semibold text-gray-900 mb-6 flex items-center gap-2">
                <i class="fas fa-list-ul text-primary-900"></i> Detail Proyek
            </h3>
            
            <div class="grid md:grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Estimasi Budget (Rp)</label>
                    <input type="number" name="estimasi_budget" value="{{ old('estimasi_budget') }}"
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm"
                           placeholder="Contoh: 500000000">
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Luas Bangunan (m²)</label>
                    <input type="number" name="luas_bangunan" value="{{ old('luas_bangunan') }}"
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm"
                           placeholder="Contoh: 120">
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Durasi Pengerjaan</label>
                    <input type="text" name="durasi_pengerjaan" value="{{ old('durasi_pengerjaan') }}"
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm"
                           placeholder="Contoh: 6 bulan">
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Selesai</label>
                    <input type="number" name="tahun_selesai" value="{{ old('tahun_selesai') }}"
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm"
                           placeholder="Contoh: 2024">
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Koordinat Latitude</label>
                    <input type="text" name="koordinat_lat" value="{{ old('koordinat_lat') }}"
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm"
                           placeholder="Contoh: -7.2575">
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Koordinat Longitude</label>
                    <input type="text" name="koordinat_lng" value="{{ old('koordinat_lng') }}"
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm"
                           placeholder="Contoh: 112.7521">
                </div>
            </div>
        </div>

        <!-- Status & Options -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8 mb-6">
            <h3 class="text-lg font-heading font-semibold text-gray-900 mb-6 flex items-center gap-2">
                <i class="fas fa-cog text-primary-900"></i> Status & Opsi
            </h3>
            
            <div class="grid md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status Proyek *</label>
                    <div class="grid grid-cols-3 gap-2">
                        <label class="relative flex flex-col items-center gap-2 p-3 rounded-xl border-2 cursor-pointer transition-all
                                      {{ old('status_proyek', 'selesai') == 'selesai' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-gray-300' }}">
                            <input type="radio" name="status_proyek" value="selesai" {{ old('status_proyek', 'selesai') == 'selesai' ? 'checked' : '' }} class="sr-only">
                            <i class="fas fa-check-circle text-xl {{ old('status_proyek', 'selesai') == 'selesai' ? 'text-green-600' : 'text-gray-400' }}"></i>
                            <span class="text-xs font-medium">Selesai</span>
                        </label>
                        
                        <label class="relative flex flex-col items-center gap-2 p-3 rounded-xl border-2 cursor-pointer transition-all
                                      {{ old('status_proyek') == 'berjalan' ? 'border-yellow-500 bg-yellow-50' : 'border-gray-200 hover:border-gray-300' }}">
                            <input type="radio" name="status_proyek" value="berjalan" {{ old('status_proyek') == 'berjalan' ? 'checked' : '' }} class="sr-only">
                            <i class="fas fa-spinner text-xl {{ old('status_proyek') == 'berjalan' ? 'text-yellow-600' : 'text-gray-400' }}"></i>
                            <span class="text-xs font-medium">Berjalan</span>
                        </label>
                        
                        <label class="relative flex flex-col items-center gap-2 p-3 rounded-xl border-2 cursor-pointer transition-all
                                      {{ old('status_proyek') == 'direncanakan' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}">
                            <input type="radio" name="status_proyek" value="direncanakan" {{ old('status_proyek') == 'direncanakan' ? 'checked' : '' }} class="sr-only">
                            <i class="fas fa-calendar text-xl {{ old('status_proyek') == 'direncanakan' ? 'text-blue-600' : 'text-gray-400' }}"></i>
                            <span class="text-xs font-medium">Direncanakan</span>
                        </label>
                    </div>
                </div>
                
                <div class="flex items-center">
                    <label class="relative flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all
                                  {{ old('is_featured') ? 'border-accent-500 bg-accent-50' : 'border-gray-200 hover:border-gray-300' }}">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="sr-only">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ old('is_featured') ? 'bg-accent-500 text-primary-900' : 'bg-gray-100 text-gray-400' }}">
                            <i class="fas fa-star"></i>
                        </div>
                        <div>
                            <span class="text-sm font-semibold text-gray-900">Featured / Unggulan</span>
                            <p class="text-xs text-gray-500">Tampilkan di halaman utama</p>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8 mb-6">
            <h3 class="text-lg font-heading font-semibold text-gray-900 mb-6 flex items-center gap-2">
                <i class="fas fa-align-left text-primary-900"></i> Deskripsi
            </h3>
            <textarea name="deskripsi" rows="6" required
                      class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm"
                      placeholder="Jelaskan detail proyek secara lengkap...">{{ old('deskripsi') }}</textarea>
        </div>

        <!-- Gallery Upload -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8 mb-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-heading font-semibold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-images text-primary-900"></i> Galeri Gambar
                </h3>
                <button type="button" onclick="addGalleryItem()" 
                        class="text-primary-900 hover:text-primary-700 text-sm font-medium flex items-center gap-1">
                    <i class="fas fa-plus-circle"></i> Tambah Gambar
                </button>
            </div>
            
            <div id="galleryContainer" class="space-y-4">
                <div class="gallery-item border-2 border-dashed border-gray-200 rounded-xl p-4 hover:border-primary-300 transition">
                    <div class="grid md:grid-cols-3 gap-3">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-medium text-gray-600 mb-1">Pilih Gambar</label>
                            <input type="file" name="images[]" accept="image/*" 
                                   class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-900 hover:file:bg-primary-100">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Caption</label>
                            <input type="text" name="image_captions[]" placeholder="Deskripsi gambar" 
                                   class="w-full rounded-lg border-gray-200 bg-gray-50 py-2 px-3 text-sm focus:border-primary-500 focus:ring-1 focus:ring-primary-100">
                        </div>
                    </div>
                    <label class="flex items-center gap-2 mt-3 cursor-pointer">
                        <input type="checkbox" name="is_before[]" value="1" 
                               class="w-4 h-4 rounded border-gray-300 text-primary-900 focus:ring-primary-500">
                        <span class="text-sm text-gray-600">Gambar Sebelum (Before)</span>
                    </label>
                </div>
            </div>
            <p class="text-xs text-gray-400 mt-3">Format: JPG, PNG, WebP. Maks 5MB per gambar.</p>
        </div>

        <!-- Submit -->
        <div class="flex justify-end gap-3">
            <a href="{{ route('content.portofolio.index') }}" 
               class="px-6 py-3 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50 transition font-medium text-sm">
                Batal
            </a>
            <button type="submit" 
                    class="px-8 py-3 bg-primary-900 text-white rounded-xl hover:bg-primary-800 transition font-medium text-sm flex items-center gap-2 shadow-lg shadow-primary-900/20">
                <i class="fas fa-save"></i> Simpan Portofolio
            </button>
        </div>
    </form>
</div>

@push('scripts')
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
                       class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-900 hover:file:bg-primary-100">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Caption</label>
                <input type="text" name="image_captions[]" placeholder="Deskripsi gambar" 
                       class="w-full rounded-lg border-gray-200 bg-gray-50 py-2 px-3 text-sm focus:border-primary-500 focus:ring-1 focus:ring-primary-100">
            </div>
        </div>
        <label class="flex items-center gap-2 mt-3 cursor-pointer">
            <input type="checkbox" name="is_before[]" value="1" 
                   class="w-4 h-4 rounded border-gray-300 text-primary-900 focus:ring-primary-500">
            <span class="text-sm text-gray-600">Gambar Sebelum (Before)</span>
        </label>
    `;
    container.appendChild(newItem);
}
</script>
@endpush
@endsection