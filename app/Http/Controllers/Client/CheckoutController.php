<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Order, OrderDetail, CartItem, Cart, WebsiteInfo, Product};
use Illuminate\Support\Facades\{Auth};

class CheckoutController
{
    public function index()
    {
        $cart = $this->getOrCreateCart();
        $totalShip = 0;

        // Lấy tất cả cart items không phân trang để tính tổng
        $allCartItems = CartItem::with('product')
            ->where('id_giohang', $cart->id_giohang)
            ->get();

        // Tính tổng giá từ tất cả items
        $totalPrice = $allCartItems->sum(function ($item) {
            return ($item->product->gia_khuyen_mai ?? $item->product->gia) * $item->soluong;
        });

        // Phân trang cart items để hiển thị
        $cartItems = CartItem::with('product')
            ->where('id_giohang', $cart->id_giohang)
            ->paginate(3);

        return view('users.pages.checkout', compact('cartItems', 'totalShip', 'totalPrice'));
    }
    public function checkoutCOD(Request $request)
    {
        // Validate input fields
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'phone' => [
                'required',
                'regex:/^(0[3|5|7|8|9])+([0-9]{8})$/'
            ],
            'address_detail' => 'required|string|max:255',
            'payment' => 'required|in:cod,momo',
        ], [
            'name.required' => 'Họ và tên không được để trống.',
            'name.max' => 'Họ và tên không được quá 100 ký tự.',
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Định dạng email không hợp lệ.',
            'phone.required' => 'Số điện thoại không được để trống.',
            'phone.regex' => 'Số điện thoại không hợp lệ.',
            'address_detail.required' => 'Địa chỉ chi tiết không được để trống.',
            'address_detail.max' => 'Địa chỉ chi tiết không được quá 255 ký tự.',
            'payment.required' => 'Bạn phải chọn phương thức thanh toán.',
            'payment.in' => 'Phương thức thanh toán không hợp lệ.',
        ]);

        try {
            $websiteInfo = WebsiteInfo::first();
            $phoneNumber = $websiteInfo->phone ?? 'N/A';
            $userId = Auth::id();
            $cartItems = $request->input('cartItems', []);
            $priceErrors = [];
            $quantityErrors = [];


            // Validate cart items
            foreach ($cartItems as $item) {
                $currentProduct = Product::where('id_sanpham', $item['product_id'])->first();

                // Kiểm tra giá
                $currentPrice = $currentProduct->gia_khuyen_mai > 0
                    ? $currentProduct->gia_khuyen_mai
                    : $currentProduct->gia;

                if ($currentPrice != $item['price']) {
                    $priceErrors[] = sprintf(
                        "Sản phẩm '%s' có giá đã thay đổi từ %s₫ thành %s₫",
                        $currentProduct->tensanpham,
                        number_format($item['price']),
                        number_format($currentPrice)
                    );
                }

                // Kiểm tra số lượng
                if ($currentProduct->soluong < $item['quantity']) {
                    $quantityErrors[] = sprintf(
                        "Sản phẩm '%s' chỉ còn %d sản phẩm (bạn đặt %d)",
                        $currentProduct->tensanpham,
                        $currentProduct->soluong,
                        $item['quantity']
                    );
                }
            }
            if (!empty($priceErrors)) {
                return redirect()->back()->with(
                    'error',
                    "Giá sản phẩm đã thay đổi:\n" . implode("\n", $priceErrors)
                );
            }

            if (!empty($quantityErrors)) {
                return redirect()->back()->with(
                    'error',
                    "Số lượng sản phẩm không đủ:\n" . implode("\n", $quantityErrors) . "\nXin vui lòng liên hệ: {$phoneNumber}"
                );
            }


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
            Order::where('ma_don_hang', $request->orderId)
                ->update([
                    'trangthai_thanhtoan' => 'paid',
                ]);

            // Chuyển hướng đến trang thanh toán thành công
            return redirect()->route('checkout.index')
                ->with('success', 'Đơn hàng của bạn đã được tạo thành công.');
        } catch (\Exception $e) {
            return redirect()->route('checkout.index')
                ->with('error', 'Thanh toán thất bại. Vui lòng thử lại sau.');
        }
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
