
<p align="center"><a href="https://ideacat.ro" target="_blank"><img src="https://raw.githubusercontent.com/ideacatlab/laravel-cookie-consent-enhanced/master/.github/images/github-cookie-consent-logo.png" width="400"></a></p>

# Elevate Your Laravel App's GDPR Compliance with Enhanced Cookie Consent

Ensuring compliance with EU laws on cookie usage is crucial for websites targeting or owned by EU citizens. Dive into the capabilities of this Laravel package, a robust extension originating from [Spatie's Laravel Cookie Consent](https://github.com/spatie/laravel-cookie-consent). Developed by IdeaCat, a web development agency in Bucharest, Romania, this package not only simplifies the implementation of a cookie consent dialog but also extends its functionalities. Beyond the essentials, it introduces advanced features like predefined database tables, administrative tools for user data management, and seamless integration of GDPR compliance requirements.

Explore further details about the EU legislation on cookies [here](http://ec.europa.eu/ipg/basics/legal/cookies/index_en.htm#section_2).

## Installation and Configuration

### 1. Install the Package

You can effortlessly install the package via Composer. Open your terminal and run:

```bash
composer require ideacatlab/laravel-cookie-consent-enhanced
```

The package will automatically register itself in your Laravel application.

### 2. Publish Vendor Files 

Run the publish command to publish the views, languages, database migration, config and assets.

```sh
php artisan vendor:publish --provider="Ideacatlab\LaravelCookieConsentEnhanced\CookieConsentServiceProvider"
```


### 3. Migrate the Database

Execute the migration command to create the required database tables:

```bash
php artisan migrate
```

### Configuration Details

Upon publishing the configuration file, you'll find a file named `cookie-consent-enhanced.php` in the `config` directory. Here's an overview of the configuration options:

```php
return [

    /*
     * Use this setting to enable the cookie consent dialog.
     */
    'enabled' => env('COOKIE_CONSENT_ENABLED', true),

    /*
     * The name of the cookie in which we store if the user
     * has agreed to accept the conditions.
     */
    'cookie_name' => 'cookie_consent',

    /*
     * Set the cookie duration in days. Default is 365 * 20.
     */
    'cookie_lifetime' => 365 * 20,
];
```

### Note on Cookie Domain

Ensure you set the cookie domain by using the 'domain' key in the `config/session.php` file. Add the corresponding value in your `.env` file for `SESSION_DOMAIN`. If your URL includes a port, such as 'localhost:3000', it is crucial to set this value for the package to function correctly.

## Usage and Customization

### Displaying the Cookie Consent Dialog Using Blade Template

To effortlessly display the cookie consent dialog in your template, include the following line in your Blade file:

```blade
@include('cookie-consent-enhanced::index')
```

This will render a dialog similar to the one depicted below. Note that the default styling, powered by TailwindCSS v2, creates a floating banner at the bottom of the page.

### Displaying the Cookie Consent Dialog Using the Middleware

Instead of manually including `cookie-consent-enhanced::index` in your view, consider adding the middleware to your kernel:

```php
// app/Http/Kernel.php

class Kernel extends HttpKernel
{
    protected $middleware = [
        // ...
        \Ideacatlab\LaravelCookieConsentEnhanced\CookieConsentMiddleware::class,
    ];

    // ...
}
```

This will automatically add `cookie-consent-enhanced::index` to your response just before the closing body tag.

![Cookie Consent Dialog](https://raw.githubusercontent.com/ideacatlab/laravel-cookie-consent-enhanced/master/.github/images/dialog.png)

Upon clicking "Allow cookies," a `cookie_consent` cookie will be set, and the dialog will be removed from the DOM. Laravel, recognizing the set `laravel_cookie_consent` cookie on subsequent requests, will refrain from displaying the dialog again.

### Customizing Dialog Texts

The files is published to `resources/lang/vendor/cookie-consent-enhanced/en/texts.php`. You can then customize the text as follows:

```php
return [
    'message' => 'Please be informed that this site uses cookies.',
    'agree' => 'Allow cookies',
];
```

For translations, copy the file to, for instance, `resources/lang/vendor/cookie-consent-enhanced/fr/texts.php` and provide the French translations.

### Customizing Dialog Contents

The files is published to the `index` and `dialogContents` view files to `resources/views/vendor/cookie-consent-enhanced`. Typically, you only need to modify the `dialogContents` view. Adjusting the JavaScript code is possible in the `index` view file.

## Testing

Execute the following command to run tests:

```bash
composer test
```

## Security

If you discover any security-related issues, please contact razvan@ideacat.ro instead of using the issue tracker.

## License

This project is licensed under the MIT License. See [License File](LICENSE.md) for more information.