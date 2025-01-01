document.querySelectorAll('.pro-qty').forEach(function(proQty) {
    const decreaseBtn = proQty.querySelector('.decrease-btn');
    const increaseBtn = proQty.querySelector('.increase-btn');
    const input = proQty.querySelector('input[name="quantity"]');
    const form = proQty.closest('form');

    decreaseBtn.addEventListener('click', function() {
        if (parseInt(input.value) > 1) {
            input.value = parseInt(input.value) - 1;
        }
    });

    increaseBtn.addEventListener('click', function() {
        input.value = parseInt(input.value) + 1;
    });

    form.addEventListener('submit', function(e) {
        e.preventDefault(); // Ngăn tải lại trang
        const formData = new FormData(form);
        const url = form.action;

        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); // Tải lại trang để cập nhật giỏ hàng
            }
        })
        .catch(error => console.error('Error:', error));
    });
});

$(document).ready(function() {
    $('.quantity-input').on('change', function() {
        var quantity = $(this).val(); // Lấy giá trị số lượng mới
        var cartItemId = $(this).data('id'); // Lấy ID sản phẩm trong giỏ hàng

        // Gửi yêu cầu AJAX đến route cập nhật giỏ hàng
        $.ajax({
            url: '/cart/update/' + cartItemId,  // Đảm bảo đúng URL route
            method: 'PATCH',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),  // CSRF token
                quantity: quantity
            },
            success: function(response) {
                // Cập nhật giá mới và tổng tiền
                $('.product-price-total').text(response.newTotal);  // Giả sử response trả về tổng tiền mới

                // Cập nhật giá của sản phẩm (nếu có thể)
                $('.quantity-input').val(response.newQuantity);  // Cập nhật số lượng nếu cần
            },
            error: function(xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    });
});

