<section class="hero" style="padding-top: 20px">
    <div class="container">
        <div class="hero__slideshow">
            @foreach($slider as $index => $product)
            <div class="hero__item {{ $index === 0 ? 'active' : '' }}"
                 style="background-image: url('{{ $product->images->first()->duongdan ?? "img/featured/feature-8.jpg" }}')">
                <div class="hero__text">
                    @if($product->gia_khuyen_mai)
                        <span>SALE UP TO {{ round((($product->gia - $product->gia_khuyen_mai) / $product->gia) * 100) }}% OFF</span>
                    @else
                        <span>FEATURED PRODUCT</span>
                    @endif
                    <h2>{{ $product->tensanpham }}</h2>
                    <p>{{ Str::limit($product->mota, 50) }}</p>
                    <a href="{{ route('users.shop_details', $product->slug) }}" class="primary-btn">SHOP NOW</a>
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
