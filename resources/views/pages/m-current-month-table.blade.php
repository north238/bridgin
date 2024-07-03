<div
    class="flex flex-col rounded-lg overflow-hidden border dark:border-dark_border bg-white md:col-span-3 dark:bg-dark_table">
    <div class="p-5">
        <div class="scrollbar-custom overflow-x-auto min-w-full rounded dark:border-dark_border">
            <table class="text-sm  align-middle min-w-full">
                <thead class="dark:bg-dark_table">
                    <tr class="border-b-2 border-slate-100 dark:border-dark_border">
                        <th scope="col"
                            class="min-w-[150px] px-3 py-2 text-start font-semibold text-slate-700 dark:text-white">
                            年月
                        </th>
                        <th scope="col"
                            class="min-w-[150px] px-3 py-2 text-start font-semibold text-slate-700 dark:text-white">
                            {{ __('total_amount') }}
                        </th>
                        <th scope="col"
                            class="min-w-[150px] px-3 py-2 text-start font-semibold text-slate-700 dark:text-white">
                            増減額
                        </th>
                        <th scope="col"
                            class="min-w-[150px] px-3 py-2 text-start font-semibold text-slate-700 dark:text-white">
                            前月比
                        </th>
                        <th scope="col"
                            class="min-w-[100px] ps-3 py-2 text-start font-semibold text-slate-700 dark:text-white">
                            {{ __('action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($monthOverMonthRatios as $month => $assets)
                        @php
                            // 金額によって不等号をつける処理
                            $sign = null;
                            if ($assets['ratioClass'] === 'positive') {
                                $sign = '+';
                            }
                        @endphp
                        <tr
                            class="border-b border-slate-100 dark:border-dark_border hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-3 py-3 text-start text-slate-600 dark:text-white">
                                {{ $month }}</td>
                            <td class="text-slate-800 dark:text-white px-3 py-3 font-medium text-start">
                                {{ number_format($assets['totalAmount']) }}<span>&nbsp;円</span>
                            </td>
                            <td class="{{ $assets['ratioClass'] }} px-3 py-3 text-start">
                                @if ($assets['ratioClass'] === 'even')
                                    &plus;{{ number_format($assets['increaseAndDecreaseAmount']) }}<span>&nbsp;円</span>
                                @else
                                    {{ $sign }}{{ number_format($assets['increaseAndDecreaseAmount']) }}<span>&nbsp;円</span>
                                @endif
                            </td>
                            <td class="{{ $assets['ratioClass'] }} px-3 py-3 text-start">
                                @if ($assets['monthOverMonthRatio'] === 0)
                                    <span>&plusmn;0&nbsp;%</span>
                                @else
                                    {{ $sign }}{{ $assets['monthOverMonthRatio'] }}<span>&nbsp;%</span>
                                @endif
                            </td>
                            <td class="ps-3 py-3 text-start">
                                {{-- todo:月間データへどのように遷移するのか考える --}}
                                <form action="{{route('search.index')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="search-date" value="{{$month}}">
                                    <input type="submit" class="cursor-pointer font-medium text-blue-600 dark:text-blue-500 hover:underline" value="詳細ページへ">
                                </form>
                            </td>
                        </tr>
                    @endforeach
            </table>
        </div>
    </div>
</div>
