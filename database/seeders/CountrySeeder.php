<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        FacadesDB::table('countries')->insert([
            ['id' => 1, 'name' => 'USA', 'slug' => 'usa'],
            ['id' => 2, 'name' => 'UK', 'slug' => 'uk'],
            ['id' => 3, 'name' => 'Japan', 'slug' => 'japan'],
            ['id' => 4, 'name' => 'Korea', 'slug' => 'korea'],
            ['id' => 5, 'name' => 'France', 'slug' => 'france'],
        ]);
    }
}
