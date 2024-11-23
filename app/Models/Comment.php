<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'binh_luan';
    protected $primaryKey = 'id_binhluan';
    public $timestamps = false;

    protected $fillable = [
        'id_sanpham',
        'id_nguoidung',
        'danhgia',
        'noidung',
        'parent_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_sanpham', 'id_sanpham');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_nguoidung', 'id_nguoidung');
    }

    public function parentComment()
    {
        return $this->belongsTo(Comment::class, 'parent_id', 'id_binhluan');
    }

    public function childComments()
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id_binhluan');
    }
}
