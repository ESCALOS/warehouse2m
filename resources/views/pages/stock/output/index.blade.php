<?php
use Filament\Notifications\Notification;
use function Laravel\Folio\name;
use function Livewire\Volt\{state};
use function Livewire\Volt\{computed};
use App\Models\User;

name('output');

$warehouse = computed(function () {
    return Auth::user()->warehouses()->first();
});

?>

<x-app-layout>
    @volt
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ $this->warehouse->warehouseType->description }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl dark:bg-gray-800 sm:rounded-lg">
                todavia no hay nada
            </div>
        </div>
    </div>
    @endvolt
</x-app-layout>
