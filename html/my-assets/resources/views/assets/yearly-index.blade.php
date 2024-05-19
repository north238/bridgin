<x-app-layout>
    @if (session('success-message'))
        <div class="alert-message">
            <x-alert-message name="success" color="green">
                {{ session('success-message') }}
            </x-alert-message>
        </div>
    @endif
    <div class="container mx-auto p-4 lg:p-8 xl:max-w-7xl">
        <div class="flex flex-col gap-2 text-center sm:flex-row sm:items-center sm:justify-between sm:text-start">
            <div class="grow">
                <h1 class="mb-1 text-xl font-medium text-slate-900 dark:text-white">{{__('assets_data')}}</h1>
                <h2 class="text-sm sm:text-md font-medium text-slate-500 dark:text-white">
                    {{__('yearly_message')}}
                </h2>
            </div>
            <div
                class="flex items-center justify-center px-2">
                <a href="{{ route('assets.create') }}"
                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                    <span>{{__('asset_create_btn')}}</span><i class="fa-solid fa-angle-right ml-2"></i>
                </a>
            </div>
        </div>
        <hr class="h-px my-6 bg-gray-200 border-1 dark:border-dark_border dark:bg-dark_bg">
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
