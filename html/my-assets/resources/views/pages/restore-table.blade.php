<section id="assets-restore-table-section" class="flex flex-col rounded-lg border bg-white md:col-span-3">
    <div
        class="flex flex-col items-center justify-between gap-4 border-b border-slate-100 p-5 text-center sm:flex-row sm:text-start">
        <div>
            <h2 class="mb-0.5 font-semibold">削除済みの資産</h2>
            <h3 class="text-sm font-medium text-slate-600">
                削除されたデータを表示しています
            </h3>
        </div>
    </div>

    <div class="p-5">
        <div class="overflow-x-auto min-w-full rounded">
            <table class="text-sm  align-middle min-w-full">
                <thead class="dark:bg-gray-700">
                    <tr class="border-b-2 border-slate-100">
                        <th scope="col"
                            class="min-w-[150px] px-3 py-2 text-start font-semibold text-slate-700 dark:text-white">
                            {{ __('asset_name') }}</th>
                        <th scope="col"
                            class="min-w-[150px] px-3 py-2 text-start font-semibold text-slate-700 dark:text-white">
                            {{ __('amount') }}
                        </th>
                        <th scope="col"
                            class="min-w-[150px] px-3 py-2 text-start font-semibold text-slate-700 dark:text-white">
                            {{ __('deleted_at') }}
                        </th>
                        <th scope="col"
                            class="min-w-[150px] px-3 py-2 text-start font-semibold text-slate-700 dark:text-white">
                            {{ __('action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($restoreAssetsData as $asset)
                        <tr
                            class="border-b border-slate-100 dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-3 py-3 text-start text-slate-600 dark:text-white">
                                {{ $asset['name'] }}
                            </td>
                            <td class="px-3 py-3 text-start text-slate-600 dark:text-white">
                                {{ number_format($asset['amount']) }}円</td>
                            <td class="px-3 py-3 text-start text-slate-600 dark:text-white">
                                {{ $asset['deleted_at'] }}</td>
                            <td class="px-3 py-3 text-start text-slate-600 dark:text-white">
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
</section>
