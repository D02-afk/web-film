<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;

class MovieGenreSeeder extends Seeder
{
    public function run(): void
    {
        FacadesDB::table('movie_genre')->insert([
            ['movie_id' => 1, 'genre_id' => 1],
            ['movie_id' => 1, 'genre_id' => 2],
            ['movie_id' => 2, 'genre_id' => 3],
            ['movie_id' => 2, 'genre_id' => 5],
        ]);
    }
}
