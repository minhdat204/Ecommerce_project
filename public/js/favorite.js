
document.addEventListener('DOMContentLoaded', function () {
const tabs = document.querySelectorAll('.profile-navigation a');
const tabPanes = document.querySelectorAll('.profile-tab-pane');
tabs.forEach((tab, index) => {
    tab.addEventListener('click', function (e) {
        e.preventDefault();

        // Loại bỏ lớp active khỏi tất cả tab và ẩn các pane
        tabs.forEach((t) => t.classList.remove('active'));
        tabPanes.forEach((pane) => pane.style.display = 'none');

        // Thêm lớp active vào tab được nhấn và hiển thị nội dung pane
        tab.classList.add('active');
        tabPanes[index].style.display = 'block';
    });
});

// Đảm bảo tab Favorites hiển thị nếu có lỗi khi reload lại
if (window.location.hash === '#favorites') {
    tabs[1].click();
}
});