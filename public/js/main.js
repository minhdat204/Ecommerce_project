/*  ---------------------------------------------------
    Template Name: Ogani
    Description:  Ogani eCommerce  HTML Template
    Author: Colorlib
    Author URI: https://colorlib.com
    Version: 1.0
    Created: Colorlib
---------------------------------------------------------  */

'use strict';

(function ($) {

    /*------------------
        Preloader
    --------------------*/
    $(window).on('load', function () {
        $(".loader").fadeOut();
        $("#preloder").delay(200).fadeOut("slow");

        /*------------------
            Gallery filter
        --------------------*/
        $('.featured__controls li').on('click', function () {
            $('.featured__controls li').removeClass('active');
            $(this).addClass('active');
        });
        if ($('.featured__filter').length > 0) {
            var containerEl = document.querySelector('.featured__filter');
            var mixer = mixitup(containerEl);
        }
    });

    /*------------------
        Background Set
    --------------------*/
    $('.set-bg').each(function () {
        var bg = $(this).data('setbg');
        $(this).css('background-image', 'url(' + bg + ')');
    });

    //Humberger Menu
    $(".humberger__open").on('click', function () {
        $(".humberger__menu__wrapper").addClass("show__humberger__menu__wrapper");
        $(".humberger__menu__overlay").addClass("active");
        $("body").addClass("over_hid");
    });

    $(".humberger__menu__overlay").on('click', function () {
        $(".humberger__menu__wrapper").removeClass("show__humberger__menu__wrapper");
        $(".humberger__menu__overlay").removeClass("active");
        $("body").removeClass("over_hid");
    });

    /*------------------
		Navigation
	--------------------*/
    $(".mobile-menu").slicknav({
        prependTo: '#mobile-menu-wrap',
        allowParentLinks: true
    });

    /*-----------------------
        Categories Slider
    ------------------------*/
    $(".categories__slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 4,
        dots: false,
        nav: true,
        navText: ["<span class='fa fa-angle-left'><span/>", "<span class='fa fa-angle-right'><span/>"],
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        responsive: {

            0: {
                items: 1,
            },

            480: {
                items: 2,
            },

            768: {
                items: 3,
            },

            992: {
                items: 4,
            }
        }
    });


    $('.hero__categories__all').on('click', function(){
        $('.hero__categories ul').slideToggle(400);
    });

    /*--------------------------
        Latest Product Slider
    ----------------------------*/
    $(".latest-product__slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 1,
        dots: false,
        nav: true,
        navText: ["<span class='fa fa-angle-left'><span/>", "<span class='fa fa-angle-right'><span/>"],
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true
    });

    /*-----------------------------
        Product Discount Slider
    -------------------------------*/
    $(".product__discount__slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 3,
        dots: true,
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        responsive: {

            320: {
                items: 1,
            },

            480: {
                items: 2,
            },

            768: {
                items: 2,
            },

            992: {
                items: 3,
            }
        }
    });

    /*---------------------------------
        Product Details Pic Slider
    ----------------------------------*/
    $(".product__details__pic__slider").owlCarousel({
        loop: true,
        margin: 20,
        items: 4,
        dots: true,
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true
    });

    /*-----------------------
		Price Range Slider
	------------------------ */
    var rangeSlider = $(".price-range"),
        minamount = $("#minamount"),
        maxamount = $("#maxamount"),
        minPrice = rangeSlider.data('min'),
        maxPrice = rangeSlider.data('max');
    rangeSlider.slider({
        range: true,
        min: minPrice,
        max: maxPrice,
        values: [minPrice, maxPrice],
        slide: function (event, ui) {
            minamount.val('$' + ui.values[0]);
            maxamount.val('$' + ui.values[1]);
        }
    });
    minamount.val('$' + rangeSlider.slider("values", 0));
    maxamount.val('$' + rangeSlider.slider("values", 1));

    /*--------------------------
        Select
    ----------------------------*/
    $("select").niceSelect();

    /*------------------
		Single Product
	--------------------*/
    $('.product__details__pic__slider img').on('click', function () {

        var imgurl = $(this).data('imgbigurl');
        var bigImg = $('.product__details__pic__item--large').attr('src');
        if (imgurl != bigImg) {
            $('.product__details__pic__item--large').attr({
                src: imgurl
            });
        }
    });

    /*-------------------
        Quantity change
    --------------------- */
    var proQty = $('.pro-qty');
    proQty.on('click', '.qtybtn', function () {
        var $button = $(this);
        var $input = $button.parent().find('input');
        var oldValue = parseInt($input.val());
        var maxValue = parseInt($input.attr('max'));
        var minValue = parseInt($input.attr('min'));

        if ($button.hasClass('inc')) {
            var newVal = oldValue + 1;
            if (newVal > maxValue) newVal = maxValue;
        } else {
            var newVal = oldValue - 1;
            if (newVal < minValue) newVal = minValue;
        }

        $input.val(newVal);
        $input.trigger('change'); // Trigger change event
    });

})(jQuery);

//Dat: hàm tái sử dụng fetch api
function fetchData(url, method, body = null, successCallback, errorCallback, finallyCallback) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    //thiết lập mặc định các option cho fetch
    const options = {
        method,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    };

    //nếu là phương thức ngoài get thì thêm header và body
    if (method !== 'GET' && body) {
        options.headers['Content-Type'] = 'application/json';
        options.body = JSON.stringify(body);
    }

    fetch(url, options)
    .then(response => {
        if (!response.ok) {
            notification('Có lỗi xảy ra, vui lòng thử lại sau.', 'error');
            throw new Error('có lỗi xảy ra, vui lòng thử lại sau.');
        }
        return response.json();
    })
    .then(data => successCallback(data))
    .catch(error => {
        console.error('Error:', error);
        notification('Có lỗi xảy ra, vui lòng thử lại sau.', 'error');
        if(errorCallback) errorCallback(error);
    })
    .finally(() => {
        if(finallyCallback) finallyCallback();
    });
}

//cải tiến hàm fetch api
async function fetchData2(url, method, body = null, successCallback, errorCallback, finallyCallback) {
    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        // Thiết lập mặc định các option cho fetch
        const options = {
            method,
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
        };

        // Nếu là phương thức ngoài GET thì thêm header và body
        if (method !== 'GET' && body) {
            options.headers['Content-Type'] = 'application/json';
            options.body = JSON.stringify(body);
        }

        // Gửi yêu cầu fetch
        const response = await fetch(url, options);

        // Kiểm tra phản hồi
        if (!response.ok) {
            const errorMessage = `Lỗi ${response.status}: ${response.statusText}`;
            console.error('Fetch Error:', errorMessage);
            notification(errorMessage, 'error');
            throw new Error(errorMessage);
        }

        // Chuyển đổi dữ liệu sang JSON
        const data = await response.json();
        if (successCallback) successCallback(data);
    } catch (error) {
        console.error('Error:', error);
        notification('Có lỗi xảy ra, vui lòng thử lại sau.', 'error');
        if (errorCallback) errorCallback(error);
    }
    finally {
        if (finallyCallback) finallyCallback();
    }
}

// Dat: Hàm hiển thị thông báo
function notification(message, type = 'error', duration = 3000, onClick = null) {
    const bgColors = {
        error: '#ff6b6b',
        success: '#7fad39',
        warning: '#ffd43b',
        info: '#4dabf7'
    };

    Toastify({
        text: message,
        duration: duration,
        gravity: "top",
        position: "right",
        style: {
            background: bgColors[type] || bgColors.error,
        },
        onClick: onClick || function(){}
    }).showToast();
}

// Dat: lắng nghe sự kiện pageshow để reload trang khi dùng nút back/forward
window.addEventListener('pageshow', function(event) {
    // Define paths that need reload
    const pathsNeedReload = [
        '/cart',
        // Add more paths as needed
    ];

    // Get current path
    const currentPath = window.location.pathname;

    // Check if current path needs reload
    if (!pathsNeedReload.includes(currentPath)) {
        return; // Exit if not a path that needs reload
    }

    // Check back-forward cache
    if (event.persisted) {
        window.location.reload();
        return;
    }

    // Check navigation type
    if (window.performance && window.performance.getEntriesByType) {
        const navigationEntries = window.performance.getEntriesByType('navigation');
        if (navigationEntries.length > 0) {
            const navigationType = navigationEntries[0].type;
            if (navigationType === 'back_forward') {
                window.location.reload();
            }
        }
    }
});


// Dat: Hàm chọn danh mục cho tìm kiếm
function selectCategory(element, id_category = null) {
    const categoryText = element.textContent.trim();
    const categoriesDiv = document.querySelector('.hero__search__categories');
    const categoryDisplay = categoriesDiv.querySelector('.category-display');

    categoryDisplay.textContent = categoryText;
    if(id_category != null) {
        const categoryInput = categoriesDiv.querySelector('input[name="category"]');
        categoryInput.value = id_category;
    }
}
