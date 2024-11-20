<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'danh_muc'; // Tên bảng trong database

    protected $fillable = [
        'ten_danhmuc', // Các cột cần thiết, bổ sung nếu thiếu
        'slug',
        'mota',
    ];

    // Quan hệ 1-N: Một danh mục có nhiều sản phẩm
    public function products()
    {
        return $this->hasMany(Product::class, 'id_danhmuc', 'id_danhmuc');
    }
}
