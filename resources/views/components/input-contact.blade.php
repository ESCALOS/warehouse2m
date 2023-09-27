<div x-data="{ isFocused: false }">
    <div class="relative">
        <label
        for="{{ $model }}"
            class="absolute block px-2 transition-all duration-200 transform -translate-y-1/2 rounded-md"
            :class="{ 'left-2 text-xs top-0 bg-white dark:bg-gray-900': isFocused || $wire.form.{{ $model }} !== '', 'text-gray-900 dark:text-gray-100 left-3 top-1/2': !(isFocused || $wire.form.{{ $model }} !== ''), 'text-blue-600': isFocused}"
        >{{ $label }}</label>
        <input
            type="text"
            x-on:focus="isFocused = true"
            x-on:blur="isFocused = false"
            @if ($model == 'phoneNumber')
            x-on:input="$wire.form.phoneNumber = $wire.form.phoneNumber.replace(/\D/g, '').replace(/(\d{3})(?=\d)/g, '$1-');"
            maxlength="11"
            @endif
            class="block w-full px-3 py-2 bg-transparent border border-gray-900 rounded dark:border-white focus:border-blue-600 focus:ring-blue-500 dark:focus:border-blue-600 dark:focus:ring-blue-500"
            id="{{ $model }}"
            autocomplete="{{ $autocomplete !== '' ? $autocomplete : $model }}"
            wire:model.blur="form.{{ $model }}"
        />
    </div>
    <div class="text-left">
        @error('form.'.$model)
            <span class="text-xs text-red-700 dark:text-red-600">{{ $message }}</span>
        @enderror
    </div>
</div>
