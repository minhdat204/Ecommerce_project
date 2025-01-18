@extends('Admin.Layout.Layout')

@section('namepage', 'Thống kê doanh thu')
@section('content')
    <style>
        .stats-container,
        .charts-container {
            display: grid;
            gap: 20px;
            margin-bottom: 30px;
        }

        .stats-container {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        }

        .charts-container {
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        }

        .stat-card,
        .chart-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .stat-title {
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
        }

        .stat-circle {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto;
        }

        .stat-value {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 24px;
            font-weight: bold;
        }

        .time-filter {
            display: flex;
            justify-content: flex-end;
            /* Căn chỉnh các nút về bên trái */
            gap: 10px;
            /* Khoảng cách giữa các nút */
        }

        .time-button {
            padding: 5px 15px;
            border-radius: 20px;
            border: none;
            background: #f0f0f0;
            cursor: pointer;
            font-size: 12px;
        }

        .time-button.active {
            background: #007bff;
            color: white;
        }
    </style>

    <div class="stats-container">
        <div class="stat-card">
            {{-- <div class="stat-title">Tổng doanh thu</div> --}}
            <div class="stat-circle">
                <canvas id="salesChart"></canvas>
                <div class="stat-value">{{ number_format($totalSales) }} </div>
            </div>
        </div>
        <div class="stat-card">
            {{-- <div class="stat-title">Tổng đơn hàng</div> --}}
            <div class="stat-circle">
                <canvas id="ordersChart"></canvas>
                <div class="stat-value">{{ $totalOrders }}</div>
            </div>
        </div>
        <div class="stat-card">
            {{-- <div class="stat-title">Sản phẩm đã bán</div> --}}
            <div class="stat-circle">
                <canvas id="soldChart"></canvas>
                <div class="stat-value">{{ $totalProductsSold }}</div>
            </div>
        </div>
        <div class="stat-card">
            {{-- <div class="stat-title">Tổng sản phẩm</div> --}}
            <div class="stat-circle">
                <canvas id="productsChart"></canvas>
                <div class="stat-value">{{ $totalProducts }}</div>
            </div>
        </div>
    </div>

    <div class="charts-container">
        <!-- Biểu đồ Thống kê lượt bán -->
        <div class="chart-card">
            <div class="chart-header">
                <h3>Thống kê lượt bán</h3>
                <div class="time-filter">
                    <button class="time-button active" data-time="week">Tuần</button>
                    <button class="time-button" data-time="month">Tháng</button>
                    <button class="time-button" data-time="year">Năm</button>
                </div>
            </div>
            <canvas id="salesBarChart"></canvas>
        </div>

        <!-- Biểu đồ Thống kê doanh thu -->
        <div class="chart-card">
            <div class="chart-header">
                <h3>Thống kê doanh thu</h3>
                <div class="time-filter">
                    <button class="time-button active" data-time="week">Tuần</button>
                    <button class="time-button" data-time="month">Tháng</button>
                    <button class="time-button" data-time="year">Năm</button>
                </div>
            </div>
            <canvas id="revenueLineChart"></canvas>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function createCircularChart(canvasId, percentage, color) {
            const ctx = document.getElementById(canvasId).getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [percentage, 100 - percentage],
                        backgroundColor: [color, '#f0f0f0'],
                        borderWidth: 0
                    }]
                },
                options: {
                    cutout: '80%',
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }

        createCircularChart('salesChart', 45, '#007bff');
        createCircularChart('ordersChart', 70, '#ff4757');
        createCircularChart('soldChart', 55, '#8e44ad');
        createCircularChart('productsChart', 85, '#f1c40f');

        let revenueLineChart, salesBarChart;

        function initCharts() {
            // Biểu đồ doanh thu
            const revenueCtx = document.getElementById('revenueLineChart').getContext('2d');
            revenueLineChart = new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Doanh thu',
                        borderColor: '#007bff',
                        backgroundColor: 'rgba(0, 123, 255, 0.1)',
                        fill: true,
                        data: []
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            mode: 'index'
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false // Bỏ lưới ngang
                            },
                            beginAtZero: true // Bắt đầu từ 0 trên trục X
                        },
                        y: {
                            grid: {
                                display: false // Bỏ lưới dọc
                            },
                            ticks: {
                                beginAtZero: true // Bắt đầu từ 0 trên trục Y
                            }
                        }
                    }
                }
            });

            // Biểu đồ sản phẩm bán chạy
            const salesCtx = document.getElementById('salesBarChart').getContext('2d');
            salesBarChart = new Chart(salesCtx, {
                type: 'bar',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Sản phẩm bán chạy',
                        backgroundColor: '#28a745',
                        data: []
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }

                    },
                    scales: {
                        x: {
                            grid: {
                                display: false // Bỏ lưới ngang
                            },
                            beginAtZero: true // Bắt đầu từ 0 trên trục X
                        },
                        y: {
                            grid: {
                                display: false // Bỏ lưới dọc
                            },
                            ticks: {
                                beginAtZero: true // Bắt đầu từ 0 trên trục Y
                            }
                        }
                    }
                }
            });
        }

        initCharts();

        // Mặc định chọn "Tuần"
        document.querySelector('.time-button[data-time="week"]').classList.add('active');
        fetchSalesData('week'); // Gửi yêu cầu dữ liệu theo tuần khi trang tải lần đầu

        document.querySelectorAll('.time-button').forEach(button => {
            button.addEventListener('click', function() {
                // Thay đổi trạng thái active của các nút
                document.querySelectorAll('.time-button').forEach(btn => btn.classList.remove(
                    'active'));
                this.classList.add('active');

                const timePeriod = this.getAttribute('data-time'); // Tuần, Tháng, Năm

                // Gửi yêu cầu Ajax để lấy dữ liệu mới
                fetchSalesData(timePeriod);
            });
        });

        function fetchSalesData(timePeriod) {
            const url = `/get-sales-data?timePeriod=${timePeriod}`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    // Cập nhật biểu đồ doanh thu
                    updateRevenueChart(data.salesData);

                    // Cập nhật biểu đồ sản phẩm bán chạy
                    updateProductSalesChart(data.productSales);
                });
        }

        function updateRevenueChart(salesData) {
            const salesLabels = salesData.map(item => item.formatted_date);
            const salesValues = salesData.map(item => item.total_sales);

            // Cập nhật dữ liệu cho biểu đồ doanh thu
            revenueLineChart.data.labels = salesLabels;
            revenueLineChart.data.datasets[0].data = salesValues;
            revenueLineChart.update();
        }

        function updateProductSalesChart(productSales) {
            const productNames = productSales.map(item => item.tensanpham);
            const productSalesValues = productSales.map(item => item.total_sales);

            // Mảng màu pastel
            const pastelColors = [
                '#f8c8d3', '#b4d8d8', '#e7d9b6', '#e4c1f9', '#f9e2d1',
                '#b8c6e2', '#f5b0cb', '#c4d9a3', '#f5e2a9', '#e1f0d7'
            ];
            // Cập nhật dữ liệu cho biểu đồ sản phẩm bán chạy
            salesBarChart.data.labels = productNames;
            salesBarChart.data.datasets[0].data = productSalesValues;
            salesBarChart.data.datasets[0].backgroundColor = pastelColors; // Áp dụng màu pastel cho cột
            // Chú thích tương ứng với màu và sản phẩm
            salesBarChart.data.datasets[0].label =
                'Sản phẩm bán chạy'; // Tên cho dataset (chú thích chung cho tất cả các cột)

            // Cập nhật chú thích hiển thị màu sắc tương ứng
            salesBarChart.options.plugins.legend = {
                display: true, // Hiển thị legend
                position: 'bottom', // Đặt chú thích dưới biểu đồ

                labels: {
                    generateLabels: function(chart) {
                        return chart.data.labels.map((label, index) => {
                            return {
                                text: label, // Tên sản phẩm
                                fillStyle: pastelColors[index], // Màu sắc tương ứng
                                strokeStyle: pastelColors[index], // Màu viền
                                lineWidth: 1,
                                hidden: false,
                            };
                        });
                    }
                }
            };
            salesBarChart.update();
        }
    </script>
@endsection
