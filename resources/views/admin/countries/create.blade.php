@extends('admin.layout')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-4xl font-bold mb-10 text-cyan-400">Thêm Quốc Gia Mới</h1>

    <form action="{{ route('admin.countries.store') }}" method="POST" class="bg-gray-800 rounded-2xl p-10 shadow-2xl">
        @csrf

        <div class="mb-8">
            <label class="block text-lg text-gray-300 mb-3">Tên quốc gia *</label>
            <input type="text" name="name" required value="{{ old('name') }}"
                   class="w-full px-6 py-4 bg-gray-700 rounded-xl text-white focus:ring-4 focus:ring-cyan-500"
                   placeholder="Ví dụ: Việt Nam, Mỹ, Hàn Quốc...">
            @error('name') <p class="text-red-400 mt-2">{{ $message }}</p> @enderror
        </div>

        <div class="mb-10">
            <label class="block text-lg text-gray-300 mb-3">Mã quốc gia (ISO 2 chữ) *</label>
            <input type="text" name="code" required maxlength="2" value="{{ old('code') }}"
                   class="w-full px-6 py-4 bg-gray-700 rounded-xl text-white uppercase font-mono text-xl tracking-widest text-center focus:ring-4 focus:ring-cyan-500"
                   placeholder="VD: VN, US, KR, JP">
            @error('code') <p class="text-red-400 mt-2">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-6">
            <a href="{{ route('admin.countries.index') }}"
               class="px-10 py-4 bg-gray-700 hover:bg-gray-600 rounded-xl text-white font-bold">
                Quay lại
            </a>
            <button type="submit"
                    class="px-12 py-4 bg-gradient-to-r from-cyan-600 to-blue-600 rounded-xl text-white font-bold text-xl shadow-xl hover:scale-105 transition">
                THÊM QUỐC GIA
            </button>
        </div>
    </form>
</div>
@endsection