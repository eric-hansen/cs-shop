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

        $this->setConfigurableAreas([
            'after-pagination' => 'products.table.footer',
            'toolbar-right-start' => 'products.table.create_product_button',
        ]);
    }

    public function columns(): array
    {
        return [
            Column::make("Name", "product_name")
                ->searchable(),
            Column::make("Style", "style"),
            Column::make("Brand", "brand"),

            // Library doesn't support hasMany relationships currently, so we need to trick the fetching of SKUs
            Column::make("SKUs", "id")->format(fn($id, Product $product) => $product->skus->implode(", ")),

            Column::make('Actions')
                ->label(fn ($row) => view('products.table.actions', compact('row'))),
        ];
    }

    public function builder(): Builder
    {
        return Product::with('inventory')
            ->whereUserId(auth()->user()->id)
            ->orderBy('product_name', 'asc');
    }
}
