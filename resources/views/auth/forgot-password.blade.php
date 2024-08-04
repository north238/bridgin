<x-guest-layout>
    <div class="p-4 sm:p-7">
        <div class="text-start">
            <h1 class="block text-xl font-semibold text-gray-800">{{ __('password_reset_email') }}</h1>
        </div>
        <hr class="h-px mb-6 mt-3 bg-gray-200 border-1">

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        <form method="POST" action="{{ route('password.email') }}" novalidate>
            @csrf
            <div class="grid gap-y-4">
                <div>
                    <x-input-label for="email">
                        <i class="fa-solid fa-envelope text-slate-600 pr-2"></i>{{ __('Email') }}
                    </x-input-label>
                    <x-text-input id="email" class="block mt-1 w-full py-3 px-4" type="email" name="email"
                        :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div class="mt-4">
                    <button
                        class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                        type="submit">
                        {{ __('Email Password Reset Link') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-guest-layout>
