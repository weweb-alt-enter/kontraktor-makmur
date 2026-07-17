@extends('layouts.content-layout')

@section('title', 'Blog Saya')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-heading font-bold text-gray-900">Blog Saya</h1>
        <p class="text-gray-500 text-sm mt-1">Kelola artikel blog yang Anda tulis</p>
    </div>
    <a href="{{ route('content.blog.create') }}" 
       class="inline-flex items-center justify-center gap-2 bg-primary-900 text-white px-5 py-2.5 rounded-xl hover:bg-primary-800 transition font-medium text-sm">
        <i class="fas fa-plus"></i> Tulis Blog
    </a>
</div>

@php
    $totalPublished = $blogs->where('is_published', true)->count();
    $totalDraft = $blogs->where('is_published', false)->count();
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
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Artikel</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase hidden lg:table-cell">Tags</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase hidden xl:table-cell">Tanggal</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($blogs as $blog)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if($blog->featured_image)
                            <img src="{{ Storage::url($blog->featured_image) }}" class="w-12 h-12 rounded-xl object-cover flex-shrink-0">
                            @else
                            <div class="w-12 h-12 bg-gradient-to-br from-primary-100 to-primary-200 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-newspaper text-primary-400"></i>
                            </div>
                            @endif
                            <div class="min-w-0">
                                <p class="font-medium text-gray-900 text-sm truncate max-w-[200px] lg:max-w-md">{{ $blog->judul }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ Str::limit($blog->excerpt, 50) }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium
                                    {{ $blog->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                            <i class="fas fa-circle text-[6px]"></i>
                            {{ $blog->is_published ? 'Published' : 'Draft' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 hidden lg:table-cell">
                        @if($blog->tags)
                        <div class="flex flex-wrap gap-1">
                            @foreach(array_slice(explode(',', $blog->tags), 0, 3) as $tag)
                            <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded-full text-xs">{{ trim($tag) }}</span>
                            @endforeach
                        </div>
                        @else
                        <span class="text-xs text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500 hidden xl:table-cell">{{ $blog->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-1">
                            <a href="{{ route('blog.show', $blog->slug) }}" target="_blank" 
                               class="w-8 h-8 flex items-center justify-center rounded-lg text-green-600 hover:bg-green-50 transition" title="Lihat">
                                <i class="fas fa-eye text-sm"></i>
                            </a>
                            <a href="{{ route('content.blog.edit', $blog) }}" 
                               class="w-8 h-8 flex items-center justify-center rounded-lg text-blue-600 hover:bg-blue-50 transition" title="Edit">
                                <i class="fas fa-edit text-sm"></i>
                            </a>
                            <form action="{{ route('content.blog.destroy', $blog) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
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
                    <td colspan="5" class="px-6 py-16 text-center">
                        <div class="w-20 h-20 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-newspaper text-3xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-600 mb-1">Belum Ada Artikel</h3>
                        <p class="text-sm text-gray-500 mb-4">Mulai tulis artikel blog pertama Anda</p>
                        <a href="{{ route('content.blog.create') }}" 
                           class="inline-flex items-center gap-2 bg-primary-900 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-primary-800 transition">
                            <i class="fas fa-pen"></i> Tulis Blog
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-6">{{ $blogs->links() }}</div>
@endsection