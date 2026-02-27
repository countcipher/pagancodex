<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'tradition',
        'description',
        'country',
        'state_province',
        'city',
        'has_clergy',
        'is_public',
        'contact_email',
        'phone_number',
        'website',
        'facebook_url',
        'instagram_url',
        'x_url',
    ];

    /**
     * Get the user that owns the group.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
