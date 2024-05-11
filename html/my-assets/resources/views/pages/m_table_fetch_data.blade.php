<div id="temp-m-assets-table" class="overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="font-medium text-gray-700 bg-gray-50 dark:bg-dark_bg dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    {{ __('asset_name') }}</th>
                <th scope="col" class="px-6 py-3">
                    <div class="flex items-center">
                        {{ __('category_name') }}
                        <a href="{{ route('sort.get') }}" id="category-sort" data-sort="{{ $sort }}"><svg
                                class="w-3 h-3 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                            </svg></a>
                    </div>
                </th>
                <th scope="col" class="px-6 py-3">
                    <div class="flex items-center">
                        {{ __('amount') }}
                        <a href="{{ route('sort.get') }}" id="amount-sort" data-sort="{{ $sort }}"><svg
                                class="w-3 h-3 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                            </svg></a>
                    </div>
                </th>
                <th scope="col" class="px-6 py-3">
                    <div class="flex items-center">
                        {{ __('registration_date') }}
                        <a href="{{ route('sort.get') }}" id="registration-date-sort"
                            data-sort="{{ $sort }}"><svg class="w-3 h-3 ms-1.5" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                            </svg></a>
                    </div>
                </th>
                <th scope="col" class="px-6 py-3">
                    {{ __('action') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($assets as $key => $asset)
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-dark_border hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="text-gray-900 dark:text-white border-t border-b border-gray-200 px-4 py-3 font-medium">
                        @if ($asset['asset_type_flg'] === 0)
                            <i class="fa-solid fa-money-bill-trend-up text-green-500 me-1"></i>
                        @else
                            <i class="fa-solid fa-vault text-blue-600 me-1"></i>
                        @endif
                        {{ $asset['name'] }}
                    </td>
                    <td class="border-t border-b border-gray-200 px-6 py-3">
                        {{ $asset['category']['name'] }}
                    </td>
                    <td class="border-t border-b border-gray-200 px-6 py-3">
                        {{ number_format($asset['amount']) }}円</td>
                    <td class="border-t border-b border-gray-200 px-6 py-3">
                        {{ $asset['registration_date'] }}</td>
                    <td class="border-t border-b border-gray-200 px-6 py-3">
                        <a href="{{ route('assets.show', [$asset->id]) }}" id="asset-edit"
                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline"><svg
                                class="w-5 h-5 inline-block align-bottom  text-gray-500 dark:text-white"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                            </svg>
                            {{ __('edit') }}</a>
                    </td>
                </tr>
            @endforeach
    </table>
</div>
