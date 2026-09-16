<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'Notebook',
            'description' => 'Notebook para estudos e trabalho.',
            'price' => 3500.00,
            'stock' => 10,
            'is_active' => true,
        ]);

        Product::create([
            'name' => 'Mouse',
            'description' => 'Mouse RGB foda.',
            'price' => 80.00,
            'stock' => 25,
            'is_active' => true,
        ]);

        Product::create([
            'name' => 'Teclado',
            'description' => 'Teclado mecânico.',
            'price' => 250.00,
            'stock' => 15,
            'is_active' => true,
        ]);

        Product::create([
            'name' => 'Monitor',
            'description' => 'Monitor LED de 24 polegadas.',
            'price' => 900.00,
            'stock' => 8,
            'is_active' => true,
        ]);

        Product::create([
            'name' => 'Headset',
            'description' => 'Headset com microfone para gamers.',
            'price' => 180.00,
            'stock' => 20,
            'is_active' => true,
        ]);
    }
}
