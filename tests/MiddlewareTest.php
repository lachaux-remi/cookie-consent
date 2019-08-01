<?php

namespace LachauxRemi\CookieConsent\Tests;


use Illuminate\Support\Facades\Cookie;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use LachauxRemi\CookieConsent\CookieConsentMiddleware;

class MiddlewareTest extends TestCase
{
    /**
     * @test
     * @return void
     * @throws Throwable
     */
    public final function itInjectsTheIfAClosingBodyTagIsFound(): void
    {
        $middleware = new CookieConsentMiddleware();
        $result = $middleware->handle(new Request(), function () {
            return (new Response())->setContent("<html lang='en'><body></body></html>");
        });
        $content = $result->getContent();
        $this->assertStringContainsString("<html lang='en'><body>", $content);
        $this->assertStringContainsString('window.cookieConsent', $content);
        $this->assertStringContainsString("</body></html>", $content);
    }

    /**
     * @test
     * @return void
     * @throws Throwable
     */
    public final function itDoesNotAlterContentThatDoesNotContainABodyTag(): void
    {
        $middleware = new CookieConsentMiddleware();
        $result = $middleware->handle(new Request(), function () {
            return (new Response())->setContent("<html lang='en'></html>");
        });
        $content = $result->getContent();
        $this->assertEquals("<html lang='en'></html>", $content);
    }

    /**
     * @test
     * @return void
     * @throws Throwable
     */
    public final function itDoesNotUseASecureCookieIfSessionSecureIsFalse(): void
    {
        config(['session.secure' => false]);
        $middleware = new CookieConsentMiddleware();
        $result = $middleware->handle(new Request(), function () {
            return (new Response())->setContent("<html lang='en'><body></body></html>");
        });
        $this->assertStringContainsString(';path=/\';', $result->getContent());
        $this->assertStringNotContainsString(';path=/;secure\';', $result->getContent());
    }

    /**
     * @test
     * @return void
     * @throws Throwable
     */
    public final function itUsesASecureCookieIfConfigSessionIsSetToSecure(): void
    {
        config(['session.secure' => true]);
        $middleware = new CookieConsentMiddleware();
        $result = $middleware->handle(new Request(), function () {
            return (new Response())->setContent("<html lang='en'><body></body></html>");
        });
        $this->assertStringNotContainsString(';path=/\';', $result->getContent());
        $this->assertStringContainsString(';path=/;secure\';', $result->getContent());
    }

    /**
     * @test
     * @return void
     * @throws Throwable
     */
    public final function theCookieSomainIsSetByTheSessionDomainConfigVariable(): void
    {
        config(['session.domain' => 'some domain']);
        $middleware = new CookieConsentMiddleware();
        $result = $middleware->handle(new Request(), function () {
            return (new Response())->setContent("<html lang='en'><body></body></html>");
        });
        $this->assertStringContainsString('const COOKIE_DOMAIN = \'some domain\'', $result->getContent());
    }

    /**
     * @test
     * @return void
     * @throws Throwable
     */
    public final function itUsesTheRequestHostUnlessSessionDomainIsSet(): void
    {
        config(['session.domain' => null]);
        $middleware = new CookieConsentMiddleware();
        $result = $middleware->handle(new Request(), function () {
            return (new Response())->setContent("<html lang='en'><body></body></html>");
        });
        $this->assertStringContainsString('const COOKIE_DOMAIN = \'localhost\'', $result->getContent());
    }

    /**
     * @test
     * @return void
     * @throws Throwable
     */
    public final function itNotInjectsTheCookieConsentWiewWhenThePackageIsDisabled(): void
    {
        config(['cookie-consent.enabled' => false]);
        $middleware = new CookieConsentMiddleware();
        $result = $middleware->handle(new Request(), function () {
            return (new Response())->setContent("<html lang='en'></html>");
        });
        $content = $result->getContent();
        $this->assertEquals("<html lang='en'></html>", $content);
    }

    /**
     * @test
     * @return void
     * @throws Throwable
     */
    public final function itNotInjectsTheCookieConsentWiewWhenNotAResponse(): void
    {
        $middleware = new CookieConsentMiddleware();
        $result = $middleware->handle(new Request(), function () {
            return "<html lang='en'></html>";
        });
        $this->assertEquals("<html lang='en'></html>", $result);
    }
}
