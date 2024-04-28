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

<body>

    <div x-data="{ userDropdownOpen: false, mobileNavOpen: false }">
        <!-- Page Container -->
        <div id="page-container" class="mx-auto flex min-h-screen w-full min-w-[320px] flex-col bg-slate-50">
            <!-- Page Header -->
            <header id="page-header" class="z-1 flex flex-none items-center pt-5">
                <div class="container mx-auto px-4 lg:px-8 xl:max-w-7xl">
                    <div
                        class="-mx-4 border-y border-slate-200 bg-white px-4 shadow-sm sm:rounded-lg sm:border lg:-mx-6 lg:px-6">
                        <div class="flex justify-between py-2.5 lg:py-3.5">
                            <!-- Left Section -->
                            <div class="flex items-center gap-2 lg:gap-6">
                                <!-- Logo -->
                                <a href="javascript:void(0)"
                                    class="group inline-flex items-center gap-1.5 text-lg font-bold tracking-wide text-slate-900 hover:text-slate-600">
                                    <svg class="hi-mini hi-banknotes inline-block h-5 w-5 -rotate-45 text-violet-600 transition group-hover:scale-110"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M1 4a1 1 0 011-1h16a1 1 0 011 1v8a1 1 0 01-1 1H2a1 1 0 01-1-1V4zm12 4a3 3 0 11-6 0 3 3 0 016 0zM4 9a1 1 0 100-2 1 1 0 000 2zm13-1a1 1 0 11-2 0 1 1 0 012 0zM1.75 14.5a.75.75 0 000 1.5c4.417 0 8.693.603 12.749 1.73 1.111.309 2.251-.512 2.251-1.696v-.784a.75.75 0 00-1.5 0v.784a.272.272 0 01-.35.25A49.043 49.043 0 001.75 14.5z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>Tail<span class="font-normal">Bank</span></span>
                                </a>
                                <!-- END Logo -->

                                <!-- Desktop Navigation -->
                                <nav class="hidden items-center gap-1.5 lg:flex">
                                    <a href="javascript:void(0)"
                                        class="group flex items-center gap-2 rounded-lg bg-violet-50 px-2.5 py-1.5 text-sm font-medium text-violet-600">
                                        <span>Dashboard</span>
                                    </a>
                                    <a href="javascript:void(0)"
                                        class="group flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-sm font-medium text-slate-800 hover:bg-violet-50 hover:text-violet-600 active:border-violet-100">
                                        <span>Accounts</span>
                                    </a>
                                    <a href="javascript:void(0)"
                                        class="group flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-sm font-medium text-slate-800 hover:bg-violet-50 hover:text-violet-600 active:border-violet-100">
                                        <span>Cards</span>
                                    </a>
                                    <a href="javascript:void(0)"
                                        class="group flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-sm font-medium text-slate-800 hover:bg-violet-50 hover:text-violet-600 active:border-violet-100">
                                        <span>Settings</span>
                                    </a>
                                </nav>
                                <!-- END Desktop Navigation -->
                            </div>
                            <!-- END Left Section -->

                            <!-- Right Section -->
                            <div class="flex items-center gap-2">
                                <!-- User Dropdown -->
                                <div class="relative inline-block">
                                    <!-- Dropdown Toggle Button -->
                                    <button x-on:click="userDropdownOpen = true" x-bind:aria-expanded="userDropdownOpen"
                                        type="button" id="tk-dropdown-layouts-user"
                                        class="inline-flex items-center justify-center gap-1 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold leading-5 text-slate-800 hover:border-violet-300 hover:text-violet-800 active:border-slate-200"
                                        aria-haspopup="true">
                                        <svg class="hi-mini hi-user-circle inline-block h-5 w-5 sm:hidden"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-5.5-2.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zM10 12a5.99 5.99 0 00-4.793 2.39A6.483 6.483 0 0010 16.5a6.483 6.483 0 004.793-2.11A5.99 5.99 0 0010 12z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <span class="hidden sm:inline">John Doe</span>
                                        <svg class="hi-mini hi-chevron-down hidden h-5 w-5 opacity-40 sm:inline-block"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <!-- END Dropdown Toggle Button -->

                                    <!-- Dropdown -->
                                    <div x-cloak x-show="userDropdownOpen"
                                        x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                        x-transition:leave="transition ease-in duration-100"
                                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                        x-on:click.outside="userDropdownOpen = false" role="menu"
                                        aria-labelledby="tk-dropdown-layouts-user"
                                        class="absolute end-0 z-10 mt-2 w-48 rounded-lg shadow-xl ltr:origin-top-right rtl:origin-top-left">
                                        <div class="divide-y divide-slate-100 rounded-lg bg-white ring-1 ring-black/5">
                                            <div class="space-y-1 p-2.5">
                                                <a role="menuitem" href="javascript:void(0)"
                                                    class="group flex items-center justify-between gap-2 rounded-lg px-2.5 py-2 text-sm font-medium text-slate-700 hover:bg-violet-50 hover:text-violet-800">
                                                    <svg class="hi-mini hi-user-circle inline-block h-5 w-5 flex-none opacity-25 group-hover:opacity-50"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd"
                                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-5.5-2.5a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0zM10 12a5.99 5.99 0 00-4.793 2.39A6.483 6.483 0 0010 16.5a6.483 6.483 0 004.793-2.11A5.99 5.99 0 0010 12z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    <span class="grow">Account</span>
                                                </a>
                                                <a role="menuitem" href="javascript:void(0)"
                                                    class="group flex items-center justify-between gap-2 rounded-lg px-2.5 py-2 text-sm font-medium text-slate-700 hover:bg-violet-50 hover:text-violet-800">
                                                    <svg class="hi-mini hi-cog-6-tooth inline-block h-5 w-5 flex-none opacity-25 group-hover:opacity-50"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd"
                                                            d="M7.84 1.804A1 1 0 018.82 1h2.36a1 1 0 01.98.804l.331 1.652a6.993 6.993 0 011.929 1.115l1.598-.54a1 1 0 011.186.447l1.18 2.044a1 1 0 01-.205 1.251l-1.267 1.113a7.047 7.047 0 010 2.228l1.267 1.113a1 1 0 01.206 1.25l-1.18 2.045a1 1 0 01-1.187.447l-1.598-.54a6.993 6.993 0 01-1.929 1.115l-.33 1.652a1 1 0 01-.98.804H8.82a1 1 0 01-.98-.804l-.331-1.652a6.993 6.993 0 01-1.929-1.115l-1.598.54a1 1 0 01-1.186-.447l-1.18-2.044a1 1 0 01.205-1.251l1.267-1.114a7.05 7.05 0 010-2.227L1.821 7.773a1 1 0 01-.206-1.25l1.18-2.045a1 1 0 011.187-.447l1.598.54A6.993 6.993 0 017.51 3.456l.33-1.652zM10 13a3 3 0 100-6 3 3 0 000 6z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    <span class="grow">Settings</span>
                                                </a>
                                            </div>
                                            <div class="space-y-1 p-2.5">
                                                <form onsubmit="return false;">
                                                    <button type="submit" role="menuitem"
                                                        class="group flex w-full items-center justify-between gap-2 rounded-lg px-2.5 py-2 text-start text-sm font-medium text-slate-700 hover:bg-violet-50 hover:text-violet-800">
                                                        <svg class="hi-mini hi-lock-closed inline-block h-5 w-5 flex-none opacity-25 group-hover:opacity-50"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd"
                                                                d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        <span class="grow">Sign out</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END Dropdown -->
                                </div>
                                <!-- END User Dropdown -->

                                <!-- Alerts -->
                                <a href="javascript:void(0)"
                                    class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold leading-5 text-slate-800 hover:border-violet-300 hover:text-violet-800 active:border-slate-200">
                                    <svg class="hi-outline hi-bell-alert inline-block h-5 w-5"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0M3.124 7.5A8.969 8.969 0 015.292 3m13.416 0a8.969 8.969 0 012.168 4.5" />
                                    </svg>
                                </a>
                                <!-- END Alerts -->

                                <!-- Toggle Mobile Navigation -->
                                <div class="lg:hidden">
                                    <button x-on:click="mobileNavOpen = !mobileNavOpen" type="button"
                                        class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold leading-5 text-slate-800 hover:border-violet-300 hover:text-violet-800 active:border-slate-200">
                                        <svg fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="hi-solid hi-menu inline-block h-5 w-5">
                                            <path fill-rule="evenodd"
                                                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>
                                <!-- END Toggle Mobile Navigation -->
                            </div>
                            <!-- END Right Section -->
                        </div>

                        <!-- Mobile Navigation -->
                        <div x-cloak x-show="mobileNavOpen" class="lg:hidden">
                            <nav class="flex flex-col gap-2 border-t border-slate-200 py-4">
                                <a href="javascript:void(0)"
                                    class="group flex items-center gap-2 rounded-lg border border-violet-50 bg-violet-50 px-2.5 py-1.5 text-sm font-semibold text-violet-600">
                                    <span>Dashboard</span>
                                </a>
                                <a href="javascript:void(0)"
                                    class="group flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-sm font-medium text-slate-800 hover:bg-violet-50 hover:text-violet-600 active:border-violet-100">
                                    <span>Accounts</span>
                                </a>
                                <a href="javascript:void(0)"
                                    class="group flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-sm font-medium text-slate-800 hover:bg-violet-50 hover:text-violet-600 active:border-violet-100">
                                    <span>Cards</span>
                                </a>
                                <a href="javascript:void(0)"
                                    class="group flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-sm font-medium text-slate-800 hover:bg-violet-50 hover:text-violet-600 active:border-violet-100">
                                    <span>Profile</span>
                                </a>
                            </nav>
                        </div>
                        <!-- END Mobile Navigation -->
                    </div>
                </div>
            </header>
            <!-- END Page Header -->

            <!-- Page Content -->
            <main id="page-content" class="flex max-w-full flex-auto flex-col">
                <!-- Page Heading -->
                <div class="container mx-auto px-4 pt-6 lg:px-8 lg:pt-8 xl:max-w-7xl">
                    <div
                        class="flex flex-col gap-2 text-center sm:flex-row sm:items-center sm:justify-between sm:text-start">
                        <div class="grow">
                            <h1 class="mb-1 text-xl font-bold">Quick Overview</h1>
                            <h2 class="text-sm font-medium text-slate-500">
                                Welcome to your personal e-banking dashboard.
                            </h2>
                        </div>
                        <div
                            class="flex flex-none items-center justify-center gap-2 rounded px-2 sm:justify-end sm:bg-transparent sm:px-0">
                            <a href="javascript:void(0)"
                                class="inline-flex items-center justify-center gap-1 rounded-lg border border-violet-700 bg-violet-700 px-3 py-2 text-sm font-semibold leading-5 text-white hover:border-violet-600 hover:bg-violet-600 hover:text-white focus:ring focus:ring-violet-400/50 active:border-violet-700 active:bg-violet-700">
                                <span>New request</span>
                            </a>
                            <a href="javascript:void(0)"
                                class="inline-flex items-center justify-center gap-1 rounded-lg border border-violet-700 bg-violet-700 px-3 py-2 text-sm font-semibold leading-5 text-white hover:border-violet-600 hover:bg-violet-600 hover:text-white focus:ring focus:ring-violet-400/50 active:border-violet-700 active:bg-violet-700">
                                <span>New transfer</span>
                            </a>
                        </div>
                    </div>
                    <hr class="mt-6 lg:mt-8" />
                </div>
                <!-- END Page Heading -->

                <!-- Page Section -->
                <div class="container mx-auto p-4 lg:p-8 xl:max-w-7xl">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3 lg:gap-8">
                        <!-- Quick Statistics -->
                        <a href="javascript:void(0)"
                            class="flex flex-col rounded-lg border border-slate-200 bg-white hover:border-slate-300 active:border-violet-300">
                            <div class="flex grow items-center justify-between p-5">
                                <dl>
                                    <dt class="text-2xl font-bold">$112,768</dt>
                                    <dd class="text-sm font-medium text-slate-500">
                                        Total Balance
                                    </dd>
                                </dl>
                                <div
                                    class="flex h-12 w-12 items-center justify-center rounded-xl border border-violet-100 bg-violet-50 text-violet-500">
                                    <svg class="hi-outline hi-currency-dollar inline-block h-6 w-6"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="border-t border-slate-100 px-5 py-3 text-xs font-medium text-slate-500">
                                <p>From all accounts</p>
                            </div>
                        </a>
                        <a href="javascript:void(0)"
                            class="flex flex-col rounded-lg border border-slate-200 bg-white hover:border-slate-300 active:border-emerald-300">
                            <div class="flex grow items-center justify-between p-5">
                                <dl>
                                    <dt class="text-2xl font-bold">$6,840</dt>
                                    <dd class="text-sm font-medium text-slate-500">Income</dd>
                                </dl>
                                <div
                                    class="flex h-12 w-12 items-center justify-center rounded-xl border border-emerald-100 bg-emerald-50 text-emerald-500">
                                    <svg class="hi-outline hi-arrow-trending-up inline-block h-6 w-6"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                                    </svg>
                                </div>
                            </div>
                            <div class="border-t border-slate-100 px-5 py-3 text-xs font-medium text-slate-500">
                                <p>This month</p>
                            </div>
                        </a>
                        <a href="javascript:void(0)"
                            class="flex flex-col rounded-lg border border-slate-200 bg-white hover:border-slate-300 active:border-rose-300">
                            <div class="flex grow items-center justify-between p-5">
                                <dl>
                                    <dt class="text-2xl font-bold">$4,725</dt>
                                    <dd class="text-sm font-medium text-slate-500">Expenses</dd>
                                </dl>
                                <div
                                    class="flex h-12 w-12 items-center justify-center rounded-xl border border-rose-100 bg-rose-50 text-rose-500">
                                    <svg class="hi-outline hi-arrow-trending-down inline-block h-6 w-6"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 6L9 12.75l4.286-4.286a11.948 11.948 0 014.306 6.43l.776 2.898m0 0l3.182-5.511m-3.182 5.51l-5.511-3.181" />
                                    </svg>
                                </div>
                            </div>
                            <div class="border-t border-slate-100 px-5 py-3 text-xs font-medium text-slate-500">
                                <p>This month</p>
                            </div>
                        </a>
                        <!-- END Quick Statistics -->

                        <!-- Transactions -->
                        <div class="flex flex-col rounded-lg border bg-white md:col-span-3">
                            <div
                                class="flex flex-col items-center justify-between gap-4 border-b border-slate-100 p-5 text-center sm:flex-row sm:text-start">
                                <div>
                                    <h2 class="mb-0.5 font-semibold">Recent Transactions</h2>
                                    <h3 class="text-sm font-medium text-slate-600">
                                        All your recent transactions in one place
                                    </h3>
                                </div>
                                <div>
                                    <a href="javascript:void(0)"
                                        class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold leading-5 text-slate-800 hover:border-violet-300 hover:text-violet-800 active:border-slate-200">
                                        View all transactions
                                    </a>
                                </div>
                            </div>
                            <div class="p-5">
                                <!-- Responsive Table Container -->
                                <div class="min-w-full overflow-x-auto rounded">
                                    <!-- Alternate Responsive Table -->
                                    <table class="min-w-full align-middle text-sm">
                                        <!-- Table Header -->
                                        <thead>
                                            <tr class="border-b-2 border-slate-100">
                                                <th
                                                    class="min-w-[180px] py-3 pe-3 text-start text-sm font-semibold uppercase tracking-wider text-slate-700">
                                                    Date
                                                </th>
                                                <th
                                                    class="min-w-[180px] px-3 py-2 text-start text-sm font-semibold uppercase tracking-wider text-slate-700">
                                                    Account
                                                </th>
                                                <th
                                                    class="min-w-[180px] px-3 py-2 text-start text-sm font-semibold uppercase tracking-wider text-slate-700">
                                                    Description
                                                </th>
                                                <th
                                                    class="min-w-[180px] px-3 py-2 text-start text-sm font-semibold uppercase tracking-wider text-slate-700">
                                                    Category
                                                </th>
                                                <th
                                                    class="px-3 py-2 text-start text-sm font-semibold uppercase tracking-wider text-slate-700">
                                                    Amount
                                                </th>
                                                <th
                                                    class="min-w-[100px] py-2 ps-3 text-end text-sm font-semibold uppercase tracking-wider text-slate-700">
                                                    Actions
                                                </th>
                                            </tr>
                                        </thead>
                                        <!-- END Table Header -->

                                        <!-- Table Body -->
                                        <tbody>
                                            <tr class="border-b border-slate-100">
                                                <td class="py-3 pe-3 text-start text-slate-600">
                                                    2023-09-15 09:30
                                                </td>
                                                <td class="p-3">
                                                    <a href="javascript:void(0)"
                                                        class="font-medium text-violet-500 hover:text-violet-700">Savings
                                                        (****543210)</a>
                                                </td>
                                                <td class="p-3 font-medium text-slate-600">
                                                    Johnson's Pharmacy
                                                </td>
                                                <td class="p-3 text-start">Healthcare</td>
                                                <td class="p-3 font-medium">
                                                    <div
                                                        class="inline-block rounded-full bg-rose-100 px-2 py-1 text-xs font-semibold leading-4 text-rose-800">
                                                        -$200.00
                                                    </div>
                                                </td>
                                                <td class="py-3 ps-3 text-end font-medium">
                                                    <a href="javascript:void(0)"
                                                        class="group inline-flex items-center gap-1 rounded-lg border border-slate-200 px-2.5 py-1.5 font-medium text-slate-800 hover:border-violet-300 hover:text-violet-800 active:border-slate-200">
                                                        <span>View</span>
                                                        <svg class="hi-mini hi-arrow-right inline-block h-5 w-5 text-slate-400 group-hover:text-violet-600 group-active:translate-x-0.5"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd"
                                                                d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr class="border-b border-slate-100">
                                                <td class="py-3 pe-3 text-start text-slate-600">
                                                    2023-09-10 14:15
                                                </td>
                                                <td class="p-3">
                                                    <a href="javascript:void(0)"
                                                        class="font-medium text-violet-500 hover:text-violet-700">Current
                                                        (****567890)</a>
                                                </td>
                                                <td class="p-3 font-medium text-slate-600">
                                                    Monthly Bonus from ABC Inc
                                                </td>
                                                <td class="p-3 text-start">Bonus</td>
                                                <td class="p-3 font-medium">
                                                    <div
                                                        class="inline-block rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold leading-4 text-emerald-800">
                                                        +$1,000.00
                                                    </div>
                                                </td>
                                                <td class="py-3 ps-3 text-end font-medium">
                                                    <a href="javascript:void(0)"
                                                        class="group inline-flex items-center gap-1 rounded-lg border border-slate-200 px-2.5 py-1.5 font-medium text-slate-800 hover:border-violet-300 hover:text-violet-800 active:border-slate-200">
                                                        <span>View</span>
                                                        <svg class="hi-mini hi-arrow-right inline-block h-5 w-5 text-slate-400 group-hover:text-violet-600 group-active:translate-x-0.5"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd"
                                                                d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr class="border-b border-slate-100">
                                                <td class="py-3 pe-3 text-start text-slate-600">
                                                    2023-09-05 17:45
                                                </td>
                                                <td class="p-3">
                                                    <a href="javascript:void(0)"
                                                        class="font-medium text-violet-500 hover:text-violet-700">Savings
                                                        (****543210)</a>
                                                </td>
                                                <td class="p-3 font-medium text-slate-600">
                                                    Gas Refill at PetroFuel
                                                </td>
                                                <td class="p-3 text-start">Transportation</td>
                                                <td class="p-3 font-medium">
                                                    <div
                                                        class="inline-block rounded-full bg-rose-100 px-2 py-1 text-xs font-semibold leading-4 text-rose-800">
                                                        -$30.00
                                                    </div>
                                                </td>
                                                <td class="py-3 ps-3 text-end font-medium">
                                                    <a href="javascript:void(0)"
                                                        class="group inline-flex items-center gap-1 rounded-lg border border-slate-200 px-2.5 py-1.5 font-medium text-slate-800 hover:border-violet-300 hover:text-violet-800 active:border-slate-200">
                                                        <span>View</span>
                                                        <svg class="hi-mini hi-arrow-right inline-block h-5 w-5 text-slate-400 group-hover:text-violet-600 group-active:translate-x-0.5"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd"
                                                                d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr class="border-b border-slate-100">
                                                <td class="py-3 pe-3 text-start text-slate-600">
                                                    2023-08-30 08:00
                                                </td>
                                                <td class="p-3">
                                                    <a href="javascript:void(0)"
                                                        class="font-medium text-violet-500 hover:text-violet-700">Savings
                                                        (****543210)</a>
                                                </td>
                                                <td class="p-3 font-medium text-slate-600">
                                                    Savings Interest Payment
                                                </td>
                                                <td class="p-3 text-start">Interest</td>
                                                <td class="p-3 font-medium">
                                                    <div
                                                        class="inline-block rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold leading-4 text-emerald-800">
                                                        +$25.00
                                                    </div>
                                                </td>
                                                <td class="py-3 ps-3 text-end font-medium">
                                                    <a href="javascript:void(0)"
                                                        class="group inline-flex items-center gap-1 rounded-lg border border-slate-200 px-2.5 py-1.5 font-medium text-slate-800 hover:border-violet-300 hover:text-violet-800 active:border-slate-200">
                                                        <span>View</span>
                                                        <svg class="hi-mini hi-arrow-right inline-block h-5 w-5 text-slate-400 group-hover:text-violet-600 group-active:translate-x-0.5"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd"
                                                                d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr class="border-b border-slate-100">
                                                <td class="py-3 pe-3 text-start text-slate-600">
                                                    2023-08-25 20:20
                                                </td>
                                                <td class="p-3">
                                                    <a href="javascript:void(0)"
                                                        class="font-medium text-violet-500 hover:text-violet-700">Savings
                                                        (****543210)</a>
                                                </td>
                                                <td class="p-3 font-medium text-slate-600">
                                                    Dinner at Bistro
                                                </td>
                                                <td class="p-3 text-start">Entertainment</td>
                                                <td class="p-3 font-medium">
                                                    <div
                                                        class="inline-block rounded-full bg-rose-100 px-2 py-1 text-xs font-semibold leading-4 text-rose-800">
                                                        -$40.00
                                                    </div>
                                                </td>
                                                <td class="py-3 ps-3 text-end font-medium">
                                                    <a href="javascript:void(0)"
                                                        class="group inline-flex items-center gap-1 rounded-lg border border-slate-200 px-2.5 py-1.5 font-medium text-slate-800 hover:border-violet-300 hover:text-violet-800 active:border-slate-200">
                                                        <span>View</span>
                                                        <svg class="hi-mini hi-arrow-right inline-block h-5 w-5 text-slate-400 group-hover:text-violet-600 group-active:translate-x-0.5"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd"
                                                                d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr class="border-b border-slate-100">
                                                <td class="py-3 pe-3 text-start text-slate-600">
                                                    2023-09-10 14:15
                                                </td>
                                                <td class="p-3">
                                                    <a href="javascript:void(0)"
                                                        class="font-medium text-violet-500 hover:text-violet-700">Current
                                                        (****567890)</a>
                                                </td>
                                                <td class="p-3 font-medium text-slate-600">
                                                    Freelance Web Design for XYZ
                                                </td>
                                                <td class="p-3 text-start">Freelance</td>
                                                <td class="p-3 font-medium">
                                                    <div
                                                        class="inline-block rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold leading-4 text-emerald-800">
                                                        +$3,100.00
                                                    </div>
                                                </td>
                                                <td class="py-3 ps-3 text-end font-medium">
                                                    <a href="javascript:void(0)"
                                                        class="group inline-flex items-center gap-1 rounded-lg border border-slate-200 px-2.5 py-1.5 font-medium text-slate-800 hover:border-violet-300 hover:text-violet-800 active:border-slate-200">
                                                        <span>View</span>
                                                        <svg class="hi-mini hi-arrow-right inline-block h-5 w-5 text-slate-400 group-hover:text-violet-600 group-active:translate-x-0.5"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd"
                                                                d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr class="border-b border-slate-100">
                                                <td class="py-3 pe-3 text-start text-slate-600">
                                                    2023-08-15 09:15
                                                </td>
                                                <td class="p-3">
                                                    <a href="javascript:void(0)"
                                                        class="font-medium text-violet-500 hover:text-violet-700">Savings
                                                        (****543210)</a>
                                                </td>
                                                <td class="p-3 font-medium text-slate-600">
                                                    Rent Payment to Green Properties
                                                </td>
                                                <td class="p-3 text-start">Housing</td>
                                                <td class="p-3 font-medium">
                                                    <div
                                                        class="inline-block rounded-full bg-rose-100 px-2 py-1 text-xs font-semibold leading-4 text-rose-800">
                                                        -$1,700.00
                                                    </div>
                                                </td>
                                                <td class="py-3 ps-3 text-end font-medium">
                                                    <a href="javascript:void(0)"
                                                        class="group inline-flex items-center gap-1 rounded-lg border border-slate-200 px-2.5 py-1.5 font-medium text-slate-800 hover:border-violet-300 hover:text-violet-800 active:border-slate-200">
                                                        <span>View</span>
                                                        <svg class="hi-mini hi-arrow-right inline-block h-5 w-5 text-slate-400 group-hover:text-violet-600 group-active:translate-x-0.5"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd"
                                                                d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr class="border-b border-slate-100">
                                                <td class="py-3 pe-3 text-start text-slate-600">
                                                    2023-08-10 16:30
                                                </td>
                                                <td class="p-3">
                                                    <a href="javascript:void(0)"
                                                        class="font-medium text-violet-500 hover:text-violet-700">Savings
                                                        (****543210)</a>
                                                </td>
                                                <td class="p-3 font-medium text-slate-600">
                                                    Clothing Store Purchase at Fashion World
                                                </td>
                                                <td class="p-3 text-start">Clothing</td>
                                                <td class="p-3 font-medium">
                                                    <div
                                                        class="inline-block rounded-full bg-rose-100 px-2 py-1 text-xs font-semibold leading-4 text-rose-800">
                                                        -$75.00
                                                    </div>
                                                </td>
                                                <td class="py-3 ps-3 text-end font-medium">
                                                    <a href="javascript:void(0)"
                                                        class="group inline-flex items-center gap-1 rounded-lg border border-slate-200 px-2.5 py-1.5 font-medium text-slate-800 hover:border-violet-300 hover:text-violet-800 active:border-slate-200">
                                                        <span>View</span>
                                                        <svg class="hi-mini hi-arrow-right inline-block h-5 w-5 text-slate-400 group-hover:text-violet-600 group-active:translate-x-0.5"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd"
                                                                d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr class="border-b border-slate-100">
                                                <td class="py-3 pe-3 text-start text-slate-600">
                                                    2023-08-05 14:00
                                                </td>
                                                <td class="p-3">
                                                    <a href="javascript:void(0)"
                                                        class="font-medium text-violet-500 hover:text-violet-700">Savings
                                                        (****543210)</a>
                                                </td>
                                                <td class="p-3 font-medium text-slate-600">
                                                    Grocery Shopping at FreshMart
                                                </td>
                                                <td class="p-3 text-start">Food</td>
                                                <td class="p-3 font-medium">
                                                    <div
                                                        class="inline-block rounded-full bg-rose-100 px-2 py-1 text-xs font-semibold leading-4 text-rose-800">
                                                        -$150.00
                                                    </div>
                                                </td>
                                                <td class="py-3 ps-3 text-end font-medium">
                                                    <a href="javascript:void(0)"
                                                        class="group inline-flex items-center gap-1 rounded-lg border border-slate-200 px-2.5 py-1.5 font-medium text-slate-800 hover:border-violet-300 hover:text-violet-800 active:border-slate-200">
                                                        <span>View</span>
                                                        <svg class="hi-mini hi-arrow-right inline-block h-5 w-5 text-slate-400 group-hover:text-violet-600 group-active:translate-x-0.5"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd"
                                                                d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr class="border-b border-slate-100">
                                                <td class="py-3 pe-3 text-start text-slate-600">
                                                    2023-08-01 11:45
                                                </td>
                                                <td class="p-3">
                                                    <a href="javascript:void(0)"
                                                        class="font-medium text-violet-500 hover:text-violet-700">Current
                                                        (****567890)</a>
                                                </td>
                                                <td class="p-3 font-medium text-slate-600">
                                                    Salary Deposit from XYZ Inc
                                                </td>
                                                <td class="p-3 text-start">Salary</td>
                                                <td class="p-3 font-medium">
                                                    <div
                                                        class="inline-block rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold leading-4 text-emerald-800">
                                                        +$3,700.00
                                                    </div>
                                                </td>
                                                <td class="py-3 ps-3 text-end font-medium">
                                                    <a href="javascript:void(0)"
                                                        class="group inline-flex items-center gap-1 rounded-lg border border-slate-200 px-2.5 py-1.5 font-medium text-slate-800 hover:border-violet-300 hover:text-violet-800 active:border-slate-200">
                                                        <span>View</span>
                                                        <svg class="hi-mini hi-arrow-right inline-block h-5 w-5 text-slate-400 group-hover:text-violet-600 group-active:translate-x-0.5"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd"
                                                                d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <!-- END Table Body -->
                                    </table>
                                    <!-- END Alternate Responsive Table -->
                                </div>
                                <!-- END Responsive Table Container -->
                            </div>
                        </div>
                        <!-- END Transactions -->
                    </div>
                </div>
                <!-- END Page Section -->
            </main>
            <!-- END Page Content -->

            <!-- Page Footer -->
            <footer id="page-footer" class="flex flex-none items-center py-5">
                <div
                    class="container mx-auto flex flex-col px-4 text-center text-sm md:flex-row md:justify-between md:text-start lg:px-8 xl:max-w-7xl">
                    <div class="pb-1 pt-4 md:pb-4">
                        <span class="font-medium">TailBank</span>
                        ©
                    </div>
                    <div class="inline-flex items-center justify-center pb-4 pt-1 md:pt-4">
                        <span>Crafted with</span>
                        <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"
                            class="hi-solid hi-heart mx-1 inline-block h-4 w-4 text-red-600">
                            <path fill-rule="evenodd"
                                d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span>
                            by
                            <a href="https://pixelcave.com" class="font-medium text-violet-600 hover:text-violet-400"
                                target="_blank">pixelcave</a></span>
                    </div>
                </div>
            </footer>
            <!-- END Page Footer -->
        </div>
        <!-- END Page Container -->
    </div>
</body>
