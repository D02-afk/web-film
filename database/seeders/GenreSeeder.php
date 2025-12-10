<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        FacadesDB::table('genres')->insert([
            ['id' => 1, 'name' => 'Action', 'slug' => 'action'],
            ['id' => 2, 'name' => 'Comedy', 'slug' => 'comedy'],
            ['id' => 3, 'name' => 'Drama', 'slug' => 'drama'],
            ['id' => 4, 'name' => 'Horror', 'slug' => 'horror'],
            ['id' => 5, 'name' => 'Romance', 'slug' => 'romance'],
        ]);
    }
}
