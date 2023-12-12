<?php

namespace App\Providers;

use Barryvdh\Debugbar\Facades\Debugbar;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Rawilk\FilamentPasswordInput\Password;
use Illuminate\Support\ServiceProvider;
use Spatie\Health\Facades\Health;
use Spatie\Health\Checks\Checks\OptimizedAppCheck;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Checks\Checks\EnvironmentCheck;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;
use Spatie\Health\Checks\Checks\DatabaseConnectionCountCheck;
use Spatie\Health\Checks\Checks\RedisCheck;

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
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        Debugbar::disable();

        FilamentColor::register([
            'indigo' => Color::Indigo,
        ]);

        Password::configureUsing(function (Password $password) {
            $password
                ->label('Contraseña')
                ->copyable()
                ->regeneratePassword()
                ->copyIconColor('warning')
                ->regeneratePasswordIconColor('primary')
                ->dehydrateStateUsing(fn (?string $state): string => Hash::make($state))
                ->dehydrated(fn (?string $state) => filled($state))
                ->required(fn (string $context): bool => $context === 'create');
        });
    }
}
