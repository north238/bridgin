<section class="text-gray-600 body-font">
    <div class="container px-5 py-24 mx-auto">
        <div class="flex flex-col text-center w-full mb-20">
            <h1 class="sm:text-4xl text-3xl font-medium title-font mb-2 text-gray-900">{{ __('total_amount') }}</h1>
            <p class="lg:w-2/3 mx-auto leading-relaxed text-base">
            <p class="text-lg">{{ $totalAmount }}</p>
            </p>
        </div>
        <div class="lg:w-2/3 w-full mx-auto overflow-auto">
            <table class="divide-gray-200 table-auto w-full text-left whitespace-no-wrap">
                <thead>
                    <tr>
                        <th
                            class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-50 rounded-tl rounded-bl">
                            {{ __('asset_name') }}</th>
                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-50">
                            {{ __('category_name') }}</th>
                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-50">
                            {{ __('amount') }}</th>
                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-50">
                            {{ __('edit') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-gray-200">
                    @foreach ($assets as $asset)
                        <tr>
                            <td class="border-t-2 border-b-2 border-gray-200 px-4 py-3">{{ $asset['name'] }}</td>
                            <td class="border-t-2 border-b-2 border-gray-200 px-4 py-3">{{ $asset['category']['name'] }}
                            </td>
                            <td class="border-t-2 border-b-2 border-gray-200 px-4 py-3">
                                {{ $asset['amount'] }}</td>
                            <td class="border-t-2 border-b-2 border-gray-200 px-4 py-3">
                                <a href="#" class="text-blue-600 hover:text-blue-900">編集詳細</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="flex pl-4 mt-4 lg:w-2/3 w-full mx-auto">
            <a class="text-yellow-500 inline-flex items-center md:mb-2 lg:mb-0">Learn More
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="2" class="w-4 h-4 ml-2" viewBox="0 0 24 24">
                    <path d="M5 12h14M12 5l7 7-7 7"></path>
                </svg>
            </a>
            <button
                class="flex ml-auto text-white bg-yellow-500 border-0 py-2 px-6 focus:outline-none hover:bg-yellow-600 rounded">Button</button>
        </div>
    </div>
</section>
