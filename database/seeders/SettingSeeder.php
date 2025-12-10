<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        FacadesDB::table('settings')->insert([
            [
                'id' => 1,
                'key' => 'hero_title',
                'value' => 'FilmMWE - Xem Phim Miễn Phí',
                'type' => 'text',
                'group' => 'general',
                'order' => 0,
                'created_at' => '2025-11-28 05:42:19',
                'updated_at' => '2025-11-28 05:42:19',
            ],
            [
                'id' => 2,
                'key' => 'hero_description',
                'value' => 'Xem phim hay nhất 2025, cập nhật liên tục, chất lượng HD',
                'type' => 'text',
                'group' => 'general',
                'order' => 0,
                'created_at' => '2025-11-28 05:42:19',
                'updated_at' => '2025-11-28 05:42:19',
            ],
            [
                'id' => 3,
                'key' => 'site_name',
                'value' => 'LUUUUU',
                'type' => 'text',
                'group' => 'general',
                'order' => 0,
                'created_at' => '2025-11-28 05:42:19',
                'updated_at' => '2025-11-28 06:00:02',
            ],
            [
                'id' => 4,
                'key' => 'primary_color',
                'value' => '#a2fba8',
                'type' => 'text',
                'group' => 'general',
                'order' => 0,
                'created_at' => '2025-11-28 05:42:19',
                'updated_at' => '2025-11-28 05:42:19',
            ],
        ]);
    }
}
