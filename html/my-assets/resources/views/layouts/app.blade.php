<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
