<?php
use Filament\Notifications\Notification;
use function Laravel\Folio\name;
use App\Models\User;

name('output.view');
?>
<x-app-layout>
    @if (session('warehouse') !== null)
    <livewire:view-input :warehouse="session('warehouse')" :movement="$movement">
    @endif
</x-app-layout>
