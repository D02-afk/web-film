<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = ['movie_id', 'episode_id', 'user_id', 'reason', 'description', 'resolved'];

    protected $casts = ['resolved' => 'boolean'];

    public function movie() { return $this->belongsTo(Movie::class); }
    public function episode() { return $this->belongsTo(Episode::class); }
    public function user() { return $this->belongsTo(User::class); }
}