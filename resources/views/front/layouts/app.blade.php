<!DOCTYPE html>
<html lang="vi" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', setting('site_name'))</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('description', setting('site_description'))">
    <link rel="icon" type="image/png"
        href="{{ setting('site_favicon') ? asset('storage/' . ltrim(setting('site_favicon'), '/')) : asset('favicon.ico') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <style>
    body {
        font-family: 'Inter', sans-serif;
        background: #000;
    }

    .primary {
        color: setting('theme_color', '#a855f7');
    }

    .bg-primary {
        background-color: setting('theme_color', '#a855f7');
    }

    .hover\:bg-primary-dark:hover {
        background-color: adjustBrightness(setting('theme_color', '#a855f7'), -20);
    }

    .gradient-primary {
        background: linear-gradient(135deg, 
                    
                    setting('theme_color', '#a855f7')
                
            

            , #ec4899);
    }

    .hero-bg {
        background: linear-gradient(to right, rgba(0, 0, 0, 0.95), transparent 70%),
        url('{{ setting('hero_background') ? asset('storage/'.setting('hero_background')) : 'https: //images.alphacoders.com/133/1330141.jpg' }}') center/cover no-repeat; }
   
    .aspect-w-2 { position: relative; padding-bottom: 150%; }
    .aspect-w-2 > * { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .scrollbar-hide {
        -ms-overflow-style: none;  
        scrollbar-width: none;    
    }
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
   </style>
    @stack('styles')
</head>

<body class="text-white min-h-screen">

    @include('front.partials.header')
    <div class="" style="height: 75px;"></div>
    <main>
        @yield('content')
    </main>

    @include('front.partials.footer')

    @stack('scripts')
</body>

</html>