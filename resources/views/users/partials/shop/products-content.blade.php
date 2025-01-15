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
                <div class="product__item__pic set-bg"
                    data-setbg="{{ asset('storage/' . ($product->images->isNotEmpty() ? $product->images->first()->duongdan : 'img/products/default.jpg')) }}">
                    <ul class="product__item__pic__hover">
                    @include('users.partials.pic-hover', ['product' => $product])
                    </ul>
                </div>
                <div class="product__item__text">
                    <h6><a href="{{ route('users.shop_details', $product->slug) }}">{{ $product->tensanpham }}</a></h6>
                    <h5>
                        <div class="product__item__price">
                            @if ($product->gia_khuyen_mai != 0)
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
<div class="product__pagination">
    @if ($products->lastPage() > 1)
        @if ($products->currentPage() > 1)
            <a href="{{ $products->appends(request()->except('page'))->previousPageUrl() }}">
                <i class="fa fa-long-arrow-left"></i>
            </a>
        @endif

        @php
            $start = max($products->currentPage() - 2, 1);
            $end = min($start + 4, $products->lastPage());
            $start = max(min($start, $products->lastPage() - 4), 1);
        @endphp

        @if ($start > 1)
            <a href="{{ $products->appends(request()->except('page'))->url(1) }}">1</a>
            @if ($start > 2)
                <span>...</span>
            @endif
        @endif

        @for ($i = $start; $i <= $end; $i++)
            <a href="{{ $products->appends(request()->except('page'))->url($i) }}"
                class="{{ $products->currentPage() == $i ? 'active' : '' }}">
                {{ $i }}
            </a>
        @endfor

        @if ($end < $products->lastPage())
            @if ($end < $products->lastPage() - 1)
                <span>...</span>
            @endif
            <a href="{{ $products->appends(request()->except('page'))->url($products->lastPage()) }}">
                {{ $products->lastPage() }}
            </a>
        @endif

        @if ($products->hasMorePages())
            <a href="{{ $products->appends(request()->except('page'))->nextPageUrl() }}">
                <i class="fa fa-long-arrow-right"></i>
            </a>
        @endif
    @endif
</div>
