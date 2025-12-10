@extends('admin.layout')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-4xl font-bold text-purple-400">Quản lý Phụ đề</h1>
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
            <a href="{{ route('admin.seasons.episodes.subtitles.create', [$movie, $season, $episode]) }}"
               class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-4 rounded-xl text-white font-bold shadow-lg hover:scale-105 transition">
                + Thêm Phụ đề
            </a>
        </div>
    </div>

    <div class="bg-gray-800 rounded-2xl overflow-hidden shadow-2xl">
        @if($episode->subtitles->count() > 0)
            <table class="w-full">
                <thead class="bg-gradient-to-r from-indigo-900/50 to-purple-900/50">
                    <tr>
                        <th class="px-6 py-5 text-left text-purple-300 font-bold">Ngôn ngữ</th>
                        <th class="px-6 py-5 text-left text-purple-300 font-bold">Nhãn</th>
                        <th class="px-6 py-5 text-left text-purple-300 font-bold">Link</th>
                        <th class="px-6 py-5 text-center text-purple-300 font-bold">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach($episode->subtitles as $sub)
                    <tr class="hover:bg-gray-700/50 transition group">
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-indigo-900/70 rounded-full text-indigo-300 text-sm font-medium">
                                {{ strtoupper($sub->language) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-medium text-purple-300">{{ $sub->label }}</td>
                        <td class="px-6 py-4 text-gray-300 max-w-md">
                            <a href="{{ $sub->url }}" target="_blank" class="text-cyan-400 hover:underline break-all">
                                {{ Str::limit($sub->url, 60) }}
                            </a>
                        </td>
                        <td class="text-center">
                            <form action="{{ route('admin.seasons.episodes.subtitles.destroy', [$movie, $season, $episode, $sub]) }}"
                                  method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Xóa phụ đề này?')"
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
            <div class="text-center py-24 text-gray-500">
                <i class="fas fa-closed-captioning text-8xl mb-6 text-gray-700"></i>
                <p class="text-2xl mb-6">Chưa có phụ đề nào</p>
                <a href="{{ route('admin.seasons.episodes.subtitles.create', [$movie, $season, $episode]) }}"
                   class="inline-block px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl text-white font-bold shadow-lg hover:scale-105 transition">
                    Thêm phụ đề đầu tiên
                </a>
            </div>
        @endif
    </div>
</div>
@endsection