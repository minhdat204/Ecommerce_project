<?php

namespace App\Http\Controllers\Client;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController
{
    public function index()
    {
        // slider : Lấy 3 sản phẩm có đánh giá tốt nhất và giảm giá nhiều nhất
        $slider = Product::select([
            'id_sanpham',
            'tensanpham',
            'gia',
            'gia_khuyen_mai',
            'slug',
            'mota',
        ])
        ->where('trangthai', 'active')
        ->where('soluong', '>', 0)
        ->with(['images' => function($query) {
            $query->select('id_sanpham', 'duongdan', 'alt')->limit(1);
        }])
        ->withCount(['comments as danh_gia_tich_cuc' => function($query) {
            $query->where('danhgia', '>=', 4); //với từng sản phẩm có trong bảng comments, đếm số lượng đánh giá >= 4
        }])
        ->orderByRaw('
            ((danh_gia_tich_cuc * 0.6) +
            (((gia - COALESCE(gia_khuyen_mai, gia)) / gia * 100) * 0.4)) DESC
        ')
        ->take(3)
        ->get();

        //sản phẩm bán chạy: hiển thị 4 sản phẩm bán chạy nhất
        $best_selling_products = Product::select([
            'id_sanpham',
            'tensanpham',
            'gia',
            'gia_khuyen_mai',
            'slug',
            'mota',
        ])
        ->where('trangthai', 'active')
        ->where('soluong', '>', 0)
        ->with(['images' => function($query) {
            $query->select('id_sanpham', 'duongdan', 'alt')->limit(1);
        }])
        ->withCount(['orderDetails as so_luong_da_ban'])//đếm tổng những đơn hàng có sản phẩm này, mỗi đơn không thể có cùng 1 sản phẩm
        ->orderBy('so_luong_da_ban', 'desc')
        ->take(8)
        ->get();

        // sản phâm mới: hiển thị 4 sản phẩm mới nhất
        $new_products = Product::select([
            'id_sanpham',
            'tensanpham',
            'gia',
            'gia_khuyen_mai',
            'slug',
            'mota',
        ])
        ->where('trangthai', 'active')
        ->where('soluong', '>', 0)
        ->with(['images' => function($query) {
            $query->select('id_sanpham', 'duongdan', 'alt')->limit(1);
        }])
        ->orderBy('created_at', 'desc')
        ->take(8)
        ->get();

        //hiển thị 1 số danh mục sản phẩm có trong cơ sở dữ liệu, với công thức là lấy 4 danh mục có nhiều sản phẩm nhất
        $categories = Category::withCount('products as so_luong_san_pham')
        ->orderBy('so_luong_san_pham', 'desc')
        ->take(8)
        ->get();

        return view('users.pages.home', compact('slider', 'best_selling_products', 'new_products', 'categories'));
    }
    public function search(Request $request)
{
    // Lấy tất cả danh mục cấp cha (các danh mục không có id_danhmuc_cha)
    $categories = Category::whereNull('id_danhmuc_cha')->get();

    // Khởi tạo query cho model Product
    $query = Product::query();

    // Kiểm tra và thêm điều kiện cho category
    if ($request->has('category') && $request->category != '') {
        $query->where('id_danhmuc', $request->category);
    }

    // Kiểm tra và thêm điều kiện cho từ khóa tìm kiếm
    if ($request->has('search_term') && $request->search_term != '') {
        $query->where('tensanpham', 'like', '%' . $request->search_term . '%');
    }

    // Lấy kết quả tìm kiếm từ cơ sở dữ liệu
    $products = $query->get();

    // Trả kết quả về view
    return view('users.pages.search-results', compact('products', 'categories'));
}

}