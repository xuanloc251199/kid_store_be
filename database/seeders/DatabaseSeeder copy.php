<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RolesTableSeeder::class,
            CategoriesTableSeeder::class,
            UsersTableSeeder::class,
            ProductsTableSeeder::class,
            CartTableSeeder::class,
            ReviewsTableSeeder::class,
            TicketsTableSeeder::class,
        ]);
    }
}
