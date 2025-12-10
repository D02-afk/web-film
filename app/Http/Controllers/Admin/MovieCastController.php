<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Actor;
use App\Models\MovieCast;
use Illuminate\Http\Request;

class MovieCastController extends Controller
{
    public function index(Movie $movie)
    {
        $movie->load('cast.actor');
        $actors = Actor::orderBy('name')->get();

        return view('admin.movies.cast', compact('movie', 'actors'));
    }

    public function store(Request $request, Movie $movie)
    {
        $request->validate([
            'actor_id' => 'required|exists:actors,id',
            'role' => 'required|in:actor,director',
            'character_name' => 'nullable|string|max:255',
        ]);

        // Tránh trùng
        $exists = MovieCast::where('movie_id', $movie->id)
                           ->where('actor_id', $request->actor_id)
                           ->where('role', $request->role)
                           ->exists();

        if ($exists) {
            return back()->with('error', 'Diễn viên này đã được gán với vai trò này!');
        }

        MovieCast::create([
            'movie_id' => $movie->id,
            'actor_id' => $request->actor_id,
            'role' => $request->role,
            'character_name' => $request->character_name,
        ]);

        return back()->with('success', 'Thêm thành công!');
    }

    public function destroy(MovieCast $movieCast)
    {
        $movieCast->delete();
        return back()->with('success', 'Xóa thành công!');
    }
}