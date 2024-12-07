<!-- Latest Product Section Begin -->
<section class="latest-product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="latest-product__text">
                    <h4>Latest Products</h4>
                    <div class="latest-product__slider owl-carousel">
                        @foreach ($new_products as $index => $product)
                            @if ($index % 3 == 0)
                                <div class="latest-prdouct__slider__item">
                            @endif
                            <a href="#" class="latest-product__item">
                                <div class="latest-product__item__pic">
                                    <img src="img/latest-product/lp-{{ $index % 3 + 1 }}.jpg" alt="">
                                </div>
                                <div class="latest-product__item__text">
                                    <h6>{{ $product->tensanpham }}</h6>
                                    @if ($product->gia_khuyen_mai > 0 && $product->gia_khuyen_mai < $product->gia)
                                        <span style="color: red">Giảm đến {{ ceil((($product->gia - $product->gia_khuyen_mai) / $product->gia) * 100) }}%</span>
                                    @endif
                                    <span>${{ $product->gia }}</span>
                                </div>
                            </a>
                            @if ($index % 3 == 2 || $loop->last)
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6">
                <div class="latest-product__text">
                    <h4>Best-selling Products</h4>
                    <div class="latest-product__slider owl-carousel">
                    @foreach ($best_selling_products as $index => $product)
                        @if ($index % 3 == 0)
                            <div class="latest-prdouct__slider__item">
                        @endif
                        <a href="#" class="latest-product__item">
                            <div class="latest-product__item__pic">
                                <img src="img/latest-product/lp-{{ $index % 3 + 1 }}.jpg" alt="">
                            </div>
                            <div class="latest-product__item__text">
                                <h6>{{ $product->tensanpham }}</h6>
                                @if ($product->gia_khuyen_mai > 0)
                                    <span style="color: red">Giảm đến {{ ceil((($product->gia - $product->gia_khuyen_mai) / $product->gia) * 100) }}%</span>
                                @endif
                                <span>${{ $product->gia }}</span>
                            </div>
                        </a>
                        @if ($index % 3 == 2 || $loop->last)
                            </div>
                        @endif
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Latest Product Section End -->
