<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\{Cart, CartItem, Product};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Auth, Log};
use Exception;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cart = $this->getOrCreateCart();
        $cartItems = CartItem::with('product')
            ->where('id_giohang', $cart->id_giohang)
            ->get();

        $total = $this->calculateTotal($cartItems);
        $totalShip = 15;
        return view('users.pages.shoping-cart', compact('cartItems', 'total', 'totalShip'));
    }

    public function addToCart(Request $request)
    {
        try {
            $request->validate([
                'id_sanpham' => 'required|exists:san_pham,id_sanpham',
                'soluong' => 'required|integer|min:1'
            ]);

            $product = Product::findOrFail($request->id_sanpham);
            if ($request->soluong > $product->soluong) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock available'
                ]);
            }

            DB::beginTransaction();
            $cart = $this->getOrCreateCart();

            // Check if item already exists in cart
            $existingItem = CartItem::where('id_giohang', $cart->id_giohang)
                ->where('id_sanpham', $request->id_sanpham)
                ->first();

            if ($existingItem) {
                // If item exists, update quantity
                $newQuantity = min($existingItem->soluong + $request->soluong, $product->soluong);
                $existingItem->update(['soluong' => $newQuantity]);
            } else {
                // If item doesn't exist, create new cart item
                CartItem::create([
                    'id_giohang' => $cart->id_giohang,
                    'id_sanpham' => $request->id_sanpham,
                    'soluong' => min($request->soluong, $product->soluong)
                ]);
            }

            // Tính toán tổng giỏ hàng
            $cartItems = CartItem::with('product')
                ->where('id_giohang', $cart->id_giohang)
                ->get();
            $total = $this->calculateTotal($cartItems);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully',
                'redirect_url' => route('cart.index'),
                'cart_total' => '$' . number_format($total, 2)
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Add to cart error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error adding product to cart'
            ], 500);
        }
    }

    public function updateQuantity(Request $request, $id)
    {
        try {
            $request->validate([
                'soluong' => 'required|integer|min:1'
            ]);

            DB::beginTransaction();
            $cartItem = CartItem::with('product')->findOrFail($id);

            if ($request->soluong > $cartItem->product->soluong) {
                return response()->json([
                    'success' => false,
                    'message' => 'Số lượng vượt quá tồn kho'
                ], 400);
            }

            $cartItem->soluong = $request->soluong;
            $cartItem->save();

            $cart = $cartItem->cart;
            $total = $this->calculateTotal($cart->cartItems);
            $itemTotal = ($cartItem->product->gia_khuyen_mai ?? $cartItem->product->gia) * $cartItem->soluong;
            $cartTotal = '$' . number_format($total, 2); // Format tổng giá

            DB::commit();

            return response()->json([
                'success' => true,
                'total' => '$' . number_format($total, 2),
                'item_total' => '$' . number_format($itemTotal, 2),
                'cart_total' => $cartTotal
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Update cart error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật giỏ hàng'
            ], 500);
        }
    }

    public function removeItem($id)
    {
        try {
            DB::beginTransaction();
            $cartItem = CartItem::findOrFail($id);
            $cart = $cartItem->cart;
            $cartItem->delete();

            $total = $this->calculateTotal($cart->fresh()->cartItems);
            $cartTotal = '$' . number_format($total, 2);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Đã xóa sản phẩm khỏi giỏ hàng',
                'cart_total' => $cartTotal
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Remove cart item error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra'
            ], 500);
        }
    }

    private function getOrCreateCart()
    {
        return Cart::firstOrCreate([
            'id_nguoidung' => Auth::id()
        ]);
    }

    private function calculateTotal($cartItems)
    {
        return $cartItems->sum(function ($item) {
            $price = $item->product->gia_khuyen_mai ?? $item->product->gia;
            return $price * $item->soluong;
        });
    }

    public function moveSessionCartToDatabase()
    {
        if (!Auth::check() || !session()->has('cart')) {
            return;
        }

        try {
            DB::beginTransaction();

            $cart = $this->getOrCreateCart();
            $sessionCart = session()->get('cart', []);

            foreach ($sessionCart as $productId => $quantity) {
                $product = Product::find($productId);
                if ($product) {
                    CartItem::updateOrCreate(
                        [
                            'id_giohang' => $cart->id_giohang,
                            'id_sanpham' => $productId
                        ],
                        [
                            'soluong' => DB::raw('LEAST(soluong + ' . $quantity . ', ' . $product->soluong . ')')
                        ]
                    );
                }
            }

            session()->forget('cart');
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error moving session cart to database: ' . $e->getMessage());
        }
    }
}
