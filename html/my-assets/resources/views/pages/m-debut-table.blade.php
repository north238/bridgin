<div
    class="flex flex-col rounded-lg overflow-hidden border dark:border-dark_border bg-white md:col-span-3 dark:bg-dark_table">
    @if ($isDebutAssetsDataEmpty === true)
        <div class="bg-white dark:bg-dark_table sm:rounded-lg overflow-hidden">
            <div class="flex flex-col justify-center items-center w-full p-6">
                <div class="text-slate-700 dark:text-white">
                    {{ __('empty_data_message') }}
                </div>
                <a href="{{ route('assets.create') }}" class="mt-2 text-sm sm:text-base font-medium">
                    資産登録は<span class="text-blue-600 dark:text-blue-500 hover:underline">こちら</span><i
                        class="fa-solid fa-angle-right text-blue-600 dark:text-blue-500 ml-2"></i>
                </a>
            </div>
        </div>
    @else
        <div class="p-5">
            <div class="scrollbar-custom overflow-x-auto min-w-full rounded dark:border-dark_border">
                <table class="text-sm  align-middle min-w-full">
                    <thead class="dark:bg-dark_table">
                        <tr class="border-b-2 border-slate-100 dark:border-dark_border">
                            <th scope="col"
                                class="min-w-[150px] px-3 py-2 text-start font-semibold text-slate-700 dark:text-white">
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
                                class="min-w-[150px] px-3 py-2 text-start font-semibold text-slate-700 dark:text-white">
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
                        @foreach ($debutAssetData as $asset)
                            <tr
                                class="border-b border-slate-100 dark:border-dark_border hover:bg-gray-50 dark:hover:bg-gray-600">
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
                                <td class="amount-cell px-3 py-3 text-start font-medium text-rose-500">
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
    @endif
</div>
