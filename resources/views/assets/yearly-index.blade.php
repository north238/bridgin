<x-app-layout>
    @if (session('success-message'))
        <div class="alert-message">
            <x-alert-message name="success" color="green">
                {{ session('success-message') }}
            </x-alert-message>
        </div>
    @endif
    @if (session('error-message'))
        <div class="alert-message">
            <x-alert-message name="error" color="rose">
                {{ session('error-message') }}
            </x-alert-message>
        </div>
    @endif
    <div class="container mx-auto p-4 lg:p-8 xl:max-w-7xl">
        <div class="flex flex-row items-center text-start">
            <div class="grow">
                <h1 class="text-2xl sm:text-2xl font-semibold text-slate-900 dark:text-white">{{__('assets_data')}}</h1>
            </div>
            <div
                class="flex items-center px-2">
                <a href="{{ route('assets.create') }}"
                    class="text-sm sm:text-base font-medium text-blue-600 dark:text-blue-500 hover:underline">
                    <span>{{__('asset_create_btn')}}</span><i class="fa-solid fa-angle-right ml-2"></i>
                </a>
            </div>
        </div>
        <hr class="h-px mb-6 mt-3 bg-gray-200 border-1 dark:border-dark_border dark:bg-dark_bg">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3 lg:gap-8">
            @include('pages.yearly-assets-total-card')
            @include('pages.current-month-asset-card')
            @include('pages.debut-amount-card')
        </div>
        <div class="pt-6">
            @include('pages.m-yearly-table')
        </div>
        @include('components.custom-pagination')
    </div>

    @push('script-files')
        @vite(['resources/js/chenged-color.js'])
    @endpush

</x-app-layout>
