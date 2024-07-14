<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-slate-50 dark:bg-dark_bg text-slate-800 dark:text-white">
    <div class="min-h-screen">
        <nav class="bg-white border-b border-slate-100 dark:bg-dark_bg dark:border-dark_border">
            <div class="max-w-7xl mx-auto pr-4 sm:px-6 lg:px-8">
                <div class="flex h-16">
                    <div class="overflow-hidden shrink-0 flex items-center max-w-[170px] sm:max-w-[200px]">
                        <img src="{{ asset('/images/bridgin_v2/bridgin_v2_fill_none.svg') }}">
                    </div>
                </div>
            </div>
        </nav>
        <div
            class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full sm:max-w-2xl mx-auto border border-slate-200 sm:rounded-lg sm:shadow-sm bg-white dark:bg-dark_bg px-6 py-12">
            <div class="flex flex-col items-center max-w-sm mx-auto text-center">
                <p class="p-3 text-sm font-medium text-blue-500 rounded-full bg-blue-50 dark:bg-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                </p>
                <h1 class="mt-5 text-xl font-semibold text-gray-800 dark:text-white md:text-2xl">
                    @yield('title')</h1>
                <p class="mt-4 text-gray-500 dark:text-gray-400">@yield('message')</p>
                <div class="flex items-center w-full mt-6 gap-x-3 shrink-0 sm:w-auto">
                    <a href="{{ url()->previous() }}"
                        class="flex items-center justify-center text-center w-1/2 px-4 py-3 text-base text-slate-600 transition-colors duration-200 bg-white border rounded-lg gap-x-2 sm:w-auto dark:hover:bg-gray-800 dark:bg-gray-900 hover:bg-gray-100 dark:text-gray-200 dark:border-dark_border">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="currentColor"
                            viewBox="0 0 320 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                            <path
                                d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 246.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z" />
                        </svg>
                        戻る
                    </a>

                    <a href="{{ route('assets.dashboard') }}"
                        class="w-1/2 px-4 py-3 text-base tracking-wide text-white transition-colors duration-200 bg-blue-500 rounded-lg shrink-0 sm:w-auto hover:bg-blue-600 dark:hover:bg-blue-500 dark:bg-blue-600">
                        ダッシュボードへ
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
