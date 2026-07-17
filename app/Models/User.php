<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function portofolio()
    {
        return $this->hasMany(PortofolioProyek::class, 'created_by');
    }

    public function blog()
    {
        return $this->hasMany(Blog::class, 'created_by');
    }
}