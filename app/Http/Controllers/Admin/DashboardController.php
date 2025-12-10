<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\User;
use App\Models\Comment;
use App\Models\Report;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_movies'      => Movie::count(),
            'total_users'         => User::where('is_admin', 0)->count(),
            'total_admins'        => User::where('is_admin', 1)->count(),
            'total_comments'      => Comment::count(),
            'pending_reports'     => Report::where('resolved', false)->count(),
            'today_views'         => Movie::whereDate('updated_at', today())->sum('views'),
            'total_views'         => Movie::sum('views'),
        ];

        $recentMovies = Movie::latest()->take(10)->get();
        $recentUsers  = User::latest()->take(10)->get();

        return view('admin.dashboard', compact('stats', 'recentMovies', 'recentUsers'));
    }
}