<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $table='lien_he';

    protected $primaryKey='id_lienhe';

    protected $fillable=[
        'id_nguoidung',
        'ten',
        'email',
        'sodienthoai',
        'noidung',
        'trangthai',
    ];
    
    const TrangThai=[
        'new' => 'new',
        'processing' => 'processing',
        'resolved' => 'resolved',
    ];

    public $timestamps=true;
    
    public function nguoidung(){
        return $this->belongsTo(NguoiDung::class, 'id_nguoidung', 'id_nguoidung'); 
    }
}
