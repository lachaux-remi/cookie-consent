<?php

namespace LachauxRemi\CookieConsent\Tests;

use Illuminate\Http\ResponseTrait;
use Symfony\Component\HttpFoundation\Response as BaseResponse;

/**
 * Class FakeResponse
 * @package LachauxRemi\CookieConsent\Tests
 */
class FakeResponse extends BaseResponse
{
    use ResponseTrait;

    /**
     * Set the content on the response.
     *
     * @param mixed $content
     * @return $this
     */
    public final function setContent($content): FakeResponse
    {
        $this->original = $content;

        parent::setContent($content);

        return $this;
    }
}
