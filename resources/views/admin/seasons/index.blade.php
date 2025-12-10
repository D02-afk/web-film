@extends('admin.layout')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 mb-10">
        <div class="flex items-center gap-5">
            <a href="{{ route('admin.movies.index') }}"
               class="text-purple-400 hover:text-purple-300 text-lg font-medium flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Tất cả phim
            </a>
            <h1 class="text-4xl font-bold text-purple-400">
                {{ $movie->title }} – Quản lý mùa
            </h1>
        </div>

        <a href="{{ route('admin.movies.seasons.create', $movie) }}"
           class="bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 
                  px-8 py-4 rounded-xl text-white font-bold text-lg shadow-xl hover:scale-105 transition-all duration-300 
                  flex items-center gap-3 whitespace-nowrap">
            <svg class="w-6 h-6" fill="none" stroke="currentColor"  viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 4v16m8-8H4" />
            </svg>
            + Thêm Mùa Mới
        </a>
    </div>

    <!-- Flash Message -->
    @if(session('success'))
        <div class="bg-gradient-to-r from-green-900/80 to-emerald-900/80 border border-green-600 
                    text-green-300 px-8 py-5 rounded-2xl mb-8 shadow-lg backdrop-blur-sm">
            <span class="font-semibold">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Danh sách mùa -->
    @if($movie->seasons->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
            @foreach($movie->seasons->sortBy('season_number') as $season)
                <div class="group relative bg-gray-800/90 backdrop-blur-xl rounded-3xl overflow-hidden 
                            shadow-2xl border border-purple-800/40 hover:border-purple-600/70 
                            transition-all duration-500 hover:-translate-y-2">

                    <!-- Background gradient khi hover -->
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-600/20 to-pink-600/20 
                                opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>

                    <div class="relative p-8">

                        <!-- Header mùa -->
                        <div class="flex items-center justify-between mb-6">
                            <!-- Số mùa + tên -->
                            <div class="flex items-center gap-6">
                                <div class="w-20 h-20 bg-gradient-to-br from-purple-600 to-pink-600 
                                            rounded-2xl flex items-center justify-center text-3xl font-black text-white 
                                            shadow-2xl ring-4 ring-purple-500/30">
                                    {{ $season->season_number }}
                                </div>
                                <div>
                                    <h3 class="text-2xl font-bold text-white">
                                        {{ $season->title ?? "Mùa {$season->season_number}" }}
                                    </h3>
                                    <p class="text-purple-300 text-lg mt-1">
                                        <span class="font-bold text-xl">{{ $season->episodes->count() }}</span> tập
                                        @if($season->episodes->where('servers_count', '>', 0)->count() > 0)
                                            <span class="text-green-400 text-sm ml-3">✓ Có link phát</span>
                                        @else
                                            <span class="text-yellow-400 text-sm ml-3">Chưa có link</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Nút chính: Quản lý tập – luôn hiện, to đẹp -->
                        <div class="mt-8 mb-10">
                            <a href="{{ route('admin.seasons.episodes.index', [$movie, $season]) }}"
                               class="block w-full text-center bg-gradient-to-r from-cyan-500 to-blue-600 
                                      hover:from-cyan-600 hover:to-blue-700 px-10 py-5 rounded-2xl 
                                      text-white font-bold text-xl shadow-2xl 
                                      transform hover:scale-105 transition-all duration-300 
                                      flex items-center justify-center gap-4">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                Quản lý tập phim
                            </a>
                        </div>

                        <!-- Nút Sửa / Xóa – hiện khi hover -->
                        <div class="flex justify-center gap-4 opacity-0 group-hover:opacity-100 
                                    translate-y-6 group-hover:translate-y-0 transition-all duration-500">
                            <a href="{{ route('admin.movies.seasons.edit', [$movie, $season]) }}"
                               class="bg-gradient-to-r from-yellow-600 to-orange-600 hover:from-yellow-700 hover:to-orange-700 
                                      px-8 py-3 rounded-xl font-bold text-white shadow-lg hover:scale-110 transition">
                                Sửa mùa
                            </a>

                            <form action="{{ route('admin.movies.seasons.destroy', [$movie, $season]) }}"
                                  method="POST"
                                  onsubmit="return confirm('⚠️ XÓA TOÀN BỘ MÙA NÀY?\n\nTất cả tập phim, link server và phụ đề sẽ bị xóa vĩnh viễn!')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 
                                               px-8 py-3 rounded-xl font-bold text-white shadow-lg hover:scale-110 transition">
                                    Xóa mùa
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Không có mùa nào -->
        <div class="text-center py-24">
            <div class="text-8xl mb-6 opacity-30">No seasons yet</div>
            <p class="text-gray-400 text-2xl mb-10">Phim này chưa có mùa nào</p>
            <a href="{{ route('admin.movies.seasons.create', $movie) }}"
               class="inline-block bg-gradient-to-r from-green-600 to-emerald-600 
                      hover:from-green-700 hover:to-emerald-700 px-16 py-7 rounded-3xl 
                      text-white text-3xl font-bold shadow-2xl hover:scale-110 transition-all duration-500">
                + Tạo Mùa Đầu Tiên
            </a>
        </div>
    @endif
</div>
@endsection