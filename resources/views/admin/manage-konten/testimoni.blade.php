@extends('layouts.admin-layout')

@section('title', 'Management Testimoni')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-heading font-bold text-gray-900">Management Testimoni</h1>
    <p class="text-gray-500 text-sm mt-1">Semua testimoni yang ada di sistem - kelola status publish</p>
</div>

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($testimonis as $testimoni)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-lg transition-all duration-200 {{ !$testimoni->is_published ? 'opacity-70' : '' }}">
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center gap-3">
                @if($testimoni->foto_client)
                <img src="{{ Storage::url($testimoni->foto_client) }}" class="w-12 h-12 rounded-full object-cover">
                @else
                <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center font-semibold text-primary-900">
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
        </div>
        
        <p class="text-sm text-gray-600 line-clamp-3 mb-4">"{{ $testimoni->isi_testimoni }}"</p>
        
        @if($testimoni->portofolio)
        <a href="{{ route('portofolio.detail', $testimoni->portofolio->slug) }}" target="_blank"
           class="text-xs text-primary-600 hover:underline block mb-4">
            <i class="fas fa-link mr-1"></i> {{ $testimoni->portofolio->nama_proyek }}
        </a>
        @endif
        
        {{-- Status & Toggle --}}
        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
            <span class="px-2.5 py-1 rounded-full text-xs font-medium
                        {{ $testimoni->is_published ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                {{ $testimoni->is_published ? '✓ Published' : 'Hidden' }}
            </span>
            
            <form action="{{ route('admin.manage-konten.testimoni.toggle', $testimoni) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" 
                        class="text-xs font-medium transition-colors
                               {{ $testimoni->is_published ? 'text-red-500 hover:text-red-700' : 'text-green-600 hover:text-green-700' }}"
                        title="{{ $testimoni->is_published ? 'Unpublish testimoni' : 'Publish testimoni' }}">
                    <i class="fas {{ $testimoni->is_published ? 'fa-eye-slash' : 'fa-eye' }} mr-1"></i>
                    {{ $testimoni->is_published ? 'Unpublish' : 'Publish' }}
                </button>
            </form>
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-16">
        <i class="fas fa-star text-4xl text-gray-300 mb-4 block"></i>
        <p class="text-gray-500">Belum ada testimoni</p>
    </div>
    @endforelse
</div>
<div class="mt-6">{{ $testimonis->links() }}</div>
@endsection