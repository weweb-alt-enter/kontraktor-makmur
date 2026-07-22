@extends('layouts.content-layout')

@section('title', 'Inspirasi Saya')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-heading font-bold text-gray-900">Inspirasi Saya</h1>
        <p class="text-gray-500 text-sm mt-1">Kelola inspirasi desain yang Anda buat</p>
    </div>
    <a href="{{ route('content.inspirasi.create') }}"
       class="inline-flex items-center justify-center gap-2 bg-primary-900 text-white px-5 py-2.5 rounded-xl hover:bg-primary-800 transition font-medium text-sm">
        <i class="fas fa-plus"></i> Tambah Inspirasi
    </a>
</div>

@php
    // PERBAIKAN: Gunakan $inspirasi, bukan $blogs
    $totalPublished = $inspirasi->where('is_published', true)->count();
    $totalDraft = $inspirasi->where('is_published', false)->count();
@endphp

<div class="grid grid-cols-2 gap-4 mb-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 text-center">
        <div class="text-2xl font-bold text-green-600">{{ $totalPublished }}</div>
        <div class="text-xs text-gray-500">Published</div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 text-center">
        <div class="text-2xl font-bold text-gray-400">{{ $totalDraft }}</div>
        <div class="text-xs text-gray-500">Draft</div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Inspirasi</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase hidden lg:table-cell">Kategori</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($inspirasi as $item)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if($item->gambar)
                            <img src="{{ storage_url($item->gambar) }}" class="w-12 h-12 rounded-xl object-cover flex-shrink-0">
                            @else
                            <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-paint-brush text-purple-400"></i>
                            </div>
                            @endif
                            <div class="min-w-0">
                                <p class="font-medium text-gray-900 text-sm truncate max-w-[200px]">{{ $item->judul }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ Str::limit($item->deskripsi ?? '', 50) }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 hidden lg:table-cell">
                        <div class="flex flex-wrap gap-1">
                            @if($item->kategori)
                            <span class="px-2 py-0.5 bg-purple-50 text-purple-700 rounded-full text-xs font-medium">
                                {{ $item->kategori }}
                            </span>
                            @endif
                            @if($item->konsep)
                            <span class="px-2 py-0.5 bg-indigo-50 text-indigo-700 rounded-full text-xs">
                                {{ $item->konsep }}
                            </span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium
                                    {{ $item->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                            <i class="fas fa-circle text-[6px]"></i>
                            {{ $item->is_published ? 'Published' : 'Draft' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-1">
                            <a href="{{ route('inspirasi.show', $item->slug) }}" target="_blank"
                               class="w-8 h-8 flex items-center justify-center rounded-lg text-green-600 hover:bg-green-50 transition" title="Lihat">
                                <i class="fas fa-eye text-sm"></i>
                            </a>
                            <a href="{{ route('content.inspirasi.edit', $item) }}"
                               class="w-8 h-8 flex items-center justify-center rounded-lg text-blue-600 hover:bg-blue-50 transition" title="Edit">
                                <i class="fas fa-edit text-sm"></i>
                            </a>
                            <form action="{{ route('content.inspirasi.destroy', $item) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Yakin ingin menghapus inspirasi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg text-red-500 hover:bg-red-50 transition" title="Hapus">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-16 text-center">
                        <div class="w-20 h-20 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-paint-brush text-3xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-600 mb-1">Belum Ada Inspirasi</h3>
                        <p class="text-sm text-gray-500 mb-4">Mulai tambahkan inspirasi desain pertama Anda</p>
                        <a href="{{ route('content.inspirasi.create') }}"
                           class="inline-flex items-center gap-2 bg-primary-900 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-primary-800 transition">
                            <i class="fas fa-plus"></i> Tambah Inspirasi
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-6">{{ $inspirasi->links() }}</div>
@endsection