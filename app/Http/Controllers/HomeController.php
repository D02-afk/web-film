<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Episode;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function home()
    {
        $data = Cache::remember('homepage_data_v2', 1, function () {
            return [
                'newMovies'         => Movie::latest()->take(16)->get(),
                'movies2025'        => Movie::where('year', 2025)->latest()->take(16)->get(),
                'hotSingleMovies'   => Movie::where('type', 1)->orderByDesc('views')->take(16)->get(),
                'hotSeriesMovies'   => Movie::where('type', 2)->orderByDesc('views')->take(16)->get(),
                'animeMovies'       => Movie::whereHas('genres', fn($q) => $q->where('name', 'like', '%Anime%')->orWhere('name', 'Hoạt Hình'))
                                            ->latest()->take(16)->get(),
            ];
        });

        $show = [
            'slider'      => setting('show_slider', 1),
            'hot'         => setting('show_hot', 1),
            'new'         => setting('show_new', 1),
            'single'      => setting('show_single', 1),
            'series'      => setting('show_series', 1),
        ];
        $header = $this->getHeaderData();

        return view('home', array_merge($data, $header, compact('show')));
    }

    public function show($slug)
    {
        $movie = Movie::with([
                'genres',
                'country',
                'cast.actor',
                'seasons.episodes.servers',
                'seasons.episodes.subtitles',
                'comments.user',        // thêm dòng này
                'ratings'
            ])
            ->where('slug', $slug)
            ->firstOrFail();

        // Tăng view chỉ 1 lần mỗi session
        if (!session()->has("viewed_movie_{$movie->id}")) {
            $movie->increment('views');
            session(["viewed_movie_{$movie->id}" => true]);
        }

        // ====================================================================
        // TẤT CẢ CÁC SECTION GỢI Ý ĐƯỢC TÍNH TOÁN TẠI ĐÂY (trong Controller)
        // ====================================================================

        $movieId    = $movie->id;
        $genreIds   = $movie->genres->pluck('id')->toArray();
        $countryId  = $movie->country_id;
        $year       = $movie->year;
        $tags       = is_array($movie->tags) ? $movie->tags : [];

        // 1. Cùng thể loại
        $sameGenres = Movie::where('id', '!=', $movieId)
            ->whereHas('genres', fn($q) => $q->whereIn('genre_id', $genreIds))
            ->inRandomOrder()
            ->limit(20)
            ->get();

        // 2. Cùng quốc gia
        $sameCountry = Movie::where('id', '!=', $movieId)
            ->where('country_id', $countryId)
            ->inRandomOrder()
            ->limit(20)
            ->get();

        // 3. Cùng năm phát hành
        $sameYear = Movie::where('id', '!=', $movieId)
            ->where('year', $year)
            ->inRandomOrder()
            ->limit(20)
            ->get();

        // 4. Đang hot nhất tuần (cache 30 phút)
        $trending = Cache::remember('trending_movies_week', 1800, fn() =>
            Movie::orderByDesc('views')->limit(30)->get()
        );
        $trending = $trending->where('id', '!=', $movieId)->take(20);

        // 5. Có thẻ (tags) tương tự
        $similarByTags = collect();
        if (!empty($tags)) {
            $similarByTags = Movie::where('id', '!=', $movieId)
                ->where(function ($q) use ($tags) {
                    foreach ($tags as $tag) {
                        $q->orWhereJsonContains('tags', $tag);
                    }
                })
                ->inRandomOrder()
                ->limit(20)
                ->get();
        }

        // 6. Người xem phim này cũng thích (dựa trên favorites)
        $usersAlsoLiked = Movie::where('id', '!=', $movieId)
            ->whereHas('favorites', function ($q) use ($movieId) {
                $q->whereIn('user_id', function ($sub) use ($movieId) {
                    $sub->select('user_id')
                        ->from('favorites')
                        ->where('movie_id', $movieId);
                });
            })
            ->inRandomOrder()
            ->limit(20)
            ->get();

        // 7. Phim sắp ra mắt
        $upcoming = Movie::upcoming()
            ->inRandomOrder()
            ->limit(16)
            ->get();

        // 8. Gợi ý hoàn toàn ngẫu nhiên (dự phòng)
        $randomPick = Movie::where('id', '!=', $movieId)
            ->inRandomOrder()
            ->limit(20)
            ->get();

        // Phim cũ (phim liên quan chung – giữ lại để tương thích cũ nếu cần)
        $relatedMovies = $sameGenres->take(12);

        $header = $this->getHeaderData();

        return view('front.movie.show', array_merge($header, compact(
            'movie',
            'relatedMovies', 
            'sameGenres',
            'sameCountry',
            'sameYear',
            'trending',
            'similarByTags',
            'usersAlsoLiked',
            'upcoming',
            'randomPick'
        )));
    }

    public function watch(Request $request, $slug, $episode = null)
    {
        $movie = Movie::with([
            'genres',
            'country',
            'cast.actor',
            'seasons.episodes.servers',
            'seasons.episodes.subtitles',
            'comments.user',
            'ratings'
        ])->where('slug', $slug)->firstOrFail();

        // Tăng view (1 lần/session)
        if (!session()->has("watched_movie_{$movie->id}")) {
            $movie->increment('views');
            session(["watched_movie_{$movie->id}" => true]);
        }

        // === XÁC ĐỊNH TẬP HIỆN TẠI ===
        $currentEpisode = null;

        if ($movie->type == 1) {
            // Phim lẻ → luôn lấy tập đầu tiên (thường chỉ có 1)
            $currentEpisode = $movie->episodes()->with(['servers', 'subtitles'])->first();
        } else {
            // Phim bộ
            $episodeParam = $request->query('ep') ?? $episode ?? $request->route('episode');

            if ($episodeParam) {
                // Ưu tiên: ep từ query string → URL slug → route param
                $currentEpisode = Episode::with(['servers', 'subtitles'])
                    ->where('id', $episodeParam)
                    ->orWhere('episode_number', $episodeParam)
                    ->first();
            }

            // Nếu vẫn không có → lấy tập 1
            if (!$currentEpisode) {
                $currentEpisode = $movie->seasons()
                    ->with(['episodes' => fn($q) => $q->orderBy('episode_number')])
                    ->get()
                    ->pluck('episodes')
                    ->flatten()
                    ->first();
            }
        }

        $header = $this->getHeaderData();

        if (!$currentEpisode) {
            return view('front.movie.watch-no-episode', array_merge($header,compact('movie')));
        }

        // === XỬ LÝ SERVER HIỆN TẠI ===
        $serverId = $request->query('server');

        if ($serverId) {
            $activeServer = $currentEpisode->servers()
                ->where('id', $serverId)
                ->first();
        }

        // Nếu không chọn server hoặc server không có link → lấy server đầu tiên có link
        if (!isset($activeServer) || !$activeServer?->video_url) {
            $activeServer = $currentEpisode->servers()
                ->whereNotNull('video_url')
                ->where('video_url', '!=', '')
                ->first();

            // Nếu vẫn không có → lấy server đầu tiên bất kỳ (hiển thị "đang cập nhật")
            if (!$activeServer) {
                $activeServer = $currentEpisode->servers()->first();
            }
        }

        // === GỢI Ý PHIM ===
        $movieId = $movie->id;
        $genreIds = $movie->genres->pluck('id')->toArray();

        $sameGenres = Movie::where('id', '!=', $movieId)
            ->whereHas('genres', fn($q) => $q->whereIn('genre_id', $genreIds))
            ->inRandomOrder()->limit(20)->get();

        $sameCountry = Movie::where('id', '!=', $movieId)
            ->where('country_id', $movie->country_id)
            ->inRandomOrder()->limit(20)->get();

        $trending = Cache::remember('trending_week', 1800, function () {
            return Movie::orderByDesc('views')->limit(30)->get();
        })->where('id', '!=', $movieId)->take(20);

        $randomPick = Movie::where('id', '!=', $movieId)->inRandomOrder()->limit(20)->get();

        $header = $this->getHeaderData();

        return view('front.movie.watch', array_merge($header, compact(
            'movie',
            'currentEpisode',
            'activeServer',
            'sameGenres',
            'sameCountry',
            'trending',
            'randomPick'
        )));
    }

    public function getHeaderData()
    {
        return Cache::remember('header_filters_data', 1800, function () {
            $genres = Genre::orderBy('name')->get(['id', 'name', 'slug']);
            $countries = Country::orderBy('name')->get(['id', 'name', 'slug']);
            $currentYear = now()->year;
            $years = collect();
            for ($year = $currentYear; $year >= 1990; $year--) {
                $years->push([
                    'year' => $year,
                    'is_new' => $year >= $currentYear - 1,
                ]);
            }

            return [
                'genres'   => $genres,
                'countries'=> $countries,
                'years'    => $years,
            ];
        });
    }

    private function getHotMovies()
    {
        return setting('show_hot', 1)
            ? Movie::Where('views', '>', 1000)
                ->latest('views')
                ->take(12)
                ->get()
            : collect();
    }

    private function getNewMovies()
    {
        return setting('show_new', 1)
            ? Movie::latest()->take(24)->get()
            : collect();
    }

    private function getSingleMovies()
    {
        return setting('show_single', 1)
            ? Movie::where('type', 1)->latest()->take(12)->get()
            : collect();
    }

    private function getSeriesMovies()
    {
        return setting('show_series', 1)
            ? Movie::where('type', 2)->latest()->take(12)->get()
            : collect();
    }
}