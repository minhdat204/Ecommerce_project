<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.guest');
    }
    private function getOrCreateCart()
    {
        $cart = Cart::where('id_nguoidung', Auth::id())->first();
        if (!$cart) {
            $cart = Cart::create(['id_nguoidung' => Auth::id()]);
        }
        return $cart;
    }
    private function calculateTotal($cartItems)
    {
        return $cartItems->sum(function ($item) {
            $price = ($item->product->gia_khuyen_mai !== null && $item->product->gia_khuyen_mai >= 0)
                ? $item->product->gia_khuyen_mai
                : $item->product->gia;
            return $price * $item->soluong;
        });
    }
    private function calculateSubTotal($cartItems)
    {
        return $cartItems->sum(function ($item) {
            $price = $item->product->gia;
            return $price * $item->soluong;
        });
    }

    public function index(Request $request)
    {
        $cart = $this->getOrCreateCart();
        $cartItemsQuery = CartItem::with(['product.images'])
            ->where('id_giohang', $cart->id_giohang)
            ->orderBy('created_at', 'desc');

        // Lấy toàn bộ mục giỏ hàng trước để tính toán
        $allCartItems = $cartItemsQuery->get();
        $overStockItems = $allCartItems->filter(function($item) {
            return $item->soluong > $item->product->soluong;
        });

        // Phân trang dữ liệu sau khi đã tải
        $cartItems = $cartItemsQuery->paginate(3);

        // Tính toán tổng và giảm giá
        $subTotal = $this->calculateSubTotal($allCartItems);
        $total = $this->calculateTotal($allCartItems);
        $discount = $subTotal > 0 ? ($subTotal - $total) / $subTotal * 100 : 0;


        return view('users.pages.shoping-cart', compact('cartItems', 'subTotal','total', 'discount', 'overStockItems'));
    }
    public function addToCart(Request $request)
    {
        $request->validate([
            'id_sanpham' => 'required|exists:san_pham,id_sanpham',
            'soluong' => 'required|integer|min:1'
        ]);

        //xử lý số lượng sản phẩm
        $product = Product::findOrFail($request->id_sanpham);
        if ($request->soluong > $product->soluong) {
            return response()->json([
                'success' => false,
                'message' => 'Số lượng sản phẩm không đủ.'
            ]);
        }

        //thêm sản phẩm vào giỏ hàng
        /*vấn đề :
        - xử lý việc thêm sản phẩm đã có trong giỏ hàng
        - xử lý việc số luợng sản phẩm trong giỏ hàng vượt quá số lượng sản phẩm có sẵn
        (vd: sản phẩm có số lượng 10, lần 1 người dùng thêm 9 sản phẩm vào giỏ hàng, lần 2 người dùng thêm 2 sản phẩm nữa vào giỏ hàng)
        */
        $cart = $this->getOrCreateCart();
        $productIsExist = CartItem::where('id_giohang', $cart->id_giohang)
            ->where('id_sanpham', $request->id_sanpham)
            ->first();
        if ($productIsExist) {
            //nếu sant phẩm có số lượng trong giỏ hàng + số lượng sản phẩm thêm vào giỏ hàng > số lượng sản phẩm có sẵn
            if($productIsExist->soluong + $request->soluong > $product->soluong){
                $availableQuantity = $product->soluong - $productIsExist->soluong;
                return response()->json([
                    'success' => false,
                    'message' =>  "Số lượng còn lại trong kho là {$availableQuantity} sản phẩm."
                ]);
            }
            //cập nhật số lượng sản phẩm trong giỏ hàng
            $productIsExist->update([
                'soluong' => $productIsExist->soluong + $request->soluong
            ]);
        } else {
            CartItem::create([
                'id_giohang' => $cart->id_giohang,
                'id_sanpham' => $request->id_sanpham,
                'soluong' => $request->soluong
            ]);
        }
        //tính tổng tiền không giảm giá
        $cartTotal = $this->calculateTotal($cart->fresh()->cartItems);
        // số lượng sản phẩm trong giỏ hàng
        $cartCount = $cart->cartItems->count();
        return response()->json([
            'success' => true,
            'redirect_url' => route('cart.index'),
            'cartTotal' => number_format($cartTotal, 0, ',', '.') . 'đ',
            'cartCount' => $cartCount
        ]);
    }
    public function removeItem(Request $request, $id)
    {
        $cart = $this->getOrCreateCart();
        CartItem::destroy($id);

        //tính tổng tiền không giảm giá
        $subTotal = $this->calculateSubTotal($cart->fresh()->cartItems);

        //tính tổng tiền
        $total = $this->calculateTotal($cart->fresh()->cartItems);

        //tính phần trăm giảm giá
        $discount = $subTotal > 0 ? ($subTotal - $total) / $subTotal * 100 : 0;

        // số lượng sản phẩm trong giỏ hàng
        $cartCount = $cart->cartItems->count();

        // Lấy trang hiện tại từ request
        $page = $request->currentPage ?? 1;

        // Lấy danh sách cart items sau khi xóa
        $cartItems = CartItem::with(['product.images'])
            ->where('id_giohang', $cart->id_giohang)
            ->orderBy('created_at', 'desc')
            ->paginate(3, ['*'], 'page', $page);

        // Render view partial
        $cartView = view('users.partials.shoping-cart.table-cart', compact('cartItems', 'subTotal', 'total', 'discount'))->render();

        return response()->json([
            'success' => true,
            'cartTotal' => number_format($total, 0, ',', '.') . 'đ',
            'subTotal' => number_format($subTotal, 0, ',', '.') . 'đ',
            'discount' => floor($discount),
            'cartCount' => $cartCount,
            'cartView' => $cartView
        ]);
    }
    public function clearCart()
    {
        $cart = $this->getOrCreateCart();
        $cartItems = CartItem::where('id_giohang', $cart->id_giohang);
        if ($cartItems->count() == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Giỏ hàng của bạn đã trống.'
            ]);
        }
        $cartItems->delete();
        return response()->json([
            'success' => true,
            'message' => 'Xóa toàn bộ sản phẩm khỏi giỏ hàng thành công.'
        ]);
    }
    public function updateQuantity(Request $request, $id_sp_giohang)
    {
        $request->validate([
            'soluong' => 'required|integer|min:1'
        ]);
        $cartItem = CartItem::findOrFail($id_sp_giohang);
        $product = Product::findOrFail($cartItem->id_sanpham);
        if ($request->soluong > $product->soluong) {
            return response()->json([
                'success' => false,
                'message' => 'Số lượng vượt quá tồn kho'
            ], 400);
        }
        $cartItem->update([
            'soluong' => $request->soluong
        ]);
        $cart = $cartItem->cart;
        $cartTotal = $this->calculateTotal($cart->cartItems);
        $subTotal = $this->calculateSubTotal($cart->cartItems);
        $discount = $subTotal > 0 ? ($subTotal - $cartTotal) / $subTotal * 100 : 0;
        $itemTotal = ($cartItem->product->gia_khuyen_mai ?? $cartItem->product->gia) * $cartItem->soluong;

        return response()->json([
            'success' => true,
            'cartTotal' => number_format($cartTotal, 0, ',', '.') . 'đ',
            'itemTotal' => number_format($itemTotal, 0, ',', '.') . 'đ',
            'subTotal' => number_format($subTotal, 0, ',', '.') . 'đ',
            'discount' => floor($discount)
        ]);
    }
}
