<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $table = 'bai_viet';
    protected $primaryKey = 'id_baiviet';

    protected $fillable = [
        'tieude',
        'slug',
        'noidung',
        'id_tacgia',
        'thumbnail',
        'luotxem'
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'id_tacgia', 'id_nguoidung');
    }
}
