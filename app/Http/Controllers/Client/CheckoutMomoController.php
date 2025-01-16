<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\MomoService;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\DB;

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
                    "Số lượng sản phẩm không đủ:\n" . implode("\n", $quantityErrors)
                );
            }

            $maDonHang = $this->generateOrderCode();
            $totalPayment = $request->input('totalPayment');
            $totalPrice = $request->input('totalPrice');
            $totalShip = $request->input('totalShip');
            $totalDiscount = 0;

            // Create order
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

            // Create order details
            foreach ($cartItems as $item) {
                OrderDetail::create([
                    'id_donhang' => $order->id_donhang,
                    'id_sanpham' => $item['product_id'],
                    'soluong' => $item['quantity'],
                    'gia' => $item['price'],
                    'thanh_tien' => $item['price'] * $item['quantity'],
                ]);
                Product::where('id_sanpham', $item['product_id'])
                    ->decrement('soluong', $item['quantity']);
            }

            $orderInfo = "Thanh toán đơn hàng " . $maDonHang;
            $result = $this->momoService->createPayment($maDonHang, $totalPayment, $orderInfo);

            if ($result['resultCode'] == 0) {
                return redirect($result['payUrl']);
            }
            // Xóa đơn hàng nếu thanh toán thất bại
            $this->deleteOrder($request->orderId);

            return redirect()->back()->with('error', $result['message']);
        } catch (\Exception $e) {
            // Xóa đơn hàng nếu thanh toán thất bại

            $this->deleteOrder($request->orderId);

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function momoReturn(Request $request)
    {

        if ($request->resultCode == 0 || $request->resultCode == 7002) {
            try {
                Order::where('ma_don_hang', $request->orderId)
                    ->update([
                        'trangthai_thanhtoan' => 'paid',
                    ]);

                // xóa giỏ hàng
                CartItem::join('gio_hang', 'gio_hang.id_giohang', '=', 'san_pham_gio_hang.id_giohang')
                    ->where('gio_hang.id_nguoidung', Auth::id())
                    ->delete();
            } catch (\Exception $e) {
                return redirect()->route('checkout.index')
                    ->with('error', 'Thanh toán thất bại. Vui lòng thử lại sau.');
            }
            return redirect()->route('checkout.index')
                ->with('success', 'Đặt hàng thành công! Cảm ơn bạn đã mua hàng.');
        }
        // Xóa đơn hàng nếu thanh toán thất bại
        $this->deleteOrder($request->orderId);
        return redirect()->route('checkout.index')
            ->with('error', 'Thanh toán thất bại. Vui lòng thử lại sau.');
    }

    public function momoIPN(Request $request)
    {
        // Ghi log chi tiết yêu cầu từ MoMo
        Log::info('MoMo IPN Request', ['request' => $request->all()]);

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

        // Sử dụng dd để kiểm tra các giá trị
        dd([
            'rawHash' => $rawHash,
            'generated_signature' => $signature,
            'received_signature' => $request->signature,
            'request' => $request->all()
        ]);

        if ($signature != $request->signature) {
            return response()->json([
                'message' => 'Invalid signature'
            ]);
        }
    }

    // xóa đơn hàng, chi tiết đơn hàng
    public function deleteOrder($orderId)
    {
        // Sử dụng transaction để đảm bảo tính toàn vẹn dữ liệu
        DB::transaction(function () use ($orderId) {
            // Lấy chi tiết đơn hàng liên quan đến đơn hàng cần xóa
            $orderDetails = OrderDetail::where('id_donhang', $orderId)->get();

            // Duyệt qua từng chi tiết đơn hàng
            foreach ($orderDetails as $detail) {
                // Cộng lại số lượng sản phẩm trong kho
                Product::where('id_sanpham', $detail->id_sanpham)
                    ->increment('soluong', $detail->soluong);
            }

            // Xóa tất cả các chi tiết đơn hàng
            OrderDetail::where('id_donhang', $orderId)->delete();

            // Xóa đơn hàng
            Order::where('id_donhang', $orderId)->delete();
        });
    }
    // public function deleteCartItem($cartItemId)
    // {
    //     try {
    //         DB::transaction(function () use ($cartItemId) {
    //             // Delete the specific cart item using san_pham_gio_hang table
    //             DB::table('san_pham_gio_hang')
    //                 ->where('id_giohang', function ($query) {
    //                     $query->select('id_giohang')
    //                         ->from('gio_hang')
    //                         ->where('id_nguoidung', Auth::id())
    //                         ->first();
    //                 })
    //                 ->where('id_sanpham', $cartItemId)
    //                 ->delete();
    //         });

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng'
    //         ]);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Có lỗi xảy ra khi xóa sản phẩm: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }
    private function generateOrderCode()
    {
        $timestamp = time();
        $random = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 4);
        return 'ORD' . $timestamp . $random;
    }
}
