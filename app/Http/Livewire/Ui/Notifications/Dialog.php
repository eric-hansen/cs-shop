<?php

namespace App\Http\Livewire\Ui\Notifications;

use Livewire\Component;

class Dialog extends Component
{
    public string $title = '';
    public string $message = '';
    public bool $showMessage = false;

    protected $listeners = ['showMessage'];

    public function showMessage($title, $message)
    {
        $this->title = $title;
        $this->message = $message;

        $this->showMessage = true;
    }

    public function render()
    {
        $title = ucwords(__($this->title));
        $message = __($this->message);
        $closeButtonText = __('Close');

        return $title == '' ? '<div></div>' : <<<blade
                <div>
                <x-jet-dialog-modal wire:model="showMessage">
                    <x-slot name="title">
                        $title
                    </x-slot>
            
                    <x-slot name="content">
                        $message
                    </x-slot>
            
                    <x-slot name="footer">
                        <x-jet-secondary-button wire:click="\$toggle('showMessage')" wire:loading.attr="disabled">
                            $closeButtonText
                        </x-jet-secondary-button>
                    </x-slot>
                </x-jet-dialog-modal>
            </div>
        blade;
    }
}
