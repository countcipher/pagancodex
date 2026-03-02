<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'image_path',
        'is_published',
    ];

    /**
     * Use slug instead of ID for route model binding.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Get the user that authored the article.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
