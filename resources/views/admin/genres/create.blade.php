@extends('admin.layout')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-4xl font-bold mb-10 text-green-400">Thêm Thể Loại Mới</h1>

    <form action="{{ route('admin.genres.store') }}" method="POST" class="bg-gray-800 rounded-2xl p-8 shadow-2xl">
        @csrf

        <div class="mb-8">
            <label class="block text-lg text-gray-300 mb-3">Tên thể loại *</label>
            <input type="text" name="name" required value="{{ old('name') }}"
                   class="w-full px-6 py-4 bg-gray-700 rounded-xl text-white focus:ring-4 focus:ring-purple-500"
                   placeholder="Ví dụ: Hành Động, Tình Cảm, Kinh Dị...">
            @error('name') <p class="text-red-400 mt-2">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-6">
            <a href="{{ route('admin.genres.index') }}" class="px-8 py-4 bg-gray-700 hover:bg-gray-600 rounded-xl text-white font-bold">
                Quay lại
            </a>
            <button type="submit" class="px-10 py-4 bg-gradient-to-r from-green-600 to-emerald-600 rounded-xl text-white font-bold text-xl shadow-xl hover:scale-105 transition">
                THÊM THỂ LOẠI
            </button>
        </div>
    </form>
</div>
@endsection