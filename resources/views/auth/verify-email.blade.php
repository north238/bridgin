<x-guest-layout>
    <div class="p-4 sm:p-7">
        <div class="text-start">
            <h1 class="block text-xl font-semibold text-gray-800">{{ __('verify_email_message') }}</h1>
        </div>
        <hr class="h-px mb-6 mt-3 bg-gray-200 border-1">

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <button type="submit"
                        class="w-full py-3 px-4 inline-flex justify-center items-center text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                        {{ __('Resend Verification Email') }}
                    </button>
                </div>

            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                    class="inline-flex items-center text-slate-500 bg-white border border-slate-500 py-3 px-4 focus:outline-none hover:bg-slate-50 rounded-lg text-sm">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
