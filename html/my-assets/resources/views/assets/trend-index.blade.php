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
    <div class="block m-6 p-6 bg-slate-50 border border-gray-200 rounded-lg shadow">
        <x-slot name="header">
            <h2 class="font-semibold text-gray-800 leading-tight">
                {{ __('asset_trend') }}
            </h2>
        </x-slot>
        <div class="flex justify-between items-center gap-4 mx-12 my-5">
            <div
                class="flex flex-row items-center gap-3 p-3 bg-white dark:bg-gray-800 border border-gray-200 rounded-lg">
                <h2 class="text-2xl font-medium title-font text-gray-900 dark:text-white">
                    {{ __('total_amount') }}</h2>
                <p class="text-base dark:text-white">
                {{-- <p class="text-xl">{{ number_format($totalAmount) }}<span>円</span></p> --}}
                </p>
            </div>
            <div class="p-3 bg-white dark:bg-gray-800 border border-gray-200 rounded-lg align-middle">
                <form id="asset-switch-form" action="{{ route('assets.userDisplayMethodChange') }}" method="post">
                    @csrf
                    {{-- <input type="hidden" id="debut-status" name="debut-status" value={{ $debutStatus }}> --}}
                    <button type="submit">表示切替</button>
                </form>
            </div>
        </div>
        <div>
            <canvas id="asset-chart"></canvas>
        </div>
    </div>
    {{-- @section('scripts')
        <script type="text/javascript">
            const formatDate = "{{ $formatDate }}";
            const assetMinDate = "{{ $assetMinDate }}";
            const sortUrl = "{{ route('sort.get') }}";
            const redirectIndex = "{{ route('assets.index') }}"
        </script>
    @endsection --}}
    @push('script-files')
        @vite(['resources/js/asset-trend-chart.js'])
    @endpush
</x-app-layout>
