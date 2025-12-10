@extends('admin.layout')

@section('content')
<div class="max-w-6xl mx-auto">

    {{-- Header --}}
    <div class="flex justify-between items-start mb-10">
        <div>
            <h1 class="text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-orange-500">
                {{ $movie->title }}
            </h1>
            @if($movie->origin_name && $movie->origin_name != $movie->title)
                <p class="text-2xl text-gray-400 mt-2 italic">{{ $movie->origin_name }}</p>
            @endif
        </div>

        <a href="{{ route('admin.movies.index') }}"
           class="px-6 py-3 bg-gray-700 hover:bg-gray-600 rounded-xl text-white font-bold transition">
            ← Quay lại danh sách
        </a>
    </div>

    {{-- Main Card --}}
    <form action="{{ route('admin.movies.update', $movie) }}" method="POST" enctype="multipart/form-data"
          class="bg-gray-800/90 backdrop-blur-xl rounded-3xl shadow-2xl border border-gray-700 overflow-hidden">

        @csrf @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 p-8">

            {{-- CỘT TRÁI: THÔNG TIN CHÍNH + UPLOAD --}}
            <div class="lg:col-span-7 space-y-8">

                {{-- ID + Slug + Year --}}
                <div class="grid grid-cols-3 gap-6">
                    <div class="bg-gray-900/60 rounded-2xl p-5 border border-gray-700">
                        <label class="text-xs text-gray-500">ID Phim</label>
                        <p class="text-2xl font-bold text-purple-400">#{{ $movie->id }}</p>
                    </div>
                    <div class="bg-gray-900/60 rounded-2xl p-5 border border-gray-700">
                        <label class="text-xs text-gray-500">Slug</label>
                        <input type="text" name="slug" value="{{ old('slug', $movie->slug) }}"
                               class="mt-1 w-full bg-gray-800 border border-gray-600 rounded-lg px-3 py-2 text-white focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div class="bg-gray-900/60 rounded-2xl p-5 border border-gray-700">
                        <label class="text-xs text-gray-500">Năm phát hành</label>
                        <input type="number" name="year" value="{{ old('year', $movie->year) }}" min="1900" max="2035"
                               class="mt-1 w-full bg-gray-800 border border-gray-600 rounded-lg px-3 py-2 text-white">
                    </div>
                </div>

                {{-- Title + Country + Type --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Tiêu đề phim</label>
                        <input type="text" name="title" required value="{{ old('title', $movie->title) }}"
                               class="w-full px-5 py-4 bg-gray-900 border border-gray-700 rounded-xl text-white text-xl font-bold focus:ring-2 focus:ring-yellow-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Quốc gia</label>
                        <select name="country_id" class="w-full px-5 py-4 bg-gray-900 border border-gray-700 rounded-xl text-white">
                            @foreach($countries as $c)
                                <option value="{{ $c->id }}" {{ $movie->country_id == $c->id ? 'selected' : '' }}>
                                    {{ $c->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div>
                        <label class="text-xs text-gray-500">Loại phim</label>
                        <select name="type" class="mt-2 w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-xl text-white">
                            <option value="1" {{ $movie->type == 1 ? 'selected' : '' }}>Phim lẻ</option>
                            <option value="2" {{ $movie->type == 2 ? 'selected' : '' }}>Phim bộ</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500">IMDb</label>
                        <input type="text" name="imdb_score" value="{{ old('imdb_score', $movie->imdb_score) }}"
                               class="mt-2 w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-xl text-white" placeholder="7.8">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500">Thời lượng (phút)</label>
                        <input type="number" name="duration" value="{{ old('duration', $movie->duration) }}"
                               class="mt-2 w-full px-4 py-3 bg-gray-900 border border-gray-700 rounded-xl text-white">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500">Lượt xem</label>
                        <p class="mt-2 text-2xl font-bold text-cyan-400">{{ number_format($movie->views ?? 0) }}</p>
                    </div>
                </div>

                {{-- Flags --}}
                <div class="flex flex-wrap gap-6">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" {{ $movie->is_featured ? 'checked' : '' }}
                               class="w-6 h-6 text-yellow-500 rounded focus:ring-yellow-500">
                        <span class="text-yellow-400 font-bold">Nổi bật (HOT)</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_vip" value="1" {{ $movie->is_vip ? 'checked' : '' }}
                               class="w-6 h-6 text-purple-500 rounded focus:ring-purple-500">
                        <span class="text-purple-400 font-bold">Chỉ VIP xem</span>
                    </label>
                </div>

                {{-- Mô tả --}}
                <div>
                    <label class="block text-lg font-medium text-gray-300 mb-4">Mô tả phim</label>
                    <textarea name="description" rows="6"
                              class="w-full px-6 py-5 bg-gray-900 border border-gray-700 rounded-xl text-white focus:ring-2 focus:ring-purple-500">{{ old('description', $movie->description) }}</textarea>
                </div>

            </div>

            {{-- CỘT PHẢI: ẢNH + THỐNG KÊ --}}
            <div class="lg:col-span-5 space-y-8">

                {{-- Poster & Thumbnail --}}
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500 mb-3">Poster</p>
                        <label class="block cursor-pointer group">
                            <img src="{{ $movie->poster ? asset($movie->poster) : asset('images/no-image.jpg') }}"
                                 class="w-full rounded-2xl shadow-2xl border-4 border-gray-700 group-hover:border-purple-600 transition">
                            <input type="file" name="poster_file" accept="image/*" class="hidden">
                        </label>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-3">Thumbnail</p>
                        <label class="block cursor-pointer group">
                            <img src="{{ $movie->thumbnail ? asset($movie->thumbnail) : asset('images/no-backdrop.jpg') }}"
                                 class="w-full rounded-2xl shadow-2xl border-4 border-gray-700 group-hover:border-green-600 transition">
                            <input type="file" name="thumbnail_file" accept="image/*" class="hidden">
                        </label>
                    </div>
                </div>

                {{-- Thể loại --}}
                <div>
                    <p class="text-lg font-medium text-gray-300 mb-4">Thể loại</p>
                    <div class="grid grid-cols-3 gap-3">
                        @foreach($genres as $g)
                            <label class="flex items-center text-sm cursor-pointer">
                                <input type="checkbox" name="genres[]" value="{{ $g->id }}"
                                       {{ $movie->genres->contains($g->id) ? 'checked' : '' }}
                                       class="w-5 h-5 text-purple-600 rounded">
                                <span class="ml-2 text-gray-300">{{ $g->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Diễn viên --}}
                <div>
                    <div class="flex justify-between items-center mb-3">
                        <p class="text-lg font-medium text-gray-300">Diễn viên ({{ $movie->cast->count() }})</p>
                        <a href="{{ route('admin.movies.cast.index', $movie) }}"
                           class="text-cyan-400 hover:text-cyan-300 text-sm font-bold">Quản lý →</a>
                    </div>
                    <div class="bg-gray-900/60 rounded-xl p-4 max-h-48 overflow-y-auto border border-gray-700">
                        @forelse($movie->cast as $c)
                            <div class="flex items-center justify-between py-2 border-b border-gray-800 last:border-0">
                                <span class="text-gray-300">{{ $c->actor->name }}</span>
                                @if($c->role)<span class="text-xs text-gray-500 italic">{{ $c->role }}</span>@endif
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-8">Chưa có diễn viên</p>
                        @endforelse
                    </div>
                </div>

                {{-- Thống kê tập phim --}}
                <div class="bg-gradient-to-r from-purple-900/50 to-pink-900/50 rounded-2xl p-6 border border-purple-700">
                    <p class="text-xl font-bold text-white mb-4">Tình trạng nội dung</p>
                    <div class="grid grid-cols-2 gap-6 text-center">
                        <div>
                            <p class="text-4xl font-black text-purple-400">{{ $totalEpisodes }}</p>
                            <p class="text-gray-300">Tổng số tập</p>
                        </div>
                        <div>
                            <p class="text-4xl font-black text-cyan-400">{{ $totalServers }}</p>
                            <p class="text-gray-300">Link server</p>
                        </div>
                    </div>
                    <div class="mt-6 text-center">
                        @if($movie->type == 2)
                            <a href="{{ route('admin.movies.seasons.index', $movie) }}"
                               class="inline-block px-8 py-3 bg-gradient-to-r from-teal-600 to-cyan-600 rounded-xl font-bold hover:scale-105 transition">
                                Quản lý mùa & tập
                            </a>
                        @else
                            <a href="{{ route('admin.seasons.episodes.index', [$movie, $movie->seasons->first()]) }}"
                               class="inline-block px-8 py-3 bg-gradient-to-r from-purple-600 to-pink-600 rounded-xl font-bold hover:scale-105 transition">
                                Quản lý link phim
                            </a>
                        @endif
                    </div>
                </div>

            </div>
        </div>

        {{-- NÚT CẬP NHẬT --}}
        <div class="bg-gray-900/80 border-t border-gray-700 px-8 py-6 flex justify-end gap-6">
            <button type="submit"
                    class="px-12 py-5 bg-gradient-to-r from-yellow-600 to-orange-700 hover:from-yellow-700 hover:to-orange-800 
                           rounded-xl text-white font-black text-2xl shadow-2xl transform hover:scale-105 transition duration-300">
                CẬP NHẬT PHIM
            </button>
        </div>
    </form>
</div>
@endsection