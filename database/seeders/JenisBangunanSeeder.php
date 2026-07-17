<?php

namespace Database\Seeders;

use App\Models\JenisBangunan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class JenisBangunanSeeder extends Seeder
{
    public function run(): void
    {
        $bangunan = [
            ['nama_bangunan' => 'Rumah', 'icon' => 'home'],
            ['nama_bangunan' => 'Ruko', 'icon' => 'store'],
            ['nama_bangunan' => 'Kantor', 'icon' => 'building'],
            ['nama_bangunan' => 'Kost', 'icon' => 'hotel'],
            ['nama_bangunan' => 'Villa', 'icon' => 'umbrella-beach'],
            ['nama_bangunan' => 'Pabrik', 'icon' => 'industry'],
            ['nama_bangunan' => 'Lainnya', 'icon' => 'ellipsis-h'],
        ];

        foreach ($bangunan as $item) {
            JenisBangunan::create([
                'nama_bangunan' => $item['nama_bangunan'],
                'slug' => Str::slug($item['nama_bangunan']),
                'icon' => $item['icon'],
            ]);
        }
    }
}