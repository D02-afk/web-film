@extends('admin.layout')

@section('content')
<div class="max-w-7xl mx-auto">

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-4xl font-bold text-purple-400">
                Quản lý tập phim
            </h1>
            <p class="text-gray-400 mt-2">
                Phim: <span class="text-pink-400 font-bold">{{ $movie->title }}</span>
                @if($season->season_number == 1 && $movie->type == 1)
                <span class="bg-blue-600 text-blue-100 px-3 py-1 rounded-full text-sm ml-3">Phim lẻ</span>
                @else
                → Mùa {{ $season->season_number }}: <span class="text-cyan-400">{{ $season->title }}</span>
                @endif
            </p>
        </div>
        <div class="flex gap-4">
            <a href="{{ route('admin.movies.seasons.index', $movie) }}"
                class="px-6 py-3 bg-gray-700 hover:bg-gray-600 rounded-xl text-white font-medium transition">
                ← Quay lại mùa
            </a>
            <a href="{{ route('admin.seasons.episodes.create', [$movie, $season]) }}"
                class="bg-gradient-to-r from-green-600 to-emerald-600 px-8 py-4 rounded-xl text-white font-bold shadow-lg hover:scale-105 transition">
                + Thêm tập mới
            </a>
        </div>
    </div>

    <div class="bg-gray-800 rounded-2xl overflow-hidden shadow-2xl">
        <table class="w-full">
            <thead class="bg-gradient-to-r from-purple-900/50 to-pink-900/50">
                <tr>
                    <th class="px-6 py-5 text-left text-purple-300 font-bold">Tập</th>
                    <th class="px-6 py-5 text-left text-purple-300 font-bold">Tiêu đề</th>
                    <th class="px-6 py-5 text-center text-purple-300 font-bold">Server</th>
                    <th class="px-6 py-5 text-center text-purple-300 font-bold">Phụ đề</th>
                    <th class="px-6 py-5 text-center text-purple-300 font-bold">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @forelse($season->episodes as $episode)
                <tr class="hover:bg-gray-700/50 transition group">
                    <td class="px-6 py-4 font-bold text-xl text-purple-400">
                        Tập {{ $episode->episode_number }}
                        @if($movie->type == 1 && $episode->episode_number == 1)
                        <span class="text-xs bg-blue-600 text-blue-100 px-2 py-1 rounded ml-2">Full</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-white font-medium">
                        {{ $episode->title }}
                    </td>
                    <td class="text-center">
                        @if($episode->servers->count() > 0)
                        <a href="{{ route('admin.seasons.episodes.servers', [$movie, $season, $episode]) }}"
                            class="inline-flex items-center gap-2 bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-700 hover:to-cyan-700 px-5 py-2 rounded-full text-white text-sm font-bold shadow-lg transform hover:scale-105 transition">
                            <i class="fas fa-server"></i> {{ $episode->servers->count() }} server
                        </a>
                        @else
                        <a href="{{ route('admin.seasons.episodes.servers.create', [$movie, $season, $episode]) }}"
                            class="inline-flex items-center gap-2 bg-gray-600 hover:bg-gray-500 px-5 py-2 rounded-full text-white text-sm font-medium transition">
                            <i class="fas fa-plus"></i> Thêm server
                        </a>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($episode->subtitles->count() > 0)
                        <a href="{{ route('admin.seasons.episodes.subtitles', [$movie, $season, $episode]) }}"
                            class="text-cyan-400 hover:text-cyan-300 font-medium">
                            {{ $episode->subtitles->count() }} phụ đề
                        </a>
                        @else
                        <a href="{{ route('admin.seasons.episodes.subtitles.create', [$movie, $season, $episode]) }}"
                            class="text-gray-500 hover:text-gray-400 text-sm">
                            + Thêm phụ đề
                        </a>
                        @endif
                    </td>

                    <td class="px-6 py-4 text-center">
                        <div
                            class="flex items-center justify-center gap-5 opacity-0 group-hover:opacity-100 transition">
                            <a href="{{ route('admin.seasons.episodes.edit', [$movie, $season, $episode]) }}"
                                class="text-yellow-400 hover:text-yellow-300 font-bold">Sửa</a>

                            <form action="{{ route('admin.seasons.episodes.destroy', [$movie, $season, $episode]) }}"
                                method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Xóa tập {{ $episode->episode_number }}: {{ addslashes($episode->title) }}?')"
                                    class="text-red-400 hover:text-red-300 font-bold">
                                    Xóa
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-16 text-gray-500 text-xl">
                        Chưa có tập phim nào
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection