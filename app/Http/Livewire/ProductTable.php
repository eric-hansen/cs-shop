<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;

class ProductTable extends DataTableComponent
{
    protected $model = Product::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Name", "product_name")
                ->sortable(),
            Column::make("Style", "style")
                ->sortable(),
            Column::make("Brand", "brand")
                ->sortable(),

            // Library doesn't support hasMany relationships currently, so we need to trick the fetching of SKUs
            Column::make("SKUs", "id")->format(fn($id, Product $product) => $product->skus->implode(", "))
                ->sortable(),
        ];
    }

    public function builder(): Builder
    {
        return Product::with('inventory')->whereUserId(auth()->user()->id);
    }
}
