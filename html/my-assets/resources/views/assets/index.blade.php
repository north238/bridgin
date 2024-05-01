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
    <div class="container mx-auto p-4 lg:p-8 xl:max-w-7xl">
        @include('pages.m-table')
    </div>

    @section('scripts')
        <script type="text/javascript">
            const formatDate = "{{ $formatDate }}";
            const sortUrl = "{{ route('sort.get') }}";
            const redirectIndex = "{{ route('assets.index') }}"
        </script>
    @endsection

    @push('script-files')
        @vite(['resources/js/debut-display-switching.js'])
    @endpush

</x-app-layout>
