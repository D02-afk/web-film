<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\{
    DashboardController, MovieController, GenreController,CommentAdminController,
    CountryController, ActorController, EpisodeController, MovieCastController, UserController,
    SettingController, ReportController,
    SeasonController
};
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\SearchController;

// === GUEST ONLY (chưa đăng nhập mới vào được) ===
Route::middleware('guest')->group(function () {
    Route::get('/dang-ky', [RegisterController::class, 'create'])->name('register');
    Route::post('/dang-ky', [RegisterController::class, 'store']);

    Route::get('/dang-nhap', [LoginController::class, 'create'])->name('login');
    Route::post('/dang-nhap', [LoginController::class, 'store']);
});

// === ĐĂNG XUẤT (phải đăng nhập mới được) ===
Route::post('/dang-xuat', [LoginController::class, 'destroy'])
    ->name('logout')
    ->middleware('auth');

// ==================== ADMIN CONTROL PANEL ====================
Route::prefix('admincp')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {

    // ========================================
    // 1. Dashboard
    // ========================================
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // ========================================
    // 2. Quản lý Phim (Movies)
    // ========================================
    Route::get('movies', [App\Http\Controllers\Admin\MovieController::class, 'index'])
        ->name('movies.index');
    Route::get('movies/create', [App\Http\Controllers\Admin\MovieController::class, 'create'])
        ->name('movies.create');
    Route::post('movies', [App\Http\Controllers\Admin\MovieController::class, 'store'])
        ->name('movies.store');
    Route::get('movies/{movie}/edit', [App\Http\Controllers\Admin\MovieController::class, 'edit'])
        ->name('movies.edit');
    Route::put('movies/{movie}', [App\Http\Controllers\Admin\MovieController::class, 'update'])
        ->name('movies.update');
    Route::delete('movies/{movie}', [App\Http\Controllers\Admin\MovieController::class, 'destroy'])
        ->name('movies.destroy');
    Route::get('/movies/{movie}', [MovieController::class, 'show'])
     ->name('movies.show');

    // ========================================
    // 3. Thể loại & Quốc gia (Genres + Countries)
    // ========================================
    Route::get('genres', [App\Http\Controllers\Admin\GenreController::class, 'index'])
        ->name('genres.index');
    Route::get('genres/create', [App\Http\Controllers\Admin\GenreController::class, 'create'])
        ->name('genres.create');
    Route::post('genres', [App\Http\Controllers\Admin\GenreController::class, 'store'])
        ->name('genres.store');
    Route::get('genres/{genre}/edit', [App\Http\Controllers\Admin\GenreController::class, 'edit'])
        ->name('genres.edit');
    Route::put('genres/{genre}', [App\Http\Controllers\Admin\GenreController::class, 'update'])
        ->name('genres.update');
    Route::delete('genres/{genre}', [App\Http\Controllers\Admin\GenreController::class, 'destroy'])
        ->name('genres.destroy');

    Route::get('countries', [App\Http\Controllers\Admin\CountryController::class, 'index'])
        ->name('countries.index');
    Route::get('countries/create', [App\Http\Controllers\Admin\CountryController::class, 'create'])
        ->name('countries.create');
    Route::post('countries', [App\Http\Controllers\Admin\CountryController::class, 'store'])
        ->name('countries.store');
    Route::get('countries/{country}/edit', [App\Http\Controllers\Admin\CountryController::class, 'edit'])
        ->name('countries.edit');
    Route::put('countries/{country}', [App\Http\Controllers\Admin\CountryController::class, 'update'])
        ->name('countries.update');
    Route::delete('countries/{country}', [App\Http\Controllers\Admin\CountryController::class, 'destroy'])
        ->name('countries.destroy');

    // ========================================
    // 4. Diễn viên (Actors)
    // ========================================
    Route::get('actors', [App\Http\Controllers\Admin\ActorController::class, 'index'])
        ->name('actors.index');
    Route::get('actors/create', [App\Http\Controllers\Admin\ActorController::class, 'create'])
        ->name('actors.create');
    Route::post('actors', [App\Http\Controllers\Admin\ActorController::class, 'store'])
        ->name('actors.store');
    Route::get('actors/{actor}/edit', [App\Http\Controllers\Admin\ActorController::class, 'edit'])
        ->name('actors.edit');
    Route::put('actors/{actor}', [App\Http\Controllers\Admin\ActorController::class, 'update'])
        ->name('actors.update');
    Route::delete('actors/{actor}', [App\Http\Controllers\Admin\ActorController::class, 'destroy'])
        ->name('actors.destroy');

    // ========================================
    // 5. Người dùng (Users)
    // ========================================
    Route::get('users', [App\Http\Controllers\Admin\UserController::class, 'index'])
        ->name('users.index');
    Route::get('users/create', [App\Http\Controllers\Admin\UserController::class, 'create'])
        ->name('users.create');
    Route::post('users', [App\Http\Controllers\Admin\UserController::class, 'store'])
        ->name('users.store');
    Route::get('users/{user}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])
        ->name('users.edit');
    Route::put('users/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])
        ->name('users.update');
    Route::delete('users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])
        ->name('users.destroy');
    Route::post('users/quick-create', [App\Http\Controllers\Admin\UserController::class, 'quickCreate'])
        ->name('users.quick');

    // ========================================
    // 6. Báo lỗi link (Reports)
    // ========================================
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::patch('reports/{report}/resolve', [ReportController::class, 'resolve'])->name('reports.resolve');
    Route::delete('reports/{report}', [ReportController::class, 'destroy'])->name('reports.destroy');

    // ========================================
    // 7. Cài đặt website (Settings)
    // ========================================
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');

    // ========================================
    // 8. GÁN DIỄN VIÊN CHO PHIM (Movie Cast)
    // ========================================
    Route::get('movies/{movie}/cast', [MovieCastController::class, 'index'])
        ->name('movies.cast.index');
    Route::post('movies/{movie}/cast', [MovieCastController::class, 'store'])
        ->name('movies.cast.store');
    Route::delete('movie-cast/{movieCast}', [MovieCastController::class, 'destroy'])
        ->name('movies.cast.destroy');

    // ========================================
    // 9. Comment
    // ========================================
    Route::get('comments', [CommentAdminController::class, 'index'])->name('comments.index');
    Route::delete('comments/{comment}', [CommentAdminController::class, 'destroy'])->name('comments.destroy');

    // ========================================
    // 10. QUẢN LÝ MÙA PHIM (Seasons) – Nested trong movie
    // ========================================
    Route::prefix('movies/{movie}')->group(function () {

    // --- MÙA ---
        Route::get('seasons', [SeasonController::class, 'index'])->name('movies.seasons.index');
        Route::get('seasons/create', [SeasonController::class, 'create'])->name('movies.seasons.create');
        Route::post('seasons', [SeasonController::class, 'store'])->name('movies.seasons.store');
        Route::get('seasons/{season}/edit', [SeasonController::class, 'edit'])->name('movies.seasons.edit');
        Route::patch('seasons/{season}', [SeasonController::class, 'update'])->name('movies.seasons.update');
        Route::delete('seasons/{season}', [SeasonController::class, 'destroy'])->name('movies.seasons.destroy');

        // --- TẬP PHIM + SERVER + SUBTITLE ---
        Route::prefix('seasons/{season}')->name('seasons.')->group(function () {

            // Episode CRUD
            Route::get('episodes', [EpisodeController::class, 'index'])->name('episodes.index');
            Route::get('episodes/create', [EpisodeController::class, 'create'])->name('episodes.create');
            Route::post('episodes', [EpisodeController::class, 'store'])->name('episodes.store');
            Route::get('episodes/{episode}/edit', [EpisodeController::class, 'edit'])->name('episodes.edit');
            Route::patch('episodes/{episode}', [EpisodeController::class, 'update'])->name('episodes.update');
            Route::delete('episodes/{episode}', [EpisodeController::class, 'destroy'])->name('episodes.destroy');

            // SERVER & SUBTITLE (đúng tên route)
            Route::prefix('episodes/{episode}')->name('episodes.')->group(function () {

                // Server
                Route::get('servers', [EpisodeController::class, 'servers'])
                    ->name('servers'); // → admin.seasons.episodes.servers

                Route::get('servers/create', [EpisodeController::class, 'serverCreate'])
                    ->name('servers.create'); // → admin.seasons.episodes.servers.create

                Route::post('servers', [EpisodeController::class, 'serverStore'])
                    ->name('servers.store');

                Route::delete('servers/{server}', [EpisodeController::class, 'serverDestroy'])
                    ->name('servers.destroy');

                // Subtitle
                Route::get('subtitles', [EpisodeController::class, 'subtitles'])
                    ->name('subtitles');

                Route::get('subtitles/create', [EpisodeController::class, 'subtitleCreate'])
                    ->name('subtitles.create');

                Route::post('subtitles', [EpisodeController::class, 'subtitleStore'])
                    ->name('subtitles.store');

                Route::delete('subtitles/{subtitle}', [EpisodeController::class, 'subtitleDestroy'])
                    ->name('subtitles.destroy');
            });
        });
    });
});

// ==================== PUBLIC ROUTES ====================

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/phim/{slug}', [HomeController::class, 'show'])->name('movie.show');
Route::get('/xem-phim/{slug}', [HomeController::class, 'watch'])->name('movie.watch')->where('slug', '.*');
Route::get('/xem-phim/{slug}/{season}/{episode?}', [HomeController::class, 'watch'])->where(['season' => '[0-9]+', 'episode' => '[0-9]+'])
    ->name('movie.watch.episode');
Route::get('/the-loai/{slug}', [HomeController::class, 'show'])->name('genre.show');
Route::get('/quoc-gia/{slug}', [HomeController::class, 'show'])->name('country.show');
Route::get('/nam/{year}', [HomeController::class, 'show'])->name('year.show');
Route::get('/tim-kiem', [SearchController::class, 'index'])->name('search');

Route::middleware('auth')->group(function () {
    Route::post('/movie/{movie}/comment', [CommentController::class, 'storeComment'])->name('movie.comment');
    Route::post('/movie/{movie}/rate', [RatingController::class, 'rate'])->name('movie.rate');
});

// Bảng xếp hạng – trang chính
Route::get('/bang-xep-hang', [RankingController::class, 'index'])->name('ranking.index');
// Các tab chi tiết (tùy chọn, để SEO tốt hơn)
Route::get('/bang-xep-hang/phim-le', [RankingController::class, 'single'])->name('ranking.single');
Route::get('/bang-xep-hang/phim-bo', [RankingController::class, 'series'])->name('ranking.series');
Route::get('/bang-xep-hang/vip', [RankingController::class, 'vip'])->name('ranking.vip');