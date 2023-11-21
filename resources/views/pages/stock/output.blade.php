<?php
use function Laravel\Folio\name;
use App\Models\User;

name('output');

?>

<x-app-layout>
    @if (session('warehouse') !== null)
    <livewire:list-outputs :warehouse="session('warehouse')">
    @endif
</x-app-layout>

