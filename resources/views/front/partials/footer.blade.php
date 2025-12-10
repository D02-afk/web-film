<footer class="bg-black border-t border-gray-800 py-12 mt-20 lg:mt-32">
    <div class="container mx-auto px-5 sm:px-6 lg:px-8">

        <!-- Logo + Tên site -->
        <div class="text-center mb-10">
            <div class="flex justify-center mb-5">
                @if(setting('site_logo'))
                    <img src="{{ asset('storage/'.setting('site_logo')) }}" alt="{{ setting('site_name') }}" 
                         class="h-10 sm:h-12 mx-auto rounded">
                @else
                    <h2 class="text-2xl sm:text-3xl font-black bg-gradient-to-r from-primary to-pink-500 bg-clip-text text-transparent">
                        {{ setting('site_name', 'FilmMWE') }}
                    </h2>
                @endif
            </div>

            <!-- Mô tả ngắn gọn -->
            <p class="text-gray-400 text-sm sm:text-base leading-relaxed max-w-3xl mx-auto px-4">
                {{ setting('footer_text', '© '.date('Y').' '.setting('site_name').'. Xem phim online miễn phí chất lượng cao với phụ đề tiếng việt - thuyết minh - lồng tiếng. FilmMWE luôn cập nhật phim mới để mang đến trải nghiệm tuyệt vời cho các bạn.') }}
            </p>
        </div>

        <!-- Menu links  -->
        <div class="flex flex-wrap justify-center gap-x-8 gap-y-4 text-sm sm:text-base mb-10">
            <a href="#" class="text-gray-500 hover:text-primary transition">
                Giới thiệu
            </a>
            <a href="#" class="text-gray-500 hover:text-primary transition">
                Liên hệ
            </a>
            <a href="#" class="text-gray-500 hover:text-primary transition">
                DMCA
            </a>
            <a href="#" class="text-gray-500 hover:text-primary transition">
                Điều khoản dịch vụ
            </a>
            <a href="#" class="text-gray-500 hover:text-primary transition">
                Chính sách bảo mật
            </a>
        </div>

        <!-- Social Icons -->
        <!-- <div class="flex justify-center gap-5 mb-10">
            @if(setting('facebook'))
                <a href="{{ setting('facebook') }}" target="_blank" class="w-11 h-11 rounded-full bg-gray-800 hover:bg-primary flex items-center justify-center transition">
                    <i class="fab fa-facebook-f"></i>
                </a>
            @endif
            @if(setting('telegram'))
                <a href="{{ setting('telegram') }}" target="_blank" class="w-11 h-11 rounded-full bg-gray-800 hover:bg-sky-500 flex items-center justify-center transition">
                    <i class="fab fa-telegram-plane"></i>
                </a>
            @endif
            @if(setting('youtube'))
                <a href="{{ setting('youtube') }}" target="_blank" class="w-11 h-11 rounded-full bg-gray-800 hover:bg-red-600 flex items-center justify-center transition">
                    <i class="fab fa-youtube"></i>
                </a>
            @endif
            <a href="#" class="w-11 h-11 rounded-full bg-gray-800 hover:bg-pink-600 flex items-center justify-center transition">
                <i class="fab fa-tiktok"></i>
            </a>
        </div> -->

        <div class="text-center text-xs sm:text-sm text-gray-600 border-t border-gray-800 pt-8">
            <p>© {{ date('Y') }} <span class="text-primary font-medium">{{ setting('site_name', 'FilmMWE') }}</span>. 
               All rights reserved. I am <span class="text-red-500">❤</span> Cter Hê Hê Hê Hê Hê.
            </p>
            <p class="mt-2">Phim chỉ mang tính chất giải trí - Không lưu trữ bất kỳ file nào trên server.</p>
        </div>
    </div>
</footer>