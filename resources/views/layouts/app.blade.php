@php
    $warehouse = Auth::user()->warehouses->first();
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="shortcut icon" href="{{ asset('./favicon.ico') }}" type="image/x-icon">
        <!-- Scripts -->
        @filamentStyles
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @livewire('navigation-menu')

            <header class="bg-white shadow dark:bg-gray-800">
                <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                        {{ $warehouse?->description ?: 'Sin almacén' }}
                    </h2>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <div class="py-12">
                    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                        <div class="overflow-hidden bg-white shadow-xl dark:bg-gray-800 sm:rounded-lg">
                            @if ($warehouse)
                            {{ $slot }}
                            @else
                            <div class="py-8 text-2xl font-black text-center">
                                Solicite que se le asigne un almacén
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </main>
        </div>

        @stack('modals')

        @livewire('notifications')
        @filamentScripts
        <x-impersonate::banner/>
    </body>
</html>
