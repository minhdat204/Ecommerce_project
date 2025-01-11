<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'matkhau' => Hash::make('admin123'),
            'email' => 'admin@example.com',
            'sodienthoai' => null,
            'diachi' => null,
            'hoten' => 'Administrator',
            'gioitinh' => null,
            'ngaysinh' => null,
            'avatar' => null,
            'loai_nguoidung' => 'admin',
            'trangthai' => 'active',
            'email_verified_at' => now(),
        ]);
    }
}
