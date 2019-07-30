<?php

namespace LachauxRemi\CookieConsent\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Support\Str;
use LachauxRemi\CookieConsent\ServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

/**
 * Class TestCase
 * @package LachauxRemi\EloquentPosition\Tests
 */
abstract class TestCase extends Orchestra
{
    /**
     * Define environment setup.
     *
     * @param Application $app
     * @return void
     */
    public final function getEnvironmentSetUp($app): void
    {
        $app['config']->set('laravel-blade-javascript.namespace', 'js');
        $app['config']->set('view.paths', [__DIR__.'/resources/views']);
    }

    /**
     * Get Positionable package providers.
     *
     * @param Application $app
     * @return array
     */
    public final function getPackageProviders($app): array
    {
        return [
            ServiceProvider::class,
            TestServiceProvider::class
        ];
    }

    /**
     * @param string $key
     * @return void
     */
    public final function assertTranslationExists(string $key): void
    {
        $this->assertTrue(trans($key) != $key, "Failed to assert that a translation exists for key `{$key}`");
    }

    /**
     * @param string $html
     * @return void
     */
    public final function assertConsentDialogDisplayed(string $html): void
    {
        $this->assertTrue($this->isConsentDialogDisplayed($html), 'Failed to assert that the consent dialog is displayed.');
    }

    /**
     * @param string $html
     * @return void
     */
    public final function assertConsentDialogIsNotDisplayed(string $html): void
    {
        $this->assertFalse($this->isConsentDialogDisplayed($html), 'Failed to assert that the consent dialog is not being displayed.');
    }

    /**
     * @param string $html
     * @return bool
     */
    public final function isConsentDialogDisplayed(string $html): bool
    {
        return Str::contains($html, [
            trans('cookieConsent::cookie.message'),
            trans('cookieConsent::cookie.button_text'),
        ]);
    }
}
