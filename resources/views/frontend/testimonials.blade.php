@extends('layouts.app')

@section('title', 'Testimoni Klien')
@section('meta_description', 'Baca testimoni dari klien yang puas dengan layanan Sekawan Makmur Kontraktor. Rating 4.9/5 dari 100+ klien.')

@php
$breadcrumbs = [
    ['title' => 'Testimoni', 'url' => route('testimonials')]
];
@endphp

@push('styles')
<style>
    .testimonial-card {
        transition: all 0.3s ease;
    }
    .testimonial-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
    }
    .testimonial-card:hover .quote-icon {
        transform: scale(1.2) rotate(-10deg);
        color: #FBBF24;
    }
    .quote-icon {
        transition: all 0.3s ease;
    }
    .rating-stars .star {
        transition: all 0.2s ease;
    }
    .testimonial-card:hover .rating-stars .star {
        animation: starPulse 0.6s ease;
    }
    @keyframes starPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.3); }
    }
</style>
@endpush

@section('content')
<section class="relative bg-gradient-to-br from-primary-900 via-primary-800 to-primary-900 text-white py-12 lg:py-16">
    <div class="container mx-auto px-4 text-center">
        <x-breadcrumb :breadcrumbs="$breadcrumbs" />
        <div class="max-w-3xl mx-auto mt-6">
            <span class="inline-flex items-center bg-white/10 backdrop-blur-sm rounded-full px-4 py-1.5 text-sm mb-4 border border-white/20">
                <i class="fas fa-star text-accent-500 mr-2"></i> Rating 4.9/5
            </span>
            <h1 class="text-4xl lg:text-5xl font-heading font-bold mb-4">
                Testimoni <span class="text-accent-500">Klien</span>
            </h1>
            <p class="text-xl text-white/80">
                Apa kata mereka tentang layanan kami? Kepuasan Anda adalah prioritas kami.
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
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-10 -mt-20 relative z-20">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div>
                <div class="text-3xl font-bold text-primary-900">{{ $testimonials->total() }}+</div>
                <div class="text-sm text-gray-500">Testimoni</div>
            </div>
            <div>
                <div class="text-3xl font-bold text-accent-500">4.9</div>
                <div class="text-sm text-gray-500">Rating Rata-rata</div>
            </div>
            <div>
                <div class="text-3xl font-bold text-green-600">98%</div>
                <div class="text-sm text-gray-500">Klien Puas</div>
            </div>
            <div>
                <div class="text-3xl font-bold text-primary-900">100+</div>
                <div class="text-sm text-gray-500">Proyek Selesai</div>
            </div>
        </div>
    </div>

    @if($testimonials->isNotEmpty())
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($testimonials as $testimoni)
        <div class="testimonial-card bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative">
            <div class="quote-icon absolute top-4 right-6 text-5xl text-gray-100 font-serif">"</div>
            <div class="rating-stars flex items-center gap-0.5 mb-4 text-accent-500">
                @for($i = 1; $i <= 5; $i++)
                <i class="star fas fa-star text-sm {{ $i <= $testimoni->rating ? '' : 'text-gray-200' }}"
                   style="animation-delay: {{ $i * 0.1 }}s"></i>
                @endfor
            </div>
            <p class="text-gray-600 leading-relaxed mb-6 relative z-10 italic">
                "{{ $testimoni->isi_testimoni }}"
            </p>
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                @if($testimoni->foto_client)
                <img src="{{ storage_url($testimoni->foto_client) }}"
                     alt="{{ $testimoni->nama_client }}"
                     class="w-12 h-12 rounded-full object-cover ring-2 ring-primary-100">
                @else
                <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center ring-2 ring-primary-200">
                    <span class="text-primary-900 font-bold text-lg">{{ substr($testimoni->nama_client, 0, 1) }}</span>
                </div>
                @endif
                <div>
                    <h4 class="font-semibold text-gray-900">{{ $testimoni->nama_client }}</h4>
                    @if($testimoni->portofolio)
                    <a href="{{ route('portofolio.detail', $testimoni->portofolio->slug) }}"
                       class="text-sm text-primary-600 hover:text-primary-900 transition font-medium">
                        {{ $testimoni->portofolio->nama_proyek }}
                    </a>
                    @else
                    <span class="text-sm text-gray-400">Klien</span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-10">{{ $testimonials->links() }}</div>
    @else
    <div class="text-center py-20">
        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-comments text-4xl text-gray-400"></i>
        </div>
        <h3 class="text-2xl font-heading font-semibold text-gray-700 mb-2">Belum Ada Testimoni</h3>
        <p class="text-gray-500 max-w-md mx-auto">Testimoni dari klien kami akan muncul di sini</p>
    </div>
    @endif
</div>
@endsection