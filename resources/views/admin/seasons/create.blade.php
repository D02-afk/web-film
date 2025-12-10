@extends('admin.layout')

@section('content')
<div class="max-w-2xl mx-auto py-12">
    <h1 class="text-4xl font-bold text-purple-400 mb-10">Thêm Mùa Mới cho: {{ $movie->title }}</h1>

    <form action="{{ route('admin.movies.seasons.store', $movie) }}" method="POST"
          class="bg-gray-800 rounded-2xl p-8 shadow-2xl">
        @csrf
        <div class="mb-6">
            <label class="block text-white font-bold mb-3">Số mùa</label>
            <input type="number" name="season_number" required min="1"
                   class="w-full px-6 py-4 rounded-xl bg-gray-700 text-white focus:ring-4 focus:ring-purple-500"
                   value="{{ old('season_number') }}">
        </div>

        <div class="mb-8">
            <label class="block text-white font-bold mb-3">Tên mùa (tùy chọn)</label>
            <input type="text" name="title" placeholder="Ví dụ: Mùa 1 - Hành trình bắt đầu"
                   class="w-full px-6 py-4 rounded-xl bg-gray-700 text-white focus:ring-4 focus:ring-purple-500"
                   value="{{ old('title') }}">
        </div>

        <div class="flex gap-4">
            <button type="submit"
                    class="bg-gradient-to-r from-purple-600 to-pink-600 px-10 py-4 rounded-xl text-white font-bold hover:scale-105 transition">
                Thêm Mùa
            </button>
            <a href="{{ route('admin.movies.seasons.index', $movie) }}"
               class="bg-gray-700 px-8 py-4 rounded-xl text-white font-bold hover:bg-gray-600 transition">
                Hủy
            </a>
        </div>
    </form>
</div>
@endsection