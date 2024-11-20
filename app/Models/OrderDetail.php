<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'chi_tiet_don_hang';
    protected $primaryKey = 'id_chitiet_donhang'; // Add primary key
    public $timestamps = false; // Add this since table doesn't have timestamps

    protected $fillable = [
        'id_donhang',
        'id_sanpham',
        'soluong',
        'gia',
        'giam_gia',
        'thanh_tien'
    ];

    // Cast decimal fields to float/double
    protected $casts = [
        'gia' => 'float',
        'giam_gia' => 'float',
        'thanh_tien' => 'float'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_donhang', 'id_donhang');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_sanpham', 'id_sanpham');
    }
}
