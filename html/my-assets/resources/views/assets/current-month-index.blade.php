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
        <div
            class="flex flex-col px-2 text-start items-start sm:flex-row sm:items-center sm:justify-between sm:text-start">
            <div class="grow">
                <h1 class="mb-1 text-xl font-bold text-slate-800 dark:text-white">
                    増減額データ</h1>
                <div>
                    <div class="flex items-center text-center text-sm sm:text-base text-slate-700 dark:text-white">
                        <span
                            class="inline-flex w-1.5 h-1.5 bg-blue-600 rounded-full me-1.5"></span>{{ __('total_amount') }}:&nbsp;{{ number_format($latestTotalAmount) }}<span>&nbsp;円</span>
                    </div>
                    <div class="flex items-center text-center text-sm sm:text-base text-slate-700 dark:text-white">
                        <span class="inline-flex w-1.5 h-1.5 bg-blue-600 rounded-full me-1.5"></span>期間:&nbsp;{{ $firstMonth }} ~
                        {{ $lastMonth }}
                    </div>
                </div>
            </div>
        </div>
        <hr class="h-px my-6 bg-gray-200 border-1 dark:border-dark_border dark:bg-dark_bg">
        @include('pages.m-current-month-table')
    </div>

</x-app-layout>
