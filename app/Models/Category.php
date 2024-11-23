<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'danh_muc';
    protected $primaryKey = 'id_danhmuc'; // Xác định khóa chính

    protected $fillable = [
        'id_danhmuc_cha',
        'tendanhmuc',
        'slug',
        'mota',
        'thumbnail',
        'trangthai'
    ];
    // Quan hệ với chính bảng Category
    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'id_danhmuc_cha', 'id_danhmuc');
    }

    // Thêm relationship với products
    public function products()
    {
        return $this->hasMany(Product::class, 'id_danhmuc', 'id_danhmuc');
    }

    // Thêm relationship với child categories
    public function childCategories()
    {
        return $this->hasMany(Category::class, 'id_danhmuc_cha', 'id_danhmuc');
    }
}
