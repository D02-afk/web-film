@extends('admin.layout')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <div class="flex justify-between items-center mb-10">
        <h1 class="text-4xl font-bold text-pink-400">Quản Lý Diễn Viên</h1>
        <a href="{{ route('admin.actors.create') }}"
           class="bg-gradient-to-r from-pink-600 to-rose-600 px-7 py-4 rounded-xl text-white font-bold shadow-lg hover:scale-105 transition">
            + Thêm Diễn Viên
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-900/80 border border-green-600 text-green-300 px-6 py-4 rounded-xl mb-6">
            {{ session('success') }}
        </div>
    </div>
    @endif

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 2xl:grid-cols-6 gap-8">
        @forelse($actors as $actor)
            <div class="group relative bg-gray-800 rounded-2xl overflow-hidden shadow-xl hover:shadow-2xl transition transform hover:-translate-y-2">
                <div class="aspect-w-2 aspect-h-3 relative">
                    <img src="{{ $actor->avatar ? asset('storage/' . $actor->avatar) : asset('images/no-avatar.jpg') }}"
                         alt="{{ $actor->name }}"
                         class="w-full h-80 object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                </div>

                <div class="absolute bottom-0 left-0 right-0 p-5 text-center text-white">
                    <h3 class="font-bold text-lg truncate">{{ $actor->name }}</h3>
                    <p class="text-sm opacity-90">{{ $actor->movies_count }} phim</p>
                </div>

                <div class="absolute inset-0 bg-black/80 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                    <div class="flex gap-4">
                        <a href="{{ route('admin.actors.edit', $actor) }}"
                           class="bg-yellow-600 hover:bg-yellow-700 px-6 py-3 rounded-lg font-bold transition">
                            Sửa
                        </a>
                        <form action="{{ route('admin.actors.destroy', $actor) }}" method="POST" onsubmit="return confirm('Xóa {{ addslashes($actor->name) }}?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 px-6 py-3 rounded-lg font-bold transition">
                                Xóa
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-20 text-gray-500 text-2xl">
                Chưa có diễn viên nào
            </div>
        @endforelse
    </div>

    <div class="mt-12">
        {{ $actors->links() }}
    </div>
</div>
@endsection