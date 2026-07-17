@extends('layouts.admin-layout')

@section('title', 'Dashboard Admin')

@section('content')
<!-- Welcome Section -->
<div class="mb-8">
    <h1 class="text-2xl lg:text-3xl font-heading font-bold text-gray-900">
        Selamat Datang, <span class="text-primary-900">{{ Auth::user()->name }}</span> 👋
    </h1>
    <p class="text-gray-500 mt-1">Berikut ringkasan aktivitas website Anda hari ini</p>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-8">
    <!-- Portofolio -->
    <div class="stat-card bg-white rounded-2xl shadow-sm border border-gray-100 p-5 lg:p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="stat-icon w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-briefcase text-xl text-blue-600"></i>
            </div>
            <span class="text-2xl lg:text-3xl font-bold text-gray-900">{{ $stats['total_portofolio'] }}</span>
        </div>
        <h3 class="text-sm font-medium text-gray-600">Total Portofolio</h3>
        <a href="{{ route('admin.manage-konten.portofolio') }}" class="text-xs text-primary-600 hover:text-primary-800 mt-2 inline-block">
            Kelola Portofolio →
        </a>
    </div>

    <!-- Blog -->
    <div class="stat-card bg-white rounded-2xl shadow-sm border border-gray-100 p-5 lg:p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="stat-icon w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-newspaper text-xl text-green-600"></i>
            </div>
            <span class="text-2xl lg:text-3xl font-bold text-gray-900">{{ $stats['total_blog'] }}</span>
        </div>
        <h3 class="text-sm font-medium text-gray-600">Total Blog</h3>
        <a href="{{ route('admin.manage-konten.blog') }}" class="text-xs text-primary-600 hover:text-primary-800 mt-2 inline-block">
            Kelola Blog →
        </a>
    </div>

    <!-- Testimoni -->
    <div class="stat-card bg-white rounded-2xl shadow-sm border border-gray-100 p-5 lg:p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="stat-icon w-12 h-12 bg-yellow-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-star text-xl text-yellow-600"></i>
            </div>
            <span class="text-2xl lg:text-3xl font-bold text-gray-900">{{ $stats['total_testimoni'] }}</span>
        </div>
        <h3 class="text-sm font-medium text-gray-600">Total Testimoni</h3>
        <a href="{{ route('admin.manage-konten.testimoni') }}" class="text-xs text-primary-600 hover:text-primary-800 mt-2 inline-block">
            Kelola Testimoni →
        </a>
    </div>

    <!-- Konsultasi Pending -->
    <div class="stat-card bg-white rounded-2xl shadow-sm border border-gray-100 p-5 lg:p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="stat-icon w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center">
                <i class="fas fa-comments text-xl text-red-600"></i>
            </div>
            <span class="text-2xl lg:text-3xl font-bold text-red-600">{{ $stats['total_konsultasi_pending'] }}</span>
        </div>
        <h3 class="text-sm font-medium text-gray-600">Konsultasi Pending</h3>
        <a href="{{ route('admin.konsultasi.index', ['status' => 'pending']) }}" class="text-xs text-red-600 hover:text-red-800 mt-2 inline-block">
            Lihat Konsultasi →
        </a>
    </div>
</div>

<!-- Quick Info Row -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 text-center">
        <div class="text-2xl font-bold text-purple-600">{{ $stats['total_users'] }}</div>
        <div class="text-xs text-gray-500 mt-1">Total Users</div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 text-center">
        <div class="text-2xl font-bold text-orange-600">{{ $stats['total_contacts_unread'] }}</div>
        <div class="text-xs text-gray-500 mt-1">Pesan Belum Dibaca</div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 text-center">
        <div class="text-2xl font-bold text-teal-600">{{ \App\Models\JenisLayanan::count() }}</div>
        <div class="text-xs text-gray-500 mt-1">Jenis Layanan</div>
    </div>
    <!-- Tambahkan ini -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 text-center">
        <div class="text-2xl font-bold text-fuchsia-600">{{ $stats['total_inspirasi'] }}</div>
        <div class="text-xs text-gray-500 mt-1">Inspirasi Desain</div>
    </div>
</div>

<div class="grid lg:grid-cols-2 gap-8">
    <!-- Recent Konsultasi -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="font-heading font-semibold text-gray-900 flex items-center gap-2">
                <i class="fas fa-comments text-primary-900"></i> Konsultasi Terbaru
            </h3>
            <a href="{{ route('admin.konsultasi.index') }}" class="text-xs text-primary-600 hover:text-primary-800 font-medium">Lihat Semua</a>
        </div>
        
        <div class="p-4">
            @if($recentKonsultasi->isNotEmpty())
            <div class="space-y-3">
                @foreach($recentKonsultasi as $konsultasi)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0
                                    {{ $konsultasi->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 
                                       ($konsultasi->status == 'dihubungi' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700') }}">
                            <i class="fas {{ $konsultasi->status == 'pending' ? 'fa-clock' : 
                                           ($konsultasi->status == 'dihubungi' ? 'fa-phone' : 'fa-check') }} text-sm"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="font-medium text-gray-900 text-sm truncate">{{ $konsultasi->nama }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ $konsultasi->jenisLayanan?->nama_layanan ?? 'Konsultasi' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 flex-shrink-0">
                        <span class="text-xs px-2.5 py-1 rounded-full font-medium
                                    {{ $konsultasi->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 
                                       ($konsultasi->status == 'dihubungi' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700') }}">
                            {{ ucfirst($konsultasi->status) }}
                        </span>
                        <a href="https://wa.me/{{ $konsultasi->no_wa }}" target="_blank" 
                           class="text-green-500 hover:text-green-700 transition" title="Hubungi WA">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-center text-gray-500 py-8">Belum ada konsultasi</p>
            @endif
        </div>
    </div>

    <!-- Recent Contacts -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="font-heading font-semibold text-gray-900 flex items-center gap-2">
                <i class="fas fa-envelope text-primary-900"></i> Pesan Masuk Terbaru
            </h3>
            <a href="{{ route('admin.manage-konten.contacts') }}" class="text-xs text-primary-600 hover:text-primary-800 font-medium">Lihat Semua</a>
        </div>
        
        <div class="p-4">
            @if($recentContacts->isNotEmpty())
            <div class="space-y-3">
                @foreach($recentContacts as $contact)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0
                                    {{ $contact->status == 'unread' ? 'bg-red-100 text-red-700' : 
                                       ($contact->status == 'read' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700') }}">
                            <i class="fas fa-user text-sm"></i>
                        </div>
                        <div class="min-w-0">
                            <p class="font-medium text-gray-900 text-sm truncate">{{ $contact->nama }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ Str::limit($contact->pesan, 40) }}</p>
                        </div>
                    </div>
                    <span class="text-[10px] text-gray-400 flex-shrink-0">{{ $contact->created_at->diffForHumans() }}</span>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-center text-gray-500 py-8">Belum ada pesan masuk</p>
            @endif
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="mt-8">
    <h3 class="font-heading font-semibold text-gray-900 mb-4">Quick Actions</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('admin.users.create') }}" 
           class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 text-center hover:shadow-lg transition-all duration-200 group">
            <i class="fas fa-user-plus text-2xl text-primary-600 mb-2 group-hover:scale-110 transition-transform"></i>
            <p class="text-sm font-medium text-gray-700">Tambah User</p>
        </a>
        <a href="{{ route('admin.jenis-layanan.create') }}" 
           class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 text-center hover:shadow-lg transition-all duration-200 group">
            <i class="fas fa-plus-circle text-2xl text-green-600 mb-2 group-hover:scale-110 transition-transform"></i>
            <p class="text-sm font-medium text-gray-700">Tambah Layanan</p>
        </a>
        <a href="{{ route('admin.generate-sitemap') }}" 
           class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 text-center hover:shadow-lg transition-all duration-200 group">
            <i class="fas fa-sitemap text-2xl text-orange-600 mb-2 group-hover:scale-110 transition-transform"></i>
            <p class="text-sm font-medium text-gray-700">Generate Sitemap</p>
        </a>
        <a href="{{ route('home') }}" target="_blank"
           class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 text-center hover:shadow-lg transition-all duration-200 group">
            <i class="fas fa-globe text-2xl text-teal-600 mb-2 group-hover:scale-110 transition-transform"></i>
            <p class="text-sm font-medium text-gray-700">Lihat Website</p>
        </a>
    </div>
</div>
@endsection