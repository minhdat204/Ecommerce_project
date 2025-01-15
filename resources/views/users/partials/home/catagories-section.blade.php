<!-- Categories Section Begin -->
<section class="categories">

    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Featured categories</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="categories__slider owl-carousel">
                @foreach ($categories as $category)
                <div class="col-lg-3">
                    <a href="{{ route('shop.category', $category->slug) }}">
                        <div class="categories__item set-bg catebg-blend" data-setbg="{{ asset('storage/' . ($category->thumbnail ? $category->thumbnail : 'img/categories/default.jpg')) }}">
                            <h5><span>{{$category->tendanhmuc}}</span></h5>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- Categories Section End -->
