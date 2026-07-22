@extends('layouts.app')

@section('title', $query ? 'Hasil Pencarian: ' . $query : 'Pencarian')

@php
$breadcrumbs = [
    ['title' => 'Pencarian', 'url' => route('search')]
];
@endphp

@push('styles')
<style>
    .tab-btn {
        position: relative;
        transition: all 0.2s ease;
    }
    .tab-btn.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        right: 0;
        height: 3px;
        background-color: #1E3A8A;
        border-radius: 3px 3px 0 0;
    }
    .search-highlight {
        background: linear-gradient(180deg, transparent 60%, #FDE68A 60%);
        padding: 0 2px;
    }
    .result-card {
        transition: all 0.3s ease;
    }
    .result-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px -10px rgba(30, 58, 138, 0.12);
    }
    .empty-state-icon {
        animation: float 3s ease-in-out infinite;
    }
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
</style>
@endpush

@section('content')
<section class="relative bg-gradient-to-br from-primary-900 via-primary-800 to-primary-900 text-white py-12 lg:py-16">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'40\' height=\'40\' viewBox=\'0 0 40 40\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M0 0h40v40H0V0zm1 1v38h38V1H1z\'/%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>
    <div class="container mx-auto px-4">
        <x-breadcrumb :breadcrumbs="$breadcrumbs" />
        <div class="max-w-3xl mx-auto mt-6 text-center">
            <h1 class="text-3xl lg:text-4xl font-heading font-bold mb-4">
                <i class="fas fa-search text-accent-500 mr-3"></i>
                Pencarian
            </h1>
            <form action="{{ route('search') }}" method="GET" class="mt-6">
                <div class="relative max-w-2xl mx-auto">
                    <input type="text" name="q" value="{{ $query }}"
                           placeholder="Cari proyek, artikel, inspirasi, atau testimoni..."
                           class="w-full pl-12 pr-24 py-4 rounded-2xl border-0 text-gray-900 text-lg
                                  focus:ring-4 focus:ring-accent-500/30 shadow-xl transition-all"
                           autofocus>
                    <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-gray-400 text-xl"></i>
                    @if($query)
                    <a href="{{ route('search') }}"
                       class="absolute right-24 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </a>
                    @endif
                    <button type="submit"
                            class="absolute right-2 top-1/2 -translate-y-1/2 bg-primary-900 text-white px-6 py-2.5 rounded-xl
                                   hover:bg-primary-800 transition font-medium text-sm">
                        Cari
                    </button>
                </div>
            </form>
            @if($query)
            <p class="text-white/60 mt-3 text-sm">
                Menampilkan <strong class="text-white">{{ $totalResults }}</strong> hasil untuk:
                <strong class="text-white">"{{ $query }}"</strong>
            </p>
            @endif
        </div>
    </div>
</section>

<div class="container mx-auto px-4 py-8">
    @if($query)
        @php $activeTab = request('tab', 'portofolio'); @endphp
        <div class="border-b border-gray-200 mb-8 overflow-x-auto">
            <nav class="flex gap-1 md:gap-8 -mb-px whitespace-nowrap">
                <a href="{{ route('search', ['q' => $query, 'tab' => 'portofolio']) }}"
                   class="tab-btn {{ $activeTab == 'portofolio' ? 'active' : '' }} pb-4 px-2 text-sm font-medium transition-colors
                          {{ $activeTab == 'portofolio' ? 'text-primary-900' : 'text-gray-500 hover:text-gray-700' }}">
                    <i class="fas fa-briefcase mr-1.5"></i>
                    Portofolio
                    <span class="ml-1.5 px-2 py-0.5 bg-gray-100 text-gray-600 rounded-full text-xs">
                        {{ $portofolios->total() }}
                    </span>
                </a>
                <a href="{{ route('search', ['q' => $query, 'tab' => 'blog']) }}"
                   class="tab-btn {{ $activeTab == 'blog' ? 'active' : '' }} pb-4 px-2 text-sm font-medium transition-colors
                          {{ $activeTab == 'blog' ? 'text-primary-900' : 'text-gray-500 hover:text-gray-700' }}">
                    <i class="fas fa-newspaper mr-1.5"></i>
                    Blog
                    <span class="ml-1.5 px-2 py-0.5 bg-gray-100 text-gray-600 rounded-full text-xs">
                        {{ $blogs->total() }}
                    </span>
                </a>
                <a href="{{ route('search', ['q' => $query, 'tab' => 'inspirasi']) }}"
                   class="tab-btn {{ $activeTab == 'inspirasi' ? 'active' : '' }} pb-4 px-2 text-sm font-medium transition-colors
                          {{ $activeTab == 'inspirasi' ? 'text-purple-600' : 'text-gray-500 hover:text-gray-700' }}">
                    <i class="fas fa-paint-brush mr-1.5"></i>
                    Inspirasi
                    <span class="ml-1.5 px-2 py-0.5 bg-gray-100 text-gray-600 rounded-full text-xs">
                        {{ $inspirasi->total() }}
                    </span>
                </a>
                <a href="{{ route('search', ['q' => $query, 'tab' => 'testimoni']) }}"
                   class="tab-btn {{ $activeTab == 'testimoni' ? 'active' : '' }} pb-4 px-2 text-sm font-medium transition-colors
                          {{ $activeTab == 'testimoni' ? 'text-yellow-600' : 'text-gray-500 hover:text-gray-700' }}">
                    <i class="fas fa-star mr-1.5"></i>
                    Testimoni
                    <span class="ml-1.5 px-2 py-0.5 bg-gray-100 text-gray-600 rounded-full text-xs">
                        {{ $testimonis->total() }}
                    </span>
                </a>
            </nav>
        </div>

        @if($activeTab == 'portofolio')
            @if($portofolios->isNotEmpty())
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($portofolios as $portofolio)
                <div class="result-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group">
                    <div class="relative h-48 overflow-hidden">
                        @if($portofolio->galleries->isNotEmpty())
                        <img src="{{ storage_url($portofolio->galleries->first()->image_path) }}"
                             alt="{{ $portofolio->nama_proyek }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                             loading="lazy">
                        @else
                        <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                            <i class="fas fa-image text-4xl text-gray-300"></i>
                        </div>
                        @endif
                        <div class="absolute top-3 right-3">
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-white/90 backdrop-blur-sm text-primary-900">
                                {{ $portofolio->jenisLayanan?->nama_layanan ?? 'Proyek' }}
                            </span>
                        </div>
                    </div>
                    <div class="p-5">
                        <h3 class="font-heading font-semibold text-gray-900 mb-2 line-clamp-2">
                            <a href="{{ route('portofolio.detail', $portofolio->slug) }}" class="hover:text-primary-900">
                                {{ $portofolio->nama_proyek }}
                            </a>
                        </h3>
                        <p class="text-sm text-gray-500 mb-3 flex items-center gap-1">
                            <i class="fas fa-map-marker-alt text-primary-600"></i>
                            {{ Str::limit($portofolio->lokasi, 40) }}
                        </p>
                        <a href="{{ route('portofolio.detail', $portofolio->slug) }}"
                           class="inline-flex items-center text-primary-900 hover:text-primary-700 text-sm font-medium">
                            Lihat Detail <i class="fas fa-arrow-right ml-1.5 text-xs"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-16">
                <i class="fas fa-folder-open text-5xl text-gray-300 empty-state-icon mb-4 block"></i>
                <h3 class="text-xl font-heading font-semibold text-gray-600">Tidak ada portofolio ditemukan</h3>
                <p class="text-gray-500 mt-2">Coba gunakan kata kunci lain</p>
            </div>
            @endif
            @if($portofolios->hasPages())
            <div class="mt-8">{{ $portofolios->appends(['q' => $query, 'tab' => 'portofolio'])->links() }}</div>
            @endif
        @endif

        @if($activeTab == 'blog')
            @if($blogs->isNotEmpty())
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($blogs as $blog)
                <article class="result-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group">
                    <div class="relative h-48 overflow-hidden">
                        @if($blog->featured_image)
                        <img src="{{ storage_url($blog->featured_image) }}" alt="{{ $blog->judul }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                        <div class="w-full h-full bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                            <i class="fas fa-newspaper text-4xl text-primary-400/50"></i>
                        </div>
                        @endif
                    </div>
                    <div class="p-5">
                        <div class="text-xs text-gray-500 mb-2">
                            <i class="far fa-calendar mr-1"></i>
                            {{ $blog->published_at?->format('d M Y') ?? $blog->created_at->format('d M Y') }}
                        </div>
                        <h3 class="font-heading font-semibold text-gray-900 mb-2 line-clamp-2">
                            <a href="{{ route('blog.show', $blog->slug) }}" class="hover:text-primary-900">
                                {{ $blog->judul }}
                            </a>
                        </h3>
                        @if($blog->excerpt)
                        <p class="text-sm text-gray-500 line-clamp-2 mb-3">{{ $blog->excerpt }}</p>
                        @endif
                        @if($blog->tags)
                        <div class="flex flex-wrap gap-1 mb-3">
                            @foreach(array_slice(explode(',', $blog->tags), 0, 3) as $tag)
                            <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded-full text-[10px]">{{ trim($tag) }}</span>
                            @endforeach
                        </div>
                        @endif
                        <a href="{{ route('blog.show', $blog->slug) }}"
                           class="inline-flex items-center text-primary-900 hover:text-primary-700 text-sm font-medium">
                            Baca Selengkapnya <i class="fas fa-arrow-right ml-1.5 text-xs"></i>
                        </a>
                    </div>
                </article>
                @endforeach
            </div>
            @else
            <div class="text-center py-16">
                <i class="fas fa-newspaper text-5xl text-gray-300 empty-state-icon mb-4 block"></i>
                <h3 class="text-xl font-heading font-semibold text-gray-600">Tidak ada artikel ditemukan</h3>
                <p class="text-gray-500 mt-2">Coba gunakan kata kunci lain</p>
            </div>
            @endif
            @if($blogs->hasPages())
            <div class="mt-8">{{ $blogs->appends(['q' => $query, 'tab' => 'blog'])->links() }}</div>
            @endif
        @endif

        @if($activeTab == 'inspirasi')
            @if($inspirasi->isNotEmpty())
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($inspirasi as $item)
                <div class="result-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group">
                    <div class="relative h-48 overflow-hidden">
                        @if($item->gambar)
                        <img src="{{ storage_url($item->gambar) }}" alt="{{ $item->judul }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                             loading="lazy">
                        @else
                        <div class="w-full h-full bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center">
                            <i class="fas fa-paint-brush text-4xl text-purple-300"></i>
                        </div>
                        @endif
                        @if($item->kategori)
                        <div class="absolute top-3 left-3">
                            <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-white/90 backdrop-blur-sm text-purple-700">
                                {{ $item->kategori }}
                            </span>
                        </div>
                        @endif
                    </div>
                    <div class="p-5">
                        @if($item->konsep)
                        <span class="text-[11px] bg-indigo-50 text-indigo-700 px-2.5 py-1 rounded-full font-medium mb-2 inline-block">
                            {{ $item->konsep }}
                        </span>
                        @endif
                        <h3 class="font-heading font-semibold text-gray-900 mb-2 line-clamp-2">
                            <a href="{{ route('inspirasi.show', $item->slug) }}" class="hover:text-purple-700">
                                {{ $item->judul }}
                            </a>
                        </h3>
                        <p class="text-sm text-gray-500 line-clamp-2 mb-3">{{ $item->deskripsi }}</p>
                        <a href="{{ route('inspirasi.show', $item->slug) }}"
                           class="inline-flex items-center text-purple-600 hover:text-purple-800 text-sm font-medium">
                            Lihat Detail <i class="fas fa-arrow-right ml-1.5 text-xs"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-16">
                <i class="fas fa-paint-brush text-5xl text-gray-300 empty-state-icon mb-4 block"></i>
                <h3 class="text-xl font-heading font-semibold text-gray-600">Tidak ada inspirasi ditemukan</h3>
                <p class="text-gray-500 mt-2">Coba gunakan kata kunci lain</p>
            </div>
            @endif
            @if($inspirasi->hasPages())
            <div class="mt-8">{{ $inspirasi->appends(['q' => $query, 'tab' => 'inspirasi'])->links() }}</div>
            @endif
        @endif

        @if($activeTab == 'testimoni')
            @if($testimonis->isNotEmpty())
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($testimonis as $testimoni)
                <div class="result-card bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center gap-3 mb-4">
                        @if($testimoni->foto_client)
                        <img src="{{ storage_url($testimoni->foto_client) }}"
                             alt="{{ $testimoni->nama_client }}"
                             class="w-12 h-12 rounded-full object-cover">
                        @else
                        <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center font-semibold text-yellow-700">
                            {{ strtoupper(substr($testimoni->nama_client, 0, 1)) }}
                        </div>
                        @endif
                        <div>
                            <h4 class="font-semibold text-gray-900">{{ $testimoni->nama_client }}</h4>
                            <div class="flex text-accent-500 text-xs">
                                @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $testimoni->rating ? '' : 'text-gray-200' }}"></i>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 italic line-clamp-4">"{{ $testimoni->isi_testimoni }}"</p>
                    @if($testimoni->portofolio)
                    <a href="{{ route('portofolio.detail', $testimoni->portofolio->slug) }}"
                       class="text-xs text-primary-600 hover:underline mt-3 inline-block">
                        <i class="fas fa-link mr-1"></i> {{ $testimoni->portofolio->nama_proyek }}
                    </a>
                    @endif
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-16">
                <i class="fas fa-star text-5xl text-gray-300 empty-state-icon mb-4 block"></i>
                <h3 class="text-xl font-heading font-semibold text-gray-600">Tidak ada testimoni ditemukan</h3>
                <p class="text-gray-500 mt-2">Coba gunakan kata kunci lain</p>
            </div>
            @endif
            @if($testimonis->hasPages())
            <div class="mt-8">{{ $testimonis->appends(['q' => $query, 'tab' => 'testimoni'])->links() }}</div>
            @endif
        @endif

    @else
        <div class="text-center py-20">
            <div class="w-24 h-24 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-6 empty-state-icon">
                <i class="fas fa-search text-4xl text-gray-400"></i>
            </div>
            <h3 class="text-2xl font-heading font-semibold text-gray-700 mb-2">Cari Konten</h3>
            <p class="text-gray-500 max-w-md mx-auto">
                Gunakan form pencarian di atas untuk menemukan portofolio, artikel, inspirasi desain, atau testimoni
            </p>
            <div class="flex flex-wrap justify-center gap-3 mt-8">
                <a href="{{ route('portofolio.index') }}" class="px-4 py-2 bg-primary-50 text-primary-700 rounded-xl text-sm font-medium hover:bg-primary-100 transition">
                    <i class="fas fa-briefcase mr-1"></i> Portofolio
                </a>
                <a href="{{ route('blog.index') }}" class="px-4 py-2 bg-green-50 text-green-700 rounded-xl text-sm font-medium hover:bg-green-100 transition">
                    <i class="fas fa-newspaper mr-1"></i> Blog
                </a>
                <a href="{{ route('inspirasi.index') }}" class="px-4 py-2 bg-purple-50 text-purple-700 rounded-xl text-sm font-medium hover:bg-purple-100 transition">
                    <i class="fas fa-paint-brush mr-1"></i> Inspirasi
                </a>
                <a href="{{ route('testimonials') }}" class="px-4 py-2 bg-yellow-50 text-yellow-700 rounded-xl text-sm font-medium hover:bg-yellow-100 transition">
                    <i class="fas fa-star mr-1"></i> Testimoni
                </a>
            </div>
        </div>
    @endif
</div>
@endsection