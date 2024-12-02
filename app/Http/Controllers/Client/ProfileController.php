<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Models\FavoriteProduct;
use App\Models\Comment;
use App\Models\Order;
use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = User::findOrFail(3);
        // Đây có thể được thay thế bằng Auth::user() :
        // Lấy các sản phẩm yêu thích của người dùng (ID = 4)
        $favorites = FavoriteProduct::where('id_nguoidung', $user->id_nguoidung)
            ->join('san_pham', 'san_pham.id_sanpham', '=', 'san_pham_yeu_thich.id_sanpham')
            ->select('san_pham.id_sanpham', 'san_pham.tensanpham', 'san_pham.gia')
            ->paginate(10);
        $scores = Comment::with('product')
            ->where('id_nguoidung', $user->id_nguoidung)
            ->select('noidung', 'id_sanpham', 'danhgia')
            ->paginate(10);
        // Lấy danh sách đơn hàng
        $orders = Order::with(['orderDetails.product'])
            ->where('id_nguoidung', $user->id_nguoidung)
            ->paginate(10);
        return view('users.pages.profile', compact('user', 'favorites', 'scores', 'orders'));
    }
    public function show($userId)
    {
        return view('users.pages.profile', compact('user', 'favorites', 'scores'));
    }
    public function edit(string $id) {}
    public function update(Request $request, $id) {}
    public function destroy(string $id)
    {
        // Logic xóa người dùng hoặc các sản phẩm yêu thích, đánh giá, nếu cần
    }
    public function orderDetail($orderId)
    {
        $order = Order::with(['orderDetails.product'])
            ->where('id_donhang', $orderId)
            ->firstOrFail();

        return view('users.pages.order.detail', compact('order'));
    }
    /**
     * Show the favorite products page.
     */
    public function favorite()
    {
        return view('users.profile.favorite'); // Trả về view cho trang Favorites
    }

    /**
     * Show the score page.
     */
    public function score()
    {
        return view('users.profile.score'); // Trả về view cho trang Score (đánh giá)
    }
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
