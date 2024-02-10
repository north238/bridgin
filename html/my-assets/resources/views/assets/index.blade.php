<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('assets') }}
        </h2>
    </x-slot>

    @include('components.m_table')

</x-app-layout>
