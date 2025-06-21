<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = [
        'story_id',
        'judul',
        'slug',
        'isi',
        'gambar_pendukung',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($chapter) {
            $chapter->slug = Str::slug($chapter->judul);
        });

        static::updating(function ($chapter) {
            $chapter->slug = Str::slug($chapter->judul);
        });
    }

    public function story()
    {
        return $this->belongsTo(Story::class);
    }
}