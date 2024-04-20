<x-app-layout>
    @if (session('success-message'))
        <div class="alert-message">
            <x-alert-message name="success" color="green">
                {{ session('success-message') }}
            </x-alert-message>
        </div>
    @endif
    @if (session('error-message'))
        <div class="alert-message">
            <x-alert-message name="error" color="red">
                {{ session('error-message') }}
            </x-alert-message>
        </div>
    @endif
    <div class="block my-20 p-6 bg-slate-50 border border-gray-200 rounded-lg shadow">
        <div>
            @include('components.restore-table')
        </div>
    </div>
</x-app-layout>
