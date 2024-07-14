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

    <!-- Styles -->
    @vite(['resources/scss/app.scss', 'resources/css/app.css'])
</head>

<body class="font-sans antialiased bg-slate-50 dark:bg-dark_bg text-slate-800 dark:text-white">
    @include('components.loading-animation')
    <div class="min-h-screen">
        @include('layouts.navigation')
        <!-- Page Content -->
        <main id="page-content" class="flex max-w-full flex-auto flex-col">
            {{ $slot }}
        </main>
    </div>

    <!-- Scripts -->
    @vite(['resources/js/app.js', 'resources/js/switch-dark-with-light.js', 'resources/js/display-loading-animation.js'])
    @yield('scripts')
    @stack('script-files')

</body>

</html>
