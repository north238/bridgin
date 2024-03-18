<section id="m-assets-table-section">
    <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
        <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg overflow-hidden">
            {{-- 資産が登録されていない場合の処理 --}}
            {{-- @if ($assets->count() === 0)
                <div class="text-center mt-3">
                    <p>表示させる資産のデータはありません。資産を追加しましょう。</p>
                    <a href="{{route('assets.create')}}" class="inline-flex justify-center px-5 py-2.5 mt-3 sm:mt-3 text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-300 rounded-full dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">登録する</a>
                </div>
            @endif --}}
            @if ($assetsByMonth->isEmpty())
                {{-- <div class="flex relative md:flex-row md:space-y-0 md:space-x-4 p-4">
                    <div class="w-full md:w-1/2 p-6">
                        @php
                            $prevMonth = date('Y-m', strtotime('-1 month', strtotime($formatDate)));
                            $nextMonth = date('Y-m', strtotime('1 month', strtotime($formatDate)));
                        @endphp
                        <div class="absolute top-2 left-12">
                            今月('{{ $formatDate }}')のデータはありません。
                        </div>
                        <form id="month-form-data" method="POST" action="{{ route('ajax.monthPagination') }}">
                            @csrf
                            <button id="prev-month-btn"
                                class="month-btn inline-flex absolute bottom-2 items-center px-4 h-10 me-3 text-base font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                <svg class="w-3.5 h-3.5 me-2 rtl:rotate-180" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M13 5H1m0 0 4 4M1 5l4-4" />
                                </svg>
                                {{ __('prev_month') }}
                            </button>
                            <input type="hidden" id="prev-month" name="prev-month" value="{{ $prevMonth }}">
                            <input type="hidden" id="prev-month" name="prev-month" value="{{ $nextMonth }}">
                            <input type="hidden" id="clicked-btn" name="clicked-btn">
                        </form>
                    </div> --}}
            @else
                @foreach ($assetsByMonth as $month => $assets)
                    <div class="bg-white dark:bg-gray-800 shadow-md sm:rounded-lg overflow-hidden">
                        <div class="flex flex-col sm:flex-row sm:justify-between items-center p-6">
                            @php
                                $prevMonth = date('Y-m', strtotime('-1 month', strtotime($month)));
                                $nextMonth = date('Y-m', strtotime('1 month', strtotime($month)));
                                $firstDayOfMonth = date('Y-m-01', strtotime($month));
                                $lastDayOfMonth = date('Y-m-t', strtotime($month));
                                $monthSelectorVal = $firstDayOfMonth . ' ~ ' . $lastDayOfMonth;
                            @endphp
                            <form id="month-form-data" class="flex flex-col sm:flex-row justify-around items-center" method="POST" action="{{ route('ajax.monthPagination') }}">
                                @csrf
                                <div>
                                    <button id="prev-month-btn"
                                        class="month-btn flex items-center px-4 h-10 me-2 mb-2 sm:mb-0 text-base font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                        <svg class="w-3.5 h-3.5 me-2 rtl:rotate-180" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M13 5H1m0 0 4 4M1 5l4-4" />
                                        </svg>
                                        {{ __('prev_month') }}
                                    </button>
                                </div>
                                <div>
                                    <div id="month-data" class="relative w-full me-2 mb-2 sm:mb-0">
                                        <div class="absolute inset-y-2.5 start-0 ps-2 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14c.6 0 1-.4 1-1V7c0-.6-.4-1-1-1H5a1 1 0 0 0-1 1v12c0 .6.4 1 1 1Zm3-7h0v0h0v0Zm4 0h0v0h0v0Zm4 0h0v0h0v0Zm-8 4h0v0h0v0Zm4 0h0v0h0v0Zm4 0h0v0h0v0Z" />
                                            </svg>
                                        </div>
                                        <input type="text"
                                            class="block items-center ps-8 h-10 text-gray-500 bg-white border border-gray-300 text-sm font-medium rounded-lg dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                            name="month-selecter" id="month-selecter" value="{{ $monthSelectorVal }}"
                                            disabled>
                                    </div>
                                </div>
                                <div>
                                    <button id="next-month-btn"
                                        class="month-btn flex items-center px-4 h-10 me-2 mb-2 sm:mb-0 text-base font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                        {{ __('next_month') }}
                                        <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                                        </svg>
                                    </button>
                                </div>
                                <div>
                                    <button id="now-month-btn"
                                        class="month-btn flex items-center px-4 h-10 mb-2 sm:mb-0 text-base font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                                        {{ __('now_month') }}
                                    </button>
                                </div>
                                <input type="hidden" id="now-month" name="now-month" value="{{ $month }}">
                                <input type="hidden" id="prev-month" name="prev-month" value="{{ $prevMonth }}">
                                <input type="hidden" id="next-month" name="next-month" value="{{ $nextMonth }}">
                                <input type="hidden" id="clicked-btn" name="clicked-btn">
                            </form>
                            <form class="mb-2 sm:mb-0" action="{{ route('assets.csvExport') }}" method="post">
                                @csrf
                                <input type="hidden" id="export-data" name="export-data" value="{{ $assets }}">
                                <button type="submit" id="export-btn"
                                    class="flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700">
                                    <svg class="w-3.5 h-3.5 mx-1 rtl:rotate-180" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewbox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                    </svg>
                                    {{ __('csv_download') }}
                                </button>
                            </form>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-md text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-3 py-3">
                                            {{ __('asset_name') }}</th>
                                        <th scope="col" class="px-6 py-3">
                                            <div class="flex items-center">
                                                {{ __('category_name') }}
                                                {{-- todo: ソート機能実装 --}}
                                                <a href="#"><svg class="w-3 h-3 ms-1.5" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path
                                                            d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                                    </svg></a>
                                            </div>
                                        </th>
                                        <th scope="col" class="px-3 py-3">
                                            <div class="flex items-center">
                                                {{ __('amount') }}
                                                {{-- todo: ソート機能実装 --}}
                                                <a href="#"><svg class="w-3 h-3 ms-1.5" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path
                                                            d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                                    </svg></a>
                                            </div>
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            <div class="flex items-center">
                                                {{ __('registration_date') }}
                                                {{-- todo: ソート機能実装 --}}
                                                <a href="#"><svg class="w-3 h-3 ms-1.5" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path
                                                            d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                                    </svg></a>
                                            </div>
                                        </th>
                                        <th scope="col" class="px-3 py-3">
                                            {{ __('action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($assets as $asset)
                                        <tr
                                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                            <td
                                                class="text-gray-900 dark:text-white border-t-2 border-b-2 border-gray-200 px-4 py-3 font-medium">
                                                {{ $asset['name'] }}</td>
                                            <td class="border-t-2 border-b-2 border-gray-200 px-4 py-3">
                                                {{ $asset['category']['name'] }}
                                            </td>
                                            <td class="border-t-2 border-b-2 border-gray-200 px-4 py-3">
                                                {{ number_format($asset['amount']) }}円</td>
                                            <td class="border-t-2 border-b-2 border-gray-200 px-4 py-3">
                                                {{ $asset['registration_date'] }}</td>
                                            <td class="border-t-2 border-b-2 border-gray-200 px-4 py-3">
                                                <a href="{{ route('assets.show', [$asset->id]) }}" id="asset-edit"
                                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">{{ __('edit') }}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
</section>

<script type="module" defer>
    // 表示のデータが今月の場合「今月」ボタンを非表示
    // データがなければ「前月・今月」のボタンを非表示
    function monthButtonChange() {
        let formatDate = "{{ $formatDate }}";
        let assetMinDate = "{{ $assetMinDate }}";
        let nowMonth = $("#now-month").val();

        if (formatDate === nowMonth) {
            $("#now-month-btn").addClass('hidden');
            $("#next-month-btn").addClass('hidden');
        }
        if (assetMinDate === nowMonth) {
            $("#prev-month-btn").addClass('hidden');
        }
    }

    $(document).ready(function() {

        monthButtonChange();

        $(".month-btn").click(function() {
            let btnId = $(this).attr("id"); // クリックされたボタンのidを取得
            $("#clicked-btn").val(btnId);
        });

        // 前月のボタンがクリックされたら
        $("#month-form-data").submit(function(event) {
            event.preventDefault(); // デフォルトのクリック動作を無効化

            const tableId = $("#m-assets-table");
            const url = "{{ route('ajax.monthPagination') }}";
            let monthFormData = $(this).serialize();
            let formData = new URLSearchParams(
                monthFormData); //serialize()で取得した文字列をURLSearchParamsオブジェクトに変換
            let formDataObject = Object.fromEntries(formData
                .entries()); // URLSearchParamsオブジェクトからJavaScriptのオブジェクトに変換
            console.log(formDataObject);
            $.ajax({
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    url: url,
                    data: formDataObject,
                    type: "POST",
                })
                .done(function(res) {
                    tableId.html(res);
                })
                .fail(function(err) {
                    console.log("エラーが発生しています。", err);
                });
        });
    });
</script>
