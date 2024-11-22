<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'lien_he';
    protected $primaryKey = 'id_lienhe';

    protected $fillable = [
        'id_nguoidung',
        'ten',
        'email',
        'sodienthoai',
        'noidung',
        'trangthai'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_nguoidung', 'id_nguoidung');
    }
}
