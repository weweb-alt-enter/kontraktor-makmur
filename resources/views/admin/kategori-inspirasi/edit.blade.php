@extends('layouts.admin-layout')

@section('title', 'Edit Kategori')

@section('content')
<div class="max-w-lg mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.kategori-inspirasi.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-primary-900 transition text-sm mb-4">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <h1 class="text-2xl font-heading font-bold text-gray-900">Edit Kategori Inspirasi</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8">
        <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl mb-6">
            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-{{ $kategoriInspirasi->icon ?? 'folder' }} text-xl text-purple-600"></i>
            </div>
            <div>
                <h3 class="font-semibold text-gray-900">{{ $kategoriInspirasi->nama_kategori }}</h3>
                <p class="text-xs text-gray-500">{{ $kategoriInspirasi->slug }}</p>
            </div>
        </div>

        <form action="{{ route('admin.kategori-inspirasi.update', $kategoriInspirasi) }}" method="POST">
            @csrf @method('PUT')
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kategori *</label>
                    <input type="text" name="nama_kategori" value="{{ old('nama_kategori', $kategoriInspirasi->nama_kategori) }}" required
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-purple-500 focus:ring-2 focus:ring-purple-100 transition-all text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Icon</label>
                    <input type="text" name="icon" value="{{ old('icon', $kategoriInspirasi->icon) }}"
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-purple-500 focus:ring-2 focus:ring-purple-100 transition-all text-sm">
                </div>
            </div>
            <div class="flex justify-between items-center mt-8 pt-6 border-t border-gray-100">
                <form action="{{ route('admin.kategori-inspirasi.destroy', $kategoriInspirasi) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="px-4 py-2.5 rounded-xl border border-red-200 text-red-600 hover:bg-red-50 transition font-medium text-sm flex items-center gap-2">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
                <div class="flex gap-3">
                    <a href="{{ route('admin.kategori-inspirasi.index') }}" class="px-6 py-2.5 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50 transition font-medium text-sm">Batal</a>
                    <button type="submit" class="px-6 py-2.5 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition font-medium text-sm flex items-center gap-2">
                        <i class="fas fa-save"></i> Update
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection