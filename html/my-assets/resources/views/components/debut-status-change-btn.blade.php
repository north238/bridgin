<form id="asset-switch-form" action="{{ route('assets.userDisplayMethodChange') }}" method="post">
    @csrf
    <input type="hidden" id="debut-status" name="debut-status" value={{ $value }}>
    <button type="submit"
        class="px-3 py-2 font-medium text-slate-600 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white"><i
            class="fa-solid fa-toggle-off me-2"></i>{{__('display_change')}}</button>
</form>
