<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;

class MovieSeeder extends Seeder
{
    public function run(): void
    {
        FacadesDB::table('movies')->insert([
            [
                'id' => 1,
                'title' => 'Action Movie 1',
                'slug' => 'action-movie-1',
                'poster' => 'https://via.placeholder.com/150x225',
                'year' => 2022,
                'country_id' => 1,
                'type' => 1,
                'status' => 1,
                'language' => 'Vietsub',
                'views' => 0,
                'created_at' => '2025-11-28 05:40:32',
                'updated_at' => '2025-11-28 05:40:32',
            ],
            [
                'id' => 2,
                'title' => 'Romantic Drama',
                'slug' => 'romantic-drama',
                'poster' => 'https://via.placeholder.com/150x225',
                'year' => 2021,
                'country_id' => 2,
                'type' => 2,
                'status' => 1,
                'language' => 'Vietsub',
                'views' => 0,
                'created_at' => '2025-11-28 05:40:32',
                'updated_at' => '2025-11-28 05:40:32',
            ],
        ]);
    }
}
