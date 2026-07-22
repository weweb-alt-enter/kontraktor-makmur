@extends('layouts.app')

@section('title', 'Hubungi Kami')
@section('meta_description', 'Hubungi Sekawan Makmur Kontraktor untuk konsultasi gratis. Kami siap membantu mewujudkan proyek impian Anda.')

@php
$breadcrumbs = [
    ['title' => 'Kontak', 'url' => route('contact')]
];
@endphp

@push('styles')
<style>
    .contact-hero {
        background: linear-gradient(135deg, #1E3A8A 0%, #1e40af 100%);
        position: relative;
        overflow: hidden;
    }
    
    .contact-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(251, 191, 36, 0.1) 0%, transparent 70%);
    }
    
    .info-card {
        transition: all 0.3s ease;
    }
    
    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px -15px rgba(30, 58, 138, 0.15);
    }
    
    .info-card:hover .info-icon {
        background-color: #1E3A8A;
        color: white;
        transform: scale(1.1) rotate(-10deg);
    }
    
    .info-icon {
        transition: all 0.3s ease;
    }
    
    .form-input:focus {
        box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
        border-color: #1E3A8A;
    }
    
    .map-container {
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
    }
    
    .map-container iframe {
        filter: grayscale(20%);
        transition: filter 0.3s ease;
    }
    
    .map-container:hover iframe {
        filter: grayscale(0%);
    }
    
    .whatsapp-float {
        animation: bounce 2s infinite;
    }
    
    @keyframes bounce {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }

    /* Social Media Card Styles */
    .social-media-card {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .social-media-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        opacity: 0;
        transition: opacity 0.3s ease;
        border-radius: 1rem;
    }
    
    .social-media-card:hover::before {
        opacity: 1;
    }
    
    .social-media-card.instagram::before {
        background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);
    }
    
    .social-media-card.tiktok::before {
        background: linear-gradient(45deg, #000000 0%, #25F4EE 50%, #FE2C55 100%);
    }
    
    .social-media-card.pinterest::before {
        background: linear-gradient(45deg, #BD081C 0%, #E60023 100%);
    }
    
    .social-media-card:hover .social-icon-wrapper {
        transform: scale(1.1);
    }
    
    .social-media-card:hover .social-info {
        color: white;
    }
    
    .social-media-card:hover .social-info h3,
    .social-media-card:hover .social-info p {
        color: white;
    }
    
    .social-icon-wrapper {
        transition: transform 0.3s ease;
    }
    
    /* Stats Grid Styles */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
    }

    @media (min-width: 768px) {
        .stats-grid {
            gap: 1.5rem;
        }
    }

    .stat-card {
        text-align: center;
        padding: 1.25rem 0.75rem;
        background: white;
        border-radius: 1rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        border: 1px solid #f3f4f6;
    }

    .stat-card:hover {
        box-shadow: 0 20px 25px -5px rgba(30, 58, 138, 0.1);
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
            width: 3.5rem;
            height: 3.5rem;
            margin-bottom: 1rem;
        }
    }

    .stat-card:hover .stat-icon {
        transform: scale(1.1) rotate(-5deg);
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1E3A8A;
        margin-bottom: 0.25rem;
        line-height: 1.2;
    }

    @media (min-width: 768px) {
        .stat-value {
            font-size: 1.875rem;
        }
    }

    .stat-label {
        font-size: 0.75rem;
        color: #4B5563;
        font-weight: 500;
    }

    @media (min-width: 768px) {
        .stat-label {
            font-size: 0.875rem;
        }
    }

    .stat-sublabel {
        font-size: 0.65rem;
        color: #9CA3AF;
        margin-top: 0.25rem;
    }

    @media (min-width: 768px) {
        .stat-sublabel {
            font-size: 0.75rem;
        }
    }
</style>
@endpush

@section('content')
<x-breadcrumb :breadcrumbs="$breadcrumbs" />
<x-alert />

<!-- Hero Section - Sama seperti About -->
<section class="contact-hero text-white py-16 lg:py-24">
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-3xl">
            <span class="inline-flex items-center bg-white/10 backdrop-blur-sm rounded-full px-4 py-1.5 text-sm mb-6 border border-white/20">
                <i class="fas fa-headset mr-2"></i> Layanan Pelanggan
            </span>
            <h1 class="text-4xl lg:text-5xl xl:text-6xl font-heading font-bold mb-6 leading-tight">
                Hubungi <span class="text-accent-500">Kami</span>
            </h1>
            <p class="text-lg lg:text-xl text-gray-200 leading-relaxed">
                Kami siap membantu mewujudkan proyek impian Anda. Tim profesional kami akan merespon dalam 1x24 jam kerja.
            </p>
        </div>
    </div>
</section>

<!-- Stats Section - Grid 3 -->
<section class="container mx-auto px-4 -mt-12 relative z-20">
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon bg-primary-100">
                <i class="fas fa-clock text-primary-900 text-xl"></i>
            </div>
            <div class="stat-value">1x24</div>
            <div class="stat-label">Jam Respon</div>
            <div class="stat-sublabel">Hari Kerja</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon bg-accent-100">
                <i class="fas fa-headset text-accent-600 text-xl"></i>
            </div>
            <div class="stat-value">24/7</div>
            <div class="stat-label">Support WA</div>
            <div class="stat-sublabel">Chat & Telepon</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon bg-green-100">
                <i class="fas fa-shield-alt text-green-600 text-xl"></i>
            </div>
            <div class="stat-value">100%</div>
            <div class="stat-label">Privasi Data</div>
            <div class="stat-sublabel">Terjamin Aman</div>
        </div>
    </div>
</section>

<div class="container mx-auto px-4 py-12 lg:py-16">
    <div class="grid lg:grid-cols-5 gap-8 lg:gap-12">
        
        <!-- Left Column - Contact Forms (3/5) -->
        <div class="lg:col-span-3 space-y-8">
            
            <!-- Quick Contact Form -->
            <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8 border border-gray-100">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-primary-100 rounded-xl flex items-center justify-center">
                        <i class="fas fa-paper-plane text-primary-900"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-heading font-bold text-text-dark">Kirim Pesan</h2>
                        <p class="text-sm text-text">Isi form di bawah untuk menghubungi kami</p>
                    </div>
                </div>
                
                <form action="{{ route('contact.store') }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <div class="grid md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-text-dark mb-2">
                                <i class="fas fa-user text-text-light mr-1.5"></i> Nama Lengkap *
                            </label>
                            <input type="text" name="nama" value="{{ old('nama') }}" required
                                   class="form-input w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4
                                          focus:bg-white transition-all duration-200"
                                   placeholder="Nama Anda">
                            @error('nama')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-text-dark mb-2">
                                <i class="fas fa-envelope text-text-light mr-1.5"></i> Email *
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                   class="form-input w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4
                                          focus:bg-white transition-all duration-200"
                                   placeholder="email@example.com">
                            @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-text-dark mb-2">
                            <i class="fas fa-comment-alt text-text-light mr-1.5"></i> Pesan *
                        </label>
                        <textarea name="pesan" rows="5" required
                                  class="form-input w-full rounded-xl border-gray-300 bg-gray-50 py-3 px-4
                                         focus:bg-white transition-all duration-200 resize-none"
                                  placeholder="Tulis pesan atau pertanyaan Anda di sini...">{{ old('pesan') }}</textarea>
                        @error('pesan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <button type="submit" 
                            class="w-full bg-primary-900 text-white py-4 px-6 rounded-xl font-semibold
                                   hover:bg-primary-800 transform hover:scale-[1.02] transition-all duration-200
                                   flex items-center justify-center space-x-2 shadow-lg shadow-primary-900/20">
                        <i class="fas fa-paper-plane"></i>
                        <span>Kirim Pesan Sekarang</span>
                    </button>
                </form>
            </div>

            <!-- Consultation Form -->
            <div class="bg-gradient-to-br from-accent-50 to-yellow-50 rounded-2xl shadow-xl p-6 md:p-8 border border-accent-200">
                <div class="flex items-center space-x-3 mb-6">
                    <div class="w-10 h-10 bg-accent-500 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-comments text-primary-900"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-heading font-bold text-text-dark">Konsultasi Gratis</h2>
                        <p class="text-sm text-text">Dapatkan konsultasi dan estimasi biaya tanpa dipungut biaya</p>
                    </div>
                </div>
                
                <form action="{{ route('contact.konsultasi') }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <div class="grid md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold text-text-dark mb-2">
                                <i class="fas fa-user text-text-light mr-1.5"></i> Nama Lengkap *
                            </label>
                            <input type="text" name="nama" required
                                class="form-input w-full rounded-xl border-gray-300 bg-white py-3 px-4 focus:bg-white transition-all duration-200"
                                placeholder="Nama Anda">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-text-dark mb-2">
                                <i class="fas fa-envelope text-text-light mr-1.5"></i> Email *
                            </label>
                            <input type="email" name="email" required
                                class="form-input w-full rounded-xl border-gray-300 bg-white py-3 px-4 focus:bg-white transition-all duration-200"
                                placeholder="email@example.com">
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-text-dark mb-2">
                                <i class="fab fa-whatsapp text-green-500 mr-1.5"></i> No WhatsApp *
                            </label>
                            <input type="text" name="no_wa" required
                                class="form-input w-full rounded-xl border-gray-300 bg-white py-3 px-4 focus:bg-white transition-all duration-200"
                                placeholder="62812xxxxxxxx">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-text-dark mb-2">
                            <i class="fas fa-clipboard-list text-text-light mr-1.5"></i> Deskripsi Singkat *
                        </label>
                        <textarea name="deskripsi" rows="4" required
                                class="form-input w-full rounded-xl border-gray-300 bg-white py-3 px-4 focus:bg-white transition-all duration-200 resize-none"
                                placeholder="Jelaskan kebutuhan proyek atau konsultasi yang Anda inginkan..."></textarea>
                    </div>
                    
                    <button type="submit" 
                            class="w-full bg-accent-500 text-primary-900 py-4 px-6 rounded-xl font-semibold
                                hover:bg-accent-400 transform hover:scale-[1.02] transition-all duration-200
                                flex items-center justify-center space-x-2 shadow-lg shadow-accent-500/30">
                        <i class="fas fa-headset"></i>
                        <span>Kirim Permintaan Konsultasi</span>
                    </button>
                    
                    <p class="text-xs text-text text-center">
                        <i class="fas fa-shield-alt mr-1"></i> 
                        Data Anda aman dan hanya digunakan untuk keperluan konsultasi
                    </p>
                </form>
            </div>
        </div>

        <!-- Right Column - Contact Info & Map (2/5) -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Info Cards -->
            <div class="space-y-4">
                <!-- WhatsApp Card -->
                <div class="info-card bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <div class="flex items-start space-x-4">
                        <div class="info-icon w-14 h-14 bg-green-50 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fab fa-whatsapp text-2xl text-green-600"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-text-dark mb-1">WhatsApp</h3>
                            <p class="text-sm text-text mb-3">+62 {{ config('app.wa_number', '812-3456-7890') }}</p>
                            <a href="https://wa.me/{{ config('app.wa_number') }}?text={{ urlencode('Halo, saya ingin berkonsultasi tentang proyek bangunan') }}" 
                               target="_blank"
                               class="whatsapp-float inline-flex items-center space-x-2 bg-green-500 text-white px-4 py-2 rounded-lg text-sm font-medium
                                      hover:bg-green-600 transition-all duration-200 shadow-md shadow-green-500/20">
                                <i class="fab fa-whatsapp"></i>
                                <span>Chat Sekarang</span>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Email Card -->
                <div class="info-card bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <div class="flex items-start space-x-4">
                        <div class="info-icon w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-envelope text-2xl text-blue-600"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-text-dark mb-1">Email</h3>
                            <p class="text-sm text-text">info@sekawanmakmur.com</p>
                            <a href="mailto:info@sekawanmakmur.com" 
                               class="inline-flex items-center space-x-2 text-primary-900 hover:text-primary-700 text-sm font-medium mt-2">
                                <i class="fas fa-reply"></i>
                                <span>Kirim Email</span>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Office Hours Card -->
                <div class="info-card bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <div class="flex items-start space-x-4">
                        <div class="info-icon w-14 h-14 bg-purple-50 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-clock text-2xl text-purple-600"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-text-dark mb-1">Jam Operasional</h3>
                            <div class="space-y-1.5">
                                <div class="flex items-center text-sm text-text">
                                    <span class="w-20">Senin - Jumat</span>
                                    <span class="font-medium text-text-dark">08:00 - 17:00 WIB</span>
                                </div>
                                <div class="flex items-center text-sm text-text">
                                    <span class="w-20">Sabtu</span>
                                    <span class="font-medium text-text-dark">08:00 - 13:00 WIB</span>
                                </div>
                                <div class="flex items-center text-sm text-text">
                                    <span class="w-20">Minggu</span>
                                    <span class="font-medium text-red-500">Tutup</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Location Card -->
                <div class="info-card bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <div class="flex items-start space-x-4">
                        <div class="info-icon w-14 h-14 bg-red-50 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-map-marker-alt text-2xl text-red-600"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-text-dark mb-1">Alamat Kantor</h3>
                            <p class="text-sm text-text">Jl. Konstruksi No. 123<br>Solo, Jawa Tengah 57168</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Media Section -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                <h3 class="font-heading font-bold text-text-dark mb-4 flex items-center">
                    <i class="fas fa-share-alt text-accent-500 mr-2"></i>
                    Ikuti Kami di Media Sosial
                </h3>
                <p class="text-sm text-text mb-4">
                    Dapatkan inspirasi desain, tips konstruksi, dan update proyek terbaru kami
                </p>
                
                <div class="grid grid-cols-3 gap-3">
                    <!-- Instagram -->
                    <a href="https://instagram.com/sekawanmakmur" target="_blank" 
                       class="social-media-card instagram bg-white rounded-xl p-4 text-center border border-gray-100 relative z-10">
                        <div class="social-icon-wrapper relative z-20">
                            <div class="w-12 h-12 mx-auto mb-2 rounded-xl flex items-center justify-center" 
                                 style="background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);">
                                <i class="fab fa-instagram text-2xl text-white"></i>
                            </div>
                            <div class="social-info relative z-20">
                                <h3 class="font-semibold text-text-dark text-sm">Instagram</h3>
                                <p class="text-xs text-text-light">@sekawanmakmur</p>
                            </div>
                        </div>
                    </a>
                    
                    <!-- TikTok -->
                    <a href="https://tiktok.com/@sekawanmakmur" target="_blank" 
                       class="social-media-card tiktok bg-white rounded-xl p-4 text-center border border-gray-100 relative z-10">
                        <div class="social-icon-wrapper relative z-20">
                            <div class="w-12 h-12 mx-auto mb-2 rounded-xl flex items-center justify-center bg-black">
                                <i class="fab fa-tiktok text-2xl text-white"></i>
                            </div>
                            <div class="social-info relative z-20">
                                <h3 class="font-semibold text-text-dark text-sm">TikTok</h3>
                                <p class="text-xs text-text-light">@sekawanmakmur</p>
                            </div>
                        </div>
                    </a>
                    
                    <!-- Pinterest -->
                    <a href="https://pinterest.com/sekawanmakmur" target="_blank" 
                       class="social-media-card pinterest bg-white rounded-xl p-4 text-center border border-gray-100 relative z-10">
                        <div class="social-icon-wrapper relative z-20">
                            <div class="w-12 h-12 mx-auto mb-2 rounded-xl flex items-center justify-center bg-red-600">
                                <i class="fab fa-pinterest-p text-2xl text-white"></i>
                            </div>
                            <div class="social-info relative z-20">
                                <h3 class="font-semibold text-text-dark text-sm">Pinterest</h3>
                                <p class="text-xs text-text-light">@sekawanmakmur</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Google Maps -->
            <div class="map-container bg-white rounded-2xl shadow-xl p-2">
                <iframe src="{{ config('app.map_embed_url', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3951.5!2d112.6!3d-7.9!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwNTQnMDAuMCJTIDExMsKwMzYnMDAuMCJF!5e0!3m2!1sid!2sid!4v1234567890') }}" 
                        width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
            
            <!-- Social Proof -->
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 text-center">
                <div class="flex justify-center -space-x-2 mb-3">
                    <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center border-2 border-white">
                        <i class="fas fa-star text-accent-500 text-xs"></i>
                    </div>
                    <div class="w-10 h-10 bg-primary-200 rounded-full flex items-center justify-center border-2 border-white">
                        <i class="fas fa-star text-accent-500 text-xs"></i>
                    </div>
                    <div class="w-10 h-10 bg-primary-300 rounded-full flex items-center justify-center border-2 border-white">
                        <i class="fas fa-star text-accent-500 text-xs"></i>
                    </div>
                </div>
                <p class="text-sm text-text">
                    <strong class="text-text-dark">4.9/5</strong> dari <strong class="text-text-dark">100+</strong> klien puas
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Bottom CTA -->
<section class="bg-gray-50 py-16">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-heading font-bold text-text-dark mb-4">
            Lebih Suka Diskusi Langsung?
        </h2>
        <p class="text-text mb-8 max-w-xl mx-auto">
            Kunjungi kantor kami atau hubungi via WhatsApp untuk respon lebih cepat
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="https://wa.me/{{ config('app.wa_number') }}?text={{ urlencode('Halo, saya ingin diskusi langsung tentang proyek') }}" 
               target="_blank"
               class="inline-flex items-center space-x-2 bg-green-500 text-white px-8 py-4 rounded-xl font-semibold
                      hover:bg-green-600 transform hover:scale-105 transition-all duration-200 shadow-lg shadow-green-500/20">
                <i class="fab fa-whatsapp text-xl"></i>
                <span>WhatsApp Sekarang</span>
            </a>
            <a href="tel:+62{{ config('app.wa_number') }}" 
               class="inline-flex items-center space-x-2 bg-primary-900 text-white px-8 py-4 rounded-xl font-semibold
                      hover:bg-primary-800 transform hover:scale-105 transition-all duration-200 shadow-lg shadow-primary-900/20">
                <i class="fas fa-phone"></i>
                <span>Telepon Langsung</span>
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    // Smooth scroll to forms
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Auto-resize textarea
    document.querySelectorAll('textarea').forEach(textarea => {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    });
</script>
@endpush