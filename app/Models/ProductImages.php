<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model
{
    protected $table = 'hinh_anh_san_pham';
    protected $primaryKey = 'id_hinhanh';
    public $timestamps = false;

    protected $fillable = [
        'id_sanpham',
        'duongdan',
        'alt',
        'vitri',
        'created_at'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_sanpham', 'id_sanpham');
    }
}
