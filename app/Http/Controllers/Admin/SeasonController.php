<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Season;
use Illuminate\Http\Request;

class SeasonController extends Controller
{
    public function index(Movie $movie)
    {
        $movie->load('seasons.episodes');
        return view('admin.seasons.index', compact('movie'));
    }

    public function create(Movie $movie)
    {
        return view('admin.seasons.create', compact('movie'));
    }

    public function store(Request $request, Movie $movie)
    {
        $request->validate([
            'season_number' => 'required|integer|min:1|unique:seasons,season_number,NULL,id,movie_id,'.$movie->id,
            'title' => 'nullable|string|max:255',
        ]);

        Season::create([
            'movie_id' => $movie->id,
            'season_number' => $request->season_number,
            'title' => $request->title ?? "Mùa {$request->season_number}",
        ]);

        return redirect()->route('admin.movies.seasons.index', $movie)
            ->with('success', 'Thêm {$request->title ?? "Mùa"} thành công!');
    }

    public function edit(Movie $movie, Season $season)
    {
        return view('admin.seasons.edit', compact('movie', 'season'));
    }

    public function update(Request $request, Movie $movie, Season $season)
    {
        $request->validate([
            'season_number' => 'required|integer|min:1|unique:seasons,season_number,'.$season->id.',id,movie_id,'.$movie->id,
            'title' => 'nullable|string|max:255',
        ]);

        $season->update([
            'season_number' => $request->season_number,
            'title' => $request->title ?? "Mùa {$request->season_number}",
        ]);

        return redirect()->route('admin.movies.seasons.index', $movie)
            ->with('success', 'Cập nhật mùa thành công!');
    }

    public function destroy(Movie $movie, Season $season)
    {
        // Xóa hết tập + server + sub trước
        foreach ($season->episodes as $episode) {
            $episode->servers()->delete();
            $episode->subtitles()->delete();
        }
        $season->episodes()->delete();
        $season->delete();

        return back()->with('success', 'Xóa mùa thành công!');
    }
}