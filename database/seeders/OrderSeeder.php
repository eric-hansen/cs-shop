<?php

namespace Database\Seeders;

use App\Models\Order;

class OrderSeeder extends BaseSeeder
{
    public string $model = Order::class;
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->processCsvData('orders');
    }

    protected function preProcessRow(array &$header, array &$data)
    {
        $headerCollection = collect($header);

        $nullDataIds = [$headerCollection->search('ship_charged_cents'), $headerCollection->search('ship_cost_cents')];

        foreach ($nullDataIds as $id) {
            $data[$id] = intval($data[$id]);
        }
    }
}
