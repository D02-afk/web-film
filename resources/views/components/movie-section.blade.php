@props(['title', 'movies', 'icon', 'color' => 'from-primary to-purple-600', 'hot' => false])

@if($movies->count() > 0)
<section class="container mx-auto px-6 py-16">
    <div class="flex items-center gap-4 mb-10">
        <div class="p-3 md:p-4 bg-gradient-to-br {{ $color }} rounded-xl md:rounded-2xl shadow-2xl">
            <i class="{{ $icon }} text-2xl md:text-3xl text-white"></i>
        </div>
        <h2 class="text-3xl md:text-5xl font-black bg-gradient-to-r {{ $color }} bg-clip-text text-transparent">
            {{ $title }}
            @if($hot)
                <span class="ml-2 md:ml-4 text-xl md:text-3xl animate-pulse">HOT</span>
            @endif
        </h2>
        <div class="flex-1 h-1 bg-gradient-to-r {{ $color }} rounded-full opacity-30"></div>
    </div>

    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 xl:grid-cols-8 2xl:grid-cols-10 gap-6">
        @foreach($movies as $m)
            <x-movie-card :movie="$m" />
        @endforeach
    </div>
</section>
@endif