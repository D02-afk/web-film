<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $table = 'ratings';
    protected $fillable = ['movie_id', 'user_id', 'score', 'review', 'ip_address'];

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('unique', function ($builder) {
            $builder->whereRaw('id IN (SELECT MAX(id) FROM ratings GROUP BY movie_id, user_id)');
        });
    }

    public function movie() { return $this->belongsTo(Movie::class); }
    public function user() { return $this->belongsTo(User::class); }
}