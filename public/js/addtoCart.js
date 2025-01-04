function addToCart(element) {
    // Check if user is authenticated
    if (!isAuthenticated()) {
        window.location.href = loginUrl;
        return;
    }

    const quantity = $(element).data('quantity');
    const productId = $(element).data('id');

    $.ajax({
        url: cartAddUrl,
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken
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

// Helper to check authentication
function isAuthenticated() {
    return userAuthenticated;
}
