<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;

class ProductService
{
    // slider : Lấy 3 sản phẩm có đánh giá tốt nhất và giảm giá nhiều nhất
    public function getSliderProducts($take = 3)
    {
        return Product::select([
            'id_sanpham',
            'tensanpham',
            'gia',
            'gia_khuyen_mai',
            'slug',
            'mota',
        ])
            ->where('trangthai', 'active')
            ->where('soluong', '>', 0)
            ->with(['images' => function ($query) {
                $query->select('id_sanpham', 'duongdan', 'alt')->limit(1);
            }])
            ->withCount(['comments as danh_gia_tich_cuc' => function ($query) {
                $query->where('danhgia', '>=', 4); //với từng sản phẩm có trong bảng comments, đếm số lượng đánh giá >= 4
            }])
            ->orderByRaw('
                ((danh_gia_tich_cuc * 0.6) +
                (((gia - COALESCE(gia_khuyen_mai, gia)) / gia * 100) * 0.4)) DESC
            ')
            ->take($take)
            ->get();
    }
    //sản phẩm bán chạy: hiển thị 8 sản phẩm bán chạy nhất
    public function getBestSellingProducts($take = 8)
    {
        return Product::select([
            'id_sanpham',
            'tensanpham',
            'gia',
            'gia_khuyen_mai',
            'slug',
            'mota',
        ])
            ->where('trangthai', 'active')
            ->where('soluong', '>', 0)
            ->with(['images' => function ($query) {
                $query->select('id_sanpham', 'duongdan', 'alt')->limit(1);
            }])
            ->withCount(['orderDetails as so_luong_da_ban']) //đếm tổng những đơn hàng có sản phẩm này, mỗi đơn không thể có cùng 1 sản phẩm
            ->orderBy('so_luong_da_ban', 'desc')
            ->take($take)
            ->get();
    }
    // sản phâm mới: hiển thị 8 sản phẩm mới nhất
    public function getNewProducts($take = 8)
    {
        return Product::select([
            'id_sanpham',
            'tensanpham',
            'gia',
            'gia_khuyen_mai',
            'slug',
            'mota',
        ])
            ->where('trangthai', 'active')
            ->where('soluong', '>', 0)
            ->with(['images' => function ($query) {
                $query->select('id_sanpham', 'duongdan', 'alt')->limit(1);
            }])
            ->orderBy('created_at', 'desc')
            ->take($take)
            ->get();
    }
    //hiển thị 1 số danh mục sản phẩm có trong cơ sở dữ liệu, với công thức là lấy 4 danh mục có nhiều sản phẩm nhất
    public function getCategories($take = 8)
    {
        return Category::withCount('products as so_luong_san_pham')
            ->orderBy('so_luong_san_pham', 'desc')
            ->take($take)
            ->get();
    }
}