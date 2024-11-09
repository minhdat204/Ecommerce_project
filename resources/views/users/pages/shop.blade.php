@extends('users.layouts.layout')

@section('content')
    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-5">
                    <div class="sidebar">
                        <div class="sidebar__item">
                            @include('users.partials.shop.department')
                        </div>
                        <div class="sidebar__item">
                            @include('users.partials.shop.price-filter')
                        </div>
                        <div class="sidebar__item">
                            @include('users.partials.shop.latest-products')
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-7">
                    <div class="product__discount">
                        @include('users.partials.shop.products-discount')
                    </div>
                    @include('users.partials.shop.products-content')
                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->
@endsection
