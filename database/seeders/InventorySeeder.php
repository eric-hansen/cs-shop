<?php

namespace Database\Seeders;

use App\Models\Inventory;

class InventorySeeder extends BaseSeeder
{
    public string $model = Inventory::class;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->processCsvData('inventory');
    }
}
