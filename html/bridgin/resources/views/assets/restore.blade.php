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
            <x-alert-message name="error" color="red">
                {{ session('error-message') }}
            </x-alert-message>
        </div>
    @endif
    <div class="container mx-auto p-4 lg:p-8 xl:max-w-7xl">
        <div class="flex flex-row items-center text-start">
            <div class="grow flex items-center">
                <h1 class="text-2xl sm:text-2xl font-semibold text-slate-900 dark:text-white">{{ __('assets_restore') }}
                </h1>
                <svg data-popover-target="restore-info" data-popover-placement="bottom"
                    class="w-3.5 h-3.5 text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white cursor-pointer ms-1"
                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm0 16a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3Zm1-5.034V12a1 1 0 0 1-2 0v-1.418a1 1 0 0 1 1.038-.999 1.436 1.436 0 0 0 1.488-1.441 1.501 1.501 0 1 0-3-.116.986.986 0 0 1-1.037.961 1 1 0 0 1-.96-1.037A3.5 3.5 0 1 1 11 11.466Z" />
                </svg>
            </div>
            <div class="flex items-center px-2">
                <a href="{{ route('assets.create') }}"
                    class="text-sm sm:text-base font-medium text-blue-600 dark:text-blue-500 hover:underline">
                    <span>{{ __('asset_create_btn') }}</span><i class="fa-solid fa-angle-right ml-2"></i>
                </a>
            </div>
        </div>
        <div data-popover id="restore-info" role="tooltip"
            class="absolute z-10 invisible inline-block text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400">
            <div class="p-3 space-y-2">
                <h3 class="font-semibold text-gray-900 dark:text-white">画面詳細</h3>
                <p>資産や取引履歴など、各種ページで削除されたデータはこちらの画面で管理できます。『復元』をタップすれば、ワンタップで以前登録した年月にデータを戻せます。</p>
            </div>
            <div data-popper-arrow></div>
        </div>
        <hr class="h-px mb-6 mt-3 bg-gray-200 border-1 dark:border-dark_border dark:bg-dark_bg">
        <p class="ml-2 text-sm sm:text-base text-slate-700 dark:text-white">
            {{__('total_count')}}:&nbsp;{{ $totalCount }}<span>{{ __('count') }}</span>
        </p>
        @include('pages.restore-table')
    </div>
</x-app-layout>
