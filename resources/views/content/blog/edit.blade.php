@extends('layouts.content-layout')

@section('title', 'Edit Blog')

@push('styles')
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
<style>
    trix-toolbar [data-trix-button-group="file-tools"] { display: none; }
    trix-editor { min-height: 300px; }

    .status-toggle {
        transition: all 0.3s ease;
    }

    .status-toggle .status-icon {
        transition: all 0.3s ease;
    }

    .status-toggle .status-text {
        transition: color 0.3s ease;
    }

    .status-toggle .status-desc {
        transition: color 0.3s ease;
    }

    .status-toggle.active {
        border-color: #22c55e;
        background-color: #f0fdf4;
    }

    .status-toggle.active .status-icon {
        background-color: #22c55e;
        color: white;
    }

    .status-toggle.active .status-text {
        color: #15803d;
    }

    .status-toggle.active .status-desc {
        color: #15803d;
    }

    .status-toggle.inactive {
        border-color: #e5e7eb;
        background-color: white;
    }

    .status-toggle.inactive:hover {
        border-color: #d1d5db;
    }

    .status-toggle.inactive .status-icon {
        background-color: #f3f4f6;
        color: #9ca3af;
    }

    .status-toggle.inactive .status-text {
        color: #111827;
    }

    .status-toggle.inactive .status-desc {
        color: #6b7280;
    }
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('content.blog.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-primary-900 transition text-sm mb-4">
            <i class="fas fa-arrow-left"></i> Kembali ke daftar
        </a>
        <h1 class="text-2xl font-heading font-bold text-gray-900">Edit Blog</h1>
        <p class="text-gray-500 text-sm mt-1">{{ $blog->judul }}</p>
    </div>

    <form action="{{ route('content.blog.update', $blog) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8 mb-6">
            <div class="grid md:grid-cols-3 gap-6">
                <div class="md:col-span-2 space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Judul *</label>
                        <input type="text" name="judul" value="{{ old('judul', $blog->judul) }}" required
                            class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm
                                    @error('judul') border-red-300 bg-red-50 focus:border-red-500 focus:ring-red-100 @enderror">
                        @error('judul')
                        <div class="flex items-center gap-2 mt-2 text-sm text-red-600 bg-red-50 px-4 py-2 rounded-lg">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $message }}</span>
                        </div>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Excerpt</label>
                        <textarea name="excerpt" rows="2" class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm resize-none">{{ old('excerpt', $blog->excerpt) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tags</label>
                        <input type="text" name="tags" value="{{ old('tags', $blog->tags) }}"
                               class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                    </div>
                </div>
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Featured Image</label>
                        @if($blog->featured_image)
                        <img src="{{ storage_url($blog->featured_image) }}" class="w-full h-32 object-cover rounded-xl mb-2">
                        @endif
                        <div class="border-2 border-dashed border-gray-200 rounded-xl p-4 text-center hover:border-primary-300 transition cursor-pointer">
                            <input type="file" name="featured_image" accept="image/*" class="hidden" id="featuredImageInput">
                            <label for="featuredImageInput" class="cursor-pointer text-sm text-gray-500">
                                <i class="fas fa-cloud-upload-alt mr-1"></i> Ganti gambar
                            </label>
                        </div>
                    </div>
                    <div>
                        <!-- STATUS TOGGLE WITH INTERACTIVITY -->
                        <label class="flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all duration-300 status-toggle {{ $blog->is_published ? 'active' : 'inactive' }}"
                               id="statusToggle">
                            <input type="checkbox" name="is_published" value="1" class="sr-only" id="statusCheckbox"
                                   {{ $blog->is_published ? 'checked' : '' }}>
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center transition-all duration-300 status-icon {{ $blog->is_published ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-400' }}">
                                <i class="fas fa-check"></i>
                            </div>
                            <div>
                                <span class="text-sm font-semibold transition-colors duration-300 status-text">{{ $blog->is_published ? 'Published' : 'Publish' }}</span>
                                <p class="text-xs transition-colors duration-300 status-desc">{{ $blog->is_published ? 'Artikel sudah tayang di publik' : 'Centang untuk publish' }}</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8 mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-3">Konten *</label>
            <input id="konten" type="hidden" name="konten" value="{{ old('konten', $blog->konten) }}">
            <trix-editor input="konten" class="prose max-w-none"></trix-editor>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('content.blog.index') }}"
               class="px-6 py-3 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50 transition font-medium text-sm">
                Batal
            </a>
            <button type="submit"
                    class="px-8 py-3 bg-primary-900 text-white rounded-xl hover:bg-primary-800 transition font-medium text-sm flex items-center gap-2 shadow-lg shadow-primary-900/20">
                <i class="fas fa-save"></i> Update Blog
            </button>
        </div>
    </form>

    <form action="{{ route('content.blog.destroy', $blog) }}" method="POST" class="mt-4"
          onsubmit="return confirm('Yakin ingin menghapus artikel ini? Data tidak dapat dikembalikan.')">
        @csrf
        @method('DELETE')
        <button type="submit"
                class="px-4 py-3 rounded-xl border border-red-200 text-red-600 hover:bg-red-50 transition font-medium text-sm flex items-center gap-2">
            <i class="fas fa-trash"></i> Hapus Artikel
        </button>
    </form>
</div>

@push('scripts')
<script src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
<script>
    document.addEventListener('trix-file-accept', e => e.preventDefault());

    document.getElementById('featuredImageInput')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.querySelector('img[src*="featured_image"]');
                if (preview) {
                    preview.src = e.target.result;
                }
            };
            reader.readAsDataURL(file);
        }
    });

    // ============================================
    // STATUS TOGGLE INTERACTIVITY
    // ============================================
    document.getElementById('statusCheckbox')?.addEventListener('change', function() {
        const toggle = document.getElementById('statusToggle');
        const iconBox = toggle.querySelector('.status-icon');
        const statusText = toggle.querySelector('.status-text');
        const statusDesc = toggle.querySelector('.status-desc');

        if (this.checked) {
            toggle.className = 'flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all duration-300 status-toggle active';
            iconBox.className = 'w-10 h-10 rounded-lg flex items-center justify-center transition-all duration-300 status-icon bg-green-500 text-white';
            statusText.textContent = 'Published';
            statusDesc.textContent = 'Artikel sudah tayang di publik';
        } else {
            toggle.className = 'flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all duration-300 status-toggle inactive';
            iconBox.className = 'w-10 h-10 rounded-lg flex items-center justify-center transition-all duration-300 status-icon bg-gray-100 text-gray-400';
            statusText.textContent = 'Publish';
            statusDesc.textContent = 'Centang untuk publish';
        }
    });
</script>
@endpush
@endsection