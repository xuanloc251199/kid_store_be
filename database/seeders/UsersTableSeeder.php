<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Thêm dữ liệu mẫu vào bảng users
        DB::table('users')->insert([
            [
                'role_id' => 1, // Admin
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'), // Mật khẩu đã mã hóa
                'number_phone' => '1234567890',
                'address' => '123 Main St, Cityville',
                'avatar' => 'avatars/john.jpg',
                'remember_token' => \Illuminate\Support\Str::random(10),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'role_id' => 2, // Regular user
                'name' => 'Jane Doe',
                'email' => 'jane@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'number_phone' => '0987654321',
                'address' => '456 Maple St, Townsville',
                'avatar' => 'avatars/jane.jpg',
                'remember_token' => \Illuminate\Support\Str::random(10),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
