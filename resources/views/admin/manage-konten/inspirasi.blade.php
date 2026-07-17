@extends('layouts.admin-layout')

@section('title', 'Management Inspirasi Desain')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-heading font-bold text-gray-900">Management Inspirasi Desain</h1>
    <p class="text-gray-500 text-sm mt-1">Semua inspirasi desain - kelola status publish</p>
</div>

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($inspirasi as $item)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-200 {{ !$item->is_published ? 'opacity-75' : '' }}">
        <!-- Image -->
        <div class="relative h-48 overflow-hidden bg-gray-100">
            @if($item->gambar)
            <img src="{{ Storage::url($item->gambar) }}" alt="{{ $item->judul }}" 
                 class="w-full h-full object-cover">
            @else
            <div class="w-full h-full bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center">
                <i class="fas fa-paint-brush text-4xl text-purple-300"></i>
            </div>
            @endif
            
            <!-- Status Badge -->
            <div class="absolute top-3 right-3">
                <span class="px-2.5 py-1 rounded-full text-xs font-medium shadow-lg
                            {{ $item->is_published ? 'bg-green-500 text-white' : 'bg-gray-500 text-white' }}">
                    {{ $item->is_published ? 'Published' : 'Draft' }}
                </span>
            </div>
            
            <!-- Kategori Badge -->
            @if($item->kategori)
            <div class="absolute top-3 left-3">
                <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-white/90 backdrop-blur-sm text-primary-900 shadow-lg">
                    {{ $item->kategori }}
                </span>
            </div>
            @endif
        </div>
        
        <!-- Content -->
        <div class="p-5">
            <!-- Info Tags -->
            <div class="flex flex-wrap gap-1.5 mb-3">
                @if($item->konsep)
                <span class="px-2 py-0.5 bg-purple-50 text-purple-700 rounded-full text-[11px] font-medium">
                    {{ $item->konsep }}
                </span>
                @endif
                @if($item->warna_dominan)
                <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded-full text-[11px]">
                    {{ $item->warna_dominan }}
                </span>
                @endif
            </div>
            
            <!-- Judul -->
            <h3 class="font-heading font-semibold text-gray-900 mb-2 line-clamp-2 text-sm">
                {{ $item->judul }}
            </h3>
            
            <!-- Deskripsi -->
            @if($item->deskripsi)
            <p class="text-xs text-gray-500 line-clamp-2 mb-4">{{ $item->deskripsi }}</p>
            @endif
            
            <!-- Creator & Date -->
            <div class="flex items-center justify-between text-xs text-gray-400 mb-4">
                <span><i class="far fa-user mr-1"></i> {{ $item->creator?->name ?? '-' }}</span>
                <span><i class="far fa-calendar mr-1"></i> {{ $item->created_at->format('d M Y') }}</span>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex items-center gap-2 pt-4 border-t border-gray-100">
                <!-- View Button -->
                <a href="{{ route('inspirasi.show', $item->slug) }}" target="_blank" 
                   class="flex-1 text-center py-2 rounded-xl bg-gray-50 text-gray-700 hover:bg-gray-100 transition text-xs font-medium">
                    <i class="fas fa-eye mr-1"></i> Lihat
                </a>
                
                <!-- Publish/Unpublish Toggle -->
                <form action="{{ route('admin.manage-konten.inspirasi.toggle', $item) }}" method="POST" class="flex-1">
                    @csrf
                    @method('PATCH')
                    <button type="submit" 
                            class="w-full text-center py-2 rounded-xl text-xs font-medium transition-all duration-200
                                   {{ $item->is_published 
                                       ? 'bg-red-50 text-red-600 hover:bg-red-100 border border-red-200' 
                                       : 'bg-green-50 text-green-600 hover:bg-green-100 border border-green-200' }}">
                        <i class="fas {{ $item->is_published ? 'fa-eye-slash' : 'fa-check-circle' }} mr-1"></i>
                        {{ $item->is_published ? 'Unpublish' : 'Publish' }}
                    </button>
                </form>
            </div>
            
            <!-- Tags -->
            @if($item->tags)
            <div class="flex flex-wrap gap-1 mt-3 pt-3 border-t border-gray-100">
                @foreach(array_slice(explode(',', $item->tags), 0, 3) as $tag)
                <span class="px-2 py-0.5 bg-gray-100 text-gray-500 rounded-full text-[10px]">{{ trim($tag) }}</span>
                @endforeach
                @if(count(explode(',', $item->tags)) > 3)
                <span class="text-[10px] text-gray-400">+{{ count(explode(',', $item->tags)) - 3 }}</span>
                @endif
            </div>
            @endif
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-16">
        <div class="w-20 h-20 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-paint-brush text-3xl text-gray-400"></i>
        </div>
        <h3 class="text-lg font-semibold text-gray-600 mb-1">Belum Ada Inspirasi Desain</h3>
        <p class="text-sm text-gray-500">Content writer belum menambahkan inspirasi desain</p>
    </div>
    @endforelse
</div>

<div class="mt-6">
    {{ $inspirasi->links() }}
</div>
@endsection