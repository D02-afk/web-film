<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        $more = [
            // Homepage blocks
            ['key' => 'slider_movies_count', 'value' => '10', 'type' => 'number', 'group' => 'homepage'],
            ['key' => 'show_slider', 'value' => '1', 'type' => 'checkbox', 'group' => 'homepage'],

            ['key' => 'hot_week_title', 'value' => 'Phim Hot Trong Tuần', 'type' => 'text', 'group' => 'homepage'],
            ['key' => 'hot_week_count', 'value' => '12', 'type' => 'number', 'group' => 'homepage'],
            ['key' => 'show_hot_week', 'value' => '1', 'type' => 'checkbox', 'group' => 'homepage'],

            ['key' => 'new_movies_title', 'value' => 'Phim Mới Cập Nhật', 'type' => 'text', 'group' => 'homepage'],
            ['key' => 'new_movies_count', 'value' => '24', 'type' => 'number', 'group' => 'homepage'],
            ['key' => 'show_new_movies', 'value' => '1', 'type' => 'checkbox', 'group' => 'homepage'],

            ['key' => 'single_movies_title', 'value' => 'Phim Lẻ Mới Nhất', 'type' => 'text', 'group' => 'homepage'],
            ['key' => 'single_movies_count', 'value' => '12', 'type' => 'number', 'group' => 'homepage'],
            ['key' => 'show_single_movies', 'value' => '1', 'type' => 'checkbox', 'group' => 'homepage'],

            ['key' => 'series_movies_title', 'value' => 'Phim Bộ Hay Nhất', 'type' => 'text', 'group' => 'homepage'],
            ['key' => 'series_movies_count', 'value' => '12', 'type' => 'number', 'group' => 'homepage'],
            ['key' => 'show_series_movies', 'value' => '1', 'type' => 'checkbox', 'group' => 'homepage'],

            ['key' => 'completed_movies_title', 'value' => 'Phim Bộ Hoàn Thành', 'type' => 'text', 'group' => 'homepage'],
            ['key' => 'completed_movies_count', 'value' => '12', 'type' => 'number', 'group' => 'homepage'],
            ['key' => 'show_completed_movies', 'value' => '1', 'type' => 'checkbox', 'group' => 'homepage'],

            ['key' => 'top_view_title', 'value' => 'Top Phim Xem Nhiều', 'type' => 'text', 'group' => 'homepage'],
            ['key' => 'top_view_count', 'value' => '10', 'type' => 'number', 'group' => 'homepage'],
            ['key' => 'show_top_view', 'value' => '1', 'type' => 'checkbox', 'group' => 'homepage'],

            // Player & Ads
            ['key' => 'default_player', 'value' => 'plyr', 'type' => 'select', 'group' => 'player'],
            ['key' => 'ads_header', 'value' => '', 'type' => 'textarea', 'group' => 'ads'],
            ['key' => 'ads_footer', 'value' => '', 'type' => 'textarea', 'group' => 'ads'],
            ['key' => 'support_zalo', 'value' => 'https://zalo.me/...', 'type' => 'text', 'group' => 'general'],
            ['key' => 'maintenance_mode', 'value' => '0', 'type' => 'checkbox', 'group' => 'advanced'],
        ];

        foreach ($more as $item) {
            DB::table('settings')->updateOrInsert(['key' => $item['key']], $item);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            //
        });
    }
};
