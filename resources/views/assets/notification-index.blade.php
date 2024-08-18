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
    <div class="container mx-auto p-4 lg:p-8 xl:max-w-7xl">
        <div class="px-2">
            <h1 class="mb-5 text-2xl font-semibold text-slate-700 dark:text-white">{{ __('notification_message') }}</h1>
        </div>
        <hr class="h-px mb-6 mt-3 bg-gray-200 border-1 dark:border-dark_border dark:bg-dark_bg">

        <div class="flex gap-7 ml-5 mb-3">
            <a href="{{ route('notification.index') }}"
                class="relative text-slate-700 px-3 border border-slate-300 dark:text-white dark:border-dark_border shadow-sm rounded-full hover:border-blue-500 hover:bg-blue-100 dark:hover:bg-dark_table">{{ __('all_notification') }}<span
                    class="sr-only">all</span>
                <div class="absolute font-bold text-sm text-blue-500 -top-2 -end-2">
                    {{ $totalCount }}</div>
            </a>
            <a href="{{ route('notification.unread') }}"
                class="relative text-slate-700 px-3 border border-slate-300 dark:text-white dark:border-dark_border shadow-sm rounded-full hover:border-blue-500 hover:bg-blue-100 dark:hover:bg-dark_table">{{ __('unread_notification') }}<span
                    class="sr-only">unread</span>
                <div class="absolute font-bold text-sm text-blue-500 -top-2 -end-2">
                    {{ $unreadTotalCount }}</div>
            </a>
        </div>
        @include('pages.notification-message')
    </div>
</x-app-layout>
