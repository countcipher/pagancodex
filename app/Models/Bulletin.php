<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bulletin extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'link',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
