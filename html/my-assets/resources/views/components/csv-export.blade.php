<form class="mb-2 sm:mb-0" action="{{ route('assets.csvExport') }}" method="post">
    @csrf
    <input type="hidden" id="export-data" name="export-data" value="{{ $assetData }}">
    <button type="submit" id="export-btn"
        class="flex items-center text-sm p-2.5 text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-slate-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700">
        <i class="fa-solid fa-file-csv mr-2"></i>
        {{ __('download') }}
    </button>
</form>
