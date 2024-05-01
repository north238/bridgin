@php
    $firstOfMonth = date('Y-m', strtotime($formatDate));
@endphp
<form id="month-form-data" class="flex flex-col sm:flex-row justify-around items-center" method="POST" action="">
    @csrf
    <div class="calender-input-icon">
        <input type="month" name="start" id="start" value="{{ $firstOfMonth }}"
            class="bg-white tesxt-md font-medium border rounded-s-lg border-gray-300 text-slate-700 dark:text-white focus:ring-blue-400 focus:border-blue-400 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-400 dark:focus:border-blue-400"
            required>
    </div>
    <button type="submit" class="text-white font-medium h-full border rounded-e-lg w-full py-2 px-3.5 bg-blue-700 border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"><i class="fa-solid fa-magnifying-glass"></i><span class="sr-only">Search</span></button>

    <input type="hidden" id="first-day-of-month" name="first-day-of-month" value="{{ $firstOfMonth }}">
</form>
