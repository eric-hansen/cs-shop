<?php

namespace App\Http\Livewire\Product\Ui;

use App\Http\Livewire\Ui\Notifications\Dialog as NotificationsDialog;
use App\Models\Product;
use Livewire\Component;

class Dialog extends Component
{
    public Product $product;
    public bool $showModal;
    public int $modelId;

    protected $listeners = ['showProductDialog', 'confirmProduct'];

    protected $rules = [
        'product.product_name' => 'required|string',
        'product.description' => 'nullable',
        'product.style' => 'required|string',
        'product.brand' => 'required|string',
        'product.url' => 'nullable|string',
        'product.product_type' => 'required|string',
        'product.shipping_price' => 'required',
        'product.note' => 'nullable'
    ];

    public function updated($property)
    {
        $this->validateOnly($property);
    }

    public function confirmProduct()
    {
        $this->validate();

        $dialogParams = [];

        $action = $this->product->getOriginal('id') ? 'update' : 'create';

        $this->product->user_id = auth()->user()->id;
        
        if ($this->product->save()) {
            $dialogParams = ['success', 'Product was ' . $action . 'd successfully.'];
            $this->showModal = false;
        } else {
            $dialogParams = ['danger', 'Unable to ' . $action . ' product.  Please try again.'];
        }
        
        $this->emitTo(NotificationsDialog::class, 'showMessage', ...$dialogParams);

        $this->emit('refreshDatatable');
    }

    public function showProductDialog($productId = 0)
    {
        $this->product = Product::findOrNew($productId);
        $this->modelId = optional($this->product)->id ?? $productId;

        $this->showModal = true;
    }

    public function render()
    {
        return view('livewire.product.ui.dialog');
    }
}
