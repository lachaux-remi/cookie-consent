# Cookie Consent
All sites owned by EU citizens or targeted towards EU citizens must comply with a crazy EU law. This law requires a dialog to be displayed to inform the users of your websites how cookies are being used. You can read more info on the legislation on [the site of the European Commission](http://ec.europa.eu/ipg/basics/legal/cookies/index_en.htm#section_2).

[![Build Status](https://travis-ci.com/lachaux-remi/cookie-consent.svg?token=uGgobxsLgjyHsLYYLyPt&branch=master)](https://travis-ci.com/lachaux-remi/cookie-consent)
[![License: MIT](https://img.shields.io/badge/License-MIT-brightgreen.svg?style=flat-square)](https://opensource.org/licenses/MIT)


* [Installation](#installation)
* [Usage](#usage)
* [Customising the dialog texts](#customising-the-dialog-texts)
* [Using the middleware](#using-the-middleware)

## Installation

**Install via composer**

```
composer require lachaux-remi/cookie-consent
```

Optionally you can publish the config-file:

```
php artisan vendor:publish --provider="LachauxRemi\CookieConsent\ServiceProvider" --tag="config"
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
     * Set the cookie duration in days.
     * The validity period of this consent is 13 months maximum.
     * Default is 30 * 13.
     */
    'cookie_lifetime' => 30 * 13,
];
```

## Usage

To display the dialog all you have to do is include this view in your template:

```php
//in your blade template
@include('cookieConsent::index')
```

Please be aware that the package provide styling for bootstrap 4.

When the user clicks "Allow cookies" a `cookie_consent` cookie will be set and the dialog will be removed from the DOM. On the next request, Laravel will notice that the `cookie_consent` has been set and will not display the dialog again

## Customising the dialog texts

If you want to modify the text shown in the dialog you can publish the lang-files with this command:

```bash
php artisan vendor:publish --provider="LachauxRemi\CookieConsent\ServiceProvider" --tag="lang"
```

This will publish this file to `resources/lang/vendor/cookieConsent/en/texts.php`.

 ```php
 
 return [
     'message' => 'Please be informed that this site uses cookies.',
     'agree' => 'Allow cookies',
 ];
 ```
 
 If you want to translate the values to, for example, French, just copy that file over to `resources/lang/vendor/cookieConsent/fr/texts.php` and fill in the French translations.
 
### Customising the dialog contents

If you need full control over the contents of the dialog. You can publish the views of the package:

```bash
php artisan vendor:publish --provider="LachauxRemi\CookieConsent\ServiceProvider" --tag="views"
```

This will copy the `index` and `dialogContents` view files over to `resources/views/vendor/cookieConsent`. You probably only want to modify the `dialogContents` view. If you need to modify the JavaScript code of this package you can do so in the `index` view file.

## Using the middleware

Instead of including `cookieConsent::index` in your view you could opt to add the `LachauxRemi\CookieConsent\CookieConsentMiddleware` to your kernel:

```php
// app/Http/Kernel.php

use LachauxRemi/CookieConsent/CookieConsentMiddleware

class Kernel extends HttpKernel
{
    protected $middleware = [
        // ...
        CookieConsentMiddleware::class,
    ];

    // ...
}
```

This will automatically add `cookieConsent::index` to the content of your response right before the closing body tag.

## Copyright and License

[cookie-consent](https://github.com/lachaux-remi/cookie-consent)
was written by [Lachaux Rémi](http://www.remi-lachaux.fr) and is released under the 
[MIT License](LICENSE.md).

Copyright (c) 2019 Lachaux Rémi