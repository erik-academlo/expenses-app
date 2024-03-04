<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['Restaurante',  'Cine', 'Carro', 'Mantenimiento auto', 'Iphone 15', 'Linea telefonica', 'Internet', 'Agua', 'Luz', 'Netflix', 'Walmart', 'Costco', 'Regalandote'];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category]);
        }
    }
}
