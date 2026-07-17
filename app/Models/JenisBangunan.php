<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisBangunan extends Model
{
    protected $table = 'jenis_bangunan';
    protected $fillable = ['nama_bangunan', 'slug', 'icon'];

    public function portofolio()
    {
        return $this->hasMany(PortofolioProyek::class);
    }
}