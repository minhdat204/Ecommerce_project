<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $table = 'san_pham_gio_hang';
    protected $primaryKey = 'id_sp_giohang';

    protected $fillable = [
        'id_giohang',
        'id_sanpham',
        'soluong'
    ];

    public $timestamps = false;

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'id_giohang', 'id_giohang');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_sanpham', 'id_sanpham');
    }
}
