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

        $aggregates = $this->builder(false)
            ->selectRaw('AVG(total_cents) AS average, SUM(total_cents) AS total')
            ->first();

        $statusTotals = $this->builder(false)
            ->groupBy('order_status')
            ->selectRaw('COUNT(orders.id) AS total, order_status')
            ->get()
            ->keyBy('order_status');

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
            Column::make("Order status", "order_status"),
            Column::make("Total", "total_cents")
                ->format(fn ($value) => format_currency($value)),
            Column::make("Transaction id", "transaction_id"),
            Column::make("Shipper name", "shipper_name"),
            Column::make("Tracking number", "tracking_number"),
            Column::make("SKU", "inventory.sku")
                ->searchable()
                ->hideIf(true),
        ];
    }
    
    public function builder($includeOrderBy = true): Builder
    {
        $builder = Order::join('products', 'products.id', 'orders.product_id')
            ->where('products.user_id', auth()->user()->id);

        if ($includeOrderBy) $builder->orderBy('name');

        return $builder;
    }
}
