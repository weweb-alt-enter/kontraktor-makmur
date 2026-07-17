<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimoni extends Model
{
    protected $table = 'testimoni';
    
    protected $fillable = [
        'nama_client', 'foto_client', 'isi_testimoni',
        'rating', 'portofolio_id', 'is_published'
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_published' => 'boolean',
    ];

    public function portofolio()
    {
        return $this->belongsTo(PortofolioProyek::class);
    }
}