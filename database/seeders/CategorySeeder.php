<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::updateOrCreate([
            'id' => 1,
            'name' => 'El aletleri'
        ]);

        Category::updateOrCreate([
            'id' => 2,
            'name' => 'Elektrik Malzemeleri'
        ]);
    }
}
