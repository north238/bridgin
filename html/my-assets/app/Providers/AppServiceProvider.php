<?php

namespace App\Providers;

use Orchid\Icons\IconFinder;
use Illuminate\Support\ServiceProvider;
use App\View\Components\CsvDownload;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider

{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(IconFinder $iconFinder): void
    {
        // $iconFinder->registerIconDirectory('fa', storage_path('app/icons'));
        Blade::component('csv-download', CsvDownload::class);
    }
}
