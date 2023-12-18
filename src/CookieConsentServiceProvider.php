<?php

namespace Ideacatlab\LaravelCookieConsentEnhanced;

use Illuminate\Contracts\View\View;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Support\Facades\Cookie;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CookieConsentServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-cookie-consent-enhanced')
            ->hasConfigFile()
            ->hasViews()
            ->hasTranslations()
            ->hasAssets()
            ->hasViewComposer('cookie-consent-enhanced::index', function (View $view) {
                $cookieConsentConfig = config('cookie-consent-enhanced');

                $alreadyConsentedWithCookies = Cookie::has($cookieConsentConfig['cookie_name']);

                $view->with(compact('alreadyConsentedWithCookies', 'cookieConsentConfig'));
            });
    }

    public function packageBooted(): void
    {
        $this->app->resolving(EncryptCookies::class, function (EncryptCookies $encryptCookies) {
            $encryptCookies->disableFor(config('cookie-consent-enhanced.cookie_name'));
        });

        if (app()->runningInConsole()) {
            $this->registerMigrations();
            $this->publishes([
                __DIR__ . '/../database/migrations' => database_path('migrations'),
            ], 'cookie-consent-enhanced-migrations');
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    // public function boot(): void
    // {
    //     if (app()->runningInConsole()) {
    //         $this->registerMigrations();
    //         $this->publishes([
    //             __DIR__ . '/../database/migrations' => database_path('migrations'),
    //         ], 'cookie-consent-enhanced-migrations');
    //     }
    // }

    /**
     * Register Laravel Cookie Consent Enhanced's migration files.
     *
     * @return void
     */
    protected function registerMigrations()
    {
        if (CookieConsentMiddleware::shouldRunMigrations()) {
            return $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        }
    }
}
