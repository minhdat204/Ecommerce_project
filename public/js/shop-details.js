// add to cart
function addToCart(productId) {
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
            // cập nhật số lượng sp giỏ hàng trên header và tổng tiền
            updateCartCountAndTotal(data.cartTotal, data.cartCount);
            notification("Đã thêm vào giỏ hàng", 'success', 3000);
            setTimeout(() => {
                showRedirectNotification(`Nhấp vào đây để chuyển hướng đến giỏ hàng`, 6000, data.redirect_url);
            }, 1000);

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

function toggleFavorite(productId) {
    if (!authCheck) {
        notification('Vui lòng đăng nhập để thêm sản phẩm vào yêu thích', 'error');
        setTimeout(() => openModal(), 500);
        return;
    }

    const btn = document.querySelector(`.favorite-btn[data-id="${productId}"]`);
    if (!btn) return;

    // Disable button & add loading state
    btn.disabled = true;
    const originalContent = btn.innerHTML;
    btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';

    fetch(`/favorites/toggle/${productId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // cập nhật số lượng yêu thích trên header
            updateFavoriteCount(data.favoriteCount);
            // chuẩn hóa trạng thái của nút yêu thích
            btn.classList.toggle('active');

            // Update icons
            const emptyHeart = btn.querySelector('.heart-empty');
            const filledHeart = btn.querySelector('.heart-filled');

            if (emptyHeart && filledHeart) {
                if (data.isAdded) {
                    emptyHeart.style.opacity = 0;
                    filledHeart.style.opacity = 1;
                    filledHeart.style.transform = 'scale(1)';
                } else {
                    emptyHeart.style.opacity = 1;
                    filledHeart.style.opacity = 0;
                    filledHeart.style.transform = 'scale(0)';
                }
            }

            notification(data.message, 'success');
        } else {
            notification(data.message || 'Có lỗi xảy ra', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        notification('Có lỗi xảy ra, vui lòng thử lại sau.', 'error');
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = originalContent;
    });
}
