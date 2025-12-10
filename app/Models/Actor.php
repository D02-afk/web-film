<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Actor extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'avatar', 'birthday', 'country', 'bio'];
    protected $casts = [
        'birthday' => 'date',
    ];


    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'movie_cast', 'actor_id', 'movie_id')
                    ->withPivot('role', 'character_name');
    }
}