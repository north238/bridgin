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
            <x-alert-message name="error" color="red">
                {{ session('error-message') }}
            </x-alert-message>
        </div>
    @endif
    <div class="container mx-auto p-4 lg:p-8 xl:max-w-7xl dark:bg-dark_bg">
        <div class="flex flex-col px-2 gap-4 text-center sm:flex-row sm:items-center sm:justify-between sm:text-start">
            <div class="grow">
                <h1 class="mb-1 text-2xl text-slate-800 dark:text-white">
                    増減額データ</h1>
                <h2 class="text-slate-800 dark:text-white">各月の増減額が確認できます</h2>
            </div>
            <div class="flex items-center justify-center">
                {{-- @include('components.search-month') --}}
            </div>
        </div>
        <hr class="h-px my-6 bg-gray-200 border-1 dark:border-dark_border dark:bg-dark_bg">
        @include('pages.m-current-month-table')
    </div>

</x-app-layout>
