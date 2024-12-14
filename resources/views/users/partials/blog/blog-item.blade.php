@foreach ($posts as $post)
    <div class="col-lg-6 col-md-6">
        <div class="blog__item">
            <div class="blog__item__pic">
                <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->tieude }}">
            </div>
            <div class="blog__item__text">
            <ul>
                <!-- Ngày tạo -->
                <li><i class="fa fa-calendar-o"></i> {{ $post->created_at->format('F d, Y') }}</li>
                <!-- Lượt xem -->
                <li><i class="fa fa-eye"></i> {{ $post->luotxem }}</li>
            </ul>
                <h5><a href="{{ route('blogs.show', $post->slug) }}">{{ $post->tieude }}</a></h5>
                <p>{{ Str::limit($post->noidung, 150) }}</p>
                <a href="{{ route('blogs.show', $post->slug) }}" class="blog__btn">Read More <span class="arrow_right"></span></a>
            </div>
        </div>
    </div>
@endforeach