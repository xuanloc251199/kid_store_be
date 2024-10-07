<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Thêm dữ liệu mẫu vào bảng roles
        DB::table('roles')->insert([
            ['name' => 'Admin', 'description' => 'Administrator with full permissions'],
            ['name' => 'User', 'description' => 'Regular user with limited permissions'],
            ['name' => 'Manager', 'description' => 'Manager role with advanced permissions'],
        ]);
    }
}
