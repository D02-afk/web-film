<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Genre;
use App\Models\Country;
use App\Models\Actor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    // Hàm hỗ trợ upload ảnh
    private function uploadImage($file, $folder = 'movies')
    {
        if (!$file) return null;

        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('movies', $filename, 'public'); // lưu vào storage/app/public/movies
        return '/storage/' . $path; // trả về đường dẫn public
    }

    // Danh sách phim
    public function index(Request $request)
    {
        $query = Movie::query()->with(['country', 'genres']);

        // Tìm kiếm
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                ->orWhere('slug', 'LIKE', "%{$search}%")
                ->orWhere('year', 'LIKE', "%{$search}%");
            });
        }

        // Lọc quốc gia
        if ($country = $request->get('country')) {
            $query->where('country_id', $country);
        }

        // Lọc thể loại (nhiều thể loại)
        if ($genres = $request->filled('genres') ? $request->get('genres') : []) {
            $query->whereHas('genres', function ($q) use ($genres) {
                $q->whereIn('genres.id', $genres);
            });
        }

        // Lọc loại phim
        if ($type = $request->get('type')) {
            $query->where('type', $type);
        }

        // Lọc trạng thái (nếu bạn có cột status: 1=hoàn thành, 2=đang chiếu...)
        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        // Sắp xếp
        $query->latest();

        $movies = $query->paginate(15)->withQueryString(); // giữ lại param khi phân trang

        // Dữ liệu cho form lọc
        $countries = Country::orderBy('name')->get();
        $allGenres = Genre::orderBy('name')->get();

        return view('admin.movies.index', compact('movies', 'countries', 'allGenres'));
    }

    // Form thêm phim
    public function create()
    {
        $genres    = Genre::orderBy('name')->get();
        $countries = Country::orderBy('name')->get();
        $actors    = Actor::orderBy('name')->get();

        return view('admin.movies.create', compact('genres', 'countries', 'actors'));
    }

    // Lưu phim mới
    public function store(Request $request)
    {
        $request->validate([
            'title'           => 'required|string|max:255',
            'slug'            => 'required|string|unique:movies,slug',
            'year'            => 'required|integer|min:1900|max:2035',
            'country_id'      => 'required|exists:countries,id',
            'type'            => 'required|in:1,2',
            'poster_file'     => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'thumbnail_file'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'genres'          => 'required|array|min:1',
            'genres.*'        => 'exists:genres,id',
        ]);

        $data = $request->only([
            'title', 'slug', 'year', 'country_id', 'type',
            'description', 'quality', 'language', 'duration'
        ]);

        // Upload poster (bắt buộc)
        $data['poster'] = $this->uploadImage($request->file('poster_file'));

        // Upload thumbnail (tùy chọn)
        if ($request->hasFile('thumbnail_file')) {
            $data['thumbnail'] = $this->uploadImage($request->file('thumbnail_file'));
        }

        $movie = Movie::create($data);

        // Sync thể loại & diễn viên
        $movie->genres()->sync($request->genres);
        if ($request->actors) {
            $movie->actors()->sync($request->actors);
        }

        return redirect()->route('admin.movies.index')
            ->with('success', 'Thêm phim thành công!');
    }

    // Form sửa phim
    // public function edit(Movie $movie)
    // {
    //     $genres    = Genre::orderBy('name')->get();
    //     $countries = Country::orderBy('name')->get();
    //     $actors    = Actor::orderBy('name')->get();

    //     return view('admin.movies.edit', compact('movie', 'genres', 'countries', 'actors'));
    // }

    // Cập nhật phim
    // App\Http\Controllers\Admin\MovieController.php

    public function update(Request $request, Movie $movie)
    {
        $request->validate([
            'title'           => 'required|string|max:255',
            'slug'            => 'required|string|unique:movies,slug,' . $movie->id,
            'year'            => 'required|integer|min:1900|max:2035',
            'country_id'      => 'required|exists:countries,id',
            'type'            => 'required|in:1,2',
            'poster_file'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'thumbnail_file'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'imdb_score'      => 'nullable|numeric|min:0|max:10',
            'duration'        => 'nullable|integer|min:1|max:999',
            'genres'          => 'required|array|min:1',
            'genres.*'        => 'exists:genres,id',
        ]);

        $data = $request->only([
            'title',
            'slug',
            'origin_name',
            'description',
            'year',
            'country_id',
            'type',
            'imdb_score',
            'duration',
            'quality',
            'language',
            'trailer_url',
        ]);

        // Xử lý các trường boolean (checkbox)
        $data['is_vip']      = $request->has('is_vip');
        $data['is_featured'] = $request->has('is_featured');

        // Upload poster mới (nếu có)
        if ($request->hasFile('poster_file')) {
            if ($movie->poster && file_exists(public_path($movie->poster))) {
                unlink(public_path($movie->poster));
            }
            $data['poster'] = $this->uploadImage($request->file('poster_file'));
        }

        // Upload thumbnail mới (nếu có)
        if ($request->hasFile('thumbnail_file')) {
            if ($movie->thumbnail && file_exists(public_path($movie->thumbnail))) {
                unlink(public_path($movie->thumbnail));
            }
            $data['thumbnail'] = $this->uploadImage($request->file('thumbnail_file'));
        }

        $movie->update($data);

        // Sync thể loại
        $movie->genres()->sync($request->genres);

        // Diễn viên: hiện tại trang show không có form chọn actor → giữ nguyên như cũ
        // Nếu muốn sửa actor luôn ở đây thì thêm select multiple trong form và sync ở đây
        // $movie->actors()->sync($request->actors ?? []);

        return back()->with('success', 'Cập nhật phim thành công!');
    }

    // Xóa phim
    public function destroy(Movie $movie)
    {
        // Xóa ảnh nếu có
        if ($movie->poster && file_exists(public_path($movie->poster))) {
            unlink(public_path($movie->poster));
        }
        if ($movie->thumbnail && file_exists(public_path($movie->thumbnail))) {
            unlink(public_path($movie->thumbnail));
        }

        $movie->delete();

        return back()->with('success', 'Xóa phim thành công!');
    }


    public function show(Movie $movie)
    {
        // Load đầy đủ quan hệ cần thiết để hiển thị
        $movie->load([
            'country',
            'genres',
            'cast.actor',
            'seasons.episodes.servers',
            'comments.user',
            'ratings'
        ]);

        $rating = $movie->rating;

        $genres    = Genre::orderBy('name')->get();
        $countries = Country::orderBy('name')->get();
        $actors    = Actor::orderBy('name')->get();

        $totalEpisodes = $movie->type == 1 
            ? 1 
            : $movie->seasons->sum(fn($s) => $s->episodes->count());

        // Tổng số server/link phim
        $totalServers = $movie->type == 1
            ? $movie->seasons->first()?->episodes->first()?->servers->count() ?? 0
            : $movie->seasons->pluck('episodes')->flatten()->sum(fn($ep) => $ep->servers->count());

        return view('admin.movies.edit', compact(
            'movie',
            'rating',
            'totalEpisodes',
            'totalServers',
            'genres',
            'countries',
            'actors'
        ));
    }
}