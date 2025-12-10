<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Lịch sử xem phim của user
        Schema::create('watch_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('movie_id')->constrained()->cascadeOnDelete();
            $table->foreignId('episode_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('watched_seconds')->default(0); // Xem đến giây thứ bao nhiêu
            $table->timestamps();

            $table->unique(['user_id', 'movie_id', 'episode_id']);
        });

        // Phụ đề riêng (nếu cần nhiều ngôn ngữ)
        Schema::create('subtitles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('episode_id')->constrained()->cascadeOnDelete();
            $table->string('language')->default('vi'); // vi, en, etc.
            $table->string('label')->default('Tiếng Việt');
            $table->text('url'); // .vtt hoặc .srt
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subtitles');
        Schema::dropIfExists('watch_history');
    }
};