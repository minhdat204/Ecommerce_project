function removeItem(cartItemId){
    const row = document.querySelector('#cart-item-' + cartItemId);
    const cartTotal = document.getElementById('total');
    fetchData('/cart/items/' + cartItemId, 'DELETE', {}, function(data){
        if(data.success) {
            row.style.transition = 'opacity 0.5s';//OR: all 0.5s ease
            row.style.opacity = 0;
            // row.style.transform = 'translateX(20px)';

            setTimeout(function(){
                row.remove();
                cartTotal.innerHTML = data.cartTotal;
                //document.querySelectorAll('tbody tr') = $('tbody tr')
                // kiểm nếu giỏ hàng rỗng
                if($('tbody tr').length === 0) {
                    $('tbody').html(
                        `<tr>
                            <td colspan="5" class="text-center">Your cart is empty</td>
                        </tr>`
                    );
                    // document.querySelector('tbody').innerHTML = `
                    //     <tr>
                    //         <td colspan="5" class="text-center">Your cart is empty</td>
                    //     </tr>
                    // `;
                }
                notification("Đã xóa sản phẩm khỏi giỏ hàng", 'success', 3000);
            }, 500);
        }
        else {
            notification(data.message || "Có lỗi xảy ra", 'error');
        }
    });
}

function clearCart(){
    const rows = document.querySelectorAll('tbody tr');
    const tbody = document.querySelector('tbody');

    const cartTotal = document.getElementById('total');

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

                cartTotal.innerHTML = '0.00 VNĐ';

                tbody.innerHTML = `
                    <tr>
                        <td colspan="5" class="text-center">Your cart is empty</td>
                    </tr>
                `;
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
}
function handleQuantityChange(input){
    const quantity = parseInt(input.value);
    const row = input.closest('tr');
    const cartItemId = row.getAttribute('data-id');
    const itemTotal = row.querySelector('.shoping__cart__total');
    const cartTotal = document.getElementById('total');
    fetchData('/cart/items/' + cartItemId, 'PATCH', {soluong: quantity}, function(data){
        if(data.success) {
            itemTotal.innerHTML = data.itemTotal;
            cartTotal.innerHTML = data.cartTotal;
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
