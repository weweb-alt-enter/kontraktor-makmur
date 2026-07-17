<?php

namespace Database\Seeders;

use App\Models\KonsepInspirasi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KonsepInspirasiSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama_konsep' => 'Minimalis Modern', 'icon' => 'cube'],
            ['nama_konsep' => 'Scandinavian', 'icon' => 'snowflake'],
            ['nama_konsep' => 'Industrial', 'icon' => 'industry'],
            ['nama_konsep' => 'Japandi', 'icon' => 'fan'],
            ['nama_konsep' => 'Mewah Modern', 'icon' => 'gem'],
            ['nama_konsep' => 'Tropis Modern', 'icon' => 'leaf'],
            ['nama_konsep' => 'Klasik', 'icon' => 'landmark'],
            ['nama_konsep' => 'Bohemian', 'icon' => 'feather'],
            ['nama_konsep' => 'Mediterranean', 'icon' => 'sun'],
            ['nama_konsep' => 'American Classic', 'icon' => 'flag-usa'],
        ];

        foreach ($data as $item) {
            KonsepInspirasi::create([
                'nama_konsep' => $item['nama_konsep'],
                'slug' => Str::slug($item['nama_konsep']),
                'icon' => $item['icon'],
            ]);
        }
    }
}