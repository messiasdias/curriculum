<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ImageSeeder::class,
            UsersSeeder::class,
            PagesSeeder::class,
            CategoriesSeeder::class,
            CasesSeeder::class,
            SolutionsSeeder::class,
            SlidersSeeder::class,
        ]);
    }
}
