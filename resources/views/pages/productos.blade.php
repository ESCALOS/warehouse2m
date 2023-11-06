<?php
use function Laravel\Folio\name;
use function Livewire\Volt\{state};

name('home.products');

?>

<x-guest-layout>
<section class="flex items-center justify-center gap-4 text-center bg-gray-100 height-content dark:bg-gray-800">
    <div class="px-4 py-8 md:px-12">
        <h1 class="mb-4 text-4xl font-extrabold tracking-tight dark:text-white md:text-5xl lg:text-6xl" style="line-height: 3.5rem">
            Cultivando Frutas de Excelencia
        </h1>
        <p class="hidden mb-8 text-lg font-normal text-gray-700 dark:text-gray-300 md:block lg:text-xl sm:px-16 lg:px-48">
            Cosechamos más que frutas; cultivamos experiencias. En 2M Agrícola, cada uva y palta es un testimonio de nuestra dedicación a la excelencia agrícola. Bienvenido a un mundo de sabores auténticos y naturaleza viva.
        </p>

        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
              <div class="swiper-slide">
                <img src="https://drive.google.com/uc?id=1kqefvi_ZvkI6mGMfQJ-_JlcL05DNiv70" />
              </div>
              <div class="swiper-slide">
                <img src="https://drive.google.com/uc?id=1hiu7YIJbjCNOJMAFHc823LMZ4RDBNn-K" />
              </div>
              <div class="swiper-slide">
                <img src="https://drive.google.com/uc?id=1Qs7B491QIcEUf1ViVVxAlUEMDgCBNIEr" style="margin-top: 80px" />
              </div>
              <div class="swiper-slide">
                <img src="https://drive.google.com/uc?id=1EjYI3YyYdhSZBzWPt7r-pbeN6IenCwR0" />
              </div>
            </div>
            <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
          </div>
    </div>
</section>
</x-guest-layout>


