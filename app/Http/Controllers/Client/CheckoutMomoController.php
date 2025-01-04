<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\MomoService;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CheckoutMomoController extends Controller
{
    protected $momoService;

    public function __construct(MomoService $momoService)
    {
        $this->momoService = $momoService;
    }

    public function payWithMomo(Request $request)
    {
        try {
            $userId = Auth::id();
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
                'ghi_chu' => 'a',
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

            $orderInfo = "Thanh toán đơn hàng " . $maDonHang;
            $result = $this->momoService->createPayment($maDonHang, $totalPayment, $orderInfo);

            if ($result['resultCode'] == 0) {
                return redirect($result['payUrl']);
            }

            return redirect()->back()->with('error', $result['message']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function momoReturn(Request $request)
    {
        if ($request->resultCode == 0) {
            Order::where('ma_don_hang', $request->orderId)
                ->update([
                    'trangthai_thanhtoan' => 'paid',
                ]);

            return redirect()->route('checkout.index');
        }

        return redirect()->route('checkout.index');
    }

    public function momoIPN(Request $request)
    {
        // Verify signature
        $rawHash = "accessKey=" . config('momo.access_key') .
            "&amount=" . $request->amount .
            "&extraData=" . $request->extraData .
            "&orderId=" . $request->orderId .
            "&orderInfo=" . $request->orderInfo .
            "&orderType=" . $request->orderType .
            "&partnerCode=" . $request->partnerCode .
            "&payType=" . $request->payType .
            "&requestId=" . $request->requestId .
            "&responseTime=" . $request->responseTime .
            "&resultCode=" . $request->resultCode .
            "&transId=" . $request->transId;

        $signature = hash_hmac('sha256', $rawHash, config('momo.secret_key'));

        if ($signature != $request->signature) {
            return response()->json([
                'message' => 'Invalid signature'
            ], 400);
        }

        if ($request->resultCode == 0) {
            Order::where('ma_don_hang', $request->orderId)
                ->update([
                    'trangthai_thanhtoan' => 'paid',
                ]);
        }

        return response()->json([
            'message' => 'OK'
        ]);
    }



    private function generateOrderCode()
    {
        $timestamp = time();
        $random = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4);
        return 'ORD' . $timestamp . $random;
    }
}
