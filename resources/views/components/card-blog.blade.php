@props(['blog'])

<article class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
    <div class="relative">
        @if($blog->featured_image)
        <img src="{{ storage_url($blog->featured_image) }}"
             alt="{{ $blog->judul }}"
             class="w-full h-48 object-cover">
        @else
        <div class="w-full h-48 bg-gradient-to-br from-primary-500 to-primary-900 flex items-center justify-center">
            <i class="fas fa-newspaper text-4xl text-white/50"></i>
        </div>
        @endif

        @if($blog->tags)
        <div class="absolute bottom-2 left-2 flex flex-wrap gap-1">
            @foreach(explode(',', $blog->tags) as $tag)
            <span class="text-xs bg-white/90 text-primary-900 px-2 py-1 rounded-full">
                {{ trim($tag) }}
            </span>
            @endforeach
        </div>
        @endif
    </div>

    <div class="p-4">
        <div class="text-xs text-gray-500 mb-2">
            <i class="far fa-calendar mr-1"></i>
            {{ $blog->published_at?->format('d M Y') ?? $blog->created_at->format('d M Y') }}
        </div>

        <h3 class="text-lg font-heading font-semibold text-gray-800 mb-2 line-clamp-2">
            <a href="{{ route('blog.show', $blog->slug) }}" class="hover:text-primary-900 transition">
                {{ $blog->judul }}
            </a>
        </h3>

        @if($blog->excerpt)
        <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $blog->excerpt }}</p>
        @endif

        <a href="{{ route('blog.show', $blog->slug) }}"
           class="inline-flex items-center text-primary-900 hover:text-primary-700 font-medium text-sm">
            Baca Selengkapnya
            <i class="fas fa-arrow-right ml-2"></i>
        </a>
    </div>
</article>