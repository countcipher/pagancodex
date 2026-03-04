<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'details',
        'country',
        'state_province',
        'city',
        'start_date',
        'end_date',
        'is_public',
        'is_organizer',
        'external_organizer_name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
