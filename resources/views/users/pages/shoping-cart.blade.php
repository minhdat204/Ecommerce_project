@extends('users.layouts.layout')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/modal-confirm.css') }}">
@endpush
@section('content')
    <!-- Shopping Cart Section Begin -->
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
{{-- <script>
function handleQuantityChange(input) {
    const $input = $(input);
    const $row = $input.closest('tr');
    const itemId = $row.data('id');
    const quantity = parseInt($input.val());
    const originalValue = $input.data('original-value');

    if (isNaN(quantity) || quantity < 1) {
        $input.val(originalValue);
        return;
    }

    $.ajax({
        url: `/cart/items/${itemId}`,
        method: 'PATCH',
        data: {
            soluong: quantity,
            _token: '{{ csrf_token() }}'
        },
        beforeSend: function() {
            $row.addClass('loading');
            $input.prop('disabled', true);
        },
        success: function(response) {
            if (response.success) {
                $row.find('.shoping__cart__total').text(response.item_total);
                $('#total').text(response.total);
                updateCartTotal(response.cart_total); // Cập nhật tổng giá trên header
                $input.data('original-value', quantity);
            } else {
                alert(response.message);
                $input.val(originalValue);
            }
        },
        error: function(xhr) {
            console.error('Cart update error:', xhr);
            alert('Có lỗi xảy ra khi cập nhật. Vui lòng thử lại.');
            $input.val(originalValue);
        },
        complete: function() {
            $row.removeClass('loading');
            $input.prop('disabled', false);
        }
    });
}

function handleRemoveItem(button) {
    const $row = $(button).closest('tr');
    const itemId = $row.data('id');

    if(confirm('Bạn có chắc muốn xóa sản phẩm này?')) {
        $.ajax({
            url: `/cart/items/${itemId}`,
            method: 'DELETE',
            data: { _token: '{{ csrf_token() }}' },
            beforeSend: function() {
                $row.addClass('loading');
            },
            success: function(response) {
                if(response.success) {
                    $row.fadeOut(function() {
                        $(this).remove();
                        updateCartTotal(response.cart_total); // Cập nhật tổng giá trên header
                        updateCartTotals(response);

                        if($('tbody tr').length === 0) {
                            location.reload();
                        }
                    });
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Có lỗi xảy ra. Vui lòng thử lại.');
                $row.removeClass('loading');
            }
        });
    }
}

// Helper functions
function updateCartTotals(data) {
    if(data.total) $('#total').text(data.total);
}

function updateCartCount(count) {
    $('.header__cart__price span').text(count);
}

// Thêm hàm mới để cập nhật tổng giá trên header
function updateCartTotal(total) {
    $('.header__cart__price span').text(total);
}
</script> --}}
@endpush
