<?php
use Filament\Notifications\Notification;
use function Laravel\Folio\name;
use function Livewire\Volt\{state};
use function Livewire\Volt\{computed};
use App\Models\User;

name('input');

?>

<x-app-layout>
    @if (session('warehouse') !== null)
    <livewire:list-outputs :warehouse="session('warehouse')">
    @endif
</x-app-layout>
