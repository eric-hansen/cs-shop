<?php

namespace App\Http\Livewire\Ui\Dialogs;

use App\Http\Livewire\Ui\Notifications\Dialog;
use Livewire\Component;

class Delete extends Component
{
    public bool $showModal = false;
    public string $modelName = '';
    public int $modelId = 0;
    
    protected $listeners = ['showDeletion', 'deleteConfirmed'];

    private $model;

    public function showDeletion(string $modelName, int $modelId, bool $shouldShow)
    {
        $this->loadModel($modelName, $modelId);

        $this->showModal = $shouldShow;
    }

    public function deleteConfirmed(string $modelName, int $modelId)
    {
        $this->loadModel($modelName, $modelId);

        $dialogParams = [];
        
        if ($this->model->delete()) $dialogParams = ['success', ucwords($this->modelName) . ' was deleted successfullly.'];
        else $dialogParams = ['danger', 'Unable to delete ' . $this->modelName . '.  Please try again.'];
        
        $this->emitTo(Dialog::class, 'showMessage', ...$dialogParams);

        $this->showModal = false;

        $this->emit('refreshDatatable');
    }

    public function render()
    {
        return view('livewire.ui.dialogs.delete');
    }

    private function loadModel(string $modelName, int $modelId)
    {
        $this->modelName = $modelName;
        $this->modelId = $modelId;

        $class = "App\\Models\\" . ucwords($modelName);

        $this->model = $class::findOrFail($modelId);
    }
}
