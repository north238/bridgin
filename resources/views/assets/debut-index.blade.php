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
    @php
        if (empty($latestMonthDate)) {
            $latestMonthDate = now();
        }
        $firstDayOfMonth = date('Y-m-01', strtotime($latestMonthDate));
        $lastDayOfMonth = date('Y-m-t', strtotime($latestMonthDate));
        $monthSelectorVal = $firstDayOfMonth . ' ~ ' . $lastDayOfMonth;
        $isDebutAssetsDataEmpty = $debutAssetData->isEmpty();
    @endphp
    <div class="container mx-auto p-4 lg:p-8 xl:max-w-7xl dark:bg-dark_bg">
        <div class="px-2">
            <h1 class="mb-1 text-2xl font-semibold text-slate-700 dark:text-white">{{ __('debut_data') }}</h1>
            <p class="flex items-center text-sm sm:text-base text-slate-800 dark:text-white">
                <span class="w-1.5 h-1.5 bg-blue-600 rounded-full me-1.5"></span>{{ __('total_amount') }}:&nbsp;<span
                    class="text-rose-500">{{ number_format($debutTotalAmount) }}&nbsp;{{ __('jpy') }}</span>
            </p>
            <p class="flex items-center text-sm sm:text-base text-slate-800 dark:text-white"><span
                    class="w-1.5 h-1.5 bg-blue-600 rounded-full me-1.5"></span>{{ __('period') }}&nbsp;{{ $monthSelectorVal }}
            </p>
        </div>
        <hr class="h-px mb-3 mt-3 bg-gray-200 border-1 dark:border-dark_border dark:bg-dark_bg">
        <div class="px-2 mb-2 flex items-end justify-between">
            <p class="text-sm sm:text-base text-slate-700 dark:text-white">
                {{ __('total_count') }}:&nbsp;{{ $totalCount }}<span>{{ __('count') }}</span>
            </p>
            <x-search-month :value="$latestMonthDate" status="1" />
        </div>
        @include('pages.m-debut-table')
    </div>

</x-app-layout>
