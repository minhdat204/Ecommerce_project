@extends('users.layouts.layout')

@push('styles')
    <link rel="stylesheet" href="{{asset('css/slideshow.css')}}">
    <link rel="stylesheet" href="{{asset('css/services.css')}}">
@endpush
@push('scripts')
    <script src="{{asset('js/slideshow.js')}}"></script>
    <script>
 function addToCart(element) {
    @if(!Auth::check())
        window.location.href = "{{ route('login') }}";
        return;
    @endif

    const quantity =  $(element).data('quantity');
    const productId =  $(element).data('id');

    $.ajax({
        url: '{{ route('cart.add') }}',
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        data: {
            id_sanpham: productId,
            soluong: quantity
        },
        success: function(response) {
            if (response.success) {
                alert(response.message);
                // Redirect to cart page
                window.location.href = response.redirect_url;
            } else {
                alert(response.message || 'Error adding product to cart');
            }
        },
        error: function(xhr) {
            console.error('Cart error:', xhr);
            alert('Error adding product to cart. Please try again.');
        }
    });
}
</script>
@endpush

@section('content')

    @include('users.partials.home.slide-banner')
    @include('users.partials.home.catagories-section')
    @include('users.partials.home.latest-products')
    @include('users.partials.home.best_selling-products')
    @include('users.partials.home.banner')
    @include('users.partials.home.our-services')

@endsection
