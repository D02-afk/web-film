@extends('admin.layout')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex items-center gap-6 mb-10">
        <a href="{{ route('admin.movies.index') }}" class="text-pink-400 hover:text-pink-300">
            ← Quay lại danh sách phim
        </a>
        <h1 class="text-4xl font-bold text-pink-400">
            Diễn viên & Đạo diễn: {{ $movie->title }}
        </h1>
    </div>

    @if(session('success'))
        <div class="bg-green-900/80 border border-green-600 text-green-300 px-6 py-4 rounded-xl mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-900/80 border border-red-600 text-red-300 px-6 py-4 rounded-xl mb-6">
            {{ session('error') }}
        </div>
    @endif

    <!-- Form thêm diễn viên -->
    <div class="bg-gray-800 rounded-2xl p-8 mb-10 shadow-2xl">
        <h2 class="text-2xl font-bold text-pink-300 mb-6">Thêm diễn viên / đạo diễn</h2>
        <form action="{{ route('admin.movies.cast.store', $movie) }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @csrf
            <div>
                <label class="block text-white font-bold mb-2">Diễn viên</label>
                <select name="actor_id" required class="w-full px-5 py-4 rounded-xl bg-gray-700 text-white focus:ring-4 focus:ring-pink-500">
                    <option value="">-- Chọn diễn viên --</option>
                    @foreach($actors as $actor)
                        <option value="{{ $actor->id }}">{{ $actor->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-white font-bold mb-2">Vai trò</label>
                <select name="role" required class="w-full px-5 py-4 rounded-xl bg-gray-700 text-white focus:ring-4 focus:ring-pink-500">
                    <option value="actor">Diễn viên</option>
                    <option value="director">Đạo diễn</option>
                </select>
            </div>

            <div>
                <label class="block text-white font-bold mb-2">Tên nhân vật (nếu có)</label>
                <input type="text" name="character_name" placeholder="Ví dụ: Iron Man"
                       class="w-full px-5 py-4 rounded-xl bg-gray-700 text-white focus:ring-4 focus:ring-pink-500">
            </div>

            <div class="flex items-end">
                <button type="submit"
                        class="bg-gradient-to-r from-pink-600 to-rose-600 px-10,py-4 rounded-xl text-white font-bold hover:scale-105 transition w-full">
                    + Thêm vào phim
                </button>
            </div>
        </form>
    </div>

    <!-- Danh sách đã gán -->
    <div class="bg-gray-800/50 backdrop-blur rounded-2xl shadow-2xl overflow-hidden border border-gray-700">
        <table class="w-full text-left">
            <thead class="bg-gradient-to-r from-pink-900/50 to-purple-900/50">
                <tr>
                    <th class="px-6 py-5 text-pink-300 font-bold">Ảnh</th>
                    <th class="px-6 py-5 text-pink-300 font-bold">Tên</th>
                    <th class="px-6 py-5 text-pink-300 font-bold">Vai trò</th>
                    <th class="px-6 py-5 text-pink-300 font-bold">Nhân vật</th>
                    <th class="px-6 py-5 text-pink-300 font-bold text-center">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @forelse($movie->cast as $cast)
                    <tr class="hover:bg-gray-700/50 transition">
                        <td class="px-6 py-5">
                            <img src="{{ $cast->actor->avatar_url }}" class="w-12 h-12 rounded-full object-cover ring-2 ring-pink-500/50">
                        </td>
                        <td class="px-6 py-5 font-semibold text-white">{{ $cast->actor->name }}</td>
                        <td class="px-6 py-5">
                            @if($cast->role === 'director')
                                <span class="bg-purple-600 text-white px-4 py-2 rounded-full text-sm font-bold">ĐẠO DIỄN</span>
                            @else
                                <span class="bg-blue-600 text-white px-4 py-2 rounded-full text-sm">DIỄN VIÊN</span>
                            @endif
                        </td>
                        <td class="px-6 py-5 text-gray-300">
                            {{ $cast->character_name ?: '-' }}
                        </td>
                        <td class="px-6 py-5 text-center">
                            <form action="{{ route('admin.movies.cast.destroy', $cast) }}" method="POST"
                                  onsubmit="return confirm('Xóa {{ addslashes($cast->actor->name) }} khỏi phim này?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 px-5 py-3 rounded-lg font-bold text-sm transition">
                                    Xóa
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-20 text-gray-500 text-xl">
                            Chưa có diễn viên nào được gán cho phim này
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection