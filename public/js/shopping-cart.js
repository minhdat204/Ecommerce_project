const contentHtmlEmptyCart = `<tr>
                                <td colspan="5" class="text-center range-cart-favorites">Your cart is empty</td>
                            </tr>`;

// hàm xóa sản phẩm khỏi giỏ hàng
function removeItem(cartItemId){
    showConfirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng không?', function() {
        const row = document.querySelector('#cart-item-' + cartItemId);
        const cartTotal = document.getElementById('total');
        const subTotal = document.getElementById('subtotal');

        fetchData('/cart/items/' + cartItemId, 'DELETE', {}, function(data){
            if(data.success) {
                row.style.transition = 'opacity 0.5s';//OR: all 0.5s ease
                row.style.opacity = 0;
                // row.style.transform = 'translateX(20px)';

                setTimeout(function(){
                    row.remove();
                    cartTotal.innerHTML = data.cartTotal + (data.discount ? ' (-' + data.discount + '%)' : '');
                    subTotal.innerHTML = data.subTotal;
                    //document.querySelectorAll('tbody tr') = $('tbody tr')
                    // kiểm nếu giỏ hàng rỗng
                    if($('tbody tr').length === 0) {
                        $('tbody').html(
                            contentHtmlEmptyCart
                        );
                        // document.querySelector('tbody').innerHTML = `
                        //     <tr>
                        //         <td colspan="5" class="text-center">Your cart is empty</td>
                        //     </tr>
                        // `;
                    }
                    // cập nhật số lượng sp giỏ hàng trên header và tổng tiền
                    updateCartCountAndTotal(data.cartTotal, data.cartCount);
                    notification("Đã xóa sản phẩm khỏi giỏ hàng", 'success', 3000);
                }, 500);
            }
            else {
                notification(data.message || "Có lỗi xảy ra", 'error');
            }
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

        // Show loading
        const button = document.querySelector('#deleteCart');
        button.disabled = true;
        button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Deleting...';

        fetchData('/cart/clear', 'DELETE', {}, function(data){
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
                    notification("Đã xóa toàn bộ sản phẩm khỏi giỏ hàng", 'success', 3000);
                }, 500);
            }
            else {
                notification(data.message || "Có lỗi xảy ra", 'error');
            }
        }, null, function(){
            button.disabled = false;
            button.innerHTML = 'DELETE ALL';
        });
    });
}
// hàm cập nhật số lượng sản phẩm
function handleQuantityChange(input){
    const quantity = parseInt(input.value);
    const row = input.closest('tr');
    const cartItemId = row.getAttribute('data-id');
    const itemTotal = row.querySelector('.shoping__cart__total');
    const cartTotal = document.getElementById('total');
    const subTotal = document.getElementById('subtotal');
    // lấy phần tử để cập nhật tổng tiền ở header
    const headerCartTotalElement = document.getElementById('cart-total');
    fetchData('/cart/items/' + cartItemId, 'PATCH', {soluong: quantity}, function(data){
        if(data.success) {
            itemTotal.innerHTML = data.itemTotal;
            cartTotal.innerHTML = data.cartTotal + (data.discount ? ' (-' + data.discount + '%)' : '');
            subTotal.innerHTML = data.subTotal;
            headerCartTotalElement.innerHTML = data.cartTotal;
            notification("Đã cập nhật số lượng", 'success', 3000);
        }
        else {
            notification(data.message || "Có lỗi xảy ra", 'error');
        }
    });
}


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
