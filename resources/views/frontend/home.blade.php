@extends('layouts.app')

@section('title', 'Beranda')
@section('meta_description', 'Sekawan Makmur Kontraktor - Jasa Bangun Baru, Renovasi, Desain Interior, dan Manajemen Konstruksi Terpercaya di Indonesia')

@push('styles')
<style>
    .hero-video-wrapper {
        position: relative;
        overflow: hidden;
    }
    
    .hero-video-wrapper video,
    .hero-video-wrapper iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .inspirasi-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .inspirasi-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px -12px rgba(30, 58, 138, 0.15);
    }
    
    .inspirasi-card:hover .inspirasi-image img {
        transform: scale(1.1);
    }
    
    .inspirasi-image {
        overflow: hidden;
    }
    
    .inspirasi-image img {
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Stats Grid Mobile - 3 Columns */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.75rem;
    }

    @media (min-width: 768px) {
        .stats-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }
    }

    .stat-card {
        text-align: center;
        padding: 1rem 0.5rem;
        background: white;
        border-radius: 0.75rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    @media (min-width: 768px) {
        .stat-card {
            padding: 1.5rem;
        }
    }

    .stat-card:hover {
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }

    .stat-icon {
        width: 2.5rem;
        height: 2.5rem;
        margin: 0 auto 0.5rem;
        border-radius: 9999px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    @media (min-width: 768px) {
        .stat-icon {
            width: 4rem;
            height: 4rem;
            margin-bottom: 1rem;
        }
    }

    .stat-icon i {
        font-size: 1rem;
    }

    @media (min-width: 768px) {
        .stat-icon i {
            font-size: 1.5rem;
        }
    }

    .stat-value {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1E3A8A;
        margin-bottom: 0.25rem;
    }

    @media (min-width: 768px) {
        .stat-value {
            font-size: 1.875rem;
            margin-bottom: 0.5rem;
        }
    }

    .stat-label {
        font-size: 0.75rem;
        color: #4B5563;
    }

    @media (min-width: 768px) {
        .stat-label {
            font-size: 1rem;
        }
    }

    /* Portfolio Slider Styles */
    .portfolio-slider-container {
        position: relative;
        overflow: hidden;
    }

    .portfolio-slider {
        display: flex;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
        gap: 1rem;
        padding: 1rem 0.5rem;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .portfolio-slider::-webkit-scrollbar {
        display: none;
    }

    .portfolio-slide {
        scroll-snap-align: start;
        flex: 0 0 85%;
        max-width: 85%;
        transition: transform 0.3s ease;
    }

    @media (min-width: 640px) {
        .portfolio-slide {
            flex: 0 0 45%;
            max-width: 45%;
        }
    }

    @media (min-width: 1024px) {
        .portfolio-slide {
            flex: 0 0 calc(33.333% - 1rem);
            max-width: calc(33.333% - 1rem);
        }
    }

    .portfolio-slide:hover {
        transform: translateY(-4px);
    }

    .slider-nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 2.5rem;
        height: 2.5rem;
        background: white;
        border-radius: 9999px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
    }

    .slider-nav-btn:hover {
        background: #1E3A8A;
        color: white;
        border-color: #1E3A8A;
    }

    .slider-nav-btn.prev {
        left: 0;
    }

    .slider-nav-btn.next {
        right: 0;
    }

    .slider-dots {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .slider-dot {
        width: 0.5rem;
        height: 0.5rem;
        border-radius: 9999px;
        background: #d1d5db;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .slider-dot.active {
        background: #1E3A8A;
        width: 1.5rem;
    }

    /* View Toggle Styles */
    .view-toggle-container {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .view-toggle-btn {
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
        background: white;
        color: #4B5563;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .view-toggle-btn.active {
        background: #1E3A8A;
        color: white;
        border-color: #1E3A8A;
    }

    .view-toggle-btn:hover:not(.active) {
        background: #f3f4f6;
    }

    /* List View Styles */
    .inspirasi-container.grid-view {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
    }

    .inspirasi-container.list-view {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .inspirasi-container.list-view .inspirasi-card {
        display: flex;
        flex-direction: row;
    }

    .inspirasi-container.list-view .inspirasi-image {
        width: 200px;
        min-height: 150px;
        flex-shrink: 0;
    }

    @media (max-width: 640px) {
        .inspirasi-container.list-view .inspirasi-card {
            flex-direction: column;
        }
        
        .inspirasi-container.list-view .inspirasi-image {
            width: 100%;
            height: 200px;
        }
    }

    .inspirasi-container.list-view .inspirasi-card .p-5 {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="relative bg-primary-900 text-white overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>
    
    <div class="absolute inset-0 bg-black/40 z-10"></div>
    
    <div class="relative z-20 container mx-auto px-4 py-16 lg:py-28">
        <div class="grid lg:grid-cols-2 gap-10 lg:gap-16 items-center">
            <!-- Hero Content -->
            <div class="hero-content">
                <div class="inline-flex items-center bg-white/10 backdrop-blur-sm rounded-full px-4 py-1.5 mb-6 border border-white/20">
                    <span class="w-2 h-2 bg-accent-500 rounded-full mr-2 animate-pulse"></span>
                    <span class="text-sm text-white/90">Kontraktor Terpercaya Sejak {{ config('about.established') }}</span>
                </div>
                
                <h1 class="text-4xl lg:text-5xl xl:text-6xl font-heading font-bold mb-6 leading-tight">
                    Bangun, Renovasi, & <span class="text-accent-500">Desain</span> Bersama Sekawan Makmur
                </h1>
                
                <p class="text-lg lg:text-xl text-gray-200 mb-8 leading-relaxed">
                    Mitra terpercaya untuk mewujudkan properti impian Anda. Profesional, berkualitas, dan tepat waktu dengan pengalaman lebih dari {{ date('Y') - config('about.established') }} tahun.
                </p>
                
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('portofolio.index') }}" 
                       class="group bg-accent-500 text-primary-900 px-8 py-3.5 rounded-xl font-semibold hover:bg-accent-400 transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:shadow-accent-500/25">
                        <span class="flex items-center">
                            Lihat Portofolio
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </span>
                    </a>
                    <a href="{{ route('contact') }}" 
                       class="group border-2 border-white/30 text-white px-8 py-3.5 rounded-xl font-semibold hover:bg-white hover:text-primary-900 transition-all duration-300 backdrop-blur-sm">
                        <span class="flex items-center">
                            <i class="fas fa-headset mr-2"></i>
                            Konsultasi Gratis
                        </span>
                    </a>
                </div>
                
                <!-- Trust Indicators -->
                <div class="flex flex-wrap items-center gap-6 mt-10 pt-8 border-t border-white/20">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-shield-check text-accent-500"></i>
                        <span class="text-sm text-white/80">Berlisensi Resmi</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-star text-accent-500"></i>
                        <span class="text-sm text-white/80">4.9/5 Rating Klien</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-clock text-accent-500"></i>
                        <span class="text-sm text-white/80">Tepat Waktu</span>
                    </div>
                </div>
            </div>
            
            <!-- Hero Video/Image -->
            <div class="relative">
                <div class="aspect-video rounded-2xl overflow-hidden shadow-2xl shadow-black/30 hero-video-wrapper bg-gray-800">
                    @php
                        $localVideoPath = public_path('videos/hero-video.mp4');
                        $localVideoExists = file_exists($localVideoPath);
                        $youtubeId = env('YOUTUBE_HERO_VIDEO_ID', 'dQw4w9WgXcQ');
                        
                        if (!$localVideoExists) {
                            $localVideoExists = Storage::disk('public')->exists('videos/hero-video.mp4');
                        }
                    @endphp
                    
                    @if($localVideoExists)
                        <video autoplay muted loop playsinline class="w-full h-full object-cover">
                            <source src="{{ file_exists(public_path('videos/hero-video.mp4')) ? asset('videos/hero-video.mp4') : Storage::url('videos/hero-video.mp4') }}" type="video/mp4">
                        </video>
                    @else
                        <iframe 
                            src="https://www.youtube.com/embed/{{ $youtubeId }}?autoplay=1&mute=1&loop=1&playlist={{ $youtubeId }}&controls=0&showinfo=0&rel=0&modestbranding=1" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen
                            class="w-full h-full">
                        </iframe>
                    @endif
                </div>
                
                <!-- Decorative Elements -->
                <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-accent-500/20 rounded-2xl -z-10"></div>
                <div class="absolute -top-4 -left-4 w-16 h-16 bg-primary-500/20 rounded-2xl -z-10"></div>
            </div>
        </div>
    </div>
    
    <!-- Wave Divider -->
    <div class="absolute bottom-0 left-0 right-0 z-20">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" class="w-full h-auto">
            <path fill="#f9fafb" fill-opacity="1" d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
        </svg>
    </div>
</section>

<!-- Quick Search Section -->
<section class="bg-white shadow-lg -mt-8 relative z-30 mx-4 lg:mx-auto max-w-4xl rounded-xl p-6">
    <form action="{{ route('portofolio.index') }}" method="GET" class="grid md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-text-dark mb-2">Jenis Layanan</label>
            <select name="layanan[]" class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500">
                <option value="">Semua Layanan</option>
                @foreach($jenisLayanan as $layanan)
                <option value="{{ $layanan->id }}">{{ $layanan->nama_layanan }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-text-dark mb-2">Budget Min (Rp)</label>
            <input type="number" name="budget_min" placeholder="Min budget" 
                   class="w-full rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500">
        </div>
        <div class="flex items-end">
            <button type="submit" 
                    class="w-full bg-primary-900 text-white py-2.5 rounded-lg hover:bg-primary-800 transition font-medium">
                <i class="fas fa-search mr-2"></i> Cari Proyek
            </button>
        </div>
    </form>
</section>

<!-- Profil Singkat Section - Mobile Grid 3 -->
<section class="container mx-auto px-4 py-16">
    <div class="stats-grid mb-12">
        <div class="stat-card">
            <div class="stat-icon bg-primary-100">
                <i class="fas fa-building text-primary-900"></i>
            </div>
            <div class="stat-value">{{ $totalProyek }}+</div>
            <div class="stat-label">Proyek Selesai</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-accent-100">
                <i class="fas fa-smile text-accent-600"></i>
            </div>
            <div class="stat-value">{{ $totalKlien }}+</div>
            <div class="stat-label">Klien Puas</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-green-100">
                <i class="fas fa-ruler-combined text-green-600"></i>
            </div>
            <div class="stat-value">{{ number_format($totalLuas) }}</div>
            <div class="stat-label">Total m² Dibangun</div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-3xl font-heading font-bold text-primary-900 mb-6 text-center">
            Mengapa Memilih Sekawan Makmur?
        </h2>
        <div class="grid md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div class="flex items-start space-x-3">
                    <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-check-circle text-primary-900"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-text-dark">Profesional & Berpengalaman</h3>
                        <p class="text-sm text-text">Tim kami terdiri dari tenaga ahli berpengalaman di bidang konstruksi.</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-clock text-primary-900"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-text-dark">Tepat Waktu</h3>
                        <p class="text-sm text-text">Kami berkomitmen menyelesaikan proyek sesuai jadwal yang disepakati.</p>
                    </div>
                </div>
            </div>
            <div class="space-y-4">
                <div class="flex items-start space-x-3">
                    <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-hand-holding-usd text-primary-900"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-text-dark">Harga Kompetitif</h3>
                        <p class="text-sm text-text">Transparansi biaya dengan hasil berkualitas tanpa hidden cost.</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-shield-alt text-primary-900"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-text-dark">Garansi Pekerjaan</h3>
                        <p class="text-sm text-text">Semua pekerjaan kami dilengkapi dengan garansi untuk ketenangan Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Portofolio Unggulan - Mobile Slider -->
@if($featuredPortofolio->isNotEmpty())
<section class="bg-gray-50 py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <span class="inline-flex items-center bg-primary-50 text-primary-900 rounded-full px-4 py-1.5 text-sm font-medium mb-4">
                <i class="fas fa-star mr-2"></i> Pilihan Terbaik
            </span>
            <h2 class="text-3xl lg:text-4xl font-heading font-bold text-primary-900 mb-4">
                Portofolio Unggulan
            </h2>
            <p class="text-text max-w-2xl mx-auto">
                Proyek-proyek terbaik yang telah kami selesaikan dengan hasil memuaskan
            </p>
        </div>
        
        <!-- Mobile Slider -->
        <div class="portfolio-slider-container relative">
            <button class="slider-nav-btn prev" onclick="slidePortfolio('prev')" aria-label="Previous">
                <i class="fas fa-chevron-left"></i>
            </button>
            
            <div class="portfolio-slider" id="portfolioSlider">
                @foreach($featuredPortofolio as $portofolio)
                <div class="portfolio-slide">
                    <x-card-proyek :portofolio="$portofolio" />
                </div>
                @endforeach
            </div>
            
            <button class="slider-nav-btn next" onclick="slidePortfolio('next')" aria-label="Next">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
        
        <!-- Slider Dots -->
        <div class="slider-dots" id="portfolioDots"></div>
        
        <div class="text-center mt-10">
            <a href="{{ route('portofolio.index') }}" 
               class="inline-flex items-center bg-primary-900 text-white px-8 py-3 rounded-xl hover:bg-primary-800 transition font-medium group">
                Lihat Semua Portofolio
                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>
    </div>
</section>
@endif

<!-- Inspirasi Desain Terbaru dengan View Toggle -->
@if($latestInspirasi->isNotEmpty())
<section class="container mx-auto px-4 py-16">
    <div class="flex flex-col md:flex-row justify-between items-center mb-8">
        <div class="text-center md:text-left mb-4 md:mb-0">
            <span class="inline-flex items-center bg-purple-50 text-purple-700 rounded-full px-4 py-1.5 text-sm font-medium mb-4">
                <i class="fas fa-paint-brush mr-2"></i> Ide & Kreativitas
            </span>
            <h2 class="text-3xl lg:text-4xl font-heading font-bold text-primary-900 mb-4">
                Inspirasi Desain Terbaru
            </h2>
            <p class="text-text max-w-2xl">
                Temukan ide dan inspirasi untuk mewujudkan rumah impian Anda dengan desain terkini
            </p>
        </div>
        
        <!-- View Toggle Buttons -->
        <div class="view-toggle-container">
            <button class="view-toggle-btn active" onclick="toggleView('grid')" id="gridViewBtn">
                <i class="fas fa-th-large"></i>
                <span class="hidden sm:inline">Grid</span>
            </button>
            <button class="view-toggle-btn" onclick="toggleView('list')" id="listViewBtn">
                <i class="fas fa-list"></i>
                <span class="hidden sm:inline">List</span>
            </button>
        </div>
    </div>
    
    <div class="inspirasi-container grid-view" id="inspirasiContainer">
        @foreach($latestInspirasi as $item)
        <article class="inspirasi-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group">
            <!-- Image -->
            <div class="inspirasi-image relative h-52 overflow-hidden">
                @if($item->gambar)
                <img src="{{ Storage::url($item->gambar) }}" alt="{{ $item->judul }}" 
                     class="w-full h-full object-cover" loading="lazy">
                @else
                <div class="w-full h-full bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center">
                    <i class="fas fa-paint-brush text-5xl text-purple-300"></i>
                </div>
                @endif
                
                <!-- Overlay on hover -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent 
                            opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <div class="absolute bottom-4 left-4 right-4">
                        <a href="{{ route('inspirasi.show', $item->slug) }}" 
                           class="block w-full bg-white text-primary-900 text-center py-2.5 rounded-xl font-semibold
                                  hover:bg-accent-500 transition-all duration-200 transform hover:scale-105 text-sm">
                            <i class="fas fa-eye mr-2"></i> Lihat Detail
                        </a>
                    </div>
                </div>
                
                <!-- Kategori Badge -->
                @if($item->kategori)
                <div class="absolute top-3 left-3">
                    <span class="bg-white/90 backdrop-blur-sm text-primary-900 text-xs px-3 py-1.5 rounded-full font-medium shadow-lg">
                        <i class="fas fa-tag mr-1 text-purple-500"></i> {{ $item->kategori }}
                    </span>
                </div>
                @endif
            </div>
            
            <!-- Content -->
            <div class="p-5">
                @if($item->konsep)
                <span class="text-[11px] bg-purple-50 text-purple-700 px-2.5 py-1 rounded-full font-medium mb-3 inline-block">
                    {{ $item->konsep }}
                </span>
                @endif
                
                <h3 class="text-lg font-heading font-bold text-text-dark mb-2 line-clamp-2 group-hover:text-primary-900 transition-colors">
                    <a href="{{ route('inspirasi.show', $item->slug) }}">{{ $item->judul }}</a>
                </h3>
                
                @if($item->deskripsi)
                <p class="text-sm text-text line-clamp-2 mb-4">{{ $item->deskripsi }}</p>
                @endif
                
                <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                    @if($item->warna_dominan)
                    <span class="text-xs text-text flex items-center gap-1">
                        <i class="fas fa-palette text-purple-500"></i> {{ $item->warna_dominan }}
                    </span>
                    @endif
                    
                    @if($item->estimasi_biaya)
                    <span class="text-xs text-text">
                        Rp {{ number_format($item->estimasi_biaya, 0, ',', '.') }}/m²
                    </span>
                    @endif
                </div>
            </div>
        </article>
        @endforeach
    </div>
    
    <div class="text-center mt-10">
        <a href="{{ route('inspirasi.index') }}" 
           class="inline-flex items-center bg-primary-900 text-white px-8 py-3 rounded-xl hover:bg-primary-800 transition font-medium group">
            Lihat Semua Inspirasi
            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
        </a>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="bg-primary-900 text-white py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-20 -right-20 w-64 h-64 bg-accent-500 rounded-full"></div>
        <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-accent-500 rounded-full"></div>
    </div>
    
    <div class="container mx-auto px-4 text-center relative z-10">
        <h2 class="text-3xl lg:text-4xl font-heading font-bold mb-4">
            Siap Mewujudkan Proyek Impian Anda?
        </h2>
        <p class="text-xl text-gray-200 mb-8 max-w-2xl mx-auto">
            Hubungi kami sekarang untuk konsultasi GRATIS dan dapatkan penawaran terbaik
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="https://wa.me/{{ config('app.wa_number', '6281234567890') }}?text={{ urlencode('Halo, saya ingin konsultasi tentang proyek bangunan') }}" 
               target="_blank"
               class="bg-green-500 text-white px-8 py-3.5 rounded-xl font-semibold hover:bg-green-600 transition transform hover:scale-105 shadow-lg shadow-green-500/20">
                <i class="fab fa-whatsapp mr-2"></i> Chat via WhatsApp
            </a>
            <a href="{{ route('contact') }}" 
               class="bg-accent-500 text-primary-900 px-8 py-3.5 rounded-xl font-semibold hover:bg-accent-400 transition transform hover:scale-105 shadow-lg shadow-accent-500/20">
                <i class="fas fa-envelope mr-2"></i> Hubungi Kami
            </a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Portfolio Slider Functionality
    let currentSlide = 0;
    
    function initPortfolioSlider() {
        const slider = document.getElementById('portfolioSlider');
        const slides = slider.children;
        const dotsContainer = document.getElementById('portfolioDots');
        
        // Create dots
        dotsContainer.innerHTML = '';
        const slideCount = Math.ceil(slides.length / getSlidesPerView());
        
        for (let i = 0; i < slideCount; i++) {
            const dot = document.createElement('div');
            dot.className = 'slider-dot' + (i === 0 ? ' active' : '');
            dot.onclick = () => goToSlide(i);
            dotsContainer.appendChild(dot);
        }
        
        // Update dots on scroll
        slider.addEventListener('scroll', updateDots);
    }
    
    function getSlidesPerView() {
        if (window.innerWidth >= 1024) return 3;
        if (window.innerWidth >= 640) return 2;
        return 1;
    }
    
    function slidePortfolio(direction) {
        const slider = document.getElementById('portfolioSlider');
        const slideWidth = slider.children[0].offsetWidth;
        const gap = 16; // 1rem gap
        const scrollAmount = slideWidth + gap;
        
        if (direction === 'next') {
            slider.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        } else {
            slider.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        }
    }
    
    function goToSlide(index) {
        const slider = document.getElementById('portfolioSlider');
        const slideWidth = slider.children[0].offsetWidth;
        const gap = 16;
        const scrollAmount = (slideWidth + gap) * index * getSlidesPerView();
        
        slider.scrollTo({ left: scrollAmount, behavior: 'smooth' });
    }
    
    function updateDots() {
        const slider = document.getElementById('portfolioSlider');
        const slideWidth = slider.children[0].offsetWidth;
        const gap = 16;
        const scrollPosition = slider.scrollLeft;
        const activeIndex = Math.round(scrollPosition / ((slideWidth + gap) * getSlidesPerView()));
        
        const dots = document.querySelectorAll('.slider-dot');
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === activeIndex);
        });
    }
    
    // View Toggle Functionality
    function toggleView(viewType) {
        const container = document.getElementById('inspirasiContainer');
        const gridBtn = document.getElementById('gridViewBtn');
        const listBtn = document.getElementById('listViewBtn');
        
        if (viewType === 'grid') {
            container.classList.remove('list-view');
            container.classList.add('grid-view');
            gridBtn.classList.add('active');
            listBtn.classList.remove('active');
            localStorage.setItem('inspirasiView', 'grid');
        } else {
            container.classList.remove('grid-view');
            container.classList.add('list-view');
            listBtn.classList.add('active');
            gridBtn.classList.remove('active');
            localStorage.setItem('inspirasiView', 'list');
        }
    }
    
    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize portfolio slider
        initPortfolioSlider();
        
        // Restore view preference
        const savedView = localStorage.getItem('inspirasiView') || 'grid';
        toggleView(savedView);
        
        // Update slider on resize
        window.addEventListener('resize', initPortfolioSlider);
    });
</script>
@endpush