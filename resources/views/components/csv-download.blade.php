<button id="export-btn" data-dropdown-toggle="drop-down-list" data-dropdown-placement="bottom-end"
    data-tooltip-target="csv-download-tooltip" data-tooltip-placement="top" type="button"
    {{ $attributes->merge(['class' => 'px-3 py-2 font-medium text-slate-600 bg-white hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white']) }}>
    <i class="fa-solid fa-file-csv"></i>
    <span class="sr-only">{{ __('download') }}</span>
    {{ $slot }}
</button>
<div id="drop-down-list"
    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-50 dark:bg-gray-700 dark:divide-gray-600">
    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="drop-down-list">
        <li>
            <form action="{{ route('post.assets.csvDownload') }}" method="post">
                @csrf
                <input type="hidden" id="export-data" name="export-data" value="{{ $assets }}">
                <button type="submit"
                    class="block w-full text-start px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                    <i class="fa-solid fa-download mr-3"></i>{{ __('download') }}
                </button>
            </form>
        </li>
        <li>
            <button type="button" data-modal-target="csv-modal" data-modal-toggle="csv-modal"
                class="block w-full text-start px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"><i
                    class="fa-solid fa-upload mr-3"></i>{{ __('upload') }}</button>
        </li>
        <li>
            <a href="{{ route('get.template.csv') }}"
                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"><i
                    class="fa-solid fa-file-arrow-down mr-3"></i>{{ __('template_file_download') }}</a>
        </li>
    </ul>
</div>
<div id="csv-download-tooltip" role="tooltip"
    class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
    {{ __('download_csv') }}
    <div class="tooltip-arrow" data-popper-arrow></div>
</div>

<x-csv-upload-modal type="csv" name="ファイルアップロード">
    <x-csv-upload />
</x-csv-upload-modal>

@push('script-files')
    @vite(['resources/js/csv-upload.js'])
@endpush