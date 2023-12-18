<?php

namespace Ideacatlab\LaravelCookieConsentEnhanced;

use Illuminate\Contracts\View\View;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Support\Facades\Cookie;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Illuminate\Support\ServiceProvider;

class CookieConsentServiceProvider extends ServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-cookie-consent')
            ->hasConfigFile()
            ->hasViews()
            ->hasTranslations()
            ->hasViewComposer('cookie-consent::index', function (View $view) {
                $cookieConsentConfig = config('cookie-consent');

                $alreadyConsentedWithCookies = Cookie::has($cookieConsentConfig['cookie_name']);

                $view->with(compact('alreadyConsentedWithCookies', 'cookieConsentConfig'));
            });
    }

    public function packageBooted(): void
    {
        $this->app->resolving(EncryptCookies::class, function (EncryptCookies $encryptCookies) {
            $encryptCookies->disableFor(config('cookie-consent.cookie_name'));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (app()->runningInConsole()) {
            $this->registerMigrations();
            $this->publishes([
                __DIR__ . '/../database/migrations' => database_path('migrations'),
            ], 'cookie-consent-migrations', 'laravel-assets');
            $this->publishes([
                __DIR__ . '/../config/cookie-consent.php' => config_path('cookie-consent.php'),
            ], 'cookie-consent-config');
            $this->publishes([
                __DIR__ . '/../resources/lang' => lang_path('vendor/cookie-consent'),
            ], 'cookie-consent-translations', 'laravel-assets');
            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/cookie-consent'),
            ], 'cookie-consent-views', 'laravel-assets');
            $this->publishes([
                __DIR__ . '/../public/css' => public_path('vendor/cookie-consent'),
            ], 'cookie-consent-assets', 'laravel-assets');
            $this->publishes([
                __DIR__ . '/../public/images' => public_path('vendor/cookie-consent'),
            ], 'cookie-consent-assets', 'laravel-assets');
        }
    }

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
