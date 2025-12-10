<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seasons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained()->cascadeOnDelete();
            $table->smallInteger('season_number')->unsigned();
            $table->string('title')->nullable();
            $table->timestamps();

            $table->unique(['movie_id', 'season_number']);
        });

        // Sửa episodes để thuộc season
        Schema::table('episodes', function (Blueprint $table) {
            $table->foreignId('season_id')->nullable()->after('movie_id')->constrained()->nullOnDelete();
            // Nếu không có season thì mặc định thuộc mùa 1 (hoặc phim lẻ)
        });
    }

    public function down(): void
    {
        Schema::table('episodes', function (Blueprint $table) {
            $table->dropForeign(['season_id']);
            $table->dropColumn('season_id');
        });
        Schema::dropIfExists('seasons');
    }
};