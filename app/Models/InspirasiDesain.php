<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class InspirasiDesain extends Model
{
    protected $table = 'inspirasi_desain';
    
    protected $fillable = [
        'judul', 'slug', 'deskripsi', 'gambar', 
        'kategori_id', 'konsep_id', // Ganti dari string menjadi foreign key
        'warna_dominan', 'estimasi_biaya', 'tags',
        'is_published', 'published_at', 'created_by'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'estimasi_biaya' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $baseSlug = Str::slug($model->judul);
                $slug = $baseSlug;
                $counter = 1;
                
                while (static::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $counter;
                    $counter++;
                }
                
                $model->slug = $slug;
            }
        });
        
        static::updating(function ($model) {
            if ($model->isDirty('judul') && !$model->isDirty('slug')) {
                $baseSlug = Str::slug($model->judul);
                $slug = $baseSlug;
                $counter = 1;
                
                while (static::where('slug', $slug)->where('id', '!=', $model->id)->exists()) {
                    $slug = $baseSlug . '-' . $counter;
                    $counter++;
                }
                
                $model->slug = $slug;
            }
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function galleries()
    {
        return $this->hasMany(InspirasiDesainGallery::class, 'inspirasi_id')->orderBy('sort_order');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    // Relasi
    public function kategori()
    {
        return $this->belongsTo(KategoriInspirasi::class, 'kategori_id');
    }

    public function konsep()
    {
        return $this->belongsTo(KonsepInspirasi::class, 'konsep_id');
    }
}