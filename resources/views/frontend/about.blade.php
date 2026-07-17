@extends('layouts.app')

@section('title', 'Tentang Kami')
@section('meta_description', 'Sekawan Makmur Kontraktor - Berpengalaman lebih dari 10 tahun dalam jasa konstruksi, renovasi, dan desain interior di Indonesia.')

@php
$breadcrumbs = [
    ['title' => 'Tentang Kami', 'url' => route('about')]
];
@endphp

@push('styles')
<style>
    .about-hero {
        background: linear-gradient(135deg, #1E3A8A 0%, #1e40af 100%);
        position: relative;
        overflow: hidden;
    }
    
    .about-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(251, 191, 36, 0.1) 0%, transparent 70%);
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        width: 2px;
        height: 100%;
        background: linear-gradient(to bottom, transparent, #1E3A8A, #FBBF24, #1E3A8A, transparent);
    }
    
    .timeline-item {
        position: relative;
    }
    
    .timeline-dot {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        width: 16px;
        height: 16px;
        background: #FBBF24;
        border-radius: 50%;
        border: 3px solid #1E3A8A;
        z-index: 10;
    }
    
    .value-card {
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    
    .value-card:hover {
        transform: translateY(-5px);
        border-color: #FBBF24;
        box-shadow: 0 20px 40px -15px rgba(30, 58, 138, 0.15);
    }
    
    .value-card:hover .value-icon {
        background-color: #1E3A8A;
        color: #FBBF24;
        transform: rotate(-10deg) scale(1.1);
    }
    
    .value-icon {
        transition: all 0.3s ease;
    }
    
    .team-card {
        transition: all 0.3s ease;
    }
    
    .team-card:hover {
        transform: translateY(-8px);
    }
    
    .team-card:hover .team-image img {
        transform: scale(1.1);
    }
    
    .team-image {
        overflow: hidden;
    }
    
    .team-image img {
        transition: transform 0.6s ease;
    }

    /* Stats Grid Styles */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
    }

    @media (min-width: 768px) {
        .stats-grid {
            gap: 2rem;
        }
    }

    .stat-card {
        text-align: center;
        padding: 1.5rem 0.75rem;
        background: white;
        border-radius: 1rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        border: 1px solid #f3f4f6;
    }

    @media (min-width: 768px) {
        .stat-card {
            padding: 2rem 1.5rem;
        }
    }

    .stat-card:hover {
        box-shadow: 0 20px 25px -5px rgba(30, 58, 138, 0.15);
        transform: translateY(-3px);
        border-color: #E8EDF5;
    }

    .stat-icon {
        width: 3rem;
        height: 3rem;
        margin: 0 auto 0.75rem;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    @media (min-width: 768px) {
        .stat-icon {
            width: 4rem;
            height: 4rem;
            margin-bottom: 1rem;
        }
    }

    .stat-card:hover .stat-icon {
        transform: scale(1.1) rotate(-5deg);
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: #1E3A8A;
        margin-bottom: 0.25rem;
        line-height: 1.2;
    }

    @media (min-width: 768px) {
        .stat-value {
            font-size: 2.25rem;
        }
    }

    .stat-label {
        font-size: 0.8rem;
        color: #4B5563;
        font-weight: 500;
        margin-bottom: 0.25rem;
    }

    @media (min-width: 768px) {
        .stat-label {
            font-size: 0.9rem;
        }
    }

    .stat-description {
        font-size: 0.7rem;
        color: #9CA3AF;
        line-height: 1.4;
    }

    @media (min-width: 768px) {
        .stat-description {
            font-size: 0.8rem;
        }
    }

    /* License & Certification Slider */
    .license-slider-container {
        position: relative;
        overflow: hidden;
        padding: 1rem 0;
    }

    .license-slider {
        display: flex;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
        gap: 1.5rem;
        padding: 0.5rem;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .license-slider::-webkit-scrollbar {
        display: none;
    }

    .license-slide {
        scroll-snap-align: start;
        flex: 0 0 280px;
        transition: transform 0.3s ease;
    }

    @media (min-width: 640px) {
        .license-slide {
            flex: 0 0 320px;
        }
    }

    @media (min-width: 1024px) {
        .license-slide {
            flex: 0 0 350px;
        }
    }

    .license-card {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        border: 1px solid #f3f4f6;
        transition: all 0.3s ease;
        height: 100%;
    }

    .license-card:hover {
        box-shadow: 0 20px 25px -5px rgba(30, 58, 138, 0.1);
        transform: translateY(-4px);
        border-color: #FBBF24;
    }

    .license-icon {
        width: 3rem;
        height: 3rem;
        background: linear-gradient(135deg, #E8EDF5, #C5CFE6);
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .license-card:hover .license-icon {
        background: linear-gradient(135deg, #1E3A8A, #375792);
        color: #FBBF24;
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
        left: -0.5rem;
    }

    .slider-nav-btn.next {
        right: -0.5rem;
    }

    .slider-dots {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 1.5rem;
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

    /* Why Choose Us Grid 2 */
    .why-choose-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }

    @media (max-width: 640px) {
        .why-choose-grid {
            grid-template-columns: 1fr;
        }
    }

    .why-choose-card {
        background: white;
        border-radius: 1rem;
        padding: 1.5rem;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        border: 1px solid #f3f4f6;
        transition: all 0.3s ease;
    }

    .why-choose-card:hover {
        box-shadow: 0 20px 25px -5px rgba(30, 58, 138, 0.1);
        transform: translateY(-4px);
    }
</style>
@endpush

@section('content')
<x-breadcrumb :breadcrumbs="$breadcrumbs" />
<x-alert />

<!-- Hero Section -->
<section class="about-hero text-white py-16 lg:py-24">
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-3xl">
            <span class="inline-flex items-center bg-white/10 backdrop-blur-sm rounded-full px-4 py-1.5 text-sm mb-6 border border-white/20">
                <i class="fas fa-building mr-2"></i> Sejak {{ config('about.established', '2010') }}
            </span>
            <h1 class="text-4xl lg:text-5xl xl:text-6xl font-heading font-bold mb-6 leading-tight">
                Tentang <span class="text-accent-500">Sekawan Makmur</span>
            </h1>
            <p class="text-lg lg:text-xl text-gray-200 leading-relaxed">
                Kontraktor profesional dengan pengalaman lebih dari {{ date('Y') - config('about.established', 2010) }} tahun dalam industri konstruksi, renovasi, dan desain interior di Indonesia.
            </p>
        </div>
    </div>
</section>

<!-- Stats Section - Grid 3 -->
<section class="container mx-auto px-4 -mt-12 relative z-20">
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon bg-primary-100">
                <i class="fas fa-building text-2xl text-primary-900"></i>
            </div>
            <div class="stat-value">{{ date('Y') - config('about.established', 2010) }}+</div>
            <div class="stat-label">Tahun Pengalaman</div>
            <div class="stat-description">Melayani dengan profesional</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon bg-accent-100">
                <i class="fas fa-users text-2xl text-accent-600"></i>
            </div>
            <div class="stat-value">50+</div>
            <div class="stat-label">Tim Profesional</div>
            <div class="stat-description">Ahli di bidangnya</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon bg-green-100">
                <i class="fas fa-check-circle text-2xl text-green-600"></i>
            </div>
            <div class="stat-value">500+</div>
            <div class="stat-label">Proyek Selesai</div>
            <div class="stat-description">Hasil memuaskan</div>
        </div>
    </div>
</section>

<!-- Visi & Misi Section -->
<section class="container mx-auto px-4 py-16">
    <div class="grid md:grid-cols-2 gap-12">
        <!-- Visi -->
        <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-eye text-xl text-primary-900"></i>
                </div>
                <h2 class="text-2xl font-heading font-bold text-text-dark">Visi Kami</h2>
            </div>
            <p class="text-text leading-relaxed">
                Menjadi perusahaan kontraktor terkemuka di Indonesia yang dikenal karena kualitas, inovasi, dan kepercayaan pelanggan, serta berkontribusi dalam pembangunan infrastruktur berkelanjutan.
            </p>
        </div>
        
        <!-- Misi -->
        <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
            <div class="flex items-center space-x-3 mb-6">
                <div class="w-12 h-12 bg-accent-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-bullseye text-xl text-accent-600"></i>
                </div>
                <h2 class="text-2xl font-heading font-bold text-text-dark">Misi Kami</h2>
            </div>
            <ul class="space-y-3 text-text">
                <li class="flex items-start space-x-3">
                    <i class="fas fa-check-circle text-accent-500 mt-1"></i>
                    <span>Memberikan layanan konstruksi berkualitas tinggi dengan standar profesional</span>
                </li>
                <li class="flex items-start space-x-3">
                    <i class="fas fa-check-circle text-accent-500 mt-1"></i>
                    <span>Mengutamakan kepuasan pelanggan melalui hasil kerja yang tepat waktu</span>
                </li>
                <li class="flex items-start space-x-3">
                    <i class="fas fa-check-circle text-accent-500 mt-1"></i>
                    <span>Mengembangkan tim yang kompeten dan berintegritas</span>
                </li>
                <li class="flex items-start space-x-3">
                    <i class="fas fa-check-circle text-accent-500 mt-1"></i>
                    <span>Menerapkan teknologi terkini dalam setiap proyek</span>
                </li>
            </ul>
        </div>
    </div>
</section>

<!-- Lisensi & Sertifikasi Section - Slides -->
<section class="bg-gray-50 py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <span class="inline-flex items-center bg-primary-50 text-primary-900 rounded-full px-4 py-1.5 text-sm font-medium mb-4">
                <i class="fas fa-certificate mr-2"></i> Kredibilitas Terpercaya
            </span>
            <h2 class="text-3xl lg:text-4xl font-heading font-bold text-text-dark mb-4">
                Lisensi & Sertifikasi
            </h2>
            <p class="text-text max-w-2xl mx-auto">
                Dilengkapi dengan lisensi resmi dan sertifikasi standar nasional
            </p>
        </div>
        
        <div class="license-slider-container relative">
            <button class="slider-nav-btn prev" onclick="slideLicense('prev')" aria-label="Previous">
                <i class="fas fa-chevron-left"></i>
            </button>
            
            <div class="license-slider" id="licenseSlider">
                <!-- SIUJK -->
                <div class="license-slide">
                    <div class="license-card">
                        <div class="license-icon">
                            <i class="fas fa-file-contract text-2xl text-primary-900"></i>
                        </div>
                        <h3 class="text-lg font-heading font-bold text-text-dark mb-2">SIUJK</h3>
                        <p class="text-sm text-text mb-3">Surat Izin Usaha Jasa Konstruksi</p>
                        <span class="inline-block px-3 py-1 bg-green-50 text-green-700 text-xs rounded-full font-medium">Aktif</span>
                        <p class="text-xs text-text-light mt-3">Nomor: 001/SIUJK/2024</p>
                    </div>
                </div>
                
                <!-- SBU -->
                <div class="license-slide">
                    <div class="license-card">
                        <div class="license-icon">
                            <i class="fas fa-building-shield text-2xl text-primary-900"></i>
                        </div>
                        <h3 class="text-lg font-heading font-bold text-text-dark mb-2">SBU</h3>
                        <p class="text-sm text-text mb-3">Sertifikat Badan Usaha</p>
                        <span class="inline-block px-3 py-1 bg-green-50 text-green-700 text-xs rounded-full font-medium">Tersertifikasi</span>
                        <p class="text-xs text-text-light mt-3">Kualifikasi: Menengah</p>
                    </div>
                </div>
                
                <!-- ISO 9001 -->
                <div class="license-slide">
                    <div class="license-card">
                        <div class="license-icon">
                            <i class="fas fa-globe-standards text-2xl text-primary-900"></i>
                        </div>
                        <h3 class="text-lg font-heading font-bold text-text-dark mb-2">ISO 9001:2015</h3>
                        <p class="text-sm text-text mb-3">Sistem Manajemen Mutu</p>
                        <span class="inline-block px-3 py-1 bg-green-50 text-green-700 text-xs rounded-full font-medium">Tersertifikasi</span>
                        <p class="text-xs text-text-light mt-3">Sertifikasi Internasional</p>
                    </div>
                </div>
                
                <!-- K3 -->
                <div class="license-slide">
                    <div class="license-card">
                        <div class="license-icon">
                            <i class="fas fa-hard-hat text-2xl text-primary-900"></i>
                        </div>
                        <h3 class="text-lg font-heading font-bold text-text-dark mb-2">K3 Konstruksi</h3>
                        <p class="text-sm text-text mb-3">Keselamatan & Kesehatan Kerja</p>
                        <span class="inline-block px-3 py-1 bg-green-50 text-green-700 text-xs rounded-full font-medium">Bersertifikat</span>
                        <p class="text-xs text-text-light mt-3">Ahli K3 Umum & Konstruksi</p>
                    </div>
                </div>
                
                <!-- AKLI -->
                <div class="license-slide">
                    <div class="license-card">
                        <div class="license-icon">
                            <i class="fas fa-users-gear text-2xl text-primary-900"></i>
                        </div>
                        <h3 class="text-lg font-heading font-bold text-text-dark mb-2">AKLI</h3>
                        <p class="text-sm text-text mb-3">Asosiasi Kontraktor Listrik Indonesia</p>
                        <span class="inline-block px-3 py-1 bg-green-50 text-green-700 text-xs rounded-full font-medium">Anggota Aktif</span>
                        <p class="text-xs text-text-light mt-3">No. Anggota: 2024/001</p>
                    </div>
                </div>
            </div>
            
            <button class="slider-nav-btn next" onclick="slideLicense('next')" aria-label="Next">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
        
        <div class="slider-dots" id="licenseDots"></div>
    </div>
</section>

<!-- Mengapa Memilih Kami - Grid 2 -->
<section class="container mx-auto px-4 py-16">
    <div class="text-center mb-12">
        <span class="inline-flex items-center bg-accent-50 text-accent-700 rounded-full px-4 py-1.5 text-sm font-medium mb-4">
            <i class="fas fa-star mr-2"></i> Keunggulan Kami
        </span>
        <h2 class="text-3xl lg:text-4xl font-heading font-bold text-text-dark mb-4">
            Mengapa Memilih Kami?
        </h2>
        <p class="text-text max-w-2xl mx-auto">
            Komitmen kami dalam memberikan layanan terbaik untuk setiap proyek
        </p>
    </div>
    
    <div class="why-choose-grid">
        <!-- Card 1 -->
        <div class="why-choose-card">
            <div class="flex items-start space-x-4">
                <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-medal text-xl text-primary-900"></i>
                </div>
                <div>
                    <h3 class="text-lg font-heading font-bold text-text-dark mb-2">Kualitas Terjamin</h3>
                    <p class="text-sm text-text leading-relaxed">
                        Setiap proyek dikerjakan dengan standar kualitas tinggi dan pengawasan ketat dari tim ahli berpengalaman.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Card 2 -->
        <div class="why-choose-card">
            <div class="flex items-start space-x-4">
                <div class="w-12 h-12 bg-accent-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-clock text-xl text-accent-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-heading font-bold text-text-dark mb-2">Tepat Waktu</h3>
                    <p class="text-sm text-text leading-relaxed">
                        Komitmen kami menyelesaikan proyek sesuai jadwal tanpa mengorbankan kualitas hasil kerja.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Card 3 -->
        <div class="why-choose-card">
            <div class="flex items-start space-x-4">
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-hand-holding-usd text-xl text-green-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-heading font-bold text-text-dark mb-2">Harga Transparan</h3>
                    <p class="text-sm text-text leading-relaxed">
                        Rincian biaya jelas dan transparan tanpa biaya tersembunyi, disesuaikan dengan budget Anda.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Card 4 -->
        <div class="why-choose-card">
            <div class="flex items-start space-x-4">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-headset text-xl text-purple-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-heading font-bold text-text-dark mb-2">Support 24/7</h3>
                    <p class="text-sm text-text leading-relaxed">
                        Layanan konsultasi dan dukungan teknis siap membantu Anda kapan saja melalui berbagai channel.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Card 5 -->
        <div class="why-choose-card">
            <div class="flex items-start space-x-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-tools text-xl text-blue-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-heading font-bold text-text-dark mb-2">Teknologi Modern</h3>
                    <p class="text-sm text-text leading-relaxed">
                        Menggunakan peralatan dan teknologi terkini untuk hasil yang lebih presisi dan efisien.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Card 6 -->
        <div class="why-choose-card">
            <div class="flex items-start space-x-4">
                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-shield-alt text-xl text-red-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-heading font-bold text-text-dark mb-2">Garansi Pekerjaan</h3>
                    <p class="text-sm text-text leading-relaxed">
                        Semua pekerjaan dilengkapi garansi untuk memberikan ketenangan dan kepercayaan penuh.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="bg-primary-900 text-white py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-20 -right-20 w-64 h-64 bg-accent-500 rounded-full"></div>
        <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-accent-500 rounded-full"></div>
    </div>
    
    <div class="container mx-auto px-4 text-center relative z-10">
        <h2 class="text-3xl lg:text-4xl font-heading font-bold mb-4">
            Siap Bekerja Sama dengan Kami?
        </h2>
        <p class="text-xl text-gray-200 mb-8 max-w-2xl mx-auto">
            Hubungi kami sekarang untuk konsultasi GRATIS dan wujudkan proyek impian Anda
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('contact') }}" 
               class="bg-accent-500 text-primary-900 px-8 py-3.5 rounded-xl font-semibold hover:bg-accent-400 transition transform hover:scale-105 shadow-lg shadow-accent-500/20">
                <i class="fas fa-headset mr-2"></i> Hubungi Kami
            </a>
            <a href="{{ route('portofolio.index') }}" 
               class="border-2 border-white/30 text-white px-8 py-3.5 rounded-xl font-semibold hover:bg-white hover:text-primary-900 transition transform hover:scale-105">
                <i class="fas fa-briefcase mr-2"></i> Lihat Portofolio
            </a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    // License Slider Functionality
    function initLicenseSlider() {
        const slider = document.getElementById('licenseSlider');
        const slides = slider.children;
        const dotsContainer = document.getElementById('licenseDots');
        
        dotsContainer.innerHTML = '';
        const slidesPerView = getSlidesPerView();
        const totalSlides = slides.length;
        const slideCount = Math.ceil(totalSlides / slidesPerView);
        
        for (let i = 0; i < slideCount; i++) {
            const dot = document.createElement('div');
            dot.className = 'slider-dot' + (i === 0 ? ' active' : '');
            dot.onclick = () => goToLicenseSlide(i);
            dotsContainer.appendChild(dot);
        }
        
        slider.addEventListener('scroll', updateLicenseDots);
    }
    
    function getSlidesPerView() {
        if (window.innerWidth >= 1024) return 3;
        if (window.innerWidth >= 640) return 2;
        return 1;
    }
    
    function slideLicense(direction) {
        const slider = document.getElementById('licenseSlider');
        const slideWidth = slider.children[0].offsetWidth;
        const gap = 24;
        const scrollAmount = slideWidth + gap;
        
        if (direction === 'next') {
            slider.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        } else {
            slider.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        }
    }
    
    function goToLicenseSlide(index) {
        const slider = document.getElementById('licenseSlider');
        const slideWidth = slider.children[0].offsetWidth;
        const gap = 24;
        const scrollAmount = (slideWidth + gap) * index * getSlidesPerView();
        
        slider.scrollTo({ left: scrollAmount, behavior: 'smooth' });
    }
    
    function updateLicenseDots() {
        const slider = document.getElementById('licenseSlider');
        const slideWidth = slider.children[0].offsetWidth;
        const gap = 24;
        const scrollPosition = slider.scrollLeft;
        const activeIndex = Math.round(scrollPosition / ((slideWidth + gap) * getSlidesPerView()));
        
        const dots = document.querySelectorAll('#licenseDots .slider-dot');
        dots.forEach((dot, index) => {
            dot.classList.toggle('active', index === activeIndex);
        });
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        initLicenseSlider();
        window.addEventListener('resize', initLicenseSlider);
    });
</script>
@endpush