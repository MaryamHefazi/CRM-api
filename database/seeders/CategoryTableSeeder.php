<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'آلات موسیقی',
        ]);
        Category::create([
            'name' => 'آلبوم موسیقی',
        ]);
        Category::create([
            'name' => ' کتاب چاپی',
        ]);
        Category::create([
            'name' => ' کتاب صوتی',
        ]);
        Category::create([
            'name' => ' لوازم التحریر ',
        ]);
    }
}
