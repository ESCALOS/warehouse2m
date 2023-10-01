<div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
    <img class="hidden rounded-t-lg md:block" src="{{ $image }}" alt="image" style="height: 230px"/>
    <div class="p-5">
        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $title }}</h5>
        <p class="mb-3 font-normal text-justify text-gray-700 dark:text-gray-400">{{ $slot }}</p>
    </div>
</div>
