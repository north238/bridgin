<section id="notification-detail">
    @php
        // 通知カラー
        $color = '';
        if ($notification->type === 'important') {
            $color = 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
        } elseif ($notification->type === 'reminder') {
            $color = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
        } else {
            $color = 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300';
        }
    @endphp
    <div
        class="bg-white py-6 sm:py-8 lg:py-12 sm:rounded-lg border dark:bg-dark_table dark:border-dark_border overflow-hidden">
        <div class="mx-auto max-w-screen-md px-4 sm:px-0 md:px-8">
            <div class="flex flex-col items-start gap-2">
                <span
                    class="block {{ $color }} text-sm sm:text-base font-medium sm:px-5 px-2 py-0 rounded-full">{{ $notification->type }}</span>
                <span
                    class="ml-2 text-sm sm:text-base text-blue-600 dark:text-blue-500">公開日：{{ $notification->formattedDate }}&nbsp;{{ $notification->elapsedTime }}</span>
            </div>
            <h1 class="mt-6 text-start text-2xl font-bold text-gray-800 sm:text-3xl">{{ $notification->title }}</h1>
            <hr class="h-px mb-6 mt-3 bg-gray-200 border-1 dark:border-dark_border dark:bg-dark_bg">

            <p class="my-6 text-gray-500 sm:text-lg sm:my-16">
                {{ $notification->body }}
            </p>
        </div>
    </div>
</section>
