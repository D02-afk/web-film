@extends('admin.layout')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-purple-400">Quản Lý Thể Loại</h1>
        <a href="{{ route('admin.genres.create') }}"
           class="bg-gradient-to-r from-green-600 to-emerald-600 px-6 py-3 rounded-xl text-white font-bold shadow-lg hover:scale-105 transition">
            + Thêm Thể Loại
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-900/80 border border-green-600 text-green-300 px-6 py-4 rounded-xl mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-gray-800 rounded-2xl overflow-hidden shadow-2xl">
        <table class="w-full">
            <thead class="bg-gray-700">
                <tr>
                    <th class="px-8 py-5 text-left">STT</th>
                    <th class="px-8 py-5 text-left">Tên thể loại</th>
                    <th class="px-8 py-5 text-left">Slug</th>
                    <th class="px-8 py-5 text-center">Số phim</th>
                    <th class="px-8 py-5 text-center">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($genres as $index => $genre)
                <tr class="border-b border-gray-700 hover:bg-gray-750 transition">
                    <td class="px-8 py-5">{{ $loop->iteration + ($genres->currentPage() - 1) * $genres->perPage() }}</td>
                    <td class="px-8 py-5 font-semibold">{{ $genre->name }}</td>
                    <td class="px-8 py-5 text-gray-400 font-mono text-sm">{{ $genre->slug }}</td>
                    <td class="px-8 py-5 text-center">
                        <span class="px-3 py-1 bg-purple-900 rounded-full text-sm font-bold">
                            {{ $genre->movies_count ?? $genre->movies()->count() }}
                        </span>
                    </td>
                    <td class="px-8 py-5 text-center space-x-4">
                        <a href="{{ route('admin.genres.edit', $genre) }}" class="text-yellow-400 hover:text-yellow-300">Sửa</a>
                        <form action="{{ route('admin.genres.destroy', $genre) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Xóa thể loại: {{ $genre->name }} ?')"
                                    class="text-red-400 hover:text-red-300">Xóa</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-12 text-gray-500">Chưa có thể loại nào</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-6 bg-gray-900">
            {{ $genres->links() }}
        </div>
    </div>
</div>
@endsection