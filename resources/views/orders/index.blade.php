<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Orders') }}
        </h2>
    </x-slot>

        <div class="mx-auto sm:px-6 lg:px-2 py-4">
            <livewire:order-table />            
        </div>
</x-app-layout>
