<!DOCTYPE html>
<html lang="vi" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - @yield('title', setting('site_name'))</title>
    <link rel="icon" type="image/png"
        href="{{ setting('site_favicon') ? asset('storage/' . ltrim(setting('site_favicon'), '/')) : asset('favicon.ico') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .input-field {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        .input-field:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(147, 51, 234, 0.5);
            box-shadow: 0 0 0 3px rgba(147, 51, 234, 0.1);
        }
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            transition: left 0.3s ease;
        }
        .btn-primary:hover::before {
            left: 0;
        }
        .btn-primary span {
            position: relative;
            z-index: 1;
        }
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
    </style>
</head>
<body class="h-full flex items-center justify-center p-4">
    
    <!-- Decorative Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 floating"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-pink-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 floating" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-1/2 w-80 h-80 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 floating" style="animation-delay: 2s;"></div>
    </div>

    <div class="w-full max-w-md relative z-10">
        <!-- Logo Section -->
        <div class="text-center mb-10">
            <h1 class="text-5xl font-bold text-white mb-3 tracking-tight">@yield('title', setting('site_name'))</h1>
            <div class="w-16 h-1 bg-gradient-to-r from-purple-500 to-pink-500 mx-auto mb-4"></div>
            <p class="text-gray-400 text-sm font-light">Trải nghiệm điện ảnh đỉnh cao</p>
        </div>

        <!-- Login Form -->
        <div class="glass-effect p-10">
            <h2 class="text-2xl font-semibold text-white mb-2">Đăng nhập</h2>
            <p class="text-gray-400 text-sm mb-8">Chào mừng bạn quay trở lại</p>
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <!-- Email Field -->
                <div class="mb-6">
                    <label class="block text-xs font-medium text-gray-400 mb-2 uppercase tracking-wide">Email</label>
                    <input type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autofocus
                           placeholder="your@email.com"
                           class="input-field w-full px-4 py-3.5 text-white placeholder-gray-500 focus:outline-none">
                    @error('email')
                        <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="mb-6">
                    <label class="block text-xs font-medium text-gray-400 mb-2 uppercase tracking-wide">Mật khẩu</label>
                    <input type="password" 
                           name="password" 
                           required 
                           autocomplete="current-password"
                           placeholder="••••••••"
                           class="input-field w-full px-4 py-3.5 text-white placeholder-gray-500 focus:outline-none">
                    @error('password')
                        <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember & Forgot -->
                <div class="flex items-center justify-between mb-8">
                    <label class="flex items-center text-sm text-gray-400 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 border-gray-600 text-purple-600 focus:ring-purple-500 focus:ring-offset-gray-900">
                        <span class="ml-2 font-light">Ghi nhớ</span>
                    </label>
                    <a href="#" class="text-sm text-gray-400 hover:text-purple-400 transition font-light">Quên mật khẩu?</a>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-primary w-full py-4 text-white font-medium focus:outline-none">
                    <span>Đăng nhập</span>
                </button>
            </form>

            <!-- Divider -->
            <!-- <div class="relative my-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-700"></div>
                </div>
                <div class="relative flex justify-center text-xs">
                    <span class="px-4 text-gray-500 bg-transparent">hoặc</span>
                </div>
            </div> -->

            <!-- Social Login -->
            <!-- <div class="grid grid-cols-2 gap-3 mb-8">
                <button class="input-field py-3 text-white text-sm font-light hover:bg-white hover:bg-opacity-10 transition flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    Google
                </button>
                <button class="input-field py-3 text-white text-sm font-light hover:bg-white hover:bg-opacity-10 transition flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                    Facebook
                </button>
            </div> -->

            <!-- Sign Up Link -->
            <p class="text-center text-sm text-gray-400 font-light">
                Chưa có tài khoản? 
                <a href="{{ route('register') }}" class="text-purple-400 hover:text-purple-300 transition font-medium ml-1">Đăng ký ngay</a>
            </p>
        </div>

        <!-- Footer -->
        <p class="text-center text-xs text-gray-500 mt-8">
            © 2024  @yield('title', setting('site_name')). All rights reserved.
        </p>
    </div>

</body>
</html>