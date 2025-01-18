<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StatisticalManagerController
{
    // index2
    public function index(Request $request)
    {
        // Tổng quan thống kê
        $totalSales = Order::where('trangthai', 'completed')->sum('tong_thanh_toan');
        $totalOrders = Order::count();
        $totalProductsSold = OrderDetail::sum('soluong');
        $totalProducts = Product::count();


        // Xử lý dữ liệu doanh thu
        return view('admin.pages.statistics.index2', compact(
            'totalSales',
            'totalOrders',
            'totalProducts',
            'totalProductsSold',
        ));
    }
    public function getSalesData(Request $request)
    {
        // Lấy thông tin khoảng thời gian từ query string
        $timePeriod = $request->input('timePeriod');

        // Dữ liệu mặc định cho tuần, tháng, năm
        if ($timePeriod === 'week') {
            $startDate = now()->subDays(7);  // 7 ngày qua
            $endDate = now();
        } elseif ($timePeriod === 'month') {
            $startDate = now()->startOfMonth();  // Bắt đầu tháng này
            $endDate = now();
        } elseif ($timePeriod === 'year') {
            $startDate = now()->startOfYear();  // Bắt đầu năm nay
            $endDate = now();
        } else {
            return response()->json(['error' => 'Invalid time period'], 400);
        }

        // Truy vấn để lấy dữ liệu doanh thu theo thời gian (week/month/year)
        $salesData = Order::whereBetween('created_at', [$startDate, $endDate])
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, DAY(created_at) as day, SUM(tong_thanh_toan) as total_sales')
            ->groupBy('year', 'month', 'day')
            ->orderBy('created_at', 'ASC')
            ->get()
            ->map(function ($item) {
                $item->formatted_date = "{$item->day}/{$item->month}/{$item->year}";
                $item->formatted_sales = number_format($item->total_sales) . ' VND';
                return $item;
            });

        // Truy vấn để lấy 10 sản phẩm bán chạy nhất theo thời gian (week/month/year)
        $productSales = DB::table('chi_tiet_don_hang')
            ->join('san_pham', 'san_pham.id_sanpham', '=', 'chi_tiet_don_hang.id_sanpham')
            ->join('don_hang', 'don_hang.id_donhang', '=', 'chi_tiet_don_hang.id_donhang')
            ->select('san_pham.tensanpham', DB::raw('SUM(chi_tiet_don_hang.soluong) as total_sales'))
            ->whereBetween('don_hang.created_at', [$startDate, $endDate])
            ->groupBy('san_pham.tensanpham')
            ->orderByDesc('total_sales')  // Sắp xếp theo số lượng bán ra giảm dần
            ->limit(10)  // Lấy 10 sản phẩm bán chạy nhất
            ->get()
            ->map(function ($item) {
                $item->formatted_sales = number_format($item->total_sales);
                return $item;
            });

        // Trả dữ liệu về dưới dạng JSON
        return response()->json([
            'salesData' => $salesData,
            'productSales' => $productSales,
        ]);
    }

    public function sales(Request $request)
    {
        $startDate = $request->input('start_date'); // Ngày bắt đầu
        $endDate = $request->input('end_date'); // Ngày kết thúc

        if ($startDate && $endDate) {
            $salesData = Order::whereBetween('created_at', [$startDate, $endDate])
                ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, DAY(created_at) as day, SUM(tong_thanh_toan) as total_sales')
                ->groupBy('year', 'month', 'day')
                ->orderBy('created_at', 'ASC')
                ->get()
                ->map(function ($item) {
                    $item->formatted_date = "{$item->day}/{$item->month}/{$item->year}"; // Định dạng ngày/tháng/năm
                    $item->formatted_sales = number_format($item->total_sales) . ' VND'; // Định dạng doanh thu
                    return $item;
                });
        } else {
            // Mặc định là tháng hiện tại
            $salesData = Order::whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, DAY(created_at) as day, SUM(tong_thanh_toan) as total_sales')
                ->groupBy('year', 'month', 'day')
                ->orderBy('created_at', 'ASC')
                ->get()
                ->map(function ($item) {
                    $item->formatted_date = "{$item->day}/{$item->month}/{$item->year}"; // Định dạng ngày/tháng/năm
                    $item->formatted_sales = number_format($item->total_sales) . ' VND'; // Định dạng doanh thu
                    return $item;
                });
        }

        return view('admin.pages.statistics.index', compact('salesData'));
    }
    public function productSales(Request $request)
    {
        // Lấy thông tin ngày bắt đầu và ngày kết thúc từ input
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Bắt đầu truy vấn để lấy số lượng sản phẩm đã bán, sử dụng bảng don_hang
        $query = DB::table('chi_tiet_don_hang')
            ->join('san_pham', 'san_pham.id_sanpham', '=', 'chi_tiet_don_hang.id_sanpham')
            ->join('don_hang', 'don_hang.id_donhang', '=', 'chi_tiet_don_hang.id_donhang') // Kết nối với bảng don_hang
            ->select('san_pham.tensanpham', DB::raw('SUM(chi_tiet_don_hang.soluong) as total_sales'))
            ->groupBy('san_pham.tensanpham');

        // Nếu có lọc theo ngày bắt đầu và ngày kết thúc, thêm điều kiện vào truy vấn
        if ($startDate) {
            $query->whereDate('don_hang.created_at', '>=', $startDate); // Lọc theo ngày từ bảng don_hang
        }
        if ($endDate) {
            $query->whereDate('don_hang.created_at', '<=', $endDate); // Lọc theo ngày từ bảng don_hang
        }

        // Thực thi truy vấn và lấy kết quả
        $productSales = $query->get();

        // Trả kết quả về view
        return view('admin.pages.statistics.sales', compact('productSales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
