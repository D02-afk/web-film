<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function storeComment(Request $request, Movie $movie)
    {
        $request->validate([
            'content' => 'required|min:3|max:1000'
        ]);

        $movie->comments()->create([
            'user_id'  => Auth::id(),
            'content'  => clean($request->content), 
        ]);

        return back()->with('success', 'Bình luận của bạn đã được gửi!');
    }
}
