<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konsultasi extends Model
{
    protected $table = 'konsultasi';
    
    protected $fillable = [
        'nama', 'email', 'no_wa', 'jenis_layanan_id', 
        'deskripsi', 'status',
        'source_type', 'source_slug', 'source_judul' // Tambahkan
    ];

    public function jenisLayanan()
    {
        return $this->belongsTo(JenisLayanan::class);
    }
}