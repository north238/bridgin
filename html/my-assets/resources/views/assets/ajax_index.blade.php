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

<body class="font-sans antialiased">
    <div class="">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('assets') }}
            </h2>
        </x-slot>
        <div class="flex justify-start items-center gap-4 ms-5 my-5">
            <h2 class="text-2xl font-medium title-font text-gray-900 dark:text-white"><svg
                    class="w-6 h-6 text-gray-800 dark:text-white inline" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 8H5m12 0c.6 0 1 .4 1 1v2.6M17 8l-4-4M5 8a1 1 0 0 0-1 1v10c0 .6.4 1 1 1h12c.6 0 1-.4 1-1v-2.6M5 8l4-4 4 4m6 4h-4a2 2 0 1 0 0 4h4c.6 0 1-.4 1-1v-2c0-.6-.4-1-1-1Z" />
                </svg>{{ __('total_amount') }}</h2>
            <p class="lg:w-2/3 text-base dark:text-white">
            <p class="text-xl">{{ number_format($totalAmount) }}<span>円</span></p>
            </p>
        </div>
        <div>
            @include('components.m_table')
        </div>
    </div>
</body>

</html>
