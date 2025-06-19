<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function progress()
    {
        return $this->hasMany(UserProgress::class);
    }

    public function answers()
    {
        return $this->hasMany(UserAnswer::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}