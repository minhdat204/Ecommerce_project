// view empty
const contentHtmlEmptyFavorites = `<tr>
                            <td colspan="5" class="text-center range-cart-favorites">Your favorites list is empty</td>
                        </tr>`;

function removeFavorite(favoriteId) {
    showConfirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi danh sách yêu thích không?', () => {
        const row = document.querySelector('#favorite-item-' + favoriteId);

        fetchData('/favorites/items/' + favoriteId, 'DELETE', {},
            function(data){
                if (data.success) {
                    row.style.transition = 'opacity 0.5s';
                    row.style.opacity = 0;
                    setTimeout(() => {
                        row.remove();
                        // kiểm nếu danh sách yêu thích rỗng
                        if ($('tbody tr').length === 0) {
                            $('tbody').html(
                                contentHtmlEmptyFavorites
                            );
                        }
                        // cập nhật số lượng yêu thích trên header
                        updateFavoriteCount(data.favoriteCount);
                        notification(data.message, 'success', 3000);
                    }, 500);
                }
                else {
                    notification(data.message || 'Có lỗi xảy ra', 'error');
                }
            }
        );
    });
}

function clearFavorites() {
    showConfirm('Bạn có chắc chắn muốn xóa toàn bộ danh sách yêu thích không?', function() {
        const rows = document.querySelectorAll('tbody tr');
        const tbody = document.querySelector('tbody');

        // Show loading state
        const button = document.querySelector('#clearFavorites');
        button.disabled = true;
        button.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Deleting...';

        fetchData('/favorites/clear', 'DELETE', {}, function(data) {
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

                setTimeout(() => {
                    rows.forEach(row => row.remove());
                    // Hiển thị thông báo danh sách yêu thích trống
                    tbody.innerHTML = contentHtmlEmptyFavorites;
                    // cập nhật số lượng yêu thích trên header
                    updateFavoriteCount(0);
                    notification("Đã xóa toàn bộ danh sách yêu thích", 'success', 3000);
                }, 500);
            } else {
                notification(data.message || "Có lỗi xảy ra", 'error');
            }
        }, null, function() {
            button.disabled = false;
            button.innerHTML = 'DELETE FAVORITES';
        });
    });
}
