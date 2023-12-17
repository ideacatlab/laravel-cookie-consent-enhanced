<?php

namespace Ideacatlab\LaravelCookieConsentEnhanced;

use Closure;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class CookieConsentMiddleware
{
    /**
     * Indicates whether migrations should be run for Laravel Cookie Consent Enhanced.
     *
     * @var bool
     */
    public static $runsMigrations = true;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $response = $next($request);

        if (!config('cookie-consent.enabled')) {
            return $response;
        }

        if (!$response instanceof Response) {
            return $response;
        }

        if (!$this->containsBodyTag($response)) {
            return $response;
        }

        return $this->addCookieConsentScriptToResponse($response);
    }

    /**
     * Check if the response contains a closing body tag.
     *
     * @param  \Illuminate\Http\Response  $response
     * @return bool
     */
    protected function containsBodyTag(Response $response): bool
    {
        return $this->getLastClosingBodyTagPosition($response->getContent()) !== false;
    }

    /**
     * Add the Cookie Consent script to the response.
     *
     * @param  \Illuminate\Http\Response  $response
     * @return \Illuminate\Http\Response
     */
    protected function addCookieConsentScriptToResponse(Response $response): Response
    {
        $content = $response->getContent();

        $closingBodyTagPosition = $this->getLastClosingBodyTagPosition($content);

        $content = ''
            . substr($content, 0, $closingBodyTagPosition)
            . view('cookie-consent::index')->render()
            . substr($content, $closingBodyTagPosition);

        return $response->setContent($content);
    }

    /**
     * Get the position of the last closing body tag in the content.
     *
     * @param  string  $content
     * @return bool|int
     */
    protected function getLastClosingBodyTagPosition(string $content = ''): bool | int
    {
        return strripos($content, '</body>');
    }

    /**
     * Determine if Laravel Cookie Consent Enhanced 's migrations should be run.
     *
     * @return bool
     */
    public static function shouldRunMigrations(): bool
    {
        return static::$runsMigrations;
    }

    /**
     * Configure Laravel Cookie Consent Enhanced to not register its migrations.
     *
     * @return static
     */
    public static function ignoreMigrations(): static
    {
        static::$runsMigrations = false;

        return new static;
    }
}
