<?php

namespace Database\Seeders;

use App\Models\PortofolioProyek;
use App\Models\JenisLayanan;
use App\Models\JenisBangunan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PortofolioProyekSeeder extends Seeder
{
    public function run(): void
    {
        $proyek = [
            [
                'nama_proyek' => 'Rumah Minimalis Modern Pak Budi',
                'jenis_layanan' => 'bangun-baru',
                'jenis_bangunan' => 'rumah',
                'estimasi_budget' => 850000000,
                'lokasi' => 'Jl. Mawar No. 123, Surabaya',
                'koordinat_lat' => -7.2575,
                'koordinat_lng' => 112.7521,
                'luas_bangunan' => 120,
                'durasi_pengerjaan' => '6 bulan',
                'tahun_selesai' => 2024,
                'klien_nama' => 'Budi Santoso',
                'deskripsi' => 'Proyek pembangunan rumah minimalis modern dengan 3 kamar tidur, 2 kamar mandi, dan carport untuk 2 mobil. Menggunakan material berkualitas tinggi dengan finishing modern.',
                'status_proyek' => 'selesai',
                'is_featured' => true,
            ],
            [
                'nama_proyek' => 'Renovasi Ruko 3 Lantai Ibu Ani',
                'jenis_layanan' => 'renovasi',
                'jenis_bangunan' => 'ruko',
                'estimasi_budget' => 450000000,
                'lokasi' => 'Jl. Diponegoro No. 45, Malang',
                'koordinat_lat' => -7.9839,
                'koordinat_lng' => 112.6214,
                'luas_bangunan' => 200,
                'durasi_pengerjaan' => '4 bulan',
                'tahun_selesai' => 2024,
                'klien_nama' => 'Ani Wijaya',
                'deskripsi' => 'Renovasi total ruko 3 lantai menjadi pusat perbelanjaan modern. Pekerjaan meliputi perbaikan struktur, pengecatan, pemasangan lantai granit, dan upgrade sistem kelistrikan.',
                'status_proyek' => 'selesai',
                'is_featured' => true,
            ],
            [
                'nama_proyek' => 'Desain Interior Kantor Startup',
                'jenis_layanan' => 'desain-interior',
                'jenis_bangunan' => 'kantor',
                'estimasi_budget' => 350000000,
                'lokasi' => 'Jl. Sudirman No. 100, Jakarta Selatan',
                'koordinat_lat' => -6.2088,
                'koordinat_lng' => 106.8456,
                'luas_bangunan' => 150,
                'durasi_pengerjaan' => '3 bulan',
                'tahun_selesai' => 2024,
                'klien_nama' => 'TechCorp Indonesia',
                'deskripsi' => 'Desain interior kantor startup modern dengan konsep open space, dilengkapi ruang meeting, pantry, dan area co-working yang nyaman.',
                'status_proyek' => 'selesai',
                'is_featured' => true,
            ],
            [
                'nama_proyek' => 'Pembangunan Villa Resort di Batu',
                'jenis_layanan' => 'bangun-baru',
                'jenis_bangunan' => 'villa',
                'estimasi_budget' => 2500000000,
                'lokasi' => 'Jl. Raya Selecta, Batu, Jawa Timur',
                'koordinat_lat' => -7.8831,
                'koordinat_lng' => 112.5334,
                'luas_bangunan' => 300,
                'durasi_pengerjaan' => '8 bulan',
                'tahun_selesai' => 2025,
                'klien_nama' => 'PT Wisata Indah',
                'deskripsi' => 'Pembangunan villa resort mewah dengan 5 kamar, kolam renang, dan pemandangan pegunungan. Menggunakan arsitektur modern tropis.',
                'status_proyek' => 'berjalan',
                'is_featured' => false,
            ],
            [
                'nama_proyek' => 'Manajemen Konstruksi Apartemen Green Park',
                'jenis_layanan' => 'manajemen-konstruksi',
                'jenis_bangunan' => 'lainnya',
                'estimasi_budget' => 50000000000,
                'lokasi' => 'Jl. Ahmad Yani No. 200, Surabaya',
                'koordinat_lat' => -7.2756,
                'koordinat_lng' => 112.7345,
                'luas_bangunan' => 5000,
                'durasi_pengerjaan' => '24 bulan',
                'tahun_selesai' => 2026,
                'klien_nama' => 'PT Properti Sejahtera',
                'deskripsi' => 'Manajemen konstruksi pembangunan apartemen 20 lantai dengan 200 unit. Meliputi pengawasan, scheduling, dan quality control.',
                'status_proyek' => 'berjalan',
                'is_featured' => false,
            ],
            [
                'nama_proyek' => 'Konsultasi Pembangunan Pabrik Tekstil',
                'jenis_layanan' => 'konsultasi-bangunan',
                'jenis_bangunan' => 'pabrik',
                'estimasi_budget' => 15000000000,
                'lokasi' => 'Kawasan Industri Sidoarjo',
                'koordinat_lat' => -7.4498,
                'koordinat_lng' => 112.7183,
                'luas_bangunan' => 2000,
                'durasi_pengerjaan' => '12 bulan',
                'tahun_selesai' => 2025,
                'klien_nama' => 'PT Tekstil Nusantara',
                'deskripsi' => 'Konsultasi perencanaan dan pengawasan pembangunan pabrik tekstil modern dengan standar internasional.',
                'status_proyek' => 'berjalan',
                'is_featured' => false,
            ],
        ];

        foreach ($proyek as $item) {
            $layanan = JenisLayanan::where('slug', $item['jenis_layanan'])->first();
            $bangunan = JenisBangunan::where('slug', $item['jenis_bangunan'])->first();

            PortofolioProyek::create([
                'nama_proyek' => $item['nama_proyek'],
                'slug' => Str::slug($item['nama_proyek']),
                'jenis_layanan_id' => $layanan ? $layanan->id : null,
                'jenis_bangunan_id' => $bangunan ? $bangunan->id : null,
                'estimasi_budget' => $item['estimasi_budget'],
                'lokasi' => $item['lokasi'],
                'koordinat_lat' => $item['koordinat_lat'],
                'koordinat_lng' => $item['koordinat_lng'],
                'luas_bangunan' => $item['luas_bangunan'],
                'durasi_pengerjaan' => $item['durasi_pengerjaan'],
                'tahun_selesai' => $item['tahun_selesai'],
                'klien_nama' => $item['klien_nama'],
                'deskripsi' => $item['deskripsi'],
                'status_proyek' => $item['status_proyek'],
                'is_featured' => $item['is_featured'],
                'created_by' => 2, // Andi Pratama
            ]);
        }
    }
}