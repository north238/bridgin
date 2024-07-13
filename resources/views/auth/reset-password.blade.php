<x-guest-layout>
    <div class="p-4 sm:p-7">
        <div class="text-start">
            <h1 class="block text-xl font-semibold text-gray-800 dark:text-white">{{ __('Reset Password') }}</h1>
        </div>
        <hr class="h-px mb-6 mt-3 bg-gray-200 border-1 dark:border-dark_border dark:bg-dark_bg">

        <form method="POST" action="{{ route('password.store') }}" novalidate>
            @csrf
            <div class="grid gap-y-4">
                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div>
                    <x-input-label for="email">
                        <i class="fa-solid fa-envelope text-slate-600 pr-2"></i>{{ __('Email') }}
                    </x-input-label>
                    <x-text-input id="email" class="block mt-1 w-full py-3 px-4" type="email" name="email"
                        :value="old('email')" required autofocus />
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
                        type="submit">
                        {{ __('Reset Password') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-guest-layout>
