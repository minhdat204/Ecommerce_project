<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'don_hang';
    protected $primaryKey = 'id_donhang';

    protected $fillable = [
        'id_nguoidung',
        'ma_don_hang',
        'tong_tien_hang',
        'tong_giam_gia',
        'phi_van_chuyen',
        'tong_thanh_toan',
        'pt_thanhtoan',
        'trangthai_thanhtoan',
        'dia_chi_giao',
        'ten_nguoi_nhan',
        'sdt_nhan',
        'ghi_chu',
        'trangthai'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_nguoidung', 'id_nguoidung');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'id_donhang', 'id_donhang');
    }
}
