<form action="{{ route('post.upload.csv') }}" method="post" enctype="multipart/form-data">
    @csrf
    <label for="upload-file"
        class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
        <div class="flex flex-col items-center justify-center pt-5 pb-6">
            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
            </svg>
            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                    class="font-semibold">クリックしてファイルを選択してください</span>
            <p class="text-xs text-gray-500 dark:text-gray-400">CSVファイルのみ（MAX: 5MB）</p>
        </div>
        <input type="file" id="upload-file" name="upload-file" class="hidden" accept="text/csv, .csv">
        <p id="file-name" class="mt-5 text-sm text-gray-500 dark:text-gray-400">選択されていません</p>
    </label>
    <div class="mt-5 flex justify-center">
        <button
            class="w-full py-2 px-4 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
            <i class="fa-solid fa-upload mr-3"></i>{{ __('upload') }}
        </button>
    </div>
</form>
