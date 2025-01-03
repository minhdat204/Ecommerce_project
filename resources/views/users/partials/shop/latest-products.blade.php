<div class="latest-product__text">
    <h4>Latest Products</h4>
    <div class="latest-product__slider owl-carousel">
        @foreach($new_products->chunk(3) as $chunk)
            <div class="latest-prdouct__slider__item">
                @foreach($chunk as $product)
                    <a href="{{ route('users.shop_details', $product->slug) }}" class="latest-product__item">
                        <div class="latest-product__item__pic">
                            <img src="{{ asset('storage/' . ($product->images->isNotEmpty() ? $product->images->first()->duongdan : 'img/products/F60z2Ytjqo1SfLm8GSjV1T8Ucjzv8jV6SsN4DC8S.jpg')) }}"
                                 alt="{{ $product->images->first()->alt ?? $product->tensanpham }}"
                                 width="110" height="110">
                        </div>
                        <div class="latest-product__item__text">
                            <h6>{{ $product->tensanpham }}</h6>
                            @if($product->gia_khuyen_mai)
                                <span>{{ number_format($product->gia_khuyen_mai, 0, ',', '.') }}đ</span>
                            @else
                                <span>{{ number_format($product->gia, 0, ',', '.') }}đ</span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @endforeach
    </div>
</div>
