@extends('Admin.Layout.Layout')

@section('namepage', 'Doanh thu theo ngày')

@section('css_custom')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css" rel="stylesheet">
@endsection

@section('content')
    <!-- Form lọc theo thời gian -->
    <form action="{{ route('admin.statistics.sales') }}" method="GET" class="date-filter-form">
        <label for="start_date" class="form-label">Ngày bắt đầu:</label>
        <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" class="form-input">

        <label for="end_date" class="form-label">Ngày kết thúc:</label>
        <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" class="form-input">

        <button type="submit" class="form-button">Lọc</button>
    </form>

    <p><strong>Doanh thu theo ngày:</strong></p>

    <!-- Hiển thị biểu đồ doanh thu -->
    <div id="sales-chart" style="height: 300px;"></div>

@endsection

@section('js_custom')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

    <script>
        $(function() {
            var salesData = @json($salesData);

            if (salesData && salesData.length > 0) {
                var chartData = salesData.map(function(item) {
                    return {
                        date: item.formatted_date, // Ngày
                        sales: item.total_sales // Doanh thu
                    };
                });

                Morris.Bar({
                    element: 'sales-chart',
                    data: chartData,
                    xkey: 'date', // Trục X: ngày
                    ykeys: ['sales'], // Trục Y: doanh thu
                    labels: ['Doanh thu'], // Ghi chú cho trục Y
                    barColors: ['#0b62a4'],
                    hideHover: 'auto',
                    resize: true
                });
            } else {
                console.log('Không có dữ liệu doanh thu.');
            }
            2
        });
    </script>
@endsection
