<?php

namespace LachauxRemi\CookieConsent\Tests;

use Illuminate\Support\ServiceProvider;

/**
 * Class TestServiceProvider
 * @package LachauxRemi\CookieConsent\Tests
 */
class TestServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
