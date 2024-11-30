<?php

namespace App\Http\Controllers\Client;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController
{
    public function index()
    {
        // Lấy 3 sản phẩm có đánh giá tốt nhất và giảm giá nhiều nhất
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
            $query->where('danhgia', '>=', 4);
        }])
        ->orderByRaw('
            ((danh_gia_tich_cuc * 0.6) +
            (((gia - COALESCE(gia_khuyen_mai, gia)) / gia * 100) * 0.4)) DESC
        ')
        ->take(3)
        ->get();

        return view('users.pages.home', compact('slider'));
    }
}
