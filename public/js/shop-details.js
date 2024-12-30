function addToCart(productId, authCheck) {
    // Kiểm tra trạng thái đăng nhập
    if (!authCheck) {
        notification('Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng', 'error');
        // mở modal sau 0.5s
        setTimeout(() => {
            openModal();
        }, 500);
        return;
    }
    // Kiểm tra tham số đầu vào
    if (!productId) {
        console.error('productId không hợp lệ');
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const quantity = document.getElementById('quantity').value;

    if (!quantity) {
        console.error('Không thể thêm sản phẩm vào giỏ hàng với số lượng không hợp lệ');
        notification('Số lượng không hợp lệ', 'error');
        return;
    }
    // Show loading
    const button = document.querySelector('#addToCartButton');
    button.disabled = true;
    button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Adding...';

    // Gửi request lên server
    fetch('/cart/items', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            id_sanpham: productId,
            soluong: quantity
        })
    })
    .then(response => {
        if (!response.ok) {
            notification('Có lỗi xảy ra, vui lòng thử lại sau.', 'error');
            throw new Error('có lỗi xảy ra, vui lòng thử lại sau.');
        }
        return response.json();
    })
    .then(data => {
        //nếu thêm thành công thì thông báo và chuyển hướng đến trang giỏ hàng
        if(data.success) {
            notification("Đã thêm vào giỏ hàng", 'success', 3000, function(){
                window.location.href = data.redirect_url;
            });

            // chuyên hướng sau 1s
            // setTimeout(() => {
            //     window.location.href = data.redirect_url;
            // }, 1000);
        }
        //nếu thất bại thì thông báo lỗi
        else {
            notification(data.message || "Có lỗi xảy ra", 'error');
        }

        // Có thể thêm code cập nhật UI ở đây
    })
    .catch(error => {
        console.error('Error:', error);
        notification('Có lỗi xảy ra, vui lòng thử lại sau.', 'error');
    })
    .finally(() => {
        button.disabled = false;
        button.innerHTML = 'ADD TO CART';
    });
}
