<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Thêm dữ liệu mẫu vào bảng products
        DB::table('products')->insert([
            [
                'name' => 'Toy Car',
                'category_id' => 1, // Giả định category_id 1 là Toys
                'detail' => 'Small red toy car for kids',
                'description' => 'This toy car is made of durable plastic, suitable for children aged 3 and above.',
                'price' => 9.99,
                'thumbnail' => 'product.jpg',
                'sold' => 10,
                'quantity' => 100,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Building Blocks Set',
                'category_id' => 1, // Giả định category_id 1 là Toys
                'detail' => 'A set of colorful building blocks',
                'description' => 'These blocks help to develop creativity and problem-solving skills in children.',
                'price' => 19.99,
                'thumbnail' => 'product.jpg',
                'sold' => 5,
                'quantity' => 50,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Story Book',
                'category_id' => 2, // Giả định category_id 2 là Books
                'detail' => 'A story book for kids',
                'description' => 'A fun and engaging story book for young readers.',
                'price' => 5.99,
                'thumbnail' => 'product.jpg',
                'sold' => 20,
                'quantity' => 200,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
