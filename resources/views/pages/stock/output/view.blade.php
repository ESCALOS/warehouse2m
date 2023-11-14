<?php
use Filament\Notifications\Notification;
use function Laravel\Folio\name;
use function Livewire\Volt\{state};
use function Livewire\Volt\{computed};
use App\Models\User;

name('output.view');
?>
<x-app-layout>
    @if (session('warehouse') !== null)
    infolist
    @endif
</x-app-layout>
