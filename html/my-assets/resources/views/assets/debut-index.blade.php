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
    @php
        $firstDayOfMonth = date('Y-m-01', strtotime($latestMonthDate));
        $lastDayOfMonth = date('Y-m-t', strtotime($latestMonthDate));
        $monthSelectorVal = $firstDayOfMonth . ' ~ ' . $lastDayOfMonth;
        $isDebutAssetsDataEmpty = $debutAssetData->isEmpty();
    @endphp
    <div class="container mx-auto p-4 lg:p-8 xl:max-w-7xl dark:bg-dark_bg">
        <div class="flex flex-col px-2 gap-4 text-center sm:flex-row sm:items-center sm:justify-between sm:text-start">
            <div class="grow">
                <h1 class="mb-1 text-2xl text-slate-800 dark:text-white">
                    負債総額<span class="text-rose-500">&nbsp;{{ number_format($debutTotalAmount) }}&nbsp;円</span></h1>
                <h2 class="text-slate-800 dark:text-white">期間:&nbsp;{{ $monthSelectorVal }}</h2>
            </div>
            <div class="flex items-center justify-center">
                {{-- @include('components.search-month') --}}
            </div>
        </div>
        <hr class="h-px my-6 bg-gray-200 border-1 dark:border-dark_border dark:bg-dark_bg">
        @include('pages.m-debut-table')
    </div>

</x-app-layout>
