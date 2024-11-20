<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanPhamYeuThich extends Model
{
    use HasFactory;

    protected $table = 'san_pham_yeu_thich'; 

    protected $fillable = [
        'id_nguoidung',
        'id_sanpham',
        'status', 
    ];
    public function sanpham()
    {
        return $this->belongsTo(SanPham::class, 'id_sanpham');
    }
    
    public function nguoidung()
    {
        return $this->belongsTo(NguoiDung::class, 'id_nguoidung');
    }
}
