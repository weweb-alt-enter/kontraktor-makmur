<?php

namespace Database\Seeders;

use App\Models\InspirasiDesain;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InspirasiDesainSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'judul' => 'Desain Ruang Tamu Minimalis Modern',
                'deskripsi' => 'Inspirasi desain ruang tamu dengan konsep minimalis modern yang mengutamakan fungsi dan estetika. Menggunakan warna netral dengan aksen kayu.',
                'kategori' => 'Ruang Tamu',
                'konsep' => 'Minimalis Modern',
                'warna_dominan' => 'Putih, Abu-abu, Coklat Kayu',
                'estimasi_biaya' => 2500000,
                'tags' => 'minimalis, modern, ruang tamu, interior',
                'is_published' => true,
                'published_at' => now(),
                'created_by' => 2,
            ],
            [
                'judul' => 'Kamar Tidur Utama Konsep Japandi',
                'deskripsi' => 'Perpaduan gaya Jepang dan Skandinavia menciptakan kamar tidur yang tenang dan nyaman. Furnitur rendah dengan material alami.',
                'kategori' => 'Kamar Tidur',
                'konsep' => 'Japandi',
                'warna_dominan' => 'Beige, Putih, Hitam',
                'estimasi_biaya' => 3500000,
                'tags' => 'japandi, kamar tidur, skandinavia, jepang',
                'is_published' => true,
                'published_at' => now(),
                'created_by' => 2,
            ],
            [
                'judul' => 'Dapur Terbuka Industrial Style',
                'deskripsi' => 'Desain dapur terbuka dengan sentuhan industrial. Material exposed brick, besi hitam, dan lampu gantung vintage.',
                'kategori' => 'Dapur',
                'konsep' => 'Industrial',
                'warna_dominan' => 'Hitam, Merah Bata, Abu-abu',
                'estimasi_biaya' => 5000000,
                'tags' => 'industrial, dapur, terbuka, vintage',
                'is_published' => true,
                'published_at' => now(),
                'created_by' => 3,
            ],
            [
                'judul' => 'Kamar Mandi Mewah Marmer',
                'deskripsi' => 'Inspirasi kamar mandi mewah dengan lantai dan dinding marmer. Bathtub freestanding dan pencahayaan LED tersembunyi.',
                'kategori' => 'Kamar Mandi',
                'konsep' => 'Mewah Modern',
                'warna_dominan' => 'Putih Marmer, Gold, Putih',
                'estimasi_biaya' => 8000000,
                'tags' => 'mewah, marmer, kamar mandi, modern',
                'is_published' => true,
                'published_at' => now(),
                'created_by' => 3,
            ],
            [
                'judul' => 'Ruang Kerja Rumah Scandinavian',
                'deskripsi' => 'Desain ruang kerja di rumah dengan konsep Scandinavian. Meja minimalis, kursi ergonomis, dan pencahayaan alami maksimal.',
                'kategori' => 'Ruang Kerja',
                'konsep' => 'Scandinavian',
                'warna_dominan' => 'Putih, Kayu Terang, Pastel',
                'estimasi_biaya' => 2000000,
                'tags' => 'scandinavian, ruang kerja, wfh, minimalis',
                'is_published' => true,
                'published_at' => now(),
                'created_by' => 2,
            ],
            [
                'judul' => 'Taman Belakang Tropis Modern',
                'deskripsi' => 'Inspirasi taman belakang dengan konsep tropis modern. Kolam ikan kecil, tanaman hijau, dan area duduk outdoor.',
                'kategori' => 'Taman',
                'konsep' => 'Tropis Modern',
                'warna_dominan' => 'Hijau, Coklat, Putih',
                'estimasi_biaya' => 4500000,
                'tags' => 'taman, tropis, outdoor, landscape',
                'is_published' => false,
                'published_at' => null,
                'created_by' => 2,
            ],
        ];

        foreach ($data as $item) {
            InspirasiDesain::create($item);
        }
    }
}