<?php

namespace Database\Seeders;

use App\Models\Testimoni;
use Illuminate\Database\Seeder;

class TestimoniSeeder extends Seeder
{
    public function run(): void
    {
        $testimoni = [
            [
                'nama_client' => 'Budi Santoso',
                'isi_testimoni' => 'Sangat puas dengan hasil kerja Sekawan Makmur. Rumah impian saya dibangun tepat waktu dan sesuai dengan desain yang dijanjikan. Tim sangat profesional dan responsif.',
                'rating' => 5,
                'portofolio_id' => 1,
                'is_published' => true,
            ],
            [
                'nama_client' => 'Ani Wijaya',
                'isi_testimoni' => 'Renovasi ruko saya selesai lebih cepat dari estimasi. Hasil akhir sangat rapi dan berkualitas. Harga juga kompetitif dibandingkan kontraktor lain.',
                'rating' => 5,
                'portofolio_id' => 2,
                'is_published' => true,
            ],
            [
                'nama_client' => 'PT TechCorp Indonesia',
                'isi_testimoni' => 'Desain interior kantor kami menjadi lebih modern dan nyaman. Karyawan merasa lebih produktif. Terima kasih Sekawan Makmur!',
                'rating' => 4,
                'portofolio_id' => 3,
                'is_published' => true,
            ],
        ];

        foreach ($testimoni as $item) {
            Testimoni::create($item);
        }
    }
}