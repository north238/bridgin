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

    @include('pages.notification-message')
    </div>
</x-app-layout>
