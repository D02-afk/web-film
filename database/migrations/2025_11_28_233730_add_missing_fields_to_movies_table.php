<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->string('quality')->nullable()->after('status'); // HD, FullHD, CAM, etc.
            $table->string('language')->default('Vietsub')->after('quality'); // Vietsub, Thuyết minh, Lồng tiếng
            $table->boolean('is_vip')->default(false)->after('language'); // Phim VIP chỉ thành viên xem
            $table->boolean('is_featured')->default(false)->after('is_vip'); // Phim nổi bật trang chủ
            $table->boolean('is_upcoming')->default(false)->after('is_featured'); // Phim sắp chiếu
            $table->text('trailer_url')->nullable()->after('is_upcoming'); // Link trailer YouTube
            $table->integer('duration')->nullable()->after('trailer_url'); // Phút
            $table->string('meta_title')->nullable()->after('duration');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->json('tags')->nullable()->after('meta_description'); // ["18+", "Siêu anh hùng", "Tâm lý"]
        });
    }

    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->dropColumn([
                'quality', 'language', 'is_vip', 'is_featured', 'is_upcoming',
                'trailer_url', 'duration', 'meta_title', 'meta_description', 'tags'
            ]);
        });
    }
};