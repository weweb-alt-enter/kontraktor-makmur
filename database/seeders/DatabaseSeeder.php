<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            JenisLayananSeeder::class,
            JenisBangunanSeeder::class,
            UserSeeder::class,
            PortofolioProyekSeeder::class,
            BlogSeeder::class,
            TestimoniSeeder::class,
            KategoriInspirasiSeeder::class,  // Tambahkan
            KonsepInspirasiSeeder::class,    // Tambahkan
            InspirasiDesainSeeder::class,
        ]);
    }
}