<x-guest-layout>
    <div class="p-4 sm:p-7">
        <div class="text-start">
            <h1 class="block text-xl font-semibold text-gray-800 dark:text-white">{{ __('register') }}</h1>
        </div>
        <hr class="h-px mb-6 mt-3 bg-gray-200 border-1 dark:border-dark_border dark:bg-dark_bg">
        <div class="mt-5">
            <a href="{{ route('login.google') }}"
                class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800">
                <svg class="w-4 h-auto" width="46" height="47" viewBox="0 0 46 47" fill="none">
                    <path
                        d="M46 24.0287C46 22.09 45.8533 20.68 45.5013 19.2112H23.4694V27.9356H36.4069C36.1429 30.1094 34.7347 33.37 31.5957 35.5731L31.5663 35.8669L38.5191 41.2719L38.9885 41.3306C43.4477 37.2181 46 31.1669 46 24.0287Z"
                        fill="#4285F4" />
                    <path
                        d="M23.4694 47C29.8061 47 35.1161 44.9144 39.0179 41.3012L31.625 35.5437C29.6301 36.9244 26.9898 37.8937 23.4987 37.8937C17.2793 37.8937 12.0281 33.7812 10.1505 28.1412L9.88649 28.1706L2.61097 33.7812L2.52296 34.0456C6.36608 41.7125 14.287 47 23.4694 47Z"
                        fill="#34A853" />
                    <path
                        d="M10.1212 28.1413C9.62245 26.6725 9.32908 25.1156 9.32908 23.5C9.32908 21.8844 9.62245 20.3275 10.0918 18.8588V18.5356L2.75765 12.8369L2.52296 12.9544C0.909439 16.1269 0 19.7106 0 23.5C0 27.2894 0.909439 30.8731 2.49362 34.0456L10.1212 28.1413Z"
                        fill="#FBBC05" />
                    <path
                        d="M23.4694 9.07688C27.8699 9.07688 30.8622 10.9863 32.5344 12.5725L39.1645 6.11C35.0867 2.32063 29.8061 0 23.4694 0C14.287 0 6.36607 5.2875 2.49362 12.9544L10.0918 18.8588C11.9987 13.1894 17.25 9.07688 23.4694 9.07688Z"
                        fill="#EB4335" />
                </svg>
                Log in with Google
            </a>
            <div
                class="py-5 flex items-center text-xs text-gray-400 uppercase before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6 dark:text-neutral-500 dark:before:border-neutral-600 dark:after:border-neutral-600">
                Or</div>

            <form method="POST" action="{{ route('register') }}" novalidate>
                @csrf
                <div class="grid gap-y-4">
                    <!-- Name -->
                    <div>
                        <x-input-label for="name">
                            <i class="fa-solid fa-user text-slate-600 pr-2"></i>{{ __('Name') }}
                        </x-input-label>
                        <x-text-input id="name" class="block mt-1 w-full py-3 px-4" type="text" name="name"
                            :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email">
                            <i class="fa-solid fa-envelope text-slate-600 pr-2"></i>{{ __('Email') }}
                        </x-input-label>
                        <x-text-input id="email" class="block mt-1 w-full py-3 px-4" type="email" name="email"
                            :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <!-- Password -->
                    <div>
                        <div class="flex justify-between items-center">
                            <x-input-label for="password">
                                <i class="fa-solid fa-key text-slate-600 pr-2"></i>{{ __('Password') }}
                            </x-input-label>
                        </div>
                        <x-text-input id="password" class="block mt-1 w-full py-3 px-4" type="password" name="password"
                            required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation">
                            <i class="fa-solid fa-key text-slate-600 pr-2"></i>{{ __('Confirm Password') }}
                        </x-input-label>
                        <x-text-input id="password_confirmation" class="block mt-1 w-full py-3 px-4" type="password"
                            name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <button
                            class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                            :href="route('assets.dashboard')">
                            {{ __('register') }}
                        </button>
                    </div>
                    <div class="flex gap-2 justify-center items-center">
                        <p class="block font-medium text-sm text-slate-600 dark:text-white">
                            {{ __('Already registered?') }}</p>
                        @if (Route::has('register'))
                            <a class="text-sm text-blue-600 hover:underline font-medium"
                                href="{{ route('login') }}">ログインページへ<i class="fa-solid fa-angle-right ml-2"></i></a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
