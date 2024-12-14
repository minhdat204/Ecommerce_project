@extends('Admin.Layout.Layout')

@section('namepage', 'Statistical Management')

@section('css_custom')
<link href="{{ asset('Admin/css/website-info.css') }}" rel="stylesheet">
<!-- Morris.js CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css" rel="stylesheet">
@endsection

@section('content')
<!-- Form lọc theo thời gian -->
<form action="{{ route('admin.statistics.index') }}" method="GET" class="date-filter-form">
    <label for="start_date" class="form-label">Ngày bắt đầu:</label>
    <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="form-input">

    <label for="end_date" class="form-label">Ngày kết thúc:</label>
    <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="form-input">

    <button type="submit" class="form-button">Lọc</button>
</form>

<style>
    /* Định dạng cho toàn bộ form */
    .date-filter-form {
        display: flex;
        align-items: center; /* Căn chỉnh theo chiều dọc */
        justify-content: flex-start; /* Căn chỉnh theo chiều ngang */
        width: 100%;
        margin: 20px auto;
        padding: 10px;
        background-color: #f9f9f9;
    }

    /* Định dạng cho nhãn (label) */
    .form-label {
        font-size: 14px;
        margin-right: 10px; /* Khoảng cách giữa label và input */
        color: #333;
    }

    /* Định dạng cho các ô nhập liệu (input) */
    .form-input {
        padding: 8px;
        margin-right: 15px; /* Khoảng cách giữa các ô nhập liệu */
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
        width: 150px; /* Kích thước cố định cho các ô nhập liệu */
    }

    /* Định dạng cho nút lọc */
    .form-button {
        padding: 8px 15px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s ease;
    }

    /* Hiệu ứng hover cho nút lọc */
    .form-button:hover {
        background-color: #45a049;
    }

    /* Đảm bảo các phần tử không bị tràn trong form */
    .form-input, .form-button {
        box-sizing: border-box;
    }
</style>

<!-- Ghi chú trước sơ đồ -->
 <p></p>
<p><strong>Doanh thu :</strong> Biểu đồ dưới đây thể hiện doanh thu.</p>

<!-- Hiển thị biểu đồ doanh thu -->
<div id="sales-chart" style="height: 300px;"></div>
<!-- Morris Area Chart for Sales -->
<div id="morris-area-chart" style="height: 250px;"></div>
<td><p>VNĐ: Việt Nam Đồng</p></td>
<td><p>Định dạng thời gian: Năm - Tháng - Ngày</p></td>
@endsection

@section('js_custom')
<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- MetisMenu -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/metisMenu/3.0.7/metisMenu.min.js"></script>

<!-- Khởi tạo MetisMenu -->
<script>
    $(function() {
        $('#menu').metisMenu();  // Khởi tạo MetisMenu
    });
</script>

<!-- Raphael.js (phải được tải trước Morris.js) -->
<script src="https://cdn.jsdelivr.net/npm/raphael@2.3.0/raphael.min.js"></script>

<!-- Morris.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

<script>
    $(function() {
        // Dữ liệu được truyền từ PHP sang JS
        var salesData = @json($salesData);        
        console.log(salesData); // Kiểm tra dữ liệu

        // Kiểm tra nếu dữ liệu tồn tại và có giá trị
        if (salesData && salesData.length > 0) {
            // Chuyển đổi dữ liệu để phù hợp với cấu trúc yêu cầu của Morris.js
            var chartData = salesData.map(function(item) {
                return {
                    date: item.formatted_date, // Ngày dưới dạng dd/mm/yyyy
                    sales: item.total_sales // Doanh thu
                };
            });

            // Vẽ biểu đồ cột Morris
            Morris.Bar({
                element: 'sales-chart',  // id của thẻ HTML chứa biểu đồ
                data: chartData,  // Dữ liệu đã được chuyển đổi
                xkey: 'date',  // Trục X (ngày)
                ykeys: ['sales'],  // Trục Y (doanh thu)
                labels: ['Doanh thu'],  // Ghi chú cho trục Y
                barColors: ['#0b62a4'],  // Màu sắc cột
                hoverCallback: function(index, options, content, row) {
                    return row.date + "<br>" + "Doanh thu: " + row.sales;  // Khi hover vào một nốt
                },
                preUnits: 'VNĐ ',  // Thêm "VNĐ" vào trước giá trị doanh thu
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
