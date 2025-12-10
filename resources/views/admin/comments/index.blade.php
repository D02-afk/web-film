@extends('admin.layout')

@section('content')
<div class="max-w-7xl mx-auto">

    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-purple-400">Quản Lý Bình Luận</h1>
        <div class="text-gray-400">
            Tổng: <span class="font-bold text-xl text-purple-300">{{ $comments->total() }}</span> bình luận
        </div>
    </div>

    @if(session('success'))
    <div class="bg-gradient-to-r from-green-900/80 to-emerald-900/80 border border-green-600 
                    text-green-300 px-8 py-5 rounded-2xl mb-8 shadow-lg backdrop-blur-sm">
        <span class="font-semibold">{{ session('success') }}</span>
    </div>
    @endif

    <!-- FORM TÌM KIẾM + LỌC -->
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl p-6 shadow-2xl border border-gray-700 mb-8">
        <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-4 items-end">
            <div class="lg:col-span-5">
                <label class="block text-xs font-medium text-gray-400 mb-2">Tìm kiếm bình luận</label>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Nội dung bình luận, tên người dùng, tên phim..."
                    class="w-full px-4 py-3 bg-gray-700/70 border border-gray-600 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-500 transition">
            </div>

            <div class="lg:col-span-4">
                <label class="block text-xs font-medium text-gray-400 mb-2">Lọc theo phim</label>
                <select name="movie"
                    class="w-full px-4 py-3 bg-gray-700/70 border border-gray-600 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <option value="">Tất cả phim</option>
                    @foreach($movies as $id => $title)
                    <option value="{{ $id }}" {{ request('movie') == $id ? 'selected' : '' }}>
                        {{ $title }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="lg:col-span-3 flex gap-3">
                <button type="submit"
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 rounded-xl text-white font-bold shadow-lg hover:shadow-purple-500/50 transform hover:scale-105 transition">
                    Tìm Kiếm
                </button>
                <a href="{{ route('admin.comments.index') }}"
                    class="px-6 py-3 bg-gray-700 hover:bg-gray-600 rounded-xl text-white font-medium transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- BẢNG DANH SÁCH BÌNH LUẬN -->
    <div class="bg-gray-800 rounded-2xl overflow-hidden shadow-2xl">
        <table class="w-full">
            <thead class="bg-gradient-to-r from-purple-900/50 to-pink-900/50">
                <tr>
                    <th class="px-6 py-5 text-left text-purple-300 font-bold">Người dùng</th>
                    <th class="px-6 py-5 text-left text-purple-300 font-bold">Phim</th>
                    <th class="px-6 py-5 text-left text-purple-300 font-bold w-2/5">Nội dung bình luận</th>
                    <th class="px-6 py-5 text-center text-purple-300 font-bold">Thời gian</th>
                    <th class="px-6 py-5 text-center text-purple-300 font-bold">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @forelse($comments as $comment)
                <tr class="hover:bg-gray-700/50 transition group">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if($comment->user?->avatar)
                            <img src="{{ $comment->user->avatar ?? asset('images/avatar-default.jpg') }}"
                                class="w-10 h-10 rounded-full object-cover ring-2 ring-purple-500/30">
                            @else
                            <div
                                class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-600 to-pink-600 flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr($comment->user?->name ?? 'A', 0, 1)) }}
                            </div>
                            @endif
                            <div>
                                <div class="font-semibold text-white">{{ $comment->user?->name ?? 'Khách' }}</div>
                                <div class="text-xs text-gray-400">{{ $comment->user?->email ?? '—' }}</div>
                            </div>
                        </div>
                    </td>

                    <td class="px-6 py-4">
                        <a href=""
                            class="font-medium text-purple-300 hover:text-purple-100 underline">
                            {{ Str::limit($comment->movie->title, 30) }}
                        </a>
                    </td>

                    <td class="px-6 py-4 text-gray-300 leading-relaxed">
                        {{ Str::limit(preg_replace('/<\/?p>/', '', $comment->content), 150) }}
                        @if(strlen($comment->content) > 150)
                        <span class="text-purple-400 text-xs">... (đọc thêm)</span>
                        @endif
                    </td>

                    <td class="px-6 py-4 text-center text-gray-400 text-sm">
                        {{ $comment->created_at->format('d/m/Y H:i') }}
                        <div class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</div>
                    </td>

                    <td class="px-6 py-4 text-center">
                        <div
                            class="flex items-center justify-center gap-3 opacity-0 group-hover:opacity-100 transition">
                            <!-- Nút Xóa -->
                            <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Xóa bình luận này?\n\nNội dung: {{ addslashes(Str::limit($comment->content, 50)) }}')"
                                    class="text-red-400 hover:text-red-300 font-bold text-lg transition transform hover:scale-125"
                                    title="Xóa bình luận">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-16 text-gray-500 text-xl">
                        @if(request()->hasAny(['search', 'movie']))
                        Không tìm thấy bình luận nào phù hợp
                        @else
                        Chưa có bình luận nào
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Phân trang -->
        @if($comments->hasPages())
        <div class="p-6 bg-gray-900 border-t border-gray-700">
            {{ $comments->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection