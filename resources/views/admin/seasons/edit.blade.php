@extends('admin.layout')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-12">

    <!-- Header -->
    <div class="flex items-center justify-between mb-12">
        <div class="flex items-center gap-6">
            <a href="{{ route('admin.movies.seasons.index', $movie) }}"
               class="text-purple-400 hover:text-purple-300 text-lg font-medium flex items-center gap-3 
                      bg-gray-800/70 px-5 py-3 rounded-xl hover:bg-gray-700/80 transition backdrop-blur-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Quay lại danh sách mùa
            </a>
            <div>
                <h1 class="text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-400">
                    Sửa Mùa Phim
                </h1>
                <p class="text-xl text-gray-300 mt-2">
                    <span class="text-purple-300 font-bold">{{ $movie->title }}</span>
                    <span class="mx-2">→</span>
                    Mùa hiện tại: <span class="text-cyan-400 font-bold">{{ $season->season_number }}</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-gradient-to-br from-gray-800/90 via-purple-900/20 to-gray-800/90 
                rounded-3xl shadow-2xl border border-purple-700/40 backdrop-blur-xl p-10">

        <form action="{{ route('admin.movies.seasons.update', [$movie, $season]) }}" 
              method="POST"
              class="space-y-10">

            @csrf
            @method('PATCH')

            <!-- Số mùa -->
            <div class="group">
                <label for="season_number" class="block text-lg font-bold text-purple-300 mb-4 
                                              group-focus-within:text-purple-200 transition">
                    <i class="fas fa-hashtag mr-2"></i> Số mùa
                </label>
                <div class="relative">
                    <input type="number"
                           id="season_number"
                           name="season_number"
                           required
                           min="1"
                           step="1"
                           value="{{ old('season_number', $season->season_number) }}"
                           class="w-full px-8 py-6 text-2xl font-bold text-white bg-gray-900/80 
                                  border-2 border-purple-600/50 rounded-2xl 
                                  focus:border-purple-400 focus:ring-4 focus:ring-purple-500/30 
                                  focus:outline-none transition-all duration-300
                                  placeholder-gray-500">
                    <div class="absolute inset-y-0 left-0 pl-8 flex items-center pointer-events-none">
                        <span class="text-purple-400 text-2xl font-bold">Mùa</span>
                    </div>
                </div>
                @error('season_number')
                    <p class="text-red-400 text-sm mt-3 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Tên mùa -->
            <div class="group">
                <label for="title" class="block text-lg font-bold text-purple-300 mb-4 
                                         group-focus-within:text-purple-200 transition">
                    <i class="fas fa-heading mr-2"></i> Tên mùa (tùy chọn – để đẹp hơn)
                </label>
                <input type="text"
                       id="title"
                       name="title"
                       placeholder="VD: Mùa 1 - Thời đại hoàng kim, Season 2: Cuộc chiến cuối cùng..."
                       value="{{ old('title', $season->title) }}"
                       class="w-full px-8 py-6 text-xl text-white bg-gray-900/80 
                              border-2 border-purple-600/50 rounded-2xl 
                              focus:border-purple-400 focus:ring-4 focus:ring-purple-500/30 
                              focus:outline-none transition-all duration-300
                              placeholder-gray-500 italic">
                <p class="text-gray-400 text-sm mt-3 ml-2">
                    Nếu để trống sẽ hiển thị: <span class="text-cyan-400 font-medium">"Mùa {{ $season->season_number }}"</span>
                </p>
                @error('title')
                    <p class="text-red-400 text-sm mt-3 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row gap-6 pt-8">
                <button type="submit"
                        class="flex-1 bg-gradient-to-r from-purple-600 to-pink-600 
                               hover:from-purple-700 hover:to-pink-700 
                               px-12 py-6 rounded-2xl text-white font-black text-2xl 
                               shadow-2xl hover:shadow-purple-600/50 
                               transform hover:scale-105 transition-all duration-300 
                               flex items-center justify-center gap-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5 13l4 4L19 7" />
                    </svg>
                    Cập Nhật Mùa
                </button>

                <a href="{{ route('admin.movies.seasons.index', $movie) }}"
                   class="flex-1 text-center bg-gray-700/80 hover:bg-gray-600 
                          px-12 py-6 rounded-2xl text-white font-bold text-xl 
                          backdrop-blur-sm border border-gray-600 
                          transform hover:scale-105 transition-all duration-300 
                          flex items-center justify-center gap-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Hủy bỏ
                </a>
            </div>
        </form>
    </div>

    <!-- Mini info -->
    <div class="mt-12 text-center text-gray-400">
        <p class="text-sm">
            Sau khi cập nhật, bạn sẽ được chuyển về trang quản lý tập của mùa này.
        </p>
    </div>
</div>
@endsection