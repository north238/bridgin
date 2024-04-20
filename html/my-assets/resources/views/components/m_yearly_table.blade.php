<section id="m-yearly-table-section">
    <div class="relative max-w-screen-md overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-gray-700 bg-gray-100 border border-gray-200 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-4 text-center">
                        年月
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        合計
                    </th>
                    <th scope="col" class="px-6 py-4 text-center">
                        資産総数
                    </th>
                    <th scope="col" class="px-6 py-4">
                        <span class="sr-only">操作</span>
                    </th>
                </tr>
            </thead>
            @foreach ($assetsByMonth as $yearMonth => $data)
                <tbody>
                    <tr
                        class="bg-white dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 text-center font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <a href="{{ route('assets.index') }}">{{ $yearMonth }}</a>
                        </th>
                        <td class="px-6 py-4 text-center">
                            {{ number_format($data['totalAmount']) }} 円
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{ $data['assetCount'] }}
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('assets.index') }}"
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline">詳細・一覧</a>
                        </td>
                    </tr>
                </tbody>
            @endforeach
        </table>
    </div>
</section>
