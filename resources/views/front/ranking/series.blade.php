@extends('front.layouts.app')

@section('title', 'Bảng Xếp Hạng Phim Bộ Hay Nhất - Top Hot')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-950 via-gray-900 to-black text-white py-12 md:py-20">
    
    <div class="container mx-auto px-4 md:px-6">
        
        <!-- Compact Header -->
        <div class="text-center mb-12 md:mb-16 space-y-4">
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-purple-600/20 border border-purple-500/30 rounded-full text-sm font-semibold text-purple-300 mb-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/>
                </svg>
                Series Hot Nhất
            </div>
            
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-black leading-tight">
                <span class="bg-gradient-to-r from-purple-400 via-pink-400 to-red-400 bg-clip-text text-transparent">
                    TOP PHIM BỘ
                </span>
            </h1>
            
            <p class="text-base md:text-lg text-gray-400 max-w-2xl mx-auto">
                Những series đỉnh cao đang làm mưa làm gió
            </p>
        </div>

        <!-- Top 3 Podium - Compact Design -->
        <div class="max-w-6xl mx-auto mb-16">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($topSeries->take(3) as $index => $movie)
                <div class="relative group {{ $index == 0 ? 'md:order-2 md:scale-105' : ($index == 1 ? 'md:order-1' : 'md:order-3') }}">
                    
                    <!-- Rank Badge -->
                    <div class="absolute -top-3 -right-3 z-20 w-12 h-12 rounded-full flex items-center justify-center font-black text-xl shadow-lg
                        {{ $index == 0 ? 'bg-gradient-to-br from-yellow-400 to-orange-500 ring-4 ring-yellow-400/30' : '' }}
                        {{ $index == 1 ? 'bg-gradient-to-br from-gray-300 to-gray-500 ring-4 ring-gray-300/30' : '' }}
                        {{ $index == 2 ? 'bg-gradient-to-br from-orange-600 to-red-700 ring-4 ring-orange-500/30' : '' }}">
                        {{ $index + 1 }}
                    </div>

                    <!-- Movie Card -->
                    <a href="{{ route('movie.watch', $movie->slug) }}"
                       class="block relative overflow-hidden rounded-2xl bg-gray-900/60 backdrop-blur border border-gray-800 hover:border-purple-500/50 transition-all duration-300 hover:shadow-2xl hover:shadow-purple-500/20 group">
                        
                        <!-- Poster -->
                        <div class="relative aspect-[2/3] overflow-hidden">
                            <img src="{{ $movie->poster ? asset($movie->poster) : asset('images/no-poster.jpg') }}"
                                 alt="{{ $movie->title }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                            
                            <!-- Overlay Gradient -->
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/50 to-transparent opacity-60"></div>
                            
                            <!-- Views Badge -->
                            <div class="absolute top-3 left-3 flex items-center gap-1.5 px-3 py-1.5 bg-black/70 backdrop-blur rounded-full text-xs font-semibold">
                                <svg class="w-3.5 h-3.5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                {{ number_format($movie->views) }}
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="p-4">
                            <h3 class="text-lg font-bold line-clamp-2 mb-2 group-hover:text-purple-400 transition-colors">
                                {{ $movie->title }}
                            </h3>
                            <div class="flex items-center gap-2 text-xs text-gray-400">
                                <span class="px-2 py-1 bg-purple-600/20 text-purple-300 rounded font-medium">Series</span>
                                <span>•</span>
                                <span>{{ $movie->year }}</span>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Rest of Rankings - Clean Grid -->
        <div>
            <div class="flex items-center gap-3 mb-6">
                <div class="h-0.5 flex-1 bg-gradient-to-r from-transparent via-gray-700 to-transparent"></div>
                <h2 class="text-xl font-bold text-gray-300">Xếp Hạng Từ #4</h2>
                <div class="h-0.5 flex-1 bg-gradient-to-r from-transparent via-gray-700 to-transparent"></div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-5">
                @foreach($topSeries->skip(3) as $index => $movie)
                <div class="group relative">
                    <!-- Rank Number -->
                    <div class="absolute -top-2 -left-2 z-20 w-8 h-8 bg-gradient-to-br from-gray-700 to-gray-900 border-2 border-gray-600 rounded-lg flex items-center justify-center font-bold text-sm shadow-lg">
                        {{ $index + 4 }}
                    </div>

                    <a href="{{ route('movie.watch', $movie->slug) }}"
                       class="block relative overflow-hidden rounded-xl bg-gray-900/40 backdrop-blur border border-gray-800 hover:border-purple-500/50 transition-all duration-300 hover:shadow-lg hover:shadow-purple-500/10 hover:-translate-y-1">
                        
                        <!-- Poster -->
                        <div class="relative aspect-[2/3] overflow-hidden">
                            <img src="{{ $movie->poster ? asset($movie->poster) : asset('images/no-poster.jpg') }}"
                                 alt="{{ $movie->title }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent opacity-60"></div>
                            
                            <!-- Views -->
                            <div class="absolute bottom-2 left-2 flex items-center gap-1 px-2 py-1 bg-black/70 backdrop-blur rounded text-xs font-medium">
                                <svg class="w-3 h-3 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                {{ number_format($movie->views) }}
                            </div>
                        </div>

                        <!-- Compact Info -->
                        <div class="p-3">
                            <h3 class="text-sm font-bold line-clamp-2 mb-1.5 group-hover:text-purple-400 transition-colors leading-snug">
                                {{ $movie->title }}
                            </h3>
                            <div class="flex items-center gap-1.5 text-xs text-gray-500">
                                <span class="px-1.5 py-0.5 bg-purple-600/20 text-purple-300 rounded text-xs">Series</span>
                                <span>•</span>
                                <span>{{ $movie->year }}</span>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Pagination -->
        @if($topSeries->hasPages())
        <div class="mt-12 flex justify-center">
            <div class="inline-flex items-center gap-2 p-2 bg-gray-900/60 backdrop-blur rounded-xl border border-gray-800">
                {{ $topSeries->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<style>
/* Custom pagination styling */
.pagination {
    @apply flex items-center gap-2;
}

.pagination a,
.pagination span {
    @apply px-4 py-2 rounded-lg text-sm font-medium transition-all;
}

.pagination a {
    @apply bg-gray-800 text-gray-300 hover:bg-purple-600 hover:text-white;
}

.pagination .active span {
    @apply bg-gradient-to-r from-purple-600 to-pink-600 text-white;
}

.pagination .disabled span {
    @apply bg-gray-800/50 text-gray-600 cursor-not-allowed;
}
</style>
@endsection