<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Inventory;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Filters\NumberFilter;

class InventoryTable extends DataTableComponent
{
    protected $model = Inventory::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("ID", "id")
                ->searchable(),
            Column::make("Product Name", "product.product_name"),
            Column::make("SKU", "sku")
                ->searchable(),
            Column::make("Quantity", "quantity"),
            Column::make("Color", "color"),
            Column::make("Size", "size"),
            Column::make("Price", "price_cents")
                ->format(fn ($value) => format_currency($value)),
            Column::make("Cost", "cost_cents")
                ->format(fn ($value) => format_currency($value)),
        ];
    }
    
    public function builder(): Builder
    {
        return Inventory::join('products', 'products.id', 'inventories.product_id')
            ->where('products.user_id', auth()->user()->id);
    }

    public function filters(): array
    {
        return [
            NumberFilter::make('Quantity Below  Threshold')
                ->filter(fn(Builder $builder, string $value) => $builder->where('quantity', '<', $value)),
        ];
    }
}
