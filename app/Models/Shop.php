<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'country',
        'state_province',
        'city',
        'is_public',
        'contact_email',
        'phone_number',
        'website',
        'facebook_url',
        'instagram_url',
        'x_url',
        'hours_monday',
        'hours_tuesday',
        'hours_wednesday',
        'hours_thursday',
        'hours_friday',
        'hours_saturday',
        'hours_sunday',
    ];

    /**
     * Get the user that owns the shop.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
