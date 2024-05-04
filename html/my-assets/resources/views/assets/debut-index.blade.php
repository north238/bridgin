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
        <div>
            <h1 class="mb-0.5 text-xl font-semibold dark:text-white">負債データの一覧</h1>
            <h2 class="ml-1 mb-1 first-line:text-md text-slate-600 dark:text-white">
                直近の負債データを表示しています
            </h2>
        </div>
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
