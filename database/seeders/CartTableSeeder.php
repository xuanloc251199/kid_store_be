<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CartTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Thêm dữ liệu mẫu vào bảng cart
        DB::table('cart')->insert([
            [
                'user_id' => 1, // Giả định user_id 1 là John Doe
                'product_id' => 1, // Giả định product_id 1 là Toy Car
                'quantity' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2, // Giả định user_id 2 là Jane Doe
                'product_id' => 2, // Giả định product_id 2 là Building Blocks Set
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1, 
                'product_id' => 3, // Giả định product_id 3 là Story Book
                'quantity' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
