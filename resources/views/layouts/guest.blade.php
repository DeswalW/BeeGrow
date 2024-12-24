<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col justify-around sm:justify-center items-center pt-6 sm:pt-0 bg-ungu relative">
            <div class="absolute inset-0 overflow-hidden flex justify-center items-center">
                <x-decoration class="absolute h-full w-auto lg:w-full lg:h-auto fill-transparent bottom-0 opacity-10" />
                <div class="absolute inset-0 bg-gradient-to-b from-ungu to-transparent"></div>
            </div>
        
            <div class="w-4/5 max-w-md -top-16 md:top-0 mt-6 px-6 py-6 md:px-10 md:py-10 bg-white shadow-md overflow-hidden rounded-3xl flex justify-center items-center flex-col relative z-10">
                <a href="/">
                    <x-application-logo viewBox="0 0 98 22" class="w-32 h-auto fill-current mb-4" />
                </a>
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
