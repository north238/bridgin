<a href="{{route('assets.index')}}"
    class="overflow-x-auto sm:rounded-lg rounded-lg border border-slate-200 dark:border-dark_border bg-white dark:bg-dark_table hover:bg-cyan-50 dark:hover:bg-gray-600 hover:border-slate-300 active:border-cyan-300">
    <div class="flex grow items-center justify-between p-5">
        <dl>
            <dt class="text-xl sm:text-2xl font-semibold">{{ number_format($monthlyTotalAmount) }}<span>&nbsp;円</span></dt>
            <dd class="text-sm sm:text-base font-medium text-slate-500 dark:text-white mt-2">資産合計額</dd>
        </dl>
        <div
            class="flex h-12 w-12 items-center justify-center rounded-xl border border-cyan-100 dark:border-dark_border bg-cyan-50 dark:bg-dark_cyan text-cyan-500 dark:text-cyan-300">
            <svg class="hi-outline hi-currency-dollar inline-block h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
    </div>
    <div class="flex justify-between border-t border-slate-100 dark:border-dark_border px-5 py-3 text-xs font-medium text-slate-500 dark:text-white">
        <p>{{$formatDate}}</p>
        <p class="text-blue-600 dark:text-blue-500 hover:underline">詳細を見る<i class="fa-solid fa-angle-right ml-2"></i></p>
    </div>
</a>
