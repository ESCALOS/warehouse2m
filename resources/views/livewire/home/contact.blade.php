<section class="text-center bg-gray-100 home-content dark:bg-gray-800">
    <div class="px-4 py-12 md:px-12">
    <div class="container mx-auto xl:px-32">
        <div class="grid items-center lg:grid-cols-2">
        <div class="md:mt-12 lg:mt-0 lg:mb-0">
            <div
            class="relative z-[1] block rounded-lg bg-[hsla(0,0%,100%,0.55)] px-6 py-10 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] backdrop-blur-[30px] dark:bg-gray-900 dark:shadow-black/20 md:px-12 lg:-mr-14">
            <h2 class="mb-6 text-3xl font-bold">Contáctenos</h2>
            <form class="contact-form">
                <div>
                    <div x-data="{ isFocused: false, inputValue: '' }" class="relative mb-3" data-te-input-wrapper-init>
                        <label
                            for="email"
                            class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary"
                            >Correo Electrónico
                        </label>
                        <input
                            type="text"
                            x-on:focus="isFocused = true"
                            x-on:blur="isFocused = false"
                            x-model="inputValue"
                            class="peer block min-h-[auto] w-full rounded border border-gray-300 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:border-primary focus:placeholder-opacity-100 data-[te-input-state-active]:placeholder-opacity-100 motion-reduce:transition-none dark:border-neutral-200 dark:placeholder-text-neutral-200 dark:focus:border-primary dark:peer-focus:text-primary dark:peer-focus:placeholder-text-primary dark:peer-data-[te-input-state-active]:border-neutral-200 dark:peer-data-[te-input-state-active]:placeholder-text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder-opacity-0"
                            id="name"
                            autocomplete="name"/>
                    </div>
                    <div x-data="{ isFocused: false, inputValue: '' }" class="relative mb-3">
                        <!-- Contenedor del input y el label -->
                        <div class="relative">
                            <!-- Label -->
                            <label
                                for="custom-input"
                                class="absolute block px-2 text-gray-500 transition-all duration-200 transform -translate-y-1/2 rounded-md"
                                :class="{ 'left-2 text-xs top-0 dark:bg-gray-900': isFocused || inputValue !== '', 'left-3 top-1/2': !(isFocused || inputValue !== '') }"
                            >Nombre</label>

                            <!-- Input -->
                            <input
                                type="text"
                                x-on:focus="isFocused = true"
                                x-on:blur="isFocused = false"
                                x-model="inputValue"
                                class="block w-full px-3 py-2 bg-transparent border border-white rounded peer focus:border-primary"
                                id="custom-input"
                                autocomplete="off"
                            />
                        </div>
                    </div>
                    <div class="relative mb-3" data-te-input-wrapper-init x-data="{ phoneNumber: '' }">
                        <input
                            type="text"
                            class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:peer-focus:text-primary [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                            autocomplete="phone"
                            id="phone"
                            x-model="phoneNumber"
                            x-on:input="formatPhoneNumber"/>
                        <label
                            for="phone"
                            class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary"
                            >Celular
                        </label>
                    </div>
                    <div class="mb-5">
                        <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mensaje</label>
                        <textarea id="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Escribe tu mensaje"></textarea>
                    </div>
                </div>
                <button type="button" class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">Enviar</button>
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
    <script data-navigate-once>
        function formatPhoneNumber() {
            this.phoneNumber = this.phoneNumber.replace(/\D/g, ''); // Elimina cualquier carácter que no sea un número
            this.phoneNumber = this.phoneNumber.replace(/(\d{3})(?=\d)/g, '$1-'); // Agrega guiones cada 3 números
        }
    </script>
</section>
