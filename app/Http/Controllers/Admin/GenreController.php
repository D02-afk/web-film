<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::orderBy('name')->paginate(20);
        return view('admin.genres.index', compact('genres'));
    }

    public function create()
    {
        return view('admin.genres.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:genres,name',
        // tên duy nhất
        ]);

        Genre::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.genres.index')
            ->with('success', 'Thêm thể loại thành công!');
    }

    public function edit(Genre $genre)
    {
        return view('admin.genres.edit', compact('genre'));
    }

    public function update(Request $request, Genre $genre)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:genres,name,' . $genre->id,
        ]);

        $genre->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.genres.index')
            ->with('success', 'Cập nhật thể loại thành công!');
    }

    public function destroy(Genre $genre)
    {
        // Nếu phim nào đang dùng thể loại này → không cho xóa (tùy chọn)
        if ($genre->movies()->count() > 0) {
            return back()->with('error', 'Không thể xóa! Có phim đang sử dụng thể loại này.');
        }

        $genre->delete();
        return back()->with('success', 'Xóa thể loại thành công!');
    }
}