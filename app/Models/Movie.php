<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'tmdb_id',
        'media_type',
        'title',
        'poster_path',
        'release_date',
        'vote_average',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
