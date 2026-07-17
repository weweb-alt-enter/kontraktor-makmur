<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspirasiDesainGallery extends Model
{
    protected $table = 'inspirasi_desain_galleries';
    
    protected $fillable = [
        'inspirasi_id', 'image_path', 'caption', 'sort_order'
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function inspirasi()
    {
        return $this->belongsTo(InspirasiDesain::class, 'inspirasi_id');
    }
}