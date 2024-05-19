<a href="{{route('assets.debut.index')}}"
    class="flex flex-col rounded-lg border border-slate-200 dark:border-dark_border bg-white dark:bg-dark_table hover:bg-rose-50 dark:hover:bg-gray-600 hover:border-slate-300 active:border-rose-300">
    <div class="flex grow items-center justify-between p-5">
        <dl>
            <dt class="text-2xl font-bold text-rose-500">{{ number_format($debutAssetTotalAmount) }}<span>&nbsp;円</span></dt>
            <dd class="text-md font-medium text-slate-500 dark:text-white mt-2">負債合計額</dd>
        </dl>
        <div
            class="flex h-12 w-12 items-center justify-center rounded-xl border border-rose-100 dark:border-dark_border bg-rose-50 dark:bg-rose-400 text-rose-500 dark:text-rose-300">
            <svg class="hi-outline hi-arrow-trending-down inline-block h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 6L9 12.75l4.286-4.286a11.948 11.948 0 014.306 6.43l.776 2.898m0 0l3.182-5.511m-3.182 5.51l-5.511-3.181" />
            </svg>
        </div>
    </div>
    <div class="flex justify-between border-t border-slate-100 dark:border-dark_border px-5 py-3 text-xs font-medium text-slate-500 dark:text-white">
        <p>{{$formatDate}}</p>
        <p class="text-blue-600 dark:text-blue-500 hover:underline">詳細を見る<i class="fa-solid fa-angle-right ml-2"></i></p>
    </div>
</a>
