<!-- Featured Section Begin -->
<section class="featured spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>Best-selling Products</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="categories__slider owl-carousel">
                @foreach ($best_selling_products as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6 mix oranges fresh-meat">
                        <div class="featured__item">
                            <div class="featured__item__pic set-bg" data-setbg="img/featured/feature-1.jpg">
                                <ul class="featured__item__pic__hover">
                                    <li><a href="#"><i class="fa fa-heart"></i></a></li>
                                    <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                                    <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                </ul>
                            </div>
                            <div class="featured__item__text">
                                <h6><a href="#">{{ $product->tensanpham }}</a></h6>
                                <h5>{{ $product->gia }}</h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- Featured Section End -->
