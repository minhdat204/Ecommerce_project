<?php
namespace App\Http\Controllers\Client;

use App\Models\Comment; 
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopDetailsController
{
        public function showProductDetails($id)
    {
        // Lấy tất cả bình luận của sản phẩm với id_sanpham
        $comments = Comment::where('id_sanpham', $id)->get();

        // Tính điểm đánh giá trung bình cho sản phẩm
        $averageRating = Comment::where('id_sanpham', $id)->avg('danhgia');

        // Trả về dữ liệu vào view
        return view('users.pages.shop-details', compact('comments', 'averageRating'));
    }

}
