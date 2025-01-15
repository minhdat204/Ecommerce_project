function quickToggleFavorite(productId){
    // Check if user is authenticated
    if (!authCheck) {
        notification('Vui lòng đăng nhập để thêm sản phẩm vào danh sách yêu thích', 'error');
        // open modal after 0.5s
        setTimeout(() => {
            openModal();
        }, 500);
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    fetch(`/favorites/toggle/${productId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // cập nhật số lượng yêu thích trên header
            updateFavoriteCount(data.favoriteCount);
            notification(data.message, 'success');

            // hiển thị thông báo chuyển hướng sau 1s
            setTimeout(() => {
                showRedirectNotification('Nhấp vào đây để xem danh sách yêu thích', 6000, data.redirect_url);
            }, 1000);
        } else {
            notification(data.message || 'Có lỗi xảy ra', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        notification('Có lỗi xảy ra, vui lòng thử lại sau.', 'error');
    });
}
