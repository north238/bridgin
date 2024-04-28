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
                <h1 class="mb-1 text-xl font-bold">資産データ</h1>
                <h2 class="text-md font-medium text-slate-500">
                    ようこそ、ここからすべての資産へアクセスできます
                </h2>
            </div>
            <div
                class="flex flex-none items-center justify-center gap-2 rounded px-2 sm:justify-end sm:bg-transparent sm:px-0">
                <a href="{{ route('assets.create') }}"
                    class="inline-flex items-center justify-center gap-1 rounded-lg border border-green-400 bg-green-400 px-3 py-2 text-sm font-semibold leading-5 text-white hover:border-green-300 hover:bg-green-300 hover:text-white focus:ring focus:ring-green-400/50 active:border-green-400 active:bg-green-400">
                    <span>資産の登録</span>
                </a>
                <a href="javascript:void(0)"
                    class="inline-flex items-center justify-center gap-1 rounded-lg border border-green-400 bg-green-400 px-3 py-2 text-sm font-semibold leading-5 text-white hover:border-green-300 hover:bg-green-300 hover:text-white focus:ring focus:ring-green-400/50 active:border-green-400 active:bg-green-400">
                    <span>New transfer</span>
                </a>
            </div>
        </div>
        <hr class="h-px my-6 bg-gray-200 border-1 dark:bg-gray-700">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3 lg:gap-8">
            @include('pages.yearly-assets-total-card')
            @include('pages.current-month-asset-card')
            @include('pages.debut-amount-card')
        </div>
        <div class="pt-6">
            @include('pages.m-yearly-table')
        </div>
    </div>
</x-app-layout>
