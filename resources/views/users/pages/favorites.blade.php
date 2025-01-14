@extends('users.layouts.layout')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/modal-confirm.css') }}">
@endpush
@section('content')
    <!-- Favorites Section Begin -->
    <section class="shoping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    @include('users.partials.favorites.table-favorites')
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    @include('users.partials.favorites.favorites-btns')
                </div>
            </div>
        </div>
    </section>
    <!-- Favorites Section End -->
@endsection

@push('scripts')
<script src="{{ asset('js/favorites.js') }}"></script>
@endpush
