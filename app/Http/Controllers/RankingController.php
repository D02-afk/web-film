<?php
// app/Http/Controllers/RankingController.php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Genre;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class RankingController extends Controller
{

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

    public function index()
    {
        // 1. Top 20 phim có lượt xem cao nhất (tất cả)
        $topViews = Movie::with(['country', 'genres'])
            ->orderByDesc('views')
            ->limit(20)
            ->get();

        // 2. Top 20 phim điểm IMDb cao nhất (có điểm)
        $topImdb = Movie::whereNotNull('imdb_score')
            ->where('imdb_score', '>', 0)
            ->orderByDesc('imdb_score')
            ->orderByDesc('views') // phụ để tránh bằng điểm
            ->limit(20)
            ->get();

        // 3. Top 20 phim VIP có lượt xem cao nhất
        $topVip = Movie::where('is_vip', true)
            ->orderByDesc('views')
            ->limit(20)
            ->get();

        // 4. Top 20 phim được yêu thích nhiều nhất (dựa vào bảng favorites)
        $topFavorites = Movie::withCount('favorites')
            ->orderByDesc('favorites_count')
            ->orderByDesc('views')
            ->limit(20)
            ->get();

        // 5. Top 10 thể loại hot nhất (tổng lượt xem của tất cả phim trong thể loại)
        $topGenres = Genre::select('genres.*')
            ->join('movie_genre', 'genres.id', '=', 'movie_genre.genre_id')
            ->join('movies', 'movie_genre.movie_id', '=', 'movies.id')
            ->selectRaw('genres.*, COALESCE(SUM(movies.views), 0) as total_views')
            ->groupBy('genres.id', 'genres.name', 'genres.slug')
            ->orderByDesc('total_views')
            ->limit(10)
            ->get();

        // 6. Top 10 quốc gia hot nhất
        $topCountries = Country::select('countries.*')
            ->join('movies', 'countries.id', '=', 'movies.country_id')
            ->selectRaw('countries.*, COALESCE(SUM(movies.views), 0) as total_views')
            ->groupBy('countries.id', 'countries.name', 'countries.slug')
            ->orderByDesc('total_views')
            ->limit(10)
            ->get();

        // 7. Top 10 phim lẻ hot nhất
        $topSingle = Movie::where('type', 1)
            ->orderByDesc('views')
            ->limit(10)
            ->get();

        // 8. Top 10 phim bộ hot nhất
        $topSeries = Movie::where('type', 2)
            ->orderByDesc('views')
            ->limit(10)
            ->get();
         $header = $this->getHeaderData();

        return view('front.ranking.index', array_merge($header, compact(
            'topViews',
            'topImdb',
            'topVip',
            'topFavorites',
            'topGenres',
            'topCountries',
            'topSingle',
            'topSeries'
        )));
    }

    // Trang riêng: Chỉ phim lẻ
    public function single()
    {
        $topSingle = Movie::where('type', 1)
            ->orderByDesc('views')
            ->paginate(30);
        $header = $this->getHeaderData();
        return view('front.ranking.single',array_merge($header, compact('topSingle')));
    }

    // Trang riêng: Chỉ phim bộ
    public function series()
    {
        $topSeries = Movie::where('type', 2)
            ->orderByDesc('views')
            ->paginate(30);
        $header = $this->getHeaderData();
        return view('front.ranking.series', array_merge($header,compact('topSeries')));
    }

    // Trang riêng: Chỉ phim VIP
    public function vip()
    {
        $topVip = Movie::where('is_vip', true)
            ->orderByDesc('views')
            ->paginate(30);
        $header = $this->getHeaderData();
        return view('front.ranking.vip', array_merge($header,compact('topVip')));
    }

    
}