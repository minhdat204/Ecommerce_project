<h4>Recent News</h4>
<div class="blog__sidebar__recent">
    @foreach($recentBlogs as $blog)
        <a href="#blog-{{ $blog->id }}" class="blog__sidebar__recent__item">
            <div class="blog__sidebar__recent__item__pic">
                <img src="{{ asset('img/' . $blog->image) }}" alt="{{ $blog->title }}" style="width: 70px; height: 70px;">
            </div>
            <div class="blog__sidebar__recent__item__text">
                <h6>{{ $blog->title }}</h6>
                <span>{{ $blog->created_at->format('M d, Y') }}</span>
            </div>
        </a>
    @endforeach
</div>
