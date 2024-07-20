@php
    if(empty($value)) {
        $value = now();
    }
    $firstOfMonth = date('Y-m', strtotime($value));
@endphp
<form id="month-form-data" class="flex items-center" method="POST" action="{{ route('search.index') }}" novalidate>
    @csrf
    <div class="calender-input-icon">
        <input type="month" name="search-date" id="search-date" value="{{ $firstOfMonth }}"
            class="text-sm sm:text-base py-3 border-0 border-b-2 border-gray-300 bg-transparent focus:border-blue-400 focus:outline-none appearance-non focus:ring-0 text-slate-600 block w-28 sm:w-32 dark:border-gray-700 dark:text-white dark:focus:border-blue-500"
            required>
    </div>
    <button type="submit"
        class="text-gray-600 dark:text-white hover:transform hover:duration-200 hover:-translate-y-1"><i
            class="fa-solid fa-magnifying-glass"></i><span class="sr-only">Search</span></button>

    <input type="hidden" name="debut-search-flg" value="{{ $status }}">
    <input type="hidden" id="first-day-of-month" name="first-day-of-month" value="{{ $firstOfMonth }}">
</form>
