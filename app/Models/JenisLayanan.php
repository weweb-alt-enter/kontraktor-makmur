<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisLayanan extends Model
{
    protected $table = 'jenis_layanan';
    protected $fillable = ['nama_layanan', 'slug', 'icon'];

    public function portofolio()
    {
        return $this->hasMany(PortofolioProyek::class);
    }
}