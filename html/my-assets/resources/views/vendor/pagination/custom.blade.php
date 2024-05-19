@if ($paginator->hasPages())
    <section>
        <div class="items-center px-8 lg:px-16 md:px-12">
            <div class="justify-center">
                <div class="flex items-center justify-center py-1 border rounded-full dark:border-dark_border bg-white dark:bg-dark_table">
                    <div class="flex items-center">
                        <div>
                            <nav class="relative z-0 inline-flex items-center gap-1"
                                aria-label="{{ __('Pagination Navigation') }}">
                                @if ($paginator->onFirstPage())
                                    <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                                        <i class="fa-solid fa-chevron-left p-2 text-2xl text-slate-400 dark:text-white"></i>
                                    </span>
                                @else
                                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                                        class="relative inline-flex items-center pr-2 py-2 pl-3 text-2xl text-slate-400 dark:text-white hover:text-slate-700 dark:hover:text-slate-400 rounded-l-full focus:z-10 focus:ring focus:border-blue-300 transition ease-in-out duration-150"
                                        aria-label="{{ __('pagination.previous') }}">
                                        <span class="sr-only">Previous</span>
                                        <i class="fa-solid fa-chevron-left"></i>
                                    </a>
                                @endif
                                {{-- ページ番号の部分 --}}
                                @foreach ($elements as $element)
                                    {{-- ...の場合 --}}
                                    @if (is_string($element))
                                        <span aria-disabled="true">
                                            <span
                                                class="relative inline-flex items-center m-1 px-4 py-2 text-lg text-slate-400 dark:text-white cursor-default">{{ $element }}</span>
                                        </span>
                                    @endif

                                    {{-- 複数ページある場合 --}}
                                    @if (is_array($element))
                                        @foreach ($element as $page => $url)
                                            {{-- 選択しているページ --}}
                                            @if ($page == $paginator->currentPage())
                                                <span aria-current="page">
                                                    <span
                                                        class="relative inline-flex items-center m-1 px-4 py-2 text-lg dark:text-white bg-blue-600 text-white rounded-lg cursor-default">{{ $page }}</span>
                                                </span>
                                            @else
                                                <a href="{{ $url }}"
                                                    class="relative inline-flex items-center m-1 px-4 py-2 text-lg text-slate-400 dark:text-white rounded-lg hover:bg-gray-100 hover:text-gray-500 dark:hover:bg-gray-600 focus:z-10 focus:ring ring-gray-300 focus:border-blue-300 transition ease-in-out duration-150 dark:focus:border-blue-800"
                                                    aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                                    {{ $page }}
                                                </a>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                                @if ($paginator->hasMorePages())
                                    <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                                        class="relative inline-flex items-center pr-3 pl-2 py-2 text-2xl text-slate-400 dark:text-white hover:text-slate-700 dark:hover:text-slate-400 rounded-r-full focus:z-10 focus:ring focus:border-blue-300 transition ease-in-out duration-150"
                                        aria-label="{{ __('pagination.next') }}">
                                        <span class="sr-only">next</span>
                                        <i class="fa-solid fa-chevron-right"></i>
                                    </a>
                                @else
                                    <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                                        <span
                                            class="relative inline-flex items-center p-2 text-2xl text-slate-400 dark:text-white cursor-default"
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
