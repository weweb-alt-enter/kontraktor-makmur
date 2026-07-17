@extends('layouts.admin-layout')

@section('title', 'Management Blog')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-heading font-bold text-gray-900">Management Blog</h1>
    <p class="text-gray-500 text-sm mt-1">Semua artikel blog - kelola status publish</p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Artikel</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Publish</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase hidden lg:table-cell">Creator</th>
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
                            <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-newspaper text-gray-400"></i>
                            </div>
                            @endif
                            <div class="min-w-0">
                                <p class="font-medium text-gray-900 text-sm truncate max-w-[200px] lg:max-w-xs">{{ Str::limit($blog->judul, 50) }}</p>
                                <p class="text-xs text-gray-500">{{ Str::limit($blog->excerpt, 40) }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        {{-- Status Draft/Published --}}
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium
                                    {{ $blog->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ $blog->is_published ? 'Published' : 'Draft' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        {{-- Toggle Publish/Unpublish --}}
                        <form action="{{ route('admin.manage-konten.blog.toggle', $blog) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="text-sm font-medium transition-colors
                                           {{ $blog->is_published ? 'text-green-600 hover:text-red-600' : 'text-gray-400 hover:text-green-600' }}"
                                    title="{{ $blog->is_published ? 'Klik untuk unpublish' : 'Klik untuk publish' }}">
                                <i class="fas {{ $blog->is_published ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                {{ $blog->is_published ? 'Unpublish?' : 'Publish' }}
                            </button>
                        </form>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500 hidden lg:table-cell">{{ $blog->creator?->name ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500 hidden xl:table-cell">
                        {{ $blog->published_at ? $blog->published_at->format('d M Y') : '-' }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <a href="{{ route('blog.show', $blog->slug) }}" target="_blank"
                           class="w-8 h-8 inline-flex items-center justify-center rounded-lg text-blue-600 hover:bg-blue-50 transition" title="Lihat">
                            <i class="fas fa-external-link-alt text-sm"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center">
                        <i class="fas fa-newspaper text-4xl text-gray-300 mb-4 block"></i>
                        <p class="text-gray-500">Belum ada artikel</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-6">{{ $blogs->links() }}</div>
@endsection