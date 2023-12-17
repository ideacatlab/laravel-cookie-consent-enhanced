<p align="center"><a href="https://ideacat.ro" target="_blank"><img src="https://raw.githubusercontent.com/ideacatlab/laravel-cookie-consent-enhanced/master/.github/images/github-cookie-consent-logo.png" width="400"></a></p>

# Make your Laravel app comply with the EU law reffering cookie cookie  


All sites owned by EU citizens or targeted towards EU citizens must comply with a EU law referring cookie usage. This law requires a dialog to be displayed to inform the users of your websites how cookies are being used. You can read more info on the legislation on [the site of the European Commission](http://ec.europa.eu/ipg/basics/legal/cookies/index_en.htm#section_2).

This package provides an easily configurable view to display the message. Also included is JavaScript code to set a cookie when a user agrees with the cookie policy. The package will not display the dialog when that cookie has been set.

IdeaCat is a web development agency based in Bucharest, Romania. You'll find an overview of all our open source projects [on our website](https://ideacat.ro/opensource).



## Installation

You can install the package via composer:

``` bash
composer require ideacatlab/laravel-cookie-consent-enhanced
```

The package will automatically register itself.

Optionally you can publish the config-file:

```bash
php artisan vendor:publish --provider="Ideacatlab\LaravelCookieConsentEnhanced\CookieConsentServiceProvider" --tag="cookie-consent-config"
```
Migrate and seed the database

```bash

php artisan migrate --seed"
```
This is the contents of the published config-file:

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
     * Set the cookie duration in days.  Default is 365 * 20.
     */
    'cookie_lifetime' => 365 * 20,
];
```

The cookie domain is set by the 'domain' key in config/session.php, make sure you add a value in your .env for SESSION_DOMAIN. If you are using a domain with a port in the url such as 'localhost:3000', this package will not work until you do so.

## Usage

To display the dialog all you have to do is include this view in your template:

```blade
//in your blade template
@include('cookie-consent::index')
```

This will render the following dialog that, when styled, will look very much like this one.

![dialog](https://spatie.github.io/laravel-cookie-consent/images/dialog.png)

The default styling provided by this package uses TailwindCSS v2 to provide a floating banner at the bottom of the page.

When the user clicks "Allow cookies" a `cookie_consent` cookie will be set and the dialog will be removed from the DOM. On the next request, Laravel will notice that the `laravel_cookie_consent` has been set and will not display the dialog again

## Customising the dialog texts

If you want to modify the text shown in the dialog you can publish the lang-files with this command:

```bash
php artisan vendor:publish --provider="Ideacatlab\LaravelCookieConsentEnhanced\CookieConsentServiceProvider" --tag="cookie-consent-translations"
```

This will publish this file to `resources/lang/vendor/cookie-consent/en/texts.php`.

 ```php
 
 return [
     'message' => 'Please be informed that this site uses cookies.',
     'agree' => 'Allow cookies',
 ];
 ```
 
 If you want to translate the values to, for example, French, just copy that file over to `resources/lang/vendor/cookie-consent/fr/texts.php` and fill in the French translations.
 
### Customising the dialog contents

If you need full control over the contents of the dialog. You can publish the views of the package:

```bash
php artisan vendor:publish --provider="Ideacatlab\LaravelCookieConsentEnhanced\CookieConsentServiceProvider" --tag="cookie-consent-views"
```

This will copy the `index` and `dialogContents` view files over to `resources/views/vendor/cookie-consent`. You probably only want to modify the `dialogContents` view. If you need to modify the JavaScript code of this package you can do so in the `index` view file.

## Using the middleware

Instead of including `cookie-consent::index` in your view you could opt to add the `Ideacatlab\LaravelCookieConsentEnhanced\CookieConsentMiddleware` to your kernel:

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

This will automatically add `cookie-consent::index` to the content of your response right before the closing body tag.

## Notice
The legislation is pretty very vague on how to display the warning, which texts are necessary, and what options you need to provide. This package will go a long way towards compliance, but if you want to be 100% sure that your website is ok, you should consult a legal expert.


## Testing

``` bash
composer test
```

## Contributing

Please see [CONTRIBUTING](https://github.com/ideacatlab/.github/blob/main/CONTRIBUTING.md) for details.

## Security

If you discover any security-related issues, please email razvan@ideacat.ro instead of using the issue tracker.

## Credits

- [Razvan Gheorghe](https://github.com/ideacatlab)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.