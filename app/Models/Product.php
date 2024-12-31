<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

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

    protected $casts = [
        'gia' => 'decimal:2',
        'gia_khuyen_mai' => 'decimal:2',
        'soluong' => 'integer',
        'luotxem' => 'integer'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_danhmuc', 'id_danhmuc');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'id_sanpham', 'id_sanpham');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'id_sanpham', 'id_sanpham');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'id_sanpham', 'id_sanpham');
    }

    public function favoriteProducts()
    {
        return $this->hasMany(FavoriteProduct::class, 'id_sanpham', 'id_sanpham');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'id_sanpham', 'id_sanpham');
    }

    // Thuộc tính ảo để lấy giá hiển thị (ưu tiên giá khuyến mãi nếu có)
    public function getCurrentPriceAttribute()
    {
        return $this->gia_khuyen_mai ?? $this->gia;
    }

    // Check if product is in stock
    public function isInStock()
    {
        return $this->soluong > 0;
    }

    // Check if product is active
    public function isActive()
    {
        return $this->trangthai === 'active';
    }

    // Scope to get only active products
    public function scopeActive($query)
    {
        return $query->where('trangthai', 'active');
    }

    // Increment view count
    public function incrementViewCount()
    {
        $this->increment('luotxem');
    }

    // quan hệ product đến cart
    public function carts()
    {
        return $this->belongsToMany(Cart::class, 'san_pham_gio_hang', 'id_sanpham', 'id_giohang')
            ->using(CartItem::class);
    }
    public function productImages()
    {
        return $this->hasMany(ProductImage::class, 'id_sanpham', 'id_sanpham');
    }
}
