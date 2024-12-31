@extends('Admin.Layout.Layout')

@section('content')
<div class="wrapper">
    <!-- Phần sản phẩm bán chạy -->
    <div style="display: flex; justify-content: space-around; gap: 20px;">
        <div id="top-selling-products" class="d-flex">
            <!-- Các sản phẩm bán chạy nhất sẽ được chèn vào đây -->
        </div>
    </div>
</div>

<div class="dashboard">
    <!-- Biểu đồ sản phẩm bán -->
    <div class="chart-card">
        <h3>Sản phẩm bán</h3>
        <div class="tabs">
            <button class="active" id="btnProductDay">Ngày</button>
            <button id="btnProductWeek">Tuần</button>
            <button id="btnProductMonth">Tháng</button>
        </div>
        <div class="chart">
            <canvas id="productChart" width="400" height="200"></canvas>
        </div>
    </div>

    <!-- Biểu đồ doanh thu -->
    <div class="chart-card">
        <h3>Doanh thu</h3>
        <div class="tabs">
            <button class="active" id="btnDay">Ngày</button>
            <button id="btnWeek">Tuần</button>
            <button id="btnMonth">Tháng</button>
        </div>
        <div class="chart">
            <canvas id="revenueChart" width="400" height="200"></canvas>
        </div>
    </div>
</div>

@endsection

@section('js_custom')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Khởi tạo biểu đồ doanh thu và sản phẩm bán
let revenueChart, productChart;

function initCharts() {
    // Biểu đồ doanh thu
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: @json($salesData['labels']), // Nhãn trục X (ngày, tuần, tháng)
            datasets: [{
                label: 'Doanh thu', 
                data: @json($salesData['data']),
                borderColor: 'rgba(0, 123, 255, 1)',
                backgroundColor: 'rgba(0, 123, 255, 0.2)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false // Ẩn phần legend (label của dataset)
                }
            },
            scales: {
                y: {
                    display: false // Ẩn trục Y
                },
                x: {
                    display: true // Hiển thị trục X
                }
            }
        }
    });

    // Biểu đồ sản phẩm bán
    const productCtx = document.getElementById('productChart').getContext('2d');
    const productData = @json($productSalesData['data']); // Lấy dữ liệu sản phẩm bán từ server
    const productMin = Math.min(...productData) - 1; 
    const productMax = Math.max(...productData) + 2;
    
    productChart = new Chart(productCtx, {
        type: 'bar',
        data: {
            labels: @json($productSalesData['labels']), // Nhãn trục X (tên sản phẩm)
            datasets: [{
                label: 'Sản phẩm bán', 
                data: @json($productSalesData['data']),
                borderColor: 'rgba(255, 99, 132, 1)', 
                backgroundColor: 'rgba(255, 99, 132, 0.2)', 
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false // Ẩn phần legend
                }
            },
            scales: {
                y: {
                    display: false,
                    min: productMin,
                    max: productMax,
                },
                x: {
                    display: true
                }
            }
        }
    });
}

// Cập nhật dữ liệu cho biểu đồ doanh thu
function updateRevenueChart(period) {
    document.querySelectorAll('.tabs button').forEach(button => {
        button.classList.remove('active');
    });
    document.getElementById(`btn${period.charAt(0).toUpperCase() + period.slice(1)}`).classList.add('active');

    fetch(`/admin/statistics/revenue-chart?period=${period}`)
        .then(response => response.json())
        .then(data => {
            revenueChart.data.labels = data.labels;
            revenueChart.data.datasets[0].data = data.data;
            revenueChart.update();
        });
}

// Cập nhật dữ liệu cho biểu đồ sản phẩm bán
function updateProductChart(period) {
    document.querySelectorAll('.tabs button').forEach(button => {
        button.classList.remove('active');
    });
    document.getElementById(`btnProduct${period.charAt(0).toUpperCase() + period.slice(1)}`).classList.add('active');

    fetch(`/admin/statistics/product-chart?period=${period}`)
        .then(response => response.json())
        .then(data => {
            productChart.data.labels = data.labels;
            productChart.data.datasets[0].data = data.data;
            productChart.update();
        });
}

document.addEventListener('DOMContentLoaded', () => {
    initCharts(); // Khởi tạo các biểu đồ khi trang được tải

    // Thêm sự kiện cho các tab
    document.getElementById('btnDay').addEventListener('click', () => updateRevenueChart('day'));
    document.getElementById('btnWeek').addEventListener('click', () => updateRevenueChart('week'));
    document.getElementById('btnMonth').addEventListener('click', () => updateRevenueChart('month'));

    document.getElementById('btnProductDay').addEventListener('click', () => updateProductChart('day'));
    document.getElementById('btnProductWeek').addEventListener('click', () => updateProductChart('week'));
    document.getElementById('btnProductMonth').addEventListener('click', () => updateProductChart('month'));
});

// Lấy dữ liệu sản phẩm bán chạy nhất
document.addEventListener("DOMContentLoaded", function () {
    fetch('{{ url('admin/statistics/top-selling-products') }}')
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('top-selling-products');
            container.innerHTML = ''; // Xóa nội dung cũ

            data.forEach(product => {
                const cardItem = document.createElement('div');
                cardItem.classList.add('col-md-3', 'card-item');
                cardItem.innerHTML = `
                    <div class="card">
                        <img alt="${product.name}" src="${product.image}" height="30" width="30" />
                        <h5>${product.name}</h5>
                        <div class="progress-ring">
                            <svg>
                                <circle class="background" cx="50" cy="50" r="45"></circle>
                                <circle class="progress-meter" cx="50" cy="50" r="45" stroke="#007bff" stroke-dasharray="282.743" stroke-dashoffset="${(282.743 - (282.743 * product.percentage / 100)).toFixed(3)}"></circle>
                            </svg>
                            <div class="percentage">${product.percentage.toFixed(2)}%</div>
                        </div>
                    </div>
                `;
                container.appendChild(cardItem);
            });
        })
        .catch(error => {
            console.error('Error fetching top selling products:', error);
        });
});
</script>
@endsection
