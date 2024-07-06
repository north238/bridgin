@props(['data'])

<div class="scrollbar-custom overflow-y-auto bg-white dark:bg-dark_table overflow-hidden">
    @if ($data['assetsYearlyData']->isEmpty())
        <div class="bg-white dark:bg-dark_table sm:rounded-lg overflow-hidden">
            <div class="flex flex-col justify-center items-center w-full p-6">
                <div class="text-slate-600 dark:text-white">
                    {{ __('empty_data_message') }}
                </div>
            </div>
        </div>
    @else
        <div class="scrollbar-custom overflow-x-auto min-w-full">
            <table class="text-sm align-middle min-w-full">
                <thead class="text-sm sm:text-base bg-slate-500 dark:bg-dark_thead">
                    <tr class="border-b-2 border-slate-200 dark:border-dark_border text-white dark:text-gray-400">
                        <th scope="col" class="min-w-[100px] px-4 py-3 text-center font-semibold">
                            {{ __('year_month') }}</th>
                        <th scope="col" class="min-w-[130px] px-4 py-3 text-center font-semibold">
                            {{ __('asset_amount') }}<span class="font-medium text-xs">{{ __('JPY') }}</span>
                        </th>
                        <th scope="col" class="min-w-[130px] px-4 py-3 text-center font-semibold">
                            {{ __('debut_amount') }}<span class="font-medium text-xs">{{ __('JPY') }}</span>
                        </th>
                        </th>
                        <th scope="col" class="min-w-[130px] px-3 py-3 text-center font-semibold">
                            {{ __('total_asset_amount') }}<span class="font-medium text-xs">{{ __('JPY') }}</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['labels'] as $key => $item)
                        <tr
                            class="border-b border-slate-200 dark:border-dark_border bg-white dark:bg-dark_table hover:bg-slate-50 dark:hover:bg-gray-600">
                            <th scope="row" class="px-4 py-3 text-center text-slate-600 dark:text-white">
                                {{ $item }}
                            </th>
                            <td class="px-4 py-3 text-center text-green-500">
                                {{ number_format($data['assetsDataArray'][$key]) }}
                            </td>
                            <td class="px-4 py-3 text-center text-rose-500">
                                {{ number_format($data['debutDataArray'][$key]) }}
                            </td>
                            <td class="px-4 py-3 text-center text-slate-600 dark:text-white">
                                {{ number_format($data['yearlyDataArray'][$key]) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
