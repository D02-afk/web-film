{{-- resources/views/movies/show.blade.php --}}
@extends('front.layouts.app')

@section('title', $movie->title . ' - Xem phim online')
@section('description', Str::limit(strip_tags($movie->description), 155))

@section('content')
<div class="min-h-screen bg-black text-white">

    <!-- HERO SECTION - ĐÃ FIX RESPONSIVE -->
    <section class="relative min-h-screen flex items-end pb-12 md:pb-20 lg:pb-32">
        <!-- Backdrop -->
        <div class="absolute inset-0">
            <img src="{{ $movie->thumbnail ? asset($movie->thumbnail) : ($movie->poster ? asset('storage/'.$movie->poster) : asset('images/no-backdrop.jpg')) }}"
                 alt="{{ $movie->title }}"
                 class="w-full h-full object-cover brightness-50">
            <div class="absolute inset-0 bg-gradient-to-t from-black via-black/70 to-transparent"></div>
        </div>

        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-end">
                <!-- Poster -->
                <div class="relative lg:col-span-4 flex justify-center lg:justify-end">
                    <div class="relative w-64 sm:w-80 md:w-96 lg:w-full max-w-sm">
                        <img src="{{ $movie->poster ? asset($movie->poster) : asset('images/no-poster.jpg') }}"
                             alt="{{ $movie->title }}"
                             class="w-full rounded-2xl sm:rounded-3xl shadow-2xl border-4 sm:border-8 border-black/50">
                        @if($movie->is_featured ?? false)
                            <div class="absolute -top-3 -right-3 sm:-top-4 sm:-right-4 bg-gradient-to-r from-red-600 to-pink-600 px-4 sm:px-6 py-2 sm:py-3 rounded-full font-black text-sm sm:text-base shadow-2xl animate-pulse">
                                HOT
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Thông tin phim -->
                <div class="lg:col-span-8 space-y-6 sm:space-y-8">
                    <div>
                        <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl xl:text-8xl font-black leading-tight">
                            {{ $movie->title }}
                        </h1>
                        @if($movie->origin_name && $movie->origin_name != $movie->title)
                            <p class="text-xl sm:text-2xl md:text-3xl text-gray-400 italic mt-2">
                                {{ $movie->origin_name }}
                            </p>
                        @endif
                    </div>

                    <!-- Tags info -->
                    <div class="flex flex-wrap gap-3 text-base sm:text-lg">
                        @if($movie->imdb_score)
                            <span class="px-4 sm:px-5 py-2 sm:py-3 bg-yellow-500/20 border border-yellow-500 rounded-full flex items-center gap-2">
                                <i class="fas fa-star text-yellow-500"></i> {{ $movie->imdb_score }}
                            </span>
                        @endif
                        <span class="px-4 sm:px-5 py-2 sm:py-3 bg-gray-800 rounded-full">{{ $movie->year }}</span>
                        <span class="px-4 sm:px-5 py-2 sm:py-3 {{ $movie->type == 1 ? 'bg-blue-600' : 'bg-purple-600' }} rounded-full font-bold">
                            {{ $movie->type == 1 ? 'Phim Lẻ' : 'Phim Bộ' }}
                        </span>
                    </div>

                    <!-- Genres -->
                    <div class="flex flex-wrap gap-3">
                        @foreach($movie->genres as $g)
                            <a href="{{ route('genre.show', $g->slug) }}"
                               class="px-4 sm:px-5 py-2 bg-white/10 hover:bg-primary rounded-full text-sm transition">
                                {{ $g->name }}
                            </a>
                        @endforeach
                    </div>

                    <!-- Mô tả -->
                    <p class="text-base sm:text-lg text-gray-300 leading-relaxed max-w-4xl">
                        {{ $movie->description ? strip_tags($movie->description) : 'Chưa có mô tả.' }}
                    </p>

                    <!-- Nút Xem phim - responsive -->
                    <div class="pt-6 sm:pt-8">
                        <a href="{{ route('movie.watch', $movie->slug) }}"
                           class="inline-flex items-center gap-4 bg-gradient-to-r from-primary to-purple-600 
                                  px-8 sm:px-12 py-4 sm:py-6 rounded-full 
                                  text-xl sm:text-2xl font-black 
                                  hover:shadow-2xl hover:shadow-primary/50 
                                  transform hover:scale-105 transition-all duration-300">
                            <i class="fas fa-play-circle text-3xl sm:text-4xl"></i>
                            @if($movie->type == 1) XEM PHIM @else XEM TẬP MỚI NHẤT @endif
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- End Hero -->

    <!-- DANH SÁCH TẬP - PHIM BỘ (Responsive Grid) -->
    @if($movie->type == 2 && $movie->seasons->count() > 0)
        <section class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-20">
            <h2 class="text-3xl sm:text-4xl font-black mb-10 text-center sm:text-left">Danh sách tập phim</h2>

            @foreach($movie->seasons as $season)
                <div class="mb-12 bg-gray-900/50 backdrop-blur rounded-2xl sm:rounded-3xl p-6 sm:p-8 border border-gray-800">
                    <h3 class="text-xl sm:text-2xl font-bold text-primary mb-6">Season {{ $season->season_number }}</h3>

                    <div class="grid grid-cols-6 sm:grid-cols-8 md:grid-cols-10 lg:grid-cols-12 xl:grid-cols-16 2xl:grid-cols-20 gap-3 sm:gap-4">
                        @foreach($season->episodes as $ep)
                            <a href="{{ route('movie.watch', [$movie->slug, 'ep' => $ep->id]) }}"
                               class="block bg-gray-800 hover:bg-primary hover:scale-110 transition-all duration-300 
                                      rounded-xl sm:rounded-2xl p-4 sm:p-5 text-center 
                                      font-bold text-base sm:text-lg shadow-lg aspect-square flex items-center justify-center">
                                {{ $ep->episode_number }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </section>
    @endif

    @include('front.partials.rating-comment', ['movie' => $movie])

    <!-- CÁC SECTION GỢI Ý - dùng component có sẵn (giả sử đã responsive) -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-16">
        <x-movie-section title="Cùng thể loại" :movies="$sameGenres" icon="fas fa-layer-group"
                         color="from-pink-600 to-rose-600" />
        <x-movie-section title="Phim {{ $movie->country?->name ?? 'cùng quốc gia' }}" :movies="$sameCountry"
                         icon="fas fa-flag" color="from-blue-600 to-cyan-600" />
        <x-movie-section title="Phim ra mắt năm {{ $movie->year }}" :movies="$sameYear" icon="fas fa-calendar-alt"
                         color="from-green-600 to-emerald-600" />
        <x-movie-section title="Đang hot nhất tuần" :movies="$trending" icon="fas fa-fire"
                         color="from-orange-600 to-red-600" hot="true" />

        @if($similarByTags->count() > 0)
            <x-movie-section title="Có chung chủ đề với bạn" :movies="$similarByTags" icon="fas fa-tags"
                             color="from-purple-600 to-indigo-600" />
        @endif

        @if($usersAlsoLiked->count() > 2)
            <x-movie-section title="Người xem phim này cũng thích" :movies="$usersAlsoLiked" icon="fas fa-heart"
                             color="from-red-600 to-pink-600" />
        @endif

        @if($upcoming->count() > 0)
            <x-movie-section title="Sắp ra mắt - Đừng bỏ lỡ!" :movies="$upcoming" icon="fas fa-clock"
                             color="from-yellow-600 to-amber-600" />
        @endif

        <x-movie-section title="Gợi ý ngẫu nhiên cho bạn" :movies="$randomPick" icon="fas fa-dice"
                         color="from-teal-600 to-cyan-600" />
    </div>
</div>

{{-- JS đánh giá sao (giữ nguyên) --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.rating-radio');
    const form = document.getElementById('rating-form');

    stars.forEach(star => {
        star.addEventListener('change', function() {
            const value = this.value;
            stars.forEach((s, i) => {
                const icon = s.parentElement.querySelector('i');
                icon.classList.toggle('text-yellow-500', i < value);
                icon.classList.toggle('text-gray-600', i >= value);
            });
        });
    });

    form?.addEventListener('submit', function(e) {
        e.preventDefault();
        const score = document.querySelector('input[name="score"]:checked')?.value;
        if (!score) return alert('Vui lòng chọn số sao!');

        fetch("{{ route('movie.rate', $movie) }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept: 'application/json'
            },
            body: JSON.stringify({ score: score })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                alert('Cảm ơn bạn đã đánh giá ' + score + ' sao!');
                location.reload();
            }
        });
    });
});
</script>
@endsection