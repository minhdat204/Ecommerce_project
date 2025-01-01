<div class="filter__item">
    <div class="row">
        <div class="col-lg-4 col-md-5">
            <div class="filter__sort">
                <span>Sort By</span>
                <select>
                    <option value="0">Default</option>
                    <option value="0">Default</option>
                </select>
            </div>
        </div>
        <div class="col-lg-4 col-md-4">
            <div class="filter__found">
                <h6><span>{{$productsCount}}</span> Products found</h6>
            </div>
        </div>
        <div class="col-lg-4 col-md-3">
            <div class="filter__option">
                <span class="icon_grid-2x2"></span>
                <span class="icon_ul"></span>
            </div>
        </div>
    </div>
</div>
<div class="row">
    @foreach ($products as $sanpham)
    <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="product__item">
            <div class="product__item__pic set-bg" data-setbg="img/product/product-1.jpg">
                <ul class="product__item__pic__hover">
                    <li><a href="#"><i class="fa fa-heart"></i></a></li>
                    <li><a href="#"><i class="fa fa-retweet"></i></a></li>
                    <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                </ul>
            </div>
            <div class="product__item__text">
                <h6><a href="{{route('users.shop_details', $sanpham->slug)}}">{{$sanpham->tensanpham}}</a></h6>
                <h5>
                    <div class="product__item__price">
                        @if ($sanpham->gia_khuyen_mai != 0)
                            ${{$sanpham->gia_khuyen_mai}}
                            <span>${{$sanpham->gia}}</span>
                        @else
                            ${{$sanpham->gia}}
                        @endif
                    </div>
                </h5>
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="product__pagination">
    @if ($products->lastPage() > 1)
        @if ($products->currentPage() > 1)
            <a href="{{ $products->url($products->currentPage() - 1) }}"><i class="fa fa-long-arrow-left"></i></a>
        @endif

        @for ($i = 1; $i <= $products->lastPage(); $i++)
            <a href="{{ $products->url($i) }}" class="{{ ($products->currentPage() == $i) ? 'active' : '' }}">{{ $i }}</a>
        @endfor

        @if ($products->currentPage() < $products->lastPage())
            <a href="{{ $products->url($products->currentPage() + 1) }}"><i class="fa fa-long-arrow-right"></i></a>
        @endif
    @endif
</div>
