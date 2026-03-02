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
     * Get the user that authored the article.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
