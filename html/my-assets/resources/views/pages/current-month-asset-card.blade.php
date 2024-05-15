<a href="{{route('assets.currentMonth.index')}}"
    class="overflow-x-auto sm:rounded-lg rounded-lg border border-slate-200 dark:border-dark_border bg-white dark:bg-dark_table hover:bg-green-50 hover:border-slate-300 active:border-green-300">
    <div class="flex grow items-center justify-between p-5">
        <dl>
            <dt class="text-2xl font-bold">{{ number_format($latestMonthIncreaseDecreaseAmount) }}<span>&nbsp;円</span>
            </dt>
            <dd class="text-sm font-medium text-slate-500 dark:text-white mt-2">増減額</dd>
        </dl>
        <div
            class="flex h-12 w-12 items-center justify-center rounded-xl border border-green-100 dark:border-dark_border bg-green-50 dark:bg-green-600 text-green-500 dark:text-green-400">
            <svg class="hi-outline hi-arrow-trending-up inline-block h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
            </svg>
        </div>
    </div>
    <div class="border-t border-slate-100 dark:border-dark_border px-5 py-3 text-xs font-medium text-slate-500 dark:text-white">
        <p>増減額&nbsp;{{$formatDate}}</p>
    </div>
</a>
