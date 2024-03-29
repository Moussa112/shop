<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'title' => 'Awesome product',
            'description' => 'An awesome description for an awesome product',
            'price' => 19.99,
            'category_id' => 1,
        ]);
    }
}
