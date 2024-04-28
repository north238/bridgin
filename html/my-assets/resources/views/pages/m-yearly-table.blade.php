<div class="flex flex-col rounded-lg border bg-white md:col-span-3">
    <div
        class="flex flex-col items-center justify-between gap-4 border-b border-slate-100 p-5 text-center sm:flex-row sm:text-start">
        <div>
            <h2 class="mb-0.5 font-semibold">登録済みの資産</h2>
            <h3 class="text-sm font-medium text-slate-600">
                直近のデータを表示しています
            </h3>
        </div>
        <div>
            <a href="javascript:void(0)"
                class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold leading-5 text-slate-800 hover:border-violet-300 hover:text-violet-800 active:border-slate-200">
                全件表示する
            </a>
        </div>
    </div>

    <div class="p-5">
        <div class="overflow-x-auto min-w-full rounded">
            <table class="text-sm  align-middle min-w-full">
                <thead class="dark:bg-gray-700">
                    <tr class="border-b-2 border-slate-100">
                        <th scope="col" class="min-w-[150px] px-3 py-2 text-start font-semibold text-slate-700 dark:text-white">
                            <div class="flex items-center">
                                {{ __('registration_date') }}
                            </div>
                        </th>
                        <th scope="col" class="min-w-[180px] px-3 py-2 text-start font-semibold text-slate-700 dark:text-white">
                            {{ __('asset_name') }}</th>
                        <th scope="col" class="min-w-[150px] px-3 py-2 text-start font-semibold text-slate-700 dark:text-white">
                            <div class="flex items-center">
                                {{ __('genre_name') }}
                                {{-- <a href="{{ route('sort.get') }}" id="genre-sort" data-sort="{{ $sort }}"><svg
                                        class="w-3 h-3 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                    </svg></a> --}}
                            </div>
                        </th>
                        <th scope="col" class="min-w-[150px] px-3 py-2 text-start font-semibold text-slate-700 dark:text-white">
                            <div class="flex items-center">
                                {{ __('category_name') }}
                                {{-- <a href="{{ route('sort.get') }}" id="category-sort"
                                    data-sort="{{ $sort }}"><svg class="w-3 h-3 ms-1.5" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                    </svg></a> --}}
                            </div>
                        </th>
                        <th scope="col" class="min-w-[150px] px-3 py-2 text-start font-semibold text-slate-700 dark:text-white">
                            <div class="flex items-center">
                                {{ __('amount') }}
                                {{-- <a href="{{ route('sort.get') }}" id="amount-sort" data-sort="{{ $sort }}"><svg
                                        class="w-3 h-3 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                    </svg></a> --}}
                            </div>
                        </th>
                        <th scope="col" class="min-w-[100px] ps-3 py-2 text-start font-semibold text-slate-700 dark:text-white">
                            {{ __('action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($assetsAllData as $asset)
                        <tr
                            class="border-b border-slate-100 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
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
</div>
