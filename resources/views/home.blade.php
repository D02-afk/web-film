@extends('front.layouts.app')

@section('content')
<div class="text-white">
    <!-- HERO SECTION -->
    <section class="relative h-screen flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 hero-bg"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-black via-transparent to-transparent"></div>

        <div class="absolute bottom-0 left-0 w-full h-96 bg-gradient-to-t from-primary/30 to-transparent blur-3xl">
        </div>

        <div class="relative z-10 text-center px-6 max-w-4xl mx-auto">
            <h1 class="text-5xl md:text-7xl font-black leading-tight mb-6">
                <span class="bg-gradient-to-r from-white via-primary to-pink-400 bg-clip-text text-transparent">
                    {{ setting('hero_title', 'FilmMWE') }}
                </span>
            </h1>
            <p class="text-lg md:text-xl text-gray-300 mb-10 max-w-2xl mx-auto">
                {{ setting('hero_description', 'Xem phim hay nhất 2025 – Full HD – Vietsub & Thuyết minh') }}
            </p>
            <a href="#new-movies"
                class="inline-flex items-center gap-3 bg-white text-black px-10 py-5 rounded-full text-lg font-bold hover:scale-105 transition shadow-2xl">
                <i class="fas fa-play"></i> Xem Ngay
            </a>
        </div>

        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </div>
    </section>

    <!-- CÁC SECTION PHIM -->
    <div class="container mx-auto px-4 md:px-6 py-16 md:py-24 space-y-16 md:space-y-24">

        <!-- Phim Mới Cập Nhật -->
        @if($show['new'] && $newMovies->count())
        <section id="new-movies" class="scroll-mt-20">
            <div class="flex items-center justify-between mb-8 md:mb-10">
                <div class="flex items-center gap-4">
                    <div class="w-1.5 h-12 bg-gradient-to-b from-purple-500 to-pink-500 rounded-full"></div>
                    <div>
                        <h2 class="text-2xl md:text-4xl font-black text-white">Phim Mới Cập Nhật</h2>
                        <p class="text-sm text-gray-400 mt-1">Cập nhật liên tục mỗi ngày</p>
                    </div>
                </div>
                <a href="#" class="hidden sm:inline-flex items-center gap-2 text-purple-400 hover:text-purple-300 font-semibold transition-colors group">
                    Xem Tất Cả
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-8 gap-3 md:gap-5">
                @foreach($newMovies as $movie)
                <x-movie-card :movie="$movie" showEpisodeCount />
                @endforeach
            </div>
        </section>
        @endif

        <!-- Phim 2025 -->
        @if($movies2025->count())
        <section class="scroll-mt-20">
            <div class="flex items-center justify-between mb-8 md:mb-10">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-500 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2zm9 7h-6v13h-2v-6h-2v6H9V9H3V7h18v2z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl md:text-4xl font-black bg-gradient-to-r from-orange-400 to-red-400 bg-clip-text text-transparent">
                            Phim Hay 2025
                        </h2>
                        <p class="text-sm text-gray-400 mt-1">Bom tấn mới nhất năm nay</p>
                    </div>
                </div>
                <a href="#" class="hidden sm:inline-flex items-center gap-2 text-orange-400 hover:text-orange-300 font-semibold transition-colors group">
                    Xem Tất Cả
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-8 gap-3 md:gap-5">
                @foreach($movies2025 as $movie)
                <x-movie-card :movie="$movie" />
                @endforeach
            </div>
        </section>
        @endif

        <!-- Phim Lẻ Hot Nhất -->
        @if($hotSingleMovies->count())
        <section id="phim-le" class="scroll-mt-20">
            <div class="flex items-center justify-between mb-8 md:mb-10">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl md:text-4xl font-black bg-gradient-to-r from-blue-400 to-cyan-400 bg-clip-text text-transparent">
                            Phim Lẻ Được Xem Nhiều Nhất
                        </h2>
                        <p class="text-sm text-gray-400 mt-1">Blockbuster đỉnh cao</p>
                    </div>
                </div>
                <a href="#" class="hidden sm:inline-flex items-center gap-2 text-blue-400 hover:text-blue-300 font-semibold transition-colors group">
                    Xem Tất Cả
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-8 gap-3 md:gap-5">
                @foreach($hotSingleMovies as $movie)
                <x-movie-card :movie="$movie" showViews />
                @endforeach
            </div>
        </section>
        @endif

        <!-- Phim Bộ Hot Nhất -->
        @if($hotSeriesMovies->count())
        <section id="phim-bo" class="scroll-mt-20">
            <div class="flex items-center justify-between mb-8 md:mb-10">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl md:text-4xl font-black bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent">
                            Phim Bộ Hot Trong Tuần
                        </h2>
                        <p class="text-sm text-gray-400 mt-1">Series đang gây bão</p>
                    </div>
                </div>
                <a href="#" class="hidden sm:inline-flex items-center gap-2 text-purple-400 hover:text-purple-300 font-semibold transition-colors group">
                    Xem Tất Cả
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-8 gap-3 md:gap-5">
                @foreach($hotSeriesMovies as $movie)
                <x-movie-card :movie="$movie" showEpisodeCount showViews />
                @endforeach
            </div>
        </section>
        @endif

        <!-- Anime -->
        @if($animeMovies->count())
        <section id="phim-anime" class="scroll-mt-20">
            <div class="flex items-center justify-between mb-8 md:mb-10">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-rose-500 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-5-9h2v2H7v-2zm8 0h2v2h-2v-2zm-4 4h2v-2h-2v2z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl md:text-4xl font-black bg-gradient-to-r from-pink-400 to-rose-400 bg-clip-text text-transparent">
                            Anime Nhật Bản Mới Nhất
                        </h2>
                        <p class="text-sm text-gray-400 mt-1">Thế giới hoạt hình Nhật Bản</p>
                    </div>
                </div>
                <a href="#" class="hidden sm:inline-flex items-center gap-2 text-pink-400 hover:text-pink-300 font-semibold transition-colors group">
                    Xem Tất Cả
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-8 gap-3 md:gap-5">
                @foreach($animeMovies as $movie)
                <x-movie-card :movie="$movie" showEpisodeCount />
                @endforeach
            </div>
        </section>
        @endif
    </div>
</div>
@endsection