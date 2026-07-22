@extends('layouts.content-layout')

@section('title', 'Portofolio Saya')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-heading font-bold text-gray-900">Portofolio Saya</h1>
        <p class="text-gray-500 text-sm mt-1">Kelola portofolio proyek yang Anda buat</p>
    </div>
    <a href="{{ route('content.portofolio.create') }}"
       class="inline-flex items-center justify-center gap-2 bg-primary-900 text-white px-5 py-2.5 rounded-xl hover:bg-primary-800 transition font-medium text-sm">
        <i class="fas fa-plus"></i> Tambah Portofolio
    </a>
</div>

<div class="grid grid-cols-3 gap-4 mb-6">
    @php
        $totalSelesai = $portofolios->where('status_proyek', 'selesai')->count();
        $totalBerjalan = $portofolios->where('status_proyek', 'berjalan')->count();
        $totalFeatured = $portofolios->where('is_featured', true)->count();
    @endphp
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 text-center">
        <div class="text-2xl font-bold text-green-600">{{ $totalSelesai }}</div>
        <div class="text-xs text-gray-500">Selesai</div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 text-center">
        <div class="text-2xl font-bold text-yellow-600">{{ $totalBerjalan }}</div>
        <div class="text-xs text-gray-500">Berjalan</div>
    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 text-center">
        <div class="text-2xl font-bold text-accent-500">{{ $totalFeatured }}</div>
        <div class="text-xs text-gray-500">Unggulan</div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Proyek</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell">Kategori</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">Featured</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden xl:table-cell">Tanggal</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($portofolios as $portofolio)
                <tr class="hover:bg-gray-50/50 transition group">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if($portofolio->galleries->isNotEmpty())
                            <img src="{{ storage_url($portofolio->galleries->first()->image_path) }}"
                                 alt="{{ $portofolio->nama_proyek }}"
                                 class="w-12 h-12 rounded-xl object-cover flex-shrink-0">
                            @else
                            <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-image text-gray-400"></i>
                            </div>
                            @endif
                            <div class="min-w-0">
                                <p class="font-medium text-gray-900 text-sm truncate max-w-[200px] lg:max-w-xs">
                                    {{ $portofolio->nama_proyek }}
                                </p>
                                <p class="text-xs text-gray-500 truncate md:hidden">
                                    {{ $portofolio->jenisLayanan?->nama_layanan ?? '-' }}
                                </p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 hidden md:table-cell">
                        <div class="flex flex-wrap gap-1">
                            @if($portofolio->jenisLayanan)
                            <span class="px-2 py-0.5 bg-primary-50 text-primary-700 rounded-full text-xs font-medium">
                                {{ $portofolio->jenisLayanan->nama_layanan }}
                            </span>
                            @endif
                            @if($portofolio->jenisBangunan)
                            <span class="px-2 py-0.5 bg-gray-100 text-gray-600 rounded-full text-xs">
                                {{ $portofolio->jenisBangunan->nama_bangunan }}
                            </span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium
                                    {{ $portofolio->status_proyek == 'selesai' ? 'bg-green-100 text-green-700' :
                                       ($portofolio->status_proyek == 'berjalan' ? 'bg-yellow-100 text-yellow-700' : 'bg-blue-100 text-blue-700') }}">
                            <i class="fas fa-circle text-[6px]"></i>
                            {{ ucfirst($portofolio->status_proyek) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 hidden lg:table-cell">
                        @if($portofolio->is_featured)
                        <span class="text-accent-500"><i class="fas fa-star"></i> Yes</span>
                        @else
                        <span class="text-gray-300"><i class="far fa-star"></i> No</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500 hidden xl:table-cell">
                        {{ $portofolio->created_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-1">
                            <a href="{{ route('portofolio.detail', $portofolio->slug) }}" target="_blank"
                               class="w-8 h-8 flex items-center justify-center rounded-lg text-green-600 hover:bg-green-50 transition"
                               title="Lihat">
                                <i class="fas fa-eye text-sm"></i>
                            </a>
                            <a href="{{ route('content.portofolio.edit', $portofolio) }}"
                               class="w-8 h-8 flex items-center justify-center rounded-lg text-blue-600 hover:bg-blue-50 transition"
                               title="Edit">
                                <i class="fas fa-edit text-sm"></i>
                            </a>
                            <form action="{{ route('content.portofolio.destroy', $portofolio) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Yakin ingin menghapus {{ $portofolio->nama_proyek }}? Semua gambar juga akan dihapus.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg text-red-500 hover:bg-red-50 transition"
                                        title="Hapus">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center">
                        <div class="w-20 h-20 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-briefcase text-3xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-600 mb-1">Belum Ada Portofolio</h3>
                        <p class="text-sm text-gray-500 mb-4">Mulai tambahkan proyek portofolio pertama Anda</p>
                        <a href="{{ route('content.portofolio.create') }}"
                           class="inline-flex items-center gap-2 bg-primary-900 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-primary-800 transition">
                            <i class="fas fa-plus"></i> Tambah Portofolio
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $portofolios->links() }}
</div>
@endsection