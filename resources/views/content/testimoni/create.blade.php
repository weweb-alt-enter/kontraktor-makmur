@extends('layouts.content-layout')

@section('title', 'Tambah Testimoni')

@push('styles')
<style>
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
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('content.testimoni.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-primary-900 transition text-sm mb-4">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <h1 class="text-2xl font-heading font-bold text-gray-900">Tambah Testimoni</h1>
        <p class="text-gray-500 text-sm mt-1">Tambahkan testimoni dari klien yang puas</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8">
        <form action="{{ route('content.testimoni.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Klien *</label>
                    <input type="text" name="nama_client" value="{{ old('nama_client') }}" required
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Klien</label>
                    <div class="border-2 border-dashed border-gray-200 rounded-xl p-4 text-center hover:border-primary-300 transition cursor-pointer">
                        <input type="file" name="foto_client" accept="image/*" class="hidden" id="fotoInput">
                        <label for="fotoInput" class="cursor-pointer text-sm text-gray-500">
                            <i class="fas fa-cloud-upload-alt mr-1"></i> Upload foto
                        </label>
                        <div id="fotoPreview" class="mt-2 hidden">
                            <img src="" alt="Preview" class="w-16 h-16 object-cover rounded-full mx-auto">
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG. Maks 2MB.</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Portofolio Terkait</label>
                    <select name="portofolio_id" class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                        <option value="">Pilih Proyek (opsional)</option>
                        @foreach($portofolios as $p)
                        <option value="{{ $p->id }}" {{ old('portofolio_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_proyek }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Rating *</label>
                    <div class="flex items-center gap-1" id="ratingStars">
                        @for($i = 1; $i <= 5; $i++)
                        <button type="button" onclick="setRating({{ $i }})"
                                class="text-3xl transition-colors rating-star {{ $i <= old('rating', 5) ? 'text-accent-500' : 'text-gray-300' }}">
                            <i class="fas fa-star"></i>
                        </button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="ratingInput" value="{{ old('rating', 5) }}">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Isi Testimoni *</label>
                    <textarea name="isi_testimoni" rows="4" required
                              class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm resize-none">{{ old('isi_testimoni') }}</textarea>
                </div>

                <!-- STATUS TOGGLE WITH INTERACTIVITY -->
                <label class="flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all duration-300 status-toggle inactive"
                       id="statusToggle">
                    <input type="checkbox" name="is_published" value="1" class="sr-only" id="statusCheckbox">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center transition-all duration-300 status-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <span class="text-sm font-semibold transition-colors duration-300 status-text">Publish</span>
                        <p class="text-xs transition-colors duration-300 status-desc">Centang untuk langsung publish</p>
                    </div>
                </label>
            </div>

            <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                <a href="{{ route('content.testimoni.index') }}"
                   class="px-6 py-2.5 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50 transition font-medium text-sm">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2.5 bg-primary-900 text-white rounded-xl hover:bg-primary-800 transition font-medium text-sm flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan Testimoni
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
    function setRating(rating) {
        document.getElementById('ratingInput').value = rating;
        document.querySelectorAll('.rating-star').forEach((star, i) => {
            star.className = `text-3xl transition-colors rating-star ${i < rating ? 'text-accent-500' : 'text-gray-300'}`;
        });
    }

    document.getElementById('fotoInput')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('fotoPreview');
                preview.classList.remove('hidden');
                preview.querySelector('img').src = e.target.result;
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
            statusDesc.textContent = 'Testimoni akan langsung tayang di publik';
        } else {
            toggle.className = 'flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all duration-300 status-toggle inactive';
            iconBox.className = 'w-10 h-10 rounded-lg flex items-center justify-center transition-all duration-300 status-icon bg-gray-100 text-gray-400';
            statusText.textContent = 'Publish';
            statusDesc.textContent = 'Centang untuk langsung publish';
        }
    });
    </script>
    @endpush
</div>
@endsection