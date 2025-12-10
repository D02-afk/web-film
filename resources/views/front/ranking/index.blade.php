@extends('front.layouts.app')

@section('title', 'Bảng Xếp Hạng Phim Hay Nhất')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-950 via-black to-gray-900 text-white py-20 relative overflow-hidden">
    
    <!-- Animated Background Effects -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl animate-blob"></div>
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-yellow-500 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-0 left-1/3 w-96 h-96 bg-pink-500 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-4000"></div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 relative z-10">
        
        <!-- Header Section -->
        <div class="text-center mb-16 space-y-6">
            <div class="inline-block animate-fade-in-down">
                <span class="inline-block px-6 py-2 bg-gradient-to-r from-purple-600/20 to-pink-600/20 border border-purple-500/30 rounded-full text-sm font-semibold text-purple-300 mb-4">
                    🏆 Bảng Xếp Hạng Chính Thức
                </span>
            </div>
            
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-black mb-6 animate-fade-in">
                <span class="bg-gradient-to-r from-yellow-400 via-orange-500 to-red-500 bg-clip-text text-transparent drop-shadow-2xl">
                    BẢNG XẾP HẠNG
                </span>
            </h1>
            
            <p class="text-xl md:text-2xl text-gray-300 max-w-3xl mx-auto animate-fade-in-up">
                Khám phá những bộ phim <span class="text-yellow-400 font-bold">hot nhất</span>, 
                <span class="text-pink-400 font-bold">được yêu thích nhất</span> và 
                <span class="text-orange-400 font-bold">VIP nhất</span>
            </p>
        </div>

        <!-- TAB NAVIGATION - Modern Card Style -->
        <div class="max-w-5xl mx-auto mb-16">
            <div class="bg-gray-900/40 backdrop-blur-xl rounded-3xl p-3 border border-gray-800/50 shadow-2xl">
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                    <button data-tab="views" class="tab-btn active group relative overflow-hidden rounded-2xl px-6 py-5 transition-all duration-300">
                        <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-pink-600 opacity-100 group-hover:opacity-90 transition-opacity"></div>
                        <div class="relative flex flex-col items-center gap-2">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <span class="font-bold text-sm md:text-base">Lượt Xem</span>
                        </div>
                    </button>

                    <button data-tab="imdb" class="tab-btn group relative overflow-hidden rounded-2xl px-6 py-5 transition-all duration-300">
                        <div class="absolute inset-0 bg-gray-800 group-hover:bg-gray-700 transition-colors"></div>
                        <div class="relative flex flex-col items-center gap-2">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                            <span class="font-bold text-sm md:text-base">Điểm IMDb</span>
                        </div>
                    </button>

                    <button data-tab="vip" class="tab-btn group relative overflow-hidden rounded-2xl px-6 py-5 transition-all duration-300">
                        <div class="absolute inset-0 bg-gray-800 group-hover:bg-gray-700 transition-colors"></div>
                        <div class="relative flex flex-col items-center gap-2">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                            <span class="font-bold text-sm md:text-base">VIP Hot</span>
                        </div>
                    </button>

                    <button data-tab="favorites" class="tab-btn group relative overflow-hidden rounded-2xl px-6 py-5 transition-all duration-300">
                        <div class="absolute inset-0 bg-gray-800 group-hover:bg-gray-700 transition-colors"></div>
                        <div class="relative flex flex-col items-center gap-2">
                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                            <span class="font-bold text-sm md:text-base">Yêu Thích</span>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <!-- TAB CONTENT -->
        <div id="tab-views" class="tab-content animate-fade-in">
            <x-movie-grid title="🔥 Top 20 Phim Được Xem Nhiều Nhất" :movies="$topViews" />
        </div>

        <div id="tab-imdb" class="tab-content hidden">
            <x-movie-grid title="⭐ Top 20 Phim Điểm IMDb Cao Nhất" :movies="$topImdb" />
        </div>

        <div id="tab-vip" class="tab-content hidden">
            <x-movie-grid title="💎 Top 20 Phim VIP Có Lượt Xem Cao Nhất" :movies="$topVip" icon="vip" />
        </div>

        <div id="tab-favorites" class="tab-content hidden">
            <x-movie-grid title="❤️ Top 20 Phim Được Yêu Thích Nhiều Nhất" :movies="$topFavorites" icon="heart" />
        </div>

        <!-- TOP THỂ LOẠI & QUỐC GIA -->
        <div class="grid lg:grid-cols-2 gap-8 mt-24">
            <!-- Top Genres -->
            <div class="group">
                <div class="bg-gradient-to-br from-gray-900/80 to-gray-800/80 backdrop-blur-xl rounded-3xl p-8 border border-gray-700/50 shadow-2xl hover:shadow-yellow-500/10 transition-all duration-500 hover:-translate-y-1">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl flex items-center justify-center">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-black bg-gradient-to-r from-yellow-400 to-orange-500 bg-clip-text text-transparent">
                            Top 10 Thể Loại Hot
                        </h3>
                    </div>
                    
                    <div class="space-y-3">
                        @foreach($topGenres as $index => $genre)
                        <div class="group/item relative overflow-hidden bg-gradient-to-r from-gray-800/60 to-gray-800/40 rounded-2xl p-5 hover:from-gray-700/60 hover:to-gray-700/40 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg">
                            <div class="absolute inset-0 bg-gradient-to-r from-yellow-500/0 to-orange-500/0 group-hover/item:from-yellow-500/5 group-hover/item:to-orange-500/5 transition-all duration-300"></div>
                            
                            <div class="relative flex items-center justify-between">
                                <div class="flex items-center gap-5">
                                    <div class="flex-shrink-0">
                                        <span class="flex items-center justify-center w-14 h-14 text-3xl font-black bg-gradient-to-br from-yellow-500 to-orange-500 bg-clip-text text-transparent">
                                            #{{ $index + 1 }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-xl font-bold text-white mb-1 group-hover/item:text-yellow-400 transition-colors">
                                            {{ $genre->name }}
                                        </p>
                                        <p class="text-gray-400 text-sm flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            {{ number_format($genre->total_views) }} lượt xem
                                        </p>
                                    </div>
                                </div>
                                <!-- {{ route('genre.show', $genre->slug) }} -->
                                <a href="" class="flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-yellow-500 to-orange-500 text-white font-bold rounded-xl hover:shadow-lg hover:shadow-yellow-500/30 transition-all duration-300 hover:scale-105">
                                    Xem
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Top Countries -->
            <div class="group">
                <div class="bg-gradient-to-br from-gray-900/80 to-gray-800/80 backdrop-blur-xl rounded-3xl p-8 border border-gray-700/50 shadow-2xl hover:shadow-cyan-500/10 transition-all duration-500 hover:-translate-y-1">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-12 h-12 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-2xl flex items-center justify-center">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-black bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">
                            Top 10 Quốc Gia Hot
                        </h3>
                    </div>
                    
                    <div class="space-y-3">
                        @foreach($topCountries as $index => $country)
                        <div class="group/item relative overflow-hidden bg-gradient-to-r from-gray-800/60 to-gray-800/40 rounded-2xl p-5 hover:from-gray-700/60 hover:to-gray-700/40 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg">
                            <div class="absolute inset-0 bg-gradient-to-r from-cyan-500/0 to-blue-500/0 group-hover/item:from-cyan-500/5 group-hover/item:to-blue-500/5 transition-all duration-300"></div>
                            
                            <div class="relative flex items-center justify-between">
                                <div class="flex items-center gap-5">
                                    <div class="flex-shrink-0">
                                        <span class="flex items-center justify-center w-14 h-14 text-3xl font-black bg-gradient-to-br from-cyan-500 to-blue-500 bg-clip-text text-transparent">
                                            #{{ $index + 1 }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-xl font-bold text-white mb-1 group-hover/item:text-cyan-400 transition-colors">
                                            {{ $country->name }}
                                        </p>
                                        <p class="text-gray-400 text-sm flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            {{ number_format($country->total_views) }} lượt xem
                                        </p>
                                    </div>
                                </div>
                                <!-- {{ route('country.show', $country->slug) }} -->
                                 <a href="" 
                                   class="flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-cyan-500 to-blue-500 text-white font-bold rounded-xl hover:shadow-lg hover:shadow-cyan-500/30 transition-all duration-300 hover:scale-105">
                                    Xem
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes blob {
    0%, 100% { transform: translate(0, 0) scale(1); }
    25% { transform: translate(20px, -50px) scale(1.1); }
    50% { transform: translate(-20px, 20px) scale(0.9); }
    75% { transform: translate(50px, 50px) scale(1.05); }
}

@keyframes fade-in {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes fade-in-down {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes fade-in-up {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-blob {
    animation: blob 7s infinite;
}

.animation-delay-2000 {
    animation-delay: 2s;
}

.animation-delay-4000 {
    animation-delay: 4s;
}

.animate-fade-in {
    animation: fade-in 0.8s ease-out forwards;
}

.animate-fade-in-down {
    animation: fade-in-down 0.8s ease-out forwards;
}

.animate-fade-in-up {
    animation: fade-in-up 0.8s ease-out forwards;
    animation-delay: 0.2s;
    opacity: 0;
}

.tab-content {
    animation: fade-in 0.5s ease-out forwards;
}
</style>

<script>
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        // Remove active state from all buttons
        document.querySelectorAll('.tab-btn').forEach(b => {
            b.classList.remove('active');
            const bgDiv = b.querySelector('div');
            bgDiv.className = 'absolute inset-0 bg-gray-800 group-hover:bg-gray-700 transition-colors';
        });

        // Add active state to clicked button
        btn.classList.add('active');
        const activeDiv = btn.querySelector('div');
        
        if (btn.dataset.tab === 'views') {
            activeDiv.className = 'absolute inset-0 bg-gradient-to-r from-purple-600 to-pink-600 opacity-100 group-hover:opacity-90 transition-opacity';
        } else if (btn.dataset.tab === 'imdb') {
            activeDiv.className = 'absolute inset-0 bg-gradient-to-r from-blue-600 to-cyan-600 opacity-100 group-hover:opacity-90 transition-opacity';
        } else if (btn.dataset.tab === 'vip') {
            activeDiv.className = 'absolute inset-0 bg-gradient-to-r from-yellow-600 to-orange-600 opacity-100 group-hover:opacity-90 transition-opacity';
        } else if (btn.dataset.tab === 'favorites') {
            activeDiv.className = 'absolute inset-0 bg-gradient-to-r from-red-600 to-pink-600 opacity-100 group-hover:opacity-90 transition-opacity';
        }

        // Show corresponding content
        document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
        document.getElementById('tab-' + btn.dataset.tab).classList.remove('hidden');
    });
});
</script>
@endsection