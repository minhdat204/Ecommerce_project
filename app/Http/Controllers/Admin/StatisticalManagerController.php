<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use Carbon\Carbon;
use App\Models\Product; 
use Illuminate\Support\Facades\DB;

class StatisticalManagerController 
{
    /**
     * Hiển thị thống kê
     */
    public function handleStatistics(Request $request)
    {
        // Lấy khoảng thời gian từ tham số "period" trong request, mặc định là 'day'
        $period = $request->input('period', 'day');
    
        // Lấy dữ liệu doanh thu và sản phẩm đã bán dựa trên khoảng thời gian
        $salesData = $this->getSalesData($period);
        $productSalesData = $this->getProductSalesData($period);
    
        // Kiểm tra xem yêu cầu có phải Ajax không
        if ($request->ajax()) {
            return response()->json([
                'salesData' => $salesData,
                'productSalesData' => $productSalesData,
            ]);
        }
    
        // Nếu không phải yêu cầu Ajax, trả về view thông thường
        return view('admin.pages.statistics.index', [
            'salesData' => $salesData,
            'productSalesData' => $productSalesData,
            'period' => $period
        ]);
    }
    
    /**
     * Lấy dữ liệu doanh thu theo thời gian.
     */
    public function getSalesData($period)
    {
        // Kiểm tra sự hợp lệ của period
        if (!in_array($period, ['week', 'month', 'day'])) {
            abort(400, 'Invalid period');
        }
    
        // Truy vấn doanh thu theo ngày, tuần, tháng
        $query = Order::selectRaw('DATE(created_at) as label, SUM(tong_thanh_toan) as total_sales')
                      ->groupBy('label')
                      ->orderBy('label', 'ASC'); // Đảm bảo dữ liệu được sắp xếp theo ngày
    
        // Lọc dữ liệu theo khoảng thời gian
        $this->filterByPeriod($query, 'created_at', $period);
    
        // Thực hiện truy vấn và lấy dữ liệu
        $salesData = $query->get();
    
        // Kiểm tra và xử lý NULL giá trị
        $salesDataArray = $salesData->map(function ($item) {
            $item->total_sales = $item->total_sales ?? 0; // Nếu tổng tiền thanh toán NULL thì gán bằng 0
            return $item;
        })->toArray(); 
    
        return [
            'labels' => array_column($salesDataArray, 'label'), // Dùng array_column để lấy 'label'
            'data' => array_column($salesDataArray, 'total_sales'), // Dùng array_column để lấy 'total_sales'
        ];
    }
    
    /**
     * Lọc dữ liệu theo thời gian (ngày, tuần, tháng).
     */
    private function filterByPeriod($query, $dateColumn, $period)
    {
        if ($period === 'week') {
            $query->whereRaw('YEARWEEK(' . $dateColumn . ', 1) = YEARWEEK(CURDATE(), 1)');
        } elseif ($period === 'month') {
            $query->whereMonth($dateColumn, date('m'))
                  ->whereYear($dateColumn, date('Y'));
        } elseif ($period === 'day') {
            $query->whereDate($dateColumn, Carbon::today());
        }
    }

    /**
     * Lấy dữ liệu sản phẩm đã bán theo thời gian.
     */
    public function getProductSalesData($period)
    {
        // Truy vấn sản phẩm đã bán theo ngày, tuần, tháng
        $query = DB::table('chi_tiet_don_hang')
                   ->join('san_pham', 'san_pham.id_sanpham', '=', 'chi_tiet_don_hang.id_sanpham')
                   ->join('don_hang', 'don_hang.id_donhang', '=', 'chi_tiet_don_hang.id_donhang')
                   ->select('san_pham.tensanpham', DB::raw('SUM(chi_tiet_don_hang.soluong) as total_sales'))
                   ->groupBy('san_pham.tensanpham');

        $this->filterByPeriod($query, 'don_hang.created_at', $period);

        $productSales = $query->get();

        // Kiểm tra và xử lý NULL giá trị
        $productSales = $productSales->map(function ($item) {
            $item->total_sales = $item->total_sales ?? 0; // Nếu tổng số lượng sản phẩm NULL thì gán bằng 0
            return $item;
        });

        return [
            'labels' => $productSales->pluck('tensanpham')->toArray(),
            'data' => $productSales->pluck('total_sales')->toArray(),
        ];
    }

    /**
     * Lấy sản phẩm bán chạy nhất
     */
    public function getTopSellingProducts()
    {
        // Lấy sản phẩm bán chạy nhất từ order details
        $topProducts = OrderDetail::select('id_sanpham', \DB::raw('SUM(soluong) as total_sold'))
            ->groupBy('id_sanpham')
            ->orderByDesc('total_sold')
            ->limit(4)
            ->get();
    
        $products = [];
    
        foreach ($topProducts as $orderDetail) {
            // Lấy thông tin sản phẩm bao gồm tên và ảnh
            $product = Product::with('productImages')->find($orderDetail->id_sanpham);
    
            if (!$product) {
                continue;  // Nếu không tìm thấy sản phẩm, bỏ qua
            }

            // Tính phần trăm đã bán
            $percentage = $this->calculatePercentage($orderDetail->total_sold);
    
            // Lấy ảnh sản phẩm (lấy ảnh đầu tiên nếu có)
            $image = $product->productImages->first() ? $product->productImages->first()->duongdan : 'default_image.jpg';
    
            // Thêm sản phẩm vào mảng kết quả
            $products[] = [
                'name' => $product->tensanpham,  // Lấy tên sản phẩm
                'image' => $image,               // Lấy ảnh sản phẩm
                'percentage' => $percentage      // Phần trăm đã bán
            ];
        }
    
        return response()->json($products);
    }

    /**
     * Tính phần trăm đã bán của sản phẩm
     */
    private function calculatePercentage($totalSold)
    {
        // Giả sử số lượng sản phẩm bán ra tối đa là 100 (có thể thay đổi tùy vào yêu cầu của bạn)
        $maxSales = 100;
        return $maxSales > 0 ? ($totalSold / $maxSales) * 100 : 0;
    }
}
