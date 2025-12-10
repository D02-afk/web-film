<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subtitle extends Model
{
    protected $table = 'subtitles';
    protected $fillable = ['episode_id', 'language', 'label', 'url'];

    public function episode()
    {
        return $this->belongsTo(Episode::class);
    }
}