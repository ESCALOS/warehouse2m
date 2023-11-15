<?php
use Filament\Notifications\Notification;
use function Laravel\Folio\name;
use function Livewire\Volt\{state};
use function Livewire\Volt\{computed};
use App\Models\User;

name('input.create');
?>
<x-app-layout>
    @if (session('warehouse') !== null)
    <livewire:create-output :warehouse="session('warehouse')">
    @endif
</x-app-layout>
