@extends('layouts.content-layout')

@section('title', 'Testimoni')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-heading font-bold text-gray-900">Testimoni</h1>
        <p class="text-gray-500 text-sm mt-1">Kelola testimoni dari klien</p>
    </div>
    <a href="{{ route('content.testimoni.create') }}" 
       class="inline-flex items-center justify-center gap-2 bg-primary-900 text-white px-5 py-2.5 rounded-xl hover:bg-primary-800 transition font-medium text-sm">
        <i class="fas fa-plus"></i> Tambah Testimoni
    </a>
</div>

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($testimonis as $testimoni)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-lg transition-all duration-200 group">
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center gap-3">
                @if($testimoni->foto_client)
                <img src="{{ Storage::url($testimoni->foto_client) }}" class="w-12 h-12 rounded-xl object-cover">
                @else
                <div class="w-12 h-12 bg-primary-100 rounded-xl flex items-center justify-center font-bold text-primary-900">
                    {{ strtoupper(substr($testimoni->nama_client, 0, 1)) }}
                </div>
                @endif
                <div>
                    <h4 class="font-semibold text-gray-900 text-sm">{{ $testimoni->nama_client }}</h4>
                    <div class="flex text-accent-500 text-xs">
                        @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star {{ $i <= $testimoni->rating ? '' : 'text-gray-200' }}"></i>
                        @endfor
                    </div>
                </div>
            </div>
            <span class="px-2.5 py-1 rounded-full text-xs font-medium
                        {{ $testimoni->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                {{ $testimoni->is_published ? 'Live' : 'Draft' }}
            </span>
        </div>
        
        <p class="text-sm text-gray-600 line-clamp-3 mb-3">"{{ $testimoni->isi_testimoni }}"</p>
        
        @if($testimoni->portofolio)
        <p class="text-xs text-primary-600 mb-3">{{ $testimoni->portofolio->nama_proyek }}</p>
        @endif
        
        <div class="flex items-center gap-2 pt-3 border-t border-gray-100">
            <a href="{{ route('content.testimoni.edit', $testimoni) }}" 
               class="flex-1 text-center py-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition text-xs font-medium">
                <i class="fas fa-edit mr-1"></i> Edit
            </a>
            <form action="{{ route('content.testimoni.destroy', $testimoni) }}" method="POST" class="flex-1"
                  onsubmit="return confirm('Hapus testimoni ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full py-2 rounded-lg bg-red-50 text-red-500 hover:bg-red-100 transition text-xs font-medium">
                    <i class="fas fa-trash mr-1"></i> Hapus
                </button>
            </form>
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-16">
        <div class="w-20 h-20 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-star text-3xl text-gray-400"></i>
        </div>
        <h3 class="text-lg font-semibold text-gray-600 mb-1">Belum Ada Testimoni</h3>
        <p class="text-sm text-gray-500 mb-4">Tambahkan testimoni dari klien yang puas</p>
        <a href="{{ route('content.testimoni.create') }}" 
           class="inline-flex items-center gap-2 bg-primary-900 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-primary-800 transition">
            <i class="fas fa-plus"></i> Tambah Testimoni
        </a>
    </div>
    @endforelse
</div>
<div class="mt-6">{{ $testimonis->links() }}</div>
@endsection