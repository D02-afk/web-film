@extends('admin.layout')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-gray-800 rounded-2xl shadow-2xl p-8">
        <h1 class="text-3xl font-bold text-purple-400 mb-8">Thêm Server Mới</h1>

        <form action="{{ route('admin.seasons.episodes.servers.store', [$movie, $season, $episode]) }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Tên Server (VD: Vietsub HD, Lồng Tiếng, Netflix...)</label>
                    <input type="text" name="server_name" required class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-xl text-white focus:ring-2 focus:ring-purple-500" placeholder="Vietsub FHD">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Link Video (URL đầy đủ)</label>
                    <input type="url" name="video_url" required class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-xl text-white focus:ring-2 focus:ring-purple-500" placeholder="https://...">
                </div>
            </div>

            <div class="mt-8 flex gap-4">
                <button type="submit"
                    class="px-8 py-4 bg-gradient-to-r from-green-600 to-emerald-600 rounded-xl text-white font-bold hover:scale-105 transition">
                    Thêm Server
                </button>
                <a href="{{ route('admin.seasons.episodes.servers', [$movie, $season, $episode]) }}"
                   class="px-8 py-4 bg-gray-700 rounded-xl text-white font-medium hover:bg-gray-600 transition">
                    Hủy
                </a>
            </div>
        </form>
    </div>
</div>
@endsection