<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Story extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'slug',
        'genre',
        'cover_image',
        'deskripsi',
        'created_by',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($story) {
            $story->slug = Str::slug($story->judul);
        });

        static::updating(function ($story) {
            $story->slug = Str::slug($story->judul);
        });
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}