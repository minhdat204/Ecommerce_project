// const { default: axios } = require("axios");

function handlePriceChange(event, ui) {
    const productContent = document.getElementById("product__content");
    const loadingSpinner = document.getElementById("loading-spinner");

    const pathParts = window.location.pathname.split('/');
    const slug = pathParts[pathParts.length - 1]; // Get the last part of the path as slug

    const filters = {
        keyword: new URLSearchParams(window.location.search).get("keyword") || "",
        id_category: new URLSearchParams(window.location.search).get("id_category") || "",
        minPrice: ui.values[0],
        maxPrice: ui.values[1],
        slug: slug // Add the slug to filters
    };

    // Show loading indicator
    productContent.style.display = "none";
    loadingSpinner.style.display = "block";

    // Convert filters object to query string
    const queryString = new URLSearchParams(filters).toString();
        // Update URL without reload
    const newUrl = `${window.location.pathname}?${queryString}`;
    window.history.pushState({ path: newUrl }, '', newUrl);

    //chuyển hướng ngay thay vì fetch
    // window.location.href = newUrl;

    // Use fetch to send a GET request
    fetch(`/shop/search?${queryString}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then((response) => response.json())
    .then((data) => {
        if (data.success) {
                productContent.innerHTML = data.html;
                productContent.style.display = "block";
                updateBackgroundImages();

        } else {
            throw new Error('Server returned error response');
        }
    })
    .catch((error) => {
        console.error("Error:", error);
        productContent.innerHTML =
            '<div class="alert alert-danger">Error loading products</div>';
    })
    .finally(() => {
        // Ẩn spinner sau khi hoàn thành
        loadingSpinner.style.display = "none";
    });
};

// Hàm cập nhật ảnh nền
function updateBackgroundImages() {
    const elements = document.querySelectorAll(".set-bg");
    elements.forEach(element => {
        const bg = element.getAttribute("data-setbg");
        if (bg) {
            element.style.backgroundImage = `url(${bg})`;
        }
    });
}
