<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NguoiDung extends Model
{
    use HasFactory;

    protected $table = 'nguoi_dung';
    protected $primaryKey = 'id_nguoidung';

    protected $fillable = [
        'tendangnhap', 'matkhau', 'email', 'sodienthoai', 
        'diachi', 'hoten', 'gioitinh', 'ngaysinh', 
        'avatar', 'loai_nguoidung', 'trangthai'
    ];
    public $timestamps = false;
}
