{{-- resources/views/front/movie/watch.blade.php --}}
@extends('front.layouts.app')

@section('title', 'Xem phim ' . $movie->title . ($movie->type == 2 ? ' - Tập ' . $currentEpisode->episode_number : ''))
@section('description', Str::limit(strip_tags($movie->description), 155))

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-950 via-black to-gray-950 text-white">

    {{-- VIDEO PLAYER - FULL RESPONSIVE --}}
    <div class="relative bg-black">
        <div class="container mx-auto px-2 sm:px-4 lg:px-6 xl:px-8 pt-2 sm:pt-4 pb-3 sm:pb-6">
            <div
                class="aspect-video bg-black rounded-lg sm:rounded-xl lg:rounded-2xl overflow-hidden shadow-2xl relative group">
                <!-- Glow effect -->
                <div
                    class="absolute -inset-2 sm:-inset-4 bg-gradient-to-r from-primary/10 via-purple-600/10 to-pink-600/10 blur-2xl sm:blur-3xl opacity-0 group-hover:opacity-60 transition-opacity duration-500 pointer-events-none">
                </div>

                @if($activeServer?->video_url)
                <iframe src="{{ $activeServer->video_url }}?t={{ now()->timestamp }}"
                    class="absolute inset-0 w-full h-full" allowfullscreen
                    allow="autoplay; encrypted-media; picture-in-picture; fullscreen" frameborder="0"
                    loading="lazy"></iframe>

                <!-- Overlay controls -->
                <div
                    class="absolute top-0 left-0 right-0 p-3 sm:p-4 bg-gradient-to-b from-black/90 via-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10">
                    <div class="flex items-start justify-between gap-2">
                        <div class="flex-1 min-w-0">
                            <h2 class="text-sm sm:text-base lg:text-xl font-bold truncate">{{ $movie->title }}</h2>
                            @if($movie->type == 2)
                            <p class="text-xs sm:text-sm text-gray-300">Tập {{ $currentEpisode->episode_number }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                @if($activeServer->quality)
                <div
                    class="absolute top-2 sm:top-3 left-2 sm:left-3 bg-gradient-to-r from-red-600 to-pink-600 px-2 py-1 sm:px-3 sm:py-1.5 rounded-md sm:rounded-lg text-[10px] sm:text-xs font-bold z-10 shadow-lg">
                    {{ $activeServer->quality }}
                </div>
                @endif
                @else
                <div
                    class="flex flex-col items-center justify-center h-full bg-gradient-to-br from-gray-900 to-black p-4">
                    <i class="fas fa-video-slash text-4xl sm:text-6xl lg:text-8xl text-gray-700 mb-4 animate-pulse"></i>
                    <p class="text-base sm:text-xl lg:text-2xl font-bold text-gray-300 text-center">Đang cập nhật link
                        phim</p>
                    <p class="text-gray-500 mt-2 text-xs sm:text-sm">Vui lòng thử server khác</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="container mx-auto px-2 sm:px-4 lg:px-6 xl:px-8 py-4 sm:py-6 lg:py-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 sm:gap-6 lg:gap-8">

            {{-- LEFT: Poster + Stats --}}
            <div class="hidden lg:block lg:col-span-4 xl:col-span-3">
                <div class="sticky top-20 space-y-4">
                    <div class="relative group">
                        <img src="{{ $movie->poster ? asset($movie->poster) : asset('images/no-poster.jpg') }}"
                            alt="{{ $movie->title }}"
                            class="w-full rounded-xl shadow-2xl border-2 border-gray-800 group-hover:border-primary/50 transition-colors duration-300">

                        @if($movie->is_featured ?? false)
                        <div
                            class="absolute -top-2 -right-2 bg-gradient-to-r from-red-600 to-pink-600 px-3 py-1.5 rounded-lg font-white text-xs shadow-xl animate-pulse">
                            HOT
                        </div>
                        @endif
                    </div>

                    <!-- Quick Stats -->
                    <div class="grid grid-cols-2 gap-3">
                        <div
                            class="bg-gradient-to-br from-gray-800/80 to-gray-900/80 backdrop-blur rounded-lg p-4 text-center border border-gray-700/50 hover:border-primary/30 transition-colors">
                            <i class="fas fa-eye text-cyan-400 text-xl mb-2"></i>
                            <p class="text-[10px] text-gray-400 uppercase tracking-wide">Lượt xem</p>
                            <p class="text-base font-bold mt-1">{{ number_format($movie->views ?? 0) }}</p>
                        </div>
                        <div
                            class="bg-gradient-to-br from-gray-800/80 to-gray-900/80 backdrop-blur rounded-lg p-4 text-center border border-gray-700/50 hover:border-primary/30 transition-colors">
                            <i class="fas fa-star text-yellow-400 text-xl mb-2"></i>
                            <p class="text-[10px] text-gray-400 uppercase tracking-wide">IMDb</p>
                            <p class="text-base font-bold mt-1">{{ $movie->imdb_score ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT: Info + Controls -->
            <div class="lg:col-span-8 xl:col-span-9 space-y-3 sm:space-y-6">
                {{-- Mobile Poster --}}
                <div class="lg:hidden flex gap-2 sm:gap-4">
                    <div class="relative w-20 sm:w-32 flex-shrink-0">
                        <img src="{{ $movie->poster ? asset($movie->poster) : asset('images/no-poster.jpg') }}"
                            alt="{{ $movie->title }}"
                            class="w-full rounded-md sm:rounded-lg shadow-xl border-2 border-gray-800">
                        @if($movie->is_featured ?? false)
                        <div
                            class="absolute -top-1 -right-1 bg-gradient-to-r from-red-600 to-pink-600 px-1.5 py-0.5 rounded text-[8px] font-bold text-white shadow-lg">
                            HOT
                        </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <h1
                            class="text-base sm:text-2xl font-black text-white uppercase bg-gradient-to-r from-primary to-pink-500 bg-clip-text leading-tight mb-1 sm:mb-2">
                            {{ $movie->title }}
                        </h1>
                        @if($movie->origin_name && $movie->origin_name != $movie->title)
                        <p class="text-[10px] sm:text-sm text-gray-400 italic mb-1 sm:mb-2 truncate">
                            {{ $movie->origin_name }}</p>
                        @endif
                        <!-- Mobile Stats -->
                        <div class="flex gap-2 sm:gap-3 mb-1">
                            <div class="flex items-center gap-1 text-[10px] sm:text-xs text-gray-400">
                                <i class="fas fa-eye text-cyan-400"></i>
                                <span>{{ number_format($movie->views ?? 0) }}</span>
                            </div>
                            <div class="flex items-center gap-1 text-[10px] sm:text-xs text-gray-400">
                                <i class="fas fa-star text-yellow-400"></i>
                                <span>{{ $movie->imdb_score ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Desktop Title --}}
                <div class="hidden lg:block">
                    <h1
                        class="text-2xl lg:text-4xl xl:text-5xl font-black text-white uppercase bg-gradient-to-r from-primary to-pink-500 bg-clip-text leading-tight">
                        {{ $movie->title }}
                    </h1>
                    @if($movie->origin_name && $movie->origin_name != $movie->title)
                    <p class="text-base lg:text-lg xl:text-xl text-white italic mt-2">{{ $movie->origin_name }}</p>
                    @endif
                </div>

                {{-- Tags --}}
                <div class="flex flex-wrap gap-1 sm:gap-2">
                    <span
                        class="px-2 sm:px-3 py-0.5 sm:py-1.5 bg-blue-600/30 backdrop-blur rounded text-[9px] sm:text-xs font-bold border border-blue-500/20">
                        {{ $movie->type == 1 ? 'Phim lẻ' : 'Phim bộ' }}
                    </span>
                    <span
                        class="px-2 sm:px-3 py-0.5 sm:py-1.5 bg-gray-800/70 backdrop-blur rounded text-[9px] sm:text-xs border border-gray-700/50">
                        {{ $movie->year }}
                    </span>
                    <span
                        class="px-2 sm:px-3 py-0.5 sm:py-1.5 bg-green-600/30 backdrop-blur rounded text-[9px] sm:text-xs border border-green-500/20">
                        {{ $movie->quality ?? 'FullHD' }}
                    </span>
                    <span
                        class="px-2 sm:px-3 py-0.5 sm:py-1.5 bg-cyan-600/30 backdrop-blur rounded text-[9px] sm:text-xs border border-cyan-500/20">
                        {{ $movie->language ?? 'Vietsub' }}
                    </span>
                </div>

                {{-- Control Panel: Server + Episodes --}}
                <div class="bg-gradient-to-br from-gray-900/80 to-gray-800/80 backdrop-blur-xl rounded-lg lg:rounded-2xl border border-gray-700/50 overflow-hidden shadow-xl"
                    x-data="{ open: true }">
                    <button @click="open = !open"
                        class="w-full px-3 sm:px-4 lg:px-5 py-2.5 sm:py-4 flex items-center justify-between hover:bg-gray-800/50 transition-colors">
                        <div class="flex items-center gap-1.5 sm:gap-3">
                            <i class="fas fa-play-circle text-primary text-sm sm:text-xl"></i>
                            <span class="font-bold text-[11px] sm:text-sm lg:text-base">Chọn server & tập phim</span>
                            @if($movie->type == 2)
                            <span class="text-[9px] sm:text-xs text-gray-400">• Tập
                                {{ $currentEpisode->episode_number }}</span>
                            @endif
                        </div>
                        <i :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"
                            class="fas text-gray-400 text-[10px] sm:text-sm"></i>
                    </button>

                    <div x-show="open" x-transition x-cloak>
                        <div class="border-t border-gray-700/50 p-2.5 sm:p-4 lg:p-5 space-y-3 sm:space-y-5">

                            {{-- Servers --}}
                            <div>
                                <h3
                                    class="text-[9px] sm:text-xs font-bold text-gray-400 uppercase tracking-wide mb-1.5 sm:mb-3">
                                    Server</h3>
                                <div
                                    class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-1.5 sm:gap-2">
                                    @foreach($currentEpisode->servers as $server)
                                    @if($server->video_url)
                                    <a href="{{ route('movie.watch', $movie->slug) }}?ep={{ $currentEpisode->id }}&server={{ $server->id }}"
                                        class="btn-server {{ $server->id == ($activeServer?->id) ? 'active' : '' }}">
                                        <span
                                            class="block text-[9px] sm:text-xs font-semibold truncate">{{ $server->name ?? 'Server ' . $loop->iteration }}</span>
                                        @if($server->quality)<small
                                            class="text-[8px] sm:text-[10px] opacity-75">{{ $server->quality }}</small>@endif
                                    </a>
                                    @endif
                                    @endforeach
                                </div>
                            </div>

                            {{-- Episodes (Phim bộ) --}}
                            @if($movie->type == 2)
                            <div>
                                <h3
                                    class="text-[9px] sm:text-xs font-bold text-gray-400 uppercase tracking-wide mb-1.5 sm:mb-3">
                                    Tập phim</h3>
                                <div
                                    class="grid grid-cols-8 sm:grid-cols-10 md:grid-cols-12 lg:grid-cols-14 xl:grid-cols-16 gap-1 sm:gap-2">
                                    @foreach($currentEpisode->season->episodes->sortBy('episode_number') as $ep)
                                    <a href="{{ route('movie.watch', $movie->slug) }}?ep={{ $ep->id }}"
                                        class="episode-btn {{ $ep->id == $currentEpisode->id ? 'active' : '' }}">
                                        {{ $ep->episode_number }}
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Description --}}
                <div
                    class="bg-gradient-to-br from-gray-900/70 to-gray-800/70 backdrop-blur-xl rounded-lg lg:rounded-2xl p-2.5 sm:p-4 lg:p-5 border border-gray-700/50 shadow-lg">
                    <h3
                        class="font-bold text-[11px] sm:text-base lg:text-lg mb-1.5 sm:mb-3 flex items-center gap-1.5 sm:gap-2">
                        <i class="fas fa-align-left text-primary text-[10px] sm:text-sm"></i>
                        Nội dung phim
                    </h3>
                    <p class="text-gray-300 leading-relaxed text-[10px] sm:text-sm lg:text-base">
                        <span id="short-desc">{{ Str::limit(strip_tags($movie->description), 200) }}</span>
                        @if(strlen(strip_tags($movie->description)) > 200)
                        <span id="full-desc" class="hidden">{!! nl2br(e(strip_tags($movie->description))) !!}</span>
                        <button
                            onclick="document.getElementById('short-desc').classList.add('hidden'); document.getElementById('full-desc').classList.remove('hidden'); this.remove();"
                            class="text-primary text-[10px] sm:text-sm font-semibold mt-1 sm:mt-2 inline-flex items-center gap-1 hover:gap-2 transition-all">
                            Xem thêm <i class="fas fa-chevron-right text-[8px] sm:text-[10px]"></i>
                        </button>
                        @endif
                    </p>
                </div>

                {{-- Genres & Country --}}
                <div>
                    <h3
                        class="text-[9px] sm:text-xs font-bold text-gray-400 uppercase tracking-wide mb-1.5 sm:mb-3 flex items-center gap-1.5 sm:gap-2">
                        <i class="fas fa-tags text-primary text-[10px] sm:text-xs"></i>
                        Thể loại
                    </h3>
                    <div class="flex flex-wrap gap-1 sm:gap-2">
                        @foreach($movie->genres as $genre)
                        <a href="{{ route('genre.show', $genre->slug) }}" class="tag">{{ $genre->name }}</a>
                        @endforeach
                        <span class="tag opacity-70">{{ $movie->country?->name ?? 'Không rõ' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Floating Next Episode Button --}}
    @if($movie->type == 2 &&
    optional($currentEpisode->season->episodes->sortBy('episode_number')->where('episode_number', '>',
    $currentEpisode->episode_number)->first())->exists())
    <div class="fixed bottom-4 sm:bottom-6 left-1/2 -translate-x-1/2 z-50 lg:hidden px-4 w-full max-w-md">
        <a href="{{ route('movie.watch', $movie->slug) }}?ep={{ $currentEpisode->season->episodes->sortBy('episode_number')->where('episode_number', '>', $currentEpisode->episode_number)->first()->id }}"
            class="w-full bg-gradient-to-r from-primary via-purple-600 to-pink-600 px-4 sm:px-6 py-3 sm:py-4 rounded-full font-bold text-sm sm:text-base shadow-2xl flex items-center justify-center gap-2 sm:gap-3 hover:scale-105 transition-all duration-300 border border-white/10">
            <i class="fas fa-play text-sm sm:text-base"></i>
            <span>Tập tiếp theo</span>
            <span class="bg-white/20 px-2.5 py-1 rounded-full text-xs sm:text-sm font-bold">
                {{ $currentEpisode->episode_number + 1 }}
            </span>
        </a>
    </div>
    @endif

    {{-- Rating & Comments --}}
    <div class="container mx-auto px-2 sm:px-4 lg:px-6 xl:px-8 py-6 sm:py-8">
        @include('front.partials.rating-comment', ['movie' => $movie])
    </div>

    {{-- Recommendations --}}
    <div class="bg-gradient-to-t from-black via-gray-950 to-transparent pt-8 sm:pt-12 pb-6 sm:pb-10">
        <div class="container mx-auto px-2 sm:px-4 lg:px-6 xl:px-8 space-y-8 sm:space-y-12">
            <x-movie-section title="Cùng thể loại" :movies="$sameGenres" icon="fas fa-layer-group"
                color="from-pink-600 to-rose-600" />
            <x-movie-section title="Có thể bạn thích" :movies="$randomPick" icon="fas fa-heart"
                color="from-red-600 to-pink-600" />
        </div>
    </div>
</div>

{{-- CSS Tối ưu Responsive --}}
<style>
.btn-server {
    @apply block p-2 sm: p-2.5 lg:p-3 rounded-lg text-center text-[10px] sm:text-xs font-medium transition-all duration-300 backdrop-blur border border-gray-700/50;
    background: linear-gradient(135deg, rgba(31, 41, 55, 0.8), rgba(17, 24, 39, 0.8));
}

.btn-server.active {
    @apply bg-gradient-to-br from-primary via-purple-600 to-pink-600 text-white shadow-lg ring-2 ring-primary/50 scale-105 border-transparent;
}

.btn-server:hover:not(.active) {
    @apply bg-gray-700/80 border-gray-600/50 scale-105;
}

.episode-btn {
    @apply aspect-square flex items-center justify-center rounded-md sm: rounded-lg text-[10px] sm:text-xs font-bold transition-all duration-300 backdrop-blur border border-gray-700/50;
    background: linear-gradient(135deg, rgba(31, 41, 55, 0.8), rgba(17, 24, 39, 0.8));
}

.episode-btn.active {
    @apply bg-gradient-to-br from-primary via-purple-600 to-pink-600 text-white shadow-lg ring-2 ring-primary/50 scale-110 border-transparent;
}

.episode-btn:hover:not(.active) {
    @apply bg-primary/60 scale-105 border-primary/30;
}

.tag {
    @apply px-2 sm: px-3 py-1 sm:py-1.5 bg-gray-800/70 backdrop-blur rounded-lg text-[10px] sm:text-xs border border-gray-700/50 hover:border-primary/50 hover:bg-gray-700/70 transition-all;
}
</style>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection