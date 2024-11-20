<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatSession extends Model
{
    protected $table = 'phien_chat';
    protected $primaryKey = 'id_phienchat';

    protected $fillable = [
        'id_nguoidung',
        'id_admin',
        'tieu_de',
        'batdau',
        'ketthuc',
        'trangthai'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_nguoidung', 'id_nguoidung');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin', 'id_nguoidung');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'id_phienchat', 'id_phienchat');
    }
}
