<?php

namespace App\Http\Controllers\Client;

use App\Models\Order;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class OrderController
{
    public function orderDetail($orderId)
    {
        $order = Order::with(['orderDetails.product'])
            ->where('id_donhang', $orderId)
            ->firstOrFail();

        return view('users.pages.order.detail', compact('order'));
    }
    public function cancel(Request $request, $orderId)
    {
        try {
            $order = Order::with('orderDetails.product')->findOrFail($orderId);

            // Kiểm tra trạng thái trước khi hủy
            if (!in_array($order->trangthai, ['pending', 'confirmed', 'processing'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể hủy đơn hàng vì đã cập nhật ở trạng thái: ' . $order->trangthai,
                ]);
            }

            // Hoàn số lượng sản phẩm vào kho
            foreach ($order->orderDetails as $detail) {
                $product = $detail->product;
                $product->soluong += $detail->soluong;
                $product->save();
            }

            $order->trangthai = 'cancelled';
            $order->save();

            return response()->json([
                'success' => true,
                'message' => 'Đã hủy đơn hàng và hoàn số lượng sản phẩm vào kho thành công'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
}
