@extends('admin.layout')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-gray-800 rounded-2xl shadow-2xl p-8">
        <h1 class="text-3xl font-bold text-purple-400 mb-8">
            Thêm Phụ đề – Tập {{ $episode->episode_number }}: {{ $episode->title }}
        </h1>

        <form action="{{ route('admin.seasons.episodes.subtitles.store', [$movie, $season, $episode]) }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-3">Ngôn ngữ</label>
                    <input type="text" name="language" required placeholder="vi" maxlength="10"
                           class="w-full px-5 py-4 bg-gray-700 border border-gray-600 rounded-xl text-white uppercase text-center text-lg font-bold focus:ring-2 focus:ring-purple-500">
                    <p class="text-xs text-gray-500 mt-2">VD: vi, en, zh, es...</p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-400 mb-3">Nhãn hiển thị</label>
                    <input type="text" name="label" required placeholder="Tiếng Việt, English, 简体中文..."
                           class="w-full px-5 py-4 bg-gray-700 border border-gray-600 rounded-xl text-white text-lg focus:ring-2 focus:ring-purple-500">
                </div>
            </div>

            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-400 mb-3">Link phụ đề (.vtt, .srt)</label>
                <input type="url" name="url" required placeholder="https://example.com/subtitle.vtt"
                       class="w-full px-5 py-4 bg-gray-700 border border-gray-600 rounded-xl text-white text-lg focus:ring-2 focus:ring-purple-500">
            </div>

            <div class="mt-10 flex gap-5">
                <button type="submit"
                    class="px-10 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl text-white font-bold text-lg shadow-lg hover:scale-105 transition">
                    Thêm Phụ đề
                </button>
                <a href="{{ route('admin.seasons.episodes.subtitles', [$movie, $season, $episode]) }}"
                   class="px-10 py-4 bg-gray-700 hover:bg-gray-600 rounded-xl text-white font-medium text-lg transition">
                    Hủy bỏ
                </a>
            </div>
        </form>
    </div>
</div>
@endsection