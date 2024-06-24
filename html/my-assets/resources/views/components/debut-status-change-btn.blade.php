<form id="asset-switch-form" action="{{ route('assets.userDisplayMethodChange') }}" method="post">
    @csrf
    <input type="hidden" id="debut-status" name="debut-status" value={{ $value }}>
    <button type="submit" data-tooltip-target="debut-status-tooltip" data-tooltip-placement="bottom"
        class="px-3 py-2 font-medium text-slate-600 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:border-dark_border dark:bg-dark_table dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white"><i
            class="fa-solid fa-toggle-off"></i><span class="sr-only">表示切替</span></button>
</form>
<div id="debut-status-tooltip" role="tooltip"
    class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
    表示切替
    <div class="tooltip-arrow" data-popper-arrow></div>
</div>
