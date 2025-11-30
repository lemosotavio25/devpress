<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    // protected $table = 'articles';

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'content',
        'published_at',
        'cover_image_path',
    ];

    protected $casts = [
        'published_at' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
     | Relações
     |--------------------------------------------------------------------------
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function developers()
    {
        return $this->belongsToMany(User::class, 'article_user')
            ->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
     | Helpers
     |--------------------------------------------------------------------------
     */

    public function getCoverUrlAttribute(): ?string
    {
        if (! $this->cover_image_path) {
            return null;
        }

        // caso você esteja usando storage público
        return asset('storage/' . $this->cover_image_path);
    }

    public function isPublished(): bool
    {
        return ! is_null($this->published_at);
    }
}
