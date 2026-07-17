<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriInspirasi extends Model
{
    protected $table = 'kategori_inspirasi';
    protected $fillable = ['nama_kategori', 'slug', 'icon'];

    public function inspirasi()
    {
        return $this->hasMany(InspirasiDesain::class, 'kategori_id');
    }
}