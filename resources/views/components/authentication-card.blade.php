<div class="flex flex-col items-center py-6 bg-gray-100 height-content sm:justify-center dark:bg-gray-900">
    <div>
        {{ $logo }}
    </div>

    <div class="w-full px-6 py-4 mt-6 overflow-hidden bg-white shadow-md sm:max-w-md dark:bg-gray-800 sm:rounded-lg">
        {{ $slot }}
    </div>
</div>
