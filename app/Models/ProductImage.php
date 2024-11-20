<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $table = 'hinh_anh_san_pham';
    protected $primaryKey = 'id_hinhanh';

    protected $fillable = [
        'id_sanpham',
        'duongdan',
        'alt',
        'vitri'
    ];

    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_sanpham');
    }
}
