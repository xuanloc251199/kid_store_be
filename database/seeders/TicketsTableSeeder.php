<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TicketsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Thêm dữ liệu mẫu vào bảng tickets
        DB::table('tickets')->insert([
            [
                'name' => 'Water Park Fun',
                'place' => 'Aquatic Park, City Center',
                'date' => '2024-12-01',
                'detail' => 'All-day pass to water park',
                'description' => 'An exciting day at the Aquatic Park with water slides, wave pools, and more.',
                'price' => 50.00,
                'number_ticket' => 200,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Theme Park Adventure',
                'place' => 'Mountain Theme Park',
                'date' => '2024-11-15',
                'detail' => 'Full-day adventure pass',
                'description' => 'A thrilling adventure at the mountain theme park with roller coasters, games, and family fun.',
                'price' => 75.00,
                'number_ticket' => 150,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Zoo Safari Tour',
                'place' => 'National Zoo',
                'date' => '2024-10-25',
                'detail' => 'Exclusive safari tour',
                'description' => 'Explore the wonders of wildlife with a guided safari tour at the National Zoo.',
                'price' => 40.00,
                'number_ticket' => 100,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
