<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Đánh giá sao
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedTinyInteger('score')->comment('1-10'); // 1-10 điểm
            $table->text('review')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->timestamps();

            $table->unique(['movie_id', 'user_id']); // 1 user chỉ rate 1 lần
            $table->index(['movie_id', 'score']);
        });

        // Báo lỗi link hỏng
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('episode_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('movie_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('reason'); // Link hỏng, không có âm thanh, sai tập...
            $table->text('description')->nullable();
            $table->boolean('resolved')->default(false);
            $table->ipAddress('ip_address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
        Schema::dropIfExists('ratings');
    }
};