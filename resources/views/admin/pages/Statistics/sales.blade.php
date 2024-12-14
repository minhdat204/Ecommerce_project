@extends('Admin.Layout.Layout')

@section('namepage', 'Product Sales Statistics')

@section('css_custom')
<link href="{{ asset('Admin/css/website-info.css') }}" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css" rel="stylesheet">
@endsection

@section('content')
<!-- Form lọc theo thời gian -->
<form action="{{ route('admin.statistics.productSales') }}" method="GET" class="date-filter-form">
    <label for="start_date" class="form-label">Ngày bắt đầu:</label>
    <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="form-input">

    <label for="end_date" class="form-label">Ngày kết thúc:</label>
    <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="form-input">

    <button type="submit" class="form-button">Lọc</button>
</form>


<!-- Hiển thị biểu đồ lượt mua -->
<div id="sales-chart" style="height: 300px;"></div>



<!-- Liên kết các file JS cần thiết -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/raphael@2.3.0/raphael.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

<script>
    $(function() {
        // Dữ liệu được truyền từ PHP sang JS
        var productSales = @json($productSales);        

        // Kiểm tra nếu dữ liệu tồn tại và có giá trị
        if (productSales && productSales.length > 0) {
            // Chuyển đổi dữ liệu để phù hợp với cấu trúc yêu cầu của Morris.js
            var chartData = productSales.map(function(item) {
                return {
                    product: item.tensanpham,  // Tên sản phẩm
                    sales: item.total_sales    // Lượt mua (số lượng sản phẩm đã bán)
                };
            });

            // Vẽ biểu đồ cột Morris
            Morris.Bar({
                element: 'sales-chart',  // id của thẻ HTML chứa biểu đồ
                data: chartData,  // Dữ liệu đã được chuyển đổi
                xkey: 'product',  // Trục X (tên sản phẩm)
                ykeys: ['sales'],  // Trục Y (số lượng sản phẩm đã bán)
                labels: ['Lượt mua'],  // Ghi chú cho trục Y
                barColors: ['#0b62a4'],  // Màu sắc cột
                hoverCallback: function(index, options, content, row) {
                    return row.product + "<br>" + "Lượt mua: " + row.sales;  // Khi hover vào một nốt
                },
                hideHover: 'auto',  // Ẩn hover tự động khi không cần thiết
                resize: true,  // Cho phép biểu đồ tự động thay đổi kích thước khi thay đổi kích thước cửa sổ
                barWidth: 5
            });
        } else {
            console.log('Dữ liệu không hợp lệ hoặc không có dữ liệu.');
        }
    });
</script>

@endsection
