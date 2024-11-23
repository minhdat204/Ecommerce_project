document.addEventListener("DOMContentLoaded", function () {
    // Lắng nghe sự kiện click trên các nút xóa
    document.querySelectorAll(".delete").forEach(button => {
        button.addEventListener("click", function () {
            const commentId = this.closest("tr").querySelector("td:first-child").innerText.trim();

            // Cập nhật action của form xóa bình luận
            const form = document.getElementById(`deleteCommentForm${commentId}`);
            form.action = `/admin/comments/${commentId}`;

            // Cập nhật modal ID
            const modal = document.getElementById(`deleteCommentModal${commentId}`);
            $(modal).modal('show');  // Mở modal
        });
    });
});
