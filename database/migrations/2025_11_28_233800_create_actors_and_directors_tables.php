<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Bảng diễn viên + đạo diễn (cùng bảng, phân biệt bằng role)
        Schema::create('actors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('avatar')->nullable();
            $table->date('birthday')->nullable();
            $table->string('country')->nullable();
            $table->text('bio')->nullable();
            $table->timestamps();
        });

        // Quan hệ phim - diễn viên/đạo diễn
        Schema::create('movie_cast', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained()->cascadeOnDelete();
            $table->foreignId('actor_id')->constrained('actors')->cascadeOnDelete();
            $table->string('role')->default('actor'); // actor | director
            $table->string('character_name')->nullable(); // Tên nhân vật (nếu là diễn viên)
            $table->unique(['movie_id', 'actor_id', 'role']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movie_cast');
        Schema::dropIfExists('actors');
    }
};