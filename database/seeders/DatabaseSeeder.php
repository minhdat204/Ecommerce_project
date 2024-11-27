<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'tendangnhap' => 'testuser',
            'matkhau' => Hash::make('password'),
            'email' => 'test@example.com',
            'hoten' => 'Test User',
        ]);

        $this->call([
            FooterSeeder::class,
        ]);
    }
}
