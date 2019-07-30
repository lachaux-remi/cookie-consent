<?php

namespace LachauxRemi\CookieConsent\Tests;

use Throwable;

/**
 * Class BaseTest
 * @package LachauxRemi\CookieConsent\Tests
 */
class BaseTests extends TestCase
{

    /**
     * @test
     * @return void
     */
    public final function itProvidesTranslations(): void
    {
        $this->assertTranslationExists('cookieConsent::cookie.message');
    }

    /**
     * @test
     * @return void
     * @throws Throwable
     */
    public final function itCanDisplayACookieConsentView(): void
    {
        $html = view('layout')->render();
        $this->assertConsentDialogDisplayed($html);
    }

    /**
     * @test
     * @return void
     * @throws Throwable
     */
    public final function itWillNotShowTheCookieConsentViewWhenThePackageIsDisabled(): void
    {
        $this->app['config']->set('cookie-consent.enabled', false);
        $html = view('layout')->render();
        $this->assertConsentDialogIsNotDisplayed($html);
    }

    /**
     * @test
     * @return void
     * @throws Throwable
     */
    public final function itWillNotShowTheCookieConsentViewWhenTheUserHasAlreadyConsented(): void
    {
        request()->cookies->set(config('cookie-consent.cookie_name'), cookie(config('cookie-consent.cookie_name'), 1));
        $html = view('layout')->render();
        $this->assertConsentDialogIsNotDisplayed($html);
    }
}
