document.addEventListener("DOMContentLoaded", function () {
    // Lắng nghe sự kiện click trên các nút xóa
    document.querySelectorAll(".delete").forEach(button => {
        button.addEventListener("click", function () {
            // Lấy id của bình luận từ dòng bảng gần nhất
            const contactId = this.closest("tr").querySelector("td:first-child").innerText.trim();

            // Cập nhật action của form xóa bình luận
            const form = document.getElementById(`deleteContactForm${contactId}`);
            form.action = `/admin/contacts/${contactId}`;  // Đường dẫn xóa, dùng route tên là comment.destroy

            // Cập nhật modal ID
            const modal = document.getElementById(`deleteContactForm${contactId}`);
            $(modal).modal('show');  // Mở modal
        });
    });
});
