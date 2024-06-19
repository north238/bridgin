<div
    class="flex flex-col justify-between w-full bg-white rounded-lg border border-slate-200 dark:border-dark_border dark:bg-dark_table hover:border-slate-300 p-4 md:p-6">
    <div class="pb-9 mb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <div class="flex flex-row mb-1">
                <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white pe-1">年間チャート</h5>
                <svg data-popover-target="yearly-chart-info" data-popover-placement="bottom"
                    class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white cursor-pointer ms-1"
                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm0 16a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3Zm1-5.034V12a1 1 0 0 1-2 0v-1.418a1 1 0 0 1 1.038-.999 1.436 1.436 0 0 0 1.488-1.441 1.501 1.501 0 1 0-3-.116.986.986 0 0 1-1.037.961 1 1 0 0 1-.96-1.037A3.5 3.5 0 1 1 11 11.466Z" />
                </svg>
            </div>
            @php
                $monthArray = $assetsYearlyData['betweenMonthArray'];
                $firstDayOfMonth = date('Y-m-01', strtotime($monthArray[0]));
                $lastDayOfMonth = date('Y-m-t', strtotime($monthArray[1]));
                $monthSelectorVal = $firstDayOfMonth . ' ~ ' . $lastDayOfMonth;
            @endphp
            <p class="inline-flex items-center text-slate-800 dark:text-white"><span
                    class="w-1.5 h-1.5 bg-blue-600 rounded-full me-2"></span>期間:&nbsp;{{ $monthSelectorVal }}
            </p>
        </div>
        <div data-popover id="yearly-chart-info" role="tooltip"
            class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
            <div class="p-3 space-y-2">
                <h3 class="font-semibold text-gray-900 dark:text-white">年間チャート詳細</h3>
                <p>登録された資産を年単位で表示しています。チャートの特性上、登録されていない月の資産も表示されております。</p>
                <h3 class="font-semibold text-gray-900 dark:text-white">表示期間</h3>
                <p>表示期間は年単位です。表示期間を変更したい場合はグラフ下の検索窓に入力し検索してください。</p>
            </div>
            <div data-popper-arrow></div>
        </div>
    </div>

    @if ($assetsYearlyData['assetsYearlyData']->isEmpty())
        <div class="pb-3 flex justify-center items-center">
            検索結果はありません。データを登録してください。
        </div>
    @else
        <div class="pb-3 flex justify-center items-center dark:text-white my-5 h-full w-full mx-auto">
            <canvas id="yearly-chart"></canvas>
        </div>
    @endif

    <div class="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between">
        <div class="flex justify-between items-center pt-5">
            @php
                $yearArray = $assetsYearlyData['betweenMonthArray'];
                $displayYear = date('Y-m', strtotime($yearArray[0]));
            @endphp
            <form action="{{ route('asset-trend.search') }}" method="post" class="flex items-center">
                @csrf
                <div class="calender-input-icon">
                    <input type="month" name="search-year-date" id="search-year-date" value="{{ $displayYear }}"
                        class="py-3 border-0 border-b-2 border-gray-300 bg-transparent focus:border-blue-400 focus:outline-none appearance-non focus:ring-0 text-slate-600 block w-32 dark:border-gray-700 dark:text-white dark:focus:border-blue-500"
                        required>
                </div>
                <button type="submit"
                    class="text-gray-600 dark:text-white hover:transform hover:duration-200 hover:-translate-y-1"><i
                        class="fa-solid fa-magnifying-glass"></i><span class="sr-only">Search</span></button>
                <input type="hidden" id="first-day-of-year" name="first-day-of-year" value="{{ $displayYear }}">
            </form>
            <button type="button" data-modal-target="yearly-modal" data-modal-toggle="yearly-modal"
                class="inline-flex items-center rounded-lg text-blue-600 hover:text-blue-700 dark:hover:text-blue-500  hover:bg-gray-100 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700 px-3 py-2">
                データを見る
                <svg class="w-2.5 h-2.5 ms-1.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 9 4-4-4-4" />
                </svg>
            </button>
        </div>
    </div>
</div>

<x-chart-data-modal type="yearly" name="年間チャート詳細">
    <x-chart-yearly-data-table :data="$assetsYearlyData" />
</x-chart-data-modal>

@push('script-files')
    @vite(['resources/js/yearly-chart.js'])
@endpush
