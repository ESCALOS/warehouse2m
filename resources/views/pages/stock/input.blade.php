<?php
use function Laravel\Folio\name;
use App\Models\User;

name('input');

?>

<x-app-layout>
    @if (session('warehouse') !== null)
    <livewire:list-inputs :warehouse="session('warehouse')">
    @endif
</x-app-layout>
