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
            ->hasAssets('css/cookie-consent.css', 'images/cookie.svg')
            ->hasMigration('create_cookie_consents', 'create_erasure_requests')
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
    //         $this->publishes([
    //             __DIR__ . '/../config/cookie-consent-enhanced.php' => config_path('cookie-consent-enhanced.php'),
    //         ], 'cookie-consent-enhanced-config');
    //         $this->publishes([
    //             __DIR__ . '/../resources/lang' => lang_path('vendor/cookie-consent-enhanced'),
    //         ], 'cookie-consent-enhanced-translations');
    //         $this->publishes([
    //             __DIR__ . '/../resources/views' => resource_path('views/vendor/cookie-consent-enhanced'),
    //         ], 'cookie-consent-enhanced-views');
    //         $this->publishes([
    //             __DIR__ . '/../public/css' => public_path('vendor/cookie-consent-enhanced'),
    //         ], 'cookie-consent-enhanced-assets');
    //         $this->publishes([
    //             __DIR__ . '/../public/images' => public_path('vendor/cookie-consent-enhanced'),
    //         ], 'cookie-consent-enhanced-assets');
    //     }
    // }

    /**
     * Register Laravel Cookie Consent Enhanced's migration files.
     *
     * @return void
     */
    // protected function registerMigrations()
    // {
    //     if (CookieConsentMiddleware::shouldRunMigrations()) {
    //         return $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    //     }
    // }
}
