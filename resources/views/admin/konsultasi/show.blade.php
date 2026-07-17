@extends('layouts.admin-layout')

@section('title', 'Detail Konsultasi')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.konsultasi.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-primary-900 transition text-sm mb-4">
            <i class="fas fa-arrow-left"></i> Kembali ke daftar
        </a>
        <h1 class="text-2xl font-heading font-bold text-gray-900">Detail Konsultasi</h1>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fas fa-clipboard-list text-primary-900"></i> Deskripsi Konsultasi
                </h3>
                <p class="text-gray-700 leading-relaxed">{{ $konsultasi->deskripsi }}</p>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-900 mb-4">Informasi Klien</h3>
                <div class="space-y-3">
                    <div>
                        <label class="text-xs text-gray-500">Nama</label>
                        <p class="font-medium text-gray-900">{{ $konsultasi->nama }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500">Email</label>
                        <p class="text-sm text-gray-700">{{ $konsultasi->email }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500">No WhatsApp</label>
                        <p class="text-sm text-gray-700">{{ $konsultasi->no_wa }}</p>
                        <a href="https://wa.me/{{ $konsultasi->no_wa }}" target="_blank" 
                           class="inline-flex items-center gap-2 mt-2 bg-green-500 text-white px-4 py-2 rounded-xl text-sm font-medium hover:bg-green-600 transition">
                            <i class="fab fa-whatsapp"></i> Hubungi via WA
                        </a>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500">Layanan</label>
                        <p class="text-sm text-gray-700">{{ $konsultasi->jenisLayanan?->nama_layanan ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500">Status</label>
                        {{-- FORM UPDATE STATUS --}}
                        <form action="{{ route('admin.konsultasi.update-status', $konsultasi) }}" method="POST" class="mt-1">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()" 
                                    class="w-full rounded-xl border-gray-200 py-2 px-4 text-sm font-medium focus:border-primary-500 focus:ring-2 focus:ring-primary-100">
                                <option value="pending" {{ $konsultasi->status == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                <option value="dihubungi" {{ $konsultasi->status == 'dihubungi' ? 'selected' : '' }}>📞 Dihubungi</option>
                                <option value="selesai" {{ $konsultasi->status == 'selesai' ? 'selected' : '' }}>✅ Selesai</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>

            {{-- FORM DELETE DIPISAH --}}
            <form action="{{ route('admin.konsultasi.destroy', $konsultasi) }}" method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus konsultasi ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="w-full px-4 py-3 rounded-xl border border-red-200 text-red-600 hover:bg-red-50 transition font-medium text-sm flex items-center justify-center gap-2">
                    <i class="fas fa-trash"></i> Hapus Konsultasi
                </button>
            </form>
        </div>
    </div>
</div>
@endsection