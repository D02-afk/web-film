@extends('admin.layout')

@section('content')
<div class="max-w-5xl mx-auto">
    <h1 class="text-4xl font-bold mb-10 text-green-400">Thêm Phim Mới</h1>

    <form action="{{ route('admin.movies.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-gray-800 rounded-3xl p-10 shadow-2xl">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

            <!-- CỘT TRÁI -->
            <div class="space-y-8">
                <div>
                    <label class="block text-gray-300 mb-2">Tiêu đề phim *</label>
                    <input type="text" name="title" required value="{{ old('title') }}"
                           class="w-full px-5 py-4 bg-gray-700 rounded-xl text-white focus:ring-4 focus:ring-purple-500"
                           placeholder="Nhập tên phim">
                </div>

                <div>
                    <label class="block text-gray-300 mb-2">Slug *</label>
                    <input type="text" name="slug" required value="{{ old('slug') }}"
                           class="w-full px-5 py-4 bg-gray-700 rounded-xl text-white"
                           placeholder="ten-phim-2025">
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-300 mb-2">Năm *</label>
                        <input type="number" name="year" required value="{{ old('year', date('Y')) }}"
                               class="w-full px-5 py-4 bg-gray-700 rounded-xl text-white">
                    </div>
                    <div>
                        <label class="block text-gray-300 mb-2">Quốc gia *</label>
                        <select name="country_id" required class="w-full px-5 py-4 bg-gray-700 rounded-xl text-white">
                            <option value="">Chọn quốc gia</option>
                            @foreach($countries as $c)
                                <option value="{{ $c->id }}" {{ old('country_id')==$c->id?'selected':'' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-gray-300 mb-2">Loại phim *</label>
                    <select name="type" required class="w-full px-5 py-4 bg-gray-700 rounded-xl text-white">
                        <option value="1" {{ old('type',1)==1?'selected':'' }}>Phim lẻ</option>
                        <option value="2" {{ old('type')==2?'selected':'' }}>Phim bộ</option>
                    </select>
                </div>
            </div>

            <!-- CỘT PHẢI – UPLOAD ẢNH (ĐÃ FIX 100%) -->
            <div class="space-y-10">

                <!-- POSTER -->
                <div>
                    <label class="block text-lg text-gray-300 mb-4">Poster phim *</label>
                    <div class="border-4 border-dashed border-gray-600 rounded-2xl p-8 text-center cursor-pointer hover:border-purple-500 transition"
                         x-data="posterDropzone()">
                        <input type="file" name="poster_file" accept="image/*" required hidden
                               x-ref="posterInput"
                               @change="handleFile($event.target.files[0], 'poster')">

                        <div @click="$refs.posterInput.click()" 
                             @drop.prevent="handleFile($event.dataTransfer.files[0], 'poster')"
                             @dragover.prevent @dragenter.prevent @dragleave.prevent>
                            <i class="fas fa-cloud-upload-alt text-6xl text-gray-500 mb-4"></i>
                            <p class="text-xl text-gray-400">Kéo thả hoặc <span class="text-purple-400 underline">click chọn poster</span></p>
                        </div>

                        <img x-show="preview" :src="preview" class="mt-6 max-h-96 mx-auto rounded-xl shadow-2xl object-cover">
                    </div>
                </div>

                <!-- THUMBNAIL -->
                <div>
                    <label class="block text-lg text-gray-300 mb-4">Thumbnail (tùy chọn)</label>
                    <div class="border-4 border-dashed border-gray-600 rounded-2xl p-8 text-center cursor-pointer hover:border-green-500 transition"
                         x-data="thumbDropzone()">
                        <input type="file" name="thumbnail_file" accept="image/*" hidden
                               x-ref="thumbInput"
                               @change="handleFile($event.target.files[0], 'thumb')">

                        <div @click="$refs.thumbInput.click()"
                             @drop.prevent="handleFile($event.dataTransfer.files[0], 'thumb')"
                             @dragover.prevent @dragenter.prevent @dragleave.prevent>
                            <p class="text-gray-400">Kéo thả hoặc click chọn thumbnail</p>
                        </div>

                        <img x-show="preview" :src="preview" class="mt-6 max-h-72 mx-auto rounded-xl shadow-2xl object-cover">
                    </div>
                </div>
            </div>
        </div>

        <!-- THỂ LOẠI & DIỄN VIÊN -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 mt-12">
            <div>
                <label class="block text-lg text-gray-300 mb-5">Thể loại *</label>
                <div class="grid grid-cols-3 md:grid-cols-4 gap-4">
                    @foreach($genres as $g)
                        <label class="flex items-center text-gray-300">
                            <input type="checkbox" name="genres[]" value="{{ $g->id }}"
                                   {{ is_array(old('genres')) && in_array($g->id, old('genres')) ? 'checked' : '' }}
                                   class="w-5 h-5 text-purple-600 rounded focus:ring-purple-500">
                            <span class="ml-3">{{ $g->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="block text-lg text-gray-300 mb-5">Diễn viên</label>
                <select name="actors[]" multiple size="8" class="w-full px-5 py-4 bg-gray-700 rounded-xl text-white">
                    @foreach($actors as $a)
                        <option value="{{ $a->id }}" {{ is_array(old('actors')) && in_array($a->id, old('actors')) ? 'selected' : '' }}>
                            {{ $a->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mt-10">
            <label class="block text-lg text-gray-300 mb-4">Mô tả phim</label>
            <textarea name="description" rows="6" class="w-full px-6 py-5 bg-gray-700 rounded-xl text-white">{{ old('description') }}</textarea>
        </div>

        <div class="flex justify-end gap-6 mt-12">
            <a href="{{ route('admin.movies.index') }}" class="px-10 py-4 bg-gray-700 hover:bg-gray-600 rounded-xl text-white font-bold">Hủy</a>
            <button type="submit" class="px-12 py-4 bg-gradient-to-r from-green-600 to-emerald-600 rounded-xl text-white font-bold text-xl shadow-xl hover:scale-105 transition">
                THÊM PHIM
            </button>
        </div>
    </form>
</div>

<script>
function posterDropzone() {
    return {
        preview: null,
        handleFile(file, type) {
            if (file && file.type.startsWith('image/')) {
                this.preview = URL.createObjectURL(file);
            }
        }
    }
}
function thumbDropzone() {
    return {
        preview: null,
        handleFile(file, type) 
        {
            if (file && file.type.startsWith('image/')) 
                this.preview = URL.createObjectURL(file);
        }
    }
}
</script>
@endsection