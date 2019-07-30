<?php

namespace LachauxRemi\CookieConsent;

use Illuminate\Contracts\View\View;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Class ServiceProvider
 * @package LachauxRemi\CookieConsent
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/cookie-consent.php' => config_path('cookie-consent.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/resources/views' => base_path('resources/views/vendor/cookieConsent'),
        ], 'views');

        $this->publishes([
            __DIR__.'/resources/lang' => base_path('resources/lang/vendor/cookieConsent'),
        ], 'lang');

        $this->loadTranslationsFrom(__DIR__.'/resources/lang', 'cookieConsent');
        $this->mergeConfigFrom(__DIR__.'/../config/cookie-consent.php', 'cookie-consent');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'cookieConsent');

        view()->composer('cookieConsent::index', function (View $view) {
            $cookieConsentConfig = config('cookie-consent');
            $alreadyConsentedWithCookies = Cookie::has($cookieConsentConfig['cookie_name']);
            $view->with(compact('alreadyConsentedWithCookies', 'cookieConsentConfig'));
        });
    }
}
