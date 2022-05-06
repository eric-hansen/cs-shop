<?php

namespace Database\Seeders;

use App\Models\Order;

class OrderSeeder extends BaseSeeder
{
    public string $model = Order::class;
    public string $filename = 'orders.csv';
}
