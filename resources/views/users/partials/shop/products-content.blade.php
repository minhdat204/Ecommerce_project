<div class="filter__item">
    <div class="row">
        <div class="col-lg-4 col-md-5">
            <div class="filter__sort">
                <span>Sort By</span>
                <select style="display: none;">
                    <option value="0">Default</option>
                    <option value="0">Default</option>
                </select>
                <div class="nice-select" tabindex="0"><span class="current">Default</span>
                    <ul class="list">
                        <li data-value="0" class="option selected">Default</li>
                        <li data-value="0" class="option">Default</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4">
            <div class="filter__found">
                <h6><span>{{ $productsCount }}</span> Products found</h6>
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
    @foreach ($products as $product)
        <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="product__item">
                <div class="product__item__pic set-bg bg-blend"
                    data-setbg="{{ asset('storage/' . ($product->images->isNotEmpty() ? $product->images->first()->duongdan : 'img/products/default.jpg')) }}">
                    @if ($product->gia_khuyen_mai !== null && $product->gia_khuyen_mai >= 0)
                                    <div class="product__discount__percent">-{{floor(($product->gia - $product->gia_khuyen_mai) / $product->gia * 100)}}%</div>
                    @endif
                    <ul class="product__item__pic__hover">
                    @include('users.partials.pic-hover', ['product' => $product])
                    </ul>
                </div>
                <div class="product__item__text">
                    <h6><a href="{{ route('users.shop_details', $product->slug) }}">{{ $product->tensanpham }}</a></h6>
                    <h5>
                        <div class="product__item__price">
                            @if ($product->gia_khuyen_mai !== null && $product->gia_khuyen_mai >= 0)
                                {{ number_format($product->gia_khuyen_mai, 0, ',', '.') }}đ
                                <span>{{ number_format($product->gia, 0, ',', '.') }}đ</span>
                            @else
                                {{ number_format($product->gia, 0, ',', '.') }}đ
                            @endif
                        </div>
                    </h5>
                </div>
            </div>
        </div>
    @endforeach
</div>
@include('users.components.pagination', ['paginator' => $products])
