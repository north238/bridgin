<form action="{{ route('post.assets.csvDownload') }}" method="post">
    @csrf
    <input type="hidden" id="export-data" name="export-data" value="{{ $assets }}">
    <button type="submit" id="export-btn" {{ $attributes->merge(['class' => 'px-3 py-2 font-medium text-slate-600 bg-white border border-gray-300 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white']) }}>
        <i class="fa-solid fa-file-csv"></i>
        {{ __('download') }}
    </button>
</form>
