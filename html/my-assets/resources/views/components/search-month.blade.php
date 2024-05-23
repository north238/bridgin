@php
    $firstOfMonth = date('Y-m', strtotime($value));
@endphp
<form id="month-form-data" class="flex items-center" method="POST" action="{{ route('search.index') }}">
    @csrf
    <div class="calender-input-icon">
        <input type="month" name="form-date" id="form-date" value="{{ $firstOfMonth }}"
            class="bg-white py-3 border rounded-s-lg border-gray-300 text-slate-600 focus:ring-blue-400 focus:border-blue-400 block w-full dark:bg-gray-800 dark:hover:bg-gray-700 dark:border-gray-700 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-400 dark:focus:border-blue-400"
            required>
            <i class="fa-regular fa-calendar text-gray-500 dark:text-white"></i>
    </div>
    <button type="submit"
        class="text-white font-medium h-full border rounded-e-lg w-full py-2 px-3.5 bg-blue-500 border-blue-500 hover:bg-blue-700 focus:ring-2 focus:outline-none focus:ring-blue-400"><i
            class="fa-solid fa-magnifying-glass"></i><span class="sr-only">Search</span></button>

    <input type="hidden" id="first-day-of-month" name="first-day-of-month" value="{{ $firstOfMonth }}">
</form>
