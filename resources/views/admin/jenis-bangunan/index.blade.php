@extends('layouts.admin-layout')

@section('title', 'Jenis Bangunan')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-heading font-bold text-gray-900">Jenis Bangunan</h1>
        <p class="text-gray-500 text-sm mt-1">Kelola kategori bangunan</p>
    </div>
    <a href="{{ route('admin.jenis-bangunan.create') }}" 
       class="inline-flex items-center justify-center gap-2 bg-primary-900 text-white px-5 py-2.5 rounded-xl hover:bg-primary-800 transition font-medium text-sm">
        <i class="fas fa-plus"></i> Tambah Bangunan
    </a>
</div>

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
    @forelse($jenisBangunan as $bangunan)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-lg transition-all duration-200 group">
        <div class="flex items-start justify-between mb-4">
            <div class="w-12 h-12 bg-primary-50 rounded-xl flex items-center justify-center group-hover:bg-primary-100 transition">
                <i class="fas fa-{{ $bangunan->icon ?? 'building' }} text-xl text-primary-900"></i>
            </div>
            <div class="flex items-center gap-1">
                <a href="{{ route('admin.jenis-bangunan.edit', $bangunan) }}" 
                   class="w-8 h-8 flex items-center justify-center rounded-lg text-blue-600 hover:bg-blue-50 transition">
                    <i class="fas fa-edit text-sm"></i>
                </a>
                <form action="{{ route('admin.jenis-bangunan.destroy', $bangunan) }}" method="POST" class="inline"
                      onsubmit="return confirm('Yakin ingin menghapus {{ $bangunan->nama_bangunan }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg text-red-500 hover:bg-red-50 transition">
                        <i class="fas fa-trash text-sm"></i>
                    </button>
                </form>
            </div>
        </div>
        <h3 class="font-semibold text-gray-900">{{ $bangunan->nama_bangunan }}</h3>
        <p class="text-xs text-gray-400 mt-1">{{ $bangunan->slug }}</p>
    </div>
    @empty
    <div class="col-span-full text-center py-12">
        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-building text-2xl text-gray-400"></i>
        </div>
        <h3 class="text-lg font-semibold text-gray-600">Belum Ada Bangunan</h3>
        <p class="text-sm text-gray-500 mt-1">Tambahkan jenis bangunan baru</p>
    </div>
    @endforelse
</div>

<div>{{ $jenisBangunan->links() }}</div>
@endsection