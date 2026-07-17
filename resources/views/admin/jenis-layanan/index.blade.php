@extends('layouts.admin-layout')

@section('title', 'Jenis Layanan')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-heading font-bold text-gray-900">Jenis Layanan</h1>
        <p class="text-gray-500 text-sm mt-1">Kelola kategori layanan yang ditawarkan</p>
    </div>
    <a href="{{ route('admin.jenis-layanan.create') }}" 
       class="inline-flex items-center justify-center gap-2 bg-primary-900 text-white px-5 py-2.5 rounded-xl hover:bg-primary-800 transition font-medium text-sm">
        <i class="fas fa-plus"></i> Tambah Layanan
    </a>
</div>

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
    @forelse($jenisLayanan as $layanan)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-lg transition-all duration-200 group">
        <div class="flex items-start justify-between mb-4">
            <div class="w-12 h-12 bg-primary-50 rounded-xl flex items-center justify-center group-hover:bg-primary-100 transition">
                <i class="fas fa-{{ $layanan->icon ?? 'circle' }} text-xl text-primary-900"></i>
            </div>
            <div class="flex items-center gap-1">
                <a href="{{ route('admin.jenis-layanan.edit', $layanan) }}" 
                   class="w-8 h-8 flex items-center justify-center rounded-lg text-blue-600 hover:bg-blue-50 transition">
                    <i class="fas fa-edit text-sm"></i>
                </a>
                <form action="{{ route('admin.jenis-layanan.destroy', $layanan) }}" method="POST" class="inline"
                      onsubmit="return confirm('Yakin ingin menghapus {{ $layanan->nama_layanan }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg text-red-500 hover:bg-red-50 transition">
                        <i class="fas fa-trash text-sm"></i>
                    </button>
                </form>
            </div>
        </div>
        <h3 class="font-semibold text-gray-900">{{ $layanan->nama_layanan }}</h3>
        <p class="text-xs text-gray-400 mt-1">{{ $layanan->slug }}</p>
        <div class="mt-3 pt-3 border-t border-gray-100">
            <span class="text-xs text-gray-500">
                <i class="far fa-calendar mr-1"></i> {{ $layanan->created_at->format('d M Y') }}
            </span>
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-12">
        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-tools text-2xl text-gray-400"></i>
        </div>
        <h3 class="text-lg font-semibold text-gray-600">Belum Ada Layanan</h3>
        <p class="text-sm text-gray-500 mt-1">Tambahkan jenis layanan baru</p>
    </div>
    @endforelse
</div>

<div>{{ $jenisLayanan->links() }}</div>
@endsection