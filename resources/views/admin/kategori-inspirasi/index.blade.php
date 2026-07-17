@extends('layouts.admin-layout')

@section('title', 'Kategori Inspirasi')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-heading font-bold text-gray-900">Kategori Inspirasi</h1>
        <p class="text-gray-500 text-sm mt-1">Kelola kategori inspirasi desain</p>
    </div>
    <a href="{{ route('admin.kategori-inspirasi.create') }}" 
       class="inline-flex items-center justify-center gap-2 bg-purple-600 text-white px-5 py-2.5 rounded-xl hover:bg-purple-700 transition font-medium text-sm">
        <i class="fas fa-plus"></i> Tambah Kategori
    </a>
</div>

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse($kategori as $item)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-lg transition-all duration-200 group">
        <div class="flex items-start justify-between mb-4">
            <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center group-hover:bg-purple-100 transition">
                <i class="fas fa-{{ $item->icon ?? 'folder' }} text-xl text-purple-600"></i>
            </div>
            <div class="flex items-center gap-1">
                <a href="{{ route('admin.kategori-inspirasi.edit', $item) }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-blue-600 hover:bg-blue-50 transition">
                    <i class="fas fa-edit text-sm"></i>
                </a>
                <form action="{{ route('admin.kategori-inspirasi.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg text-red-500 hover:bg-red-50 transition">
                        <i class="fas fa-trash text-sm"></i>
                    </button>
                </form>
            </div>
        </div>
        <h3 class="font-semibold text-gray-900">{{ $item->nama_kategori }}</h3>
        <p class="text-xs text-gray-400 mt-1">{{ $item->slug }}</p>
    </div>
    @empty
    <div class="col-span-full text-center py-12 text-gray-500">Belum ada kategori</div>
    @endforelse
</div>
<div class="mt-6">{{ $kategori->links() }}</div>
@endsection