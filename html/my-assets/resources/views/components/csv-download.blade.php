<form action="{{ route('post.assets.csvDownload') }}" method="post">
    @csrf
    <input type="hidden" id="export-data" name="export-data" value="{{ $assets }}">
    <button type="submit" id="export-btn" data-tooltip-target="csv-download-tooltip" data-tooltip-placement="bottom"
        {{ $attributes->merge(['class' => 'px-3 py-2 font-medium text-slate-600 bg-white hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white']) }}>
        <i class="fa-solid fa-file-csv"></i>
        <span class="sr-only">ダウンロード</span>
        {{ $slot }}
    </button>
</form>
<div id="csv-download-tooltip" role="tooltip"
    class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
    ダウンロード
    <div class="tooltip-arrow" data-popper-arrow></div>
</div>
