{{-- resources/views/components/movie-card.blade.php --}}
@props(['movie', 'showEpisodeCount' => false, 'showViews' => false, 'rank' => null])

<div class="group relative">
    {{-- Rank Badge (if provided) --}}
    @if($rank)
    <div class="absolute -top-2 -left-2 z-30 w-8 h-8 flex items-center justify-center font-bold text-sm shadow-xl rounded-lg
        {{ $rank == 1 ? 'bg-gradient-to-br from-yellow-400 to-orange-500 ring-2 ring-yellow-400/50 text-white' : '' }}
        {{ $rank == 2 ? 'bg-gradient-to-br from-gray-300 to-gray-500 ring-2 ring-gray-300/50 text-white' : '' }}
        {{ $rank == 3 ? 'bg-gradient-to-br from-orange-500 to-red-600 ring-2 ring-orange-400/50 text-white' : '' }}
        {{ $rank > 3 ? 'bg-gradient-to-br from-gray-700 to-gray-900 border-2 border-gray-600 text-gray-200' : '' }}">
        {{ $rank }}
    </div>
    @endif

    <a href="{{ route('movie.show', $movie->slug) }}"
       class="block relative overflow-hidden rounded-xl bg-gray-900/40 backdrop-blur border border-gray-800 hover:border-purple-500/60 transition-all duration-500 hover:shadow-2xl hover:shadow-purple-500/30 hover:-translate-y-2">

        <div class="relative aspect-[2/3] overflow-hidden bg-gray-800">
            {{-- Poster Image --}}
            <img src="{{ $movie->poster ? asset($movie->poster) : asset('images/no-poster.jpg') }}"
                 alt="{{ $movie->title }}"
                 loading="lazy"
                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">

            {{-- Base Gradient Overlay --}}
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/50 to-transparent opacity-70"></div>

            {{-- Hover Overlay with Enhanced Info --}}
            <div class="absolute inset-0 bg-gradient-to-t from-black/95 via-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <div class="absolute bottom-0 left-0 right-0 p-4 space-y-2">
                    {{-- Title --}}
                    <h3 class="font-bold text-sm md:text-base line-clamp-2 leading-snug text-white drop-shadow-lg">
                        {{ $movie->title }}
                    </h3>
                    
                    {{-- Meta Info --}}
                    <div class="flex flex-wrap items-center gap-2 text-xs text-gray-300">
                        {{-- Year --}}
                        @if($movie->year)
                        <span class="flex items-center gap-1 px-2 py-0.5 bg-white/10 rounded">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ $movie->year }}
                        </span>
                        @endif

                        {{-- Type --}}
                        <span class="px-2 py-0.5 rounded font-medium
                            {{ $movie->type == 1 ? 'bg-blue-600/30 text-blue-300 border border-blue-500/50' : 'bg-purple-600/30 text-purple-300 border border-purple-500/50' }}">
                            {{ $movie->type == 1 ? 'Phim lẻ' : 'Phim bộ' }}
                        </span>

                        {{-- Views --}}
                        @if($showViews)
                        <span class="flex items-center gap-1 px-2 py-0.5 bg-white/10 rounded">
                            <svg class="w-3 h-3 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            {{ number_format($movie->views ?? 0) }}
                        </span>
                        @endif

                        {{-- Episodes Count --}}
                        @if($showEpisodeCount && $movie->type == 2)
                        <span class="flex items-center gap-1 px-2 py-0.5 bg-white/10 rounded">
                            <svg class="w-3 h-3 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            {{ $movie->episodes_count ?? $movie->seasons->sum(fn($s) => $s->episodes->count()) }} tập
                        </span>
                        @endif
                    </div>

                    {{-- IMDb Score (if available) --}}
                    @if(isset($movie->imdb_score) && $movie->imdb_score)
                    <div class="flex items-center gap-1.5 pt-1">
                        <div class="flex items-center gap-1 px-2 py-1 bg-yellow-500/20 border border-yellow-500/50 rounded">
                            <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>
                            <span class="text-xs font-bold text-yellow-300">{{ $movie->imdb_score }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Top Right Badges Container --}}
            <div class="absolute top-2 right-2 flex flex-col gap-2 z-20">
                {{-- HOT Badge --}}
                @if($movie->is_hot ?? false)
                <div class="flex items-center gap-1 px-2.5 py-1 bg-gradient-to-r from-red-600 to-pink-600 rounded-lg shadow-lg animate-pulse">
                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 23s-8-4.5-8-11.8A8 8 0 0 1 12 3a8 8 0 0 1 8 8.2c0 7.3-8 11.8-8 11.8z"/>
                    </svg>
                    <span class="text-white text-xs font-black">HOT</span>
                </div>
                @endif

                {{-- Episode Count Badge (Series only) --}}
                @if($showEpisodeCount && $movie->type == 2)
                <div class="px-2.5 py-1 bg-purple-600 backdrop-blur-sm rounded-lg shadow-lg">
                    <span class="text-white text-xs font-bold">
                        {{ $movie->episodes_count ?? $movie->seasons->sum(fn($s) => $s->episodes->count()) }} TẬP
                    </span>
                </div>
                @endif
            </div>

            {{-- Bottom Left Badges Container --}}
            <div class="absolute bottom-2 left-2 flex flex-wrap gap-2 z-20">
                {{-- VIP/Featured Badge --}}
                @if($movie->is_featured ?? false)
                <div class="flex items-center gap-1 px-2.5 py-1 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-lg shadow-lg">
                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    <span class="text-white text-xs font-black">VIP</span>
                </div>
                @endif

                {{-- Quality Badge (if available) --}}
                @if(isset($movie->quality) && $movie->quality)
                <div class="px-2.5 py-1 bg-green-600/90 backdrop-blur-sm rounded-lg shadow-lg">
                    <span class="text-white text-xs font-bold">{{ $movie->quality }}</span>
                </div>
                @endif
            </div>

            {{-- Glow Effect on Hover --}}
            <div class="absolute inset-0 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                <div class="absolute inset-0 rounded-xl ring-1 ring-purple-500/50 shadow-lg shadow-purple-500/30"></div>
            </div>
        </div>

        {{-- Quick Info Bar (Visible on mobile, hidden on hover) --}}
        <div class="md:hidden p-3 group-hover:hidden">
            <h3 class="font-bold text-sm line-clamp-2 leading-snug text-white mb-1">
                {{ $movie->title }}
            </h3>
            <div class="flex items-center gap-2 text-xs text-gray-400">
                <span>{{ $movie->year }}</span>
                @if($showViews)
                <span>•</span>
                <span>{{ number_format($movie->views ?? 0) }} lượt</span>
                @endif
            </div>
        </div>
    </a>
</div>

<style>
/* Ensure smooth animations */
.group:hover img {
    transform: scale(1.1);
}

/* Stagger animation for cards in grid */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>