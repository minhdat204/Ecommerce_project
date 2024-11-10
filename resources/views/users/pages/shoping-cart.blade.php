@extends('users.layouts.layout')
@section('content')
    <!-- Shoping Cart Section Begin -->
    <section class="shoping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    @include('users.partials.shoping-cart.table-cart')
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    @include('users.partials.shoping-cart.shoping-btns')
                </div>
                <div class="col-lg-6">
                    @include('users.partials.shoping-cart.discount')
                </div>
                <div class="col-lg-6">
                    @include('users.partials.shoping-cart.checkout')
                </div>
            </div>
        </div>
    </section>
    <!-- Shoping Cart Section End -->
@endsection
