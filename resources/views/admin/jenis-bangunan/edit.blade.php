@extends('layouts.admin-layout')

@section('title', 'Edit Jenis Bangunan')

@section('content')
<div class="max-w-lg mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.jenis-bangunan.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-primary-900 transition text-sm mb-4">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <h1 class="text-2xl font-heading font-bold text-gray-900">Edit Jenis Bangunan</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8">
        <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl mb-6">
            <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-{{ $jenisBangunan->icon ?? 'building' }} text-xl text-primary-900"></i>
            </div>
            <div>
                <h3 class="font-semibold text-gray-900">{{ $jenisBangunan->nama_bangunan }}</h3>
                <p class="text-xs text-gray-500">{{ $jenisBangunan->slug }}</p>
            </div>
        </div>

        <form action="{{ route('admin.jenis-bangunan.update', $jenisBangunan) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Bangunan *</label>
                    <input type="text" name="nama_bangunan" value="{{ old('nama_bangunan', $jenisBangunan->nama_bangunan) }}" required
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Icon (Font Awesome)</label>
                    <input type="text" name="icon" value="{{ old('icon', $jenisBangunan->icon) }}" 
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                </div>
            </div>
                    <!-- ... semua field form di atas tetap sama ... -->

            <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.jenis-bangunan.index') }}" 
                   class="px-6 py-2.5 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50 transition font-medium text-sm">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 bg-primary-900 text-white rounded-xl hover:bg-primary-800 transition font-medium text-sm flex items-center gap-2">
                    <i class="fas fa-save"></i> Update Bangunan
                </button>
            </div>
        </form>

        {{-- FORM DELETE DIPISAH --}}
        <form action="{{ route('admin.jenis-bangunan.destroy', $jenisBangunan) }}" method="POST" class="mt-4"
              onsubmit="return confirm('Yakin ingin menghapus bangunan {{ $jenisBangunan->nama_bangunan }}? Portofolio yang terkait akan kehilangan kategori bangunannya.')">
            @csrf
            @method('DELETE')
            <button type="submit" 
                    class="px-4 py-2.5 rounded-xl border border-red-200 text-red-600 hover:bg-red-50 transition font-medium text-sm flex items-center gap-2">
                <i class="fas fa-trash"></i> Hapus Bangunan
            </button>
        </form>
    </div>
</div>
@endsection