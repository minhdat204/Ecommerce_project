@push('scripts')
    <script src="{{asset('js/blog.js')}}"></script>
@endpush
<div class="blog__item">
    <div class="blog__item__pic">
        <img src="{{ asset('img/' . $blog->thumbnail) }}" alt="{{ $blog->tieude }}">
    </div>
    <div class="blog__item__text">
        <ul>
            <li><i class="fa fa-calendar-o"></i> {{ $blog->created_at->format('F j, Y') }}</li>
            <li><i class="fa fa-comment-o"></i> {{ $blog->comments_count ?? 0 }} {{ __('comments') }}</li>
        </ul>
        <h5><a href="{{ route('blogs.show', $blog->slug) }}">{{ $blog->tieude }}</a></h5>
        <p>{{ Str::limit($blog->noidung, 100) }}</p>
        <a href="{{ route('blogs.show', $blog->slug) }}" class="read-more-btn">READ MORE <span class="arrow_right"></span></a>
    </div>
</div>
