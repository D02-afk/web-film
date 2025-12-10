<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    protected $table = 'episodes';
    protected $fillable = ['movie_id', 'season_id', 'episode_number', 'title', 'video_url', 'video_type'];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function servers()
    {
        return $this->hasMany(VideoServer::class, 'episode_id');
    }

    public function subtitles()
    {
        return $this->hasMany(Subtitle::class, 'episode_id' );
    }

    // Tạo slug tự động cho URL xem phim
    public function getSlugAttribute()
    {
        return "tap-{$this->episode_number}";
    }
}