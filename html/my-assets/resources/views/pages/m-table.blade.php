<section id="m-assets-table-section">
    <div class="bg-white dark:bg-gray-800 rounded-lg border overflow-hidden">
        @if ($assetsByMonth->isEmpty())
            <div class="border border-slate-100 bg-white dark:bg-gray-800 shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex flex-col justify-center items-center w-full p-6">
                    <div class="">
                        今月のデータはありません。
                    </div>
                </div>
            </div>
        @else
            @foreach ($assetsByMonth as $month => $assets)
                @php
                    $firstDayOfMonth = date('Y-m-01', strtotime($month));
                    $lastDayOfMonth = date('Y-m-t', strtotime($month));
                    $monthSelectorVal = $firstDayOfMonth . '~' . $lastDayOfMonth;
                @endphp
                <div class="flex flex-col sm:flex-row sm:justify-between items-center p-6 border-b border-slate-100">
                    <div>
                        <h1 class="mb-1 text-2xl font-bold dark:text-white">{{ __('total_amount') }}</h1>
                        <h2 class="text-lg font-medium text-slate-500 dark:text-white">
                            {{ number_format($totalAmount) }}<span>&nbsp;円</span>
                        </h2>
                    </div>
                    <div>
                        <h2 class="text-lg font-medium text-slate-500 dark:text-white">
                            <i class="fa-regular fa-calendar mr-2"></i><span>{{ $monthSelectorVal }}</span>
                        </h2>
                    </div>
                    <div
                        class="flex flex-none items-center justify-center gap-2 rounded px-2 sm:justify-end sm:bg-transparent sm:px-0">
                        <form id="asset-switch-form" action="{{ route('assets.userDisplayMethodChange') }}"
                            method="post">
                            @csrf
                            <input type="hidden" id="debut-status" name="debut-status" value={{ $debutStatus }}>
                            <button type="submit"
                                class="inline-flex items-center justify-center gap-1 rounded-lg border border-green-400 bg-green-400 px-3 py-2 text-sm font-semibold leading-5 text-white hover:border-green-300 hover:bg-green-300 hover:text-white focus:ring focus:ring-green-400/50 active:border-green-400 active:bg-green-400">表示切替</button>
                        </form>
                        @include('components.csv-export')
                    </div>
                </div>

                @php
                    $sessionSort = Session::get('sortData');
                    $sort = json_encode($sessionSort);
                @endphp
                <div class="p-5">
                    <div id="m-assets-table" class="overflow-x-auto min-w-full rounded">
                        <table class="text-sm  align-middle min-w-full">
                            <thead class="dark:bg-gray-700">
                                <tr class="border-b-2 border-slate-100">
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
                                            {{-- <a href="{{ route('sort.get') }}" id="genre-sort" data-sort="{{ $sort }}"><svg
                                        class="w-3 h-3 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                    </svg></a> --}}
                                        </div>
                                    </th>
                                    <th scope="col"
                                        class="min-w-[150px] px-3 py-2 text-start font-semibold text-slate-700 dark:text-white">
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
                                    <th scope="col"
                                        class="min-w-[150px] px-3 py-2 text-start font-semibold text-slate-700 dark:text-white">
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
                                    <th scope="col"
                                        class="min-w-[100px] ps-3 py-2 text-start font-semibold text-slate-700 dark:text-white">
                                        {{ __('action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($assets as $asset)
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
            @endforeach
        @endif
</section>
