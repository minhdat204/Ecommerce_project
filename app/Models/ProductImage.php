<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $table = 'hinh_anh_san_pham'; // Tên bảng trong database
    protected $primaryKey = 'id_hinhanh'; // Khóa chính

    protected $fillable = [
        'id_sanpham',
        'duongdan',
        'alt',
        'vitri',
        'created_at',
    ];

    // Quan hệ: Một hình ảnh thuộc về một sản phẩm
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_sanpham', 'id_sanpham');
    }
}

