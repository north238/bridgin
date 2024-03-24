<x-app-layout>
    <div id="m-assets-table" class="block m-6 p-6 bg-white border border-gray-200 rounded-lg shadow">
        <x-slot name="header">
            <h2 class="font-semibold text-gray-800 leading-tight">
                {{ __('all_assets') }}
            </h2>
        </x-slot>
        <div>
            @if (session('success-message'))
                <x-alert-message name="success" color="green">
                    {{ session('success-message') }}
                </x-alert-message>
            @endif
        </div>
        <div class="flex justify-between items-center gap-4 ms-5 my-5">
            <div class="flex flex-row items-center gap-1">
                <h2 class="text-2xl font-medium title-font text-gray-900 dark:text-white"><svg
                        class="w-6 h-6 text-gray-800 dark:text-white inline" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8H5m12 0c.6 0 1 .4 1 1v2.6M17 8l-4-4M5 8a1 1 0 0 0-1 1v10c0 .6.4 1 1 1h12c.6 0 1-.4 1-1v-2.6M5 8l4-4 4 4m6 4h-4a2 2 0 1 0 0 4h4c.6 0 1-.4 1-1v-2c0-.6-.4-1-1-1Z" />
                    </svg>{{ __('total_amount') }}</h2>
                <p class="lg:w-2/3 text-base dark:text-white">
                <p class="text-xl">{{ number_format($totalAmount) }}<span>円</span></p>
                </p>
            </div>
            <div>
                <label class="inline-flex items-center me-5 cursor-pointer">
                    <input type="checkbox" value="" class="sr-only peer" checked>
                    <div
                        class="relative w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-yellow-300 dark:peer-focus:ring-yellow-800 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-yellow-400">
                    </div>
                    <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Toggle</span>
                </label>
            </div>
        </div>
        <div>
            @include('components.m_table')
        </div>
    </div>
</x-app-layout>
