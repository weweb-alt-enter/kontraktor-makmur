@props(['portofolio'])

<div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 group">
    <div class="relative overflow-hidden">
        @if($portofolio->galleries->isNotEmpty())
        <img src="{{ storage_url($portofolio->galleries->first()->image_path) }}"
             alt="{{ $portofolio->nama_proyek }}"
             class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
        @else
        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
            <i class="fas fa-image text-4xl text-gray-400"></i>
        </div>
        @endif

        <div class="absolute top-2 right-2">
            <span class="px-3 py-1 text-xs font-semibold rounded-full
                @if($portofolio->status_proyek == 'selesai') bg-green-500 text-white
                @elseif($portofolio->status_proyek == 'berjalan') bg-yellow-500 text-white
                @else bg-blue-500 text-white @endif">
                {{ ucfirst($portofolio->status_proyek) }}
            </span>
        </div>

        @if($portofolio->is_featured)
        <div class="absolute top-2 left-2">
            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-accent-500 text-primary-900">
                <i class="fas fa-star mr-1"></i> Unggulan
            </span>
        </div>
        @endif
    </div>

    <div class="p-4">
        <div class="flex items-center space-x-2 mb-2">
            @if($portofolio->jenisLayanan)
            <span class="text-xs bg-primary-100 text-primary-900 px-2 py-1 rounded">
                {{ $portofolio->jenisLayanan->nama_layanan }}
            </span>
            @endif
            @if($portofolio->jenisBangunan)
            <span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded">
                {{ $portofolio->jenisBangunan->nama_bangunan }}
            </span>
            @endif
        </div>

        <h3 class="text-lg font-heading font-semibold text-gray-800 mb-2 line-clamp-2">
            {{ $portofolio->nama_proyek }}
        </h3>

        <div class="space-y-1 text-sm text-gray-600 mb-3">
            @if($portofolio->lokasi)
            <div class="flex items-center">
                <i class="fas fa-map-marker-alt w-5 text-primary-900"></i>
                <span class="line-clamp-1">{{ $portofolio->lokasi }}</span>
            </div>
            @endif
            @if($portofolio->luas_bangunan)
            <div class="flex items-center">
                <i class="fas fa-ruler-combined w-5 text-primary-900"></i>
                <span>{{ number_format($portofolio->luas_bangunan) }} m²</span>
            </div>
            @endif
            @if($portofolio->estimasi_budget)
            <div class="flex items-center">
                <i class="fas fa-money-bill-wave w-5 text-primary-900"></i>
                <span>Rp {{ number_format($portofolio->estimasi_budget, 0, ',', '.') }}</span>
            </div>
            @endif
        </div>

        <a href="{{ route('portofolio.detail', $portofolio->slug) }}"
           class="block w-full text-center bg-primary-900 text-white py-2 rounded-lg hover:bg-primary-800 transition font-medium">
            Lihat Detail
        </a>
    </div>
</div>