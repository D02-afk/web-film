<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        FacadesDB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Admin Dat',
                'email' => 'dat@gmail.com',
                'password' => '$2y$12$3bwgWTqZvOgXmMoPXcxfvOGo0DpIc56xfFBF9Y8ZTKew2EA9adXCK',
                'is_admin' => 1,
                'created_at' => '2025-11-28 05:40:32',
                'updated_at' => '2025-11-28 05:43:01',
            ],
            [
                'id' => 2,
                'name' => 'Nguyen Van A',
                'email' => 'A@gmail.com',
                'password' => '$2y$12$goFjS1kZEI0s3bpnJF7c2.nCg2tjNZ1E/rpHgWeh8So6gGqTkfdFG',
                'is_admin' => 0,
                'created_at' => '2025-11-28 05:41:38',
                'updated_at' => '2025-11-28 05:41:38',
            ],
        ]);
    }
}
