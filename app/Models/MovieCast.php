<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovieCast extends Model
{
    protected $table = 'movie_cast';
    public $timestamps = false;
    protected $fillable = ['movie_id', 'actor_id', 'role', 'character_name'];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function actor()
    {
        return $this->belongsTo(Actor::class);
    }
}