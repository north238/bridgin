<form class="mb-2 sm:mb-0" action="{{ route('post.assets.csvDownload') }}" method="post">
    @csrf
    <input type="hidden" id="export-data" name="export-data" value="{{ $assetsData }}">
    <button type="submit" id="export-btn"
        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-e-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
        <i class="fa-solid fa-file-csv me-2"></i>
        {{ __('download') }}
    </button>
</form>
