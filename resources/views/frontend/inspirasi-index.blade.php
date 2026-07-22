@extends('layouts.app')

@section('title', 'Inspirasi Desain')
@section('meta_description', 'Temukan inspirasi desain interior dan eksterior untuk rumah impian Anda. Dari minimalis hingga mewah.')

@php
$breadcrumbs = [
    ['title' => 'Inspirasi Desain', 'url' => route('inspirasi.index')]
];
@endphp

@push('styles')
<style>
    .inspirasi-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .inspirasi-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px -12px rgba(30, 58, 138, 0.15);
    }
    .inspirasi-card:hover .card-image img {
        transform: scale(1.1);
    }
    .card-image {
        overflow: hidden;
    }
    .card-image img {
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .filter-chip {
        transition: all 0.2s ease;
    }
    .filter-chip:hover {
        transform: translateY(-2px);
    }
    .filter-chip.active {
        background-color: #1E3A8A;
        color: white;
    }
</style>
@endpush

@section('content')
<section class="relative bg-gradient-to-br from-primary-900 via-primary-800 to-primary-900 text-white py-12 lg:py-16">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'40\' height=\'40\' viewBox=\'0 0 40 40\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M0 0h40v40H0V0zm1 1v38h38V1H1z\'/%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>
    <div class="container mx-auto px-4 text-center relative z-10">
        <x-breadcrumb :breadcrumbs="$breadcrumbs" />
        <div class="max-w-3xl mx-auto mt-6">
            <span class="inline-flex items-center bg-white/10 backdrop-blur-sm rounded-full px-4 py-1.5 text-sm mb-4 border border-white/20">
                <i class="fas fa-paint-brush mr-2"></i> Galeri Desain
            </span>
            <h1 class="text-4xl lg:text-5xl font-heading font-bold mb-4">
                Inspirasi <span class="text-accent-500">Desain</span>
            </h1>
            <p class="text-xl text-white/80">
                Temukan ide dan inspirasi untuk mewujudkan rumah impian Anda
            </p>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 60" class="w-full h-auto" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 60V30C240 0 480 0 720 30C960 60 1200 60 1440 30V60H0Z" fill="#f9fafb"/>
        </svg>
    </div>
</section>

<div class="container mx-auto px-4 py-8">
    @if($kategoriList->isNotEmpty() || $konsepList->isNotEmpty())
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-8">
        @if($kategoriList->isNotEmpty())
        <div class="mb-4">
            <h4 class="text-sm font-semibold text-gray-700 mb-3">
                <i class="fas fa-tag text-primary-900 mr-1.5"></i> Kategori
            </h4>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('inspirasi.index', request()->except('kategori')) }}"
                   class="filter-chip px-4 py-2 rounded-full text-sm font-medium transition
                          {{ !request('kategori') ? 'active bg-primary-900 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    Semua
                </a>
                @foreach($kategoriList as $kat)
                <a href="{{ route('inspirasi.index', array_merge(request()->except('kategori'), ['kategori' => $kat])) }}"
                   class="filter-chip px-4 py-2 rounded-full text-sm font-medium transition
                          {{ request('kategori') == $kat ? 'active bg-primary-900 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    {{ $kat }}
                </a>
                @endforeach
            </div>
        </div>
        @endif

        @if($konsepList->isNotEmpty())
        <div>
            <h4 class="text-sm font-semibold text-gray-700 mb-3">
                <i class="fas fa-palette text-primary-900 mr-1.5"></i> Konsep
            </h4>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('inspirasi.index', request()->except('konsep')) }}"
                   class="filter-chip px-4 py-2 rounded-full text-sm font-medium transition
                          {{ !request('konsep') ? 'active bg-primary-900 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    Semua
                </a>
                @foreach($konsepList as $kon)
                <a href="{{ route('inspirasi.index', array_merge(request()->except('konsep'), ['konsep' => $kon])) }}"
                   class="filter-chip px-4 py-2 rounded-full text-sm font-medium transition
                          {{ request('konsep') == $kon ? 'active bg-primary-900 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    {{ $kon }}
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
    @endif

    @if($inspirasi->isNotEmpty())
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($inspirasi as $item)
        <article class="inspirasi-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group">
            <div class="card-image relative h-56 overflow-hidden">
                @if($item->gambar)
                <img src="{{ storage_url($item->gambar) }}" alt="{{ $item->judul }}"
                     class="w-full h-full object-cover" loading="lazy">
                @else
                <div class="w-full h-full bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center">
                    <i class="fas fa-paint-brush text-5xl text-purple-300"></i>
                </div>
                @endif
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
                @if($item->kategori)
                <div class="absolute top-3 left-3">
                    <span class="bg-white/90 backdrop-blur-sm text-primary-900 text-xs px-3 py-1.5 rounded-full font-medium">
                        {{ $item->kategori }}
                    </span>
                </div>
                @endif
            </div>
            <div class="p-5">
                @if($item->konsep)
                <span class="text-[11px] bg-purple-50 text-purple-700 px-2.5 py-1 rounded-full font-medium mb-3 inline-block">
                    {{ $item->konsep }}
                </span>
                @endif
                <h3 class="text-lg font-heading font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-primary-900 transition-colors">
                    <a href="{{ route('inspirasi.show', $item->slug) }}">{{ $item->judul }}</a>
                </h3>
                @if($item->deskripsi)
                <p class="text-sm text-gray-500 line-clamp-2 mb-4">{{ $item->deskripsi }}</p>
                @endif
                <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                    @if($item->warna_dominan)
                    <span class="text-xs text-gray-500">
                        <i class="fas fa-palette mr-1 text-purple-500"></i> {{ $item->warna_dominan }}
                    </span>
                    @endif
                    @if($item->estimasi_biaya)
                    <span class="text-xs text-gray-500">
                        Rp {{ number_format($item->estimasi_biaya, 0, ',', '.') }}/m²
                    </span>
                    @endif
                </div>
            </div>
        </article>
        @endforeach
    </div>
    <div class="mt-10">{{ $inspirasi->links() }}</div>
    @else
    <div class="text-center py-20">
        <div class="w-24 h-24 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-paint-brush text-4xl text-gray-400"></i>
        </div>
        <h3 class="text-2xl font-heading font-semibold text-gray-700 mb-2">Belum Ada Inspirasi</h3>
        <p class="text-gray-500 max-w-md mx-auto">Inspirasi desain akan segera hadir. Kunjungi kembali nanti!</p>
    </div>
    @endif
</div>
@endsection