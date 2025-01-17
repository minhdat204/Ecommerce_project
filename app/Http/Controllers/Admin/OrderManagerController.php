<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderManagerController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::query();

        // Filter 
        if ($request->status && $request->status !== 'all') {
            $query->where('trangthai', $request->status);
        }

        // Search functionality
        if ($request->search) {
            $query->where('ma_don_hang', 'like', '%' . $request->search . '%')
                ->orWhere('ten_nguoi_nhan', 'like', '%' . $request->search . '%');
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.pages.order.index', compact('orders'));
    }
    public function update(Request $request, Order $order)
    {
        $statusOrder = [
            'pending' => 1,
            'processing' => 2,
            'shipping' => 3,
            'completed' => 4,
            'cancelled' => 5,
            'inactive' => 6

        ];

        $newStatus = $request->trangthai;

        // Kiểm tra trạng thái không thể thay đổi
        if ($order->trangthai == 'completed' || $order->trangthai == 'cancelled') {
            return redirect()->back()->with('error', 'Không thể thay đổi trạng thái của đơn hàng đã hoàn thành hoặc đã hủy!');
        }

        // Kiểm tra trạng thái không thể lùi lại
        if ($statusOrder[$newStatus] < $statusOrder[$order->trangthai]) {
            return redirect()->back()->with('error', 'Không thể chuyển về trạng thái trước đó!');
        }

        // Cập nhật trạng thái đơn hàng
        $order->trangthai = $newStatus;
        $order->save();

        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công!');
    }

    public function destroy(Order $order)
    {
        try {
            // Kiểm tra trạng thái đơn hàng
            if ($order->trangthai === 'cancelled') {
                // Cập nhật trạng thái đơn hàng thành 'inactive'
                $order->trangthai = 'inactive';
                $order->save();

                return redirect()->back()->with('success', 'Trạng thái đơn hàng đã được cập nhật!');
            } else {
                return redirect()->back()->with('error', 'Chỉ có thể xóa đơn hàng đã bị hủy!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
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

    /**
     * Remove the specified resource from storage.
     */
}
