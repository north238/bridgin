<form class="mb-2 sm:mb-0" action="{{ route('assets.csvExport') }}" method="post">
    @csrf
    <input type="hidden" id="export-data" name="export-data" value="{{ $assetData }}">
    <button type="submit" id="export-btn"
        class="flex items-center text-md py-2 px-3 rounded-lg text-white bg-green-500 border-green-500 hover:bg-green-400 focus:ring-2 focus:outline-none focus:ring-green-400">
        <i class="fa-solid fa-file-csv mr-2 text-white"></i>
        {{ __('download') }}
    </button>
</form>
