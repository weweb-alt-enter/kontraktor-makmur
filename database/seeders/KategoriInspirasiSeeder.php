<?php

namespace Database\Seeders;

use App\Models\KategoriInspirasi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KategoriInspirasiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama_kategori' => 'Ruang Tamu', 'icon' => 'couch'],
            ['nama_kategori' => 'Kamar Tidur', 'icon' => 'bed'],
            ['nama_kategori' => 'Dapur', 'icon' => 'utensils'],
            ['nama_kategori' => 'Kamar Mandi', 'icon' => 'bath'],
            ['nama_kategori' => 'Ruang Kerja', 'icon' => 'desktop'],
            ['nama_kategori' => 'Taman', 'icon' => 'tree'],
            ['nama_kategori' => 'Ruang Makan', 'icon' => 'utensil-spoon'],
            ['nama_kategori' => 'Eksterior', 'icon' => 'home'],
        ];

        foreach ($data as $item) {
            KategoriInspirasi::create([
                'nama_kategori' => $item['nama_kategori'],
                'slug' => Str::slug($item['nama_kategori']),
                'icon' => $item['icon'],
            ]);
        }
    }
}