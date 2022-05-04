<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="mx-auto sm:px-6 lg:px-2 py-4">
        <livewire:product-table />
    </div>
</x-app-layout>
