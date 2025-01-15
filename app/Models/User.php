<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'nguoi_dung';
    protected $primaryKey = 'id_nguoidung';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tendangnhap',
        'matkhau',
        'email',
        'sodienthoai',
        'diachi',
        'hoten',
        'gioitinh',
        'ngaysinh',
        'avatar',
        'loai_nguoidung',
        'trangthai',
        'email_verified_at',
        'so_lan_khoa',
        'thoi_gian_khoa'
    ];

    protected $dates = [
        'thoi_gian_khoa'
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'matkhau',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'ngaysinh' => 'date',
        'gioitinh' => 'string',
        'loai_nguoidung' => 'string',
        'trangthai' => 'string'
    ];

    public function getAuthPassword()
    {
        return $this->matkhau;
    }

    // Relationships based on migration foreign keys
    public function orders()
    {
        return $this->hasMany(Order::class, 'id_nguoidung', 'id_nguoidung');
    }

    public function cart()
    {
        return $this->hasOne(Cart::class, 'id_nguoidung', 'id_nguoidung');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'id_nguoidung', 'id_nguoidung');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'id_tacgia', 'id_nguoidung');
    }

    public function favoriteProducts()
    {
        return $this->hasMany(FavoriteProduct::class, 'id_nguoidung', 'id_nguoidung');
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'id_nguoidung', 'id_nguoidung');
    }

    public function UserChatSessions()
    {
        return $this->hasMany(ChatSession::class, 'id_nguoidung', 'id_nguoidung');
    }

    public function adminChatSessions()
    {
        return $this->hasMany(ChatSession::class, 'id_admin', 'id_nguoidung');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'id_nguoigui', 'id_nguoidung');
    }
}
