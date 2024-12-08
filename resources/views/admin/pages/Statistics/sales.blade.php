<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê Lượt Mua Theo Sản Phẩm</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <style>
        #morris-bar-chart {
            height: 400px;
        }
    </style>
</head>
<body>
    <!-- Form nhập ngày, tháng, năm -->
    <form action="{{ route('admin.statistics.productSales') }}" method="GET">
        <label36 for="year">Năm:</label>
        <input type="number" id="year" name="year" min="2000" max="2099" required>
        <label for="month">Tháng:</label>
        <input type="number" id="month" name="month" min="1" max="12">
        <label for="day">Ngày:</label>
        <input type="number" id="day" name="day" min="1" max="31">
        <button type="submit">Thống kê</button>
    </form>
    @if($productSales->isEmpty())
    <p>Không có dữ liệu cho năm và tháng đã chọn.</p>
@else
    <table>
        <tr>
            <th>Tên sản phẩm</th>
            <th>Số lượng mua</th>
        </tr>
        @foreach($productSales as $sale)
            <tr>
                <td>{{ $sale->tensanpham }}</td>
                <td>{{ $sale->tong_so_luong_mua }}</td>
            </tr>
        @endforeach
    </table>
@endif


    <!-- Phần tử để vẽ biểu đồ -->
    <div id="morris-bar-chart">
        
    </div>

    <!-- Liên kết các file JS cần thiết -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script>
        const productSales = @json($productSales);

        new Morris.Bar({
            element: 'morris-bar-chart',
            data: productSales.map(item => ({
                product: item.ten_sanpham,
                sales: item.tong_so_luong_mua
            })),
            xkey: 'product',
            ykeys: ['sales'],
            labels: ['Số lượt mua'],
            barColors: ['#3498db'],
            hideHover: 'auto',
            resize: true
        });
    </script>
</body>
</html>
