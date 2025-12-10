@props([
    'title' => null,
    'movies' => collect(),
    'icon' => null
])

<div class="mb-20">
    @if($title)
        <div class="flex items-center gap-4 mb-8">
            @if($icon === 'vip')
                <i class="fas fa-crown text-4xl text-yellow-500"></i>
            @elseif($icon === 'heart')
                <i class="fas fa-heart text-4xl text-red-500"></i>
            @elseif($icon === 'fire')
                <i class="fas fa-fire text-4xl text-orange-500"></i>
            @else
                <i class="fas fa-trophy text-4xl text-yellow-400"></i>
            @endif
            <h2 class="text-4xl font-black text-white">
                {{ $title }}
            </h2>
        </div>
    @endif

    @if($movies->count() > 0)
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-4 md:gap-5">
            @foreach($movies as $index => $movie)
                <div class="group relative animate-fade-in" style="animation-delay:{{ $index * 0.05 }};">
                    <!-- Rank Badge -->
                    @if($loop->iteration <= 10)
                    <div class="absolute -top-2 -left-2 z-20 w-9 h-9 flex items-center justify-center font-bold text-sm shadow-xl rounded-lg
                        {{ $loop->iteration == 1 ? 'bg-gradient-to-br from-yellow-400 to-orange-500 ring-2 ring-yellow-400/50 text-white' : '' }}
                        {{ $loop->iteration == 2 ? 'bg-gradient-to-br from-gray-300 to-gray-500 ring-2 ring-gray-300/50 text-white' : '' }}
                        {{ $loop->iteration == 3 ? 'bg-gradient-to-br from-orange-500 to-red-600 ring-2 ring-orange-400/50 text-white' : '' }}
                        {{ $loop->iteration > 3 ? 'bg-gradient-to-br from-gray-700 to-gray-900 border-2 border-gray-600 text-gray-200' : '' }}">
                        {{ $loop->iteration }}
                    </div>
                    @endif

                    <a href="{{ route('movie.watch', $movie->slug) }}"
                       class="block relative overflow-hidden rounded-xl bg-gray-900/40 backdrop-blur border border-gray-800 hover:border-purple-500/60 transition-all duration-300 hover:shadow-xl hover:shadow-purple-500/20 hover:-translate-y-2">
                        
                        <!-- Poster Container -->
                        <div class="relative aspect-[2/3] overflow-hidden bg-gray-800">
                            <img src="{{ $movie->poster ? asset($movie->poster) : asset('images/no-poster.jpg') }}"
                                 alt="{{ $movie->title }}"
                                 loading="lazy"
                                 class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                            
                            <!-- Gradient Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent opacity-70"></div>
                            
                            <!-- Hover Overlay with Info -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/95 via-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-3">
                                <div class="space-y-2">
                                    <!-- IMDb Score -->
                                    @if(isset($movie->imdb_score) && $movie->imdb_score)
                                    <div class="flex items-center gap-1.5">
                                        <div class="flex items-center gap-1 px-2 py-1 bg-yellow-500/20 border border-yellow-500/50 rounded-md">
                                            <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                            </svg>
                                            <span class="text-xs font-bold text-yellow-300">{{ $movie->imdb_score }}</span>
                                        </div>
                                    </div>
                                    @endif
                                    
                                    <!-- Additional Info -->
                                    @if(isset($movie->year) && $movie->year)
                                    <div class="text-xs text-gray-400">{{ $movie->year }}</div>
                                    @endif

                                    @if(isset($movie->duration) && $movie->duration)
                                    <div class="text-xs text-gray-400">{{ $movie->duration }} phút</div>
                                    @endif
                                </div>
                            </div>

                            <!-- Top Badges -->
                            <div class="absolute top-2 right-2 flex flex-col gap-2">
                                <!-- Views Badge -->
                                @if(isset($movie->views) && $movie->views)
                                <div class="flex items-center gap-1 px-2 py-1 bg-black/80 backdrop-blur-sm rounded-md text-xs font-medium">
                                    <svg class="w-3 h-3 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <span>{{ number_format($movie->views) }}</span>
                                </div>
                                @endif

                                <!-- VIP Badge -->
                                @if(isset($movie->is_vip) && $movie->is_vip)
                                <div class="px-2 py-1 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-md">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                </div>
                                @endif

                                <!-- Hot Badge -->
                                @if(isset($movie->is_hot) && $movie->is_hot)
                                <div class="px-2 py-1 bg-gradient-to-r from-red-500 to-orange-500 rounded-md">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 23s-8-4.5-8-11.8A8 8 0 0 1 12 3a8 8 0 0 1 8 8.2c0 7.3-8 11.8-8 11.8z"/>
                                    </svg>
                                </div>
                                @endif
                            </div>

                            <!-- Play Button Overlay -->
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center border-2 border-white/40 group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Card Info -->
                        <div class="p-3 space-y-2">
                            <!-- Title -->
                            <h3 class="text-sm font-bold line-clamp-2 group-hover:text-purple-400 transition-colors leading-snug min-h-[2.5rem]">
                                {{ $movie->title }}
                            </h3>
                            
                            <!-- Meta Info -->
                            <div class="flex items-center gap-1.5 text-xs text-gray-500">
                                @if(isset($movie->type) && $movie->type)
                                <span class="px-2 py-0.5 rounded
                                    {{ $movie->type === 'series' ? 'bg-purple-600/20 text-purple-300 border border-purple-500/30' : '' }}
                                    {{ $movie->type === 'single' ? 'bg-blue-600/20 text-blue-300 border border-blue-500/30' : '' }}">
                                    {{ $movie->type === 'series' ? 'Phim Bộ' : 'Phim Lẻ' }}
                                </span>
                                @endif

                                @if(isset($movie->country) && $movie->country)
                                <span>•</span>
                                <span class="truncate">{{ is_object($movie->country) ? $movie->country->name : $movie->country }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Hover Glow Effect -->
                        <div class="absolute inset-0 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                            <div class="absolute inset-0 rounded-xl ring-1 ring-purple-500/50 shadow-lg shadow-purple-500/30"></div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <div class="flex flex-col items-center justify-center py-20 px-4">
            <div class="w-24 h-24 bg-gray-800/50 rounded-full flex items-center justify-center mb-6">
                <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/>
                </svg>
            </div>
            <p class="text-center text-gray-500 text-lg font-medium mb-2">Chưa có phim nào</p>
            <p class="text-center text-gray-600 text-sm">Bảng xếp hạng này hiện chưa có dữ liệu</p>
        </div>
    @endif
</div>

<style>
@keyframes fade-in {
    from { 
        opacity: 0; 
        transform: translateY(20px); 
    }
    to { 
        opacity: 1; 
        transform: translateY(0); 
    }
}

.animate-fade-in {
    animation: fade-in 0.5s ease-out forwards;
    opacity: 0;
}
</style>