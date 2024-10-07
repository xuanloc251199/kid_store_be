<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Thêm dữ liệu mẫu vào bảng reviews
        DB::table('reviews')->insert([
            [
                'user_id' => 1, // Giả định user_id 1 là John Doe
                'product_id' => 1, // Giả định product_id 1 là Toy Car
                'rating' => 5, 
                'comment' => 'My kids love this toy car!',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2, // Giả định user_id 2 là Jane Doe
                'product_id' => 2, // Giả định product_id 2 là Building Blocks Set
                'rating' => 4, 
                'comment' => 'Great quality, but could use more blocks.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1, 
                'product_id' => 3, // Giả định product_id 3 là Story Book
                'rating' => 5, 
                'comment' => 'The story is very engaging, my kids can\'t stop reading!',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
