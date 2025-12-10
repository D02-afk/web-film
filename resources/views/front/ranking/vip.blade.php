@extends('front.layouts.app')

@section('title', 'Bảng Xếp Hạng Phim VIP Đang Hot Nhất')

@section('content')
<div class="min-h-screen bg-black text-white py-16">

    <div class="container mx-auto px-6">
        <!-- Header VIP sang chảnh -->
        <div class="text-center mb-16">
            <h1 class="text-6xl md:text-8xl font-black mb-6">
                <span class="bg-gradient-to-r from-yellow-400 via-amber-500 to-orange-600 bg-clip-text text-transparent animate-pulse">
                    VIP ONLY – ĐẲNG CẤP RIÊNG
                </span>
            </h1>
            <p class="text-2xl text-yellow-400 font-bold">Những bộ phim chỉ dành cho thành viên VIP</p>
        </div>

        <!-- Top 1 VIP King -->
        @if($topVip->count() > 0)
        <div class="max-w-4xl mx-auto mb-20 relative">
            <div class="absolute inset-0 bg-gradient-to-r from-yellow-600/30 to-orange-600/30 blur-3xl"></div>
            <a href="{{ route('movie.watch', $topVip->first()->slug) }}"
               class="relative block bg-gray-900/90 backdrop-blur-2xl rounded-3xl overflow-hidden border-4 border-yellow-600 shadow-2xl hover:border-yellow-400 transition">
                <div class="grid md:grid-cols-2">
                    <img src="{{ $topVip->first()->poster ?? asset('images/no-poster.jpg') }}"
                         alt="{{ $topVip->first()->title }}"
                         class="w-full h-96 md:h-full object-cover">
                    <div class="p-10 flex flex-col justify-center">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="text-6xl font-black text-yellow-400">#1</span>
                            <span class="px-6 py-3 bg-yellow-600 rounded-full text-black font-bold text-xl">VIP KING</span>
                        </div>
                        <h2 class="text-5xl font-black mb-4">{{ $topVip->first()->title }}</h2>
                        <p class="text-gray-300 text-lg mb-6 line-clamp-3">{{ $topVip->first()->description }}</p>
                        <div class="flex items-center gap-6 text-yellow-400">
                            <span class="text-3xl font-bold">{{ number_format($topVip->first()->views) }}</span>
                            <span class="text-xl">lượt xem</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endif

        <!-- Top 2–20 -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-8">
            @foreach($topVip->skip(1) as $index => $movie)
            <x-movie-card :movie="$movie" :rank="$index + 2" vip="true" />
            @endforeach
        </div>

        <!-- Phân trang -->
        <div class="mt-16 text-center">
            {{ $topVip->links() }}
        </div>
    </div>
</div>
@endsection