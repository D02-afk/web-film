{{-- resources/views/admin/actors/edit.blade.php --}}
@extends('admin.layout')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-4xl font-bold text-pink-400 mb-10">Chỉnh Sửa: {{ $actor->name }}</h1>

    <form action="{{ route('admin.actors.update', $actor) }}" method="POST" enctype="multipart/form-data" class="bg-gray-800 p-8 rounded-2xl shadow-xl">
        @csrf @method('PUT')

        <div class="mb-6 text-center">
            @if($actor->avatar)
                <img src="{{ asset('storage/' . $actor->avatar) }}" class="w-48 h-48 object-cover rounded-full mx-auto mb-4">
            @else
                <img src="{{ asset('images/no-avatar.jpg') }}" class="w-48 h-48 object-cover rounded-full mx-auto mb-4">
            @endif
        </div>

        {{-- Giống create, chỉ thêm old value --}}
        <div class="mb-6">
            <label class="block text-white font-bold mb-2">Tên diễn viên *</label>
            <input type="text" name="name" value="{{ old('name', $actor->name) }}" required
                   class="w-full px-4 py-3 rounded-lg bg-gray-700 text-white border border-gray-600 focus:border-pink-500">
        </div>

        <div class="mb-6">
            <label class="block text-white font-bold mb-2">Đổi ảnh đại diện</label>
            <input type="file" name="avatar" accept="image/*" class="w-full px-4 py-3 rounded-lg bg-gray-700 text-white">
        </div>

        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <label>Ngày sinh</label>
                <input type="date" name="birthday" value="{{ old('birthday', $actor->birthday?->format('Y-m-d')) }}"
                       class="w-full px-4 py-3 rounded-lg bg-gray-700 text-white">
            </div>
            <div>
                <label>Quốc gia</label>
                <input type="text" name="country" value="{{ old('country', $actor->country) }}"
                       class="w-full px-4 py-3 rounded-lg bg-gray-700 text-white">
            </div>
        </div>

        <div class="mb-8">
            <label>Tiểu sử</label>
            <textarea name="bio" rows="5" class="w-full px-4 py-3 rounded-lg bg-gray-700 text-white">{{ old('bio', $actor->bio) }}</textarea>
        </div>

        <button type="submit" class="bg-gradient-to-r from-pink-600 to-rose-600 px-8 py-4 rounded-xl text-white font-bold hover:scale-105 transition">
            Cập Nhật
        </button>
    </form>
</div>
@endsection