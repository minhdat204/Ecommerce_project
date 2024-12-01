<?php
namespace App\Http\Controllers\Client;

use App\Models\Comment; 
use App\Models\Product;

class ShopDetailsController
{
    public function showProductDetails($slug)
    {
        // Truy vấn sản phẩm dựa trên slug
        $product = Product::where('slug', $slug)->firstOrFail();

        // Lấy id_sanpham từ sản phẩm
        $id_sanpham = $product->id_sanpham;

        // Lấy tất cả bình luận của sản phẩm
        $comments = Comment::where('id_sanpham', $id_sanpham)->get();

        // Tính điểm đánh giá trung bình cho sản phẩm
        $averageRating = Comment::where('id_sanpham', $id_sanpham)->avg('danhgia');

        // Trả về dữ liệu vào view
        return view('users.pages.shop-details', compact('product', 'comments', 'averageRating'));
    }
}
