<div id="csv-upload-message" class="bg-rose-50 text-rose-500 px-4 py-3 relative">
    <div class="container mx-auto p-2 lg:p-4 xl:max-w-7xl">
        <div class="flex items-center">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <strong class="font-bold text-sm sm:text-base ml-2">アップロードファイルのエラー詳細</strong>
            <button type="button"
                class="ms-auto -mx-1.5 -my-1.5 bg-rose-100 text-rose-500 rounded-lg focus:ring-2 focus:ring-rose-400 p-1.5 hover:bg-rose-200 inline-flex items-center justify-center h-8 w-8"
                data-dismiss-target="#csv-upload-message" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
        @php
            $errorLimit = 5; // 表示するエラーメッセージの最大行数
        @endphp
        <ul class="mt-4 ml-2 text-sm">
            @foreach (session('errorList') as $errorNumber => $errors)
                @if ($errorNumber < $errorLimit)
                    <li class="mb-1">
                        <strong> {{ $errorNumber }}行目:</strong>
                        <ul class="ml-4 list-disc list-inside">
                            @foreach ($errors as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li class="mb-1 hidden more-errors">
                        <strong> {{ $errorNumber }}行目:</strong>
                        <ul class="ml-4 list-disc list-inside">
                            @foreach ($errors as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </li>
                @endif
            @endforeach
        </ul>

        @php
            // エラーメッセージの総数をカウント
            $totalErrors = collect(session('errorList'))->flatten()->count();
        @endphp

        @if ($totalErrors > $errorLimit)
            <button id="show-more-btn"
                class="ml-5 mt-5 py-2 px-4 text-sm font-semibold rounded-lg border border-transparent bg-slate-700 text-white hover:bg-slate-500 disabled:opacity-50 disabled:pointer-events-none">
                {{ __('more_error_list') }}
            </button>
        @endif
    </div>
</div>

<script>
    document.getElementById('show-more-btn')?.addEventListener('click', function() {
        document.querySelectorAll('.more-errors').forEach(function(el) {
            el.classList.remove('hidden');
        });
        this.style.display = 'none'; // ボタンを隠す
    });
</script>
