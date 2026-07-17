@extends('layouts.content-layout')

@section('title', 'Tulis Blog')

@push('styles')
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
<style>
    trix-toolbar [data-trix-button-group="file-tools"] { display: none; }
    trix-editor { min-height: 300px; }
    trix-editor:focus { outline: none; }
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('content.blog.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-primary-900 transition text-sm mb-4">
            <i class="fas fa-arrow-left"></i> Kembali ke daftar
        </a>
        <h1 class="text-2xl font-heading font-bold text-gray-900">Tulis Blog Baru</h1>
        <p class="text-gray-500 text-sm mt-1">Buat artikel menarik untuk pengunjung website</p>
    </div>

    <form action="{{ route('content.blog.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8 mb-6">
            <div class="grid md:grid-cols-3 gap-6">
                <div class="md:col-span-2 space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Artikel *</label>
                        <input type="text" name="judul" value="{{ old('judul') }}" required
                            class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm
                                    @error('judul') border-red-300 bg-red-50 focus:border-red-500 focus:ring-red-100 @enderror"
                            placeholder="Masukkan judul yang menarik">
                        @error('judul')
                        <div class="flex items-center gap-2 mt-2 text-sm text-red-600 bg-red-50 px-4 py-2 rounded-lg">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $message }}</span>
                        </div>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Excerpt / Ringkasan</label>
                        <textarea name="excerpt" rows="2" 
                                  class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm resize-none"
                                  placeholder="Ringkasan singkat (akan tampil di daftar blog)">{{ old('excerpt') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tags</label>
                        <input type="text" name="tags" value="{{ old('tags') }}" 
                               class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm"
                               placeholder="tips, konstruksi, desain (pisahkan dengan koma)">
                    </div>
                </div>
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Featured Image</label>
                        <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:border-primary-300 transition cursor-pointer">
                            <input type="file" name="featured_image" accept="image/*" class="hidden" id="featuredImageInput">
                            <label for="featuredImageInput" class="cursor-pointer">
                                <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2 block"></i>
                                <span class="text-sm text-gray-500">Klik untuk upload</span>
                                <p class="text-xs text-gray-400 mt-1">1200x630px, max 5MB</p>
                            </label>
                        </div>
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
                                <p class="text-xs text-gray-500">Artikel langsung tayang</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8 mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-3">Konten Artikel *</label>
            <input id="konten" type="hidden" name="konten" value="{{ old('konten') }}">
            <trix-editor input="konten" class="prose max-w-none"></trix-editor>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('content.blog.index') }}" 
               class="px-6 py-3 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50 transition font-medium text-sm">
                Batal
            </a>
            <button type="submit" 
                    class="px-8 py-3 bg-primary-900 text-white rounded-xl hover:bg-primary-800 transition font-medium text-sm flex items-center gap-2 shadow-lg shadow-primary-900/20">
                <i class="fas fa-save"></i> Simpan Blog
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
<script>
    document.addEventListener('trix-file-accept', e => e.preventDefault());
    
    // Preview featured image
    document.getElementById('featuredImageInput')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const label = this.previousElementSibling;
            if (label) {
                label.innerHTML = `<i class="fas fa-check-circle text-green-500 text-xl mb-1 block"></i>
                                   <span class="text-sm text-green-600">${file.name}</span>`;
            }
        }
    });
</script>
@endpush
@endsection