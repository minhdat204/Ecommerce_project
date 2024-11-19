<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'san_pham';
    protected $primaryKey = 'id_sanpham';

    protected $fillable = [
        'id_danhmuc',
        'tensanpham',
        'slug',
        'mota',
        'thongtin_kythuat',
        'gia',
        'gia_khuyen_mai',
        'donvitinh',
        'xuatxu',
        'soluong',
        'trangthai',
        'luotxem'
    ];

    public function danhMuc()
    {
        return $this->belongsTo(Category::class, 'id_danhmuc', 'id_danhmuc');
    }

    public function hinhAnh()
    {
        return $this->hasMany(ProductImages::class, 'id_sanpham', 'id_sanpham');
    }
}
