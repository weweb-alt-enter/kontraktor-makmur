@extends('layouts.app')

@section('title', $portofolio->nama_proyek)
@section('meta_description', Str::limit(strip_tags($portofolio->deskripsi), 160))

@php
$breadcrumbs = [
    ['title' => 'Portofolio', 'url' => route('portofolio.index')],
    ['title' => $portofolio->nama_proyek]
];
@endphp

@push('styles')
<style>
    .gallery-thumb {
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .gallery-thumb:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 30px -10px rgba(0,0,0,0.2);
    }
    
    .spec-card {
        transition: all 0.2s ease;
    }
    
    .spec-card:hover {
        background-color: #f8fafc;
        transform: translateX(4px);
    }
    
    .sticky-cta-desktop {
        animation: slideInRight 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55) 0.3s both;
    }
    
    @keyframes slideInRight {
        from {
            transform: translateX(100px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    .lightbox-img {
        transition: opacity 0.3s ease;
    }
    
    .before-after-container {
        position: relative;
        overflow: hidden;
        border-radius: 1rem;
    }
    
    .before-after-container img {
        transition: clip-path 0.5s ease;
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-primary-900 via-primary-800 to-primary-900 text-white py-10 lg:py-14">
    <div class="container mx-auto px-4">
        <x-breadcrumb :breadcrumbs="$breadcrumbs" />
        
        <div class="flex flex-wrap items-start justify-between gap-4 mt-4">
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-3 py-1.5 text-xs font-semibold rounded-full 
                        @if($portofolio->status_proyek == 'selesai') bg-green-500/90 text-white
                        @elseif($portofolio->status_proyek == 'berjalan') bg-yellow-500/90 text-white
                        @else bg-blue-500/90 text-white @endif">
                        <i class="fas fa-circle text-[6px] mr-1"></i>
                        {{ ucfirst($portofolio->status_proyek) }}
                    </span>
                    @if($portofolio->is_featured)
                    <span class="px-3 py-1.5 text-xs font-semibold rounded-full bg-accent-500/90 text-primary-900">
                        <i class="fas fa-star mr-1"></i> Unggulan
                    </span>
                    @endif
                </div>
                <h1 class="text-2xl lg:text-3xl font-heading font-bold">
                    {{ $portofolio->nama_proyek }}
                </h1>
            </div>
            
            <button onclick="toggleFavorite({{ $portofolio->id }})" 
                    class="flex items-center gap-2 bg-white/10 backdrop-blur-sm px-4 py-2.5 rounded-xl 
                           hover:bg-white/20 transition-all duration-200 border border-white/20">
                <i id="favoriteIconTop" class="fas fa-heart text-lg {{ $isFavorited ? 'text-red-400' : 'text-white/60' }}"></i>
                <span class="text-sm">Favorit</span>
            </button>
        </div>
    </div>
</section>

<!-- Sticky CTA - Desktop -->
<div class="hidden lg:block fixed right-4 top-1/3 z-40 space-y-2 sticky-cta-desktop">
    <a href="https://wa.me/{{ config('app.wa_number') }}?text={{ urlencode('Halo, saya tertarik dengan proyek ' . $portofolio->nama_proyek) }}" 
       target="_blank"
       class="flex items-center bg-green-500 text-white pl-4 pr-5 py-3 rounded-l-2xl 
              hover:bg-green-600 transition-all duration-300 shadow-xl group w-[56px] hover:w-auto overflow-hidden">
        <i class="fab fa-whatsapp text-xl flex-shrink-0"></i>
        <span class="ml-2 whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-sm font-medium">
            Hubungi WA
        </span>
    </a>
    
    <button onclick="openKonsultasiModal()" 
            class="flex items-center bg-accent-500 text-primary-900 pl-4 pr-5 py-3 rounded-l-2xl 
                   hover:bg-accent-400 transition-all duration-300 shadow-xl group w-[56px] hover:w-auto overflow-hidden">
        <i class="fas fa-comments text-xl flex-shrink-0"></i>
        <span class="ml-2 whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-sm font-medium">
            Konsultasi Gratis
        </span>
    </button>
    
    <button onclick="toggleFavorite({{ $portofolio->id }})" 
            class="flex items-center bg-white pl-4 pr-5 py-3 rounded-l-2xl 
                   hover:bg-red-50 transition-all duration-300 shadow-xl group w-[56px] hover:w-auto overflow-hidden border border-gray-200">
        <i id="favoriteIconSide" class="fas fa-heart text-xl {{ $isFavorited ? 'text-red-500' : 'text-gray-400' }} flex-shrink-0"></i>
        <span class="ml-2 whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-sm font-medium text-gray-700">
            {{ $isFavorited ? 'Hapus Favorit' : 'Tambah Favorit' }}
        </span>
    </button>
</div>

<!-- Mobile Sticky CTA -->
<div class="lg:hidden fixed bottom-[72px] left-0 right-0 z-40 bg-white/95 backdrop-blur-sm border-t shadow-2xl px-4 py-2.5">
    <div class="flex gap-2.5 max-w-lg mx-auto">
        <a href="https://wa.me/{{ config('app.wa_number') }}?text={{ urlencode('Halo, saya tertarik dengan proyek ' . $portofolio->nama_proyek) }}" 
           target="_blank"
           class="flex-1 bg-green-500 text-white py-3 rounded-xl font-medium text-sm text-center
                  hover:bg-green-600 transition-all duration-200 flex items-center justify-center gap-2 shadow-lg shadow-green-500/20">
            <i class="fab fa-whatsapp"></i> WhatsApp
        </a>
        <button onclick="openKonsultasiModal()" 
                class="flex-1 bg-accent-500 text-primary-900 py-3 rounded-xl font-medium text-sm
                       hover:bg-accent-400 transition-all duration-200 flex items-center justify-center gap-2 shadow-lg shadow-accent-500/20">
            <i class="fas fa-comments"></i> Konsultasi
        </button>
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Main Content - 2/3 -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Image Gallery -->
            @if($portofolio->galleries->isNotEmpty())
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Main Image -->
                <div class="relative cursor-pointer" onclick="openLightbox(0)">
                    <img src="{{ Storage::url($portofolio->galleries->first()->image_path) }}" 
                         alt="{{ $portofolio->galleries->first()->caption ?? $portofolio->nama_proyek }}" 
                         class="w-full h-[400px] lg:h-[500px] object-cover">
                    <div class="absolute inset-0 bg-black/0 hover:bg-black/20 transition-colors flex items-center justify-center">
                        <span class="opacity-0 hover:opacity-100 transition-opacity bg-white/90 text-primary-900 px-6 py-3 rounded-xl font-semibold">
                            <i class="fas fa-expand mr-2"></i> Lihat Gallery
                        </span>
                    </div>
                </div>
                
                <!-- Thumbnails -->
                @if($portofolio->galleries->count() > 1)
                <div class="grid grid-cols-4 gap-2 p-4">
                    @foreach($portofolio->galleries->take(4) as $index => $gallery)
                    <div class="gallery-thumb aspect-square rounded-lg overflow-hidden" 
                         onclick="openLightbox({{ $index }})">
                        <img src="{{ Storage::url($gallery->image_path) }}" 
                             alt="{{ $gallery->caption }}" 
                             class="w-full h-full object-cover"
                             loading="lazy">
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            @endif

            <!-- Before-After Section -->
            @php
            $beforeAfterPairs = $portofolio->galleries->where('is_before', true)->filter(fn($g) => $g->before_image_id);
            @endphp
            
            @if($beforeAfterPairs->isNotEmpty())
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-xl font-heading font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <i class="fas fa-arrows-left-right text-accent-500"></i> Sebelum & Sesudah
                </h3>
                @foreach($beforeAfterPairs as $before)
                @php $after = $before->afterImage; @endphp
                @if($after)
                <div class="before-after-container mb-6 last:mb-0">
                    <div class="grid grid-cols-2 gap-2">
                        <div class="relative rounded-xl overflow-hidden">
                            <img src="{{ Storage::url($before->image_path) }}" alt="Sebelum" class="w-full h-64 object-cover">
                            <div class="absolute top-3 left-3 bg-black/60 backdrop-blur-sm text-white px-3 py-1.5 rounded-lg text-xs font-medium">
                                Sebelum
                            </div>
                        </div>
                        <div class="relative rounded-xl overflow-hidden">
                            <img src="{{ Storage::url($after->image_path) }}" alt="Sesudah" class="w-full h-64 object-cover">
                            <div class="absolute top-3 right-3 bg-green-500/80 backdrop-blur-sm text-white px-3 py-1.5 rounded-lg text-xs font-medium">
                                Sesudah
                            </div>
                        </div>
                    </div>
                    @if($before->caption)
                    <p class="text-center text-sm text-gray-500 mt-3">{{ $before->caption }}</p>
                    @endif
                </div>
                @endif
                @endforeach
            </div>
            @endif

            <!-- Description -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-xl font-heading font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-clipboard-list text-primary-900"></i> Deskripsi Proyek
                </h3>
                <div class="prose max-w-none text-gray-700 leading-relaxed">
                    {!! nl2br(e($portofolio->deskripsi)) !!}
                </div>
            </div>

            <!-- Testimonials -->
            @if($portofolio->testimoni->isNotEmpty())
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-xl font-heading font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <i class="fas fa-star text-accent-500"></i> Testimoni Klien
                </h3>
                <div class="space-y-6">
                    @foreach($portofolio->testimoni as $testimoni)
                    <div class="flex gap-4 p-4 bg-gray-50 rounded-xl">
                        <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0">
                            @if($testimoni->foto_client)
                            <img src="{{ Storage::url($testimoni->foto_client) }}" alt="{{ $testimoni->nama_client }}" class="w-full h-full rounded-full object-cover">
                            @else
                            <i class="fas fa-user text-primary-900"></i>
                            @endif
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <h4 class="font-semibold text-gray-900">{{ $testimoni->nama_client }}</h4>
                                <div class="flex text-accent-500 text-sm">
                                    @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $testimoni->rating ? '' : 'text-gray-300' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            <p class="text-gray-600 italic">"{{ $testimoni->isi_testimoni }}"</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Project Map -->
            @if($portofolio->koordinat_lat && $portofolio->koordinat_lng)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="flex items-center gap-2 px-6 py-4 border-b border-gray-100">
                    <i class="fas fa-map-marker-alt text-primary-900"></i>
                    <h3 class="font-heading font-semibold text-gray-900">Lokasi Proyek</h3>
                </div>
                <div id="projectMap" class="w-full h-80"></div>
            </div>
            @endif

            <!-- Consultation Form -->
            <!-- Consultation Form (di halaman) -->
            <div id="konsultasiForm" class="bg-gradient-to-br from-primary-50 to-blue-50 rounded-2xl shadow-sm border border-primary-200 p-6 lg:p-8">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-primary-900 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <i class="fas fa-headset text-2xl text-accent-500"></i>
                    </div>
                    <h3 class="text-xl font-heading font-bold text-gray-900">Tertarik dengan Proyek Ini?</h3>
                    <p class="text-gray-600 text-sm mt-1">
                        Dapatkan konsultasi dan penawaran gratis untuk proyek 
                        <strong class="text-primary-900">{{ $portofolio->nama_proyek }}</strong>
                    </p>
                </div>
                
                <form action="{{ route('konsultasi.store') }}" method="POST">
                    @csrf
                    
                    {{-- Hidden fields untuk identifikasi sumber --}}
                    <input type="hidden" name="source_type" value="portofolio">
                    <input type="hidden" name="source_slug" value="{{ $portofolio->slug }}">
                    <input type="hidden" name="source_judul" value="{{ $portofolio->nama_proyek }}">
                    
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap *</label>
                            <input type="text" name="nama" required 
                                class="w-full rounded-xl border-gray-200 bg-white py-2.5 px-4 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm"
                                placeholder="Nama Anda">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email *</label>
                            <input type="email" name="email" required 
                                class="w-full rounded-xl border-gray-200 bg-white py-2.5 px-4 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm"
                                placeholder="email@example.com">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">No WhatsApp *</label>
                            <input type="text" name="no_wa" required 
                                class="w-full rounded-xl border-gray-200 bg-white py-2.5 px-4 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm"
                                placeholder="62812xxxxxxxx">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi Kebutuhan *</label>
                            <textarea name="deskripsi" rows="3" required 
                                    class="w-full rounded-xl border-gray-200 bg-white py-2.5 px-4 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm resize-none"
                                    placeholder="Jelaskan kebutuhan Anda terkait proyek {{ $portofolio->nama_proyek }}..."></textarea>
                        </div>
                    </div>
                    <button type="submit" 
                            class="w-full mt-4 bg-primary-900 text-white py-3.5 rounded-xl font-semibold hover:bg-primary-800 transform hover:scale-[1.01] transition-all duration-200 flex items-center justify-center gap-2 shadow-lg shadow-primary-900/20">
                        <i class="fas fa-paper-plane"></i> Kirim Permintaan Konsultasi
                    </button>
                </form>
            </div>
        </div>

        <!-- Sidebar - 1/3 -->
        <div class="lg:col-span-1">
            <div class="sticky top-24 space-y-6">
                <!-- Specifications -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-heading font-bold text-gray-900 mb-5 flex items-center gap-2">
                        <i class="fas fa-list-ul text-primary-900"></i> Spesifikasi
                    </h3>
                    
                    <div class="space-y-1">
                        @if($portofolio->jenisLayanan)
                        <div class="spec-card flex items-center justify-between p-3 rounded-xl">
                            <span class="text-sm text-gray-500">Jenis Layanan</span>
                            <span class="text-sm font-medium text-gray-900">{{ $portofolio->jenisLayanan->nama_layanan }}</span>
                        </div>
                        @endif
                        
                        @if($portofolio->jenisBangunan)
                        <div class="spec-card flex items-center justify-between p-3 rounded-xl">
                            <span class="text-sm text-gray-500">Jenis Bangunan</span>
                            <span class="text-sm font-medium text-gray-900">{{ $portofolio->jenisBangunan->nama_bangunan }}</span>
                        </div>
                        @endif
                        
                        <div class="spec-card flex items-center justify-between p-3 rounded-xl">
                            <span class="text-sm text-gray-500">Lokasi</span>
                            <span class="text-sm font-medium text-gray-900 text-right max-w-[180px]">{{ $portofolio->lokasi }}</span>
                        </div>
                        
                        @if($portofolio->luas_bangunan)
                        <div class="spec-card flex items-center justify-between p-3 rounded-xl">
                            <span class="text-sm text-gray-500">Luas Bangunan</span>
                            <span class="text-sm font-medium text-gray-900">{{ number_format($portofolio->luas_bangunan) }} m²</span>
                        </div>
                        @endif
                        
                        @if($portofolio->estimasi_budget)
                        <div class="spec-card flex items-center justify-between p-3 rounded-xl">
                            <span class="text-sm text-gray-500">Budget</span>
                            <span class="text-sm font-medium text-gray-900">Rp {{ number_format($portofolio->estimasi_budget, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        
                        @if($portofolio->durasi_pengerjaan)
                        <div class="spec-card flex items-center justify-between p-3 rounded-xl">
                            <span class="text-sm text-gray-500">Durasi</span>
                            <span class="text-sm font-medium text-gray-900">{{ $portofolio->durasi_pengerjaan }}</span>
                        </div>
                        @endif
                        
                        @if($portofolio->tahun_selesai)
                        <div class="spec-card flex items-center justify-between p-3 rounded-xl">
                            <span class="text-sm text-gray-500">Tahun</span>
                            <span class="text-sm font-medium text-gray-900">{{ $portofolio->tahun_selesai }}</span>
                        </div>
                        @endif
                        
                        @if($portofolio->klien_nama)
                        <div class="spec-card flex items-center justify-between p-3 rounded-xl">
                            <span class="text-sm text-gray-500">Klien</span>
                            <span class="text-sm font-medium text-gray-900">{{ $portofolio->klien_nama }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Share Project -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h4 class="font-semibold text-gray-900 mb-3">Bagikan Proyek</h4>
                    <div class="flex gap-2">
                        <a href="https://wa.me/?text={{ urlencode($portofolio->nama_proyek . ' - ' . route('portofolio.detail', $portofolio->slug)) }}" 
                           target="_blank"
                           class="flex-1 bg-green-500 text-white py-2.5 rounded-xl text-sm font-medium text-center hover:bg-green-600 transition">
                            <i class="fab fa-whatsapp mr-1"></i> WA
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('portofolio.detail', $portofolio->slug)) }}" 
                           target="_blank"
                           class="flex-1 bg-blue-600 text-white py-2.5 rounded-xl text-sm font-medium text-center hover:bg-blue-700 transition">
                            <i class="fab fa-facebook mr-1"></i> FB
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('portofolio.detail', $portofolio->slug)) }}&text={{ urlencode($portofolio->nama_proyek) }}" 
                           target="_blank"
                           class="flex-1 bg-sky-500 text-white py-2.5 rounded-xl text-sm font-medium text-center hover:bg-sky-600 transition">
                            <i class="fab fa-twitter mr-1"></i> TW
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Lightbox -->
<div id="lightbox" class="fixed inset-0 bg-black/95 z-50 hidden items-center justify-center" onclick="closeLightbox()">
    <button class="absolute top-4 right-4 text-white/70 hover:text-white text-3xl z-50 transition">
        <i class="fas fa-times"></i>
    </button>
    <button onclick="event.stopPropagation(); prevImage()" 
            class="absolute left-4 text-white/70 hover:text-white text-4xl z-50 transition">
        <i class="fas fa-chevron-left"></i>
    </button>
    <button onclick="event.stopPropagation(); nextImage()" 
            class="absolute right-4 text-white/70 hover:text-white text-4xl z-50 transition">
        <i class="fas fa-chevron-right"></i>
    </button>
    <div class="max-w-6xl max-h-[90vh] px-4" onclick="event.stopPropagation()">
        <img id="lightboxImage" src="" alt="" class="max-w-full max-h-[85vh] object-contain rounded-xl shadow-2xl">
        <p id="lightboxCaption" class="text-white text-center mt-4 text-lg"></p>
        <p id="lightboxCounter" class="text-white/50 text-center text-sm mt-1"></p>
    </div>
</div>

<!-- Konsultasi Modal -->
<!-- Konsultasi Modal -->
<!-- Konsultasi Modal -->
<div id="konsultasiModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4" 
     onclick="closeKonsultasiModal()">
    <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto" 
         onclick="event.stopPropagation()">
        <div class="p-6">
            <div class="flex justify-between items-center mb-5">
                <div>
                    <h3 class="text-xl font-heading font-bold text-gray-900">Konsultasi Gratis</h3>
                    <p class="text-sm text-gray-500 mt-1">Tertarik dengan proyek ini? Diskusikan dengan tim kami</p>
                </div>
                <button onclick="closeKonsultasiModal()" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 text-gray-400 hover:bg-gray-200 hover:text-gray-600 transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            {{-- Info Proyek --}}
            <div class="bg-primary-50 rounded-xl p-4 mb-5">
                <div class="flex items-center gap-2 mb-1">
                    <i class="fas fa-briefcase text-primary-900"></i>
                    <span class="text-xs font-semibold text-primary-900 uppercase">Proyek Terkait</span>
                </div>
                <p class="text-sm font-semibold text-gray-900">{{ $portofolio->nama_proyek }}</p>
                <p class="text-xs text-gray-600">{{ $portofolio->jenisLayanan?->nama_layanan ?? '' }} • {{ $portofolio->lokasi }}</p>
            </div>
            
            <form action="{{ route('konsultasi.store') }}" method="POST" class="space-y-4">
                @csrf
                
                {{-- Hidden fields --}}
                <input type="hidden" name="source_type" value="portofolio">
                <input type="hidden" name="source_slug" value="{{ $portofolio->slug }}">
                <input type="hidden" name="source_judul" value="{{ $portofolio->nama_proyek }}">
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap *</label>
                    <input type="text" name="nama" required 
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm"
                           placeholder="Nama Anda">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email *</label>
                    <input type="email" name="email" required 
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm"
                           placeholder="email@example.com">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">No WhatsApp *</label>
                    <input type="text" name="no_wa" required 
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm"
                           placeholder="62812xxxxxxxx">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi Kebutuhan *</label>
                    <textarea name="deskripsi" rows="3" required 
                              class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm resize-none"
                              placeholder="Jelaskan kebutuhan Anda terkait proyek ini..."></textarea>
                </div>
                <button type="submit" 
                        class="w-full bg-primary-900 text-white py-3.5 rounded-xl font-semibold hover:bg-primary-800 transition-all duration-200 flex items-center justify-center gap-2 shadow-lg shadow-primary-900/20">
                    <i class="fas fa-paper-plane"></i> Kirim Konsultasi
                </button>
                <p class="text-xs text-gray-400 text-center">
                    <i class="fas fa-shield-alt mr-1"></i> Data Anda aman dan hanya digunakan untuk konsultasi
                </p>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Lightbox
const galleryImages = @json($portofolio->galleries->map(fn($g) => ['url' => Storage::url($g->image_path), 'caption' => $g->caption ?? '']));
let currentIndex = 0;

function openLightbox(index) {
    currentIndex = index;
    updateLightbox();
    document.getElementById('lightbox').classList.remove('hidden');
    document.getElementById('lightbox').classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightbox').classList.add('hidden');
    document.getElementById('lightbox').classList.remove('flex');
    document.body.style.overflow = '';
}

function prevImage() { currentIndex = (currentIndex - 1 + galleryImages.length) % galleryImages.length; updateLightbox(); }
function nextImage() { currentIndex = (currentIndex + 1) % galleryImages.length; updateLightbox(); }

function updateLightbox() {
    document.getElementById('lightboxImage').src = galleryImages[currentIndex].url;
    document.getElementById('lightboxCaption').textContent = galleryImages[currentIndex].caption;
    document.getElementById('lightboxCounter').textContent = `${currentIndex + 1} / ${galleryImages.length}`;
}

document.addEventListener('keydown', function(e) {
    if (document.getElementById('lightbox').classList.contains('flex')) {
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') prevImage();
        if (e.key === 'ArrowRight') nextImage();
    }
});

// Konsultasi modal
function openKonsultasiModal() {
    document.getElementById('konsultasiModal').classList.remove('hidden');
    document.getElementById('konsultasiModal').classList.add('flex');
}

function closeKonsultasiModal() {
    document.getElementById('konsultasiModal').classList.add('hidden');
    document.getElementById('konsultasiModal').classList.remove('flex');
}

// Favorite
function toggleFavorite(id) {
    fetch('{{ route("favorites.toggle") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ portofolio_id: id })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            document.querySelectorAll('#favoriteIconTop, #favoriteIconSide').forEach(icon => {
                icon.className = data.is_favorited ? 'fas fa-heart text-lg text-red-400' : 'fas fa-heart text-lg text-white/60';
            });
        }
    });
}

// Project map
@if($portofolio->koordinat_lat && $portofolio->koordinat_lng)
setTimeout(function() {
    if (typeof L !== 'undefined') {
        const map = L.map('projectMap').setView([{{ $portofolio->koordinat_lat }}, {{ $portofolio->koordinat_lng }}], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);
        L.marker([{{ $portofolio->koordinat_lat }}, {{ $portofolio->koordinat_lng }}])
            .addTo(map)
            .bindPopup('<strong>{{ addslashes($portofolio->nama_proyek) }}</strong><br>{{ addslashes($portofolio->lokasi) }}')
            .openPopup();
    }
}, 300);
@endif
</script>
@endpush