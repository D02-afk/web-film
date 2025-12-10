@extends('admin.layout')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-cyan-400">Quản Lý Quốc Gia</h1>
        <a href="{{ route('admin.countries.create') }}"
           class="bg-gradient-to-r from-cyan-600 to-blue-600 px-6 py-3 rounded-xl text-white font-bold shadow-lg hover:scale-105 transition">
            + Thêm Quốc Gia
        </a>
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

    <div class="bg-gray-800 rounded-2xl overflow-hidden shadow-2xl">
        <table class="w-full">
            <thead class="bg-gray-700">
                <tr>
                    <th class="px-8 py-5 text-left">Cờ</th>
                    <th class="px-8 py-5 text-left">Tên quốc gia</th>
                    <th class="px-8 py-5 text-left">Mã (ISO)</th>
                    <th class="px-8 py-5 text-left">Slug</th>
                    <th class="text-center">Số phim</th>
                    <th class="px-8 py-5 text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($countries as $country)
                <tr class="border-b border-gray-700 hover:bg-gray-750 transition">
                    <td class="px-8 py-5">
                        <img src="https://flagcdn.com/48x36/{{ strtolower($country->code) }}.png"
                             alt="{{ $country->name }}"
                             class="w-12 h-9 rounded shadow-lg border border-gray-600"
                             onerror="this.src='https://flagcdn.com/48x36/un.png'">
                    </td>
                    <td class="px-8 py-5 font-semibold text-lg">{{ $country->name }}</td>
                    <td class="px-8 py-5">
                        <span class="px-3 py-1 bg-cyan-900 rounded-full font-mono font-bold">
                            {{ $country->code }}
                        </span>
                    </td>
                    <td class="px-8 py-5 text-gray-400 font-mono text-sm">{{ $country->slug }}</td>
                    <td class="text-center">
                        <span class="px-4 py-2 bg-purple-900 rounded-full text-sm font-bold">
                            {{ $country->movies_count ?? $country->movies()->count() }}
                        </span>
                    </td>
                    <td class="px-8 py-5 text-center space-x-5">
                        <a href="{{ route('admin.countries.edit', $country) }}"
                           class="text-yellow-400 hover:text-yellow-300 font-medium">Sửa</a>
                        <form action="{{ route('admin.countries.destroy', $country) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Xóa quốc gia {{ $country->name }} ({{ $country->code }})?')"
                                    class="text-red-400 hover:text-red-300 font-medium">Xóa</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-16 text-gray-500 text-xl">
                        Chưa có quốc gia nào
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-6 bg-gray-900">
            {{ $countries->links() }}
        </div>
    </div>
</div>
@endsection