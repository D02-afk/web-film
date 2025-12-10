<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;
use Illuminate\Support\Facades\Cache;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'origin_name', 'description', 'poster', 'thumbnail',
        'year', 'country_id', 'type', 'status', 'imdb_score', 'views',
        'quality', 'language', 'is_vip', 'is_featured', 'is_upcoming',
        'trailer_url', 'duration', 'meta_title', 'meta_description', 'tags', 'id'
    ];

    protected $casts = [
        'tags' => 'array',
        'is_vip' => 'boolean',
        'is_featured' => 'boolean',
        'is_upcoming' => 'boolean',
    ];

    // Quan hệ
    public function country(): Relations\BelongsTo { return $this->belongsTo(Country::class); }
    public function genres(): Relations\BelongsToMany { return $this->belongsToMany(Genre::class, 'movie_genre'); }
    public function actors()
    {
        return $this->belongsToMany(Actor::class, 'movie_cast', 'movie_id', 'actor_id')
                    ->withPivot('role', 'character_name');
    }
    public function directors()
    {
        return $this->belongsToMany(Actor::class, 'movie_cast', 'movie_id', 'actor_id')
                    ->wherePivot('role', 'director')
                    ->withPivot('character_name');
    }
    public function cast()
    {
        return $this->hasMany(MovieCast::class)->with('actor');
    }
    public function seasons()
    {
        return $this->hasMany(Season::class)->orderBy('season_number');
    }
    public function episodes()
    {
        return $this->hasManyThrough(Episode::class, Season::class);
    }
    public function comments(): Relations\HasMany { return $this->hasMany(Comment::class); }
    public function ratings(): Relations\HasMany { return $this->hasMany(Rating::class); }
    public function reports(): Relations\HasMany { return $this->hasMany(Report::class); }
    public function favorites(): Relations\BelongsToMany { return $this->belongsToMany(User::class, 'favorites', 'movie_id', 'user_id'); }

    // Scopes
    public function scopeSingle($query) { return $query->where('type', 1); }
    public function scopeSeries($query) { return $query->where('type', 2); }
    public function scopeFeatured($query) { return $query->where('is_featured', true); }
    public function scopeUpcoming($query) { return $query->where('is_upcoming', true); }
    public function scopeHot($query) { return $query->orderByDesc('views'); }

    // Accessor
    public function getTypeNameAttribute(): string
    {
        return $this->type == 1 ? 'Phim lẻ' : 'Phim bộ';
    }

    protected static function booted()
    {   
        static::created(function ($movie) {
            if ($movie->type == 1) { // Phim lẻ
                $season = $movie->seasons()->create([
                    'season_number' => 1,
                    'title' => 'Phim lẻ',
                ]);

                $season->episodes()->create([
                    'episode_number' => 1,
                    'title' => 'Full',
                    'movie_id' => $movie->id,
                ]);
            }
        });
    }

// Quan hệ để lấy tập mặc định của phim lẻ
    public function singleEpisode()
    {
        return $this->hasOneThrough(
            Episode::class,
            Season::class,
            'movie_id',
            'season_id'
        )->where('episodes.episode_number', 1);
    }

    public function getRatingAttribute()
    {
        return Cache::remember("movie_{$this->id}_rating", 30, function () {
            $avg   = $this->ratings()->avg('score') ?? 0;
            $count = $this->ratings()->count();

            return [
                'average' => round($avg, 1),
                'count'   => $count,
                'out_of'  => 10
            ];
        });
    }
}