<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderManagerController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::all();
        return view('admin.pages.order.index', compact('orders'));
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
        $order = Order::findOrFail($id);
        $order->trangthai = $request->trangthai;
        $order->save();

        return redirect()->back()->with('success', 'Trạng thái đơn hàng đã được cập nhật!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        // dd($order);
        // Kiểm tra trạng thái đơn hàng
        if ($order->trangthai === 'cancelled') {
            // Cập nhật trạng thái đơn hàng thành 'inactive'
            $order->trangthai = 'inactive';
            $order->save();

            return redirect()->back()->with('success', 'Trạng thái đơn hàng đã được cập nhật!');
        }
    }
}
