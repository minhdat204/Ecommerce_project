@extends('users.layouts.layout')

@push('styles')
    <link rel="stylesheet" href="{{asset('css/slideshow.css')}}">
@endpush
@push('scripts')
    <script src="{{asset('js/slideshow.js')}}"></script>
@endpush

@section('content')

    @include('users.partials.home.slide-banner')
    @include('users.partials.home.catagories-section')
    @include('users.partials.home.featured-products')
    @include('users.partials.home.banner')
    @include('users.partials.home.lastest-products')

@endsection
