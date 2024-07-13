@php
    $paginator = $displayAllData->links()->paginator;
@endphp
<div class="px-3 font-medium text-slate-600 dark:text-dark_sub_text">
    <p class="text-sm">
        {!! __('Showing') !!}
        @if ($paginator->firstItem())
            <span class="font-medium">{{ $paginator->firstItem() }}</span>
            {!! __('to') !!}
            <span class="font-medium">{{ $paginator->lastItem() }}</span>
        @else
            {{ $paginator->count() }}
        @endif
        {!! __('of') !!}
        <span class="font-medium">{{ $paginator->total() }}</span>
        {!! __('results') !!}
    </p>
</div>
<div class="flex flex-col rounded-lg border dark:border-dark_border bg-white dark:bg-dark_table md:col-span-3">
    <div class="flex items-center justify-between border-b border-slate-100 dark:border-dark_border py-3 px-6">
        <x-search-month :value="$latestMonthDate" status="0" />
        @if ($downloadData->isNotEmpty())
            <x-csv-download :assets="$downloadData"
                class="rounded-lg border border-gray-300 dark:border-dark_border dark:bg-dark_table" />
        @endif
    </div>
    {{-- 資産データがない場合の処理を追加 --}}
    @if ($displayAllData->isEmpty() !== true)
        <div class="p-5">
            <div class="scrollbar-custom overflow-x-auto min-w-full rounded">
                <table class="text-sm  align-middle min-w-full">
                    <thead class="dark:bg-dark_table">
                        <tr class="border-b-2 border-slate-100 dark:border-dark_border">
                            <th scope="col"
                                class="min-w-[120px] px-3 py-2 text-start font-semibold text-slate-700 dark:text-white">
                                <div class="flex items-center">
                                    {{ __('registration_date') }}
                                </div>
                            </th>
                            <th scope="col"
                                class="min-w-[180px] px-3 py-2 text-start font-semibold text-slate-700 dark:text-white">
                                {{ __('asset_name') }}</th>
                            <th scope="col"
                                class="min-w-[150px] px-3 py-2 text-start font-semibold text-slate-700 dark:text-white">
                                <div class="flex items-center">
                                    {{ __('genre_name') }}
                                </div>
                            </th>
                            <th scope="col"
                                class="min-w-[150px] px-3 py-2 text-start font-semibold text-slate-700 dark:text-white">
                                <div class="flex items-center">
                                    {{ __('category_name') }}
                                </div>
                            </th>
                            <th scope="col"
                                class="min-w-[120px] px-3 py-2 text-start font-semibold text-slate-700 dark:text-white">
                                <div class="flex items-center">
                                    {{ __('amount') }}
                                </div>
                            </th>
                            <th scope="col"
                                class="min-w-[100px] ps-3 py-2 text-start font-semibold text-slate-700 dark:text-white">
                                {{ __('action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($displayAllData as $asset)
                            <tr
                                class="border-b border-slate-100 dark:bg-dark_table dark:border-dark_border hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-3 py-3 text-start text-slate-600 dark:text-white">
                                    {{ $asset['registration_date'] }}</td>
                                <td class="text-slate-800 dark:text-white px-3 py-3 font-medium text-start">
                                    @if ($asset['asset_type_flg'] === 0)
                                        <i class="fa-solid fa-money-bill-trend-up text-green-500 me-1"></i>
                                    @else
                                        <i class="fa-solid fa-vault text-blue-600 me-1"></i>
                                    @endif
                                    {{ $asset['name'] }}
                                </td>
                                <td class="px-3 py-3 text-start text-slate-600 dark:text-white"
                                    data-genre_id="{{ $asset['genre_id'] }}">
                                    {{ $asset['genre_name'] }}
                                </td>
                                <td class="px-3 py-3 text-start text-slate-600 dark:text-white">
                                    {{ $asset['category_name'] }}
                                </td>
                                <td class="amount-cell px-3 py-3 text-start font-medium text-green-500">
                                    {{ number_format($asset['amount']) }}円</td>
                                <td class="ps-3 py-3 text-start">
                                    <a href="{{ route('assets.show', [$asset->asset_id]) }}" id="asset-edit"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline"><i
                                            class="fa-regular fa-pen-to-square mr-1"></i>
                                        {{ __('edit') }}</a>
                                </td>
                            </tr>
                        @endforeach
                </table>
            </div>
        </div>
    @else
        <div class="p-5">
            <div class="text-center text-slate-700 dark:text-white">
                {{ __('empty_data_message') }}
            </div>
        </div>
    @endif
</div>
