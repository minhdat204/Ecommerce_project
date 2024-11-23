<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'gio_hang';
    protected $primaryKey = 'id_giohang';
    public $timestamps = true;

    protected $fillable = [
        'id_nguoidung'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_nguoidung', 'id_nguoidung');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'id_giohang', 'id_giohang');
    }
}
