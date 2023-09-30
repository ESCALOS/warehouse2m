<?php
use function Laravel\Folio\name;
use function Livewire\Volt\{state};

name('home.products');

state([
    'grapeImages' => ['1sP8xX0xy_gvFu1-dP9OSk-NEbyYLrmNJ','1WwD61ag6-RxufNcgxp-HLSxGJQ2ato43'],
    'avocadoImages' => ['17Be_F8evqYAghKaMkSL0XMtOWiTFXdBN','1fF0P0OsfAP45UnNlOhet-3pbzK4LzChA']
]);
?>

<x-guest-layout>
<section class="text-center bg-gray-100 height-content dark:bg-gray-800">
    <div class="px-4 py-12 md:px-12">
        <h1 class="mb-4 text-4xl font-extrabold tracking-tight text-white md:text-5xl lg:text-6xl" style="line-height: 3.5rem">
            Del Campo a tu Mesa
        </h1>
        <p class="hidden mb-8 text-lg font-normal text-gray-300 md:block lg:text-xl sm:px-16 lg:px-48">
            Cosechamos más que frutas; cultivamos experiencias. En 2M Agrícola, cada uva y palta es un testimonio de nuestra dedicación a la excelencia agrícola. Bienvenido a un mundo de sabores auténticos y naturaleza viva.
        </p>
    </div>
    @volt
    <div class="flex flex-wrap items-center justify-center">
        <div class="swiper slider-grape">
            <div class="swiper-wrapper">
                @foreach ($grapeImages as $imageId)
                <div class="bg-gray-700 bg-center bg-no-repeat bg-cover bg-blend-multiply swiper-slide" style="background-image: url('https://drive.google.com/uc?id={{ $imageId }}')"><span class="text-2xl font-extrabold">UVA</span></div>
                @endforeach
            </div>
        </div>
        <div class="swiper slider-grape">
            <div class="swiper-wrapper">
                @foreach ($avocadoImages as $imageId)
                <div class="swiper-slide"><img src="https://drive.google.com/uc?id={{ $imageId }}" alt="avocado"></div>
                @endforeach
            </div>
        </div>
    </div>
    @endvolt
</section>
</x-guest-layout>
