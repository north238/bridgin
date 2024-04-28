@php
    $prevMonth = date('Y-m', strtotime('-1 month', strtotime($month)));
    $nextMonth = date('Y-m', strtotime('1 month', strtotime($month)));
    $firstDayOfMonth = date('Y-m-01', strtotime($month));
    $lastDayOfMonth = date('Y-m-t', strtotime($month));
    $monthSelectorVal = $firstDayOfMonth . ' ~ ' . $lastDayOfMonth;
@endphp
<form id="month-form-data" class="flex flex-col sm:flex-row justify-around items-center" method="POST"
    action="{{ route('ajax.pagination.index') }}">
    @csrf
    <div>
        <button id="prev-month-btn"
            class="month-btn flex items-center px-4 h-10 me-2 mb-2 sm:mb-0 text-base font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-slate-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
            <svg class="w-3.5 h-3.5 me-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 14 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 5H1m0 0 4 4M1 5l4-4" />
            </svg>
            {{ __('prev_month') }}
        </button>
    </div>
    <div>
        <div id="month-data" class="relative w-full me-2 mb-2 sm:mb-0">
            <div class="absolute inset-y-2.5 start-0 ps-2 pointer-events-none">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14c.6 0 1-.4 1-1V7c0-.6-.4-1-1-1H5a1 1 0 0 0-1 1v12c0 .6.4 1 1 1Zm3-7h0v0h0v0Zm4 0h0v0h0v0Zm4 0h0v0h0v0Zm-8 4h0v0h0v0Zm4 0h0v0h0v0Zm4 0h0v0h0v0Z" />
                </svg>
            </div>
            <input type="text"
                class="block items-center ps-8 h-10 text-gray-500 bg-white border border-gray-300 text-sm font-medium rounded-lg dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                name="month-selecter" id="month-selecter" value="{{ $monthSelectorVal }}" disabled>
        </div>
    </div>
    <div>
        <button id="next-month-btn"
            class="month-btn flex items-center px-4 h-10 me-2 mb-2 sm:mb-0 text-base font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-slate-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
            {{ __('next_month') }}
            <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 14 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M1 5h12m0 0L9 1m4 4L9 9" />
            </svg>
        </button>
    </div>
    <div>
        <button id="now-month-btn"
            class="month-btn flex items-center px-4 h-10 mb-2 sm:mb-0 text-base font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-slate-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
            {{ __('now_month') }}
            <svg class="w-4 h-4 ms-2 text-gray-800 dark:text-white" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 9H8a5 5 0 0 0 0 10h9m4-10-4-4m4 4-4 4" />
            </svg>

        </button>
    </div>
    <input type="hidden" id="now-month" name="now-month" value="{{ $month }}">
    <input type="hidden" id="prev-month" name="prev-month" value="{{ $prevMonth }}">
    <input type="hidden" id="next-month" name="next-month" value="{{ $nextMonth }}">
    <input type="hidden" id="clicked-btn" name="clicked-btn">
</form>
