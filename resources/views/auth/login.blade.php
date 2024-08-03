<x-guest-layout>
    <div class="p-4 sm:p-7">
        <div class="text-start">
            <h1 class="block text-xl font-semibold text-gray-800 ">{{ __('user_login') }}</h1>
        </div>
        <hr class="h-px mb-6 mt-3 bg-gray-200 border-1">

        <div class="mt-5">
            <a href="{{ route('login.provider', ['provider' => 'google']) }}"
                class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none">
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
            <a href="{{ route('login.provider', ['provider' => 'github']) }}"
                class="mt-2 w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                    <path
                        d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                </svg>
                Log in with Github
            </a>

            <div
                class="py-5 flex items-center text-xs text-gray-400 uppercase before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6">
                Or</div>

            <form method="POST" action="{{ route('login') }}" novalidate>
                @csrf
                <div class="grid gap-y-4">
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
                            @if (Route::has('password.request'))
                                <a class="text-sm text-blue-600 hover:underline font-medium"
                                    href="{{ route('password.request') }}">お忘れの方はこちら<i
                                        class="fa-solid fa-angle-right ml-2"></i></a>
                            @endif
                        </div>
                        <x-text-input id="password" class="block mt-1 w-full py-3 px-4" type="password" name="password"
                            required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <!-- Remember Me -->
                    <div>
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox"
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
                                name="remember">
                            <span class="ms-2 text-sm text-gray-600 ">{{ __('Remember me') }}</span>
                        </label>
                    </div>
                    <div>
                        <button
                            class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                            :href="route('assets.dashboard')">
                            {{ __('Log in') }}
                        </button>
                    </div>
                    <div class="flex gap-2 justify-center items-center">
                        <p class="block font-medium text-sm text-slate-600 ">アカウントは未登録ですか？</p>
                        @if (Route::has('register'))
                            <a class="text-sm text-blue-600 hover:underline font-medium"
                                href="{{ route('register') }}">新規作成する<i class="fa-solid fa-angle-right ml-2"></i></a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
