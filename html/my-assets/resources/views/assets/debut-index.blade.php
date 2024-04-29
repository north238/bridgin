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
    <div class="container mx-auto p-4 lg:p-8 xl:max-w-7xl dark:bg-gray-700">
        @include('pages.m-debut-table')
    </div>

    @section('scripts')
        <script type="text/javascript">
            //
        </script>
    @endsection

    @push('script-files')
        //
    @endpush

</x-app-layout>
