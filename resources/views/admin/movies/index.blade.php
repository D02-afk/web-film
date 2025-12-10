@extends('admin.layout')

@section('content')
<div class="max-w-7xl mx-auto">

    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold text-purple-400">Quản Lý Phim</h1>
        <a href="{{ route('admin.movies.create') }}"
            class="bg-gradient-to-r from-green-600 to-emerald-600 px-8 py-4 rounded-xl text-white font-bold shadow-lg hover:scale-105 transition">
            + Thêm Phim Mới
        </a>
    </div>
    @if(session('success'))
    <div class="bg-gradient-to-r from-green-900/80 to-emerald-900/80 border border-green-600 
                    text-green-300 px-8 py-5 rounded-2xl mb-8 shadow-lg backdrop-blur-sm">
        <span class="font-semibold">{{ session('success') }}</span>
    </div>
    @endif

    <!-- FORM TÌM KIẾM + LỌC (giữ nguyên như cũ) -->
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl p-6 shadow-2xl border border-gray-700 mb-8">
        <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-4 items-end">
            <!-- ... phần tìm kiếm giữ nguyên như bạn đã có ... -->
            <!-- (không thay đổi gì ở đây) -->
            <div class="lg:col-span-4">
                <label class="block text-xs font-medium text-gray-400 mb-2">Tìm kiếm</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Tên phim, slug, năm..."
                    class="w-full px-4 py-3 bg-gray-700/70 border border-gray-600 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-purple-500 transition">
            </div>
            <div class="lg:col-span-2">
                <label class="block text-xs font-medium text-gray-400 mb-2">Quốc gia</label>
                <select name="country"
                    class="w-full px-4 py-3 bg-gray-700/70 border border-gray-600 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <option value="">Tất cả</option>
                    @foreach($countries as $c)
                    <option value="{{ $c->id }}" {{ request('country') == $c->id ? 'selected' : '' }}>{{ $c->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="lg:col-span-2">
                <label class="block text-xs font-medium text-gray-400 mb-2">Loại phim</label>
                <select name="type"
                    class="w-full px-4 py-3 bg-gray-700/70 border border-gray-600 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <option value="">Tất cả</option>
                    <option value="1" {{ request('type') == 1 ? 'selected' : '' }}>Phim lẻ</option>
                    <option value="2" {{ request('type') == 2 ? 'selected' : '' }}>Phim bộ</option>
                </select>
            </div>
            <div class="lg:col-span-2 relative" x-data="{ open: false }">
                <label class="block text-xs font-medium text-gray-400 mb-2">Thể loại</label>
                <button type="button" @click="open = !open"
                    class="w-full px-4 py-3 bg-gray-700/70 border border-gray-600 rounded-xl text-white text-left flex justify-between items-center focus:outline-none focus:ring-2 focus:ring-purple-500 transition">
                    <span
                        x-text="document.querySelectorAll('input[name=\'genres[]\']:checked').length || 'Tất cả'"></span>
                    <svg class="w-5 h-5 transition-transform" :class="open ? 'rotate-180' : ''" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="open" @click.away="open = false" x-transition
                    class="absolute z-50 mt-2 w-full bg-gray-800 border border-gray-700 rounded-xl shadow-2xl max-h-64 overflow-y-auto">
                    @foreach($allGenres as $genre)
                    <label class="flex items-center px-4 py-3 hover:bg-gray-700 transition cursor-pointer">
                        <input type="checkbox" name="genres[]" value="{{ $genre->id }}"
                            {{ in_array($genre->id, (array)request('genres')) ? 'checked' : '' }}
                            class="w-4 h-4 text-purple-600 rounded focus:ring-purple-500">
                        <span class="ml-3 text-gray-300">{{ $genre->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            <div class="lg:col-span-2 flex gap-3">
                <button type="submit"
                    class="flex-1 px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 rounded-xl text-white font-bold shadow-lg hover:shadow-purple-500/50 transform hover:scale-105 transition">
                    Tìm
                </button>
                <a href="{{ route('admin.movies.index') }}"
                    class="px-6 py-3 bg-gray-700 hover:bg-gray-600 rounded-xl text-white font-medium transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- BẢNG DANH SÁCH PHIM – ĐÃ THÊM CỘT “MÙA & TẬP” -->
    <div class="bg-gray-800 rounded-2xl overflow-hidden shadow-2xl">
        <table class="w-full">
            <thead class="bg-gradient-to-r from-purple-900/50 to-pink-900/50">
                <tr>
                    <th class="px-6 py-5 text-left text-purple-300 font-bold">Poster</th>
                    <th class="px-6 py-5 text-left text-purple-300 font-bold">Tên phim</th>
                    <th class="px-6 py-5 text-center text-purple-300 font-bold">Năm</th>
                    <th class="px-6 py-5 text-center text-purple-300 font-bold">Quốc gia</th>
                    <th class="px-6 py-5 text-center text-purple-300 font-bold">Thể loại</th>
                    <th class="px-8 py-5 text-center text-purple-300 font-bold">Loại</th>
                    <th class="px-6 py-5 text-center text-purple-300 font-bold">Diễn viên</th>
                    <th class="px-6 py-5 text-center text-purple-300 font-bold">Mùa & Tập</th> <!-- CỘT MỚI -->
                    <th class="px-6 py-5 text-center text-purple-300 font-bold">Lượt xem</th>
                    <th class="px-6 py-5 text-center text-purple-300 font-bold">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
                @forelse($movies as $movie)
                <tr class="hover:bg-gray-700/50 transition group">
                    <td class="px-6 py-4">
                        <img src="{{ $movie->poster ? asset( $movie->poster) : asset('images/no-image.jpg') }}"
                            class="w-12 h-18 object-cover rounded-lg shadow-lg ring-2 ring-purple-500/30">
                    </td>
                    <td class="px-6 py-4 font-semibold text-lg text-white max-w-sm truncate">
                        {{ $movie->title }}
                    </td>
                    <td class="text-center text-gray-300">{{ $movie->year ?? '—' }}</td>
                    <td class="text-center">
                        <span class="px-3 py-1 bg-purple-900/50 rounded-full text-xs font-medium text-purple-300">
                            {{ $movie->country?->name ?? '—' }}
                        </span>
                    </td>
                    <td class="text-center">
                        <div class="flex flex-wrap gap-1 justify-center">
                            @foreach($movie->genres as $g)
                            <span class="px-2 py-1 bg-pink-900/50 text-pink-300 rounded text-xs font-medium">
                                {{ $g->name }}
                            </span>
                            @endforeach
                        </div>
                    </td>
                    <td class="text-center">
                        <span class="px-4 py-2 rounded-full text-xs font-bold
                            {{ $movie->type == 1 ? 'bg-blue-600 text-blue-100' : 'bg-orange-600 text-orange-100' }}">
                            {{ $movie->type == 1 ? 'Phim lẻ' : 'Phim bộ' }}
                        </span>
                    </td>

                    <!-- CỘT DIỄN VIÊN -->
                    <td class="text-center">
                        <a href="{{ route('admin.movies.cast.index', $movie) }}"
                            class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 
                                  px-5 py-3 rounded-full text-white font-bold text-sm shadow-lg transform hover:scale-110 transition-all duration-200">
                            <!-- <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" />
                            </svg> -->
                            <span>{{ $movie->cast->count() }}</span>
                        </a>
                    </td>

                    <!-- CỘT MỚI: QUẢN LÝ MÙA & TẬP -->
                    <!-- CỘT MỚI: MÙA & TẬP – HOẠT ĐỘNG CHO CẢ PHIM LẺ + PHIM BỘ -->
                    <td class="text-center">
                        @if($movie->type == 2)
                        <!-- PHIM BỘ: vào trang quản lý mùa -->
                        <a href="{{ route('admin.movies.seasons.index', $movie) }}"
                            class="inline-flex items-center gap-2 bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-700 hover:to-cyan-700 
                  px-6 py-3 rounded-full text-white font-bold text-sm shadow-lg transform hover:scale-110 transition-all duration-200">
                            <i class="fas fa-list-ol"></i>
                            <span>{{ $movie->seasons->sum(fn($s) => $s->episodes->count()) }} tập</span>
                        </a>
                        @else
                        @php
                        $season = $movie->seasons->first();
                        if (!$season) {
                        $season = $movie->seasons()->create([
                        'season_number' => 1,
                        'title' => 'Phim lẻ'
                        ]);
                        $season->episodes()->create([
                        'episode_number' => 1,
                        'title' => 'Full',
                        'movie_id' => $movie->id
                        ]);
                        }
                        $episode = $season->episodes->first();
                        @endphp

                        <a href="{{ route('admin.seasons.episodes.index', [$movie, $season]) }}"
                            class="inline-flex items-center gap-2 bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 
                  px-6 py-3 rounded-full text-white font-bold text-sm shadow-lg transform hover:scale-110 transition-all duration-200">
                            <i class="fas fa-play-circle"></i>
                            <span>
                                @if($episode->servers->count() > 0)
                                {{ $episode->servers->count() }} link
                                @else
                                Thêm link phim
                                @endif
                            </span>
                        </a>
                        @endif
                    </td>

                    <td class="text-center font-medium text-gray-300">
                        {{ number_format($movie->views ?? 0) }}
                    </td>

                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-4 opacity-0 group-hover:opacity-100 transition">

                            {{-- NÚT XEM CHI TIẾT (MỚI) --}}
                            <a href="{{ route('admin.movies.show', $movie) }}"
                                class="inline-flex items-center gap-2 bg-gradient-to-r from-cyan-600 to-blue-600
                  px-5 py-3 rounded-full font-bold text-sm shadow-lg transform hover:scale-110 transition-all duration-200" title="Xem chi tiết phim">
                                <span class="hidden sm:inline">
                                    <i class="fa-solid fa-wrench" style="color: #FFD43B;"></i>
                                </span>
                            </a>

                            {{-- Nút Sửa --}}
                            <!-- <a href="{{ route('admin.movies.edit', $movie) }}"
                                class="text-yellow-400 hover:text-yellow-300 font-bold text-lg">
                                Sửa
                            </a> -->

                            {{-- Nút Xóa --}}
                            <form action="{{ route('admin.movies.destroy', $movie) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Xóa phim «{{ addslashes($movie->title) }}»?')"
                                    class="text-red-400 hover:text-red-300 font-bold text-lg">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center py-16 text-gray-500 text-xl">
                        @if(request()->hasAny(['search', 'country', 'type', 'genres']))
                        Không tìm thấy phim nào phù hợp
                        @else
                        Chưa có phim nào
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Phân trang -->
        <div class="p-6 bg-gray-900 border-t border-gray-700">
            {{ $movies->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection