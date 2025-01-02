@extends('users.layouts.layout')
@push('scripts')
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

