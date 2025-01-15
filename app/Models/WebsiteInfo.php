<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteInfo extends Model
{
    use HasFactory;

    protected $table = 'website_info';

    protected $fillable = [
        'address',
        'phone',
        'email',
        'content',
        'facebook_link',
        'logo_image'
    ];

    //hàm lấy info nếu cần
    public static function getInfo()
    {
        return self::first();
    }
}
