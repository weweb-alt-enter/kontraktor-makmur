@extends('layouts.admin-layout')

@section('title', 'Tambah Jenis Layanan')

@section('content')
<div class="max-w-lg mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.jenis-layanan.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-primary-900 transition text-sm mb-4">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <h1 class="text-2xl font-heading font-bold text-gray-900">Tambah Jenis Layanan</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8">
        <form action="{{ route('admin.jenis-layanan.store') }}" method="POST">
            @csrf
            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Layanan *</label>
                    <input type="text" name="nama_layanan" value="{{ old('nama_layanan') }}" required
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm"
                           placeholder="Contoh: Bangun Baru">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Icon (Font Awesome)</label>
                    <input type="text" name="icon" value="{{ old('icon') }}" 
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm"
                           placeholder="Contoh: home, wrench, paint-brush">
                    <p class="text-xs text-gray-400 mt-1">Nama icon dari <a href="https://fontawesome.com/icons" target="_blank" class="text-primary-600">Font Awesome</a></p>
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.jenis-layanan.index') }}" class="px-6 py-2.5 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50 transition font-medium text-sm">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-primary-900 text-white rounded-xl hover:bg-primary-800 transition font-medium text-sm flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection