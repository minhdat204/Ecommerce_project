<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Order, OrderDetail, CartItem, Cart};
use Illuminate\Support\Facades\{Auth};

class CheckoutController
{
    public function index()
    {
        $cart = $this->getOrCreateCart();
        $totalShip = 0;
        $cartItems = CartItem::with('product')
            ->where('id_giohang', $cart->id_giohang)
            ->get();

        return view('users.pages.checkout', compact('cartItems', 'totalShip'));
    }
    public function checkoutCOD(Request $request)
    {
        $userId = Auth::id();

        // Tính  tiền
        $cartItems = $request->input('cartItems', []);
        $maDonHang = $this->generateOrderCode();
        $totalPayment = $request->input('totalPayment');
        $totalPrice = $request->input('totalPrice');
        $totalShip = $request->input('totalShip');
        $totalDiscount = 0;
        // Lưu thông tin đơn hàng vào database
        $order = Order::create([
            'id_nguoidung' => $userId,
            'ma_don_hang' => $maDonHang,
            'tong_tien_hang' => $totalPrice,
            'tong_giam_gia' => $totalDiscount,
            'phi_van_chuyen' => $totalShip,
            'tong_thanh_toan' => $totalPayment,
            'trangthai_thanhtoan' => 'pending',
            'dia_chi_giao' => $request->input('address'),
            'ten_nguoi_nhan' => $request->input('name'),
            'sdt_nhan' => $request->input('phone'),
            'ghi_chu'   => 'a',
            'trangthai' => 'pending',
        ]);

        // Tạo chi tiết đơn hàng
        foreach ($cartItems as $item) {
            OrderDetail::create([
                'id_donhang' => $order->id_donhang,
                'id_sanpham' => $item['product_id'],
                'soluong' => $item['quantity'],
                'gia' => $item['price'],
                'thanh_tien' => $item['price'] * $item['quantity'],
            ]);
        }

        // Chuyển hướng đến trang thanh toán thành công
        return redirect()->route('checkout.index')
            ->with('success', 'Đơn hàng của bạn đã được tạo thành công.');
    }

    private function getOrCreateCart()
    {
        return Cart::firstOrCreate([
            'id_nguoidung' => Auth::id()
        ]);
    }
    private function generateOrderCode()
    {
        $timestamp = time();
        $random = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4);
        return 'ORD' . $timestamp . $random;
    }
}
