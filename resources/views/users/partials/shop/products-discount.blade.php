<div class="section-title product__discount__title">
    <h2>Sale Off</h2>
</div>
<div class="row">
    <div class="product__discount__slider owl-carousel">
        @foreach ($productsDiscount as $product)
        <div class="col-lg-4">
            <div class="product__discount__item">
                <div class="product__discount__item__pic set-bg bg-blend"
                    data-setbg="{{ asset('storage/' . ($product->images->isNotEmpty() ? $product->images->first()->duongdan : 'img/products/default.jpg')) }}">
                    <div class="product__discount__percent">-{{floor(($product->gia - $product->gia_khuyen_mai) / $product->gia * 100)}}%</div>
                    <ul class="product__item__pic__hover">
                    @include('users.partials.pic-hover', ['product' => $product])
                    </ul>
                </div>
                <div class="product__discount__item__text">
                    <span>{{$product->category->tendanhmuc}}</span>
                    <h5><a href="{{route('users.shop_details', $product->slug)}}">{{$product->tensanpham}}</a></h5>
                    <div class="product__item__price">{{number_format($product->gia_khuyen_mai, 0, ',', '.')}}đ <span>{{number_format($product->gia, 0, ',', '.')}}đ</span></div>
                    <div class="discount">Giảm đến {{floor(($product->gia - $product->gia_khuyen_mai) / $product->gia * 100)}}%</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
