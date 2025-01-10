<section class="hero" style="padding-top: 20px">
    <div class="container">
        <div class="hero__slideshow">
            @foreach($slider as $index => $product)
            <div class="hero__item {{ $index === 0 ? 'active' : '' }}"
                style="background: #f5f5f5; display: flex; align-items: center; padding: 40px;">
                <div class="hero__text" style="flex: 1; z-index: 2; padding-left: 40px;">
                    @if($product->gia_khuyen_mai)
                        <span>SALE UP TO {{ floor((($product->gia - $product->gia_khuyen_mai) / $product->gia) * 100) }}% OFF</span>
                    @else
                        <span>FEATURED PRODUCT</span>
                    @endif
                    <h2>{{ $product->tensanpham }}</h2>
                    <p>{{ Str::limit($product->mota ?? 'No description available', 50) }}</p>
                    <a href="{{ route('users.shop_details', $product->slug) }}" class="primary-btn">SHOP NOW</a>
                </div>
                <div class="hero__image" style="flex: 1; position: relative; height: 400px; overflow: hidden;">
                    <img src="{{ 'storage/' . $product->images->first()->duongdan ?? 'img/featured/feature-8.jpg' }}"
                         style="position: absolute; right: 0; top: 50%; transform: translateY(-50%); max-width: 100%; height: auto; mix-blend-mode: darken;"
                         alt="{{ $product->tensanpham }}">
                </div>
            </div>
            @endforeach

            <div class="hero__nav">
                @foreach($slider as $index => $product)
                    <button class="hero__nav-dot {{ $index === 0 ? 'active' : '' }}"></button>
                @endforeach
            </div>
        </div>
    </div>
</section>
