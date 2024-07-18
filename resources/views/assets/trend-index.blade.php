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
            <x-alert-message name="error" color="rose">
                {{ session('error-message') }}
            </x-alert-message>
        </div>
    @endif
    <div class="container mx-auto p-4 lg:p-8 xl:max-w-7xl">
        <div class="flex items-center justify-between">
            <div class="grow">
                <h1 class="text-2xl font-semibold text-slate-800 dark:text-white">{{__('assets_trend')}}</h1>
            </div>
            <div
                class="flex px-2">
                <a href="{{ route('assets.create') }}"
                    class="text-sm sm:text-base font-medium text-blue-600 dark:text-blue-500 hover:underline">
                    <span>{{__('asset_create_btn')}}</span><i class="fa-solid fa-angle-right ml-2"></i>
                </a>
            </div>
        </div>
        <hr class="h-px mb-6 mt-3 bg-gray-200 border-1 dark:border-dark_border dark:bg-dark_bg">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:gap-8">
            @include('chart.yearly-chart')
            @include('chart.monthly-chart')
        </div>
    </div>

    @section('scripts')
    <script type="text/javascript">
        const categoryArrays = {!! @json_encode($assetsMonthlyData['categoryArrays']) !!};
            const categoryColorArrays = {!! @json_encode($assetsMonthlyData['categoryColorArrays']) !!};
            const genreArrays = {!! @json_encode($assetsMonthlyData['genreArrays']) !!};
            const genreColorArrays = {!! @json_encode($assetsMonthlyData['genreColorArrays']) !!};
            const labels = {!! @json_encode($assetsYearlyData['labels']) !!};
            const assetsDataArray = {!! @json_encode($assetsYearlyData['assetsDataArray']) !!};
            const debutDataArray = {!! @json_encode($assetsYearlyData['debutDataArray']) !!};
            const yearlyDataArray = {!! @json_encode($assetsYearlyData['yearlyDataArray']) !!};
    </script>
@endsection
</x-app-layout>
