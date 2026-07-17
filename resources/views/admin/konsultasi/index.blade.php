@extends('layouts.admin-layout')

@section('title', 'Management Konsultasi')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-heading font-bold text-gray-900">Management Konsultasi</h1>
        <p class="text-gray-500 text-sm mt-1">Daftar permintaan konsultasi dari pengunjung</p>
    </div>
</div>

<!-- Filter -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6">
    <form action="{{ route('admin.konsultasi.index') }}" method="GET" class="flex flex-wrap gap-3">
        <select name="status" class="rounded-xl border-gray-200 bg-gray-50 py-2 px-4 text-sm focus:border-primary-500 focus:ring-2 focus:ring-primary-100">
            <option value="">Semua Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="dihubungi" {{ request('status') == 'dihubungi' ? 'selected' : '' }}>Dihubungi</option>
            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
        </select>
        <button type="submit" class="bg-primary-900 text-white px-4 py-2 rounded-xl text-sm font-medium hover:bg-primary-800 transition">
            <i class="fas fa-filter mr-2"></i> Filter
        </button>
    </form>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Klien</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase hidden md:table-cell">Layanan</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase hidden lg:table-cell">Tanggal</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($konsultasi as $item)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center font-semibold text-sm
                                        {{ $item->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : 
                                        ($item->status == 'dihubungi' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700') }}">
                                {{ strtoupper(substr($item->nama, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 text-sm">{{ $item->nama }}</p>
                                <p class="text-xs text-gray-500 md:hidden">{{ $item->no_wa }}</p>
                                {{-- Tampilkan sumber --}}
                                @if($item->source_type)
                                <p class="text-xs text-gray-400">
                                    <i class="fas {{ $item->source_type == 'portofolio' ? 'fa-briefcase' : 'fa-paint-brush' }} mr-1"></i>
                                    {{ $item->source_judul ?? 'Konsultasi Umum' }}
                                </p>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600 hidden md:table-cell">
                        @if($item->source_type)
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                    {{ $item->source_type == 'portofolio' ? 'bg-primary-50 text-primary-700' : 'bg-purple-50 text-purple-700' }}">
                            {{ $item->source_type == 'portofolio' ? 'Portofolio' : 'Inspirasi' }}
                        </span>
                        @else
                        <span class="text-xs text-gray-400">Umum</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500 hidden lg:table-cell">{{ $item->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-1">
                            <a href="https://wa.me/{{ $item->no_wa }}" target="_blank" 
                               class="w-8 h-8 flex items-center justify-center rounded-lg text-green-500 hover:bg-green-50 transition" title="Hubungi WA">
                                <i class="fab fa-whatsapp text-sm"></i>
                            </a>
                            <a href="{{ route('admin.konsultasi.show', $item) }}" 
                               class="w-8 h-8 flex items-center justify-center rounded-lg text-blue-600 hover:bg-blue-50 transition" title="Detail">
                                <i class="fas fa-eye text-sm"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-16 text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-comments text-2xl text-gray-400"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-600">Belum Ada Konsultasi</h3>
                        <p class="text-sm text-gray-500">Permintaan konsultasi akan muncul di sini</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-6">{{ $konsultasi->links() }}</div>
@endsection