<?php

namespace App\Http\Controllers\Client;


use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController 
{
    public function showCart($cartId = 2)
    {
        // Lấy các sản phẩm trong giỏ hàng theo id_giohang
        $cartItems = CartItem::with(['product' => function ($query) {
            $query->select('id_sanpham', 'tensanpham', 'gia'); // Chỉ lấy các cột cần thiết
        }])
            ->where('id_giohang', $cartId)
            ->get();

        // Truyền dữ liệu đến view
        return view('users.pages.shoping-cart', compact('cartItems'));
    }

    public function updateQuantity(Request $request, $cartItemId)
    {
        $cartItem = CartItem::find($cartItemId);
    
        if ($cartItem) {
            $cartItem->soluong = $request->quantity; // Cập nhật số lượng
            $cartItem->save();
    
            // Trả về dữ liệu cập nhật
            return response()->json(['success' => true, 'message' => 'Số lượng đã được cập nhật']);
        }
    
        return response()->json(['success' => false, 'message' => 'Không tìm thấy sản phẩm']);
    }
    

    
}


