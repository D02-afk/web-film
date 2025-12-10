@extends('admin.layout')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-4xl font-bold text-purple-400">Quản lý Server</h1>
            <p class="text-gray-400 mt-2">
                Phim: <span class="text-pink-400 font-bold">{{ $movie->title }}</span>
                → Mùa {{ $season->season_number }} → Tập {{ $episode->episode_number }}: <span class="text-cyan-400">{{ $episode->title }}</span>
            </p>
        </div>
        <div class="flex gap-4">
            <a href="{{ route('admin.seasons.episodes.index', [$movie, $season]) }}"
               class="px-6 py-3 bg-gray-700 hover:bg-gray-600 rounded-xl text-white font-medium transition">
                ← Quay lại tập phim
            </a>
            <a href="{{ route('admin.seasons.episodes.servers.create', [$movie, $season, $episode]) }}"
               class="bg-gradient-to-r from-green-600 to-emerald-600 px-8 py-4 rounded-xl text-white font-bold shadow-lg hover:scale-105 transition">
                + Thêm Server Mới
            </a>
        </div>
    </div>

    <div class="bg-gray-800 rounded-2xl overflow-hidden shadow-2xl">
        @if($episode->servers->count() > 0)
            <table class="w-full">
                <thead class="bg-gradient-to-r from-purple-900/50 to-pink-900/50">
                    <tr>
                        <th class="px-6 py-5 text-left text-purple-300 font-bold">Server</th>
                        <th class="px-6 py-5 text-left text-purple-300 font-bold">Link</th>
                        <th class="px-6 py-5 text-center text-purple-300 font-bold">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach($episode->servers as $server)
                    <tr class="hover:bg-gray-700/50 transition group">
                        <td class="px-6 py-4 font-semibold text-teal-400">{{ $server->server_name }}</td>
                        <td class="px-6 py-4 text-gray-300 truncate max-w-md">
                            <a href="{{ $server->video_url }}" target="_blank" class="text-cyan-400 hover:underline">
                                {{ Str::limit($server->video_url, 80) }}
                            </a>
                        </td>
                        <td class="text-center">
                            <form action="{{ route('admin.seasons.episodes.servers.destroy', [$movie, $season, $episode, $server]) }}"
                                  method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Xóa server {{ addslashes($server->server_name) }}?')"
                                        class="text-red-400 hover:text-red-300 font-bold">
                                    Xóa
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="text-center py-20 text-gray-500">
                <i class="fas fa-server text-6xl mb-4 text-gray-600"></i>
                <p class="text-xl">Chưa có server nào</p>
                <a href="{{ route('admin.seasons.episodes.servers.create', [$movie, $season, $episode]) }}"
                   class="mt-4 inline-block px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 rounded-xl text-white font-bold">
                    Thêm server đầu tiên
                </a>
            </div>
        @endif
    </div>
</div>
@endsection