<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $table = 'san_pham'; // Replace with the correct table name

    protected $fillable = [
        'id_danhmuc',
        'tensanpham',
        'slug',
        'mota',
        'id_sanpham',
        'thongtin_kythuat',
        'gia',
        'gia_khuyen_mai',
        'donvitinh',
        'xuatxu',
        'soluong',
        'trangthai',
        'luotxem'
    ];

    // Relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'id_danhmuc', 'id_danhmuc');
    }
}
