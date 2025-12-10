@extends('front.layouts.app')

@section('title', $query ? "Tìm kiếm: $query" : 'Tất cả phim')

@section('content')
<div class="pt-20 pb-16 lg:pb-24">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-screen-2xl">

        <!-- TIÊU ĐỀ -->
        <div class="text-center lg:text-left mb-8">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white leading-tight">
                @if($query)
                    Kết quả cho
                    <span class="block sm:inline text-primary text-4xl sm:text-5xl lg:text-6xl">"{{ $query }}"</span>
                @else
                    Tất cả phim
                @endif
            </h1>
            <p class="text-gray-400 text-lg mt-3">
                Tìm thấy <strong class="text-primary">{{ number_format($movies->total()) }}</strong> phim
            </p>
        </div>

        <!-- BỘ LỌC SIÊU ĐẸP – MOBILE FIRST, TINH TẾ NHẤT 2025 -->
        <div class="mb-10">
            <form method="GET" action="{{ route('search') }}" class="space-y-4">
                
                <!-- Ô tìm kiếm lớn, nổi bật -->
                <div class="relative">
                    <i class="fas fa-search absolute left-6 top-1/2 -translate-y-1/2 text-gray-400 text-xl"></i>
                    <input type="text" name="q" value="{{ $query }}" 
                           placeholder="Tìm phim, diễn viên, đạo diễn..."
                           class="w-full pl-16 pr-6 py-5 bg-gray-900/80 backdrop-blur-xl rounded-2xl text-white placeholder-gray-500 focus:outline-none focus:ring-4 focus:ring-primary/30 transition text-base lg:text-lg border border-gray-800">
                </div>

                <!-- Các bộ lọc nhỏ gọn, đẹp như app -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <!-- Loại phim -->
                    <div class="relative">
                        <select name="type" class="appearance-none w-full pl-10 pr-10 py-4 bg-gray-800/70 backdrop-blur-xl rounded-2xl text-white text-sm font-medium focus:outline-none focus:ring-4 focus:ring-primary/30 transition border border-gray-700/50">
                            <option value="">Loại phim</option>
                            <option value="1" {{ $type=='1'?'selected':'' }}>Phim lẻ</option>
                            <option value="2" {{ $type=='2'?'selected':'' }}>Phim bộ</option>
                        </select>
                        <i class="fas fa-film absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <i class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 text-xs"></i>
                    </div>

                    <!-- Năm -->
                    <div class="relative">
                        <select name="year" class="appearance-none w-full pl-10 pr-10 py-4 bg-gray-800/70 backdrop-blur-xl rounded-2xl text-white text-sm font-medium focus:outline-none focus:ring-4 focus:ring-primary/30 transition border border-gray-700/50">
                            <option value="">Năm</option>
                            @for($y = now()->year; $y >= 1990; $y--)
                                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                        <i class="fas fa-calendar absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <i class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 text-xs"></i>
                    </div>

                    <!-- Thể loại -->
                    <div class="relative">
                        <select name="genre" class="appearance-none w-full pl-10 pr-10 py-4 bg-gray-800/70 backdrop-blur-xl rounded-2xl text-white text-sm font-medium focus:outline-none focus:ring-4 focus:ring-primary/30 transition border border-gray-700/50">
                            <option value="">Thể loại</option>
                            @foreach($genres as $g)
                                <option value="{{ $g->slug }}" {{ $genre == $g->slug ? 'selected' : '' }}>{{ $g->name }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-tags absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <i class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 text-xs"></i>
                    </div>

                    <!-- Quốc gia -->
                    <div class="relative">
                        <select name="country" class="appearance-none w-full pl-10 pr-10 py-4 bg-gray-800/70 backdrop-blur-xl rounded-2xl text-white text-sm font-medium focus:outline-none focus:ring-4 focus:ring-primary/30 transition border border-gray-700/50">
                            <option value="">Quốc gia</option>
                            @foreach($countries as $c)
                                <option value="{{ $c->slug }}" {{ $country == $c->slug ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-globe absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <i class="fas fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 text-xs"></i>
                    </div>
                </div>

                <!-- Nút Tìm kiếm + Xóa lọc -->
                <div class="flex gap-3">
                    <button type="submit" 
                            class="flex-1 bg-gradient-to-r from-primary to-purple-600 hover:from-purple-600 hover:to-pink-600 py-4 rounded-2xl font-bold text-white text-lg shadow-xl hover:shadow-primary/50 transition transform hover:scale-105">
                        <i class="fas fa-search mr-2"></i>
                        Tìm ngay
                    </button>

                    @if(request()->hasAny(['q', 'type', 'year', 'genre', 'country']))
                    <a href="{{ route('search') }}" 
                       class="px-6 py-4 bg-gray-800/70 backdrop-blur-xl rounded-2xl font-medium text-gray-400 hover:text-white hover:bg-gray-700/70 transition border border-gray-700/50">
                        <i class="fas fa-times"></i>
                    </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- DANH SÁCH PHIM -->
        @if($movies->count())
            <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 xl:grid-cols-8 2xl:grid-cols-10 gap-4 sm:gap-5 mb-12">
                @foreach($movies as $movie)
                    <x-movie-card :movie="$movie" />
                @endforeach
            </div>

            <div class="flex justify-center">
                {{ $movies->appends(request()->query())->links('pagination::tailwind') }}
            </div>
        @else
            <div class="text-center py-24">
                <i class="fas fa-search text-9xl text-gray-700 mb-8 opacity-40"></i>
                <h3 class="text-3xl font-bold text-gray-400 mb-4">Không tìm thấy phim nào</h3>
                <p class="text-gray-500 text-lg max-w-md mx-auto">Thử bỏ bớt bộ lọc hoặc tìm bằng từ khóa khác nhé!</p>
            </div>
        @endif

        <!-- GỢI Ý PHIM -->
        @if($movies->count() < 12 || !$query)
        <div class="mt-16">
            <h2 class="text-2xl lg:text-3xl font-black text-white mb-10 text-center lg:text-left">
                @if($movies->count() === 0) Có thể bạn thích @else Gợi ý hôm nay @endif
            </h2>

            <div class="space-y-12">
                @php
                    $suggestions = [
                        ['title' => 'Phim đang HOT', 'icon' => 'fa-fire', 'color' => 'text-red-500', 'movies' => \App\Models\Movie::where('is_featured', 1)->inRandomOrder()->take(12)->get()],
                        ['title' => 'Mới cập nhật', 'icon' => 'fa-sync-alt', 'color' => 'text-green-500', 'movies' => \App\Models\Movie::latest()->take(12)->get()],
                        ['title' => 'Phim lẻ hay nhất', 'icon' => 'fa-film', 'color' => 'text-purple-500', 'movies' => \App\Models\Movie::where('type', 1)->orderBy('views', 'desc')->take(12)->get()],
                        ['title' => 'Phim bộ đang hot', 'icon' => 'fa-tv', 'color' => 'text-yellow-500', 'movies' => \App\Models\Movie::where('type', 2)->orderBy('views', 'desc')->take(12)->get()],
                    ];
                @endphp

                @foreach($suggestions as $item)
                    @if($item['movies']->count())
                    <div>
                        <h3 class="text-xl font-bold {{ $item['color'] }} mb-6 flex items-center gap-3">
                            <i class="fas {{ $item['icon'] }} text-2xl"></i>
                            {{ $item['title'] }}
                        </h3>
                        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 xl:grid-cols-8 gap-4 sm:gap-5">
                            @foreach($item['movies'] as $movie)
                                <x-movie-card :movie="$movie" />
                            @endforeach
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>
@endsection