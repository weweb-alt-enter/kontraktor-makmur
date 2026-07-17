<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortofolioGallery extends Model
{
    protected $table = 'portofolio_galleries';
    
    protected $fillable = [
        'portofolio_id', 'image_path', 'caption', 
        'is_before', 'before_image_id', 'sort_order'
    ];

    protected $casts = [
        'is_before' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function portofolio()
    {
        return $this->belongsTo(PortofolioProyek::class);
    }

    public function beforeImage()
    {
        return $this->belongsTo(PortofolioGallery::class, 'before_image_id');
    }

    public function afterImage()
    {
        return $this->hasOne(PortofolioGallery::class, 'before_image_id');
    }
}