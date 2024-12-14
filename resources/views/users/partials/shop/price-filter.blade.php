<h4>Price</h4>
<div class="price-range-wrap">
    <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
        data-min="{{ $minPrice }}" data-max="{{ $maxPrice }}">
        <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
        <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
        <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
    </div>
    <div class="range-slider">
        <div class="price-input">
            <input type="text" id="minamount" value="{{ request()->get('min_price', $minPrice) }}">
            <input type="text" id="maxamount" value="{{ request()->get('max_price', $maxPrice) }}">
        </div>
    </div>
</div>
<scrip>
$(document).ready(function() {
    var minPrice = {{ $minPrice }};
    var maxPrice = {{ $maxPrice }};
    
    // Khởi tạo thanh trượt với giá trị min/max
    $(".price-range").slider({
        range: true,
        min: minPrice,
        max: maxPrice,
        values: [minPrice, maxPrice],
        slide: function(event, ui) {
            // Cập nhật giá trị input khi kéo thanh trượt
            $("#minamount").val(ui.values[0]);
            $("#maxamount").val(ui.values[1]);

            // Gửi request để lọc sản phẩm theo giá
            window.location.href = "{{ route('shop.index') }}?min_price=" + ui.values[0] + "&max_price=" + ui.values[1];
        }
    });

    // Khi người dùng thay đổi giá trị trong input, cập nhật thanh trượt
    $("#minamount, #maxamount").on("input", function() {
        var minAmount = parseInt($("#minamount").val());
        var maxAmount = parseInt($("#maxamount").val());
        
        if(minAmount >= minPrice && maxAmount <= maxPrice) {
            $(".price-range").slider("values", [minAmount, maxAmount]);
        }
    });
});
</scrip>

