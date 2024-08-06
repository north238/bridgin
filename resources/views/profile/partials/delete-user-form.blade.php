<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-white">
            {{ __('Delete Account') }}
        </h2>
        <hr class="h-px mb-6 mt-3 bg-gray-200 border-1 dark:border-dark_border dark:bg-dark_bg">

        <p class="mt-1 text-sm text-gray-600 dark:text-dark_sub_text">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">{{ __('Delete Account') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>
            <hr class="h-px mb-6 mt-3 bg-gray-200 border-1 dark:border-dark_border dark:bg-dark_bg">

            <p class="mt-1 text-sm text-gray-600 dark:text-dark_sub_text">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your name to confirm you would like to permanently delete your account.') }}
                <span class="text-sm text-gray-600 dark:text-white">こちらを入力：{{ $user->name }}</span>
            </p>

            <div class="mt-6 flex flex-col items-center">
                <x-input-label for="delete-name" value="{{ __('delete_user_name') }}" class="sr-only dark:text-white" />

                <x-text-input id="delete-name" name="delete-name" type="text"
                    class="mt-1 block w-3/4 dark:bg-dark_input dark:hover:bg-dark_input_border dark:border-dark_input_border dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-400 dark:focus:border-blue-400"
                    placeholder="{{ __('delete_user_name') }}" :value="old('delete-name')"/>

                <x-input-error :messages="$errors->userDeletion->get('delete-name')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-center">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
