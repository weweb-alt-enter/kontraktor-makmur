@extends('layouts.admin-layout')

@section('title', 'Management Portofolio')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-heading font-bold text-gray-900">Management Portofolio</h1>
    <p class="text-gray-500 text-sm mt-1">Semua portofolio yang ada di sistem</p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Proyek</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase hidden md:table-cell">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Featured</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Publish</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase hidden lg:table-cell">Creator</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($portofolios as $portofolio)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if($portofolio->galleries->isNotEmpty())
                            <img src="{{ Storage::url($portofolio->galleries->first()->image_path) }}"
                                 class="w-12 h-12 rounded-xl object-cover flex-shrink-0">
                            @else
                            <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-image text-gray-400"></i>
                            </div>
                            @endif
                            <div class="min-w-0">
                                <p class="font-medium text-gray-900 text-sm truncate max-w-[200px]">{{ $portofolio->nama_proyek }}</p>
                                <p class="text-xs text-gray-500">{{ $portofolio->jenisLayanan?->nama_layanan ?? '-' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 hidden md:table-cell">
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium
                                    {{ $portofolio->status_proyek == 'selesai' ? 'bg-green-100 text-green-700' :
                                       ($portofolio->status_proyek == 'berjalan' ? 'bg-yellow-100 text-yellow-700' : 'bg-blue-100 text-blue-700') }}">
                            {{ ucfirst($portofolio->status_proyek) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        {{-- Toggle Featured --}}
                        <form action="{{ route('admin.manage-konten.portofolio.toggle-featured', $portofolio) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-sm font-medium transition-colors
                                    {{ $portofolio->is_featured ? 'text-accent-500 hover:text-accent-600' : 'text-gray-400 hover:text-gray-600' }}">
                                <i class="fas fa-star"></i> {{ $portofolio->is_featured ? 'Yes' : 'No' }}
                            </button>
                        </form>
                    </td>
                    <td class="px-6 py-4">
                        {{-- Toggle Publish/Unpublish --}}
                        @if($portofolio->status_proyek == 'selesai')
                        <form action="{{ route('admin.manage-konten.portofolio.unpublish', $portofolio) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="inline-flex items-center gap-1 text-sm font-medium text-green-600 hover:text-red-600 transition-colors"
                                    title="Klik untuk unpublish (sembunyikan dari publik)">
                                <i class="fas fa-check-circle"></i> Published
                                <span class="text-[10px] text-gray-400">(klik unpublish)</span>
                            </button>
                        </form>
                        @else
                        <form action="{{ route('admin.manage-konten.portofolio.unpublish', $portofolio) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="inline-flex items-center gap-1 text-sm font-medium text-gray-400 hover:text-green-600 transition-colors"
                                    title="Klik untuk publish (tampilkan ke publik)">
                                <i class="fas fa-eye-slash"></i> Hidden
                                <span class="text-[10px] text-gray-400">(klik publish)</span>
                            </button>
                        </form>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500 hidden lg:table-cell">{{ $portofolio->creator?->name ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-1">
                            <a href="{{ route('portofolio.detail', $portofolio->slug) }}" target="_blank"
                               class="w-8 h-8 flex items-center justify-center rounded-lg text-blue-600 hover:bg-blue-50 transition" title="Lihat">
                                <i class="fas fa-external-link-alt text-sm"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center">
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