document.addEventListener("DOMContentLoaded", function () {
    // Lắng nghe sự kiện click trên các nút xóa
    document.querySelectorAll(".delete").forEach(button => {
        button.addEventListener("click", function () {
            // Lấy id của bình luận từ dòng bảng gần nhất
            const commentId = this.closest("tr").querySelector("td:first-child").innerText.trim();
            
            // Cập nhật action của form xóa bình luận
            const form = document.getElementById("deleteCommentForm");
            form.action = `/admin/comments/${commentId}`;  // Đặt đường dẫn đến hành động xóa bình luận
        });
    });
});