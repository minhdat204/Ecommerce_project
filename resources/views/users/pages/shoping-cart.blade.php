@extends('users.layouts.layout')

@section('title', 'Giỏ hàng')

@section('content')
    <!-- Shopping Cart Section Begin -->
    <section class="shoping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    {{-- input lưu số lượng sản phẩm trong giỏ hàng để kiểm tra khi thay đổi số lượng --}}
                    <input type="hidden" id="overStockCount" value="{{ $overStockItems->count() }}">
                    <div class="shoping__cart__table">
                        @include('users.partials.shoping-cart.table-cart')
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    @include('users.partials.shoping-cart.shoping-btns')
                </div>
                <div class="col-lg-6">
                </div>
                <div class="col-lg-6">
                    @include('users.partials.shoping-cart.checkout')
                </div>
            </div>
        </div>
    </section>
    <!-- Shopping Cart Section End -->
@endsection

@push('scripts')
<script src="{{ asset('js/shopping-cart.js') }}"></script>
@endpush
