<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'password',
        'nama_lengkap',

    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function stories()
    {
        return $this->hasMany(Story::class, 'created_by');
    }

}