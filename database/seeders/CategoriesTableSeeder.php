<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['category_name' => 'Snacks'],
            ['category_name' => 'Drinks'],
            ['category_name' => 'Condiments'],
            ['category_name' => 'Noodles'],
            ['category_name' => 'Canned Foods'],
        ];

        DB::table('categories')->insert($categories);
    }
}
