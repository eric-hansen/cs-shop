<?php

namespace App\Http\Livewire\Ui\Dialogs;

use Livewire\Component;

class Delete extends Component
{
    public bool $modal = false;
    public string $modelName = '';
    public int $modelId = 0;
    
    protected $listeners = ['showDeletion', 'deleteConfirmed'];

    private $model;

    public function showDeletion(string $modelName, int $modelId, bool $shouldShow)
    {
        $this->loadModel($modelName, $modelId);

        $this->modal = $shouldShow;
    }

    public function deleteConfirmed(string $modelName, int $modelId)
    {
        $this->loadModel($modelName, $modelId);

        $toastParams = [];
        
        if ($this->model->delete()) $toastParams = ['success', ucwords($this->modelName) . ' was deleted successfullly.'];
        else $toastParams = ['danger', 'Unable to delete ' . $this->modelName . '.  Please try again.'];
        
        $this->emit('showToast', ...$toastParams);

        $this->modal = false;

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
