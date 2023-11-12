<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Folio\Folio;

class FolioServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Folio::path(resource_path('views/pages/stock'))
            ->uri('/stock')
            ->middleware([
                '*' => [
                    'auth:sanctum',
                    'verified',
                    'warehouse',
                    config('jetstream.auth_session'),
                ],
            ]);

        Folio::path(resource_path('views/pages'))->middleware([
            '*' => [
                //
            ],
        ]);
    }
}
