<?php
use App\Mail\ContactMailable;
use App\Livewire\Forms\ContactForm;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use function Livewire\Volt\{form};
use function Laravel\Folio\name;

name('home.contact');
form(ContactForm::class);

$send = function() {
    $this->form->validate();
    Mail::to('stornblood6969@gmail.com')->send(new ContactMailable($this->form->all()));
    Notification::make()
        ->title('Mensaje enviado')
        ->success()
        ->send();
    $this->form->reset();
}
?>
<x-guest-layout title="Contáctenos">
<section class="text-center bg-gray-100 height-content dark:bg-gray-800">
    <div class="px-4 py-12 md:px-12">
        <div class="container mx-auto xl:px-32">
            <div class="grid items-center lg:grid-cols-2">
                <div class="lg:mt-0 lg:mb-0 md:mt-12">
                    <div
                    class="relative z-[1] block rounded-lg bg-white px-6 py-8 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] backdrop-blur-[30px] dark:bg-gray-900 dark:shadow-black/20 md:px-12 lg:-mr-14">
                        <h2 class="mb-6 text-3xl font-bold">Contáctenos</h2>
                        @volt('contact-form')
                        <form class="contact-form" wire:submit='send'>
                            <div>
                                <x-input-contact model="name" label="Nombres y Apellidos" />
                                <x-input-contact model="email" label="Correo Electrónico" />
                                <x-input-contact model="phoneNumber" label="Celular" autocomplete="tel" />
                                <x-textarea-contact model="content" label="Mensaje" />
                            </div>
                            <x-custom-button class="bg-gray-900 dark:bg-blue-700" label="Enviar" action="send" />
                        </form>
                        @endvolt
                    </div>
                </div>
                <!--Mapa de google maps-->
                <div class="hidden md:mb-12 lg:mb-0 lg:block">
                    <div
                    class="relative h-[700px] rounded-lg shadow-lg dark:shadow-black/20">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15489.992420755932!2d-75.9419914!3d-13.9289211!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9110f79b211e7ced%3A0x6e68818510440c5!2sAgr%C3%ADcola%202M!5e0!3m2!1ses-419!2spe!4v1695613510723!5m2!1ses-419!2spe"
                        class="absolute top-0 left-0 w-full h-full rounded-lg"
                        frameborder="0"
                        allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</x-guest-layout>
