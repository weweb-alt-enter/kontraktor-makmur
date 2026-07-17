<?php

namespace Database\Seeders;

use App\Models\JenisLayanan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class JenisLayananSeeder extends Seeder
{
    public function run(): void
    {
        $layanan = [
            ['nama_layanan' => 'Bangun Baru', 'icon' => 'home'],
            ['nama_layanan' => 'Renovasi', 'icon' => 'wrench'],
            ['nama_layanan' => 'Desain Interior', 'icon' => 'paint-brush'],
            ['nama_layanan' => 'Manajemen Konstruksi', 'icon' => 'clipboard-list'],
            ['nama_layanan' => 'Konsultasi Bangunan', 'icon' => 'comments'],
        ];

        foreach ($layanan as $item) {
            JenisLayanan::create([
                'nama_layanan' => $item['nama_layanan'],
                'slug' => Str::slug($item['nama_layanan']),
                'icon' => $item['icon'],
            ]);
        }
    }
}