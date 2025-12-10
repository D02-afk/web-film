@extends('admin.layout')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-4xl font-bold text-pink-400 mb-10">Thêm Người Dùng Mới</h1>

    <form action="{{ route('admin.users.store') }}" method="POST" class="bg-gray-800 rounded-2xl p-8 shadow-2xl">
        @csrf
        <div class="mb-6">
            <label class="block text-white font-bold mb-2">Họ tên</label>
            <input type="text" name="name" required
                   class="w-full px-5 py-4 rounded-xl bg-gray-700 text-white focus:outline-none focus:ring-4 focus:ring-pink-500"
                   value="{{ old('name') }}">
            @error('name') <p class="text-red-400 mt-2">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label class="block text-white font-bold mb-2">Email</label>
            <input type="email" name="email" required
                   class="w-full px-5 py-4 rounded-xl bg-gray-700 text-white focus:outline-none focus:ring-4 focus:ring-pink-500"
                   value="{{ old('email') }}">
            @error('email') <p class="text-red-400 mt-2">{{ $message }}</p> @enderror
        </div>

        <div class="mb-8">
            <label class="flex items-center space-x-3">
                <input type="checkbox" name="is_admin" class="w-6 h-6 text-pink-600 rounded focus:ring-pink-500">
                <span class="text-white font-bold">Là Quản Trị Viên</span>
            </label>
        </div>

        <div class="bg-amber-900/50 border border-amber-600 rounded-xl p-4 mb-8">
            <p class="text-amber-300 font-bold">
                Mật khẩu mặc định: <span class="text-xl">1</span>
                <br><small>(Người dùng nên đổi ngay sau khi đăng nhập)</small>
            </p>
        </div>

        <div class="flex gap-4">
            <button type="submit"
                    class="bg-gradient-to-r from-pink-600 to-rose-600 px-10 py-4 rounded-xl text-white font-bold hover:scale-105 transition">
                Thêm Người Dùng
            </button>
            <a href="{{ route('admin.users.index') }}"
               class="bg-gray-600 px-8 py-4 rounded-xl text-white font-bold hover:bg-gray-700 transition">
                Hủy
            </a>
        </div>
    </form>
</div>
@endsection