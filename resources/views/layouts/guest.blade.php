<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- 各種iconの設定 --}}
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/images/bridgin_v2/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/images/bridgin_v2/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/images/bridgin_v2/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('/images/bridgin_v2/site.webmanifest') }}">
    <meta name="apple-mobile-web-app-title" content="Bridgin">
    <meta name="application-name" content="Bridgin">
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#ffffff">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased h-dvh sm:h-svh bg-slate-50">
    <nav class="bg-white border-b border-gray-100 dark:bg-dark_bg dark:border-dark_border">
        <div class="max-w-7xl mx-auto pr-4 sm:px-6 lg:px-8">
            <div class="flex h-16">
                <div class="overflow-hidden shrink-0 flex items-center max-w-[170px] sm:max-w-[200px]">
                    <img src="{{ asset('/images/bridgin_v2/bridgin_v2_fill_none.svg') }}">
                </div>
            </div>
        </div>
    </nav>
    <div class="relative top-2/4 translate-y-[-58%] dark:bg-dark_bg">
        <div class="mx-auto max-w-[360px] sm:max-w-[430px] bg-white border border-slate-100 rounded-lg shadow-sm">
            {{ $slot }}
        </div>
    </div>
</body>

</html>
