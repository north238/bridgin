<x-app-layout>
    <div class="container mx-auto p-4 lg:p-8 xl:max-w-7xl">
        <div class="px-2">
            <h1 class="mb-5 text-2xl font-semibold text-slate-700 dark:text-white">{{ __('notification_detail') }}</h1>
        </div>
        <hr class="h-px mb-6 mt-3 bg-gray-200 border-1 dark:border-dark_border dark:bg-dark_bg">

        @include('pages.notification-detail')
    </div>
</x-app-layout>
