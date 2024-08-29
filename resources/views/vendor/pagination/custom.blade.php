@if ($paginator->hasPages())
    <section>
        <div class="lg:px-16 md:px-12">
            <div class="justify-center">
                <div
                    class="flex items-center justify-center py-1 border rounded-full dark:border-dark_border bg-white dark:bg-dark_table">
                    <div class="flex items-center">
                        <div>
                            <nav class="relative z-0 inline-flex items-center"
                                aria-label="{{ __('Pagination Navigation') }}">
                                @if ($paginator->onFirstPage())
                                    <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                                        <i
                                            class="fa-solid fa-chevron-left p-2 pr-3 text-2xl text-slate-400 dark:text-white"></i>
                                    </span>
                                @else
                                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                                        class="relative inline-flex items-center pr-2 py-2 pl-3 text-2xl text-slate-500 dark:text-white hover:text-slate-700 dark:hover:text-slate-400 hover:transform hover:-translate-x-1 hover:duration-200"
                                        aria-label="{{ __('pagination.previous') }}">
                                        <span class="sr-only">Previous</span>
                                        <i class="fa-solid fa-chevron-left"></i>
                                    </a>
                                @endif
                                {{-- ページ表示の条件
                                - 最初と最後のページ番号は常に表示
                                - 1ページを選択中は4ページ目までを表示,それ以外は最後のページと...
                                - 5ページ目を選択時は両サイドのページ番号と最初と最後のページと...
                                - 以下最後のページから3ページ前までを表示、それ以外は最初と最後のページと...

                                例： 1234 ... 15, 1 ...345... 15, 1 ... 12 13 14 15 --}}
                                {{-- 最初のページは常に表示 --}}
                                <a href="{{ $paginator->url(1) }}"
                                    class="relative inline-flex items-center px-3 py-2 text:sm sm:text-lg {{ $paginator->currentPage() == 1 ? 'font-semibold bg-blue-600 text-white rounded-lg cursor-default' : 'text-slate-500 dark:text-white rounded-lg hover:bg-gray-100 hover:text-slate-600 dark:hover:bg-gray-600 focus:z-10 focus:ring ring-gray-300 focus:border-blue-300 transition ease-in-out duration-150 dark:focus:border-blue-800' }}">
                                    1
                                </a>

                                {{-- 現在のページが3より大きいとき... --}}
                                @if ($paginator->currentPage() > 3)
                                    <span aria-disabled="true"
                                        class="relative inline-flex items-center px-1 py-2 text-lg text-slate-500 dark:text-white cursor-default">...</span>
                                @endif

                                @for ($i = 2; $i <= $paginator->lastPage() - 1; $i++)
                                    @if ($i >= $paginator->currentPage() - 1 && $i <= $paginator->currentPage() + 1)
                                        <a href="{{ $paginator->url($i) }}"
                                            class="relative inline-flex items-center px-3 py-2 text:sm sm:text-lg {{ $paginator->currentPage() == $i ? 'font-semibold bg-blue-600 text-white rounded-lg cursor-default' : 'text-slate-500 dark:text-white rounded-lg hover:bg-gray-100 hover:text-slate-600 dark:hover:bg-gray-600 focus:z-10 focus:ring ring-gray-300 focus:border-blue-300 transition ease-in-out duration-150 dark:focus:border-blue-800' }}">
                                            {{ $i }}
                                        </a>
                                    @endif
                                @endfor

                                {{-- 現在のページが（最後のページ-2）より小さいとき... --}}
                                @if ($paginator->currentPage() < $paginator->lastPage() - 2)
                                    <span aria-disabled="true"
                                        class="relative inline-flex items-center px-1 py-2 text-lg text-slate-500 dark:text-white cursor-default">...</span>
                                @endif

                                {{-- 最後のページは常に表示 --}}
                                <a href="{{ $paginator->url($paginator->lastPage()) }}"
                                    class="relative inline-flex items-center px-3 py-2 text:sm sm:text-lg {{ $paginator->currentPage() == $paginator->lastPage() ? 'font-semibold bg-blue-600 text-white rounded-lg cursor-default' : 'text-slate-500 dark:text-white rounded-lg hover:bg-gray-100 hover:text-slate-600 dark:hover:bg-gray-600 focus:z-10 focus:ring ring-gray-300 focus:border-blue-300 transition ease-in-out duration-150 dark:focus:border-blue-800' }}">
                                    {{ $paginator->lastPage() }}
                                </a>

                                @if ($paginator->hasMorePages())
                                    <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                                        class="relative inline-flex items-center pr-3 pl-2 py-2 text-2xl text-slate-500 dark:text-white hover:text-slate-700 dark:hover:text-slate-400 hover:transform hover:translate-x-1 hover:duration-200"
                                        aria-label="{{ __('pagination.next') }}">
                                        <span class="sr-only">next</span>
                                        <i class="fa-solid fa-chevron-right"></i>
                                    </a>
                                @else
                                    <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                                        <span
                                            class="relative inline-flex items-center p-2 pl-3 text-2xl text-slate-400 dark:text-white cursor-default"
                                            aria-hidden="true">
                                            <i class="fa-solid fa-chevron-right"></i>
                                        </span>
                                    </span>
                                @endif
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
