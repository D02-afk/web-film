<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'avatar',
        'provider', 'provider_id', 'is_admin'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
    ];

    public function comments() { return $this->hasMany(Comment::class); }
    public function favorites() { return $this->belongsToMany(Movie::class, 'favorites', 'user_id', 'movie_id')->withTimestamps(); }
    public function ratings() { return $this->hasMany(Rating::class); }
    public function watchHistory() { return $this->hasMany(WatchHistory::class); }
    public function reports() { return $this->hasMany(Report::class); }

    public function isAdmin(): bool { return $this->is_admin; }

    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar ? asset('storage/' . $this->avatar) : asset('images/default-avatar.png');
    }
}