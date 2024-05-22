<form id="asset-switch-form" action="{{ route('assets.userDisplayMethodChange') }}" method="post">
    @csrf
    <input type="hidden" id="debut-status" name="debut-status" value={{ $debutStatus }}>
    <button type="submit"
        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-s-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white"><i
            class="fa-solid fa-toggle-off me-2"></i>{{__('display_change')}}</button>
</form>
