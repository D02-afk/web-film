{{-- resources/views/front/partials/rating-comment.blade.php --}}
<section class="max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    <h2 class="text-2xl lg:text-3xl font-black mb-6 lg:mb-8 bg-gradient-to-r from-yellow-400 to-orange-500 bg-clip-text text-transparent">
        Đánh giá & Bình luận
    </h2>

    <div class="grid lg:grid-cols-12 gap-6 lg:gap-8">

        <!-- CỘT TRÁI: ĐIỂM + FORM ĐÁNH GIÁ (trên mobile hiện trước) -->
        <div class="lg:col-span-4 order-2 lg:order-1">
            <div class="bg-gray-900/80 backdrop-blur-2xl rounded-2xl p-5 border border-gray-800 sticky top-20 lg:top-24 z-10">
                <div class="text-center">
                    <!-- Điểm trung bình -->
                    <div class="text-4xl lg:text-5xl font-black text-yellow-400 tabular-nums">
                        {{ $movie->rating['average'] ?? '?.?' }}
                        <span class="text-lg lg:text-xl text-gray-500">/10</span>
                    </div>

                    <!-- 5 ngôi sao lớn -->
                    <div class="flex justify-center gap-1.5 my-3">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star text-2xl lg:text-3xl {{ $i <= round(($movie->rating['average'] ?? 0)/2) ? 'text-yellow-400 drop-shadow-lg' : 'text-gray-700' }}"></i>
                        @endfor
                    </div>

                    <p class="text-gray-400 text-xs lg:text-sm">{{ number_format($movie->rating['count'] ?? 0) }} lượt đánh giá</p>

                    <!-- Form đánh giá -->
                    @auth
                        <form id="rating-form" class="mt-6 space-y-4">
                            @csrf
                            <input type="hidden" name="movie_id" value="{{ $movie->id }}">

                            <p class="text-xs lg:text-sm font-semibold text-gray-300 text-center">
                                Bạn đánh giá phim này bao nhiêu sao?
                            </p>

                            <!-- 10 ngôi sao (gọn hơn) -->
                            <div class="flex flex-wrap justify-center gap-2 lg:gap-3" id="star-rating">
                                @for($i = 1; $i <= 10; $i++)
                                    <label class="cursor-pointer group">
                                        <input type="radio" name="score" value="{{ $i }}" class="hidden peer">
                                        <i class="fas fa-star text-2xl lg:text-3xl transition-all duration-300
                                            text-gray-600 hover:text-yellow-400 hover:scale-110
                                            peer-checked:text-yellow-400 peer-checked:scale-110
                                            peer-checked:drop-shadow-lg">
                                        </i>
                                        <span class="block text-[10px] mt-0.5 text-gray-500">{{ $i }}</span>
                                    </label>
                                @endfor
                            </div>

                            <button type="submit" id="submit-rating"
                                class="w-full mt-5 bg-gradient-to-r from-yellow-500 to-orange-600 py-3 rounded-xl font-bold text-black text-sm lg:text-base shadow-lg hover:shadow-orange-500/50 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                                Gửi đánh giá của bạn
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" 
                           class="block mt-5 text-center bg-gradient-to-r from-primary to-purple-600 py-3 rounded-xl font-bold text-white text-sm lg:text-base shadow-lg hover:shadow-primary/50 transition">
                            Đăng nhập để đánh giá
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- CỘT PHẢI: BÌNH LUẬN (trên mobile hiện trước) -->
        <div class="lg:col-span-8 order-1 lg:order-2">

            <!-- Form bình luận -->
            @auth
                <form action="{{ route('movie.comment', $movie) }}" method="POST" class="mb-4 sm:mb-6">
                    @csrf
                    <div class="bg-gray-900/70 backdrop-blur-xl rounded-lg sm:rounded-xl p-3 sm:p-4 border border-gray-800/60">
                        <textarea name="content" rows="1" placeholder="Viết bình luận của bạn..." required
                            class="w-full bg-black/50 border border-gray-700 rounded-lg px-3 py-2 sm:px-4 sm:py-3 text-xs sm:text-sm placeholder-gray-500 focus:border-primary focus:outline-none resize-none"></textarea>
                        <div class="flex justify-end items-center mt-2 sm:mt-3">
                            <button type="submit"
                                class="bg-gradient-to-r from-primary to-purple-600 px-4 py-2 sm:px-6 sm:py-2.5 rounded-lg font-bold text-white text-xs sm:text-sm hover:scale-105 transition shadow-lg">
                                Gửi
                            </button>
                        </div>
                    </div>
                </form>
            @endauth

            <!-- Danh sách bình luận -->
            <div id="comments-container" class="space-y-1.5 sm:space-y-2">
                @forelse($movie->comments->take(8) as $comment)
                    <div class="flex gap-2 sm:gap-2.5 backdrop-blur-xl p-2 sm:p-3 transition-all">
                        <img src="{{ $comment->user->avatar ?? asset('images/avatar-default.jpg') }}"
                             alt="{{ $comment->user->name }}"
                             class="w-7 h-7 sm:w-8 sm:h-8 rounded-full object-cover border border-primary/20 flex-shrink-0">

                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-1 sm:gap-1.5 mb-0.5 sm:mb-1">
                                <span class="font-semibold text-white text-[11px] sm:text-xs">{{ $comment->user->name }}</span>
                                @if($comment->user->is_admin ?? false)
                                    <span class="text-[8px] sm:text-[9px] bg-red-600/80 px-1 sm:px-1.5 py-0.5 rounded-full leading-none">Admin</span>
                                @endif
                                <span class="text-[9px] sm:text-[10px] text-gray-500">· {{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-gray-300 text-[9px] sm:text-xs leading-snug break-words">{!! $comment->content !!}</p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 sm:py-12 bg-gray-900/40 rounded-lg border border-dashed border-gray-700">
                        <i class="fas fa-comment-slash text-3xl sm:text-4xl text-gray-700 mb-2 opacity-50"></i>
                        <p class="text-sm sm:text-base text-gray-500">Chưa có bình luận</p>
                        <p class="text-gray-400 text-[10px] sm:text-xs mt-1">
                            @auth Hãy là người đầu tiên!
                            @else <a href="{{ route('login') }}" class="text-primary underline">Đăng nhập</a> để bình luận @endauth
                        </p>
                    </div>
                @endforelse
            </div>

            <!-- Nút Xem thêm -->
            @if($movie->comments->count() > 8)
                <div class="text-center mt-3 sm:mt-4">
                    <button id="load-more-comments"
                        data-movie="{{ $movie->id }}"
                        data-loaded="8"
                        class="inline-flex items-center gap-1.5 sm:gap-2 bg-gray-800 hover:bg-gray-700 px-4 py-1.5 sm:px-5 sm:py-2 rounded-full font-semibold text-primary text-[10px] sm:text-xs transition-all hover:scale-105">
                        Xem thêm
                        <i class="fas fa-chevron-down text-[9px] sm:text-[10px]"></i>
                    </button>
                </div>
            @endif
        </div>
    </div>
</section>

{{-- JS --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ratingForm = document.getElementById('rating-form');
    const submitBtn = document.getElementById('submit-rating');

    // Tự động bật nút khi chọn sao
    document.querySelectorAll('#star-rating input[name="score"]').forEach(input => {
        input.addEventListener('change', () => {
            submitBtn.disabled = false;
            submitBtn.textContent = "Gửi đánh giá " + input.value + " sao";
        });
    });

    // Submit rating
    ratingForm?.addEventListener('submit', function (e) {
        e.preventDefault();
        const score = document.querySelector('input[name="score"]:checked')?.value;
        if (!score) return;

        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Đang gửi...';
        submitBtn.disabled = true;

        fetch('{{ route("movie.rate", $movie) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ score: parseInt(score) })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Lỗi: ' + (data.message || 'Không thể gửi đánh giá'));
                submitBtn.textContent = "Gửi đánh giá";
                submitBtn.disabled = false;
            }
        });
    });

    // Load more comments
    document.getElementById('load-more-comments')?.addEventListener('click', function () {
        const btn = this;
        const movieId = btn.dataset.movie;
        let loaded = parseInt(btn.dataset.loaded);

        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Đang tải...';
        btn.disabled = true;

        fetch(`/movie/${movieId}/comments?skip=${loaded}&take=10`)
            .then(r => r.text())
            .then(html => {
                if (html.trim() === '') {
                    btn.remove();
                    return;
                }
                document.getElementById('comments-container').insertAdjacentHTML('beforeend', html);
                loaded += 10;
                btn.dataset.loaded = loaded;
                btn.innerHTML = 'Xem thêm bình luận <i class="fas fa-chevron-down ml-2"></i>';
                btn.disabled = false;
            });
    });
});
</script>