<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'matkhau' => Hash::make('password'),
            'email' => $this->faker->unique()->safeEmail,
            'sodienthoai' => $this->faker->phoneNumber,
            'diachi' => $this->faker->address,
            'hoten' => $this->faker->name,
            'gioitinh' => $this->faker->randomElement(['male', 'female']),
            'ngaysinh' => $this->faker->date(),
            'avatar' => null,
            'loai_nguoidung' => 'user',
            'trangthai' => 'active',
            'email_verified_at' => now(),
        ];
    }
}
