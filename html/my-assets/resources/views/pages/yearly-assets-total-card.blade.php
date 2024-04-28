<a href="{{route('assets.index')}}"
    class="overflow-x-auto sm:rounded-lg rounded-lg border border-slate-200 bg-white hover:bg-cyan-50 hover:border-slate-300 active:border-cyan-300">
    <div class="flex grow items-center justify-between p-5">
        <dl>
            <dt class="text-2xl font-bold">{{ number_format($totalAmounts) }}<span>&nbsp;円</span></dt>
            <dd class="text-sm font-medium text-slate-500 mt-2">総資産額</dd>
        </dl>
        <div
            class="flex h-12 w-12 items-center justify-center rounded-xl border border-cyan-100 bg-cyan-50 text-cyan-500">
            <svg class="hi-outline hi-currency-dollar inline-block h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
    </div>
    <div class="border-t border-slate-100 px-5 py-3 text-xs font-medium text-slate-500">
        <p>最新の資産合計額</p>
    </div>
</a>
