<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'danh_muc';

    protected $fillable = [
        'id_danhmuc',
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
}
