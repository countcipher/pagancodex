<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'tradition',
        'bio',
        'location',
        'website',
        'facebook_url',
        'instagram_url',
        'x_url',
        'public_email',
        'phone_number',
        'avatar_path',
        'is_public',
    ];

    /**
     * Get the user that owns the profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
