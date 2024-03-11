<x-app-layout>
    <div id="m-assets-table">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('all_assets') }}
            </h2>
        </x-slot>
        @if (session('success-message'))
            <x-alert-message name="success" color="bg-green">
                {{ session('success-message') }}
            </x-alert-message>
        @endif
        <div class="flex flex-col text-center w-full my-5">
            <h1 class="sm:text-4xl text-3xl font-medium title-font mb-2 text-gray-900"><svg
                    class="w-7 h-7 text-gray-800 dark:text-white inline" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 8H5m12 0c.6 0 1 .4 1 1v2.6M17 8l-4-4M5 8a1 1 0 0 0-1 1v10c0 .6.4 1 1 1h12c.6 0 1-.4 1-1v-2.6M5 8l4-4 4 4m6 4h-4a2 2 0 1 0 0 4h4c.6 0 1-.4 1-1v-2c0-.6-.4-1-1-1Z" />
                </svg>{{ __('total_amount') }}</h1>
            <p class="lg:w-2/3 mx-auto leading-relaxed text-base">
            <p class="text-lg">{{ number_format($totalAmount) }}円</p>
            </p>
        </div>
        <div>
            @include('components.m_table')
        </div>
    </div>
</x-app-layout>
