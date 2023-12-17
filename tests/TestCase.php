<?php

namespace Ideacatlab\LaravelCookieConsentEnhanced\Test;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Ideacatlab\LaravelCookieConsentEnhanced\CookieConsentServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            CookieConsentServiceProvider::class,
        ];
    }

    /**
     * Set up the environment.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('laravel-blade-javascript.namespace', 'js');
        $app['config']->set('view.paths', [__DIR__ . '/stubs/views']);
    }
}
