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

<body class="font-sans antialiased h-dvh sm:h-svh bg-slate-50">
    <section class="sm:relative sm:top-2/4 sm:translate-y-[-50%] text-slate-800">
        <div
            class="mx-auto max-w-[1100px] py-12 bg-white border-0 rounded-lg flex gap-0 sm:gap-6 scroll-px-56 sm:px-24 sm:py-24 md:flex-row flex-col items-center">
            <div class="lg:max-w-md md:w-1/2 w-5/6 mb-10 md:mb-0">
                <img class="object-cover object-center border border-slate-50 shadow-lg rounded-lg" alt="logo"
                    src="{{ asset('/images/bridgin_v2/bridgin_v2_fill_none.svg') }}">
            </div>
            <div class="md:w-1/2 md:pl-8 px-6 flex flex-col justify-between items-start text-start">
                <h1
                    class="mx-2 mb-5 block text-2xl font-bold text-gray-800 sm:text-4xl lg:leading-tight dark:text-white">
                    資産管理のかけ橋<span><br>もっと身近に</span></h1>
                <div class="mb-5 bg-slate-50 p-5 border-0 rounded-lg">
                    <div class="flex gap-2 items-center">
                        <i class="fa-regular fa-thumbs-up text-2xl text-blue-600"></i>
                        <p class="text-lg font-semibold">資産管理のお悩みを解決</p>
                    </div>
                    <ul class="py-3 px-5 text-base text-slate-500 list-disc leading-relaxed text-start">
                        <li>お金の流れを『見える化』したい</li>
                        <li>エクセルでの入力はめんどう</li>
                        <li>そもそも管理していない</li>
                    </ul>
                </div>
                <div class="flex justify-center items-center">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('assets.dashboard') }}"
                                class="inline-flex items-center text-white bg-blue-600 border-0 py-3 px-6 focus:outline-none hover:bg-blue-700 rounded-lg text-base">{{ __('dashboard') }}<i
                                    class="fa-solid fa-angle-right ml-2"></i></a>
                        @else
                            <div class="flex gap-4">
                                <a href="{{ route('login') }}"
                                    class="inline-flex items-center text-white bg-blue-600 border-0 py-3 px-6 focus:outline-none hover:bg-blue-700 rounded-lg text-base">{{ __('login') }}<i
                                        class="fa-solid fa-angle-right ml-2"></i>
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="inline-flex items-center text-slate-500 bg-white border border-slate-600 py-3 px-6 focus:outline-none hover:bg-slate-50 rounded-lg text-base">{{ __('register') }}<i
                                            class="fa-solid fa-angle-right ml-2"></i></a>
                                @endif
                            </div>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </section>
    @vite('resources/js/app.js')
</body>

</html>
