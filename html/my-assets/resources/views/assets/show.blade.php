<x-app-layout>
    <section class="bg-white dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
            <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">資産の追加</h2>
            @if (session('error-message'))
                <x-alert-message name="error" color="bg-red-50">
                    {{ session('error-message') }}
                </x-alert-message>
            @endif
            <form class="validated-form mb-2" method="post" action="{{ route('assets.update', [$assetData->id]) }}"
                novalidate>
                @csrf
                @method('PATCH')
                <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                    <div class="sm:col-span-2">
                        <label for="name"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">資産名</label>
                        <input type="text" name="name" id="name" value="{{ $assetData->name }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            required>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div class="w-full">
                        <label for="amount"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">資産額</label>
                        <input type="number" name="amount" id="amount" value="{{ $assetData->amount }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            required>
                        <input type="hidden" name="format-amount" id="format-amount"
                            value="{{ number_format($assetData->amount) }}" required>
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </div>
                    <div class="w-full">
                        <label for="registration_date"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">登録日</label>
                        <input type="date" name="registration_date" id="registration_date"
                            value="{{ $assetData->registration_date }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            required>
                        <x-input-error :messages="$errors->get('registration_date')" class="mt-2" />
                    </div>
                    {{-- Todo:: 動的に保存されているデータと置き換える --}}
                    <div>
                        <label for="genre_id"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ジャンル</label>
                        <select id="genre_id" name="genre_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->genre->id }}">{{ $category->genre->name }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="{{ $assetData->genre_name }}" value="{{ $assetData->genre_id }}">
                        <x-input-error :messages="$errors->get('genre')" class="mt-2" />
                    </div>
                    <div>
                        <label for="category_id"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">カテゴリ</label>
                        <select id="category_id" name="category_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="{{ $assetData->category_name }}"
                            value="{{ $assetData->category_id }}">
                        <x-input-error :messages="$errors->get('category')" class="mt-2" />
                    </div>
                    <div class="">
                        <button
                            class="text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2.5 text-center inline-flex items-center me-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"><svg
                                class="w-5 h-5 me-2 text-white dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17.7 7.7A7.1 7.1 0 0 0 5 10.8M18 4v4h-4m-7.7 8.3A7.1 7.1 0 0 0 19 13.2M6 20v-4h4" />
                            </svg>{{__('update')}}</button>
                    </div>
                </div>
            </form>
            <form action="{{ route('assets.destroy', [$assetData->id]) }}" method="post">
                @csrf
                @method('DELETE')
                    <button
                        class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center inline-flex items-center me-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900"><svg
                            class="w-5 h-5 me-2 text-white dark:text-white" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                        </svg>{{__('delete')}}</button>
            </form>
        </div>
    </section>
</x-app-layout>
