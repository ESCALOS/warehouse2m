<?php
use function Laravel\Folio\name;
use App\Models\User;

name('stock');
?>

<x-app-layout>
    @if (session('warehouse') !== null)
    <livewire:list-items :warehouse="session('warehouse')">
    @endif
</x-app-layout>
