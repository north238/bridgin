@props(['data'])

<div class="bg-white dark:bg-dark_table overflow-hidden">
    @if (false)
        <div class="bg-white dark:bg-dark_table sm:rounded-lg overflow-hidden">
            <div class="flex flex-col justify-center items-center w-full p-6">
                <div class="text-slate-700 dark:text-white">
                    登録されているデータはありません
                </div>
            </div>
        </div>
    @else
        <div class="scrollbar-custom overflow-x-auto min-w-full">
            <table class="text-sm align-middle min-w-full">
                <thead class="text-base bg-slate-500 dark:bg-dark_thead text-white dark:text-gray-400">
                    <tr class="border-b-2 border-slate-100 dark:border-dark_border">
                        <th scope="col" class="min-w-[180px] px-3 py-2 text-start font-semibold">
                            {{ __('asset_name') }}</th>
                        <th scope="col" class="min-w-[150px] px-3 py-2 text-start font-semibold">
                            {{ __('amount') }}<span class="font-medium text-xs">（円）</span>
                        </th>
                        <th scope="col" class="min-w-[110px] px-3 py-2 text-start font-semibold">
                            比率
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $arrays)
                        <tr
                            class="border-b border-slate-200 dark:bg-dark_table_genre dark:border-dark_border bg-gray-100 dark:hover:bg-gray-600">
                            <td class="p-3 text-start font-semibold text-slate-800 dark:text-white">
                                {{ $key }}<span class="font-medium text-xs">（ジャンル）</span>
                            </td>
                            <td class="text-slate-800 dark:text-white p-3 font-semibold text-start">
                                {{ number_format($arrays['fieldTotalAmountArray']) }}
                            </td>
                            <td class="text-slate-800 dark:text-white p-3 font-semibold text-start">
                                {{-- ここで割合を計算して表示 --}}
                                @php
                                    $totalSum = $data->pluck('fieldTotalAmountArray')->sum();
                                    $percentage =
                                        $totalSum != 0 ? ($arrays['fieldTotalAmountArray'] / $totalSum) * 100 : 0;
                                @endphp
                                {{ number_format($percentage, 2) }}%
                            </td>
                        </tr>
                        <tr
                            class="border-b border-slate-200 dark:bg-dark_table_tr dark:border-dark_border hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="p-3 pl-5 text-start text-slate-600 dark:text-gray-400">
                                @foreach ($arrays['assetNamesArray'] as $name)
                                    {{ $name }}<br>
                                @endforeach
                            </td>
                            <td class="p-3 text-start text-slate-600 dark:text-gray-400">
                                {{-- 配列の要素を金額として表示 --}}
                                @foreach ($arrays['totalAmountArray'] as $amount)
                                    {{ number_format($amount) }}<br>
                                @endforeach
                            </td>
                            <td class="p-3 text-start text-slate-600 dark:text-gray-400">
                                {{-- 配列の要素ごとに割合を表示 --}}
                                @foreach ($arrays['totalAmountArray'] as $amount)
                                    @php
                                        $percentage = $totalSum != 0 ? ($amount / $totalSum) * 100 : 0;
                                    @endphp
                                    {{ number_format($percentage, 2) }}%<br>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
