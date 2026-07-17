<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $blogs = [
            [
                'judul' => 'Tips Memilih Kontraktor Terpercaya untuk Rumah Impian Anda',
                'konten' => '<p>Membangun rumah impian adalah investasi besar dalam hidup Anda. Oleh karena itu, memilih kontraktor yang tepat sangatlah penting. Berikut adalah beberapa tips untuk memilih kontraktor terpercaya:</p><h3>1. Cek Legalitas dan Izin Usaha</h3><p>Pastikan kontraktor memiliki SIUJK (Surat Izin Usaha Jasa Konstruksi) dan terdaftar di asosiasi konstruksi seperti GAPENSI.</p><h3>2. Lihat Portofolio</h3><p>Mintalah portofolio proyek sebelumnya untuk melihat kualitas pekerjaan mereka.</p><h3>3. Baca Testimoni</h3><p>Cari tahu pengalaman klien sebelumnya melalui testimoni dan review.</p><h3>4. Bandingkan Harga</h3><p>Dapatkan minimal 3 penawaran untuk membandingkan harga dan spesifikasi.</p>',
                'excerpt' => 'Membangun rumah impian adalah investasi besar. Pelajari tips memilih kontraktor terpercaya untuk memastikan proyek Anda berjalan lancar.',
                'tags' => 'tips,kontraktor,rumah',
                'is_published' => true,
                'published_at' => '2024-01-15 09:00:00',
            ],
            [
                'judul' => 'Tren Desain Interior 2024: Minimalis dan Fungsional',
                'konten' => '<p>Tahun 2024 membawa tren baru dalam dunia desain interior. Konsep minimalis dan fungsional menjadi pilihan utama banyak orang. Berikut adalah tren desain interior yang patut Anda pertimbangkan:</p><h3>1. Warna Netral dengan Aksen Bold</h3><p>Kombinasikan warna netral seperti putih, abu-abu, dan beige dengan aksen bold seperti navy blue atau emerald green.</p><h3>2. Smart Home Integration</h3><p>Integrasikan teknologi smart home untuk kenyamanan dan efisiensi energi.</p><h3>3. Material Alami</h3><p>Penggunaan kayu, batu alam, dan tanaman indoor semakin populer.</p><h3>4. Multifunctional Space</h3><p>Ruang dengan fungsi ganda menjadi solusi untuk rumah berukuran terbatas.</p>',
                'excerpt' => 'Tahun 2024 membawa tren desain interior yang menarik. Temukan inspirasi untuk membuat rumah Anda lebih modern dan fungsional.',
                'tags' => 'desain-interior,tren,minimalis',
                'is_published' => true,
                'published_at' => '2024-02-20 10:00:00',
            ],
            [
                'judul' => 'Estimasi Biaya Bangun Rumah per m2 Tahun 2024',
                'konten' => '<p>Mengetahui estimasi biaya bangun rumah per m2 sangat penting dalam perencanaan anggaran. Berdasarkan pengalaman kami, berikut adalah rincian estimasi biaya untuk tahun 2024:</p><h3>Rumah Standar</h3><p>Rp 3.000.000 - Rp 4.000.000 per m2 untuk finishing standar.</p><h3>Rumah Menengah</h3><p>Rp 4.000.000 - Rp 6.000.000 per m2 dengan material berkualitas menengah.</p><h3>Rumah Mewah</h3><p>Rp 6.000.000 - Rp 10.000.000 per m2 untuk finishing premium.</p><p>Biaya tersebut sudah termasuk jasa kontraktor dan material. Namun, harga dapat bervariasi tergantung lokasi dan spesifikasi yang diinginkan.</p>',
                'excerpt' => 'Pelajari estimasi biaya bangun rumah per m2 tahun 2024. Mulai dari rumah standar hingga mewah, lengkap dengan rinciannya.',
                'tags' => 'biaya,estimasi,bangun-rumah',
                'is_published' => true,
                'published_at' => '2024-03-10 08:00:00',
            ],
        ];

        foreach ($blogs as $item) {
            Blog::create([
                'judul' => $item['judul'],
                'slug' => Str::slug($item['judul']),
                'konten' => $item['konten'],
                'excerpt' => $item['excerpt'],
                'tags' => $item['tags'],
                'is_published' => $item['is_published'],
                'published_at' => $item['published_at'],
                'created_by' => 3, // Budi Santoso
            ]);
        }
    }
}