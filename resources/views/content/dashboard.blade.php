@extends('layouts.content-layout')

@section('title', 'Dashboard Content')

@section('content')
<!-- Welcome -->
<div class="mb-8">
    <h1 class="text-2xl lg:text-3xl font-heading font-bold text-gray-900">
        Selamat Datang, <span class="text-primary-900">{{ Auth::user()->name }}</span> 👋
    </h1>
    <p class="text-gray-500 mt-1">Kelola konten portofolio, blog, testimoni, dan inspirasi desain Anda</p>
</div>

<!-- Stats -->
<div class="grid md:grid-cols-3 gap-6 mb-8">
    <!-- Portofolio -->
    <div class="stat-card bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-all duration-200">
        <div class="flex items-center justify-between mb-4">
            <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center">
                <i class="fas fa-briefcase text-2xl text-blue-600"></i>
            </div>
            <span class="text-4xl font-bold text-gray-900">{{ $stats['total_portofolio'] }}</span>
        </div>
        <h3 class="text-lg font-semibold text-gray-700">Portofolio</h3>
        <p class="text-sm text-gray-500 mt-1">Total proyek yang Anda kelola</p>
        <div class="flex gap-2 mt-4">
            <a href="{{ route('content.portofolio.index') }}" class="flex-1 text-center py-2 rounded-xl bg-blue-50 text-blue-700 hover:bg-blue-100 transition text-sm font-medium">
                <i class="fas fa-list mr-1"></i> Kelola
            </a>
            <a href="{{ route('content.portofolio.create') }}" class="flex-1 text-center py-2 rounded-xl bg-primary-900 text-white hover:bg-primary-800 transition text-sm font-medium">
                <i class="fas fa-plus mr-1"></i> Tambah
            </a>
        </div>
    </div>
    
    <!-- Blog -->
    <div class="stat-card bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-all duration-200">
        <div class="flex items-center justify-between mb-4">
            <div class="w-14 h-14 bg-green-50 rounded-2xl flex items-center justify-center">
                <i class="fas fa-newspaper text-2xl text-green-600"></i>
            </div>
            <span class="text-4xl font-bold text-gray-900">{{ $stats['total_blog'] }}</span>
        </div>
        <h3 class="text-lg font-semibold text-gray-700">Blog</h3>
        <p class="text-sm text-gray-500 mt-1">Total artikel yang Anda tulis</p>
        <div class="flex gap-2 mt-4">
            <a href="{{ route('content.blog.index') }}" class="flex-1 text-center py-2 rounded-xl bg-green-50 text-green-700 hover:bg-green-100 transition text-sm font-medium">
                <i class="fas fa-list mr-1"></i> Kelola
            </a>
            <a href="{{ route('content.blog.create') }}" class="flex-1 text-center py-2 rounded-xl bg-primary-900 text-white hover:bg-primary-800 transition text-sm font-medium">
                <i class="fas fa-pen mr-1"></i> Tulis
            </a>
        </div>
    </div>

    <!-- Inspirasi Desain -->
    <div class="stat-card bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-all duration-200">
        <div class="flex items-center justify-between mb-4">
            <div class="w-14 h-14 bg-purple-50 rounded-2xl flex items-center justify-center">
                <i class="fas fa-paint-brush text-2xl text-purple-600"></i>
            </div>
            <span class="text-4xl font-bold text-gray-900">{{ $stats['total_inspirasi'] }}</span>
        </div>
        <h3 class="text-lg font-semibold text-gray-700">Inspirasi Desain</h3>
        <p class="text-sm text-gray-500 mt-1">Total inspirasi yang Anda buat</p>
        <div class="flex gap-2 mt-4">
            <a href="{{ route('content.inspirasi.index') }}" class="flex-1 text-center py-2 rounded-xl bg-purple-50 text-purple-700 hover:bg-purple-100 transition text-sm font-medium">
                <i class="fas fa-list mr-1"></i> Kelola
            </a>
            <a href="{{ route('content.inspirasi.create') }}" class="flex-1 text-center py-2 rounded-xl bg-primary-900 text-white hover:bg-primary-800 transition text-sm font-medium">
                <i class="fas fa-plus mr-1"></i> Tambah
            </a>
        </div>
    </div>
</div>

<!-- Quick Create -->
<div>
    <h3 class="font-heading font-semibold text-gray-900 mb-4 flex items-center gap-2">
        <i class="fas fa-bolt text-accent-500"></i> Buat Konten Baru
    </h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('content.portofolio.create') }}" 
           class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 text-center hover:shadow-lg transition-all duration-200 group">
            <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                <i class="fas fa-plus-circle text-2xl text-blue-600"></i>
            </div>
            <h4 class="font-semibold text-gray-800 text-sm">Portofolio</h4>
            <p class="text-xs text-gray-500 mt-1">Tambah proyek baru</p>
        </a>
        
        <a href="{{ route('content.blog.create') }}" 
           class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 text-center hover:shadow-lg transition-all duration-200 group">
            <div class="w-14 h-14 bg-green-50 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                <i class="fas fa-pen text-2xl text-green-600"></i>
            </div>
            <h4 class="font-semibold text-gray-800 text-sm">Blog</h4>
            <p class="text-xs text-gray-500 mt-1">Tulis artikel baru</p>
        </a>
        
        <a href="{{ route('content.testimoni.create') }}" 
           class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 text-center hover:shadow-lg transition-all duration-200 group">
            <div class="w-14 h-14 bg-yellow-50 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                <i class="fas fa-star text-2xl text-yellow-600"></i>
            </div>
            <h4 class="font-semibold text-gray-800 text-sm">Testimoni</h4>
            <p class="text-xs text-gray-500 mt-1">Tambah testimoni</p>
        </a>

        <a href="{{ route('content.inspirasi.create') }}" 
           class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 text-center hover:shadow-lg transition-all duration-200 group">
            <div class="w-14 h-14 bg-purple-50 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                <i class="fas fa-paint-brush text-2xl text-purple-600"></i>
            </div>
            <h4 class="font-semibold text-gray-800 text-sm">Inspirasi</h4>
            <p class="text-xs text-gray-500 mt-1">Tambah inspirasi desain</p>
        </a>
    </div>
</div>
@endsection