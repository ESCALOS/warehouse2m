<?php
use function Laravel\Folio\name;

name('home.index');
?>

<x-guest-layout>
<section class="bg-gray-700 bg-center bg-no-repeat bg-cover bg-blend-multiply bg-image-home height-content">
    <div class="max-w-screen-xl px-6 py-24 mx-auto text-center lg:py-56">
        <h1 class="mb-4 text-4xl font-extrabold tracking-tight text-white md:text-5xl lg:text-6xl" style="line-height: 3.5rem">Agrícola 2m: Cultivando Sustentabilidad</h1>
        <p class="mb-8 text-lg font-normal text-gray-300 lg:text-xl sm:px-16 lg:px-48">Comprometidos con la calidad, sostenibilidad y la satisfacción de nuestros clientes.</p>
        <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0 sm:space-x-4">
            <a wire:navigate.hover href="{{ route('home.contact') }}" class="inline-flex items-center justify-center px-5 py-3 text-base font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
                Contáctanos
                <svg class="w-3.5 h-3.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                </svg>
            </a>
            <a wire:navigate.hover href="{{ route('home.products') }}" class="inline-flex items-center justify-center px-5 py-3 text-base font-medium text-center text-white border border-white rounded-lg hover:text-gray-900 hover:bg-gray-100 focus:ring-4 focus:ring-gray-400">
                Nuestros servicios
            </a>
        </div>
    </div>
</section>
</x-guest-layout>
