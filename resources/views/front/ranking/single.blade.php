@extends('front.layouts.app')

@section('title', 'Bảng Xếp Hạng Phim Lẻ Hay Nhất')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-950 via-blue-950/20 to-black text-white py-12 md:py-20">
    
    <!-- Animated Background -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-blue-500/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-cyan-500/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
    </div>

    <div class="container mx-auto px-4 md:px-6 relative z-10">
        
        <!-- Header Section -->
        <div class="text-center mb-12 md:mb-16 space-y-4">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600/20 border border-blue-500/30 rounded-full text-sm font-semibold text-blue-300 mb-3 animate-fade-in">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/>
                </svg>
                Blockbuster Đỉnh Cao
            </div>
            
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-black leading-tight animate-fade-in-up">
                <span class="bg-gradient-to-r from-blue-400 via-cyan-400 to-teal-400 bg-clip-text text-transparent drop-shadow-2xl">
                    TOP PHIM LẺ HAY NHẤT
                </span>
            </h1>
            
            <p class="text-base md:text-lg text-gray-400 max-w-2xl mx-auto animate-fade-in-up" style="animation-delay: 0.1s;">
                Những tác phẩm điện ảnh đỉnh cao được yêu thích nhất
            </p>

            <!-- Stats Bar -->
            <div class="flex items-center justify-center gap-6 md:gap-8 mt-6 animate-fade-in-up" style="animation-delay: 0.2s;">
                <div class="text-center">
                    <div class="text-2xl md:text-3xl font-black bg-gradient-to-r from-blue-400 to-cyan-400 bg-clip-text text-transparent">
                        {{ $topSingle->total() }}
                    </div>
                    <div class="text-xs text-gray-500 mt-1">Phim Lẻ</div>
                </div>
                <div class="h-10 w-px bg-gray-800"></div>
                <div class="text-center">
                    <div class="text-2xl md:text-3xl font-black bg-gradient-to-r from-cyan-400 to-teal-400 bg-clip-text text-transparent">
                        Top 100
                    </div>
                    <div class="text-xs text-gray-500 mt-1">Xếp Hạng</div>
                </div>
                <div class="h-10 w-px bg-gray-800"></div>
                <div class="text-center">
                    <div class="text-2xl md:text-3xl font-black bg-gradient-to-r from-teal-400 to-blue-400 bg-clip-text text-transparent">
                        HOT
                    </div>
                    <div class="text-xs text-gray-500 mt-1">Trending</div>
                </div>
            </div>
        </div>

        <!-- Featured Top 3 -->
        @if($topSingle->count() >= 3)
        <div class="mb-16 animate-fade-in" style="animation-delay: 0.3s;">
            <div class="flex items-center gap-3 mb-8">
                <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
                <h2 class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-orange-400">
                    TOP 3 XUẤT SẮC NHẤT
                </h2>
                <div class="h-px flex-1 bg-gradient-to-r from-yellow-600/50 to-transparent"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto">
                @foreach($topSingle->take(3) as $index => $movie)
                <div class="relative group {{ $index == 0 ? 'md:scale-105' : '' }}">
                    
                    <!-- Crown for #1 -->
                    @if($index == 0)
                    <div class="absolute -top-6 left-1/2 -translate-x-1/2 z-20 animate-bounce">
                        <svg class="w-12 h-12 text-yellow-400 drop-shadow-lg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2l2.5 7.5L22 12l-7.5 2.5L12 22l-2.5-7.5L2 12l7.5-2.5L12 2z"/>
                        </svg>
                    </div>
                    @endif

                    <!-- Rank Badge -->
                    <div class="absolute -top-4 -right-4 z-20 w-14 h-14 rounded-full flex items-center justify-center font-black text-2xl shadow-2xl
                        {{ $index == 0 ? 'bg-gradient-to-br from-yellow-400 via-yellow-500 to-orange-500 ring-4 ring-yellow-400/50 animate-pulse' : '' }}
                        {{ $index == 1 ? 'bg-gradient-to-br from-gray-300 via-gray-400 to-gray-500 ring-4 ring-gray-300/50' : '' }}
                        {{ $index == 2 ? 'bg-gradient-to-br from-orange-500 via-orange-600 to-red-600 ring-4 ring-orange-500/50' : '' }}">
                        {{ $index + 1 }}
                    </div>

                    <a href="{{ route('movie.watch', $movie->slug) }}"
                       class="block relative overflow-hidden rounded-2xl bg-gray-900/60 backdrop-blur-xl border-2 transition-all duration-500 hover:shadow-2xl hover:-translate-y-2
                        {{ $index == 0 ? 'border-yellow-500/50 hover:border-yellow-400 hover:shadow-yellow-500/30' : '' }}
                        {{ $index == 1 ? 'border-gray-500/50 hover:border-gray-400 hover:shadow-gray-400/30' : '' }}
                        {{ $index == 2 ? 'border-orange-500/50 hover:border-orange-400 hover:shadow-orange-500/30' : '' }}">
                        
                        <!-- Poster with Overlay -->
                        <div class="relative aspect-[2/3] overflow-hidden">
                            <img src="{{ $movie->poster ? asset($movie->poster) : asset('images/no-poster.jpg') }}"
                                 alt="{{ $movie->title }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                            
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/60 to-transparent"></div>
                            
                            <!-- Info Overlay -->
                            <div class="absolute inset-0 flex flex-col justify-end p-5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-gradient-to-t from-black/90 via-black/50 to-transparent">
                                <div class="space-y-2">
                                    @if($movie->imdb_score)
                                    <div class="flex items-center gap-2">
                                        <div class="flex items-center gap-1 px-3 py-1.5 bg-yellow-500/20 border border-yellow-500/50 rounded-full">
                                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                            </svg>
                                            <span class="text-sm font-bold text-yellow-300">{{ $movie->imdb_score }}</span>
                                        </div>
                                    </div>
                                    @endif
                                    @if($movie->year)
                                    <div class="text-xs text-gray-400">Năm: {{ $movie->year }}</div>
                                    @endif
                                </div>
                            </div>

                            <!-- Views Badge -->
                            <div class="absolute top-3 right-3 flex items-center gap-1.5 px-3 py-1.5 bg-black/80 backdrop-blur rounded-full text-xs font-semibold">
                                <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                {{ number_format($movie->views) }}
                            </div>
                        </div>

                        <!-- Card Info -->
                        <div class="p-5 space-y-3">
                            <h3 class="text-lg font-bold line-clamp-2 group-hover:text-blue-400 transition-colors leading-snug">
                                {{ $movie->title }}
                            </h3>
                            <div class="flex items-center gap-2 text-xs text-gray-400">
                                <span class="px-2 py-1 bg-blue-600/20 border border-blue-500/30 text-blue-300 rounded-full font-medium">Phim Lẻ</span>
                                @if($movie->duration)
                                <span>•</span>
                                <span>{{ $movie->duration }} phút</span>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Main Movie Grid -->
        <div class="animate-fade-in" style="animation-delay: 0.4s;">
            <div class="flex items-center gap-3 mb-6">
                <div class="h-0.5 flex-1 bg-gradient-to-r from-transparent via-blue-700/50 to-transparent"></div>
                <h2 class="text-xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400">
                    {{ $topSingle->count() > 3 ? 'Xếp Hạng Từ #4' : 'Tất Cả Phim Lẻ' }}
                </h2>
                <div class="h-0.5 flex-1 bg-gradient-to-r from-transparent via-blue-700/50 to-transparent"></div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-5">
                @foreach($topSingle->skip(3) as $index => $movie)
                <div class="group relative">
                    <!-- Rank Badge -->
                    <div class="absolute -top-2 -left-2 z-20 w-9 h-9 bg-gradient-to-br from-blue-600 to-cyan-600 border-2 border-blue-400/50 rounded-lg flex items-center justify-center font-bold text-sm shadow-lg">
                        {{ $index + 4 }}
                    </div>

                    <a href="{{ route('movie.watch', $movie->slug) }}"
                       class="block relative overflow-hidden rounded-xl bg-gray-900/40 backdrop-blur border border-gray-800 hover:border-blue-500/50 transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/20 hover:-translate-y-1">
                        
                        <!-- Poster -->
                        <div class="relative aspect-[2/3] overflow-hidden">
                            <img src="{{ $movie->poster ? asset($movie->poster) : asset('images/no-poster.jpg') }}"
                                 alt="{{ $movie->title }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent opacity-60"></div>
                            
                            <!-- Quick Info -->
                            <div class="absolute bottom-0 left-0 right-0 p-2 bg-gradient-to-t from-black/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                                @if($movie->imdb_score)
                                <div class="flex items-center gap-1 text-xs">
                                    <svg class="w-3 h-3 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                    </svg>
                                    <span class="text-yellow-300 font-bold">{{ $movie->imdb_score }}</span>
                                </div>
                                @endif
                            </div>

                            <!-- Views -->
                            <div class="absolute top-2 right-2 flex items-center gap-1 px-2 py-1 bg-black/70 backdrop-blur rounded text-xs font-medium">
                                <svg class="w-3 h-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                {{ number_format($movie->views) }}
                            </div>
                        </div>

                        <!-- Card Info -->
                        <div class="p-3">
                            <h3 class="text-sm font-bold line-clamp-2 mb-1.5 group-hover:text-blue-400 transition-colors leading-snug">
                                {{ $movie->title }}
                            </h3>
                            <div class="flex items-center gap-1.5 text-xs text-gray-500">
                                <span class="px-1.5 py-0.5 bg-blue-600/20 text-blue-300 rounded text-xs">Lẻ</span>
                                @if($movie->year)
                                <span>•</span>
                                <span>{{ $movie->year }}</span>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Pagination -->
        @if($topSingle->hasPages())
        <div class="mt-12 flex justify-center animate-fade-in" style="animation-delay: 0.5s;">
            <div class="inline-flex items-center gap-2 p-2 bg-gray-900/60 backdrop-blur-xl rounded-xl border border-gray-800 shadow-xl">
                {{ $topSingle->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes fade-in-up {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
    animation: fade-in 0.6s ease-out forwards;
}

.animate-fade-in-up {
    animation: fade-in-up 0.8s ease-out forwards;
    opacity: 0;
}

/* Custom pagination styling */
.pagination {
    @apply flex items-center gap-2;
}

.pagination a,
.pagination span {
    @apply px-4 py-2 rounded-lg text-sm font-medium transition-all;
}

.pagination a {
    @apply bg-gray-800 text-gray-300 hover:bg-blue-600 hover:text-white hover:scale-105;
}

.pagination .active span {
    @apply bg-gradient-to-r from-blue-600 to-cyan-600 text-white shadow-lg;
}

.pagination .disabled span {
    @apply bg-gray-800/50 text-gray-600 cursor-not-allowed;
}
</style>
@endsection