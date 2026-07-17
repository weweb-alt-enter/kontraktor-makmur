@extends('layouts.admin-layout')

@section('title', 'Edit Konsep')

@section('content')
<div class="max-w-lg mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.konsep-inspirasi.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-primary-900 transition text-sm mb-4">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <h1 class="text-2xl font-heading font-bold text-gray-900">Edit Konsep Inspirasi</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8">
        <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl mb-6">
            <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-{{ $konsepInspirasi->icon ?? 'palette' }} text-xl text-indigo-600"></i>
            </div>
            <div>
                <h3 class="font-semibold text-gray-900">{{ $konsepInspirasi->nama_konsep }}</h3>
                <p class="text-xs text-gray-500">{{ $konsepInspirasi->slug }}</p>
            </div>
        </div>

        <form action="{{ route('admin.konsep-inspirasi.update', $konsepInspirasi) }}" method="POST">
            @csrf @method('PUT')
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Konsep *</label>
                    <input type="text" name="nama_konsep" value="{{ old('nama_konsep', $konsepInspirasi->nama_konsep) }}" required
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition-all text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Icon</label>
                    <input type="text" name="icon" value="{{ old('icon', $konsepInspirasi->icon) }}"
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 transition-all text-sm">
                </div>
            </div>
            <div class="flex justify-between items-center mt-8 pt-6 border-t border-gray-100">
                <form action="{{ route('admin.konsep-inspirasi.destroy', $konsepInspirasi) }}" method="POST" onsubmit="return confirm('Hapus konsep ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="px-4 py-2.5 rounded-xl border border-red-200 text-red-600 hover:bg-red-50 transition font-medium text-sm flex items-center gap-2">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
                <div class="flex gap-3">
                    <a href="{{ route('admin.konsep-inspirasi.index') }}" class="px-6 py-2.5 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50 transition font-medium text-sm">Batal</a>
                    <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition font-medium text-sm flex items-center gap-2">
                        <i class="fas fa-save"></i> Update
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection