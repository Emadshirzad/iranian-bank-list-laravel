<?php

namespace EmadShirzad\IranianBank\Providers;

use EmadShirzad\IranianBank\Services\IranianBankService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class IranianBankServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('iranBank', function ($app) {
            return new IranianBankService();
        });

        // Register the service class in the container
        $this->app->bind(IranianBankService::class, function ($app) {
            return $app->make('iranBank');
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Publish migrations (optional - allows users to customize)
        $this->publishes([
            __DIR__ . '/../database/migrations'                    => database_path('migrations'),
            __DIR__ . '/../database/seeders/IranianBankSeeder.php' => database_path('seeders/IranianBankSeeder.php'),
            __DIR__ . '/../Models/IranianBank.php'                 => app_path('Models/IranianBank.php'),
            __DIR__ . '/../../assets/images'                       => public_path('vendor/iranian-bank/images'),
        ], 'iranian-bank-config');
    }
}
