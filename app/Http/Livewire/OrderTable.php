<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;

class OrderTable extends DataTableComponent
{
    protected $model = Order::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');

        $aggregates = $this->builder()->selectRaw('AVG(total_cents) AS average, SUM(total_cents) AS total')->first();
        $statusTotals = $this->builder()->groupBy('order_status')->selectRaw('COUNT(orders.id) AS total, order_status')->get()->keyBy('order_status');

        $statuses = collect();

        $statusTotals->each(fn($data, $key) => $statuses->push($key . " - " . $data->total));

        $this->setConfigurableAreas([
            'after-pagination' => [
                'orders.table.stats', [
                    'total' => $aggregates->total,
                    'avg' => $aggregates->average,
                    'status_totals' => $statuses,
                ]
            ]
        ]);
    }

    public function columns(): array
    {
        return [
            Column::make("Name", "name"),
            Column::make("Email", "email"),
            Column::make("Product", "product.product_name")
                ->searchable(),
            Column::make("Color", "inventory.color"),
            Column::make("Size", "inventory.size"),
            Column::make("Order status", "order_status")
                ->sortable(),
            Column::make("Total", "total_cents")
                ->sortable(),
            Column::make("Transaction id", "transaction_id")
                ->sortable(),
            Column::make("Shipper name", "shipper_name")
                ->sortable(),
            Column::make("Tracking number", "tracking_number")
                ->sortable(),
            Column::make("SKU", "inventory.sku")->searchable()->hideIf(true),
        ];
    }
    
    public function builder(): Builder
    {
        return Order::join('products', 'products.id', 'orders.product_id')->where('products.user_id', auth()->user()->id);
    }
}
