<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sekawan Makmur Kontraktor') - {{ config('app.name') }}</title>
    <meta name="description" content="@yield('meta_description', 'Sekawan Makmur Kontraktor - Jasa Bangun Baru, Renovasi, Desain Interior, dan Manajemen Konstruksi Terpercaya')">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js"></script>
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-50 font-sans text-text">
    <!-- Desktop Header -->
    <header class="hidden lg:block bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between py-3">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3 flex-shrink-0">
                    <img src="{{ asset('images/logo.png') }}" 
                         alt="Sekawan Makmur Kontraktor" 
                         class="h-12 w-auto"
                         onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-12 h-12 bg-primary-900 rounded-lg flex items-center justify-center\'><i class=\'fas fa-hard-hat text-accent-500 text-xl\'></i></div><div><h1 class=\'text-lg font-heading font-bold text-primary-900 leading-tight\'>Sekawan Makmur</h1><p class=\'text-xs text-text-light\'>Kontraktor Terpercaya</p></div>'">
                </a>
                
                <!-- Main Menu -->
                <nav class="flex items-center space-x-1">
                    <a href="{{ route('home') }}" 
                       class="relative px-4 py-2 text-sm font-medium transition-colors duration-200
                              {{ request()->routeIs('home') ? 'text-primary-900' : 'text-text hover:text-primary-700' }}">
                        Beranda
                        <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 h-0.5 bg-accent-500 transition-all duration-300
                                     {{ request()->routeIs('home') ? 'w-full' : 'w-0' }}"></span>
                    </a>
                    
                    <a href="{{ route('portofolio.index') }}" 
                       class="relative px-4 py-2 text-sm font-medium transition-colors duration-200
                              {{ request()->routeIs('portofolio.*') ? 'text-primary-900' : 'text-text hover:text-primary-700' }}">
                        Portofolio
                        <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 h-0.5 bg-accent-500 transition-all duration-300
                                     {{ request()->routeIs('portofolio.*') ? 'w-full' : 'w-0' }}"></span>
                    </a>
                    
                    <a href="{{ route('inspirasi.index') }}" 
                       class="relative px-4 py-2 text-sm font-medium transition-colors duration-200
                              {{ request()->routeIs('inspirasi.*') ? 'text-primary-900' : 'text-text hover:text-primary-700' }}">
                        Inspirasi
                        <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 h-0.5 bg-accent-500 transition-all duration-300
                                     {{ request()->routeIs('inspirasi.*') ? 'w-full' : 'w-0' }}"></span>
                    </a>
                    
                    <a href="{{ route('about') }}" 
                       class="relative px-4 py-2 text-sm font-medium transition-colors duration-200
                              {{ request()->routeIs('about') ? 'text-primary-900' : 'text-text hover:text-primary-700' }}">
                        Tentang Kami
                        <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 h-0.5 bg-accent-500 transition-all duration-300
                                     {{ request()->routeIs('about') ? 'w-full' : 'w-0' }}"></span>
                    </a>
                    
                    <a href="{{ route('contact') }}" 
                       class="relative px-4 py-2 text-sm font-medium transition-colors duration-200
                              {{ request()->routeIs('contact') ? 'text-primary-900' : 'text-text hover:text-primary-700' }}">
                        Kontak
                        <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 h-0.5 bg-accent-500 transition-all duration-300
                                     {{ request()->routeIs('contact') ? 'w-full' : 'w-0' }}"></span>
                    </a>
                </nav>
                
                <!-- Secondary Menu -->
                <div class="flex items-center space-x-1">
                    <a href="{{ route('testimonials') }}" 
                       class="relative p-2 text-sm transition-colors duration-200
                              {{ request()->routeIs('testimonials') ? 'text-accent-500' : 'text-text-light hover:text-primary-700' }}" 
                       title="Testimoni">
                        <i class="fas fa-star text-lg"></i>
                        @if(request()->routeIs('testimonials'))
                        <span class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 w-1 h-1 bg-accent-500 rounded-full"></span>
                        @endif
                    </a>
                    
                    <a href="{{ route('blog.index') }}" 
                       class="relative p-2 text-sm transition-colors duration-200
                              {{ request()->routeIs('blog.*') ? 'text-accent-500' : 'text-text-light hover:text-primary-700' }}" 
                       title="Blog">
                        <i class="fas fa-newspaper text-lg"></i>
                        @if(request()->routeIs('blog.*'))
                        <span class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 w-1 h-1 bg-accent-500 rounded-full"></span>
                        @endif
                    </a>
                    
                    <a href="{{ route('favorites') }}" 
                       class="relative p-2 text-sm transition-colors duration-200
                              {{ request()->routeIs('favorites') ? 'text-red-500' : 'text-text-light hover:text-red-500' }}" 
                       title="Favorit">
                        <i class="fas fa-heart text-lg"></i>
                        @if(request()->routeIs('favorites'))
                        <span class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 w-1 h-1 bg-red-500 rounded-full"></span>
                        @endif
                    </a>
                    
                    <a href="{{ route('search') }}" 
                       class="relative p-2 text-sm transition-colors duration-200 text-text-light hover:text-primary-700" 
                       title="Cari">
                        <i class="fas fa-search text-lg"></i>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Header -->
    <header class="lg:hidden bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3">
            <div class="flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <img src="{{ asset('images/logo.png') }}" 
                         alt="Sekawan Makmur" 
                         class="h-8 w-auto"
                         onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-8 h-8 bg-primary-900 rounded-lg flex items-center justify-center\'><i class=\'fas fa-hard-hat text-accent-500 text-sm\'></i></div><span class=\'text-sm font-heading font-bold text-primary-900\'>Sekawan Makmur</span>'">
                </a>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('search') }}" class="text-text hover:text-primary-900 transition">
                        <i class="fas fa-search text-lg"></i>
                    </a>
                    <button id="mobileMenuBtn" class="text-text hover:text-primary-900 transition">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu Dropdown -->
        <div id="mobileMenu" class="hidden bg-white border-t border-gray-100 shadow-lg">
            <div class="container mx-auto px-4 py-2 space-y-1">
                <a href="{{ route('home') }}" 
                   class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-colors
                          {{ request()->routeIs('home') ? 'bg-primary-50 text-primary-900 font-medium' : 'text-text-dark hover:bg-gray-50' }}">
                    <i class="fas fa-home w-5 text-center {{ request()->routeIs('home') ? 'text-primary-900' : 'text-text-light' }}"></i>
                    <span>Beranda</span>
                </a>
                
                <a href="{{ route('portofolio.index') }}" 
                   class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-colors
                          {{ request()->routeIs('portofolio.*') ? 'bg-primary-50 text-primary-900 font-medium' : 'text-text-dark hover:bg-gray-50' }}">
                    <i class="fas fa-briefcase w-5 text-center {{ request()->routeIs('portofolio.*') ? 'text-primary-900' : 'text-text-light' }}"></i>
                    <span>Portofolio</span>
                </a>
                
                <a href="{{ route('inspirasi.index') }}" 
                   class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-colors
                          {{ request()->routeIs('inspirasi.*') ? 'bg-purple-50 text-purple-700 font-medium' : 'text-text-dark hover:bg-gray-50' }}">
                    <i class="fas fa-paint-brush w-5 text-center {{ request()->routeIs('inspirasi.*') ? 'text-purple-500' : 'text-text-light' }}"></i>
                    <span>Inspirasi Desain</span>
                </a>
                
                <a href="{{ route('about') }}" 
                   class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-colors
                          {{ request()->routeIs('about') ? 'bg-primary-50 text-primary-900 font-medium' : 'text-text-dark hover:bg-gray-50' }}">
                    <i class="fas fa-info-circle w-5 text-center {{ request()->routeIs('about') ? 'text-primary-900' : 'text-text-light' }}"></i>
                    <span>Tentang Kami</span>
                </a>
                
                <a href="{{ route('contact') }}" 
                   class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-colors
                          {{ request()->routeIs('contact') ? 'bg-primary-50 text-primary-900 font-medium' : 'text-text-dark hover:bg-gray-50' }}">
                    <i class="fas fa-envelope w-5 text-center {{ request()->routeIs('contact') ? 'text-primary-900' : 'text-text-light' }}"></i>
                    <span>Kontak</span>
                </a>
                
                <div class="border-t border-gray-100 my-2"></div>
                
                <a href="{{ route('testimonials') }}" 
                   class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-colors
                          {{ request()->routeIs('testimonials') ? 'bg-primary-50 text-primary-900 font-medium' : 'text-text-dark hover:bg-gray-50' }}">
                    <i class="fas fa-star w-5 text-center {{ request()->routeIs('testimonials') ? 'text-accent-500' : 'text-text-light' }}"></i>
                    <span>Testimoni</span>
                </a>
                
                <a href="{{ route('blog.index') }}" 
                   class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-colors
                          {{ request()->routeIs('blog.*') ? 'bg-primary-50 text-primary-900 font-medium' : 'text-text-dark hover:bg-gray-50' }}">
                    <i class="fas fa-newspaper w-5 text-center {{ request()->routeIs('blog.*') ? 'text-accent-500' : 'text-text-light' }}"></i>
                    <span>Blog</span>
                </a>
                
                <a href="{{ route('favorites') }}" 
                   class="flex items-center space-x-3 px-3 py-2.5 rounded-lg transition-colors
                          {{ request()->routeIs('favorites') ? 'bg-red-50 text-red-600 font-medium' : 'text-text-dark hover:bg-gray-50' }}">
                    <i class="fas fa-heart w-5 text-center {{ request()->routeIs('favorites') ? 'text-red-500' : 'text-text-light' }}"></i>
                    <span>Favorit</span>
                </a>
                
                <div class="border-t border-gray-100 my-2"></div>
                
                @auth
                    <div class="flex items-center space-x-3 px-3 py-2.5">
                        <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-primary-900 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-text-dark">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-text-light">{{ Auth::user()->role == 'admin' ? 'Admin' : 'Content' }}</p>
                        </div>
                    </div>
                    
                    @if(Auth::user()->role == 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-text-dark hover:bg-gray-50">
                        <i class="fas fa-tachometer-alt w-5 text-center text-text-light"></i>
                        <span>Dashboard Admin</span>
                    </a>
                    @else
                    <a href="{{ route('content.dashboard') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-text-dark hover:bg-gray-50">
                        <i class="fas fa-tachometer-alt w-5 text-center text-text-light"></i>
                        <span>Dashboard Content</span>
                    </a>
                    @endif
                    
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center space-x-3 w-full px-3 py-2.5 rounded-lg text-red-600 hover:bg-red-50">
                            <i class="fas fa-sign-out-alt w-5 text-center"></i>
                            <span>Keluar</span>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-text-dark hover:bg-gray-50">
                        <i class="fas fa-lock w-5 text-center text-text-light"></i>
                        <span>Login Dashboard</span>
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Mobile Bottom Navigation -->
    <nav class="lg:hidden fixed bottom-0 left-0 right-0 bg-white shadow-2xl z-50 border-t border-gray-100 safe-area-bottom">
        <div class="flex justify-around items-center py-1.5">
            <a href="{{ route('home') }}" 
               class="flex flex-col items-center px-2 py-1.5 rounded-lg transition-colors min-w-[56px]
                      {{ request()->routeIs('home') ? 'text-primary-900' : 'text-text-light hover:text-text' }}">
                <i class="fas fa-home text-lg {{ request()->routeIs('home') ? 'scale-110' : '' }} transition-transform"></i>
                <span class="text-[10px] mt-0.5 font-medium {{ request()->routeIs('home') ? 'font-semibold' : '' }}">Beranda</span>
                @if(request()->routeIs('home'))
                <span class="block w-1 h-1 bg-primary-900 rounded-full mt-0.5"></span>
                @endif
            </a>
            
            <a href="{{ route('portofolio.index') }}" 
               class="flex flex-col items-center px-2 py-1.5 rounded-lg transition-colors min-w-[56px]
                      {{ request()->routeIs('portofolio.*') ? 'text-primary-900' : 'text-text-light hover:text-text' }}">
                <i class="fas fa-briefcase text-lg {{ request()->routeIs('portofolio.*') ? 'scale-110' : '' }} transition-transform"></i>
                <span class="text-[10px] mt-0.5 font-medium {{ request()->routeIs('portofolio.*') ? 'font-semibold' : '' }}">Portofolio</span>
                @if(request()->routeIs('portofolio.*'))
                <span class="block w-1 h-1 bg-primary-900 rounded-full mt-0.5"></span>
                @endif
            </a>
            
            <a href="{{ route('inspirasi.index') }}" 
               class="flex flex-col items-center px-2 py-1.5 rounded-lg transition-colors min-w-[56px]
                      {{ request()->routeIs('inspirasi.*') ? 'text-purple-600' : 'text-text-light hover:text-text' }}">
                <i class="fas fa-paint-brush text-lg {{ request()->routeIs('inspirasi.*') ? 'scale-110' : '' }} transition-transform"></i>
                <span class="text-[10px] mt-0.5 font-medium {{ request()->routeIs('inspirasi.*') ? 'font-semibold' : '' }}">Inspirasi</span>
                @if(request()->routeIs('inspirasi.*'))
                <span class="block w-1 h-1 bg-purple-600 rounded-full mt-0.5"></span>
                @endif
            </a>
            
            <a href="{{ route('about') }}" 
               class="flex flex-col items-center px-2 py-1.5 rounded-lg transition-colors min-w-[56px]
                      {{ request()->routeIs('about') ? 'text-primary-900' : 'text-text-light hover:text-text' }}">
                <i class="fas fa-info-circle text-lg {{ request()->routeIs('about') ? 'scale-110' : '' }} transition-transform"></i>
                <span class="text-[10px] mt-0.5 font-medium {{ request()->routeIs('about') ? 'font-semibold' : '' }}">Tentang</span>
                @if(request()->routeIs('about'))
                <span class="block w-1 h-1 bg-primary-900 rounded-full mt-0.5"></span>
                @endif
            </a>
            
            <a href="{{ route('contact') }}" 
               class="flex flex-col items-center px-2 py-1.5 rounded-lg transition-colors min-w-[56px]
                      {{ request()->routeIs('contact') ? 'text-primary-900' : 'text-text-light hover:text-text' }}">
                <i class="fas fa-envelope text-lg {{ request()->routeIs('contact') ? 'scale-110' : '' }} transition-transform"></i>
                <span class="text-[10px] mt-0.5 font-medium {{ request()->routeIs('contact') ? 'font-semibold' : '' }}">Kontak</span>
                @if(request()->routeIs('contact'))
                <span class="block w-1 h-1 bg-primary-900 rounded-full mt-0.5"></span>
                @endif
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen pb-16 lg:pb-0">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-primary-900 text-white mt-16">
        <div class="container mx-auto px-4 py-12">
            <div class="grid md:grid-cols-4 gap-8">
                <div class="md:col-span-1">
                    <div class="flex items-center space-x-3 mb-4">
                        <img src="{{ asset('images/logo-descrip.png') }}" 
                             alt="Sekawan Makmur" 
                             class="h-10 w-auto brightness-0 invert"
                             onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center\'><i class=\'fas fa-hard-hat text-accent-500 text-xl\'></i></div>'">
                        <div>
                            <h3 class="text-lg font-heading font-bold">Sekawan Makmur</h3>
                            <p class="text-xs text-text-light">Kontraktor Terpercaya</p>
                        </div>
                    </div>
                    <p class="text-text-light text-sm leading-relaxed mb-4">
                        Mitra terpercaya untuk pembangunan, renovasi, dan desain interior properti Anda.
                    </p>
                    <div class="flex space-x-3">
                        <a href="#" class="w-9 h-9 bg-white/10 rounded-lg flex items-center justify-center hover:bg-white/20 transition-colors">
                            <i class="fab fa-facebook-f text-sm"></i>
                        </a>
                        <a href="#" class="w-9 h-9 bg-white/10 rounded-lg flex items-center justify-center hover:bg-white/20 transition-colors">
                            <i class="fab fa-instagram text-sm"></i>
                        </a>
                        <a href="#" class="w-9 h-9 bg-white/10 rounded-lg flex items-center justify-center hover:bg-white/20 transition-colors">
                            <i class="fab fa-youtube text-sm"></i>
                        </a>
                        <a href="https://wa.me/{{ config('app.wa_number') }}" target="_blank" class="w-9 h-9 bg-white/10 rounded-lg flex items-center justify-center hover:bg-green-500 transition-colors">
                            <i class="fab fa-whatsapp text-sm"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h4 class="font-heading font-semibold mb-4 text-accent-500">Menu Utama</h4>
                    <ul class="space-y-2.5 text-sm text-text-light">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition-colors flex items-center gap-2 group"><i class="fas fa-chevron-right text-[10px] text-text-light/50 group-hover:text-accent-500"></i>Beranda</a></li>
                        <li><a href="{{ route('portofolio.index') }}" class="hover:text-white transition-colors flex items-center gap-2 group"><i class="fas fa-chevron-right text-[10px] text-text-light/50 group-hover:text-accent-500"></i>Portofolio</a></li>
                        <li><a href="{{ route('inspirasi.index') }}" class="hover:text-white transition-colors flex items-center gap-2 group"><i class="fas fa-chevron-right text-[10px] text-text-light/50 group-hover:text-accent-500"></i>Inspirasi Desain</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-white transition-colors flex items-center gap-2 group"><i class="fas fa-chevron-right text-[10px] text-text-light/50 group-hover:text-accent-500"></i>Tentang Kami</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-white transition-colors flex items-center gap-2 group"><i class="fas fa-chevron-right text-[10px] text-text-light/50 group-hover:text-accent-500"></i>Kontak</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-heading font-semibold mb-4 text-accent-500">Layanan Kami</h4>
                    <ul class="space-y-2.5 text-sm text-text-light">
                        @foreach(\App\Models\JenisLayanan::take(5)->get() as $layanan)
                        <li><a href="{{ route('portofolio.index', ['layanan[]' => $layanan->id]) }}" class="hover:text-white transition-colors flex items-center gap-2 group"><i class="fas fa-chevron-right text-[10px] text-text-light/50 group-hover:text-accent-500"></i>{{ $layanan->nama_layanan }}</a></li>
                        @endforeach
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-heading font-semibold mb-4 text-accent-500">Hubungi Kami</h4>
                    <ul class="space-y-3 text-sm text-text-light">
                        <li class="flex items-start gap-3"><i class="fas fa-map-marker-alt mt-1 text-accent-500"></i><span>Jl. Konstruksi No. 123, Solo, Jawa Tengah 57168</span></li>
                        <li class="flex items-center gap-3"><i class="fas fa-phone text-accent-500"></i><span>+62 {{ config('app.wa_number', '812-3456-7890') }}</span></li>
                        <li class="flex items-center gap-3"><i class="fas fa-envelope text-accent-500"></i><span>info@sekawanmakmur.com</span></li>
                        <li class="flex items-center gap-3"><i class="fas fa-clock text-accent-500"></i><span>Senin - Jumat, 08:00 - 17:00 WIB</span></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-white/10 mt-10 pt-8">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <p class="text-sm text-text-light text-center md:text-left">
                        &copy; {{ date('Y') }} <span class="text-white font-medium">Sekawan Makmur Kontraktor</span>. All rights reserved.
                    </p>
                    
                    <div class="flex items-center gap-4 text-sm text-text-light">
                        <a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a>
                        <span class="text-text-light/30">|</span>
                        <a href="{{ route('contact') }}" class="hover:text-white transition-colors">Kontak</a>
                        <span class="text-text-light/30">|</span>
                        @auth
                            <div class="relative group">
                                <button class="flex items-center gap-2 hover:text-accent-500 transition-colors">
                                    <div class="w-6 h-6 bg-accent-500 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-xs text-primary-900"></i>
                                    </div>
                                    <span class="text-white">{{ Auth::user()->name }}</span>
                                    <i class="fas fa-chevron-down text-[10px] text-text-light group-hover:text-accent-500"></i>
                                </button>
                                <div class="absolute bottom-full mb-2 right-0 bg-white rounded-xl shadow-2xl border border-gray-200 py-2 min-w-[200px] opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                    <div class="px-4 py-3 border-b border-gray-100">
                                        <p class="text-sm font-semibold text-text-dark">{{ Auth::user()->name }}</p>
                                        <p class="text-xs text-text-light">{{ Auth::user()->email }}</p>
                                        <span class="inline-block mt-1.5 px-2 py-0.5 rounded-full text-[10px] font-medium {{ Auth::user()->role == 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">{{ Auth::user()->role == 'admin' ? 'Admin' : 'Content' }}</span>
                                    </div>
                                    @if(Auth::user()->role == 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-text-dark hover:bg-gray-50"><i class="fas fa-tachometer-alt w-5 text-text-light"></i>Dashboard Admin</a>
                                    @else
                                    <a href="{{ route('content.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-text-dark hover:bg-gray-50"><i class="fas fa-tachometer-alt w-5 text-text-light"></i>Dashboard Content</a>
                                    @endif
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="flex items-center gap-3 w-full px-4 py-2.5 text-sm text-red-600 hover:bg-red-50"><i class="fas fa-sign-out-alt w-5"></i>Keluar</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="hover:text-accent-500 transition-colors flex items-center gap-1.5"><i class="fas fa-lock text-xs"></i><span>Login</span></a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>
    
    @stack('scripts')
    
    <script>
        document.getElementById('mobileMenuBtn')?.addEventListener('click', function() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        });
    </script>
</body>
</html>