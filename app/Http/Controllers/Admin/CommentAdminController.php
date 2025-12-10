<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Movie;
use Illuminate\Http\Request;

class CommentAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Comment::with(['user', 'movie'])->latest();

        // Tìm kiếm theo nội dung bình luận hoặc tên phim
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('content', 'like', "%{$search}%")
                  ->orWhereHas('movie', function ($m) use ($search) {
                      $m->where('title', 'like', "%{$search}%");
                  })
                  ->orWhereHas('user', function ($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Lọc theo phim
        if ($movie_id = $request->get('movie')) {
            $query->where('movie_id', $movie_id);
        }

        $comments = $query->paginate(20)->withQueryString();

        $movies = Movie::orderBy('title')->pluck('title', 'id');

        return view('admin.comments.index', compact('comments', 'movies'));
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()->route('admin.comments.index')
                ->with('success', 'Đã xóa bình luận thành công!');
    }
}