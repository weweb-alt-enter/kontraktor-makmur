@extends('layouts.app')

@section('title', 'Favorit Saya')

@php
$breadcrumbs = [
    ['title' => 'Favorit', 'url' => route('favorites')]
];
@endphp

@section('content')
<!-- Hero -->
<section class="relative bg-gradient-to-br from-primary-900 via-primary-800 to-primary-900 text-white py-12 lg:py-16">
    <div class="container mx-auto px-4 text-center">
        <x-breadcrumb :breadcrumbs="$breadcrumbs" />
        
        <div class="max-w-3xl mx-auto mt-6">
            <h1 class="text-4xl lg:text-5xl font-heading font-bold mb-4">
                <i class="fas fa-heart text-red-400 mr-3"></i>
                Favorit <span class="text-accent-500">Saya</span>
            </h1>
            <p class="text-xl text-white/80">
                Proyek yang Anda simpan sebagai favorit
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
    <x-alert />
    
    @if($favorites->isNotEmpty())
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($favorites as $favorit)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 group">
            <div class="relative h-48 overflow-hidden">
                @if($favorit->portofolio->galleries->isNotEmpty())
                <img src="{{ Storage::url($favorit->portofolio->galleries->first()->image_path) }}" 
                     alt="{{ $favorit->portofolio->nama_proyek }}" 
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                @else
                <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                    <i class="fas fa-image text-4xl text-gray-300"></i>
                </div>
                @endif
                
                <form action="{{ route('favorites.remove') }}" method="POST" class="absolute top-3 right-3">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="portofolio_id" value="{{ $favorit->portofolio_id }}">
                    <button type="submit" 
                            class="w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center 
                                   hover:bg-red-600 transition shadow-lg"
                            title="Hapus dari favorit">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </form>
            </div>
            
            <div class="p-5">
                <h3 class="font-heading font-semibold text-gray-900 mb-2 line-clamp-2">
                    <a href="{{ route('portofolio.detail', $favorit->portofolio->slug) }}" 
                       class="hover:text-primary-900 transition-colors">
                        {{ $favorit->portofolio->nama_proyek }}
                    </a>
                </h3>
                <p class="text-sm text-gray-500 mb-3 flex items-center gap-1">
                    <i class="fas fa-map-marker-alt text-primary-600"></i>
                    {{ $favorit->portofolio->lokasi }}
                </p>
                <a href="{{ route('portofolio.detail', $favorit->portofolio->slug) }}" 
                   class="block w-full text-center bg-primary-50 text-primary-900 py-2.5 rounded-xl font-medium text-sm
                          hover:bg-primary-900 hover:text-white transition-all duration-200">
                    Lihat Detail
                </a>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-20">
        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-heart-broken text-4xl text-gray-400"></i>
        </div>
        <h3 class="text-2xl font-heading font-semibold text-gray-700 mb-2">Belum Ada Favorit</h3>
        <p class="text-gray-500 max-w-md mx-auto mb-6">Jelajahi portofolio kami dan simpan proyek yang Anda sukai</p>
        <a href="{{ route('portofolio.index') }}" 
           class="inline-flex items-center gap-2 bg-primary-900 text-white px-6 py-3 rounded-xl font-medium hover:bg-primary-800 transition">
            <i class="fas fa-briefcase"></i> Lihat Portofolio
        </a>
    </div>
    @endif
</div>
@endsection