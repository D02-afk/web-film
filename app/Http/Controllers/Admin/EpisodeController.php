<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Season;
use App\Models\Episode;
use App\Models\Subtitle;
use App\Models\VideoServer;
use Illuminate\Http\Request;

class EpisodeController extends Controller
{
    public function index(Movie $movie, Season $season)
    {
        if ($season->movie_id !== $movie->id) abort(404);
        
        $season->load(['episodes' => fn($q) => $q->orderBy('episode_number')]);

        return view('admin.episodes.index', compact('movie', 'season'));
    }

    public function create(Movie $movie, Season $season)
    {
        if ($season->movie_id !== $movie->id) abort(404);

        return view('admin.episodes.create', compact('movie', 'season'));
    }

    public function store(Request $request, Movie $movie, Season $season)
    {
        if ($season->movie_id !== $movie->id) abort(404);

        $request->validate([
            'episode_number' => 'required|integer|min:1|unique:episodes,episode_number,NULL,id,season_id,' . $season->id,
            'title' => 'required|string|max:255',
        ]);

        $episode = Episode::create([
            'movie_id'       => $movie->id,
            'season_id'      => $season->id,
            'episode_number' => $request->episode_number,
            'title'          => $request->title,
            'video_url'      => null,
            'video_type'     => 1, // Mặc định là server bên ngoài
        ]);

        return redirect()
            ->route('admin.seasons.episodes.index', [$movie, $season])
            ->with('success', "Thêm tập \"{$episode->title}\" thành công!");
    }

    public function edit(Movie $movie, Season $season, Episode $episode)
    {
        if ($episode->season_id !== $season->id || $season->movie_id !== $movie->id) {
            abort(404);
        }

        return view('admin.episodes.edit', compact('movie', 'season', 'episode'));
    }

    public function update(Request $request, Movie $movie, Season $season, Episode $episode)
    {
        if ($episode->season_id !== $season->id || $season->movie_id !== $movie->id) {
            abort(404);
        }

        $request->validate([
            'episode_number' => 'required|integer|min:1|unique:episodes,episode_number,'.$episode->id.',id,season_id,'.$season->id,
            'title' => 'required|string|max:255',
        ]);

        $episode->update([
            'episode_number' => $request->episode_number,
            'title'          => $request->title,
        ]);

        return redirect()
            ->route('admin.seasons.episodes.index', [$movie, $season])
            ->with('success', "Cập nhật tập \"{$episode->title}\" thành công!");
    }

    public function destroy(Movie $movie, Season $season, Episode $episode)
    {
        if ($episode->season_id !== $season->id || $season->movie_id !== $movie->id) {
            abort(404);
        }

        // Xóa server + subtitle
        $episode->servers()->delete();
        $episode->subtitles()->delete();
        $episodeTitle = $episode->title;
        $episode->delete();

        return back()->with('success', "Đã xóa tập \"{$episodeTitle}\" thành công!");
    }

    public function servers(Movie $movie, Season $season, Episode $episode)
    {
        $this->authorizeEpisode($movie, $season, $episode);
        $episode->load('servers');
        return view('admin.episodes.servers', compact('movie', 'season', 'episode'));
    }

    public function serverCreate(Movie $movie, Season $season, Episode $episode)
    {
        $this->authorizeEpisode($movie, $season, $episode);
        return view('admin.episodes.server_create', compact('movie', 'season', 'episode'));
    }

    public function serverStore(Request $request, Movie $movie, Season $season, Episode $episode)
    {
        $this->authorizeEpisode($movie, $season, $episode);

        $request->validate([
            'server_name' => 'required|string|max:100',
            'video_url'   => 'required|url|max:1000',
        ]);

        $episode->servers()->create($request->only(['server_name', 'video_url']));

        return redirect()->route('admin.seasons.episodes.servers', [$movie, $season, $episode])
            ->with('success', 'Thêm server thành công!');
    }

    public function serverDestroy(Movie $movie, Season $season, Episode $episode, VideoServer $server)
    {
        if ($server->episode_id !== $episode->id) abort(404);
        $server->delete();
        return back()->with('success', 'Xóa server thành công!');
    }

    public function subtitles(Movie $movie, Season $season, Episode $episode)
    {
        $this->authorizeEpisode($movie, $season, $episode);
        $episode->load('subtitles');
        return view('admin.episodes.subtitles', compact('movie', 'season', 'episode'));
    }

    public function subtitleCreate(Movie $movie, Season $season, Episode $episode)
    {
        $this->authorizeEpisode($movie, $season, $episode);
        return view('admin.episodes.subtitle_create', compact('movie', 'season', 'episode'));
    }

    public function subtitleStore(Request $request, Movie $movie, Season $season, Episode $episode)
    {
        $this->authorizeEpisode($movie, $season, $episode);

        $request->validate([
            'language' => 'required|string|max:50',
            'label'    => 'required|string|max:100',
            'url'      => 'required|url|max:1000',
        ]);

        $episode->subtitles()->create($request->only(['language', 'label', 'url']));

        return redirect()->route('admin.seasons.episodes.subtitles', [$movie, $season, $episode])
            ->with('success', 'Thêm phụ đề thành công!');
    }

    public function subtitleDestroy(Movie $movie, Season $season, Episode $episode, Subtitle $subtitle)
    {
        if ($subtitle->episode_id !== $episode->id) abort(404);
        $subtitle->delete();
        return back()->with('success', 'Xóa phụ đề thành công!');
    }

    private function authorizeEpisode(Movie $movie, Season $season, Episode $episode)
    {
        if ($episode->season_id !== $season->id || $season->movie_id !== $movie->id) {
            abort(404);
        }
    }
}