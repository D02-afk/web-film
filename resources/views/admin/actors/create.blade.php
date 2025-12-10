@extends('admin.layout')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-4xl font-bold text-pink-400 mb-10">Thêm Diễn Viên Mới</h1>

    <form action="{{ route('admin.actors.store') }}" method="POST" enctype="multipart/form-data" class="bg-gray-800 p-8 rounded-2xl shadow-xl">
        @csrf

        <div class="mb-6">
            <label class="block text-white font-bold mb-2">Tên diễn viên *</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   class="w-full px-4 py-3 rounded-lg bg-gray-700 text-white border border-gray-600 focus:border-pink-500 focus:outline-none">
            @error name @enderror
        </div>

        <div class="mb-6">
            <label class="block text-white font-bold mb-2">Ảnh đại diện</label>
            <input type="file" name="avatar" accept="image/*"
                   class="w-full px-4 py-3 rounded-lg bg-gray-700 text-white">
        </div>

        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-white font-bold mb-2">Ngày sinh</label>
                <input type="date" name="birthday" value="{{ old('birthday') }}"
                       class="w-full px-4 py-3 rounded-lg bg-gray-700 text-white">
            </div>
            <div>
                <label class="block text-white font-bold mb-2">Quốc gia</label>
                <input type="text" name="country" value="{{ old('country') }}" placeholder="USA, Việt Nam, Korea..."
                       class="w-full px-4 py-3 rounded-lg bg-gray-700 text-white">
            </div>
        </div>

        <div class="mb-8">
            <label class="block text-white font-bold mb-2">Tiểu sử</label>
            <textarea name="bio" rows="5" class="w-full px-4 py-3 rounded-lg bg-gray-700 text-white">{{ old('bio') }}</textarea>
        </div>

        <div class="flex gap-4">
            <button type="submit"
                    class="bg-gradient-to-r from-pink-600 to-rose-600 px-8 py-4 rounded-xl text-white font-bold hover:scale-105 transition">
                Thêm Diễn Viên
            </button>
            <a href="{{ route('admin.actors.index') }}"
               class="px-8 py-4 bg-gray-700 rounded-xl text-white font-bold hover:bg-gray-600 transition">
                Hủy
            </a>
        </div>
    </form>
</div>
@endsection