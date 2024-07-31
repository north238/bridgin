<section id="notification-message">
    <div
        class="bg-white py-6 sm:py-8 lg:py-12 rounded-lg border dark:bg-dark_table dark:border-dark_border overflow-hidden">
        <div class="mx-auto max-w-screen-2xl px-4 md:px-8">

            <div class="grid gap-6 grid-cols-1">
                @foreach ($notifications as $item)
                    @php
                        // 通知カラー
                        $color = '';
                        if ($item->type === 'important') {
                            $color = 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
                        } elseif ($item->type === 'reminder') {
                            $color = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
                        } else {
                            $color = 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300';
                        }
                    @endphp
                    <a href="{{ route('notification.detail', ['notificationId' => $item->id]) }}"
                        class="cursor-pointer h-16 sm:h-20 flex flex-col justify-center border-dashed border-b hover:bg-slate-50 dark:hover:bg-dark_bg">
                        <div class="p-2 sm:p-4 flex flex-col gap-2 sm:gap-4">
                            <div class="flex flex-row sm:items-center">
                                <span class="text-sm text-blue-600 dark:text-blue-500">{{ $item->formattedDate }}</span>
                                <span class="ml-2 text-sm text-blue-600 dark:text-blue-500">{{ $item->elapsedTime }}</span>
                                <span
                                    class="ml-2 sm:ml-4 {{ $color }} text-sm sm:px-5 px-2 py-0 rounded-full">{{ $item->type }}</span>
                            </div>
                            <div class="flex justify-between">
                                <h2 class="text-base text-slate-600 dark:text-white font-semibold truncate">
                                    {{ $item->title }}
                                </h2>
                                <div class="pr-2">
                                    <i class="fa-solid fa-angle-right text-blue-600 dark:text-blue-500"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    <div class="text-center mt-5">
        <x-custom-pagination :displayData="$notifications" />
    </div>
</section>
