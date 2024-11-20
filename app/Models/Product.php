<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'san_pham';

    // Các thuộc tính có thể được gán đại trà (mass-assignment)
    protected $fillable = [
        'id_danhmuc',           // ID danh mục sản phẩm
        'tensanpham',           // Tên sản phẩm
        'slug',                 // Slug cho sản phẩm
        'mota',                 // Mô tả sản phẩm
        'thongtin_kythuat',     // Thông tin kỹ thuật
        'gia',                  // Giá sản phẩm
        'gia_khuyen_mai',       // Giá khuyến mãi
        'donvitinh',            // Đơn vị tính
        'xuatxu',               // Xuất xứ
        'soluong',              // Số lượng
        'trangthai',            // Trạng thái sản phẩm
    ];

    public $timestamps = true;

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_danhmuc');
    }

    // Nếu có mối quan hệ với bảng yêu thích 
        public function favorites()
    {
        return $this->hasMany(SanPhamYeuThich::class, 'id_sanpham');
    }

    // Nếu có quan hệ với đơn hàng, có thể định nghĩa mối quan hệ với bảng order
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products', 'product_id', 'order_id');
    }
}
