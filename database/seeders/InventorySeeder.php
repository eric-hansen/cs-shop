<?php

namespace Database\Seeders;

use App\Models\Inventory;

class InventorySeeder extends BaseSeeder
{
    public string $model = Inventory::class;
    public string $filename = 'inventory.csv';
}
