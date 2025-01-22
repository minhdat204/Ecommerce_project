const contentHtmlEmptyCart = `<tr>
                                <td colspan="5" class="text-center range-cart-favorites">Your cart is empty</td>
                            </tr>`;

// hàm check số lượng sản phẩm tồn kho trong giỏ hàng
let checkQuantityNotification = null;

function updateQuantityNotification() {
    const remainingChecks = document.getElementById('overStockCount').value;
    const checkoutButton = document.querySelector('.shoping__checkout a');

    // Clear thông báo cũ
    if (checkQuantityNotification) {
        checkQuantityNotification.hideToast();
    }

    // Nếu còn sản phẩm cần cập nhật số lượng
    if (remainingChecks > 0) {
        checkQuantityNotification = Toastify({
            text: `Có ${remainingChecks} sản phẩm cần cập nhật số lượng, vui lòng cập nhật trước khi thanh toán.`,
            duration: -1, // Persistent until manually closed
            gravity: "top",
            position: "right",
            style: {
                background: "#ff6b6b",
            }
        }).showToast();

        // Disable checkout button
        checkoutButton.classList.add('disabled');
    } else {
        // Enable checkout button
        checkoutButton.classList.remove('disabled');
    }
}
// mở thông báo cập nhật số lượng mỗi khi load trang
updateQuantityNotification();


 // trang hiện tại
 const pageActive = document.querySelector('.product__pagination a.active')?.textContent?.trim();
 var currentPage = pageActive || 1;

// hàm xóa sản phẩm khỏi giỏ hàng
function removeItem(cartItemId) {
    // kiểm tra xem có phải sản phẩm cuối cùng không
    if ($('tbody tr').length === 1) {
        currentPage = pageActive > 1 ? pageActive - 1 : 1;
        // lấy url hiện tại
        var url = new URL(window.location.href);
    }

    showConfirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng không?', function() {
        const row = document.querySelector('#cart-item-' + cartItemId);
        const cartTotal = document.getElementById('total');
        const subTotal = document.getElementById('subtotal');
        // biến check thông báo số lượng tồn kho
        const warningDiv = row.querySelector('.checkQuantity');
        const check = row.classList.contains('check');

        // Lấy CSRF token từ meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Gọi API xóa sản phẩm
        fetch('/cart/items/' + cartItemId, {
            method: 'DELETE',
            headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
            currentPage: currentPage // Truyền trang hiện tại vào request
            })
        })
        .then(response => {
            if (!response.ok) {
            throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if(data.success) {
            row.style.transition = 'opacity 0.5s';
            row.style.opacity = 0;
            // nếu có url thì cập nhật trang hiện tại
            if(url){
                url.searchParams.set('page', currentPage);
                window.history.pushState({}, '', url);
            }

            setTimeout(() => {
                // cập nhật lại view giỏ hàng
                $('.shoping__cart__table').html(data.cartView);
                // cập nhật tổng tiền và tổng số tiền
                cartTotal.innerHTML = data.cartTotal + (data.discount ? ' (-' + data.discount + '%)' : '');
                subTotal.innerHTML = data.subTotal;
                // cập nhật số lượng sp giỏ hàng trên header và tổng tiền
                updateCartCountAndTotal(data.cartTotal, data.cartCount);
                // cập nhật thông báo số lượng tồn kho
                if (warningDiv && check) {
                document.getElementById('overStockCount').value = Number(document.getElementById('overStockCount').value) - 1;
                // cập nhật thông báo
                updateQuantityNotification();
                }
                notification("Đã xóa sản phẩm khỏi giỏ hàng", 'success', 3000);
            }, 500);
            }
            else {
            notification(data.message || "Có lỗi xảy ra", 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            notification('Có lỗi xảy ra, vui lòng thử lại sau.', 'error');
        });
    });
}
// hàm xóa toàn bộ sản phẩm khỏi giỏ hàng
function clearCart(){
    showConfirm('Bạn có chắc chắn muốn xóa toàn bộ giỏ hàng không?', function() {
        const rows = document.querySelectorAll('tbody tr');
        const tbody = document.querySelector('tbody');

        const cartTotal = document.getElementById('total');
        const subTotal = document.getElementById('subtotal');

        const checkoutButton = document.querySelector('.shoping__checkout a');

        // Show loading
        const button = document.querySelector('#deleteCart');
        button.disabled = true;
        button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Deleting...';

        // Lấy CSRF token từ meta tag
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Gọi API xóa toàn bộ giỏ hàng
        fetch('/cart/clear', {
            method: 'DELETE',
            headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => {
            if (!response.ok) {
            throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if(data.success) {
            tbody.innerHTML = `
                <tr>
                <td colspan="5" class="text-center">
                    <i class="fa fa-spinner fa-spin"></i> Loading...
                </td>
                </tr>
            `;

            rows.forEach(row => {
                row.style.transition = 'opacity 0.5s';
                row.style.opacity = 0;
            });
            //chuyên hướng sau 0.5s
            setTimeout(() => {
                rows.forEach(row => {
                row.remove();
                });

                // cập nhật tổng tiền và tổng số tiền
                cartTotal.innerHTML = '0đ';
                subTotal.innerHTML = '0đ';

                // Hiển thị thông báo giỏ hàng trống
                tbody.innerHTML = contentHtmlEmptyCart;
                // cập nhật số lượng sp giỏ hàng trên header và tổng tiền
                updateCartCountAndTotal();

                if (checkQuantityNotification) {
                checkQuantityNotification.hideToast();
                // Disable checkout button
                checkoutButton.classList.add('disabled');
                }
                notification("Đã xóa toàn bộ sản phẩm khỏi giỏ hàng", 'success', 3000);
            }, 500);
            } else {
            notification(data.message || "Có lỗi xảy ra", 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            notification('Có lỗi xảy ra, vui lòng thử lại sau.', 'error');
        })
        .finally(() => {
            button.disabled = false;
            button.innerHTML = 'DELETE ALL';
        });
    });
}


// hàm cập nhật số lượng sản phẩm
function handleQuantityChange(input, maxValue){
    const quantity = parseInt(input.value);

    const maxQuantity = maxValue;
    const originalValue = parseInt(input.getAttribute('data-original-value'));

    if (!quantity || quantity < 1) {
        input.value = originalValue;
        notification('Số lượng không được nhỏ hơn 1', 'error');
        return;
    }

    if (quantity > maxQuantity) {
        input.value = originalValue;
        notification('Số lượng hiện tại trong kho là ' + maxQuantity, 'error');
        return;
    }

    const row = input.closest('tr');
    const cartItemId = row.getAttribute('data-id');
    const itemTotal = row.querySelector('.shoping__cart__total');
    const cartTotal = document.getElementById('total');
    const subTotal = document.getElementById('subtotal');

    // lấy phần tử để cập nhật tổng tiền ở header
    const headerCartTotalElement = document.getElementById('cart-total');
    // Lấy CSRF token từ meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // Gọi API cập nhật số lượng
    fetch('/cart/items/' + cartItemId, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ soluong: quantity })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if(data.success) {
            itemTotal.innerHTML = data.itemTotal;
            cartTotal.innerHTML = data.cartTotal + (data.discount ? ' (-' + data.discount + '%)' : '');
            subTotal.innerHTML = data.subTotal;
            headerCartTotalElement.innerHTML = data.cartTotal;
            input.setAttribute('data-original-value', quantity);

            // loại bỏ trạng thái sản phẩm có số lượng không lệ nếu đã cập nhật số lượng hợp lệ
            if (quantity <= maxQuantity) {
                const warningDiv = row.querySelector('.checkQuantity');
                const check = row.classList.contains('check');
                if (warningDiv && check) {
                    warningDiv.remove();
                    row.classList.remove('check');
                    document.getElementById('overStockCount').value = Number(document.getElementById('overStockCount').value) - 1;
                    // cập nhật thông báo
                    updateQuantityNotification();
                }
            }

            notification("Đã cập nhật số lượng", 'success', 3000);
        }
        else {
            notification(data.message || "Có lỗi xảy ra", 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        notification('Có lỗi xảy ra, vui lòng thử lại sau.', 'error');
    });
}

// Kiểm tra số lượng tồn kho
// const checkQuantities = document.querySelectorAll('.checkQuantity');
// if (checkQuantities.length > 0) {


// function removeItem(cartItemId){
    // const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    // fetch('/cart/items/' + cartItemId, {
    //     method: 'DELETE',
    //     headers: {
    //         'Content-Type': 'application/json',
    //         'X-CSRF-TOKEN': csrfToken
    //     },
    // })
    // .then(response => {
    //     if (!response.ok) {
    //         notification('Có lỗi xảy ra, vui lòng thử lại sau.', 'error');
    //         throw new Error('có lỗi xảy ra, vui lòng thử lại sau.');
    //     }
    //     return response.json();
    // })
    // .then(data => {
    //     if(data.success) {
    //         notification("Đã xóa sản phẩm khỏi giỏ hàng", 'success', 3000, function(){
    //             window.location.reload();
    //         });
    //     }
    //     else {
    //         notification(data.message || "Có lỗi xảy ra", 'error');
    //     }
    // })
    // .catch(error => {
    //     console.error('Error:', error);
    //     notification('Có lỗi xảy ra, vui lòng thử lại sau.', 'error');
    // });
// }
