<x-app-layout>
    <section class="bg-white dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
            <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">資産の追加</h2>
            @foreach ($assetData as $asset)
                @if (session('error-message'))
                    <x-alert-message name="error" color="bg-red-50">
                        {{ session('error-message') }}
                    </x-alert-message>
                @endif
                <form class="validated-form mb-2" method="post" action="{{ route('assets.store') }}" novalidate>
                    @csrf
                    <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                        <div class="sm:col-span-2">
                            <label for="name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">資産名</label>
                            <input type="text" name="name" id="name" value="{{ $asset['name'] }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                required>
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="w-full">
                            <label for="amount"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">資産額</label>
                            <input type="number" name="amount" id="amount" value="{{ $asset['amount'] }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                required>
                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                        </div>
                        <div class="w-full">
                            <label for="registration_date"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">登録日</label>
                            <input type="date" name="registration_date" id="registration_date"
                                value="{{ $asset['registration_date'] }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                required>
                            <x-input-error :messages="$errors->get('registration_date')" class="mt-2" />
                        </div>
                        <div>
                            <label for="genre_id"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">ジャンル</label>
                            <select id="genre_id" name="genre_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category['genre']['id'] }}">{{ $category['genre']['name'] }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('genre')" class="mt-2" />
                        </div>
                        <div>
                            <label for="category_id"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">カテゴリ</label>
                            <select id="category_id" name="category_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                required>
                                <option value="{{ $asset['category']['id'] }}">{{ $asset['category']['name'] }}
                                </option>
                            </select>
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>
                        <div class="d-grid my-3">
                            <button class="btn btn-outline-success">編集する</button>
                        </div>
                    </div>
                </form>
            @endforeach
        </div>
    </section>
</x-app-layout>
