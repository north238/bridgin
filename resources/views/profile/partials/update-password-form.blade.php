<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-white">
            {{ __('Update Password') }}
        </h2>
        <hr class="h-px mb-6 mt-3 bg-gray-200 border-1 dark:border-dark_border dark:bg-dark_bg">

        <p class="mt-1 text-sm text-gray-600 dark:text-dark_sub_text">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6">
        @csrf
        @method('put')

        <div class="flex justify-between items-center">
            <x-input-label for="password" class="dark:text-white">
                <i class="fa-solid fa-key text-slate-600 dark:text-white pr-2"></i>{{ __('Current Password') }}
            </x-input-label>
            @if (Route::has('password.request'))
                <a class="text-sm text-blue-600 hover:underline font-medium"
                    href="{{ route('password.request') }}">{{ __('forget_link') }}<i
                        class="fa-solid fa-angle-right ml-2"></i></a>
            @endif
        </div>
        <x-text-input id="update_password_current_password" name="current_password" type="password"
            class="mt-0 block w-full dark:bg-dark_input dark:hover:bg-dark_input_border dark:border-dark_input_border dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-400 dark:focus:border-blue-400"
            autocomplete="current-password" />
        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />

        <div class="mt-4">
            <x-input-label for="password" class="dark:text-white">
                <i class="fa-solid fa-key text-slate-600 dark:text-white pr-2"></i>{{ __('New Password') }}
            </x-input-label>
            <x-text-input id="update_password_password" name="password" type="password"
                class="mt-1 block w-full dark:bg-dark_input dark:hover:bg-dark_input_border dark:border-dark_input_border dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-400 dark:focus:border-blue-400"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" class="dark:text-white">
                <i class="fa-solid fa-key text-slate-600 dark:text-white pr-2"></i>{{ __('Confirm Password') }}
            </x-input-label>
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="mt-1 block w-full dark:bg-dark_input dark:hover:bg-dark_input_border dark:border-dark_input_border dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-400 dark:focus:border-blue-400"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4 mt-4">
            <button
                class="py-2 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                {{ __('Save') }}
            </button>
        </div>
    </form>
</section>
