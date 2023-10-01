<?php
use function Laravel\Folio\name;

name('home.about');
?>

<x-guest-layout>
    <section class="flex items-center justify-center gap-4 text-center bg-gray-100 height-content dark:bg-gray-800">
        <div class="px-4 py-8 md:px-12">
            <h1 class="mb-4 text-4xl font-extrabold tracking-tight text-white md:text-5xl lg:text-6xl" style="line-height: 3.5rem">
                Nuestra Esencia
            </h1>
            <p class="hidden mb-16 text-lg font-normal text-gray-300 md:block lg:text-xl sm:px-16 lg:px-48">
                Cultivamos un Legado de Excelencia y Sostenibilidad
            </p>
            <div class="flex flex-wrap justify-around gap-8 flex-items-center">
                <x-card-image image="https://drive.google.com/uc?id=14UvPX94cxtmo8N0yxsn30djhQHROXNin" title="Misión">
                    Ser lideres en la industria agroindustrial a nivel internacional, garantizando el cumplimiento de los estándares de calidad, inocuidad, legalidad y seguridad alimentaria para nuestros procesos y sus productos, comprometidos con el trabajo sostenible y responsable del medio ambiente.
                </x-card-image>
                <x-card-image image="https://drive.google.com/uc?id=1HYztns3-5MMgJSRYhThSWVQIq5A5dhXv" title="Visión">
                    Buscamos ser la compañía líder en el negocio de la exportación de frutas frescas reconocida a nivel internacional, como una organización innovadora, competitiva, con tecnología de vanguardia y un compromiso confiable en el desarrollo de nuestros productos y servicios.
                </x-card-image>
            </div>
        </div>
    </section>
</x-guest-layout>
