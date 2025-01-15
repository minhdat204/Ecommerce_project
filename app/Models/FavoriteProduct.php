<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavoriteProduct extends Model
{
    protected $table = 'san_pham_yeu_thich';
    protected $primaryKey = 'id_yeuthich'; 

    public $timestamps = false;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'id_nguoidung',
        'id_sanpham',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_nguoidung', 'id_nguoidung');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_sanpham', 'id_sanpham');
    }
}
