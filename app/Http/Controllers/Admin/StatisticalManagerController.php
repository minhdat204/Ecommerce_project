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
    // Khoa
    public function index(Request $request)
    {
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


    // Minh , Nam
    public function sales(Request $request)
{
    $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
    $endDate = $request->input('end_date', now()->toDateString());

    $salesData = Order::whereBetween('created_at', [$startDate, $endDate])
        ->selectRaw('DATE(created_at) as formatted_date, SUM(tong_thanh_toan) as total_sales')
        ->groupBy('formatted_date')
        ->orderBy('formatted_date', 'ASC')
        ->get()
        ->map(function ($item) {
            $item->formatted_sales = number_format($item->total_sales) . ' VND'; 
            return $item;
        });

    return view('admin.pages.statistics.index', compact('salesData', 'startDate', 'endDate'));
}


    public function productSales(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = DB::table('chi_tiet_don_hang')
            ->join('san_pham', 'san_pham.id_sanpham', '=', 'chi_tiet_don_hang.id_sanpham')
            ->join('don_hang', 'don_hang.id_donhang', '=', 'chi_tiet_don_hang.id_donhang') 
            ->select('san_pham.tensanpham', DB::raw('SUM(chi_tiet_don_hang.soluong) as total_sales'))
            ->groupBy('san_pham.tensanpham');

        if ($startDate) {
            $query->whereDate('don_hang.created_at', '>=', $startDate); 
        }
        if ($endDate) {
            $query->whereDate('don_hang.created_at', '<=', $endDate); 
        }

        $productSales = $query->get();

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
