<?php

namespace Database\Seeders;

use App\Models\Product;

class ProductSeeder extends BaseSeeder
{
    public string $model = Product::class;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->processCsvData('products');
    }

    protected function preProcessRow(array &$header, array &$data)
    {
        $headerCollection = collect($header);

        $adminIdColumn = $headerCollection->search('admin_id');

        $header[$adminIdColumn] = 'user_id';
    }
}
