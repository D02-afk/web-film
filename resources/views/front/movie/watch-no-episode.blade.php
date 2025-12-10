@extends('front.layouts.app')
@section('title', 'Xem phim ' . $movie->title)
@section('content')
<div class="min-h-screen bg-gradient-to-b from-black to-gray-950 text-white flex items-center justify-center">
    <div class="container mx-auto px-6 text-center">
        <i class="fas fa-film text-9xl text-gray-700 mb-8"></i>
        <h1 class="text-5xl font-black mb-6">{{ $movie->title }}</h1>
        <p class="text-2xl text-gray-400 mb-8">
            Phim bộ này chưa có tập nào để xem.
        </p>
        <div class="space-y-4">
            <p class="text-lg text-gray-500">Admin đang cập nhật link xem phim...</p>
            <a href="{{ route('movie.show', $movie->slug) }}" 
               class="inline-block bg-primary px-10 py-4 rounded-xl font-bold text-xl hover:scale-105 transition">
               ← Quay lại trang chi tiết
            </a>
        </div>

        {{-- Vẫn hiển thị thông tin phim + gợi ý để giữ người dùng --}}
        <div class="mt-20">
            @include('front.partials.rating-comment', compact('movie'))
        </div>
    </div>
</div>
@endsection