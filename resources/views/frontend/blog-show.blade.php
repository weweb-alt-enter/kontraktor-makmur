@extends('layouts.app')

@section('title', $blog->judul)
@section('meta_description', $blog->excerpt ?? Str::limit(strip_tags($blog->konten), 160))

@php
$breadcrumbs = [
    ['title' => 'Blog', 'url' => route('blog.index')],
    ['title' => $blog->judul]
];
@endphp

@push('styles')
<style>
    .prose-content {
        color: #374151;
        line-height: 1.8;
    }
    .prose-content h2 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1F2937;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }
    .prose-content h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1F2937;
        margin-top: 1.5rem;
        margin-bottom: 0.75rem;
    }
    .prose-content p {
        margin-bottom: 1rem;
    }
    .prose-content ul, .prose-content ol {
        margin-bottom: 1rem;
        padding-left: 1.5rem;
    }
    .prose-content li {
        margin-bottom: 0.5rem;
    }
    .prose-content img {
        border-radius: 1rem;
        margin: 1.5rem 0;
    }
    .share-btn {
        transition: all 0.2s ease;
    }
    .share-btn:hover {
        transform: translateY(-2px);
    }
</style>
@endpush

@section('content')
<article>
    <section class="relative bg-gradient-to-br from-primary-900 via-primary-800 to-primary-900 text-white py-12 lg:py-16">
        <div class="container mx-auto px-4">
            <x-breadcrumb :breadcrumbs="$breadcrumbs" />
            <div class="max-w-4xl mx-auto mt-6">
                <div class="flex flex-wrap items-center gap-4 text-sm text-white/70 mb-4">
                    <span class="flex items-center gap-1.5">
                        <i class="far fa-calendar"></i>
                        {{ $blog->published_at?->format('d M Y') ?? $blog->created_at->format('d M Y') }}
                    </span>
                    @if($blog->creator)
                    <span class="flex items-center gap-1.5">
                        <i class="far fa-user"></i>
                        {{ $blog->creator->name }}
                    </span>
                    @endif
                </div>
                <h1 class="text-3xl lg:text-4xl font-heading font-bold mb-4">
                    {{ $blog->judul }}
                </h1>
                @if($blog->tags)
                <div class="flex flex-wrap gap-2">
                    @foreach(explode(',', $blog->tags) as $tag)
                    <span class="px-3 py-1 bg-white/10 backdrop-blur-sm rounded-full text-xs font-medium">
                        {{ trim($tag) }}
                    </span>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 40" class="w-full h-auto" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 40V20C240 0 480 0 720 20C960 40 1200 40 1440 20V40H0Z" fill="#f9fafb"/>
            </svg>
        </div>
    </section>

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            @if($blog->featured_image)
            <div class="rounded-2xl overflow-hidden shadow-xl mb-8 -mt-24 relative z-10">
                <img src="{{ storage_url($blog->featured_image) }}"
                     alt="{{ $blog->judul }}"
                     class="w-full h-[400px] object-cover">
            </div>
            @endif

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 lg:p-12 mb-8">
                <div class="prose-content max-w-none">
                    {!! $blog->konten !!}
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <span class="font-semibold text-gray-900">Bagikan Artikel:</span>
                    <div class="flex gap-2">
                        <a href="https://wa.me/?text={{ urlencode($blog->judul . ' - ' . route('blog.show', $blog->slug)) }}"
                           target="_blank" rel="noopener"
                           class="share-btn bg-green-500 text-white px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-green-600">
                            <i class="fab fa-whatsapp mr-1.5"></i> WhatsApp
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $blog->slug)) }}"
                           target="_blank" rel="noopener"
                           class="share-btn bg-blue-600 text-white px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-blue-700">
                            <i class="fab fa-facebook mr-1.5"></i> Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $blog->slug)) }}&text={{ urlencode($blog->judul) }}"
                           target="_blank" rel="noopener"
                           class="share-btn bg-sky-500 text-white px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-sky-600">
                            <i class="fab fa-twitter mr-1.5"></i> Twitter
                        </a>
                        <button onclick="copyLink()"
                                class="share-btn bg-gray-500 text-white px-4 py-2.5 rounded-xl text-sm font-medium hover:bg-gray-600">
                            <i class="fas fa-link mr-1.5"></i> Copy Link
                        </button>
                    </div>
                </div>
            </div>

            @if($recentPosts->isNotEmpty())
            <div>
                <h3 class="text-2xl font-heading font-bold text-gray-900 mb-6">Artikel Lainnya</h3>
                <div class="grid md:grid-cols-3 gap-6">
                    @foreach($recentPosts as $post)
                    <article class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300 group">
                        <div class="h-40 overflow-hidden">
                            @if($post->featured_image)
                            <img src="{{ storage_url($post->featured_image) }}" alt="{{ $post->judul }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                            <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                <i class="fas fa-newspaper text-3xl text-gray-300"></i>
                            </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <h4 class="font-semibold text-gray-900 line-clamp-2 group-hover:text-primary-900 transition-colors text-sm">
                                <a href="{{ route('blog.show', $post->slug) }}">{{ $post->judul }}</a>
                            </h4>
                            <span class="text-xs text-gray-400 mt-2 block">{{ $post->published_at?->format('d M Y') }}</span>
                        </div>
                    </article>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</article>
@endsection

@push('scripts')
<script>
function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(() => {
        alert('Link berhasil disalin!');
    });
}
</script>
@endpush