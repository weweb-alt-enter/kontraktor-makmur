@extends('layouts.content-layout')

@section('title', 'Edit Testimoni')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('content.testimoni.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-primary-900 transition text-sm mb-4">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <h1 class="text-2xl font-heading font-bold text-gray-900">Edit Testimoni</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8">
        <form action="{{ route('content.testimoni.update', $testimoni) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Klien *</label>
                    <input type="text" name="nama_client" value="{{ old('nama_client', $testimoni->nama_client) }}" required
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Klien</label>
                    @if($testimoni->foto_client)
                    <img src="{{ Storage::url($testimoni->foto_client) }}" class="w-16 h-16 rounded-xl object-cover mb-2">
                    @endif
                    <input type="file" name="foto_client" accept="image/*"
                           class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-primary-50 file:text-primary-900">
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Portofolio Terkait</label>
                    <select name="portofolio_id" class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                        <option value="">Pilih Proyek</option>
                        @foreach($portofolios as $p)
                        <option value="{{ $p->id }}" {{ old('portofolio_id', $testimoni->portofolio_id) == $p->id ? 'selected' : '' }}>{{ $p->nama_proyek }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">Rating *</label>
                    <div class="flex items-center gap-1" id="ratingStars">
                        @for($i = 1; $i <= 5; $i++)
                        <button type="button" onclick="setRating({{ $i }})" 
                                class="text-3xl transition-colors rating-star {{ $i <= old('rating', $testimoni->rating) ? 'text-accent-500' : 'text-gray-300' }}">
                            <i class="fas fa-star"></i>
                        </button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="ratingInput" value="{{ old('rating', $testimoni->rating) }}">
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Isi Testimoni *</label>
                    <textarea name="isi_testimoni" rows="4" required
                              class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm resize-none">{{ old('isi_testimoni', $testimoni->isi_testimoni) }}</textarea>
                </div>
                
                        <!-- ... semua field form di atas tetap sama ... -->

            <label class="flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all
                          {{ $testimoni->is_published ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-gray-300' }}">
                <input type="checkbox" name="is_published" value="1" {{ $testimoni->is_published ? 'checked' : '' }} class="sr-only">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center {{ $testimoni->is_published ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-400' }}">
                    <i class="fas fa-check"></i>
                </div>
                <span class="text-sm font-semibold text-gray-900">{{ $testimoni->is_published ? 'Published' : 'Publish' }}</span>
            </label>
        </div>
        
        {{-- TOMBOL UPDATE (DALAM FORM INI) --}}
        <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
            <a href="{{ route('content.testimoni.index') }}" 
               class="px-6 py-2.5 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50 transition font-medium text-sm">
                Batal
            </a>
            <button type="submit" 
                    class="px-6 py-2.5 bg-primary-900 text-white rounded-xl hover:bg-primary-800 transition font-medium text-sm flex items-center gap-2">
                <i class="fas fa-save"></i> Update Testimoni
            </button>
        </div>
    </form>

    {{-- FORM DELETE DIPISAH --}}
    <form action="{{ route('content.testimoni.destroy', $testimoni) }}" method="POST" class="mt-4"
          onsubmit="return confirm('Yakin ingin menghapus testimoni ini? Data tidak dapat dikembalikan.')">
        @csrf
        @method('DELETE')
        <button type="submit" 
                class="px-4 py-2.5 rounded-xl border border-red-200 text-red-600 hover:bg-red-50 transition font-medium text-sm flex items-center gap-2">
            <i class="fas fa-trash"></i> Hapus Testimoni
        </button>
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

// Preview foto baru
document.querySelector('input[name="foto_client"]')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.querySelector('img[src*="testimoni"]');
            if (preview) {
                preview.src = e.target.result;
            }
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endpush
@endsection