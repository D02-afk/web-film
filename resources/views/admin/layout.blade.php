<!DOCTYPE html>
<html lang="vi" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title', setting('site_name'))</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="icon" href="{{ setting('site_favicon') ? asset(setting('site_favicon')) : asset('favicon.ico') }}">
    <link rel="icon" type="image/png"
        href="{{ setting('site_favicon') ? asset('storage/' . ltrim(setting('site_favicon'), '/')) : asset('favicon.ico') }}">
</head>

<body class="h-full bg-gray-900 text-white">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 border-r border-gray-700 flex flex-col">
            <div class="p-6 border-b border-gray-700">
                <h1 class="text-2xl font-bold text-purple-400">Admin - @yield('title', setting('site_name'))</h1>
            </div>
            <nav class="flex-1 px-4 py-6 space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 border-l-4 border-purple-500' : '' }}">
                    <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                </a>

                <a href="{{ route('admin.movies.index') }}"
                    class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-700 {{ request()->routeIs('admin.movies.*') ? 'bg-gray-700 border-l-4 border-purple-500' : '' }}">
                    <i class="fas fa-film mr-3"></i> Quản Lý Phim
                </a>

                <!-- <a href="{{ route('admin.movies.index') }}"
                    class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-700 transition {{ request()->routeIs('admin.movies*') || request()->routeIs('admin.seasons*') ? 'bg-gray-700 border-l-4 border-purple-500 text-white' : '' }}">
                    <i class="fas fa-tv mr-3"></i>
                    Quản lý mùa & tập phim
                </a> -->

                <a href="{{ route('admin.genres.index') }}"
                    class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-700 {{ request()->routeIs('admin.genres.*') ? 'bg-gray-700 border-l-4 border-purple-500' : '' }}">
                    <i class="fas fa-tags mr-3"></i> Thể Loại
                </a>

                <a href="{{ route('admin.countries.index') }}"
                    class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-700 {{ request()->routeIs('admin.countries.*') ? 'bg-gray-700 border-l-4 border-purple-500' : '' }}">
                    <i class="fas fa-globe-americas mr-3"></i> Quốc Gia
                </a>

                <a href="{{ route('admin.actors.index') }}"
                    class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-700 {{ request()->routeIs('admin.actors.*') || request()->routeIs('admin.movies.cast.*') ? 'bg-gray-700 border-l-4 border-purple-500' : '' }}">
                    <i class="fas fa-user-friends mr-3"></i> Diễn Viên & Đạo Diễn
                </a>

                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-700 {{ request()->routeIs('admin.users.*') ? 'bg-gray-700 border-l-4 border-purple-500' : '' }}">
                    <i class="fas fa-users-cog mr-3"></i> Người Dùng
                </a>

                <a href="{{ route('admin.comments.index') }}"
                    class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-700 {{ request()->routeIs('admin.comments.*') ? 'bg-gray-700 border-l-4 border-purple-500' : '' }}">
                    <i class="fas fas fa-comments mr-3"></i> Bình Luận
                </a>

                <!-- <a href="{{ route('admin.reports.index') }}"
                    class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-700 {{ request()->routeIs('admin.reports.*') ? 'bg-gray-700 border-l-4 border-purple-500' : '' }}">
                    <i class="fas fa-flag mr-3"></i> Báo Lỗi Link
                    @if($pending = \App\Models\Report::where('resolved', false)->count())
                    <span class="ml-auto bg-red-600 text-xs px-2 py-1 rounded-full">{{ $pending }}</span>
                    @endif
                </a> -->

                <a href="{{ route('admin.settings.index') }}"
                    class="flex items-center px-4 py-3 rounded-lg text-gray-300 hover:bg-gray-700 {{ request()->routeIs('admin.settings.*') ? 'bg-gray-700 border-l-4 border-purple-500' : '' }}">
                    <i class="fas fa-wrench mr-3"></i> Setting Trang Chủ
                </a>


            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-gray-800 border-b border-gray-700 px-6 py-4 flex justify-between items-center">
                <div>Xin chào, <strong>{{ auth()->user()->name }}</strong> 
                    <a href="{{ route('home') }}" class="hover:text-primary transition px-2"><i class="fa-solid fa-house"
                            style="color: #ffffff;"></i></a>
                </div>

                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button class="text-red-400 hover:text-red-300 font-medium">
                        <i class="fas fa-sign-out-alt mr-2"></i>Đăng xuất
                    </button>
                </form>
            </header>

            <main class="flex-1 overflow-y-auto p-8 bg-gray-900">
                <!-- NƠI NỘI DUNG ĐƯỢC CHÈN VÀO -->
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>