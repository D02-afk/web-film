<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoServer extends Model
{
    protected $table = 'video_servers';
    protected $fillable = ['episode_id', 'server_name', 'video_url'];

    public function episode()
    {
        return $this->belongsTo(Episode::class);
    }
}