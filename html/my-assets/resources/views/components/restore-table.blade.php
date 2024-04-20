<section id="assets-restore-table-section">
    <div class="overflow-x-auto">
        <table class="w-full border border-gray-200 text-gray-500 dark:text-gray-400">
            <thead class="font-medium text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="py-3 text-center">
                        {{ __('asset_name') }}</th>
                    <th scope="col" class="py-3 text-center">
                        {{ __('amount') }}
                    </th>
                    <th scope="col" class="py-3 text-center">
                        {{ __('deleted_at') }}
                    </th>
                    <th scope="col" class="py-3 text-center">
                        {{ __('action') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($restoreAssetsData as $asset)
                    <tr
                        class="bg-white dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td
                            class="text-gray-900 dark:text-white border-t border-b border-gray-200 py-3 font-medium text-center">
                            {{ $asset['name'] }}
                        </td>
                        <td class="border-t border-b border-gray-200 py-3 text-center">
                            {{ number_format($asset['amount']) }}円</td>
                        <td class="border-t border-b border-gray-200 py-3 text-center">
                            {{ $asset['deleted_at'] }}</td>
                        <td class="border-t border-b border-gray-200 py-3 text-center">
                            <a href="{{route('assets.restoreAsset', $asset['id'])}}"
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline"><i
                                    class="fa-solid fa-trash-arrow-up mr-1"></i>
                                {{ __('restore') }}</a>
                        </td>
                    </tr>
                @endforeach
        </table>
    </div>
</section>
