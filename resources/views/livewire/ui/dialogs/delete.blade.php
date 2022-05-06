<div>
    <x-jet-confirmation-modal wire:model="showModal">
        <x-slot name="title">
            {{ __('Delete this') . ' ' . $modelName . '?' }}
        </x-slot>

        <x-slot name="content">
            Are you sure you want to delete this {{ $modelName }}? Once the {{ $modelName }} is deleted, all of its resources and data will be permanently deleted.
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('showModal')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="$emit('deleteConfirmed', '{{ $modelName }}', {{ $modelId }})" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>