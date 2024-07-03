<section id="assets-restore-table-section"
    class="flex flex-col rounded-lg border dark:border-dark_border bg-white dark:bg-dark_table md:col-span-3">
    @php
        $isRestoreDataNull = is_null($restoreAssetsData);
    @endphp
    @if ($isRestoreDataNull === true)
        <div class="bg-white dark:bg-dark_table sm:rounded-lg overflow-hidden">
            <div class="flex flex-col justify-center items-center w-full p-6">
                <div class="text-slate-700 dark:text-white">
                    削除されたデータはありません。
                </div>
            </div>
        </div>
    @else
        <div class="p-5">
            <div class="scrollbar-custom overflow-x-auto min-w-full rounded dark:border-dark_border">
                <table class="text-sm  align-middle min-w-full">
                    <thead class="dark:bg-dark_table">
                        <tr class="border-b-2 border-slate-100 dark:border-dark_border">
                            <th scope="col"
                                class="min-w-[180px] px-3 py-2 text-start font-semibold text-slate-700 dark:text-white">
                                {{ __('deleted_at') }}
                            </th>
                            <th scope="col"
                                class="min-w-[150px] px-3 py-2 text-start font-semibold text-slate-700 dark:text-white">
                                {{ __('asset_name') }}</th>
                            <th scope="col"
                                class="min-w-[150px] px-3 py-2 text-start font-semibold text-slate-700 dark:text-white">
                                {{ __('genre_name') }}
                            </th>
                            <th scope="col"
                                class="min-w-[150px] px-3 py-2 text-start font-semibold text-slate-700 dark:text-white">
                                {{ __('category_name') }}
                            </th>
                            <th scope="col"
                                class="min-w-[150px] px-3 py-2 text-start font-semibold text-slate-700 dark:text-white">
                                {{ __('amount') }}
                            </th>
                            <th scope="col"
                                class="min-w-[80px] py-2 text-start font-semibold text-slate-700 dark:text-white">
                                {{ __('action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($restoreAssetsData as $asset)
                            <tr
                                class="border-b border-slate-100 dark:bg-dark_table dark:border-dark_border hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-3 py-3 text-start text-slate-600 dark:text-white">
                                    {{ $asset['deleted_at'] }}</td>
                                <td class="px-3 py-3 text-start text-slate-600 dark:text-white">
                                    {{ $asset['name'] }}
                                </td>
                                <td class="px-3 py-3 text-start text-slate-600 dark:text-white">
                                    {{ $asset['genre_name'] }}
                                </td>
                                <td class="px-3 py-3 text-start text-slate-600 dark:text-white">
                                    {{ $asset['category_name'] }}
                                </td>
                                <td class="px-3 py-3 text-start text-slate-600 dark:text-white">
                                    {{ number_format($asset['amount']) }}円</td>
                                <td class="py-3 text-start text-slate-600 dark:text-white">
                                    <a href="{{ route('assets.restoreAsset', $asset['id']) }}"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline"><i
                                            class="fa-solid fa-trash-arrow-up mr-1"></i>
                                        {{ __('restore') }}</a>
                                </td>
                            </tr>
                        @endforeach
                </table>
            </div>
        </div>
    @endif
</section>
