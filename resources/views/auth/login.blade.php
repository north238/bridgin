<x-guest-layout>
    <div class="p-4 sm:p-7">
        <div class="text-start">
            <h1 class="block text-xl font-semibold text-gray-800 dark:text-white">{{ __('user_login') }}</h1>
        </div>
        <hr class="h-px mb-6 mt-3 bg-gray-200 border-1 dark:border-dark_border dark:bg-dark_bg">

        <div class="mt-5">
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
                            <span class="ms-2 text-sm text-gray-600 dark:text-white">{{ __('Remember me') }}</span>
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
                        <p class="block font-medium text-sm text-slate-600 dark:text-white">アカウントが未登録ですか？</p>
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
