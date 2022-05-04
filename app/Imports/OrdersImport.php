<?php

namespace App\Imports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OrdersImport implements ToModel, WithHeadingRow, WithBatchInserts
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $fields = collect((new Order)->getFillable())->values()->flip();

        $data = collect($row)->intersectByKeys($fields);

        return new Order($data->toArray());
    }

    public function batchSize(): int
    {
        return 1100;
    }
}
