<x-app-layout>
    @if (session('success-message'))
        <div class="alert-message">
            <x-alert-message name="success" color="green">
                {{ session('success-message') }}
            </x-alert-message>
        </div>
    @endif
    @if (session('error-message'))
        <div class="alert-message">
            <x-alert-message name="error" color="rose">
                {{ session('error-message') }}
            </x-alert-message>
        </div>
    @endif
    {{-- CSVファイルアップロード時のエラーメッセージ --}}
    @if (session('errorList'))
        <x-csv-upload-error-message />
    @endif
    @php
        if (empty($latestMonthDate)) {
            $latestMonthDate = now();
        }
        $firstDayOfMonth = date('Y/m/01', strtotime($latestMonthDate));
        $lastDayOfMonth = date('Y/m/t', strtotime($latestMonthDate));
        $monthSelectorVal = $firstDayOfMonth . ' ~ ' . $lastDayOfMonth;
        // 資産データの有無をチェック、あればtrueが返却される
        $isAssetsDataEmpty = $assetsData->isNotEmpty();
    @endphp
    <div class="container mx-auto p-4 lg:p-8 xl:max-w-7xl">
        <div class="px-2">
            <h1 class="mb-5 text-2xl font-semibold text-slate-700 dark:text-white">{{ __('monthly_assets_data') }}</h1>
            <p class="flex items-center text-sm sm:text-base text-slate-800 dark:text-dark_sub_text">
                <span
                    class="w-1.5 h-1.5 bg-blue-600 rounded-full me-1.5"></span>{{ __('total_amount') }}:&nbsp;{{ number_format($totalAmount) }}<span>&nbsp;円</span>
            </p>
            <p class="flex items-center text-sm sm:text-base text-slate-800 dark:text-dark_sub_text"><span
                    class="w-1.5 h-1.5 bg-blue-600 rounded-full me-1.5"></span>{{ __('period') }}&nbsp;{{ $monthSelectorVal }}
            </p>
        </div>
        <hr class="h-px mb-6 mt-3 bg-gray-200 border-1 dark:border-dark_border dark:bg-dark_bg">
        <div class="flex justify-between px-2 mb-1">
            <p class="ml-2 text-sm sm:text-base text-slate-700 dark:text-dark_sub_text">
                {{ __('total_asset') }}&nbsp;{{ $totalCount }}<span>{{ __('count') }}</span>
            </p>
            <form action="{{ route('asset-trend.search') }}" method="post"
                class="text-sm sm:text-base font-medium text-blue-600 dark:text-blue-500">
                @csrf
                <button type="submit">
                    <span class="hover:underline">{{ __('display_chart') }}</span><i
                        class="fa-solid fa-angle-right ml-2"></i>
                </button>
                <input type="hidden" name="search-month-date" value="{{ $latestMonthDate }}">
            </form>
        </div>
        @include('pages.m-table')
    </div>

    @section('scripts')
        <script type="text/javascript">
            const latestMonthDate = "{{ $latestMonthDate }}";
            const redirectIndex = "{{ route('assets.index') }}";
        </script>
    @endsection

    @pushIf($isAssetsDataEmpty, 'script-files')
    @vite(['resources/js/debut-display-switching.js'])
    @endPushIf

</x-app-layout>
