@extends('layouts.app')

@section('title', 'Portofolio Proyek')
@section('meta_description', 'Jelajahi portofolio proyek berkualitas dari Sekawan Makmur Kontraktor. Bangun Baru, Renovasi, Desain Interior, dan Manajemen Konstruksi.')

@php
$breadcrumbs = [
    ['title' => 'Portofolio', 'url' => route('portofolio.index')]
];
@endphp

@push('styles')
<style>
    /* Filter sidebar styling */
    .filter-checkbox:checked + span {
        color: #1E3A8A;
        font-weight: 600;
    }
    
    .filter-checkbox:checked + span::before {
        background-color: #1E3A8A;
        border-color: #1E3A8A;
    }
    
    /* Card hover effects */
    .portofolio-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .portofolio-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px -12px rgba(30, 58, 138, 0.15);
    }
    
    .portofolio-card:hover .card-image img {
        transform: scale(1.1);
    }
    
    .card-image {
        overflow: hidden;
    }
    
    .card-image img {
        transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Status badge */
    .status-badge {
        backdrop-filter: blur(8px);
    }
    
    /* View toggle buttons */
    .view-toggle-btn {
        transition: all 0.2s ease;
    }
    
    .view-toggle-btn.active {
        background-color: #1E3A8A;
        color: white;
        box-shadow: 0 4px 12px rgba(30, 58, 138, 0.3);
    }
    
    /* Map container */
    .map-wrapper {
        border-radius: 1rem;
        overflow: hidden;
        box-shadow: 0 10px 40px -15px rgba(0, 0, 0, 0.1);
    }
    
    /* List view styling */
    .list-view .portofolio-card {
        display: flex;
        flex-direction: row;
    }
    
    .list-view .portofolio-card .card-image {
        width: 280px;
        flex-shrink: 0;
    }
    
    @media (max-width: 768px) {
        .list-view .portofolio-card {
            flex-direction: column;
        }
        
        .list-view .portofolio-card .card-image {
            width: 100%;
            height: 200px;
        }
    }
    
    /* Loading skeleton */
    .skeleton {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
    }
    
    @keyframes loading {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
    
    /* Mobile filter panel */
    .mobile-filter-panel {
        transition: transform 0.3s ease;
    }
    
    .mobile-filter-panel.open {
        transform: translateX(0);
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-primary-900 via-primary-800 to-primary-900 text-white py-12 lg:py-16">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'40\' height=\'40\' viewBox=\'0 0 40 40\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M0 0h40v40H0V0zm1 1v38h38V1H1z\'/%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>
    
    <div class="relative z-10 container mx-auto px-4">
        <x-breadcrumb :breadcrumbs="$breadcrumbs" />
        
        <div class="text-center max-w-3xl mx-auto mt-4">
            <h1 class="text-3xl lg:text-4xl font-heading font-bold mb-4">
                Portofolio <span class="text-accent-500">Proyek</span>
            </h1>
            <p class="text-lg text-white/80">
                Jelajahi proyek-proyek berkualitas yang telah kami kerjakan dengan penuh dedikasi dan profesionalisme
            </p>
            
            <!-- Quick Stats -->
            <div class="flex flex-wrap justify-center gap-6 mt-8">
                @php
                    $totalProyek = \App\Models\PortofolioProyek::where('status_proyek', 'selesai')->count();
                    $totalLayanan = \App\Models\JenisLayanan::count();
                    $tahunTerbaru = \App\Models\PortofolioProyek::max('tahun_selesai');
                @endphp
                <div class="text-center">
                    <div class="text-2xl font-bold text-accent-500">{{ $totalProyek }}+</div>
                    <div class="text-xs text-white/60">Proyek Selesai</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-accent-500">{{ $totalLayanan }}</div>
                    <div class="text-xs text-white/60">Jenis Layanan</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-accent-500">{{ $tahunTerbaru }}</div>
                    <div class="text-xs text-white/60">Proyek Terbaru</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Wave Divider -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 60" class="w-full h-auto" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 60V30C240 0 480 0 720 30C960 60 1200 60 1440 30V60H0Z" fill="#f9fafb"/>
        </svg>
    </div>
</section>

<div class="container mx-auto px-4 py-8">
    <!-- Toolbar: View Toggle, Search, Results Count -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 bg-white rounded-2xl shadow-sm p-3 border border-gray-100">
        <!-- Left: View Toggle & Results Info -->
        <div class="flex items-center gap-3">
            <div class="flex items-center bg-gray-100 rounded-xl p-1">
                <button id="gridViewBtn" onclick="setView('grid')" 
                        class="view-toggle-btn active p-2 rounded-lg transition" title="Tampilan Grid">
                    <i class="fas fa-th-large text-lg"></i>
                </button>
                <button id="listViewBtn" onclick="setView('list')" 
                        class="view-toggle-btn p-2 rounded-lg transition" title="Tampilan List">
                    <i class="fas fa-list text-lg"></i>
                </button>
            </div>
            
            <div class="hidden sm:block text-sm text-gray-500">
                Menampilkan <span class="font-semibold text-gray-700">{{ $portofolios->firstItem() ?? 0 }}-{{ $portofolios->lastItem() ?? 0 }}</span> 
                dari <span class="font-semibold text-gray-700">{{ $portofolios->total() }}</span> proyek
            </div>
        </div>
        
        <!-- Right: Search & Mobile Filter Toggle -->
        <div class="flex items-center gap-3">
            <form action="{{ route('portofolio.index') }}" method="GET" class="relative">
                <input type="text" name="lokasi" value="{{ request('lokasi') }}" 
                       placeholder="Cari lokasi..." 
                       class="w-48 lg:w-64 pl-10 pr-4 py-2.5 rounded-xl border-gray-200 bg-gray-50 
                              focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 
                              transition-all duration-200 text-sm">
                <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400"></i>
                @if(request('lokasi'))
                <a href="{{ route('portofolio.index', array_merge(request()->except('lokasi'), [])) }}" 
                   class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </a>
                @endif
            </form>
            
            <button id="mobileFilterBtn" 
                    class="lg:hidden bg-primary-50 text-primary-900 px-4 py-2.5 rounded-xl font-medium text-sm
                           hover:bg-primary-100 transition flex items-center gap-2">
                <i class="fas fa-sliders-h"></i>
                <span>Filter</span>
                @php
                    $activeFilters = count(array_filter(request()->only(['layanan', 'bangunan', 'tahun', 'budget_min', 'budget_max'])));
                @endphp
                @if($activeFilters > 0)
                <span class="bg-primary-900 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                    {{ $activeFilters }}
                </span>
                @endif
            </button>
        </div>
    </div>

    <div class="grid lg:grid-cols-4 gap-8">
        <!-- Sidebar Filter (Desktop) -->
        <aside class="hidden lg:block">
            <form id="filterForm" action="{{ route('portofolio.index') }}" method="GET">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-6 sticky top-24">
                    <div class="flex items-center justify-between">
                        <h3 class="font-heading font-bold text-lg text-gray-900">
                            <i class="fas fa-filter text-primary-900 mr-2"></i> Filter
                        </h3>
                        @if($activeFilters > 0)
                        <a href="{{ route('portofolio.index') }}" 
                           class="text-xs text-red-500 hover:text-red-700 font-medium">
                            Reset
                        </a>
                        @endif
                    </div>
                    
                    <!-- Jenis Layanan -->
                    <div class="border-t pt-4">
                        <h4 class="font-semibold text-gray-800 mb-3 flex items-center justify-between">
                            Jenis Layanan
                            <span class="text-xs text-gray-400 font-normal">{{ $jenisLayanan->count() }}</span>
                        </h4>
                        <div class="space-y-2 max-h-48 overflow-y-auto custom-scrollbar">
                            @foreach($jenisLayanan as $layanan)
                            <label class="flex items-center cursor-pointer group">
                                <input type="checkbox" name="layanan[]" value="{{ $layanan->id }}" 
                                       class="filter-checkbox w-4 h-4 rounded border-gray-300 text-primary-900 
                                              focus:ring-primary-500 cursor-pointer"
                                       {{ in_array($layanan->id, (array) request('layanan', [])) ? 'checked' : '' }}>
                                <span class="ml-3 text-sm text-gray-600 group-hover:text-gray-900 transition">
                                    {{ $layanan->nama_layanan }}
                                </span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Jenis Bangunan -->
                    <div class="border-t pt-4">
                        <h4 class="font-semibold text-gray-800 mb-3 flex items-center justify-between">
                            Jenis Bangunan
                            <span class="text-xs text-gray-400 font-normal">{{ $jenisBangunan->count() }}</span>
                        </h4>
                        <div class="space-y-2 max-h-48 overflow-y-auto custom-scrollbar">
                            @foreach($jenisBangunan as $bangunan)
                            <label class="flex items-center cursor-pointer group">
                                <input type="checkbox" name="bangunan[]" value="{{ $bangunan->id }}" 
                                       class="filter-checkbox w-4 h-4 rounded border-gray-300 text-primary-900 
                                              focus:ring-primary-500 cursor-pointer"
                                       {{ in_array($bangunan->id, (array) request('bangunan', [])) ? 'checked' : '' }}>
                                <span class="ml-3 text-sm text-gray-600 group-hover:text-gray-900 transition">
                                    {{ $bangunan->nama_bangunan }}
                                </span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Tahun -->
                    <div class="border-t pt-4">
                        <h4 class="font-semibold text-gray-800 mb-3">Tahun Selesai</h4>
                        <select name="tahun" 
                                class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 
                                       focus:border-primary-500 focus:ring-2 focus:ring-primary-100 
                                       transition-all duration-200 text-sm">
                            <option value="">Semua Tahun</option>
                            @foreach($tahunRange as $tahun)
                            <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                {{ $tahun }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Budget Range -->
                    <div class="border-t pt-4">
                        <h4 class="font-semibold text-gray-800 mb-3">Estimasi Budget</h4>
                        <div class="space-y-3">
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-gray-400">Rp</span>
                                <input type="number" name="budget_min" value="{{ request('budget_min') }}" 
                                       placeholder="Minimal"
                                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border-gray-200 bg-gray-50 
                                              focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 
                                              transition-all duration-200 text-sm">
                            </div>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs text-gray-400">Rp</span>
                                <input type="number" name="budget_max" value="{{ request('budget_max') }}" 
                                       placeholder="Maksimal"
                                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border-gray-200 bg-gray-50 
                                              focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 
                                              transition-all duration-200 text-sm">
                            </div>
                        </div>
                    </div>

                    <div class="border-t pt-4 space-y-3">
                        <button type="submit" 
                                class="w-full bg-primary-900 text-white py-3 rounded-xl font-semibold
                                       hover:bg-primary-800 transform hover:scale-[1.02] transition-all duration-200
                                       flex items-center justify-center gap-2 shadow-lg shadow-primary-900/20">
                            <i class="fas fa-search"></i>
                            Terapkan Filter
                        </button>
                        <a href="{{ route('portofolio.index') }}" 
                           class="block text-center text-sm text-gray-500 hover:text-primary-900 transition font-medium">
                            <i class="fas fa-redo mr-1"></i> Reset Semua Filter
                        </a>
                    </div>
                </div>
            </form>
        </aside>

        <!-- Mobile Filter Overlay -->
        <div id="mobileFilter" class="hidden fixed inset-0 z-50 lg:hidden">
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeMobileFilter()"></div>
            <div class="absolute right-0 top-0 h-full w-80 max-w-full bg-white shadow-2xl overflow-y-auto mobile-filter-panel">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="font-heading font-bold text-lg">Filter</h3>
                        <button onclick="closeMobileFilter()" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    
                    <form action="{{ route('portofolio.index') }}" method="GET" class="space-y-6">
                        <!-- Same filter content as desktop sidebar -->
                        <!-- Copy filter fields from desktop sidebar above -->
                        
                        <button type="submit" 
                                class="w-full bg-primary-900 text-white py-3 rounded-xl font-semibold
                                       hover:bg-primary-800 transition flex items-center justify-center gap-2">
                            <i class="fas fa-search"></i>
                            Terapkan Filter
                        </button>
                        <a href="{{ route('portofolio.index') }}" 
                           class="block text-center text-sm text-gray-500 hover:text-primary-900 transition">
                            Reset Filter
                        </a>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-3 space-y-8">
            <!-- Map Section -->
            <div class="map-wrapper bg-white">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <h3 class="font-heading font-semibold text-gray-900">
                        <i class="fas fa-map-marked-alt text-primary-900 mr-2"></i> 
                        Peta Lokasi Proyek
                    </h3>
                    <span class="text-xs text-gray-500">{{ count($mapData) }} lokasi</span>
                </div>
                <div id="map" class="w-full h-[400px]"></div>
            </div>

            <!-- Active Filters Display -->
            @if($activeFilters > 0)
            <div class="flex flex-wrap items-center gap-2 bg-primary-50 rounded-xl p-3">
                <span class="text-xs font-medium text-primary-900">
                    <i class="fas fa-check-circle mr-1"></i> Filter aktif:
                </span>
                @if(request('layanan'))
                    @foreach((array) request('layanan') as $lid)
                        @php $l = $jenisLayanan->find($lid); @endphp
                        @if($l)
                        <span class="inline-flex items-center gap-1 bg-primary-900 text-white text-xs px-2.5 py-1 rounded-full">
                            {{ $l->nama_layanan }}
                            <a href="{{ route('portofolio.index', array_merge(request()->except('layanan'), ['layanan' => array_filter((array) request('layanan'), fn($i) => $i != $lid)])) }}" 
                               class="hover:text-accent-500 ml-1">
                                <i class="fas fa-times"></i>
                            </a>
                        </span>
                        @endif
                    @endforeach
                @endif
                @if(request('tahun'))
                <span class="inline-flex items-center gap-1 bg-primary-900 text-white text-xs px-2.5 py-1 rounded-full">
                    Tahun {{ request('tahun') }}
                    <a href="{{ route('portofolio.index', array_merge(request()->except('tahun'))) }}" 
                       class="hover:text-accent-500 ml-1">
                        <i class="fas fa-times"></i>
                    </a>
                </span>
                @endif
            </div>
            @endif

            <!-- Portofolio Grid -->
            <div id="portofolioGrid" class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">
                @forelse($portofolios as $portofolio)
                <div class="portofolio-card bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group">
                    <!-- Card Image -->
                    <div class="card-image relative h-52 overflow-hidden">
                        @if($portofolio->galleries->isNotEmpty())
                        <img src="{{ Storage::url($portofolio->galleries->first()->image_path) }}" 
                             alt="{{ $portofolio->nama_proyek }}" 
                             class="w-full h-full object-cover"
                             loading="lazy">
                        @else
                        <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                            <i class="fas fa-image text-5xl text-gray-300"></i>
                        </div>
                        @endif
                        
                        <!-- Overlay on hover -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent 
                                    opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="absolute bottom-4 left-4 right-4">
                                <a href="{{ route('portofolio.detail', $portofolio->slug) }}" 
                                   class="block w-full bg-white text-primary-900 text-center py-2.5 rounded-xl font-semibold
                                          hover:bg-accent-500 hover:text-primary-900 transition-all duration-200 transform hover:scale-105">
                                    <i class="fas fa-eye mr-2"></i> Lihat Detail
                                </a>
                            </div>
                        </div>
                        
                        <!-- Status Badge -->
                        <div class="absolute top-3 right-3">
                            <span class="status-badge px-3 py-1.5 text-xs font-semibold rounded-full shadow-lg
                                @if($portofolio->status_proyek == 'selesai') 
                                    bg-green-500/90 text-white
                                @elseif($portofolio->status_proyek == 'berjalan') 
                                    bg-yellow-500/90 text-white
                                @else 
                                    bg-blue-500/90 text-white 
                                @endif">
                                <i class="fas fa-circle text-[6px] mr-1"></i>
                                {{ ucfirst($portofolio->status_proyek) }}
                            </span>
                        </div>
                        
                        <!-- Featured Badge -->
                        @if($portofolio->is_featured)
                        <div class="absolute top-3 left-3">
                            <span class="status-badge px-3 py-1.5 text-xs font-semibold rounded-full 
                                         bg-accent-500/90 text-primary-900 shadow-lg">
                                <i class="fas fa-star mr-1"></i> Unggulan
                            </span>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Card Content -->
                    <div class="p-5">
                        <!-- Categories -->
                        <div class="flex flex-wrap gap-2 mb-3">
                            @if($portofolio->jenisLayanan)
                            <span class="text-[11px] bg-primary-50 text-primary-900 px-2.5 py-1 rounded-full font-medium">
                                {{ $portofolio->jenisLayanan->nama_layanan }}
                            </span>
                            @endif
                            @if($portofolio->jenisBangunan)
                            <span class="text-[11px] bg-gray-100 text-gray-700 px-2.5 py-1 rounded-full font-medium">
                                {{ $portofolio->jenisBangunan->nama_bangunan }}
                            </span>
                            @endif
                        </div>
                        
                        <!-- Title -->
                        <h3 class="text-lg font-heading font-semibold text-gray-900 mb-2 line-clamp-2 group-hover:text-primary-900 transition-colors">
                            <a href="{{ route('portofolio.detail', $portofolio->slug) }}">
                                {{ $portofolio->nama_proyek }}
                            </a>
                        </h3>
                        
                        <!-- Info Items -->
                        <div class="space-y-1.5 text-sm text-gray-500 mb-4">
                            @if($portofolio->lokasi)
                            <div class="flex items-center gap-2">
                                <i class="fas fa-map-marker-alt w-4 text-primary-600 flex-shrink-0"></i>
                                <span class="line-clamp-1">{{ $portofolio->lokasi }}</span>
                            </div>
                            @endif
                            
                            @if($portofolio->luas_bangunan)
                            <div class="flex items-center gap-2">
                                <i class="fas fa-ruler-combined w-4 text-primary-600 flex-shrink-0"></i>
                                <span>{{ number_format($portofolio->luas_bangunan, 0, ',', '.') }} m²</span>
                            </div>
                            @endif
                            
                            @if($portofolio->estimasi_budget)
                            <div class="flex items-center gap-2">
                                <i class="fas fa-tag w-4 text-primary-600 flex-shrink-0"></i>
                                <span>Rp {{ number_format($portofolio->estimasi_budget, 0, ',', '.') }}</span>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex items-center gap-2 pt-3 border-t border-gray-100">
                            <a href="{{ route('portofolio.detail', $portofolio->slug) }}" 
                               class="flex-1 bg-primary-50 text-primary-900 text-center py-2.5 rounded-xl text-sm font-medium
                                      hover:bg-primary-900 hover:text-white transition-all duration-200">
                                Detail Proyek
                            </a>
                            <button onclick="event.preventDefault(); toggleFavoriteInList({{ $portofolio->id }}, this)" 
                                    class="w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 
                                           text-gray-400 hover:text-red-500 hover:border-red-200 hover:bg-red-50 
                                           transition-all duration-200"
                                    title="Tambah ke Favorit">
                                <i class="far fa-heart text-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <!-- Empty State -->
                <div class="col-span-full">
                    <div class="text-center py-16 bg-white rounded-2xl border border-gray-100">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-folder-open text-4xl text-gray-400"></i>
                        </div>
                        <h3 class="text-xl font-heading font-semibold text-gray-700 mb-2">
                            Tidak Ada Proyek Ditemukan
                        </h3>
                        <p class="text-gray-500 max-w-md mx-auto mb-6">
                            Coba ubah filter atau kata kunci pencarian untuk menemukan proyek yang Anda cari
                        </p>
                        <a href="{{ route('portofolio.index') }}" 
                           class="inline-flex items-center gap-2 bg-primary-900 text-white px-6 py-3 rounded-xl 
                                  hover:bg-primary-800 transition font-medium">
                            <i class="fas fa-redo"></i>
                            Reset Filter
                        </a>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($portofolios->hasPages())
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4">
                {{ $portofolios->onEachSide(2)->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Map data from server
const mapData = @json($mapData);

// Initialize map
function initPortofolioMap() {
    if (typeof L === 'undefined' || !mapData.length) return;
    
    const mapElement = document.getElementById('map');
    if (!mapElement) return;
    
    const map = L.map('map').setView([-7.5, 112.5], 7);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
        maxZoom: 18
    }).addTo(map);
    
    const markers = L.markerClusterGroup({
        chunkedLoading: true,
        maxClusterRadius: 50
    });
    
    const validMarkers = [];
    
    mapData.forEach(project => {
        if (project.lat && project.lng) {
            const marker = L.marker([project.lat, project.lng]);
            marker.bindPopup(`
                <div style="min-width: 200px; padding: 5px;">
                    <h4 style="font-weight: 600; margin-bottom: 5px; color: #1F2937;">${project.nama}</h4>
                    <p style="font-size: 12px; color: #6B7280; margin-bottom: 8px;">${project.layanan || ''}</p>
                    <a href="${project.url}" 
                       style="display: inline-block; background: #1E3A8A; color: white; padding: 6px 16px; 
                              border-radius: 8px; text-decoration: none; font-size: 12px; font-weight: 500;">
                        Lihat Detail →
                    </a>
                </div>
            `);
            markers.addLayer(marker);
            validMarkers.push([project.lat, project.lng]);
        }
    });
    
    map.addLayer(markers);
    
    if (validMarkers.length > 0) {
        map.fitBounds(validMarkers, { padding: [50, 50], maxZoom: 12 });
    }
}

// View toggle
function setView(view) {
    localStorage.setItem('portofolioView', view);
    
    const grid = document.getElementById('portofolioGrid');
    const gridBtn = document.getElementById('gridViewBtn');
    const listBtn = document.getElementById('listViewBtn');
    
    if (!grid || !gridBtn || !listBtn) return;
    
    if (view === 'grid') {
        grid.className = 'grid md:grid-cols-2 xl:grid-cols-3 gap-6';
        gridBtn.classList.add('active');
        listBtn.classList.remove('active');
    } else {
        grid.className = 'list-view space-y-4';
        listBtn.classList.add('active');
        gridBtn.classList.remove('active');
    }
}

// Favorite toggle for list
function toggleFavoriteInList(portofolioId, button) {
    fetch('{{ route("favorites.toggle") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ portofolio_id: portofolioId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const icon = button.querySelector('i');
            if (data.is_favorited) {
                icon.classList.remove('far');
                icon.classList.add('fas', 'text-red-500');
                button.classList.add('border-red-200', 'bg-red-50');
            } else {
                icon.classList.remove('fas', 'text-red-500');
                icon.classList.add('far');
                button.classList.remove('border-red-200', 'bg-red-50');
            }
        }
    });
}

// Mobile filter
function openMobileFilter() {
    document.getElementById('mobileFilter').classList.remove('hidden');
}

function closeMobileFilter() {
    document.getElementById('mobileFilter').classList.add('hidden');
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    // Restore view
    const savedView = localStorage.getItem('portofolioView') || 'grid';
    setView(savedView);
    
    // Initialize map with delay
    setTimeout(initPortofolioMap, 300);
    
    // Mobile filter toggle
    document.getElementById('mobileFilterBtn')?.addEventListener('click', openMobileFilter);
});
</script>
@endpush