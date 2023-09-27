<div x-data="{ isFocused: false }">
    <div class="relative">
        <label
        for="{{ $model }}"
            class="absolute block px-2 transition-all duration-200 transform -translate-y-1/2 rounded-md"
            :class="{ 'left-2 text-xs top-0 bg-white dark:bg-gray-900': isFocused || $wire.form.{{ $model }} !== '', 'left-3 top-1/4 text-gray-900 dark:text-gray-100': !(isFocused || $wire.form.{{ $model }} !== ''), 'text-blue-600': isFocused }"
        >{{ $label }}</label>
        <textarea
            rows="4"
            type="text"
            id="{{ $model }}"
            x-on:focus="isFocused = true"
            x-on:blur="isFocused = false"
            class="block w-full px-3 py-2 bg-transparent border border-gray-900 rounded dark:border-white focus:border-blue-600 focus:ring-blue-500 dark:focus:border-blue-600 dark:focus:ring-blue-500"
            wire:model='form.{{ $model }}'
        ></textarea>
    </div>

    <div class="text-left" x-show="!isFocused && $wire.form.{{ $model }} === ''">
        @error('form.'.$model)
            <span class="text-xs text-red-700 dark:text-red-600">{{ $message }}</span>
        @enderror
    </div>
</div>
