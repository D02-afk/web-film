<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Genre;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query    = trim($request->input('q', ''));
        $type     = $request->input('type');     // 1 = phim lẻ, 2 = phim bộ
        $genre    = $request->input('genre');    // slug thể loại
        $country  = $request->input('country');  // slug quốc gia
        $year     = $request->input('year');     // năm
        $sort     = $request->input('sort', 'latest');

        $movies = Movie::query()
            ->with(['country', 'genres']) // eager load quan hệ
            ->select('movies.*') // tránh conflict

            // TÌM KIẾM THEO TỪ KHÓA
            ->when($query, function ($q) use ($query) {
                $q->where(function ($sq) use ($query) {
                    $sq->where('title', 'like', "%{$query}%")
                       ->orWhere('origin_name', 'like', "%{$query}%")
                       ->orWhere('slug', 'like', "%{$query}%");
                });
            })

            // LỌC LOẠI PHIM (type: 1 = lẻ, 2 = bộ)
            ->when(in_array($type, ['1', '2']), function ($q) use ($type) {
                $q->where('type', $type);
            })

            // LỌC THỂ LOẠI (movie_genre pivot table)
            ->when($genre, function ($q) use ($genre) {
                $q->whereHas('genres', fn($g) => $g->where('slug', $genre));
            })

            // LỌC QUỐC GIA (country_id → countries table)
            ->when($country, function ($q) use ($country) {
                $q->whereHas('country', fn($c) => $c->where('slug', $country));
            })

            // LỌC NĂM
            ->when($year && is_numeric($year), function ($q) use ($year) {
                $q->where('year', $year);
            })

            // SẮP XẾP
            ->when($sort, function ($q) use ($sort) {
                match ($sort) {
                    'views'   => $q->orderByDesc('views'),
                    'title'   => $q->orderBy('title'),
                    'oldest'  => $q->orderBy('year'),
                    default   => $q->latest(), // mới nhất
                };
            }, fn($q) => $q->latest())

            ->paginate(24)
            ->withQueryString();

        // Load danh sách lọc cho form
        $genres    = Genre::orderBy('name')->get(['id', 'name', 'slug']);
        $countries = Country::orderBy('name')->get(['id', 'name', 'slug']);
        $header = $this->getHeaderData();
        $suggestions = [
            'hot'     => Movie::where('is_featured', 1)
                            ->inRandomOrder()
                            ->limit(10)
                            ->get(),

            'latest'  => Movie::latest()
                            ->limit(10)
                            ->get(),

            'single'  => Movie::where('type', 1)
                            ->where('views', '>', 500)
                            ->inRandomOrder()
                            ->limit(10)
                            ->get(),

            'series'  => Movie::where('type', 2)
                            ->where('views', '>', 500)
                            ->inRandomOrder()
                            ->limit(10)
                            ->get(),
        ];

        return view('search', array_merge( $header ,compact(
            'movies',
            'query',
            'type',
            'genre',
            'country',
            'year',
            'sort',
            'genres',
            'countries',
            'suggestions'
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
}