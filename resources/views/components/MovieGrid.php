<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MovieGrid extends Component
{
    public $title;
    public $movies;
    public $icon;

    public function __construct($title = null, $movies = [], $icon = null)
    {
        $this->title = $title;
        $this->movies = $movies;
        $this->icon = $icon;
    }

    public function render()
    {
        return view('components.movie-grid');
    }
}