<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Makanan dan minuman',
            'Jasa Perdagangan',
            'Industri Kreatif Seni dan Budaya',
            'Manufaktur',
            'Digital',
            'Lain-lain'
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}