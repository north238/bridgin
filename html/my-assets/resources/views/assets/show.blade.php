<x-app-layout>
    <div class="alert-message">
        @if (session('success-message'))
            <x-alert-message name="success" color="green">
                {{ session('success-message') }}
            </x-alert-message>
        @endif
        @if (session('error-message'))
            <x-alert-message name="error" color="red">
                {{ session('error-message') }}
            </x-alert-message>
        @endif
    </div>
    <section
        class="max-w-screen-md sm:my-10 mx-auto block bg-white border border-slate-100 dark:border-dark_border sm:rounded-lg sm:shadow dark:bg-dark_table">
        <div class="p-4 mx-auto sm:p-8 sm:max-w-lg">
            <div class="heading-title pr-2 flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ __('edit_asset') }}</h2>
                <a href="javascript:" data-previous-url="{{ $previousUrl }}" id="show-back-btn"
                    class="text-sm text-blue-600 dark:text-blue-500"><i class="fa-solid fa-angle-left mr-2"></i><span
                        class="hover:underline">{{ __('back_btn') }}</span></a>
            </div>
            <hr class="h-px mb-2 bg-gray-200 border-1 dark:border-dark_border dark:bg-dark_table sm:col-span-2">

            <form id="updated-form" class="validated-form mb-2" method="post"
                action="{{ route('assets.update', [$assetData->id]) }}" novalidate>
                @csrf
                @method('PATCH')
                <div class="grid gap-3 sm:grid-cols-2 sm:gap-6">
                    <div class="action-checkbox flex justify-between items-start sm:col-span-2">
                        <input type="hidden" name="changed_type_flg" value="0">
                        <p class="me-4 text-sm font-medium text-gray-900 dark:text-white"><i
                                class="fa-regular fa-circle-check text-rose-500 me-0.5"></i>
                            {{ __('checked_message') }}</p>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="changed_type_flg" name="changed_type_flg" value="1"
                                class="sr-only peer">
                            <div
                                class="relative w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-3 peer-focus:ring-blue-500 dark:peer-focus:ring-blue-600 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:bg-dark_input dark:hover:bg-dark_input_border dark:border-dark_input_border peer-checked:bg-blue-500">
                            </div>
                            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300"></span>
                        </label>
                    </div>
                    <div class="name-input sm:col-span-2">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"><i
                                class="fa-regular fa-circle-check text-rose-500 me-0.5"></i>{{ __('asset_name') }}</label>
                        <input type="text" name="name" id="name" value="{{ $assetData->name }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-400 focus:border-blue-400 block w-full p-2.5 dark:bg-dark_input dark:hover:bg-dark_input_border dark:border-dark_input_border dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-400 dark:focus:border-blue-400"
                            required>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div class="amount-input w-full">
                        <label for="amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"><i
                                class="fa-regular fa-circle-check text-rose-500 me-0.5"></i>{{ __('amount') }}</label>
                        <input type="number" name="amount" id="amount" value="{{ $assetData->amount }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-400 focus:border-blue-400 block w-full p-2.5 dark:bg-dark_input dark:hover:bg-dark_input_border dark:border-dark_input_border dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-400 dark:focus:border-blue-400"
                            required>
                        <input type="hidden" name="format-amount" id="format-amount"
                            value="{{ number_format($assetData->amount) }}" required>
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </div>
                    <div class="registration_date-input w-full">
                        <label for="registration_date"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"><i
                                class="fa-regular fa-circle-check text-rose-500 me-0.5"></i>{{ __('registration_date') }}</label>
                        <div class="calender-input-icon">
                            <input type="date" name="registration_date" id="registration_date"
                                value="{{ $assetData->registration_date }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-400 focus:border-blue-400 block w-full p-2.5 dark:bg-dark_input dark:hover:bg-dark_input_border dark:border-dark_input_border dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-400 dark:focus:border-blue-400"
                                required>
                            <i class="fa-regular fa-calendar text-gray-500 dark:text-white"></i>
                        </div>
                        <x-input-error :messages="$errors->get('registration_date')" class="mt-2" />
                    </div>
                    <div class="genre-select-box">
                        <label for="genre_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"><i
                                class="fa-regular fa-circle-check text-rose-500 me-0.5"></i>{{ __('genre_name') }}</label>
                        <select id="genre_id" name="genre_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-400 focus:border-blue-400 block w-full p-2.5 dark:bg-dark_input dark:hover:bg-dark_input_border dark:border-dark_input_border dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-400 dark:focus:border-blue-400"
                            required>
                            <option value="{{ $assetData->genre_id }}">{{ $assetData->genre_name }}</option>
                            @foreach ($genres as $genre)
                                <option value="{{ $genre->id }}">{{ $genre->name }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="{{ $assetData->genre_name }}" value="{{ $assetData->genre_id }}">
                        <x-input-error :messages="$errors->get('genre')" class="mt-2" />
                    </div>
                    <div class="catagory-select-box">
                        <label for="category_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"><i
                                class="fa-regular fa-circle-check text-rose-500 me-0.5"></i>{{ __('category_name') }}</label>
                        <select id="category_id" name="category_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-400 focus:border-blue-400 block w-full p-2.5 dark:bg-dark_input dark:hover:bg-dark_input_border dark:border-dark_input_border dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-400 dark:focus:border-blue-400"
                            required>
                            <option value="{{ $assetData->category_id }}">{{ $assetData->category_name }}</option>
                        </select>
                        <input type="hidden" name="{{ $assetData->category_name }}"
                            value="{{ $assetData->category_id }}">
                        <x-input-error :messages="$errors->get('category')" class="mt-2" />
                    </div>
                    <div class="sm:col-span-2">
                        <p class="mb-2 text-sm font-medium text-gray-900 dark:text-white"><i
                                class="fa-regular fa-circle-check text-rose-500 me-0.5"></i>{{ __('assets_type') }}</p>
                        <ul class="grid gap-3 sm:gap-6 md:grid-cols-2">
                            <li>
                                <input type="checkbox" id="current-asset" name="asset_type_flg" value="0"
                                    class="hidden peer">
                                <label for="current-asset"
                                    class="inline-flex items-center justify-between w-full p-2.5 text-gray-500 bg-gray-50 border border-gray-300 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-table peer-checked:border-green-500 hover:text-gray-600 dark:peer-checked:text-white peer-checked:text-gray-800 hover:bg-green-50 dark:text-dark_sub_text dark:bg-dark_input dark:hover:bg-dark_input_border dark:border-dark_input_border">
                                    <div class="block">
                                        <div class="w-full font-semibold mb-2"><i
                                                class="fa-solid fa-money-bill-trend-up text-green-500 me-1"></i>{{ __('current-asset') }}
                                        </div>
                                        <div class="w-full text-sm">
                                            <i class="fa-solid fa-circle-info text-green-500 mb-0.5"></i>
                                            資産の価値が毎月<u class="underline font-semibold">変動する</u>場合はこちらを選択してください
                                        </div>
                                    </div>
                                </label>
                            </li>
                            <li>
                                <input type="checkbox" id="fixed-asset" name="asset_type_flg" value="1"
                                    class="hidden peer">
                                <label for="fixed-asset"
                                    class="inline-flex items-center justify-between w-full p-2.5 text-gray-500 bg-gray-50 border border-gray-300 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-table peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-white peer-checked:text-gray-800 hover:bg-blue-50 dark:text-dark_sub_text dark:bg-dark_input dark:hover:bg-dark_input_border dark:border-dark_input_border">
                                    <div class="block">
                                        <div class="w-full font-semibold mb-2"><i
                                                class="fa-solid fa-vault text-blue-600 me-1"></i>{{ __('fixed-asset') }}
                                        </div>
                                        <div class="w-full text-sm"><i
                                                class="fa-solid fa-circle-info text-blue-600 mb-0.5"></i>
                                            資産の価値が毎月<u class="underline font-semibold">変動しない</u>場合はこちらを選択してください
                                        </div>
                                    </div>
                                </label>
                            </li>
                        </ul>
                        <input type="hidden" id="asset-type-flg" value="{{ $assetData->asset_type_flg }}">
                    </div>
                </div>
                <div class="edit-btn-group mt-6 flex justify-center gap-5 sm:block">
                    <button id="updated-btn"
                        class="me-4 text-white bg-green-500 hover:bg-green-600 focus:outline-none focus:ring-4 focus:ring-green-700 font-medium rounded-lg px-3 py-2.5 text-center inline-flex items-center dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-700"><svg
                            id="updated-icon" class="w-6 h-6 me-2 text-white dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M17.7 7.7A7.1 7.1 0 0 0 5 10.8M18 4v4h-4m-7.7 8.3A7.1 7.1 0 0 0 19 13.2M6 20v-4h4" />
                        </svg>
                        <svg aria-hidden="true" role="status" id="updated-loading-icon"
                            class="w-6 h-6 me-2 text-white animate-spin hidden" viewBox="0 0 100 101" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                fill="#E5E7EB" />
                            <path
                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                fill="currentColor" />
                        </svg>
                        <svg id="plus-icon" class="w-6 h-6 me-2 text-white dark:text-white hidden" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 7.757v8.486M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <span id="updated-text">{{ __('update') }}</span></button>
                    <a id="deleted-btn" data-modal-target="deleted-modal" data-modal-toggle="deleted-modal"
                        class="cursor-pointer text-red-500 focus:outline-none bg-white border-2 border-red-500 hover:bg-red-50 focus:z-10 focus:ring-4 focus:ring-red-600 font-semibold rounded-lg px-5 py-2.5 text-center inline-flex items-center"><svg
                            id="deleted-icon" class="w-6 h-6 me-2 text-red-500" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                        </svg>
                        {{ __('delete') }}</a>
                </div>
            </form>
        </div>
    </section>

    {{-- 削除モーダル画面 --}}
    <div class="alert-modal">
        <div id="deleted-modal" tabindex="-1"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow dark:bg-dark_table  border-2 border-red-500">
                    <button type="button"
                        class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="deleted-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="p-4 md:p-5 text-center">
                        <svg class="mx-auto mb-4 text-rose-500 w-12 h-12" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-white">
                            {{ __('delete_check_message') }}</h3>
                        <div class="flex justify-center gap-4">
                            <form id="deleted-modal-form" class=""
                                action="{{ route('assets.destroy', [$assetData->id]) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" id="deleted-modal-btn"
                                    class="text-white bg-red-500 hover:bg-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 text-md font-medium rounded-lg inline-flex items-center px-5 py-2.5 text-center">
                                    <svg id="deleted-modal-icon" class="w-6 h-6 me-2 text-white" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                    </svg>
                                    <svg aria-hidden="true" role="status" id="deleted-loading-icon"
                                        class="w-4 h-4 me-3 text-white animate-spin hidden" viewBox="0 0 100 101"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                            fill="#E5E7EB" />
                                        <path
                                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                            fill="currentColor" />
                                    </svg>
                                    {{ __('delete') }}
                                </button>
                            </form>
                            <button data-modal-hide="deleted-modal" type="button"
                                class="py-2.5 px-5 text-md font-medium rounded-lg text-gray-900 focus:outline-none bg-white border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-white dark:bg-dark_table dark:hover:bg-gray-700">
                                {{ __('cancel_btn') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('scripts')
        <script type="text/javascript">
            const categories = {!! json_encode($categories) !!}
        </script>
    @endsection
    @push('script-files')
        @vite(['resources/js/asset-update.js', 'resources/js/create-with-update.js'])
    @endpush
</x-app-layout>
