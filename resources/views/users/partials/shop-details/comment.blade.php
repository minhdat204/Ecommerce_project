<div class="review-container">
    <!-- Rating Summary -->
    <div class="rating-summary">
        <div class="average-rating">
            <div class="rating-big">{{ $totalReviews > 0 ? number_format($averageRating, 1) : '0.0' }}</div>
            <div class="rating-stars">
                @for ($i = 1; $i <= 5; $i++)
                    <i class="star {{ $i <= $averageRating ? 'filled' : '' }}">★</i>
                @endfor
            </div>
            <div class="total-reviews">{{ $totalReviews }} reviews</div>
        </div>

        <div class="rating-bars">
            @foreach ($ratingStats as $stars => $count)
                <div class="rating-bar">
                    <span class="star-label">{{ $stars }} ★</span>
                    <div class="progress-bar">
                        <div class="progress-fill"
                            style="width: {{ $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0 }}%"></div>
                    </div>
                    <span class="bar-count">{{ $count }}</span>
                </div>
            @endforeach
        </div>
    </div>

    @php
        $reviewController = new \App\Http\Controllers\Client\ReviewController();
        $checkResult = $reviewController->checkCanReview($product->id_sanpham);

    @endphp
    @if ($checkResult['canReview'])
        <!-- Review Form -->
        <div class="review-form">
            <h3>Write a Review</h3>
            <form action="{{ route('reviews.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id_sanpham" value="{{ $product->id_sanpham }}">
                <p>Product ID: {{ $product->id_sanpham }}</p>

                <div class="form-group">
                    <label>Your Rating</label>
                    <div class="rating-stars" id="rating-stars">
                        <i class="star" data-value="1">☆</i>
                        <i class="star" data-value="2">☆</i>
                        <i class="star" data-value="3">☆</i>
                        <i class="star" data-value="4">☆</i>
                        <i class="star" data-value="5">☆</i>
                    </div>
                    <input type="hidden" name="danhgia" id="rating-value" required>
                </div>

                <div class="form-group">
                    <label>Your Review</label>
                    <textarea name="noidung" rows="4" required placeholder="Share your experience with this product..."></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Submit Review</button>
            </form>
        </div>
    @else
        <div class="alert alert-info">
            {{ $checkResult['message'] }}
        </div>
    @endif <!-- Review List -->
    <div class="review-list">
        @foreach ($reviews as $review)
            <div class="review-item">
                <div class="reviewer-info">
                    <div class="reviewer-avatar"></div>
                    <div>
                        <div class="reviewer-name">{{ $review->user->name }}</div>
                        <div class="rating-stars">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="star {{ $i <= $review->danhgia ? 'filled' : '' }}">★</i>
                            @endfor
                        </div>
                    </div>
                </div>
                <div class="review-content">{{ $review->noidung }}</div>
            </div>
        @endforeach
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('#rating-stars .star');
        const ratingInput = document.getElementById('rating-value');

        stars.forEach(star => {
            star.addEventListener('mouseover', function() {
                const value = this.getAttribute('data-value');
                highlightStars(value);
            });

            star.addEventListener('mouseout', function() {
                const selectedValue = ratingInput.value;
                if (selectedValue) {
                    setSelectedStars(selectedValue);
                } else {
                    clearHighlight();
                }
            });

            star.addEventListener('click', function() {
                const value = this.getAttribute('data-value');
                ratingInput.value = value;
                setSelectedStars(value);
            });
        });

        function highlightStars(value) {
            stars.forEach(star => {
                const starValue = star.getAttribute('data-value');
                if (starValue <= value) {
                    star.textContent = '★';
                    star.classList.add('hover');
                } else {
                    star.textContent = '☆';
                    star.classList.remove('hover');
                }
            });
        }

        function clearHighlight() {
            stars.forEach(star => {
                star.textContent = '☆';
                star.classList.remove('hover');
            });
        }

        function setSelectedStars(value) {
            stars.forEach(star => {
                const starValue = star.getAttribute('data-value');
                if (starValue <= value) {
                    star.textContent = '★';
                    star.classList.add('selected');
                } else {
                    star.textContent = '☆';
                    star.classList.remove('selected');
                }
            });
        }
    });
</script>
