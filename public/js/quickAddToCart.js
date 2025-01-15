function quickAddToCart(productId) {
    // Check if user is authenticated
    if (!authCheck) {
        notification('Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng', 'error');
        // mở modal sau 0.5s
        setTimeout(() => {
            openModal();
        }, 500);
        return;
    }

    //Kiểm tra tham số đầu vào
    if (!productId) {
        console.error('productId không hợp lệ');
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const quantity = 1;

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
        //nếu thêm thành công thì thông báo và tuỳ chọn chuyển hướng đến trang giỏ hàng
        if(data.success) {
            notification("Đã thêm vào giỏ hàng", 'success', 3000, function(){
                window.location.href = data.redirect_url;
            });
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
}
