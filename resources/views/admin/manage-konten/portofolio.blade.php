@extends('layouts.admin-layout')

@section('title', 'Management Portofolio')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-heading font-bold text-gray-900">Management Portofolio</h1>
    <p class="text-gray-500 text-sm mt-1">Semua portofolio proyek - kelola status featured & publish</p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Proyek</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase hidden md:table-cell">Kategori</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase hidden lg:table-cell">Featured</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($portofolios as $portofolio)
                <tr class="hover:bg-gray-50/50 transition">
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
                                <p class="font-medium text-gray-900 text-sm truncate max-w-[200px]">{{ $portofolio->nama_proyek }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ $portofolio->lokasi }}</p>
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
                        <form action="{{ route('admin.manage-konten.portofolio.toggle-featured', $portofolio) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="text-sm font-medium transition-colors
                                           {{ $portofolio->is_featured ? 'text-accent-500 hover:text-red-500' : 'text-gray-300 hover:text-accent-500' }}">
                                <i class="fas fa-star"></i>
                                {{ $portofolio->is_featured ? 'Unggulan' : 'Jadikan' }}
                            </button>
                        </form>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-1">
                            <a href="{{ route('portofolio.detail', $portofolio->slug) }}" target="_blank"
                               class="w-8 h-8 flex items-center justify-center rounded-lg text-green-600 hover:bg-green-50 transition" title="Lihat">
                                <i class="fas fa-eye text-sm"></i>
                            </a>
                            <form action="{{ route('admin.manage-konten.portofolio.unpublish', $portofolio) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="w-8 h-8 flex items-center justify-center rounded-lg transition
                                               {{ $portofolio->status_proyek == 'selesai' ? 'text-red-500 hover:bg-red-50' : 'text-green-500 hover:bg-green-50' }}"
                                        title="{{ $portofolio->status_proyek == 'selesai' ? 'Unpublish' : 'Publish' }}">
                                    <i class="fas {{ $portofolio->status_proyek == 'selesai' ? 'fa-eye-slash' : 'fa-eye' }} text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-16 text-center">
                        <i class="fas fa-briefcase text-4xl text-gray-300 mb-4 block"></i>
                        <p class="text-gray-500">Belum ada portofolio</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-6">{{ $portofolios->links() }}</div>
@endsection