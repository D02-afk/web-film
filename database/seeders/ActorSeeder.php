<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ActorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('actors')->insert([
            [
                'id' => 1,
                'name' => 'Robert Downey Jr.',
                'slug' => Str::slug('Robert Downey Jr.'),
                'avatar' => 'https://i.imgur.com/robertdowney.jpg',
                'birthday' => '1965-04-04',
                'country' => 'USA',
                'bio' => 'American actor best known for his role as Iron Man in the Marvel Cinematic Universe.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Scarlett Johansson',
                'slug' => Str::slug('Scarlett Johansson'),
                'avatar' => 'https://i.imgur.com/scarlett.jpg',
                'birthday' => '1984-11-22',
                'country' => 'USA',
                'bio' => 'American actress known for her roles in Marvel and various critically acclaimed movies.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Chris Evans',
                'slug' => Str::slug('Chris Evans'),
                'avatar' => 'https://i.imgur.com/chrisevans.jpg',
                'birthday' => '1981-06-13',
                'country' => 'USA',
                'bio' => 'American actor best known for playing Captain America.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'name' => 'Tom Holland',
                'slug' => Str::slug('Tom Holland'),
                'avatar' => 'https://i.imgur.com/tomholland.jpg',
                'birthday' => '1996-06-01',
                'country' => 'UK',
                'bio' => 'English actor known for his role as Spider-Man in the MCU.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'name' => 'Emma Watson',
                'slug' => Str::slug('Emma Watson'),
                'avatar' => 'https://i.imgur.com/emmawatson.jpg',
                'birthday' => '1990-04-15',
                'country' => 'UK',
                'bio' => 'English actress famous for her role as Hermione Granger in Harry Potter.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
