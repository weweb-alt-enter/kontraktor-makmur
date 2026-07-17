<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PortofolioProyek extends Model
{
    protected $table = 'portofolio_proyek';
    
    protected $fillable = [
        'nama_proyek', 'slug', 'jenis_layanan_id', 'jenis_bangunan_id',
        'estimasi_budget', 'lokasi', 'koordinat_lat', 'koordinat_lng',
        'luas_bangunan', 'durasi_pengerjaan', 'tahun_selesai',
        'klien_nama', 'deskripsi', 'status_proyek', 'is_featured', 'created_by'
    ];

    protected $casts = [
        'estimasi_budget' => 'decimal:0',
        'koordinat_lat' => 'decimal:8',
        'koordinat_lng' => 'decimal:8',
        'is_featured' => 'boolean',
        'tahun_selesai' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($portofolio) {
            if (empty($portofolio->slug)) {
                $portofolio->slug = Str::slug($portofolio->nama_proyek);
            }
        });
    }

    public function jenisLayanan()
    {
        return $this->belongsTo(JenisLayanan::class);
    }

    public function jenisBangunan()
    {
        return $this->belongsTo(JenisBangunan::class);
    }

    public function galleries()
    {
        return $this->hasMany(PortofolioGallery::class, 'portofolio_id')->orderBy('sort_order');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function testimoni()
    {
        return $this->hasMany(Testimoni::class, 'portofolio_id');
    }

    public function favorit()
    {
        return $this->hasMany(Favorit::class, 'portofolio_id');
    }
}