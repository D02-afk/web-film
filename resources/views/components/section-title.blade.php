@props(['title', 'link' => '#', 'icon' => null])

<div class="flex items-center justify-between mb-8">
    <h2 class="text-2xl md:text-3xl font-bold flex items-center gap-3">
        @if($icon)<i class="fas {{ $icon }} text-primary"></i>@endif
        {{ $title }}
    </h2>
    <a href="{{ $link }}" class="text-primary hover:underline text-sm font-medium flex items-center gap-2">
        Xem tất cả <i class="fas fa-arrow-right text-xs"></i>
    </a>
</div>