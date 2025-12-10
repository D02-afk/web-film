<header class="fixed top-0 left-0 right-0 z-50 bg-black/80 backdrop-blur-xl border-b border-white/5">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex items-center justify-between gap-4">

            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 flex-shrink-0 z-10">
                @if(setting('site_logo'))
                    <img src="{{ asset('storage/'.setting('site_logo')) }}" alt="Logo" class="h-8 sm:h-9 rounded">
                @else
                    <h1 class="text-xl sm:text-2xl font-black bg-gradient-to-r from-primary to-pink-500 bg-clip-text text-transparent">
                        {{ setting('site_name', 'FilmMWE') }}
                    </h1>
                @endif
            </a>

            <!-- Search Desktop -->
            <form action="{{ route('search') }}" class="hidden md:flex flex-1 max-w-xl mx-4">
                <div class="relative w-full">
                    <input type="text" name="q" placeholder="Tìm phim, diễn viên..." value="{{ request('q') }}" required
                        class="w-full px-5 py-2.5 pl-11 bg-gray-900/70 border border-gray-700 rounded-full text-sm focus:border-primary focus:outline-none transition placeholder-gray-500">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-500"></i>
                </div>
            </form>

            <!-- Desktop Menu + Auth -->
            <div class="hidden lg:flex items-center gap-6">
                <nav class="flex items-center gap-6 text-sm font-medium">
                    <a href="{{ route('home') }}" class="hover:text-primary transition">Trang chủ</a>
                    <a href="{{ route('ranking.single') }}" class="hover:text-primary transition">Phim Lẻ</a>
                    <a href="{{ route('ranking.series') }}" class="hover:text-primary transition">Phim Bộ</a>
                    <!-- <a href="{{ route('ranking.vip') }}" class="hover:text-primary transition">Vip</a> -->
                    <a href="{{ route('ranking.index') }}" class="hover:text-primary transition">BXH</a>
                </nav>

                <div class="flex items-center gap-4 text-sm">
                    @auth
                        <span class="hidden xl:block">Hi, {{ auth()->user()->name }}</span>
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="bg-primary/20 px-4 py-2 rounded-full text-xs font-bold hover:bg-primary/30 transition">Admin</a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button class="text-red-400 hover:text-red-300"><i class="fas fa-sign-out-alt"></i></button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2 border border-primary/50 rounded-full hover:bg-primary/10 transition text-sm">Đăng nhập</a>
                        <a href="{{ route('register') }}" class="px-5 py-2 bg-primary rounded-full hover:bg-primary/80 transition font-bold text-sm">Đăng ký</a>
                    @endauth
                </div>
            </div>

            <button id="mobile-menu-btn" class="lg:hidden p-2 text-xl hover:bg-white/5 rounded-lg z-10">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>
</header>

<!-- MOBILE MENU  -->
<div id="mobile-menu-overlay" class="fixed inset-0 z-[9999] hidden lg:hidden">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/80" id="close-mobile-menu"></div>

    <!-- Panel -->
    <div class="absolute inset-x-0 top-0 bg-black/95 backdrop-blur-2xl border-b border-white/10 max-h-screen overflow-y-auto pb-10">
        <div class="container mx-auto px-4 py-5">
            <div class="flex items-center justify-between mb-6">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-primary">FilmMWE</a>
                <button id="close-mobile-btn" class="p-2 text-2xl hover:bg-white/10 rounded-lg">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Search Mobile -->
            <form action="{{ route('search') }}" method="GET" class="mb-6">
                <div class="relative">
                    <input type="text" name="q" placeholder="Tìm phim, diễn viên..." value="{{ request('q') }}" required 
                           class="w-full pl-12 pr-14 py-3.5 bg-gray-900/70 border border-gray-700 rounded-full text-base focus:border-primary focus:outline-none placeholder-gray-500">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 bg-primary hover:bg-primary/90 w-11 h-11 rounded-full flex items-center justify-center">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            </form>

            <!-- Menu Links -->
            <nav class="space-y-1 text-lg font-medium">
                <a href="{{ route('home') }}" class="block py-3 px-4 rounded-lg hover:bg-white/5 transition mobile-menu-link">Trang chủ</a>
                <a href="{{ route('ranking.single') }}" class="block py-3 px-4 rounded-lg hover:bg-white/5 transition mobile-menu-link">Phim Lẻ</a>
                <a href="{{ route('ranking.series') }}" class="block py-3 px-4 rounded-lg hover:bg-white/5 transition mobile-menu-link">Phim Bộ</a>
                <a href="{{ route('ranking.vip') }}" class="block py-3 px-4 rounded-lg hover:bg-white/5 transition mobile-menu-link">Vip</a>
                <a href="{{ route('ranking.index') }}" class="block py-3 px-4 rounded-lg hover:bg-white/5 transition mobile-menu-link">Bảng Xếp Hạng</a>
            </nav>

            <!-- Auth Mobile -->
            <div class="mt-8 pt-6 border-t border-white/10">
                @auth
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-lg">Xin chào, {{ auth()->user()->name }}</span>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-red-400 hover:text-red-300">
                                <i class="fas fa-sign-out-alt mr-2"></i>Đăng xuất
                            </button>
                        </form>
                    </div>
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="block text-center bg-primary/20 py-3 rounded-lg font-bold mt-3 mobile-menu-link">Vào Admin</a>
                    @endif
                @else
                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <a href="{{ route('login') }}" class="text-center py-3 border border-primary/50 rounded-lg hover:bg-primary/10 transition mobile-menu-link">Đăng nhập</a>
                        <a href="{{ route('register') }}" class="text-center py-3 bg-primary rounded-lg font-bold hover:bg-primary/80 transition mobile-menu-link">Đăng ký</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('mobile-menu-btn').addEventListener('click', function() {
        document.getElementById('mobile-menu-overlay').classList.remove('hidden');
    });

    document.getElementById('close-mobile-btn').addEventListener('click', function() {
        document.getElementById('mobile-menu-overlay').classList.add('hidden');
    });

    document.getElementById('close-mobile-menu').addEventListener('click', function() {
        document.getElementById('mobile-menu-overlay').classList.add('hidden');
    });

    document.querySelectorAll('.mobile-menu-link').forEach(link => {
        link.addEventListener('click', function() {
            document.getElementById('mobile-menu-overlay').classList.add('hidden');
        });
    });
</script>