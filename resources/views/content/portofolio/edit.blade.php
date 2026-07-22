@extends('layouts.content-layout')

@section('title', 'Edit Portofolio')

@push('styles')
<style>
    .existing-gallery-item {
        transition: all 0.2s ease;
    }
    .existing-gallery-item:hover {
        transform: scale(1.02);
    }

    .featured-toggle {
        transition: all 0.3s ease;
    }

    .featured-toggle .featured-icon {
        transition: all 0.3s ease;
    }

    .featured-toggle .featured-text {
        transition: color 0.3s ease;
    }

    .featured-toggle .featured-desc {
        transition: color 0.3s ease;
    }

    .featured-toggle.active {
        border-color: #f59e0b;
        background-color: #fffbeb;
    }

    .featured-toggle.active .featured-icon {
        background-color: #f59e0b;
        color: #111827;
    }

    .featured-toggle.active .featured-text {
        color: #d97706;
    }

    .featured-toggle.active .featured-desc {
        color: #d97706;
    }

    .featured-toggle.inactive {
        border-color: #e5e7eb;
        background-color: white;
    }

    .featured-toggle.inactive:hover {
        border-color: #d1d5db;
    }

    .featured-toggle.inactive .featured-icon {
        background-color: #f3f4f6;
        color: #9ca3af;
    }

    .featured-toggle.inactive .featured-text {
        color: #111827;
    }

    .featured-toggle.inactive .featured-desc {
        color: #6b7280;
    }

    .status-radio {
        transition: all 0.2s ease;
    }

    .status-radio.active {
        border-color: #22c55e;
        background-color: #f0fdf4;
    }

    .status-radio.active .status-icon {
        color: #22c55e;
    }

    .status-radio.berjalan {
        border-color: #eab308;
        background-color: #fefce8;
    }

    .status-radio.berjalan .status-icon {
        color: #eab308;
    }

    .status-radio.direncanakan {
        border-color: #3b82f6;
        background-color: #eff6ff;
    }

    .status-radio.direncanakan .status-icon {
        color: #3b82f6;
    }
</style>
@endpush

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('content.portofolio.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-primary-900 transition text-sm mb-4">
            <i class="fas fa-arrow-left"></i> Kembali ke daftar
        </a>
        <h1 class="text-2xl font-heading font-bold text-gray-900">Edit Portofolio</h1>
        <p class="text-gray-500 text-sm mt-1">{{ $portofolio->nama_proyek }}</p>
    </div>

    @if($portofolio->galleries->isNotEmpty())
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <h3 class="text-lg font-heading font-semibold text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-images text-primary-900"></i> Galeri Saat Ini
            <span class="text-sm font-normal text-gray-400">(Drag to reorder)</span>
        </h3>
        <div id="existingGallery" class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($portofolio->galleries as $gallery)
            <div class="existing-gallery-item relative group rounded-xl overflow-hidden bg-gray-100" data-id="{{ $gallery->id }}">
                <img src="{{ storage_url($gallery->image_path) }}" alt="{{ $gallery->caption }}"
                     class="w-full h-32 object-cover">
                @if($gallery->is_before)
                <span class="absolute top-2 left-2 bg-yellow-500 text-white text-[10px] px-2 py-0.5 rounded-full font-medium">Before</span>
                @endif
                <button type="button" onclick="deleteImage({{ $gallery->id }})"
                        class="absolute top-2 right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center
                               opacity-0 group-hover:opacity-100 transition shadow-lg hover:bg-red-600"
                        title="Hapus gambar">
                    <i class="fas fa-times text-xs"></i>
                </button>
                @if($gallery->caption)
                <p class="text-xs text-gray-600 p-2 truncate">{{ $gallery->caption }}</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <form action="{{ route('content.portofolio.update', $portofolio) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8 mb-6">
            <h3 class="text-lg font-heading font-semibold text-gray-900 mb-6">Informasi Dasar</h3>
            <div class="grid md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Proyek *</label>
                    <input type="text" name="nama_proyek" value="{{ old('nama_proyek', $portofolio->nama_proyek) }}" required
                        class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm
                                @error('nama_proyek') border-red-300 bg-red-50 focus:border-red-500 focus:ring-red-100 @enderror">
                    @error('nama_proyek')
                    <div class="flex items-center gap-2 mt-2 text-sm text-red-600 bg-red-50 px-4 py-2 rounded-lg">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ $message }}</span>
                    </div>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Layanan</label>
                    <select name="jenis_layanan_id" class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                        <option value="">Pilih Layanan</option>
                        @foreach($jenisLayanan as $layanan)
                        <option value="{{ $layanan->id }}" {{ old('jenis_layanan_id', $portofolio->jenis_layanan_id) == $layanan->id ? 'selected' : '' }}>
                            {{ $layanan->nama_layanan }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Bangunan</label>
                    <select name="jenis_bangunan_id" class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                        <option value="">Pilih Bangunan</option>
                        @foreach($jenisBangunan as $bangunan)
                        <option value="{{ $bangunan->id }}" {{ old('jenis_bangunan_id', $portofolio->jenis_bangunan_id) == $bangunan->id ? 'selected' : '' }}>
                            {{ $bangunan->nama_bangunan }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Lokasi *</label>
                    <input type="text" name="lokasi" value="{{ old('lokasi', $portofolio->lokasi) }}" required
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Klien</label>
                    <input type="text" name="klien_nama" value="{{ old('klien_nama', $portofolio->klien_nama) }}"
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8 mb-6">
            <h3 class="text-lg font-heading font-semibold text-gray-900 mb-6">Detail Proyek</h3>
            <div class="grid md:grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Budget (Rp)</label>
                    <input type="number" name="estimasi_budget" value="{{ old('estimasi_budget', $portofolio->estimasi_budget) }}"
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Luas (m²)</label>
                    <input type="number" name="luas_bangunan" value="{{ old('luas_bangunan', $portofolio->luas_bangunan) }}"
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Durasi</label>
                    <input type="text" name="durasi_pengerjaan" value="{{ old('durasi_pengerjaan', $portofolio->durasi_pengerjaan) }}"
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Selesai</label>
                    <input type="number" name="tahun_selesai" value="{{ old('tahun_selesai', $portofolio->tahun_selesai) }}"
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Latitude</label>
                    <input type="text" name="koordinat_lat" value="{{ old('koordinat_lat', $portofolio->koordinat_lat) }}"
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Longitude</label>
                    <input type="text" name="koordinat_lng" value="{{ old('koordinat_lng', $portofolio->koordinat_lng) }}"
                           class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8 mb-6">
            <h3 class="text-lg font-heading font-semibold text-gray-900 mb-6">Status & Opsi</h3>
            <div class="grid md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status *</label>
                    <div class="grid grid-cols-3 gap-2" id="statusContainer">
                        @foreach(['selesai' => ['green', 'check-circle'], 'berjalan' => ['yellow', 'spinner'], 'direncanakan' => ['blue', 'calendar']] as $status => $colors)
                        <label class="status-radio relative flex flex-col items-center gap-2 p-3 rounded-xl border-2 cursor-pointer transition-all
                                      {{ old('status_proyek', $portofolio->status_proyek) == $status ? 'active' : 'border-gray-200 hover:border-gray-300' }}
                                      {{ $status == 'berjalan' ? 'berjalan' : '' }}
                                      {{ $status == 'direncanakan' ? 'direncanakan' : '' }}
                                      {{ $status == 'selesai' ? 'selesai' : '' }}"
                               data-status="{{ $status }}">
                            <input type="radio" name="status_proyek" value="{{ $status }}"
                                   {{ old('status_proyek', $portofolio->status_proyek) == $status ? 'checked' : '' }}
                                   class="hidden status-radio-input">
                            <i class="fas fa-{{ $colors[1] }} text-xl status-icon {{ old('status_proyek', $portofolio->status_proyek) == $status ? 'text-'.$colors[0].'-600' : 'text-gray-400' }}"></i>
                            <span class="text-xs font-medium">{{ ucfirst($status) }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                <div class="flex items-center">
                    <label class="relative flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all duration-300 featured-toggle {{ $portofolio->is_featured ? 'active' : 'inactive' }}"
                           id="featuredToggle">
                        <input type="checkbox" name="is_featured" value="1" class="sr-only" id="featuredCheckbox"
                               {{ $portofolio->is_featured ? 'checked' : '' }}>
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center transition-all duration-300 featured-icon {{ $portofolio->is_featured ? 'bg-accent-500 text-primary-900' : 'bg-gray-100 text-gray-400' }}">
                            <i class="fas fa-star"></i>
                        </div>
                        <div>
                            <span class="text-sm font-semibold transition-colors duration-300 featured-text {{ $portofolio->is_featured ? 'text-accent-700' : 'text-gray-900' }}">Featured</span>
                            <p class="text-xs transition-colors duration-300 featured-desc {{ $portofolio->is_featured ? 'text-accent-600' : 'text-gray-500' }}">{{ $portofolio->is_featured ? 'Sedang tampil di halaman utama' : 'Tampilkan di halaman utama' }}</p>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8 mb-6">
            <h3 class="text-lg font-heading font-semibold text-gray-900 mb-6">Deskripsi</h3>
            <textarea name="deskripsi" rows="6" required
                      class="w-full rounded-xl border-gray-200 bg-gray-50 py-2.5 px-4 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-100 transition-all text-sm">{{ old('deskripsi', $portofolio->deskripsi) }}</textarea>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8 mb-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-heading font-semibold text-gray-900">Tambah Gambar Baru</h3>
                <button type="button" onclick="addGalleryItem()"
                        class="text-primary-900 hover:text-primary-700 text-sm font-medium flex items-center gap-1">
                    <i class="fas fa-plus-circle"></i> Tambah
                </button>
            </div>
            <div id="galleryContainer" class="space-y-4"></div>
        </div>

        <div class="flex justify-end gap-3">
            <a href="{{ route('content.portofolio.index') }}"
               class="px-6 py-3 rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50 transition font-medium text-sm">
                Batal
            </a>
            <button type="submit"
                    class="px-8 py-3 bg-primary-900 text-white rounded-xl hover:bg-primary-800 transition font-medium text-sm flex items-center gap-2 shadow-lg shadow-primary-900/20">
                <i class="fas fa-save"></i> Update Portofolio
            </button>
        </div>
    </form>

    <form action="{{ route('content.portofolio.destroy', $portofolio) }}" method="POST" class="mt-4"
          onsubmit="return confirm('Yakin ingin menghapus portofolio ini? Semua data dan gambar akan dihapus permanen.')">
        @csrf
        @method('DELETE')
        <button type="submit"
                class="px-4 py-3 rounded-xl border border-red-200 text-red-600 hover:bg-red-50 transition font-medium text-sm flex items-center gap-2">
            <i class="fas fa-trash"></i> Hapus Portofolio
        </button>
    </form>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
function addGalleryItem() {
    const container = document.getElementById('galleryContainer');
    const newItem = document.createElement('div');
    newItem.className = 'gallery-item border-2 border-dashed border-gray-200 rounded-xl p-4 hover:border-primary-300 transition relative';
    newItem.innerHTML = `
        <button type="button" onclick="this.parentElement.remove()"
                class="absolute top-3 right-3 w-7 h-7 flex items-center justify-center rounded-full bg-red-100 text-red-500 hover:bg-red-200 transition">
            <i class="fas fa-times text-xs"></i>
        </button>
        <div class="grid md:grid-cols-3 gap-3">
            <div class="md:col-span-2">
                <label class="block text-xs font-medium text-gray-600 mb-1">Pilih Gambar</label>
                <input type="file" name="images[]" accept="image/*"
                       class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-900">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Caption</label>
                <input type="text" name="image_captions[]" placeholder="Deskripsi"
                       class="w-full rounded-lg border-gray-200 bg-gray-50 py-2 px-3 text-sm focus:border-primary-500 focus:ring-1 focus:ring-primary-100">
            </div>
        </div>
        <label class="flex items-center gap-2 mt-3 cursor-pointer">
            <input type="checkbox" name="is_before[]" value="1" class="w-4 h-4 rounded border-gray-300 text-primary-900 focus:ring-primary-500">
            <span class="text-sm text-gray-600">Gambar Sebelum (Before)</span>
        </label>
    `;
    container.appendChild(newItem);
}

function deleteImage(galleryId) {
    if (!confirm('Yakin ingin menghapus gambar ini?')) return;
    fetch(`/content/gallery/${galleryId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.querySelector(`[data-id="${galleryId}"]`)?.remove();
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const existingGallery = document.getElementById('existingGallery');
    if (existingGallery) {
        new Sortable(existingGallery, {
            animation: 150,
            handle: 'img',
            onEnd: function() {
                const ids = Array.from(existingGallery.children).map(el => el.dataset.id);
                fetch('{{ route("content.gallery.reorder") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({ orders: ids })
                });
            }
        });
    }
});

// ============================================
// STATUS RADIO INTERACTIVITY
// ============================================
document.querySelectorAll('.status-radio-input').forEach(function(radio) {
    radio.addEventListener('change', function() {
        document.querySelectorAll('.status-radio').forEach(function(label) {
            label.className = 'status-radio relative flex flex-col items-center gap-2 p-3 rounded-xl border-2 cursor-pointer transition-all border-gray-200 hover:border-gray-300';
            const icon = label.querySelector('.status-icon');
            icon.className = 'fas fa-' + getIconName(label.dataset.status) + ' text-xl status-icon text-gray-400';
        });

        const label = this.closest('.status-radio');
        const status = label.dataset.status;
        const color = getColorName(status);
        label.className = 'status-radio relative flex flex-col items-center gap-2 p-3 rounded-xl border-2 cursor-pointer transition-all active border-' + color + '-500 bg-' + color + '-50';
        const icon = label.querySelector('.status-icon');
        icon.className = 'fas fa-' + getIconName(status) + ' text-xl status-icon text-' + color + '-600';
    });
});

function getIconName(status) {
    const icons = {
        'selesai': 'check-circle',
        'berjalan': 'spinner',
        'direncanakan': 'calendar'
    };
    return icons[status] || 'circle';
}

function getColorName(status) {
    const colors = {
        'selesai': 'green',
        'berjalan': 'yellow',
        'direncanakan': 'blue'
    };
    return colors[status] || 'gray';
}

// ============================================
// FEATURED TOGGLE INTERACTIVITY
// ============================================
document.getElementById('featuredCheckbox')?.addEventListener('change', function() {
    const toggle = document.getElementById('featuredToggle');
    const iconBox = toggle.querySelector('.featured-icon');
    const statusText = toggle.querySelector('.featured-text');
    const statusDesc = toggle.querySelector('.featured-desc');

    if (this.checked) {
        toggle.className = 'relative flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all duration-300 featured-toggle active border-accent-500 bg-accent-50';
        iconBox.className = 'w-10 h-10 rounded-lg flex items-center justify-center transition-all duration-300 featured-icon bg-accent-500 text-primary-900';
        statusText.className = 'text-sm font-semibold transition-colors duration-300 featured-text text-accent-700';
        statusDesc.className = 'text-xs transition-colors duration-300 featured-desc text-accent-600';
        statusDesc.textContent = 'Sedang tampil di halaman utama sebagai unggulan';
    } else {
        toggle.className = 'relative flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition-all duration-300 featured-toggle inactive border-gray-200 hover:border-gray-300 bg-white';
        iconBox.className = 'w-10 h-10 rounded-lg flex items-center justify-center transition-all duration-300 featured-icon bg-gray-100 text-gray-400';
        statusText.className = 'text-sm font-semibold transition-colors duration-300 featured-text text-gray-900';
        statusDesc.className = 'text-xs transition-colors duration-300 featured-desc text-gray-500';
        statusDesc.textContent = 'Tampilkan di halaman utama';
    }
});

// Inisialisasi status radio yang sudah dipilih
document.querySelectorAll('.status-radio-input:checked').forEach(function(radio) {
    radio.dispatchEvent(new Event('change'));
});
</script>
@endpush
@endsection