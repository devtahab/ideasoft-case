<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = json_decode(file_get_contents(database_path('data/products.json')), true);

        foreach($products as $product){
            Product::updateOrCreate(
                ['id' => $product['id']],
                [
                    'name' => $product['name'],
                    'category_id' => $product['category'],
                    'price' => $product['price'],
                    'stock' => $product['stock']
                ]
            );
        };
    }
}
