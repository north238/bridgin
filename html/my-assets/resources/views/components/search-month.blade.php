@php
    $firstOfMonth = date('Y-m', strtotime($formatDate));
@endphp
<form id="month-form-data" class="flex items-center" method="POST" action="{{route('search.index')}}">
    @csrf
    <div class="calender-input-icon">
        <input type="month" name="form-date" id="form-date" value="{{ $firstOfMonth }}"
            class="bg-white tesxt-md font-medium border rounded-s-lg border-gray-300 text-slate-600 dark:text-white focus:ring-blue-400 focus:border-blue-400 block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-400 dark:focus:border-blue-400"
            required>
    </div>
    <button type="submit"
        class="text-white font-medium h-full border rounded-e-lg w-full py-2 px-3.5 bg-green-500 border-green-500 hover:bg-green-400 focus:ring-2 focus:outline-none focus:ring-green-400"><i
            class="fa-solid fa-magnifying-glass"></i><span class="sr-only">Search</span></button>

    <input type="hidden" id="first-day-of-month" name="first-day-of-month" value="{{ $firstOfMonth }}">
</form>
