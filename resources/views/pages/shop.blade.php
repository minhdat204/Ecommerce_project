@extends('layouts.layout')

@section('content')
    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-5">
                    <div class="sidebar">
                        <div class="sidebar__item">
                            @include('partials.shop.department')
                        </div>
                        <div class="sidebar__item">
                            @include('partials.shop.price-filter')
                        </div>
                        <div class="sidebar__item">
                            @include('partials.shop.latest-products')
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-7">
                    <div class="product__discount">
                        @include('partials.shop.product-discount')
                    </div>
                    @include('partials.shop.product-content')
                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->
@endsection
