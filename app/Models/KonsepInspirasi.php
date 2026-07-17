<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KonsepInspirasi extends Model
{
    protected $table = 'konsep_inspirasi';
    protected $fillable = ['nama_konsep', 'slug', 'icon'];

    public function inspirasi()
    {
        return $this->hasMany(InspirasiDesain::class, 'konsep_id');
    }
}