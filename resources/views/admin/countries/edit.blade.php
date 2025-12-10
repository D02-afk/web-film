@extends('admin.layout')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-4xl font-bold mb-10 text-yellow-400">Sửa Quốc Gia: {{ $country->name }}</h1>

    <form action="{{ route('admin.countries.update', $country) }}" method="POST" class="bg-gray-800 rounded-2xl p-10 shadow-2xl">
        @csrf @method('PUT')

        <div class="mb-8">
            <label class="block text-lg text-gray-300 mb-3">Tên quốc gia *</label>
            <input type="text" name="name" required value="{{ old('name', $country->name) }}"
                   class="w-full px-6 py-4 bg-gray-700 rounded-xl text-white focus:ring-4 focus:ring-yellow-500">
        </div>

        <div class="mb-10">
            <label class="block text-lg text-gray-300 mb-3">Mã quốc gia (ISO 2 chữ) *</label>
            <input type="text" name="code" required maxlength="2" value="{{ old('code', $country->code) }}"
                   class="w-full px-6 py-4 bg-gray-700 rounded-xl text-white uppercase font-mono text-xl tracking-widest text-center focus:ring-4 focus:ring-yellow-500">
        </div>

        <div class="flex gap-6">
            <a href="{{ route('admin.countries.index') }}"
               class="px-10 py-4 bg-gray-700 hover:bg-gray-600 rounded-xl text-white font-bold">
                Quay lại
            </a>
            <button type="submit"
                    class="px-12 py-4 bg-gradient-to-r from-yellow-600 to-orange-600 rounded-xl text-white font-bold text-xl shadow-xl hover:scale-105 transition">
                CẬP NHẬT
            </button>
        </div>
    </form>
</div>
@endsection