<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class RatingController extends Controller
{
    public function rate(Request $request, Movie $movie)
    {
        $request->validate([
            'score' => 'required|integer|between:1,10'
        ]);
    
        Rating::updateOrCreate(
            ['movie_id' => $movie->id, 'user_id' => Auth::id()],
            ['score' => $request->score, 'ip_address' => $request->ip()]
        );
    
        // Xóa cache rating để cập nhật ngay
        Cache::forget("movie_{$movie->id}_rating");
    
        return response()->json([
            'success' => true,
            'rating'  => $movie->fresh()->rating
        ]);
    }
}
