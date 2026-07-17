<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorit extends Model
{
    protected $table = 'favorit';
    
    protected $fillable = [
        'session_id', 'portofolio_id'
    ];

    public function portofolio()
    {
        return $this->belongsTo(PortofolioProyek::class);
    }
}