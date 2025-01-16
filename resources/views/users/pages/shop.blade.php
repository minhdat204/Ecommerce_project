@extends('users.layouts.layout')

@section('title', 'Cửa hàng')

@section('content')
    <!-- Product Section Begin -->
    <section class="product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-5">
                    <div class="sidebar">
                        <div class="sidebar__item">
                            @include('users.partials.shop.price-filter')

                        </div>
                        <div class="sidebar__item">
                            @include('users.partials.shop.department')
                        </div>
                        <div class="sidebar__item">
                            @include('users.partials.shop.latest-products')
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-7">
                    <div id="product__content">
                        {{-- kiểm tra nếu $productsDiscount tồn tại --}}
                        @if (!empty($productsDiscount))
                            <div class="product__discount">
                                @include('users.partials.shop.products-discount')
                            </div>
                        @endif

                        @include('users.partials.shop.products-content')
                    </div>
                    <div id="loading-spinner" style="display: none;">
                        <div class="spinner">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->
@endsection

@push('scripts')
    <script src="{{ asset('js/shop.js') }}"></script>
@endpush
