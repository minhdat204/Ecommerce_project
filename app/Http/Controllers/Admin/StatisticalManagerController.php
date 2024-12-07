<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StatisticalManagerController 
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.pages.statistics.index');
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
                          ->map(function($item) {
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
                          ->map(function($item) {
                              $item->formatted_date = "{$item->day}/{$item->month}/{$item->year}"; // Định dạng ngày/tháng/năm
                              $item->formatted_sales = number_format($item->total_sales) . ' VND'; // Định dạng doanh thu
                              return $item;
                          });
    }

    return view('admin.pages.statistics.index', compact('salesData'));
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
