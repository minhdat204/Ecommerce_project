<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;


class StatisticalManagerController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

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

    public function sales()
    {
        $monthlySales = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as sales')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month')
            ->toArray();
    
        $allMonths = [];
        for ($month = 1; $month <= 12; $month++) {
            $allMonths[] = [
                'month' => $month,
                'sales' => isset($monthlySales[$month]) ? $monthlySales[$month]['sales'] : 0,
            ];
        }
    
        return view('admin.pages.statistics.index', compact('allMonths'));
    }
    public function productSales(Request $request)
    {
        $year = $request->input('year');
        $month = $request->input('month');
        $day = $request->input('day');
        
        $query = DB::table('chi_tiet_don_hang as ctdh')
            ->join('san_pham as p', 'ctdh.id_sanpham', '=', 'p.id_sanpham')
            ->join('don_hang as dh', 'ctdh.id_donhang', '=', 'dh.id_donhang')
            ->select('p.id_sanpham', 'p.tensanpham', DB::raw('SUM(ctdh.soluong) as tong_so_luong_mua'))
            ->where('dh.trangthai', 'Completed');
    
        // Lọc theo năm nếu có
        if (!empty($year)) {
            $query->whereYear('dh.created_at', $year);
        }
    
        // Lọc theo tháng nếu có
        if (!empty($month)) {
            $query->whereMonth('dh.created_at', $month);
        }
    
        // Lọc theo ngày nếu có
        if (!empty($day)) {
            $query->whereDay('dh.created_at', $day);
        }
    
        // Thực hiện truy vấn và sắp xếp kết quả
        $productSales = $query
            ->groupBy('p.id_sanpham', 'p.tensanpham')
            ->orderBy('tong_so_luong_mua', 'desc')
            ->get();
    
        // Trả kết quả về view
        return view('admin.pages.statistics.index', ['productSales' => $productSales]);
    }
    
    



    

}
