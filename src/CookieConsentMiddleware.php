<?php

namespace LachauxRemi\CookieConsent;

use Closure;
use phpDocumentor\Reflection\Types\Integer;
use Throwable;
use Illuminate\Http\Response;

/**
 * Class CookieConsentMiddleware
 * @package LachauxRemi\CookieConsent
 */
class CookieConsentMiddleware
{
    /**
     * @param $request
     * @param Closure $next
     * @return Response|mixed
     * @throws Throwable
     */
    public function handle($request, Closure $next)
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
     * @param Response $response
     * @return bool
     */
    protected function containsBodyTag(Response $response): bool
    {
        return $this->getLastClosingBodyTagPosition($response->getContent()) !== false;
    }

    /**
     * @param Response $response
     * @return Response
     * @throws Throwable
     */
    protected function addCookieConsentScriptToResponse(Response $response): Response
    {
        $content = $response->getContent();
        $closingBodyTagPosition = $this->getLastClosingBodyTagPosition($content);
        $content = ''
            .substr($content, 0, $closingBodyTagPosition)
            .view('cookieConsent::index')->render()
            .substr($content, $closingBodyTagPosition);
        return $response->setContent($content);
    }

    /**
     * @param string $content
     * @return bool|int
     */
    protected function getLastClosingBodyTagPosition(string $content = '')
    {
        return strripos($content, '</body>');
    }
}
