<div class="section-title product__discount__title">
    <h2>Sale Off</h2>
</div>
<div class="row">
    <div class="product__discount__slider owl-carousel">
        @foreach ($productsDiscount as $sanpham)
        <div class="col-lg-4">
            <div class="product__discount__item">
                <div class="product__discount__item__pic set-bg" data-setbg="img/product/discount/pd-1.jpg">
                    <div class="product__discount__percent">-20%</div>
                    <ul class="product__item__pic__hover">
                        <li><a href="#"><i class="fa fa-heart"></i></a></li>
                        <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                        <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                    </ul>
                </div>
                <div class="product__discount__item__text">
                    <span>{{$sanpham->category->tendanhmuc}}</span>
                    <h5><a href="{{route('users.shop_details', $sanpham->slug)}}">{{$sanpham->tensanpham}}</a></h5>
                    <div class="product__item__price">${{$sanpham->gia_khuyen_mai}} <span>${{$sanpham->gia}}</span></div>
                    <div>Giảm đến {{floor(($sanpham->gia - $sanpham->gia_khuyen_mai) / $sanpham->gia * 100)}}%</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
