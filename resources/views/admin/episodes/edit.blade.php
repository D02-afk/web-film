{{-- create.blade.php --}}
@extends('admin.layout')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-gray-800 rounded-2xl shadow-2xl p-8">
        <h1 class="text-3xl font-bold text-purple-400 mb-8">
            {{ $season->season_number == 1 && $movie->type == 1 ? 'Thêm link phim lẻ' : 'Thêm tập mới - Mùa ' . $season->season_number }}
        </h1>

        <form action="{{ route('admin.seasons.episodes.update', [$movie, $season, $episode]) }}" method="POST">
            @csrf @method('PATCH')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Số tập</label>
                    <input type="number" name="episode_number" value="{{ old('episode_number', $episode->episode_number) }}"
                           class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-xl text-white focus:ring-2 focus:ring-purple-500" required min="1">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Tiêu đề tập</label>
                    <input type="text" name="title" value="{{ old('title', $episode->title) }}}}"
                           class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-xl text-white focus:ring-2 focus:ring-purple-500" required>
                </div>
            </div>

            <div class="mt-8 flex gap-4">
                <button type="submit"
                    class="px-8 py-4 bg-gradient-to-r from-green-600 to-emerald-600 rounded-xl text-white font-bold hover:scale-105 transition">
                    Thêm tập phim
                </button>
                <a href="{{ route('admin.seasons.episodes.index', [$movie, $season]) }}"
                   class="px-8 py-4 bg-gray-700 rounded-xl text-white font-medium hover:bg-gray-600 transition">
                    Hủy
                </a>
            </div>
        </form>
    </div>
</div>
@endsection