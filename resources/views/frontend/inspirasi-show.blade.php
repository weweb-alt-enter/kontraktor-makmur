@extends('layouts.app')

@section('title', $inspirasi->judul)
@section('meta_description', Str::limit($inspirasi->deskripsi ?? '', 160))

@php
$breadcrumbs = [
    ['title' => 'Inspirasi Desain', 'url' => route('inspirasi.index')],
    ['title' => $inspirasi->judul]
];
@endphp

@push('styles')
<style>
    .prose-content {
        color: #374151;
        line-height: 1.8;
    }
    
    .detail-card {
        transition: all 0.2s ease;
    }
    
    .detail-card:hover {
        transform: translateX(4px);
        background-color: #f8fafc;
    }
    
    .gallery-thumb {
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .gallery-thumb:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 30px -10px rgba(0,0,0,0.2);
    }
</style>
@endpush

@section('content')
<!-- Hero -->
<section class="relative bg-gradient-to-br from-primary-900 via-primary-800 to-primary-900 text-white py-10 lg:py-14">
    <div class="container mx-auto px-4">
        <x-breadcrumb :breadcrumbs="$breadcrumbs" />
        
        <div class="max-w-4xl mx-auto mt-4">
            @if($inspirasi->kategori || $inspirasi->konsep)
            <div class="flex flex-wrap gap-2 mb-4">
                @if($inspirasi->kategori)
                <span class="px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-full text-xs font-medium">
                    <i class="fas fa-tag mr-1"></i> {{ $inspirasi->kategori }}
                </span>
                @endif
                @if($inspirasi->konsep)
                <span class="px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-full text-xs font-medium">
                    <i class="fas fa-palette mr-1"></i> {{ $inspirasi->konsep }}
                </span>
                @endif
            </div>
            @endif
            
            <h1 class="text-2xl lg:text-3xl font-heading font-bold">
                {{ $inspirasi->judul }}
            </h1>
        </div>
    </div>
    
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 40" class="w-full h-auto" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 40V20C240 0 480 0 720 20C960 40 1200 40 1440 20V40H0Z" fill="#f9fafb"/>
        </svg>
    </div>
</section>

<div class="container mx-auto px-4 py-8">
    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Featured Image -->
            @if($inspirasi->gambar)
            <div class="rounded-2xl overflow-hidden shadow-xl mt-23 relative z-10">
                <img src="{{ Storage::url($inspirasi->gambar) }}" alt="{{ $inspirasi->judul }}" 
                     class="w-full h-[400px] object-cover">
            </div>
            @endif

            <!-- Gallery -->
            @if($inspirasi->galleries->isNotEmpty())
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-heading font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-images text-primary-900"></i> Galeri Desain
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach($inspirasi->galleries as $gallery)
                    <div class="gallery-thumb aspect-square rounded-xl overflow-hidden" 
                         onclick="openLightbox('{{ Storage::url($gallery->image_path) }}', '{{ $gallery->caption ?? '' }}')">
                        <img src="{{ Storage::url($gallery->image_path) }}" alt="{{ $gallery->caption }}" 
                             class="w-full h-full object-cover" loading="lazy">
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Description -->
            @if($inspirasi->deskripsi)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-heading font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-align-left text-primary-900"></i> Deskripsi
                </h3>
                <div class="prose-content">
                    {!! nl2br(e($inspirasi->deskripsi)) !!}
                </div>
            </div>
            @endif

            <!-- Share -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <span class="font-semibold text-gray-900 mr-4">Bagikan:</span>
                <div class="inline-flex gap-2 mt-2 sm:mt-0">
                    <a href="https://wa.me/?text={{ urlencode($inspirasi->judul . ' - ' . route('inspirasi.show', $inspirasi->slug)) }}" 
                       target="_blank" class="bg-green-500 text-white px-4 py-2 rounded-xl text-sm hover:bg-green-600 transition">
                        <i class="fab fa-whatsapp mr-1"></i> WA
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('inspirasi.show', $inspirasi->slug)) }}" 
                       target="_blank" class="bg-blue-600 text-white px-4 py-2 rounded-xl text-sm hover:bg-blue-700 transition">
                        <i class="fab fa-facebook mr-1"></i> FB
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('inspirasi.show', $inspirasi->slug)) }}&text={{ urlencode($inspirasi->judul) }}" 
                       target="_blank" class="bg-sky-500 text-white px-4 py-2 rounded-xl text-sm hover:bg-sky-600 transition">
                        <i class="fab fa-twitter mr-1"></i> TW
                    </a>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="sticky top-24 space-y-6">
                <!-- Detail Info -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-heading font-bold text-gray-900 mb-4">Detail Desain</h3>
                    <div class="space-y-1">
                        @if($inspirasi->kategori)
                        <div class="detail-card flex items-center justify-between p-3 rounded-xl">
                            <span class="text-sm text-gray-500">Kategori</span>
                            <span class="text-sm font-medium text-gray-900">{{ $inspirasi->kategori }}</span>
                        </div>
                        @endif
                        
                        @if($inspirasi->konsep)
                        <div class="detail-card flex items-center justify-between p-3 rounded-xl">
                            <span class="text-sm text-gray-500">Konsep</span>
                            <span class="text-sm font-medium text-gray-900">{{ $inspirasi->konsep }}</span>
                        </div>
                        @endif
                        
                        @if($inspirasi->warna_dominan)
                        <div class="detail-card flex items-center justify-between p-3 rounded-xl">
                            <span class="text-sm text-gray-500">Warna</span>
                            <span class="text-sm font-medium text-gray-900">{{ $inspirasi->warna_dominan }}</span>
                        </div>
                        @endif
                        
                        @if($inspirasi->estimasi_biaya)
                        <div class="detail-card flex items-center justify-between p-3 rounded-xl">
                            <span class="text-sm text-gray-500">Estimasi</span>
                            <span class="text-sm font-medium text-gray-900">Rp {{ number_format($inspirasi->estimasi_biaya, 0, ',', '.') }}/m²</span>
                        </div>
                        @endif
                    </div>
                    
                    @if($inspirasi->tags)
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <p class="text-xs text-gray-500 mb-2">Tags</p>
                        <div class="flex flex-wrap gap-1.5">
                            @foreach(explode(',', $inspirasi->tags) as $tag)
                            <span class="px-2.5 py-1 bg-gray-100 text-gray-600 rounded-full text-xs">{{ trim($tag) }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <!-- CTA -->
                <div class="bg-gradient-to-br from-primary-900 to-primary-800 rounded-2xl p-6 text-white text-center">
                    <i class="fas fa-headset text-3xl text-accent-500 mb-3"></i>
                    <h4 class="font-heading font-bold mb-2">Tertarik?</h4>
                    <p class="text-sm text-white/70 mb-4">Wujudkan desain impian Anda bersama kami</p>
                    <a href="{{ route('contact') }}" 
                       class="block bg-accent-500 text-primary-900 py-2.5 rounded-xl font-semibold text-sm hover:bg-accent-400 transition">
                        Konsultasi Gratis
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Inspirasi -->
    @if($relatedInspirasi->isNotEmpty())
    <div class="mt-12">
        <h3 class="text-2xl font-heading font-bold text-gray-900 mb-6">Inspirasi Lainnya</h3>
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedInspirasi as $item)
            <article class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-200 group">
                <div class="h-40 overflow-hidden">
                    @if($item->gambar)
                    <img src="{{ Storage::url($item->gambar) }}" alt="{{ $item->judul }}" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                    <div class="w-full h-full bg-purple-100 flex items-center justify-center">
                        <i class="fas fa-paint-brush text-3xl text-purple-300"></i>
                    </div>
                    @endif
                </div>
                <div class="p-4">
                    @if($item->konsep)
                    <span class="text-[10px] bg-purple-50 text-purple-700 px-2 py-0.5 rounded-full">{{ $item->konsep }}</span>
                    @endif
                    <h4 class="font-semibold text-gray-900 text-sm mt-2 line-clamp-2">
                        <a href="{{ route('inspirasi.show', $item->slug) }}" class="hover:text-primary-900">{{ $item->judul }}</a>
                    </h4>
                </div>
            </article>
            @endforeach
        </div>
    </div>
    @endif
</div>

<!-- Lightbox -->
<div id="lightbox" class="fixed inset-0 bg-black/95 z-50 hidden items-center justify-center cursor-pointer" onclick="closeLightbox()">
    <button class="absolute top-4 right-4 text-white/70 hover:text-white text-3xl z-50"><i class="fas fa-times"></i></button>
    <img id="lightboxImg" src="" alt="" class="max-w-[90vw] max-h-[90vh] object-contain rounded-xl" onclick="event.stopPropagation()">
    <p id="lightboxCaption" class="absolute bottom-8 text-white text-center text-lg"></p>
</div>

{{-- Konsultasi Modal --}}
<div id="konsultasiModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4" 
     onclick="closeKonsultasiModal()">
    <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full max-h-[90vh] overflow-y-auto" 
         onclick="event.stopPropagation()">
        <div class="p-6">
            <div class="flex justify-between items-center mb-5">
                <div>
                    <h3 class="text-xl font-heading font-bold text-gray-900">Konsultasi Gratis</h3>
                    <p class="text-sm text-gray-500 mt-1">Tertarik dengan inspirasi desain ini? Diskusikan dengan tim kami</p>
                </div>
                <button onclick="closeKonsultasiModal()" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 text-gray-400 hover:bg-gray-200 hover:text-gray-600 transition">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            {{-- Info Inspirasi --}}
            <div class="bg-purple-50 rounded-xl p-4 mb-5">
                <div class="flex items-center gap-2 mb-1">
                    <i class="fas fa-paint-brush text-purple-600"></i>
                    <span class="text-xs font-semibold text-purple-700 uppercase">Inspirasi Desain</span>
                </div>
                <p class="text-sm font-semibold text-gray-900">{{ $inspirasi->judul }}</p>
                <p class="text-xs text-gray-600">
                    {{ $inspirasi->kategori ?? 'Desain' }} 
                    @if($inspirasi->konsep) • {{ $inspirasi->konsep }} @endif
                    @if($inspirasi->warna_dominan) • {{ $inspirasi->warna_dominan }} @endif
                </p>
            </div>
            
            <form action="{{ route('konsultasi.store') }}" method="POST" class="space-y-4">
                @csrf
                
                {{-- Hidden fields --}}
                <input type="hidden" name="source_type" value="inspirasi">
                <input type="hidden" name="source_slug" value="{{ $inspirasi->slug }}">
                <input type="hidden" name="source_judul" value="{{ $inspirasi->judul }}">
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap *</label>
                    <input type="text" name="nama" required 
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:border-purple-500 focus:ring-2 focus:ring-purple-100 transition-all text-sm"
                           placeholder="Nama Anda">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email *</label>
                    <input type="email" name="email" required 
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:border-purple-500 focus:ring-2 focus:ring-purple-100 transition-all text-sm"
                           placeholder="email@example.com">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">No WhatsApp *</label>
                    <input type="text" name="no_wa" required 
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:border-purple-500 focus:ring-2 focus:ring-purple-100 transition-all text-sm"
                           placeholder="62812xxxxxxxx">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi Kebutuhan *</label>
                    <textarea name="deskripsi" rows="3" required 
                              class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:border-purple-500 focus:ring-2 focus:ring-purple-100 transition-all text-sm resize-none"
                              placeholder="Jelaskan kebutuhan desain Anda...">{{ 'Halo, saya tertarik dengan inspirasi desain "' . $inspirasi->judul . '" dan ingin berkonsultasi lebih lanjut.' }}</textarea>
                </div>
                <button type="submit" 
                        class="w-full bg-purple-600 text-white py-3.5 rounded-xl font-semibold hover:bg-purple-700 transition-all duration-200 flex items-center justify-center gap-2 shadow-lg shadow-purple-600/20">
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
function openLightbox(url, caption) {
    document.getElementById('lightboxImg').src = url;
    document.getElementById('lightboxCaption').textContent = caption;
    document.getElementById('lightbox').classList.remove('hidden');
    document.getElementById('lightbox').classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightbox').classList.add('hidden');
    document.getElementById('lightbox').classList.remove('flex');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeLightbox();
});
</script>
@endpush