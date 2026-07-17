@extends('layouts.app')

@section('title', 'Blog & Artikel')
@section('meta_description', 'Baca artikel dan tips seputar konstruksi, desain interior, renovasi, dan properti dari Sekawan Makmur Kontraktor.')

@php
$breadcrumbs = [
    ['title' => 'Blog', 'url' => route('blog.index')]
];
@endphp

@push('styles')
<style>
    .blog-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .blog-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 25px 50px -12px rgba(30, 58, 138, 0.15);
    }
    
    .blog-card:hover .blog-image img {
        transform: scale(1.1);
    }
    
    .blog-image {
        overflow: hidden;
    }
    
    .blog-image img {
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .tag-pill {
        transition: all 0.2s ease;
    }
    
    .tag-pill:hover {
        background-color: #1E3A8A;
        color: white;
        transform: scale(1.05);
    }
</style>
@endpush

@section('content')
<!-- Hero -->
<section class="relative bg-gradient-to-br from-primary-900 via-primary-800 to-primary-900 text-white py-12 lg:py-16">
    <div class="container mx-auto px-4 text-center">
        <x-breadcrumb :breadcrumbs="$breadcrumbs" />
        
        <div class="max-w-3xl mx-auto mt-6">
            <h1 class="text-4xl lg:text-5xl font-heading font-bold mb-4">
                Blog & <span class="text-accent-500">Artikel</span>
            </h1>
            <p class="text-xl text-white/80">
                Tips, inspirasi, dan informasi seputar konstruksi, desain, dan properti
            </p>
        </div>
    </div>
    
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 60" class="w-full h-auto" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 60V30C240 0 480 0 720 30C960 60 1200 60 1440 30V60H0Z" fill="#f9fafb"/>
        </svg>
    </div>
</section>

<div class="container mx-auto px-4 py-12">
    <div class="grid lg:grid-cols-4 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-3">
            @if($blogs->isNotEmpty())
            <div class="grid md:grid-cols-2 gap-6">
                @foreach($blogs as $blog)
                <article class="blog-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group">
                    <!-- Image -->
                    <div class="blog-image relative h-52 overflow-hidden">
                        @if($blog->featured_image)
                        <img src="{{ Storage::url($blog->featured_image) }}" 
                             alt="{{ $blog->judul }}" 
                             class="w-full h-full object-cover"
                             loading="lazy">
                        @else
                        <div class="w-full h-full bg-gradient-to-br from-primary-400 to-primary-600 flex items-center justify-center">
                            <i class="fas fa-newspaper text-5xl text-white/30"></i>
                        </div>
                        @endif
                        
                        <div class="absolute top-3 left-3">
                            <span class="bg-white/90 backdrop-blur-sm text-primary-900 text-xs px-3 py-1.5 rounded-full font-medium">
                                <i class="far fa-calendar mr-1"></i>
                                {{ $blog->published_at?->format('d M Y') ?? $blog->created_at->format('d M Y') }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="p-5">
                        @if($blog->tags)
                        <div class="flex flex-wrap gap-1.5 mb-3">
                            @foreach(array_slice(explode(',', $blog->tags), 0, 3) as $tag)
                            <a href="{{ route('search', ['q' => trim($tag), 'tab' => 'blog']) }}" 
                               class="tag-pill text-[10px] bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full font-medium">
                                {{ trim($tag) }}
                            </a>
                            @endforeach
                        </div>
                        @endif
                        
                        <h3 class="text-lg font-heading font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-primary-900 transition-colors">
                            <a href="{{ route('blog.show', $blog->slug) }}">
                                {{ $blog->judul }}
                            </a>
                        </h3>
                        
                        @if($blog->excerpt)
                        <p class="text-sm text-gray-500 line-clamp-2 mb-4">{{ $blog->excerpt }}</p>
                        @endif
                        
                        <a href="{{ route('blog.show', $blog->slug) }}" 
                           class="inline-flex items-center gap-2 text-primary-900 hover:text-primary-700 font-medium text-sm group/link">
                            Baca Selengkapnya
                            <i class="fas fa-arrow-right text-xs group-hover/link:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </article>
                @endforeach
            </div>
            
            <div class="mt-10">
                {{ $blogs->links() }}
            </div>
            @else
            <div class="text-center py-20">
                <i class="fas fa-newspaper text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-2xl font-heading font-semibold text-gray-600">Belum Ada Artikel</h3>
                <p class="text-gray-500 mt-2">Artikel akan segera hadir</p>
            </div>
            @endif
        </div>
        
        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="sticky top-24 space-y-6">
                <!-- Recent Posts -->
                @if($recentPosts->isNotEmpty())
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-heading font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-clock text-primary-900"></i> Terbaru
                    </h3>
                    <div class="space-y-4">
                        @foreach($recentPosts as $post)
                        <a href="{{ route('blog.show', $post->slug) }}" class="flex gap-3 group">
                            @if($post->featured_image)
                            <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->judul }}" 
                                 class="w-16 h-16 rounded-xl object-cover flex-shrink-0">
                            @else
                            <div class="w-16 h-16 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-newspaper text-gray-400"></i>
                            </div>
                            @endif
                            <div class="min-w-0">
                                <h4 class="text-sm font-medium text-gray-800 group-hover:text-primary-900 transition-colors line-clamp-2">
                                    {{ $post->judul }}
                                </h4>
                                <span class="text-xs text-gray-400">{{ $post->published_at?->format('d M Y') }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <!-- Popular Tags -->
                @if($popularTags->isNotEmpty())
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-heading font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-tags text-primary-900"></i> Tag Populer
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($popularTags as $tag => $count)
                        <a href="{{ route('search', ['q' => $tag, 'tab' => 'blog']) }}" 
                           class="tag-pill inline-flex items-center gap-1 px-3 py-1.5 bg-gray-100 text-gray-600 rounded-full text-xs font-medium">
                            {{ $tag }}
                            <span class="text-gray-400">({{ $count }})</span>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <!-- CTA -->
                <div class="bg-gradient-to-br from-primary-900 to-primary-800 rounded-2xl p-6 text-white text-center">
                    <i class="fas fa-headset text-3xl text-accent-500 mb-3"></i>
                    <h4 class="font-heading font-bold mb-2">Butuh Bantuan?</h4>
                    <p class="text-sm text-white/70 mb-4">Konsultasikan proyek Anda dengan tim ahli kami</p>
                    <a href="{{ route('contact') }}" 
                       class="block bg-accent-500 text-primary-900 py-2.5 rounded-xl font-semibold text-sm hover:bg-accent-400 transition">
                        Konsultasi Gratis
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection