@extends('admin.layout')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 mb-10">
        <h1 class="text-4xl font-bold text-pink-400">Quản Lý Người Dùng</h1>
        <a href="{{ route('admin.users.create') }}"
           class="bg-gradient-to-r from-pink-600 to-rose-600 px-7 py-4 rounded-xl text-white font-bold shadow-lg hover:scale-105 transition">
            + Thêm Người Dùng
        </a>
    </div>

    <!-- Thông báo -->
    @if(session('success'))
        <div class="bg-green-900/80 border border-green-600 text-green-300 px-6 py-4 rounded-xl mb-6 backdrop-blur">
            {{ session('success') }}
        </div>
    @endif

    <!-- Ô tìm kiếm nhanh -->
    <div class="mb-8">
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex gap-4">
            <input type="text" name="search" placeholder="Tìm tên hoặc email..."
                   value="{{ request('search') }}"
                   class="flex-1 px-6 py-4 rounded-xl bg-gray-800 text-white placeholder-gray-500 focus:outline-none focus:ring-4 focus:ring-pink-500 transition">
            <button type="submit"
                    class="bg-pink-600 hover:bg-pink-700 px-8 py-4 rounded-xl text-white font-bold transition">
                Tìm
            </button>
            @if(request('search'))
                <a href="{{ route('admin.users.index') }}"
                   class="bg-gray-700 hover:bg-gray-600 px-6 py-4 rounded-xl text-white font-bold transition">
                    Xóa bộ lọc
                </a>
            @endif
        </form>
    </div>

    <!-- Bảng danh sách -->
    <div class="bg-gray-800/50 backdrop-blur rounded-2xl shadow-2xl overflow-hidden border border-gray-700">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gradient-to-r from-pink-900/50 to-purple-900/50">
                    <tr>
                        <th class="px-6 py-5 text-pink-300 font-bold uppercase tracking-wider">ID</th>
                        <th class="px-6 py-5 text-pink-300 font-bold uppercase tracking-wider">Avatar</th>
                        <th class="px-6 py-5 text-pink-300 font-bold uppercase tracking-wider">Họ tên</th>
                        <th class="px-6 py-5 text-pink-300 font-bold uppercase tracking-wider">Email</th>
                        <th class="px-6 py-5 text-pink-300 font-bold uppercase tracking-wider">Quyền</th>
                        <th class="px-6 py-5 text-pink-300 font-bold uppercase tracking-wider">Tham gia</th>
                        <th class="px-6 py-5 text-pink-300 font-bold uppercase tracking-wider text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-700/50 transition group">
                            <td class="px-6 py-5 text-gray-400">#{{ $user->id }}</td>
                            <td class="px-6 py-5">
                                <img src="{{ $comment->user->avatar ?? asset('images/avatar-default.jpg') }}" alt="{{ $user->name }}"
                                     class="w-12 h-12 rounded-full object-cover ring-2 ring-pink-500/50">
                            </td>
                            <td class="px-6 py-5 font-semibold text-white">
                                {{ $user->name }}
                                @if($user->id === auth()->id())
                                    <span class="ml-2 text-xs bg-blue-600/50 px-2 py-1 rounded-full">Bạn</span>
                                @endif
                            </td>
                            <td class="px-6 py-5 text-gray-300">{{ $user->email }}</td>
                            <td class="px-6 py-5">
                                @if($user->is_admin)
                                    <span class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-4 py-2 rounded-full text-sm font-bold">
                                        ADMIN
                                    </span>
                                @else
                                    <span class="bg-gray-600 text-gray-300 px-4 py-2 rounded-full text-sm">
                                        Người dùng
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-5 text-gray-400 text-sm">
                                {{ $user->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-5 text-center">
                                <div class="flex items-center justify-center gap-3 opacity-0 group-hover:opacity-100 transition">
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                       class="bg-yellow-600 hover:bg-yellow-700 px-5 py-2 rounded-lg font-bold text-sm transition">
                                        Sửa
                                    </a>

                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}"
                                              method="POST" class="inline"
                                              onsubmit="return confirm('Xóa {{ addslashes($user->name) }}? Không thể khôi phục!')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    class="bg-red-600 hover:bg-red-700 px-5 py-2 rounded-lg font-bold text-sm transition">
                                                Xóa
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-500 text-xs">Không thể xóa</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-20 text-gray-500 text-xl">
                                @if(request('search'))
                                    Không tìm thấy người dùng nào với từ khóa "{{ request('search') }}"
                                @else
                                    Chưa có người dùng nào
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Phân trang -->
        <div class="px-6 py-5 bg-gray-900/50">
            {{ $users->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection