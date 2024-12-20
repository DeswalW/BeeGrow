@props(['active', 'icon'])

@php
$classes = ($active ?? false)
            ? 'p-2 mr-1 text-ungu  font-medium text-sm rounded-lg hover:text-ungu hover:bg-[#E6E2FF] dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600'
            : 'p-2 mr-1 text-gray-400 text-sm rounded-lg hover:text-ungu hover:bg-[#E6E2FF] dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {!! $icon !!}
    <div class="hidden md:block">
        {{ $slot }}
    </div>
</a>