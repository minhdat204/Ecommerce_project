<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'tin_nhan';
    public $timestamps = false;
    protected $primaryKey = 'id_tinnhan';

    protected $fillable = [
        'id_phienchat',
        'id_nguoigui',
        'noidung',
        'file_dinh_kem',
        'thoigian',
        'trangthai'
    ];

    protected $casts = [
        'thoigian' => 'datetime',
    ];

    public function chatSession()
    {
        return $this->belongsTo(ChatSession::class, 'id_phienchat', 'id_phienchat');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'id_nguoigui', 'id_nguoidung');
    }

    public function user(){
        return $this->belongsTo(User::class, 'id_nguoigui', 'id_nguoidung');
    }
}
