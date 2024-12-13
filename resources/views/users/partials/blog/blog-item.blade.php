    @foreach ($blogs as $blog)
        <div class="col-lg-6 col-md-6" id="blogItems">
            <div class="blog__item">
                <div class="blog__item__text">
                    <h5><a href="{{ route('blogs.show', $blog->slug) }}">{{ $blog->title }}</a></h5>
                    <p>{{ Str::limit($blog->content, 150) }}</p>
                    <a href="{{ route('blogs.show', $blog->slug) }}" class="blog__btn">Read More <span class="arrow_right"></span></a>
                </div>
            </div>
        </div>

    @endforeach

