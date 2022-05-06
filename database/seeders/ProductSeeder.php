<?php

namespace Database\Seeders;

use App\Models\Product;

class ProductSeeder extends BaseSeeder
{
    public string $model = Product::class;
    public string $filename = 'products.csv';
}
