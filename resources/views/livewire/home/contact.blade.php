<section class="text-center bg-gray-100 home-content dark:bg-gray-800 contact-content">
    <div class="px-4 py-12 md:px-12">
        <div class="container mx-auto xl:px-32">
            <div class="grid items-center lg:grid-cols-2">
                <div class="lg:mt-0 lg:mb-0 contact-container">
                    <div
                    class="relative z-[1] block rounded-lg bg-white px-6 py-8 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] backdrop-blur-[30px] dark:bg-gray-900 dark:shadow-black/20 md:px-12 lg:-mr-14">
                    <h2 class="mb-6 text-3xl font-bold">Contáctenos</h2>
                    <form class="contact-form" wire:submit='send'>
                        <div>
                            <div x-data="{ isFocused: false }">
                                <div class="relative">
                                    <label
                                        for="name"
                                        class="absolute block px-2 text-gray-900 transition-all duration-200 transform -translate-y-1/2 rounded-md dark:text-gray-100"
                                        :class="{ 'left-2 text-xs top-0 bg-white dark:bg-gray-900': isFocused || $wire.name !== '', 'left-3 top-1/2': !(isFocused || $wire.name !== '') }"
                                    >Nombre</label>
                                    <input
                                        type="text"
                                        x-on:focus="isFocused = true"
                                        x-on:blur="isFocused = false"
                                        class="block w-full px-3 py-2 bg-transparent border border-gray-900 rounded dark:border-white peer focus:border-primary"
                                        id="name"
                                        autocomplete="name"
                                        wire:model='name'
                                    />
                                </div>
                            </div>
                            <div x-data="{ isFocused: false }">
                                <div class="relative">
                                    <label
                                        for="email"
                                        class="absolute block px-2 text-gray-900 transition-all duration-200 transform -translate-y-1/2 rounded-md dark:text-gray-100"
                                        :class="{ 'left-2 text-xs top-0 bg-white dark:bg-gray-900': isFocused || $wire.email !== '', 'left-3 top-1/2': !(isFocused || $wire.email !== '') }"
                                    >Correo Electrónico</label>
                                    <input
                                        type="text"
                                        x-on:focus="isFocused = true"
                                        x-on:blur="isFocused = false"
                                        class="block w-full px-3 py-2 bg-transparent border border-gray-900 rounded dark:border-white peer focus:border-primary"
                                        id="email"
                                        autocomplete="email"
                                        wire:model='email'
                                    />
                                </div>
                            </div>
                            <div x-data="{ isFocused: false }">
                                <div class="relative">
                                    <label
                                        for="phone"
                                        class="absolute block px-2 text-gray-900 transition-all duration-200 transform -translate-y-1/2 rounded-md dark:text-gray-100"
                                        :class="{ 'left-2 text-xs top-0 bg-white dark:bg-gray-900': isFocused || $wire.phoneNumber !== '', 'left-3 top-1/2': !(isFocused || $wire.phoneNumber !== '') }"
                                    >Celular</label>
                                    <input
                                        type="text"
                                        x-on:focus="isFocused = true"
                                        x-on:blur="isFocused = false"
                                        x-on:input="$wire.phoneNumber = $wire.phoneNumber.replace(/\D/g, '').replace(/(\d{3})(?=\d)/g, '$1-');"
                                        maxlength="11"
                                        class="block w-full px-3 py-2 bg-transparent border border-gray-900 rounded dark:border-white peer focus:border-primary"
                                        id="phone"
                                        autocomplete="tel"
                                        wire:model='phoneNumber'
                                    />
                                </div>
                            </div>
                            <div x-data="{ isFocused: false }">
                                <div class="relative">
                                    <label
                                        for="message"
                                        class="absolute block px-2 text-gray-900 transition-all duration-200 transform -translate-y-1/2 rounded-md dark:text-gray-100"
                                        :class="{ 'left-2 text-xs top-0 bg-white dark:bg-gray-900': isFocused || $wire.message !== '', 'left-3 top-1/4': !(isFocused || $wire.message !== '') }"
                                    >Mensaje</label>
                                    <textarea
                                        rows="4"
                                        type="text"
                                        x-on:focus="isFocused = true"
                                        x-on:blur="isFocused = false"
                                        class="block w-full px-3 py-2 bg-transparent border border-gray-900 rounded dark:border-white peer focus:border-primary"
                                        id="message"
                                        wire:model='message'
                                    ></textarea>
                                </div>
                            </div>
                        </div>
                        <button wire:loading.attr='disabled' wire:loading.class='cursor-not-allowed' class="inline-flex items-center px-4 py-2 text-sm font-semibold leading-6 text-white transition duration-150 ease-in-out bg-green-500 rounded-md shadow hover:bg-green-400">
                            <svg wire:loading class="w-5 h-5 mr-3 -ml-1 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span wire:loading>Enviando...</span>
                            <span wire:loading.remove>Enviar</span>
                          </button>
                    </form>
                    </div>
                </div>
                <div class="md:mb-12 lg:mb-0 contact-map">
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
