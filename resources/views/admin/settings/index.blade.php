@extends('admin.layout')

@section('content')
<div class="max-w-6xl mx-auto py-8">
    <h1 class="text-4xl font-bold text-purple-400 mb-8">Cài Đặt Giao Diện & Nội Dung</h1>

    @if(session('success'))
    <div class="bg-green-900/80 border border-green-600 text-green-300 px-6 py-4 rounded-xl mb-6">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- TAB NAV -->
        <div class="flex gap-6 border-b border-gray-700 mb-8">
            <!-- <button type="button" onclick="showTab('general')"
                class="tab-btn active pb-4 px-2 border-b-4 border-purple-500 text-purple-400 font-bold">Chung</button> -->
            <button type="button" onclick="showTab('appearance')" class="tab-btn active pb-4 px-2 text-gray-400">Giao
                diện</button>
            <button type="button" onclick="showTab('homepage')" class="tab-btn pb-4 px-2 text-gray-400">Trang
                chủ</button>
        </div>

        <!-- TAB CONTENT -->
        <div class="space-y-8">

            <!-- TAB: CHUNG -->
            <!-- <div id="tab-general" class="tab-content">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-white font-bold mb-3">Tên website</label>
                        <input type="text" name="site_name" value="{{ setting('site_name', config('app.name')) }}"
                            class="w-full px-5 py-3 rounded-xl bg-gray-800 text-white">
                    </div>
                    <div>
                        <label class="block text-white font-bold mb-3">Mô tả SEO</label>
                        <input type="text" name="site_description"
                            value="{{ setting('site_description', 'Xem phim hay miễn phí') }}"
                            class="w-full px-5 py-3 rounded-xl bg-gray-800 text-white">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-white font-bold mb-3">Từ khóa SEO (cách nhau bằng dấu phẩy)</label>
                        <textarea name="site_keywords" rows="3"
                            class="w-full px-5 py-3 rounded-xl bg-gray-800 text-white">{{ setting('site_keywords', 'phim hay, xem phim online, phim moi') }}</textarea>
                    </div>
                </div>
            </div> -->

            <!-- TAB: GIAO DIỆN -->
            <div id="tab-appearance" class="tab-content hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-white font-bold mb-3">Logo (PNG, SVG)</label>
                        <input type="file" name="site_logo" accept="image/*"
                            class="w-full px-5 py-3 rounded-xl bg-gray-800 text-white">
                        @if(setting('site_logo'))
                        <img src="{{ asset('storage/' . setting('site_logo')) }}" class="mt-3 h-16 rounded-lg">
                        @endif
                    </div>
                    <div>
                        <label class="block text-white font-bold mb-3">Favicon</label>
                        <input type="file" name="site_favicon" accept=".ico,.png"
                            class="w-full px-5 py-3 rounded-xl bg-gray-800 text-white">
                        @if(setting('site_favicon'))
                        <img src="{{ asset('storage/' . setting('site_favicon')) }}" class="mt-3 h-10 rounded">
                        @endif
                    </div>
                    <div>
                        <label class="block text-white font-bold mb-3">Màu chủ đạo</label>
                        <input type="color" name="theme_color" value="{{ setting('theme_color', '#a855f7') }}"
                            class="w-24 h-12 rounded-lg cursor-pointer">
                        <span class="ml-3 text-gray-300">Hiện tại: {{ setting('theme_color', '#a855f7') }}</span>
                    </div>
                    <!-- <div>
                        <label class="block text-white font-bold mb-3">Poster mặc định</label>
                        <input type="file" name="default_poster" accept="image/*">
                        @if(setting('default_poster'))
                        <img src="{{ asset('storage/' . setting('default_poster')) }}" class="mt-3 h-32 rounded-lg">
                        @endif
                    </div> -->
                    <div>
                        <label class="block text-white font-bold mb-3">Ảnh nền Hero (khuyến nghị 2560x1440)</label>
                        <input type="file" name="hero_background" accept="image/*"
                            class="w-full px-5 py-3 rounded-xl bg-gray-800 text-white">
                        @if(setting('hero_background'))
                        <img src="{{ asset('storage/'.setting('hero_background')) }}"
                            class="mt-4 h-48 rounded-xl object-cover">
                        @endif
                    </div>

                    <div>
                        <label class="block text-white font-bold mb-3">Tên website</label>
                        <input type="text" name="site_name" value="{{ setting('site_name', config('app.name')) }}"
                            class="w-full px-5 py-3 rounded-xl bg-gray-800 text-white">
                    </div>

                    <div>
                        <label class="block text-white font-bold mb-3">Tiêu đề Thumbnail</label>
                        <input type="text" name="hero_title" value="{{ setting('hero_title', 'FilmMWE') }}"
                            class="w-full px-5 py-3 rounded-xl bg-gray-800 text-white">
                    </div>

                    <div>
                        <label class="block text-white font-bold mb-3">Mô tả trên Thumbnail</label>
                        <textarea name="hero_description" rows="3"
                            class="w-full px-5 py-3 rounded-xl bg-gray-800 text-white">{{ setting('hero_description') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- TAB: TRANG CHỦ -->
            <div id="tab-homepage" class="tab-content hidden">
                <div class="space-y-6">
                    @foreach(['show_slider', 'show_hot', 'show_new', 'show_single', 'show_series'] as $key)
                    <label
                        class="flex items-center justify-between bg-gray-800 rounded-xl p-5 cursor-pointer hover:bg-gray-700 transition">
                        <div>
                            <div class="text-white font-bold">
                                {{ __("settings.{$key}") }}
                            </div>
                            <p class="text-gray-400 text-sm">Hiển thị khối này trên trang chủ</p>
                        </div>
                        <input type="checkbox" name="{{ $key }}" value="1" {{ setting($key, 1) ? 'checked' : '' }}
                            class="w-6 h-6 text-purple-600 rounded focus:ring-purple-500">
                    </label>
                    @endforeach

                    <div>
                        <label class="block text-white font-bold mb-3">Footer Text</label>
                        <textarea name="footer_text" rows="4"
                            class="w-full px-5 py-3 rounded-xl bg-gray-800 text-white">{{ setting('footer_text', '© 2025 '.config('app.name').'. All rights reserved.') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-12 text-center">
            <button type="submit"
                class="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 px-12 py-5 rounded-xl text-white text-xl font-bold shadow-2xl hover:scale-105 transition">
                Lưu Tất Cả Thay Đổi
            </button>
        </div>
    </form>
</div>

<script>
function showTab(tab) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active', 'text-purple-400',
        'border-purple-500'));
    document.getElementById('tab-' + tab).classList.remove('hidden');
    event.target.classList.add('active', 'text-purple-400', 'border-purple-500');
}
</script>
@endsection